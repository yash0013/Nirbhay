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

        <!-- Libraries CSS -->
        <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
        <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
        <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

        <!-- Main Stylesheet -->
        <link href="css/style.css" rel="stylesheet">
    </head>

    <body>
    <?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page
    header("Location: login.php");
    exit();
}
?>


    <?php include_once("header.php"); ?> 
     <!-- Loader -->
     <div class="loader-wrapper" id="loaderWrapper">
        <div class="loader"></div>
    </div>


        <!-- Header Start-->
        <div class="header">
            <div id="header-slider" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ul class="carousel-indicators">
                    <li data-target="#header-slider" data-slide-to="0" class="active"></li>
                    <li data-target="#header-slider" data-slide-to="1"></li>
                    <li data-target="#header-slider" data-slide-to="2"></li>
                </ul>

                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="carousel-content">
                                    <h2>Welcome to Nirbhay</h2>
                                    <p>"Welcome to Nirbhay, where 'Nirbhay raho..!' is our mantra..!
                                        your ultimate destination for online safety.Together, let's make the digital world a safer place..!"</p>
                                    <a class="btn" href="simulator.html">Simulator</a>
                                </div>
                            </div>  
                            <div class="col-md-6">
                                <div class="carousel-img">
                                    <img src="img/slider2.png" alt="Image">
                                </div>
                            </div>
                        </div>   
                    </div>
                    <div class="carousel-item">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="carousel-content">
                                    <h2>Case Studies</h2>
                                    <p>: Real-life cyber stories unfold, showing how ordinary folks become cyber champs, turning tech troubles into triumphs!</p>
                                    <a class="btn" href="">Read More</a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="carousel-img">
                                    <img src="img/slider3.png" alt="Image">
                                </div>
                            </div>
                        </div>   
                    </div>
                    <div class="carousel-item">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="carousel-content">
                                    <h2>types of Cyber crime</h2>
                                    <p>Unveil the dark side of the digital realm with our enlightening guide, where understanding cyber perils feels more like cracking a mystery than fearing the unknown!</p>
                                    <a class="btn" href="types.html">Read More</a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="carousel-img">
                                    <img src="img/slider1.png" alt="Images">
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>

                <a class="carousel-control-prev" href="#header-slider" data-slide="prev">
                    <i class="ion-ios-arrow-back"></i>
                </a>
                <a class="carousel-control-next" href="#header-slider" data-slide="next">
                    <i class="ion-ios-arrow-forward"></i>
                </a>
            </div>
        </div>
        <!-- Header End-->


        <!-- About Start-->
        <div class="about">
            <div class="container">
                <div class="section-header">
                    <h2>About Us</h2>
                </div>
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="about-img">
                            <img src="img/cover.jpg" alt="" class="img-fluid">
                        </div>
                        <div class="about-content">
                            <h2>Welcome to Nirbhay</h2>
                            <p>
                                Nirbhay is more than just a cybersecurity platform; it's a digital sanctuary where individuals and small businesses in India can equip themselves with the knowledge and skills needed to navigate the online world securely. Our mission is rooted in the belief that everyone deserves to feel empowered and confident in their digital interactions.
                            </p>
                            <a class="btn" href="about.html">Read More</a>
                        </div>
                    </div>
                </div>

            
            </div>
        </div>
        <!-- About End -->

        

        <!-- Call To Action Start -->
        <!-- Call To Action Start -->
<div style="width: 100%; padding: 60px 0; background: linear-gradient(to right, #141E30, #243B55); display: flex; justify-content: center; align-items: center;">
    <div style="text-align: center; color: white;">
        <h2 style="font-size: 2.5em; font-weight: bold; margin-bottom: 20px;">Nirbhay Simulator Prototype:</h2>
        <p style="font-size: 1.2em; color: #b0c4de; max-width: 600px; margin: 0 auto 30px; line-height: 1.6;">
            Dive into a virtual realm of cyber challenges, where learning to outsmart digital threats feels like a game, empowering you to become the ultimate cyber-savvy hero!
        </p>
        <a href="simulator.php" style="padding: 15px 40px; background-color: #00C9FF; background-image: linear-gradient(45deg, #00C9FF, #92FE9D); color: #141E30; font-size: 1.2em; font-weight: bold; text-transform: uppercase; text-decoration: none; border-radius: 50px; box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1); transition: all 0.3s ease;">
            Try Now
        </a>
    </div>
