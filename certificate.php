<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include 'db.php';

$course_id = isset($_GET['course_id']) && is_numeric($_GET['course_id']) ? (int)$_GET['course_id'] : 0;
$student_id = $_SESSION['user_id'];

$sql = "SELECT 
            s.first_name, 
            s.last_name, 
            c.title AS course_title,
            e.completion_date
        FROM enrollments e
        JOIN students s ON e.student_id = s.student_id
        JOIN courses c ON e.course_id = c.course_id
        WHERE e.student_id = ? AND e.course_id = ? AND e.status = 'Completed'";

$certificate_data = null;

if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "ii", $student_id, $course_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($result && mysqli_num_rows($result) === 1) {
        $certificate_data = mysqli_fetch_assoc($result);
    }
    
    mysqli_stmt_close($stmt);
}

if (!$certificate_data) {
    header('Location: my-courses.php');
    exit;
}

$student_name = htmlspecialchars($certificate_data['first_name'] . ' ' . $certificate_data['last_name']);
$course_title = htmlspecialchars($certificate_data['course_title']);
$completion_date = date("F j, Y", strtotime($certificate_data['completion_date']));

$verification_string = $student_id . '|' . $course_id . '|' . $certificate_data['completion_date'];
$verification_code = strtoupper(substr(hash('sha256', $verification_string), 0, 16));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Completion - CourseHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&family=Merriweather:ital,wght@0,300;0,700;0,900;1,300&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --cert-primary: #0f172a;
            --cert-accent: #2563eb;
            --cert-gold: #d97706;
            --cert-text: #334155;
            --cert-bg: #ffffff;
            

            --space-xs: 5mm;
            --space-sm: 8mm;
            --space-md: 13mm;
            --space-lg: 21mm;
            --space-xl: 34mm;
        }

        body {
            background-color: #e2e8f0;
            font-family: 'Inter', sans-serif;
        }

        /* A4 Landscape Container */
        .certificate-wrapper {
            width: 297mm;
            height: 210mm;
            margin: 0 auto;
            background-color: var(--cert-bg);
            position: relative;
            box-shadow: 0 20px 50px rgba(0,0,0,0.1);
            display: flex;
            overflow: hidden;
        }

        /* Sidebar */
        .cert-sidebar {
            width: 80.2mm;
            height: 100%;
            background: var(--cert-primary);
            color: white;
            padding: var(--space-lg) var(--space-md);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        /* Geometric Pattern */
        .cert-sidebar::before {
            content: '';
            position: absolute;
            top: -50px;
            left: -50px;
            width: 200px;
            height: 200px;
            border: 21px solid rgba(255,255,255,0.05);
            border-radius: 50%;
        }
        .cert-sidebar::after {
            content: '';
            position: absolute;
            bottom: 50px;
            right: -50px;
            width: 144px;
            height: 144px;
            border: 13px solid rgba(255,255,255,0.05);
            border-radius: 50%;
        }

        .logo-area {
            font-size: 21pt;
            font-weight: 800;
            letter-spacing: -1px;
            display: flex;
            align-items: center;
            gap: 8px;
            z-index: 1;
        }

        .logo-area img {
            filter: invert(1);
        }

        .sidebar-content {
            z-index: 1;
        }

        .sidebar-label {
            text-transform: uppercase;
            font-size: 8pt;
            letter-spacing: 2px;
            opacity: 0.7;
            margin-bottom: 5px;
        }

        .sidebar-value {
            font-size: 11pt;
            font-weight: 600;
            margin-bottom: var(--space-md);
        }

        .verification-badge {
            border: 1px solid rgba(255,255,255,0.2);
            padding: 13px;
            border-radius: 8px;
            background: rgba(255,255,255,0.05);
        }

        .qr-placeholder {
            width: 34px;
            height: 34px;
            background: white;
            margin-bottom: 8px;
            border-radius: 3px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--cert-primary);
            font-size: 18px;
        }

        /* Main Content Area */
        .cert-main {
            flex: 1;
            padding: var(--space-lg); /* 21mm */
            display: flex;
            flex-direction: column;
            position: relative;
        }

        /* Watermark */
        .cert-main::before {
            content: 'COURSEHUB';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 89pt;
            font-weight: 900;
            color: rgba(0,0,0,0.02);
            white-space: nowrap;
            pointer-events: none;
            z-index: 0;
        }

        .header-section {
            margin-bottom: var(--space-md);
            z-index: 1;
        }

        .cert-type {
            font-size: 13pt;
            font-weight: 600;
            color: var(--cert-accent);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 5px;
        }

        .cert-headline {
            font-size: 26pt;
            font-weight: 800;
            color: var(--cert-primary);
            line-height: 1.1;
        }

        .student-section {
            margin-bottom: var(--space-lg);
            z-index: 1;
        }

        .presented-to {
            font-size: 10pt; /* Base Unit */
            color: #64748b;
            margin-bottom: var(--space-sm);
        }

        .student-name {
            font-family: 'Merriweather', serif;
            font-size: 42pt;
            font-weight: 700;
            color: var(--cert-primary);
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: var(--space-sm);
            display: inline-block;
            min-width: 80%;
        }

        .course-section {
            margin-bottom: auto;
            z-index: 1;
        }

        .completion-text {
            font-size: 10pt;
            color: #64748b;
            margin-bottom: var(--space-xs);
        }

        .course-title {
            font-size: 16pt;
            font-weight: 600;
            color: var(--cert-text);
        }

        .footer-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            z-index: 1;
            margin-top: var(--space-lg);
        }

        .signature-block {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .sign-img {
            font-family: 'Merriweather', serif;
            font-style: italic;
            font-size: 21pt;
            color: var(--cert-primary);
            margin-bottom: 5px;
        }

        .sign-line {
            width: 55mm;
            height: 1px;
            background: #cbd5e1;
        }

        .sign-title {
            font-size: 8pt;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
        }



        /* Print Settings */
        @page {
            size: A4 landscape;
            margin: 0;
        }

        @media print {
            html, body {
                width: 297mm;
                height: 210mm;
                margin: 0;
                padding: 0;
                background: #fff;
            }

            .no-print {
                display: none !important;
            }

            .container {
                width: 100% !important;
                max-width: none !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .certificate-wrapper {
                box-shadow: none;
                margin: 0;
                page-break-after: always;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>

    <div class="no-print">
        <?php include 'sidebar.php'; ?>
    </div>

    <div class="container pt-4 mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4 no-print" style="max-width: 297mm; margin: 0 auto;">
            <h1 class="mb-0 fw-bold h2">View Certificate</h1>
            <button onclick="window.print();" class="btn btn-primary rounded-pill">
                <i class="bi bi-printer-fill me-2"></i>Print Certificate
            </button>
        </div>

        <!-- Certificate Wrapper -->
        <div class="certificate-wrapper">
            
            <!-- Left Sidebar -->
            <div class="cert-sidebar">
                <div class="logo-area">
                    <img src="assets/brand/coursehub-logo.svg" alt="CourseHub Logo" width="32" height="32" /> CourseHub
                </div>

                <div class="sidebar-content">
                    <div class="sidebar-label">Issued On</div>
                    <div class="sidebar-value"><?php echo $completion_date; ?></div>

                    <div class="sidebar-label">Certificate ID</div>
                    <div class="sidebar-value" style="font-family: monospace; font-size: 10pt;"><?php echo $verification_code; ?></div>

                    <div class="verification-badge">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&format=svg&color=ffffff&bgcolor=0f172a&data=verified" 
                             alt="Verification QR Code" 
                             style="width: 100px; height: 100px; margin-bottom: 8px; border-radius: 3px;">
                        <div style="font-size: 8pt; opacity: 0.8;">
                            Scan to verify authenticity
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="cert-main">
                <div class="header-section">
                    <div class="cert-headline">Certificate of<br>Completion</div>
                </div>

                <div class="student-section">
                    <div class="presented-to">This is to certify that</div>
                    <div class="student-name"><?php echo $student_name; ?></div>
                </div>

                <div class="course-section">
                    <div class="completion-text">Has successfully completed the course requirements for</div>
                    <div class="course-title"><?php echo $course_title; ?></div>
                </div>

                <div class="footer-section">
                    <div class="signature-block">
                        <div class="sign-img">CourseHub Authority</div>
                        <div class="sign-line"></div>
                        <div class="sign-title">Academic Director</div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
</body>
<?php mysqli_close($conn); ?>
</html>