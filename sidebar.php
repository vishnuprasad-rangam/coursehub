<?php
/* Note: The sidebar is excluded from pages intended for unauthenticated users (e.g., Login, Signup, and the main landing page). */
$current_page = basename($_SERVER['SCRIPT_NAME']);
?>
<header class="navbar navbar-expand-md navbar-light bg-white sticky-top shadow-sm border-bottom">
    <div class="container-fluid px-4 px-md-5">
        <button class="navbar-toggler border-0 me-3 d-md-none" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <a class="navbar-brand fs-4 fw-bold text-primary" href="my-courses.php">
            CourseHub
        </a>
        
        <nav class="d-none d-md-flex align-items-center me-auto ms-5" aria-label="Main navigation">
            <ul class="nav">
                <li class="nav-item">
                    <a href="my-courses.php" 
                       class="nav-link rounded-3 py-2 fw-semibold px-4 <?php echo ($current_page === 'my-courses.php') ? 'text-primary' : 'text-dark'; ?>" 
                       <?php if ($current_page === 'my-courses.php') echo 'aria-current="page"'; ?>>
                        <i class="bi bi-book me-2"></i> My Courses
                    </a>
                </li>
                <li class="nav-item">
                    <a href="catalogue.php" 
                       class="nav-link rounded-3 py-2 fw-semibold px-4 <?php echo ($current_page === 'catalogue.php') ? 'text-primary' : 'text-dark'; ?>"
                       <?php if ($current_page === 'catalogue.php') echo 'aria-current="page"'; ?>>
                        <i class="bi bi-search me-2"></i> Course Catalogue
                    </a>
                </li>
            </ul>
        </nav>

        <div class="d-md-none me-auto"></div>

        <?php if (isset($_SESSION['user_id'])): ?>
            <?php
                $user_first_name = htmlspecialchars($_SESSION['first_name']);
                $user_last_name = isset($_SESSION['last_name']) ? htmlspecialchars($_SESSION['last_name']) : '';
                $user_email = htmlspecialchars($_SESSION['email']);
                $user_full_name = trim($user_first_name . ' ' . $user_last_name);

                $user_initials = strtoupper(substr($user_first_name, 0, 1));
            ?>
            <div class="d-flex align-items-center">            
                <div class="dropdown">
                    <button class="btn p-0 border-0" type="button" id="profileDropdownToggle" data-bs-toggle="dropdown" aria-expanded="false" aria-label="User Profile Menu">
                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white fw-semibold shadow-sm" style="width: 44px; height: 44px;">
                            <?php echo $user_initials; ?>
                        </div>
                    </button>
                    
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4" aria-labelledby="profileDropdownToggle">
                        <li class="px-4 pt-2 pb-1">
                            <p class="fw-bold mb-0"><?php echo $user_full_name; ?></p>
                            <small class="text-muted"><?php echo $user_email; ?></small>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="logout.php">
                                <i class="bi bi-box-arrow-right me-2"></i> Sign Out
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        <?php else: ?>
            <div class="d-flex align-items-center gap-2">
                <a href="login.php" class="btn btn-outline-primary rounded-pill px-4">Sign In</a>
                <a href="signup.php" class="btn btn-primary rounded-pill px-4">Sign Up</a>
            </div>
        <?php endif; ?>
    </div>
</header>

<div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="offcanvasSidebar" aria-labelledby="offcanvasSidebarLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title text-primary fw-bold" id="offcanvasSidebarLabel">CourseHub</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <nav class="offcanvas-body p-3" id="offcanvas-menu-container" aria-label="Mobile navigation">
        
        <ul class="nav flex-column mb-3">
            <li class="nav-item">
                <a href="my-courses.php" 
                   class="nav-link rounded-3 py-2 fw-semibold <?php echo ($current_page === 'my-courses.php') ? 'text-primary' : 'text-dark'; ?>" 
                   <?php if ($current_page === 'my-courses.php') echo 'aria-current="page"'; ?>>
                    <i class="bi bi-book me-3 fs-5"></i> My Courses
                </a>
            </li>
            <li class="nav-item">
                <a href="catalogue.php" 
                   class="nav-link rounded-3 py-2 fw-semibold <?php echo ($current_page === 'catalogue.php') ? 'text-primary' : 'text-dark'; ?>"
                   <?php if ($current_page === 'catalogue.php') echo 'aria-current="page"'; ?>>
                    <i class="bi bi-search me-3 fs-5"></i> Course Catalogue
                </a>
            </li>
        </ul>
    </nav>
</div>