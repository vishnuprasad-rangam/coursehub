<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include 'db.php';

$sql = "SELECT 
            c.course_id, 
            c.title, 
            c.image_url, 
            e.status 
        FROM 
            enrollments e
        JOIN 
            courses c ON e.course_id = c.course_id
        WHERE 
            e.student_id = ?";

if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
    
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    
} else {
    $error_message = "Error fetching courses: " . mysqli_error($conn);
    $result = false;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses - CourseHub</title>    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">

    <?php include 'sidebar.php'; ?>

    <div class="container mb-5 pt-4">
        <h1 class="mb-4 fw-bold h2">My Courses</h1>

        <div class="row g-4 row-cols-1 row-cols-md-2 row-cols-lg-4" id="course-list-owned">

            <?php
            if ($result && mysqli_num_rows($result) > 0) {
                while ($course = mysqli_fetch_assoc($result)) {
                    
                    $button_text = 'Start Course';
                    $icon_class = 'bi-rocket-takeoff';
                    $action_link = 'start_course.php?course_id=' . urlencode($course['course_id']);
                    $completion_tag = '';

                    switch ($course['status']) {
                        case 'In Progress':
                            $button_text = 'Resume Learning';
                            $icon_class = 'bi-play-circle';
                            $action_link = 'resume_course.php?course_id=' . urlencode($course['course_id']);
                            $completion_tag = '<span class="badge bg-warning text-dark position-absolute top-0 end-0 mt-3 me-3">In Progress</span>';
                            break;
                        case 'Completed':
                            $button_text = 'View Certificate';
                            $icon_class = 'bi-folder2-open';
                            $action_link = 'certificate.php?course_id=' . urlencode($course['course_id']);
                            $completion_tag = '<span class="badge bg-success position-absolute top-0 end-0 mt-3 me-3">Completed</span>';
                            break;
                        case 'Not Started':
                        default:
                            $completion_tag = '<span class="badge bg-secondary position-absolute top-0 end-0 mt-3 me-3">Not Started</span>';
                            break;
                    }
            ?>
            
            <div class="col">
                <div class="card h-100 rounded-3 overflow-hidden shadow-sm bg-white position-relative">
                    
                    <div class="ratio ratio-16x9">
                        <img src="<?php echo htmlspecialchars($course['image_url']); ?>"
                            class="object-fit-cover rounded-top-3" alt="<?php echo htmlspecialchars($course['title']); ?> Thumbnail" />
                    </div>

                    <?php echo $completion_tag; ?>

                    <div class="card-body d-flex flex-column">
                        <h2 class="card-title mb-4 fs-6 text-truncate" title="<?php echo htmlspecialchars($course['title']); ?>">
                            <?php echo htmlspecialchars($course['title']); ?>
                        </h2>
                        
                        <a href="<?php echo htmlspecialchars($action_link); ?>" class="btn btn-primary w-100 mt-auto rounded-pill mb-2">
                            <i class="bi <?php echo htmlspecialchars($icon_class); ?> me-1"></i> <?php echo htmlspecialchars($button_text); ?>
                        </a>
                    </div>
                </div>
            </div>

            <?php
                }
                mysqli_free_result($result);

            } else {
                echo '<div class="col-12"><p class="text-muted">You are not currently enrolled in any courses.</p></div>';
            }

            if (isset($stmt)) {
                mysqli_stmt_close($stmt);
            }
            ?>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
</body>

</html>