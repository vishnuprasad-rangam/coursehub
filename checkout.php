<?php
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require_once 'db.php';

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['course_id']) || !is_numeric($_GET['course_id'])) {
    header('Location: catalogue.php'); 
    exit();
}

$course_id = (int)$_GET['course_id'];
$logged_in_userid = $_SESSION['user_id'];
$gst_rate = 0.18;

/**
 * Fetches the course details and instructor information.
 */
function get_course_details($conn, $course_id) {
    $sql = "
        SELECT 
            c.title, c.description, c.original_price, c.sale_price, c.image_url,
            i.name AS instructor_name, i.bio_summary AS instructor_bio
        FROM 
            courses c
        JOIN 
            instructors i ON c.instructor_id = i.instructor_id
        WHERE 
            c.course_id = ?
    ";
    
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $course_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $course = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        return $course;
    }
    return null;
}

/**
 * Fetches course section and topic details from the database.
 */
function get_course_topics($conn, $course_id) {
    $sql = "
        SELECT 
            cs.section_title, 
            st.topic_name
        FROM 
            course_sections cs
        JOIN 
            section_topics st ON cs.section_id = st.section_id
        WHERE 
            cs.course_id = ?
        ORDER BY 
            cs.section_order, st.topic_order
    ";
    
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return [];
    }

    mysqli_stmt_bind_param($stmt, "i", $course_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $sections = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $sections[$row['section_title']]['topics'][] = $row['topic_name'];
        }
    }
    mysqli_stmt_close($stmt);

    $output = [];
    foreach ($sections as $title => $data) {
        $output[] = ['section_title' => $title, 'topics' => $data['topics']];
    }
    return $output;
}

$course_data = get_course_details($conn, $course_id);

if (!$course_data) {
    header('Location: catalogue.php'); 
    exit();
}

$original_price = (float)$course_data['original_price'];
$sale_price = (float)$course_data['sale_price'];

$subtotal = $sale_price > 0 ? $sale_price : $original_price;
$discount = $sale_price > 0 ? $original_price - $sale_price : 0;

$gst_amount = $subtotal * $gst_rate;
$total_payable = $subtotal + $gst_amount;
$half_gst = $gst_amount / 2;

$display_subtotal = '₹' . number_format($subtotal, 2);
$display_discount = '₹' . number_format($discount, 2);
$display_original = '₹' . number_format($original_price, 2);
$display_gst = '₹' . number_format($gst_amount, 2);
$display_half_gst = '₹' . number_format($half_gst, 2);
$display_total = '₹' . number_format($total_payable, 2);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('CSRF token validation failed.');
    }

    header('Location: order_success.php'); 
    exit();
}

