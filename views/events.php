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


    <!-- link the css file for the event -->



    <!-- link the jquery and toastr and the zuck.js for the stories -->
    <script defer src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script defer src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script defer src="../node_modules/toastr/build/toastr.min.js"></script>
    <script defer src="../node_modules/swiper/swiper-bundle.min.js"></script>

    <!-- Include fullCalendar plugin for jQuery -->
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>

    <!-- link the js file  -->
    <script defer src="../public/js/notificationSys.js"></script>
    <script defer src="../public/js/dashboard.js"></script>
    <script defer src="../public/js/templates.js"></script>
    <script defer src="../public/js/event.js"></script>


    <style>
        .tools {
            margin-right: 30px;
        }

        .modal-content {
            margin-top: 70%;
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

    <div class="container-fluid" style="background-color: var(--container-bg);min-height: calc(100vh - 88px);
    box-shadow: inset 0px 6px 14px -6px rgba(0, 0, 0, 0.1);">
        <div id="calendar"></div>

        <!-- Modal for adding/editing events -->
        <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="eventModalLabel"></h4>
                    </div>
                    <div class="modal-body">
                        <form id="eventForm">
                            <div class="form-group">
                                <label for="eventName">Event Name:</label>
                                <input type="text" class="form-control" id="eventName" name="eventName" required>
                            </div>
                            <div class="form-group">
                                <label for="eventDate">Event Date:</label>
                                <input type="date" class="form-control" id="eventDate" name="eventDate" required>
                            </div>
                            <div class="form-group">
                                <label for="eventTime">Event Time:</label>
                                <input type="time" class="form-control" id="eventTime" name="eventTime" required>
                            </div>
                            <div class="form-group">
                                <label for="eventLocation">Event Location:</label>
                                <input type="text" class="form-control" id="eventLocation" name="eventLocation" required>
                            </div>
                            <div class="form-group">
                                <label for="eventDescription">Event Description:</label>
                                <textarea class="form-control" id="eventDescription" name="eventDescription"></textarea>
                            </div>
                            <input type="hidden" id="eventId" name="eventId">
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>

</html>