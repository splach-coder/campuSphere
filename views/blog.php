<?php
require_once '../auth/ensureAuthentication.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Events</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="../public/icons/campushpere.ico" />
    <!-- link the css files   -->
    <link rel="stylesheet" href="../node_modules/normalize.css/normalize.css" />
    <link href="../public/css/dashboard.css" rel="stylesheet" />
    <link href="../public/css/templates.css" rel="stylesheet" />
    <link href="../public/css/settings.css" rel="stylesheet" />


    <!-- link the font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- link the fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Lato&family=Montserrat:wght@700&display=swap" rel="stylesheet" />

    <!-- link the swipper css files -->
    <link rel="stylesheet" href="../node_modules/swiper/swiper-bundle.min.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />

    <!-- link the toastr css files -->
    <link rel="stylesheet" href="../node_modules/toastr/build/toastr.css">

    <!-- link the bootstrap -->
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css" />


    <!-- link the jquery and toastr and the zuck.js for the stories -->
    <script defer src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script defer src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script defer src="../node_modules/toastr/build/toastr.min.js"></script>
    <script defer src="../node_modules/swiper/swiper-bundle.min.js"></script>


    <!-- link the js file  -->
    <script defer src="../public/js/notificationSys.js"></script>
    <script defer src="../public/js/dashboard.js"></script>
    <script defer src="../public/js/templates.js"></script>
    <script defer src="../public/js/settings.js"></script>


    <style>
        .tools {
            margin-right: 30px;
        }

        .row {
            padding: 12px 24px;
            border-radius: 15px;
            margin-inline: 50px;
            display: flex;
            flex-wrap: wrap;
            gap: 50px;
        }


        .square:hover {
            -webkit-transform: translate(20px, -10px);
            -ms-transform: translate(10px, -10px);
            transform: translate(10px, -10px);
            -webkit-box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        }


        .square {
            position: relative;
            width: 460px;
            height: 430px;
            background: white;
            border-radius: 4px;
            box-shadow: 0px 20px 50px #D9DBDF;
            -webkit-transition: all 0.3s ease;
            -o-transition: all 0.3s ease;
            transition: all 0.3s ease;
            margin-top: 50px;
        }

        .mask {
            clip: rect(0px, 460px, 220px, 0px);
            border-radius: 4px;
            position: absolute;
            left: 0;
        }

        img {
            width: 460px;
        }

        .h1 {
            margin: auto;
            text-align: left;
            margin-top: 240px;
            padding-left: 30px;

            font-family: 'Merriweather', serif;
            font-size: 24px;
        }

        p {
            text-align: justify;
            padding-left: 30px;
            padding-right: 30px;
            font-family: 'Open Sans', sans-serif;
            font-size: 12px;
            color: #C8C8C8;
            line-height: 18px;
        }

        .button {
            background-color: #3EDD84;
            color: white;
            width: 90px;
            padding: 10px 18px;
            border-radius: 3px;
            text-align: center;
            text-decoration: none;
            display: block;
            margin-top: 20px;
            margin-left: 30px;
            margin-right: 70px;
            font-size: 12px;
            cursor: pointer;
            font-family: 'merriweather';
        }
    </style>

</head>

