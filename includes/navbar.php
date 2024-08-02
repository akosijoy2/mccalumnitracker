<nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <a href="index.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
        <h2 class="m-0 text-primary"><i class="fa fa-graduation-cap me-3"></i>MCC ALUMNI</h2>
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">

        <?php
        if (isset($_SESSION['alumni'])) {
            echo '
    <div class="navbar-nav ms-auto p-4 p-lg-0">
    
        <a href="../logout.php" class="nav-item nav-link">LOGOUT</a>
    </div>
    ';
        } else {
            echo '
    <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="index.php" class="nav-item nav-link active">Home</a>
            <a href="404.php" class="nav-item nav-link">About</a>
            <a href="404.php" class="nav-item nav-link">Courses</a>
           

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                <div class="dropdown-menu fade-down m-0">
                    <a href="404.php" class="dropdown-item">In Memoriam</a>
                    <a href="404.php" class="dropdown-item">Testimonial</a>
                </div>
            </div>

            <a href="404.php" class="nav-item nav-link">Gallery</a>
            <a href="404.php" class="nav-item nav-link">Contact</a>
          
    ';
        }
        ?>

    </div>

    </div>
</nav>