</div>
<!-- Call To Action End -->

        <!-- Call To Action End -->

                <!-- Call To Action Start -->
                <section style="width: 100%; height: 100vh; background: linear-gradient(to right, #141E30, #243B55); display: flex; align-items: center; justify-content: center; padding: 0 20px;">
    <div style="text-align: center; color: white;">
        <h1 style="font-size: 3.5em; font-weight: bold; margin-bottom: 20px; line-height: 1.2;">Step into the Nirbhay Cyber Security Forum</h1>
        <p style="font-size: 1.3em; color: #b0c4de; margin: 0 auto 30px; max-width: 700px; line-height: 1.6;">
            Meet experts, engage in discussions, and stay up-to-date with the latest in cybersecurity. Your knowledge hub awaits.
        </p>
        <a href="forum.php" style="padding: 15px 40px; background-color: #00C9FF; background-image: linear-gradient(45deg, #00C9FF, #92FE9D); color: #141E30; font-size: 1.2em; font-weight: bold; text-transform: uppercase; text-decoration: none; border-radius: 50px; box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1); transition: all 0.3s ease;">
            Join the Forum
        </a>
    </div>
</section>

        <!-- Call To Action End -->


        

        <!-- Testimonials Start -->
        <div class="testimonials">
            <div class="container">
                <div class="section-header">
                    <h2>Reviews</h2>
                    <p>
                        Reviews from Our Cyber-Savvy Community                    </p>
                </div>

                <div class="owl-carousel testimonials-carousel">
                    <div class="testimonial-item row align-items-center">
                        <div class="testimonial-img">
                            <img src="img/testimonial-1.jpg" alt="Testimonial image">
                        </div>
                        <div class="testimonial-text">
                            <h3>Anna M. Brzezinski</h3>
                            <h4>businesswoman</h4>
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipiscing elit. Maecenas dictum vel
                            </p>
                        </div>
                    </div>
                    <div class="testimonial-item row align-items-center">
                        <div class="testimonial-img">
                            <img src="img/testimonial-1.jpg" alt="Testimonial image">
                        </div>
                        <div class="testimonial-text">
                            <h3>Shirley H. Lee</h3>
                            <h4>businesswoman</h4>
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipiscing elit. Maecenas dictum vel
                            </p>
                        </div>
                    </div>
                    <div class="testimonial-item row align-items-center">
                        <div class="testimonial-img">
                            <img src="img/testimonial-1.jpg" alt="Testimonial image">
                        </div>
                        <div class="testimonial-text">
                            <h3>Kerry E. Thomas</h3>
                            <h4>businesswoman</h4>
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipiscing elit. Maecenas dictum vel
                            </p>
                        </div>
                    </div>
                    <div class="testimonial-item row align-items-center">
                        <div class="testimonial-img">
                            <img src="img/testimonial-1.jpg" alt="Testimonial image">
                        </div>
                        <div class="testimonial-text">
                            <h3>Kerry E. Thomas</h3>
                            <h4>businesswoman</h4>
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipiscing elit. Maecenas dictum vel
                            </p>
                        </div>
                    </div>
                    <div class="testimonial-item row align-items-center">
                        <div class="testimonial-img">
                            <img src="img/testimonial-1.jpg" alt="Testimonial image">
                        </div>
                        <div class="testimonial-text">
                            <h3>Kerry E. Thomas</h3>
                            <h4>businesswoman</h4>
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipiscing elit. Maecenas dictum vel
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Testimonials End -->
        
         
    
        
        


        <?php include_once("footer.php"); ?> 




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