<body>
    <div class="navbar">
        <div class="logo">
            <a href="dashboard.php">
                <img src="../public/images/campushpereblue.png" alt="logo" title="campushpere" />
            </a>
        </div>
        <div class="tools">
            <div class="searchBar">
                <i class="fas fa-search"></i>
                <input type="text" id="searchbar" class="searchinput" placeholder="Search" />
                <?php include 'templates/search-sort.php'; ?>
                <?php include 'templates/recent-search.php'; ?>
            </div>
            <div class="profileImage">
                <img src="../public/images/<?= $_SESSION['profile_pic'] ?>" alt="profile picture" />
                <?php include 'templates/underProfile.php'; ?>
            </div>
        </div>
    </div>

    <div class="container-fluid pt-5" style="background-color: var(--container-bg);min-height: calc(100vh - 88px);
    box-shadow: inset 0px 6px 14px -6px rgba(0, 0, 0, 0.1);">
        <div class="row">
            <div class="square">
                <img src="https://images.unsplash.com/photo-1504610926078-a1611febcad3?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=e1c8fe0c9197d66232511525bfd1cc82&auto=format&fit=crop&w=1100&q=80" class="mask">
                <div class="h1">Is Apple a Design Company?</div>
                <p>Apple is more than a tech company; it became a culture unto itself, a passion of most of people and
                    the
                    birthplace of the world’s most revolutionized products.</p>

                <div><a href="https://medium.com/@laheshk/is-apple-a-design-company-f5c83514e261" target="_" class="button">Read More</a></div>
            </div>


            <div class="square">
                <img src="https://images.unsplash.com/photo-1504610926078-a1611febcad3?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=e1c8fe0c9197d66232511525bfd1cc82&auto=format&fit=crop&w=1100&q=80" class="mask">
                <div class="h1">Is Apple a Design Company?</div>
                <p>Apple is more than a tech company; it became a culture unto itself, a passion of most of people and
                    the
                    birthplace of the world’s most revolutionized products.</p>

                <div><a href="https://medium.com/@laheshk/is-apple-a-design-company-f5c83514e261" target="_" class="button">Read More</a></div>
            </div>

            <div class="square">
                <img src="https://images.unsplash.com/photo-1504610926078-a1611febcad3?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=e1c8fe0c9197d66232511525bfd1cc82&auto=format&fit=crop&w=1100&q=80" class="mask">
                <div class="h1">Is Apple a Design Company?</div>
                <p>Apple is more than a tech company; it became a culture unto itself, a passion of most of people and
                    the
                    birthplace of the world’s most revolutionized products.</p>

                <div><a href="https://medium.com/@laheshk/is-apple-a-design-company-f5c83514e261" target="_" class="button">Read More</a></div>
            </div>

            <div class="square">
                <img src="https://images.unsplash.com/photo-1504610926078-a1611febcad3?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=e1c8fe0c9197d66232511525bfd1cc82&auto=format&fit=crop&w=1100&q=80" class="mask">
                <div class="h1">Is Apple a Design Company?</div>
                <p>Apple is more than a tech company; it became a culture unto itself, a passion of most of people and
                    the
                    birthplace of the world’s most revolutionized products.</p>

                <div><a href="https://medium.com/@laheshk/is-apple-a-design-company-f5c83514e261" target="_" class="button">Read More</a></div>
            </div>

            <div class="square">
                <img src="https://images.unsplash.com/photo-1504610926078-a1611febcad3?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=e1c8fe0c9197d66232511525bfd1cc82&auto=format&fit=crop&w=1100&q=80" class="mask">
                <div class="h1">Is Apple a Design Company?</div>
                <p>Apple is more than a tech company; it became a culture unto itself, a passion of most of people and
                    the
                    birthplace of the world’s most revolutionized products.</p>

                <div><a href="https://medium.com/@laheshk/is-apple-a-design-company-f5c83514e261" target="_" class="button">Read More</a></div>
            </div>

            <div class="square">
                <img src="https://images.unsplash.com/photo-1504610926078-a1611febcad3?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=e1c8fe0c9197d66232511525bfd1cc82&auto=format&fit=crop&w=1100&q=80" class="mask">
                <div class="h1">Is Apple a Design Company?</div>
                <p>Apple is more than a tech company; it became a culture unto itself, a passion of most of people and
                    the
                    birthplace of the world’s most revolutionized products.</p>

                <div><a href="https://medium.com/@laheshk/is-apple-a-design-company-f5c83514e261" target="_" class="button">Read More</a></div>
            </div>

            <div class="square">
                <img src="https://images.unsplash.com/photo-1504610926078-a1611febcad3?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=e1c8fe0c9197d66232511525bfd1cc82&auto=format&fit=crop&w=1100&q=80" class="mask">
                <div class="h1">Is Apple a Design Company?</div>
                <p>Apple is more than a tech company; it became a culture unto itself, a passion of most of people and
                    the
                    birthplace of the world’s most revolutionized products.</p>

                <div><a href="https://medium.com/@laheshk/is-apple-a-design-company-f5c83514e261" target="_" class="button">Read More</a></div>
            </div>
        </div>
    </div>
</body>

</html>