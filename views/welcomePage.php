<?php
  require_once '../auth/forwardAuthentication.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" type="image/x-icon" href="../public/icons/campushpere.ico" />
    <title>campuSphere</title>

    <!-- link the fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Lato&family=Montserrat:wght@700&display=swap"
        rel="stylesheet" />

    <!-- link the font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- link the bootstrap -->
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css" />

    <!-- link the css files -->
    <link rel="stylesheet" href="../public/css/welcomePageStyle.css" />

    <!-- link the js files -->
    <script defer src="../public/js/welcomePage.js"></script>
</head>

<body>
    <div class="pageOne">
        <div class="slider">
            <div class="slide_viewer">
                <div class="slide_group">
                    <div class="slide">
                        <img src="../public/images/javier-trueba-iQPr1XkF5F0-unsplash.jpg" alt="img" />
                    </div>
                    <div class="slide">
                        <img src="../public/images/javier-trueba-iQPr1XkF5F0-unsplash.jpg" alt="img" />
                    </div>
                    <div class="slide">
                        <img src="../public/images/javier-trueba-iQPr1XkF5F0-unsplash.jpg" alt="img" />
                    </div>
                    <div class="slide">
                        <img src="../public/images/javier-trueba-iQPr1XkF5F0-unsplash.jpg" alt="img" />
                    </div>

                    <div class="slide">
                        <img src="../public/images/javier-trueba-iQPr1XkF5F0-unsplash.jpg" alt="img" />
                    </div>
                </div>
            </div>

            <div class="slide_buttons"></div>

            <div class="container">
                <div class="directional_nav">
                    <div class="previous_btn" title="Previous">
                        <i class="fas fa-arrow-left left"></i>
                    </div>
                    <div class="next_btn" title="Next">
                        <i class="fas fa-arrow-right right"></i>
                    </div>
                </div>
            </div>

            <!-- End // .directional_nav -->
        </div>
        <!-- End // .slider -->
    </div>

    <div class="container">
        <!-- nav bar begin -->
        <nav>
            <div class="logo">
                <img src="../public/images/campushpere.png" alt="" />
            </div>
            <div class="links">
                <ul>
                    <li>HOME</li>
                    <li>BLOG</li>
                    <li>ABOUT US</li>
                    <li>CONTACT</li>
                    <li title="Login"><a href="login.php"><i class="fa-regular fa-circle-user"></i></a></li>
                </ul>
            </div>
        </nav>
        <!-- nav bar ends -->

        <!-- middles blocks begin -->

        <!-- middles blocks end -->
    </div>

    <div class="container">
        <div class="middles">
            <div class="square">
                <i class="fas fa-heartbeat"></i>
                <h3>Why study on UPM?</h3>
                <p>
                    UPM provides quality education, industry-relevant curriculum,
                    state-of-the-art facilities, career opportunities, and a diverse
                    student community.
                </p>
                <a href="#" class="button">Read More<i class="fas fa-chevron-right"></i></a>
            </div>
            <div class="square">
                <i class="fas fa-globe"></i>
                <h3>Campus Life</h3>
                <p>
                    UPM offers a lively campus life with diverse extracurricular
                    activities, clubs, and events that foster social connections.
                </p>
                <a href="#" class="button">Read More<i class="fas fa-chevron-right"></i></a>
            </div>
            <div class="square">
                <i class="fas fa-utensils"></i>
                <h3>News & Events</h3>
                <p>
                    UPM hosts regular news and events such as seminars and conferences
                    to keep students informed and connected with industry professionals.
                </p>
                <a href="#" class="button">Read More<i class="fas fa-chevron-right"></i> </a>
            </div>
        </div>
    </div>

    <!-- implement jquery and bootstrap -->
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
</body>

</html>
