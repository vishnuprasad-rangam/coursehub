<?php
session_start();

include 'db.php';

$sql = "SELECT 
            c.course_id, 
            c.title, 
            c.description, 
            c.duration_weeks, 
            c.original_price, 
            c.sale_price, 
            c.image_url, 
            i.name AS instructor_name
        FROM 
            courses c
        JOIN 
            instructors i ON c.instructor_id = i.instructor_id
        ORDER BY 
            c.created_at DESC";

if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $courses = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_free_result($result);
    mysqli_stmt_close($stmt);

} else {
    $error_message = "Error fetching courses: " . mysqli_error($conn);
    $courses = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Catalogue</title>    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">

    <?php include 'sidebar.php'; ?> 

    <div class="container mb-5 pt-4">
        <h1 class="mb-4 fw-bold h2">Course Catalogue</h1>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <div class="row g-4 row-cols-1 row-cols-md-2 row-cols-lg-4" id="course-list">
            
            <?php 
            if (empty($courses)): ?>
                <div class="col-12 text-center">
                    <p class="lead">No courses are currently available in the catalogue.</p>
                </div>
            <?php 
            else: 
                foreach ($courses as $course): ?>
                <div class="col">
                    <div class="card h-100 rounded-3 overflow-hidden shadow-sm bg-white">
                        
                        <div class="ratio ratio-16x9">
                            <img src="<?php echo htmlspecialchars($course['image_url']); ?>"
                                class="object-fit-cover rounded-top-3" alt="<?php echo htmlspecialchars($course['title']); ?> Image" />
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h2 class="card-title mb-2 fs-5 text-truncate" title="<?php echo htmlspecialchars($course['title']); ?>">
                                <?php echo htmlspecialchars($course['title']); ?>
                            </h2>

                            <p class="card-text flex-grow-1 mb-2 fs-6 text-truncate" title="<?php echo htmlspecialchars($course['description']); ?>">
                                <?php echo htmlspecialchars($course['description']); ?>
                            </p>

                            <div class="d-flex flex-column gap-2 mb-4">
                                <dl class="d-flex mb-0">
                                    <dt class="me-2 fw-normal">Instructor:</dt>
                                    <dd class="mb-0 fw-semibold"><?php echo htmlspecialchars($course['instructor_name']); ?></dd>
                                </dl>
                                <dl class="d-flex mb-0">
                                    <dt class="me-2 fw-normal">Duration:</dt>
                                    <dd class="mb-0 fw-semibold"><?php echo htmlspecialchars($course['duration_weeks']); ?> Weeks</dd>
                                </dl>

                                <div>
                                    Price: 
                                    <?php 
                                        $sale_price = $course['sale_price'];
                                        $original_price = $course['original_price'];

                                        if (!is_null($sale_price) && $sale_price < $original_price) {
                                            echo '<del class="me-2">₹' . number_format($original_price, 2) . '</del>';
                                            echo '<span class="fs-6 text-dark fw-bold">₹' . number_format($sale_price, 2) . '</span>';
                                        } else {
                                            echo '<span class="fs-6 text-dark">₹' . number_format($original_price, 2) . '</span>';
                                        }
                                    ?>
                                </div>
                            </div>

                            <a href="checkout.php?course_id=<?php echo $course['course_id']; ?>" 
                                class="btn btn-primary w-100 mt-auto rounded-pill mb-2">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            <?php 
                endforeach; 
            endif;
            ?>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
</body>

</html>