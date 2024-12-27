<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Nirbhay</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="IT Company Website Template" name="keywords">
    <meta content="IT Company Website Template" name="description">

    <!-- Favicon -->
    <link href="img/fevicon.png" rel="icon">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:200,300,400,500,600,700,800,900&display=swap" rel="stylesheet"> 

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Libraries CSS -->
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Main Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

</head>

<body>

<?php
// Start the session if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
    
    <!-- Nav Start -->
    <div id="nav">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-md bg-dark navbar-dark">
                <a href="index.php" class="navbar-brand">
                    <img src="img/logo.png" alt="Logo">
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav ml-auto">
                        <a href="index.php" class="nav-item nav-link">Home</a>
                        <a href="about.php" class="nav-item nav-link">About-Nirbhay</a>
                        <a href="simulator.php" class="nav-item nav-link">Simulator</a>
                        <a href="tools.php" class="nav-item nav-link">Tools</a>
                        <a href="team.php" class="nav-item nav-link">Team</a>
                        <a href="casestudy.php" class="nav-item nav-link">Case Studies</a>
                        <a href="forum.php" class="nav-item nav-link">Forum</a>


                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Info Blog</a>
                            <div class="dropdown-menu">
                                <a href="types.php" class="dropdown-item">Types of Cyber Crime</a>
                                <a href="helpcenter.php" class="dropdown-item">Cyber Help Centers</a>
                                <a href="password.php" class="dropdown-item">All About Password</a>
                                <a href="fakenews.php" class="dropdown-item">Identify Fake News</a>
                            </div>
                        </div>
                        <a href="contact.php" class="nav-item nav-link">Contact</a>
                        
                        <!-- Check if user is logged in -->
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a href="Account.php" class="nav-item nav-link" title="Profile" style="background-color: initial; color: initial;    margin-top: -7px;">
    <i class="fa-solid fa-user"
       style="color: #fafcff; background-color: transparent; padding: 10px; border-radius: 50%;"
       onmouseover="this.style.backgroundColor='white'; this.style.color='#343a40';"
       onmouseout="this.style.backgroundColor='transparent'; this.style.color='#fafcff';">
    </i>
</a>


<a href="logout.php" class="nav-item nav-link" title="Logout" style="background-color: initial; color: initial; margin-top: -7px;">
    <i class="fa-solid fa-sign-out-alt" style="color: #fafcff; background-color: transparent; padding: 10px; border-radius: 50%;"
       onmouseover="this.style.backgroundColor='white'; this.style.color='#343a40';"
       onmouseout="this.style.backgroundColor='transparent'; this.style.color='#fafcff';">
    </i>
</a>


                           
                        <?php else: ?>
                            <a href="login.php" class="nav-item nav-link" title="Login">
                                <i class="fa-solid fa-sign-in-alt" style="color: #fafcff; margin-right:20px;"></i>
                            </a>
                         
                        <?php endif; ?>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Nav End -->

    <!-- Back to Top -->
    <a href="#" class="back-to-top"><i class="ion-ios-arrow-up"></i></a>

    <!-- Libraries JS -->
    <script src="lib/jquery/jquery.min.js"></script>
    <script src="lib/jquery/jquery-migrate.min.js"></script>
    <script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>

    <!-- Main Javascript -->
    <script src="js/main.js"></script>

</body>
</html>
