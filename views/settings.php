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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- link the fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Lato&family=Montserrat:wght@700&display=swap"
        rel="stylesheet" />

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
        max-width: 50%;
        padding: 12px 24px;
        border-radius: 15px;
        margin-inline: 50px;
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
        <div class="row bg-white py-4 ">
            <h4>Settings</h4>
            <form class="w-50" id="form">
                <div class="alert d-none mt-3 w-100" role="alert"></div>
                <div class="form-group py-2 px-2">
                    <label for="firstname">First Name</label>
                    <input type="text" class="form-control w-100" id="firstname" name="firstname"
                        placeholder="Enter full name" value="<?= $_SESSION['firstname'] ?>">
                </div>
                <div class="form-group py-2 px-2">
                    <label for="lastname">Last Name</label>
                    <input type="text" class="form-control w-100" id="lastname" name="lastname"
                        placeholder="Enter full name" value="<?= $_SESSION['lastname'] ?>">
                </div>
                <div class="form-group py-2 px-2">
                    <label for="username">Username</label>
                    <input type="text" class="form-control w-100" id="username" name="username"
                        placeholder="Enter username" value="<?= $_SESSION['username'] ?>">
                </div>
                <button type="submit" class="btn btn-primary mt-2 mx-2 w-50">Edit</button>
            </form>
        </div>
    </div>
</body>

</html>
