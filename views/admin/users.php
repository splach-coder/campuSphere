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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">


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
    <script src="../../node_modules/datatables.net/js/jquery.dataTables.min.js"></script>

    <!-- js files -->


    <style>
    h3 {
        position: relative;
        left: 78px;
        padding: 12px;
        margin-bottom: 50px;
        width: calc(100% - 78px);
    }

    .dataTables_wrapper {
        position: relative;
        left: 78px;
        padding: 12px;
        max-width: calc(100% - 100px) !important;
    }

    th {
        background: #1877F2;
        color: whitesmoke;
    }

    td {
        border-bottom: 1px solid #ccc;
        padding: 5px 0;
        transition: all 150ms ease;
        cursor: pointer;
    }

    td:hover {
        background-color: #E4E9F7;
        color: #1877F2;
    }

    table {
        padding: 15px 0;
    }

    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #aaa;
        border-radius: 3px;
        padding: 5px;
        background-color: transparent;
        margin-left: 10px;
        outline: none;
    }

    .modalll {
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

    .modalll.show {
        display: flex;
    }

    .inner-modal {
        width: 500px;
        height: 600px;
        background-color: white;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 25px;
        border-radius: 10px;
    }

    .inner-modal div {
        width: 100%;
        display: flex;
        gap: 25px;
        padding: 5px 12px;
    }

    .modalll.show .inner-modal span:first-child {
        width: 100px;
        height: 6px;
        background-color: #1877F2;
        border-radius: 5px;
        margin-top: 10px;
    }

    .modalll.show .fas.fa-close {
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

    .modalll.show img {
        object-fit: cover;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .inner-footer {
        width: 100%;
        padding: 20px;
        display: flex;
        justify-content: flex-end;
        gap: 20px;
        border-top: 1px solid #ccc;
        margin-top: auto;
    }

    .admin,
    .delete {
        padding: 5px 20px;
        font-size: 16px;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .delete {
        background-color: #dc3545;
    }

    .admin {
        background-color: #28a745;
    }

    .inner-footer button:hover {
        filter: brightness(90%);
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
                        <a href="users.php" class="active">
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
        <h3>Users</h3>

        <table id="users-table">
            <thead>
                <tr>
                    <th>user id</th>
                    <th>User Name</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created At</th>
                    <th>Last Seen</th>
                    <th>pdp</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

    </section>

    <div class="modalll" id="myModall">

        <i class="fas fa-close"></i>
        <div class="inner-modal">
            <span></span>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        //open and close the sidebar
        $(".toggle").click(function() {
            $(".sidebar").toggleClass('close');
        });

        var table = $('#users-table').DataTable({
            ajax: {
                url: '../../controller/admin/getUsers.php',
                dataSrc: ''
            },
            columns: [{
                data: 'id_user',
            }, {
                data: 'user_name',
            }, {
                data: 'fullname'
            }, {
                data: 'email'
            }, {
                data: 'role'
            }, {
                data: 'created_at'
            }, {
                data: 'lastSeen'
            }, {
                data: 'profile_pic',
                visible: false
            }]
        });

        // Add a click event to all `td` elements in the DataTable
        $('#users-table tbody').on('click', 'td', function() {
            // Get the corresponding row data
            var row = table.row($(this).closest('tr'));
            var rowData = row.data();


            // Display the row data in a modal
            $('#myModall').toggleClass('show');
            $('#myModall .inner-modal').html('<span></span>' +
                '<img src="../../public/images/' + rowData.profile_pic +
                '" width="100px" height="100px">' +
                '<div><label>User name:</label> <input type="text" value="' +
                rowData.user_name +
                '" disabled /></div>' +
                '<div><label>Email:</label> <input type="text" value="' + rowData.email +
                '" disabled /></div>' +
                '<div><label>Role:</label>  <input type="text" value="' + rowData.role +
                '" disabled /></div>' +
                '<div><label>Created at:</label>  <input type="text" value="' + rowData.created_at +
                '" disabled /></div>' +
                '<div><label>Last seen:</label> <input type="text" value=" ' + rowData.lastSeen +
                '" disabled /></div>' +
                `<div class="inner-footer"> 
                <button class="admin" data-id="${rowData.id_user}">Make as Admin</button>
                <button class="delete" data-id="${rowData.id_user}">Supprimer</button>   </div>`);

        });

        $(".inner-modal").on('click', 'button', function() {
            //make as an admin
            if ($(this).hasClass("admin")) {
                $.ajax({
                    url: '../../controller/admin/makeAsAdmin.php',
                    method: 'post',
                    data: {
                        id: $(this).attr('data-id')
                    },
                    success: data => showToast('success', 'toast-top-center', data),
                    error: err => console.log(err)
                })
            } else if ($(this).hasClass("delete")) { //delete a user
                $.ajax({
                    url: '../../controller/admin/deleteUser.php',
                    method: 'post',
                    data: {
                        id: $(this).attr('data-id')
                    },
                    success: data => showToast('success', 'toast-top-center', data),
                    error: err => console.log(err)
                })
            }
        });




        $(".fas.fa-close").click(function() {
            // Display the row data in a modal
            $('#myModall').toggleClass('show');
        });
    });
    </script>
</body>

</html>
