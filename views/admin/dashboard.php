<?php
require_once '../../auth/ensureAuthentication.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- box icons css files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">


    <!-- les fishier css -->
    <link rel="stylesheet" href="../../public/css/admin.css">

    <!-- link the icon -->
    <link rel="shortcut icon" type="image/x-icon" href="../../public/icons/campushpere.ico" />

    <!-- link the toastr css files -->
    <link rel="stylesheet" href="../../node_modules/toastr/build/toastr.css">

    <!-- link the font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- link the fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Lato&family=Montserrat:wght@700&display=swap"
        rel="stylesheet" />


    <!-- js libraires -->
    <script defer src="../../node_modules/toastr/build/toastr.min.js"></script>
    <script defer src="../../public/js/notificationSys.js"></script>
    <script src="../../node_modules/jquery/dist/jquery.min.js"></script>

    <!-- js files -->
    <script defer src="../../public/js/admin.js"></script>


</head>

<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="../../public/icons/campushpere.ico" alt="">
                </span>

                <div class="text logo-text">
                    <span class="name">campuSphere</span>
                    <span class="profession" style="font-size: 12px; color: #ccc; font-weight: 400;">admin
                        dashboard</span>
                </div>
            </div>

            <i class='bx bx-chevron-right toggle'></i>
        </header>

        <div class="menu-bar">
            <div class="menu">
                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="dashboard.php" class="active">
                            <i class='bx bx-home-alt icon'></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="market.php">
                            <i class='bx bx-store icon'></i>
                            <span class="text nav-text">Market</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="#">
                            <i class='bx bx-bell icon'></i>
                            <span class="text nav-text">Notifications</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="users.php">
                            <i class='bx bx-user icon'></i>
                            <span class="text nav-text">Users</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="events.php">
                            <i class='bx bx-calendar icon'></i>
                            <span class="text nav-text">Calendar</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="#">
                            <i class='bx bx-wallet icon'></i>
                            <span class="text nav-text">Money</span>
                        </a>
                    </li>

                </ul>
            </div>

            <div class="bottom-content">
                <li class="">
                    <a href="../../controller/logout.php">
                        <i class='bx bx-log-out icon'></i>
                        <span class="text nav-text">Logout</span>
                    </a>
                </li>
            </div>
        </div>

    </nav>

    <section class="home">
        <div class="header-home">
            <div class="left">
                <div class="text text-welcome-dash"></div>
                <div class="date date-welcome-dash"
                    style="font-size: 15px; font-weight: 600; padding-inline: 60px; color: #004E8A;">
                </div>
            </div>
            <div class="right">
                <div id="clock">

                </div>
                <div class="profileImage">
                    <img src="../../public/images/<?= $_SESSION['profile_pic'] ?>" alt="profile picture" />
                </div>
            </div>
        </div>
    </section>


    <script>
    $(".text-welcome-dash").html(`${getGreeting().str}, <?= $_SESSION['fullname'] ?>`);
    $(".date-welcome-dash").html(`${getGreeting().date}`);

    function getGreeting() {
        const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
            'October', 'November', 'December'
        ];
        const currentDate = new Date();
        const dayOfWeek = daysOfWeek[currentDate.getDay()];
        const month = months[currentDate.getMonth()];
        const dayOfMonth = currentDate.getDate();
        const hour = currentDate.getHours();
        let greeting;

        if (hour >= 5 && hour < 12) {
            greeting = 'Good morning';
        } else if (hour >= 12 && hour < 18) {
            greeting = 'Good afternoon';
        } else {
            greeting = 'Good evening';
        }

        const formattedDate = `${month} ${dayOfMonth}, ${dayOfWeek}`;
        return {
            date: formattedDate,
            str: greeting
        };
    }
    </script>
</body>

</html>
