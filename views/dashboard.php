<!-- <?php 
    require_once '../auth/ensureAuthentication.php';
?> -->
<!DOCTYPE html>
<html lang="en">

<head>
    <title></title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="../public/icons/campushpere.ico" />
    <!-- link the font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- link the fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Lato&family=Montserrat:wght@700&display=swap"
        rel="stylesheet" />

    <!-- link the zuck.js css styles -->
    <link rel="stylesheet" href="../node_modules/zuck.js/dist/zuck.css" />
    <link rel="stylesheet" href="../node_modules/zuck.js/dist/skins/snapssenger.css" />

    <!-- link the toastr css files -->
    <link rel="stylesheet" href="../node_modules/toastr/build/toastr.css">

    <!-- link the css files   -->
    <link rel="stylesheet" href="../node_modules/normalize.css/normalize.css" />
    <link href="../public/css/dashboard.css" rel="stylesheet" />
    <link href="../public/css/loader.css" rel="stylesheet" />
    <link href="../public/css/postStyle.css" rel="stylesheet" />

    <!-- link the jquery and toastr and the zuck.js for the stories -->
    <script src="../node_modules/dompurify/dist/purify.min.js"></script>
    <script src="../node_modules/zuck.js/dist/zuck.js"></script>
    <script defer src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script defer src="../node_modules/toastr/build/toastr.min.js"></script>

    <!-- link the js file  -->
    <script defer src="../public/js/notificationSys.js"></script>
    <script defer src="../public/js/stories.js"></script>
    <script defer src="../public/js/dashboard.js"></script>
    <script defer src="../public/js/postScript.js"></script>
</head>

<body>
    <div class="navbar">
        <div class="logo">
            <img src="../public/images/campushpereblue.png" alt="logo" title="campushpere" />
        </div>
        <div class="tools">
            <div class="searchBar">
                <i class="fas fa-search"></i>
                <input type="text" id="searchbar" class="searchinput" placeholder="Search" />
            </div>
            <div class="createPost">
                <button id="createPost_navButton"><i class="fas fa-plus"></i> Create</button>
            </div>
            <div class="profileImage">
                <img src="../public/images/<?=$_SESSION['profile_pic']?>" alt="profile picture" />
            </div>
        </div>
    </div>
    <div class="container">
        <div class="col"></div>
        <div class="col">
            <div id="stories" class="stories">
                <div id="addStory" class="add-story">
                    <i class="fa-solid fa-plus"></i>
                </div>
            </div>

            <?php include 'templates/postTemplate.php'; ?>
        </div>
        <div class="col"></div>
    </div>

    <!-- add the stories modals  -->

    <!-- The Modal -->
    <div id="myModal" class="modal">
        <span class="close">&times;</span>
        <!-- Modal content -->
        <div class="modal-content first">
            <div class="header">Create new Story</div>
            <div class="body">
                <svg aria-label="Icon to represent media such as images or videos" class="x1lliihq x1n2onr6"
                    color="rgb(38, 38, 38)" fill="rgb(38, 38, 38)" height="77" role="img" viewBox="0 0 97.6 77.3"
                    width="96">
                    <title>Icon to represent media such as images or videos</title>
                    <path
                        d="M16.3 24h.3c2.8-.2 4.9-2.6 4.8-5.4-.2-2.8-2.6-4.9-5.4-4.8s-4.9 2.6-4.8 5.4c.1 2.7 2.4 4.8 5.1 4.8zm-2.4-7.2c.5-.6 1.3-1 2.1-1h.2c1.7 0 3.1 1.4 3.1 3.1 0 1.7-1.4 3.1-3.1 3.1-1.7 0-3.1-1.4-3.1-3.1 0-.8.3-1.5.8-2.1z"
                        fill="currentColor"></path>
                    <path
                        d="M84.7 18.4 58 16.9l-.2-3c-.3-5.7-5.2-10.1-11-9.8L12.9 6c-5.7.3-10.1 5.3-9.8 11L5 51v.8c.7 5.2 5.1 9.1 10.3 9.1h.6l21.7-1.2v.6c-.3 5.7 4 10.7 9.8 11l34 2h.6c5.5 0 10.1-4.3 10.4-9.8l2-34c.4-5.8-4-10.7-9.7-11.1zM7.2 10.8C8.7 9.1 10.8 8.1 13 8l34-1.9c4.6-.3 8.6 3.3 8.9 7.9l.2 2.8-5.3-.3c-5.7-.3-10.7 4-11 9.8l-.6 9.5-9.5 10.7c-.2.3-.6.4-1 .5-.4 0-.7-.1-1-.4l-7.8-7c-1.4-1.3-3.5-1.1-4.8.3L7 49 5.2 17c-.2-2.3.6-4.5 2-6.2zm8.7 48c-4.3.2-8.1-2.8-8.8-7.1l9.4-10.5c.2-.3.6-.4 1-.5.4 0 .7.1 1 .4l7.8 7c.7.6 1.6.9 2.5.9.9 0 1.7-.5 2.3-1.1l7.8-8.8-1.1 18.6-21.9 1.1zm76.5-29.5-2 34c-.3 4.6-4.3 8.2-8.9 7.9l-34-2c-4.6-.3-8.2-4.3-7.9-8.9l2-34c.3-4.4 3.9-7.9 8.4-7.9h.5l34 2c4.7.3 8.2 4.3 7.9 8.9z"
                        fill="currentColor"></path>
                    <path
                        d="M78.2 41.6 61.3 30.5c-2.1-1.4-4.9-.8-6.2 1.3-.4.7-.7 1.4-.7 2.2l-1.2 20.1c-.1 2.5 1.7 4.6 4.2 4.8h.3c.7 0 1.4-.2 2-.5l18-9c2.2-1.1 3.1-3.8 2-6-.4-.7-.9-1.3-1.5-1.8zm-1.4 6-18 9c-.4.2-.8.3-1.3.3-.4 0-.9-.2-1.2-.4-.7-.5-1.2-1.3-1.1-2.2l1.2-20.1c.1-.9.6-1.7 1.4-2.1.8-.4 1.7-.3 2.5.1L77 43.3c1.2.8 1.5 2.3.7 3.4-.2.4-.5.7-.9.9z"
                        fill="currentColor"></path>
                </svg>
                <p>Drag photos and videos here</p>
                <button onclick="document.getElementById('media-file').click()">
                    <input type="file" id="media-file" name="media-file" accept="image/*,video/*" />Select From computer
                </button>
            </div>
        </div>
        <div class="modal-content second">
            <div class="header">
                <i class="fa-solid fa-arrow-left" id="back" title="back"></i>
                <span class="Crop">Crop</span>
                <span id="nextbtn" class="next">next</span>
            </div>
            <div class="body"></div>
        </div>
    </div>
    <div id="second-modal" class="modal">
        <div class="modal-content discard-alert">
            <div>
                <h3>Discard post?</h3>
                <p>If you leave, your edits won't be saved.</p>
            </div>
            <button id="discard">Discard</button>
            <button id="cancel">Cancel</button>
        </div>
    </div>

    <!-- the main loaders  -->
    <div class="loader"></div>
</body>

</html>
