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
    <link rel="stylesheet" href="../../public/css/eventCard.css">

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


    <style>
    .eventheader h3 {
        padding: 12px;
        width: calc(100% - 78px);
    }

    .eventheader button {
        display: inline-block;
        outline: none;
        border-width: 0px;
        border-radius: 3px;
        box-sizing: border-box;
        font-size: inherit;
        font-weight: 500;
        max-width: 100%;
        text-align: center;
        text-decoration: none;
        transition: background 0.1s ease-out 0s, box-shadow 0.15s cubic-bezier(0.47, 0.03, 0.49, 1.38) 0s;
        background: rgb(0, 82, 204);
        cursor: pointer;
        height: 32px;
        line-height: 32px;
        padding: 0px 12px;
        vertical-align: middle;
        width: 120px;
        font-size: 14px;
        color: rgb(255, 255, 255);
    }

    .eventheader button:hover {
        background: rgb(0, 101, 255);
        text-decoration: inherit;
        transition-duration: 0s, 0.15s;
        color: rgb(255, 255, 255);
    }

    .eventheader {
        position: relative;
        left: 78px;
        padding: 12px;
        width: calc(100% - 78px);
        display: flex;
        justify-content: space-evenly;
        align-items: center;
        margin-bottom: 50px;
    }

    .modal {
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        position: fixed;
        top: 0;
        left: 0;
        display: none;
        z-index: 999999;
        align-items: center;
        justify-content: center;
    }

    .modal.show {
        display: flex;
    }

    .modal.show .fas.fa-close {
        position: absolute;
        right: 15px;
        top: 15px;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #65676B;
        color: whitesmoke;
        border-radius: 50%;
        cursor: pointer;
    }

    .con {
        width: 80%;
        max-width: 700px;
        background: white;
        border-radius: 15px;
        padding: 20px;
        display: flex;
        flex-direction: column;
    }

    .con h2 {
        margin: auto;
    }

    input,
    textarea {
        padding: 5px 16px;
        border-radius: 5px;
        outline: none;
        margin-top: 15px;
        border: 1px solid #ccc;
    }

    label {
        margin-top: 20px;
        font-size: 18px;
        font-weight: 600;
    }

    button.addEvent {
        margin-top: 25px;
        cursor: pointer;
        outline: 0;
        color: #fff;
        background-color: #0d6efd;
        border-color: #0d6efd;
        display: inline-block;
        font-weight: 400;
        line-height: 1.5;
        text-align: center;
        border: 1px solid transparent;
        padding: 6px 12px;
        font-size: 16px;
        border-radius: 0.25rem;
        transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out,
            border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    button.addEvent:hover {
        color: #fff;
        background-color: #0b5ed7;
        border-color: #0a58ca;
    }

    #sidebar {
        position: fixed;
        top: 0;
        right: -400px;
        /* Set the initial position off screen */
        width: 400px;
        height: 100%;
        background-color: #f2f2f2;
        transition: all 0.5s ease-in-out;
        /* Add a transition for the animation */
        z-index: 99;
    }

    #sidebar.show {
        right: 0;
        /* Set the final position on screen */
    }

    #sidebarContent {
        display: flex;
        flex-direction: column;
        padding-top: 50px;
        align-items: center;
        gap: 20px;
    }

    .img-box {
        width: 300px;
        height: 150px;
        border: 1px solid #ccc;
        cursor: pointer;
    }

    .img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .event-title {
        font-size: 22px;
        font-weight: 600;
        line-height: 26px;
    }

    .event-date {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .event-date .Sdate {
        font-size: 18px;
        font-weight: 600;
    }

    .event-date .Stime {
        font-size: 15px;
        font-weight: 500;
        color: #65676B;
        margin-left: 50px;
    }

    .event-desc {
        line-break: anywhere;
        padding: 5px 25px;
        font-size: 16px;
        font-weight: 400;
        line-height: 22px;
    }

    </style>
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
                        <a href="dashboard.php">
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
                        <a href="events.php" class="active">
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

    <div id="sidebar">
        <div id="sidebarContent">

            <div class="img-box">
                <img src="" alt="">
            </div>

            <div class="event-title">
                Soccer Event
            </div>

            <div class="event-date">
                <div class="Sdate"> Thursday, 19 May </div>
                <div class="Stime">begins at 22:00</div>
            </div>

            <div class="event-desc">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Et eos autem magni blanditiis laudantium,
                labore tempora sapiente. Quibusdam, veniam dolores. Ducimus laudantium corrupti fugiat enim modi
                corporis veniam consequatur facilis.
            </div>

            <div class="event-location">
                Marrakech, UPM
            </div>
        </div>
    </div>

    <section class="home">
        <div class="eventheader">
            <h3>Events</h3>
            <button type="button" class="addEventOpen">Add Event</button>
        </div>
        <div class="card-docker">

        </div>
    </section>

    <div class="modal">
        <i class="fas fa-close"></i>
        <div class="con">
            <h2>Add Event</h2>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>

            <label for="time">Time:</label>
            <input type="time" id="time" name="time" required>

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>

            <button type="submit" class="addEvent">Add</button>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        //get Events
        getEvents();

        //open and close the sidebar
        $(".toggle").click(function() {
            $(".sidebar").toggleClass('close');
        });

        $(".fas.fa-close").click(function() {
            // Display the row data in a modal
            $('.modal').toggleClass('show');
        });

        $(".addEventOpen").click(function() {
            // open the modal
            $('.modal').toggleClass('show');
        });

        // Open the sidebar when the button is clicked
        $('.card-docker').on('click', '.card', function() {
            // Add the "show" class to the sidebar to trigger the animation
            $('#sidebar').addClass('show');

            // Make AJAX request to get event data
            $.ajax({
                url: '../../controller/admin/getEvent.php',
                method: 'GET',
                dataType: 'json',
                data: {
                    id: $(this).attr('data-id')
                },

                success: function(data) {
                    console.log(data)
                    // Get the first event from the response
                    var event = data;

                    // Set the image source
                    $('.img-box img').attr('src', '../../public/images/' + event.preview);

                    // Set the event title
                    $('.event-title').text(event.name);


                    $('.Sdate').text(formatDate(event.date));

                    // Set the event time
                    $('.Stime').text('begins at ' + event.time);

                    // Set the event description
                    $('.event-desc').text(event.description);

                    // Set the event location
                    $('.event-location').text(event.location);
                },
                error: function(xhr, status, error) {
                    // Handle errors here
                    console.log(error);
                }
            });
        });

        // Close the sidebar when the user clicks outside of it
        $(document).mouseup(function(e) {
            var sidebar = $('#sidebar');
            if (!sidebar.is(e.target) && sidebar.has(e.target).length === 0) {
                sidebar.removeClass('show');
            }
        });



        $('.addEvent').click(function() {
            // get the input data
            var name = $('#name').val();
            var date = $('#date').val();
            var time = $('#time').val();
            var location = $('#location').val();
            var description = $('#description').val();

            // send the AJAX request
            $.ajax({
                url: '../../controller/admin/addEvent.php',
                type: 'POST',
                data: {
                    name: name,
                    date: date,
                    time: time,
                    location: location,
                    description: description
                },
                success: function(response) {
                    console.log(response);
                    $(".addEventOpen").click();
                    showToast('success', 'toast-top-center', response);
                    getEvents();
                    clearInputs("con");
                },
                error: function(xhr, status, error) {
                    console.log('Error adding event:', error);
                }
            });
        });
    });

    function card(id, title, desc, img, rotate) {
        return `
        <div class="card" data-id="${id}" style="transform: ${rotate};">
            <img src="../../public/images/${img}"/>
            <h2>${title}</h2>
            <p>${desc}.</p>
        </div>
        `;
    }

    function randomRotate() {
        const deg = Math.random() * (5 - -5) - 5;
        return 'rotate(' + deg + 'deg)';
    }

    function clearInputs(divId) {
        // select all input fields within the specified div
        var inputs = $('.' + divId).find('input');

        // loop through each input field and clear its value
        inputs.each(function() {
            $(this).val('');
        });
    }

    function formatDate(dateStr) {
        // Create a new date object from the input string
        var date = new Date(dateStr);

        // Define arrays for weekdays and months
        var weekdays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October",
            "November", "December"
        ];

        // Get the weekday, day, and month from the date object
        var weekday = weekdays[date.getDay()];
        var day = date.getDate();
        var month = months[date.getMonth()];

        // Return the formatted date string
        return weekday + ', ' + day + ' ' + month;
    }



    function getEvents() {
        //get events
        $.ajax({
            url: '../../controller/events.php',
            method: 'get',
            data: {
                id: $(this).attr('data-id')
            },
            success: data => {
                if (data) {
                    $(".card-docker").empty();
                    data.forEach(event => {
                        const rotate = randomRotate();
                        $(".card-docker").append(card(event.id, event.name, event.description, event
                            .preview,
                            rotate))
                    });
                }
            },
            error: err => console.log(err)
        });
    }
    </script>
</body>

</html>