$topics = get_course_topics($conn, $course_id);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Checkout | <?php echo htmlspecialchars($course_data['title']); ?></title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    />
    <style>
      @media (min-width: 992px) {
        .sticky-sidebar {
          position: -webkit-sticky;
          position: sticky;
          top: 2rem;
          align-self: flex-start;
        }
      }
    </style>
  </head>
  <body class="bg-light lh-base">
    <?php include 'sidebar.php'; ?>
    <div class="container mb-5 pt-4">
      <main>
        <div class="row g-4">
          
          <div class="col-lg-7">
            <div class="card shadow-sm border-0 rounded-3">
              <div>
                <?php
                    $placeholder_text = urlencode(str_replace(' ', '+', $course_data['title']));
                    $image_url = $course_data['image_url'] ? $course_data['image_url'] : "https://placehold.co/640x360/563d7c/FFFFFF?text={$placeholder_text}";
                ?>
                <img
                  src="<?php echo htmlspecialchars($image_url); ?>"
                  alt="<?php echo htmlspecialchars($course_data['title']); ?> Thumbnail"
                  class="img-fluid rounded-top-3"
                />
              </div>
              <div class="card-body p-4 p-md-5">
                <div>
                  <h1 class="h3 card-title fw-bold">
                    <?php echo htmlspecialchars($course_data['title']); ?>
                  </h1>
                  <p class="card-text text-body-secondary fs-6 mb-4">
                    <?php echo htmlspecialchars($course_data['description']); ?>
                  </p>
                </div>
                
                <div class="mb-4">
                  <h2 class="h5 fw-semibold mb-3">Key Features</h2>
                  <div class="d-flex flex-wrap gap-2">
                    <span
                      class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill px-3 py-2"
                    >
                      Lifetime Access
                    </span>
                    <span
                      class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill px-3 py-2"
                    >
                      Certificate
                    </span>
                    <span
                      class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill px-3 py-2"
                    >
                      Live Projects
                    </span>
                    <span
                      class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill px-3 py-2"
                    >
                      Resources
                    </span>
                  </div>
                </div>
                
                <div class="mb-4">
                    <h2 class="h5 fw-semibold mb-3">Your Instructor</h2>
                    <div class="d-flex gap-3 align-items-center p-3 rounded-3 border">
                        <img 
                            src="https://placehold.co/60x60/343a40/FFFFFF?text=<?php echo substr(htmlspecialchars($course_data['instructor_name']), 0, 1); ?>" 
                            alt="Instructor Profile" 
                            class="rounded-circle" 
                            width="60" 
                            height="60"
                        />
                        <div>
                            <p class="mb-0 fw-bold"><?php echo htmlspecialchars($course_data['instructor_name']); ?></p>
                            <small class="text-body-secondary"><?php echo htmlspecialchars($course_data['instructor_bio']); ?></small>
                        </div>
                    </div>
                </div>

                <div>
                  <h2 class="h5 fw-semibold mb-3">Topics Covered</h2>
                  <div class="accordion" id="topicsAccordion">
                    <?php 
                    $i = 0;
                    foreach ($topics as $section):
                        $i++;
                        $id_suffix = 'c' . $i; 
                    ?>
                    <div class="accordion-item">
                      <h3 class="accordion-header" id="heading<?php echo $id_suffix; ?>">
                        <button
                          class="accordion-button collapsed fw-medium shadow-none py-2"
                          type="button"
                          data-bs-toggle="collapse"
                          data-bs-target="#collapse<?php echo $id_suffix; ?>"
                          aria-expanded="false"
                          aria-controls="collapse<?php echo $id_suffix; ?>"
                        >
                          <?php echo htmlspecialchars($section['section_title']); ?>
                        </button>
                      </h3>
                      <div
                        id="collapse<?php echo $id_suffix; ?>"
                        class="accordion-collapse collapse"
                        aria-labelledby="heading<?php echo $id_suffix; ?>"
                        data-bs-parent="#topicsAccordion"
                      >
                        <div class="accordion-body text-body-secondary px-0">
                          <ul class="list-unstyled mb-0 d-grid gap-2 ps-3">
                            <?php foreach ($section['topics'] as $topic): ?>
                            <li class="d-flex align-items-center gap-2">
                              <i class="bi bi-check-circle text-primary"></i>
                              <?php echo htmlspecialchars($topic); ?>
                            </li>
                            <?php endforeach; ?>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>

          
          <div class="col-lg-5 sticky-sidebar">
            <form method="POST" action="checkout.php?course_id=<?php echo $course_id; ?>" id="checkoutForm">
              <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
              <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4 p-md-5">                  
                  <h2 class="h4 card-title fw-bold mb-4">Payment Summary</h2>

                  <div class="d-grid gap-2 mb-3">
                    <div class="d-flex justify-content-between text-body-secondary">
                      <span>Original Price</span>
                      <span class="fw-medium text-decoration-line-through"><?php echo $display_original; ?></span>
                    </div>
                    <?php if ($discount > 0): ?>
                    <div class="d-flex justify-content-between text-success">
                      <span>Discount / Sale Price</span>
                      <span class="fw-medium">-<?php echo $display_discount; ?></span>
                    </div>
                    <?php endif; ?>
                  </div>

                  <div
                    class="d-flex justify-content-between fw-semibold mb-3 pt-3 border-top"
                  >
                    <span>Taxable Value (Subtotal)</span>
                    <span><?php echo $display_subtotal; ?></span>
                  </div>

                  <div class="mb-3 pb-3 border-bottom">
                    <div class="d-flex justify-content-between">
                      <button
                        class="btn btn-link p-0 border-0 text-decoration-none text-body-secondary fw-medium"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#taxDetailsCollapse"
                        aria-expanded="false"
                        aria-controls="taxDetailsCollapse"
                      >
                        Total GST (<?php echo ($gst_rate * 100); ?>%)
                        <i class="bi bi-chevron-down small"></i>
                      </button>
                      <span class="fw-semibold"><?php echo $display_gst; ?></span>
                    </div>
                    <div class="collapse" id="taxDetailsCollapse">
                      <div class="mt-2">
                        <div class="d-grid gap-1 ps-3">
                          <small
                            class="d-flex justify-content-between text-body-secondary"
                          >
                            <span>CGST @ <?php echo ($gst_rate * 100 / 2); ?>%</span>
                            <span><?php echo $display_half_gst; ?></span>
                          </small>
                          <small
                            class="d-flex justify-content-between text-body-secondary"
                          >
                            <span>SGST @ <?php echo ($gst_rate * 100 / 2); ?>%</span>
                            <span><?php echo $display_half_gst; ?></span>
                          </small>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="d-flex justify-content-between h5 fw-bold mb-4">
                    <span>Total Payable:</span>
                    <span><?php echo $display_total; ?></span>
                  </div>

                  <div class="d-grid gap-3 mb-4">
                    <div class="form-check">
                      <input
                        class="form-check-input"
                        type="checkbox"
                        id="agreeTerms"
                        required
                      />
                      <label class="form-check-label small" for="agreeTerms">
                        I have read and agree to the
                        <a href="index.php" class="fw-medium text-decoration-none"
                          >Terms & Conditions</a
                        >,
                        <a href="index.php" class="fw-medium text-decoration-none"
                          >Privacy Policy</a
                        >, and
                        <a href="index.php" class="fw-medium text-decoration-none"
                          >Refund Policy</a
                        >
                      </label>
                    </div>
                    <div class="form-check">
                      <input
                        class="form-check-input"
                        type="checkbox"
                        id="agreeData"
                        required
                      />
                      <label class="form-check-label small" for="agreeData">
                        I consent to data processing as per
                        <strong class="fw-semibold">DPDP Act, 2023</strong>
                      </label>
                    </div>
                  </div>
                  
                  <div class="d-grid">
                    <button
                      type="submit"
                      class="btn btn-primary w-100 rounded-pill py-3 fw-bold"
                    >
                      Proceed to Secure Payment Gateway
                    </button>
                  </div>

                  <div class="text-center mt-4">
                    <small class="text-body-secondary">
                      Powered by <strong>MSTech</strong> - 100% Secure
                    </small>
                    <div
                      class="d-flex gap-2 justify-content-center align-items-center mt-2"
                    >
                      <i
                        class="bi bi-credit-card-fill fs-5 text-muted"
                        title="Cards"
                      ></i>
                      <i
                        class="bi bi-bank fs-5 text-muted"
                        title="Net Banking"
                      ></i>
                      <img
                        src="https://www.vectorlogo.zone/logos/upi/upi-icon.svg"
                        alt="UPI"
                        title="UPI"
                        height="20"
                      />
                      <i
                        class="bi bi-wallet-fill fs-5 text-muted"
                        title="Wallets"
                      ></i>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </main>
    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      crossorigin="anonymous"
    ></script>
  </body>
</html>