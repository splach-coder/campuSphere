<?php
require_once '../auth/ensureAuthentication.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- link the icon -->
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
    <link rel="stylesheet" href="../node_modules/swiper/swiper-bundle.min.css" />

    <!-- link the toastr css files -->
    <link rel="stylesheet" href="../node_modules/toastr/build/toastr.css">

    <!-- link the bootstrap -->
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css" />

    <!-- link the css files   -->
    <link rel="stylesheet" href="../node_modules/normalize.css/normalize.css" />
    <link href="../public/css/postLayout.css" rel="stylesheet" />
    <link href="../public/css/profile.css" rel="stylesheet" />
    <link href="../public/css/postmodal.css" rel="stylesheet" />
    <link href="../public/css/loader.css" rel="stylesheet" />
    <link href="../public/css/hobbiesStyle.css" rel="stylesheet" />
    <link href="../public/css/imageViewer.css" rel="stylesheet" />


    <!-- link the jquery and toastr and the zuck.js for the stories -->
    <script src="../node_modules/dompurify/dist/purify.min.js"></script>
    <script defer src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script defer src="../node_modules/toastr/build/toastr.min.js"></script>
    <script defer src="../node_modules/swiper/swiper-bundle.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/vibrant.js/1.0.0/Vibrant.min.js"></script>

    <!-- link the js file  -->
    <script defer src="../public/js/notificationSys.js"></script>
    <script defer src="../public/js/dashboard.js"></script>
    <script defer src="../public/js/postScript.js"></script>
    <script defer src="../public/js/postsReqs.js"></script>
    <script defer src="../public/js/templates.js"></script>
    <script defer src="../public/js/profile.js"></script>
    <script defer src="../public/js/profile-data.js"></script>
    <script defer src="../public/js/hobbies.js"></script>

    <title>
        <?= $_SESSION['fullname'] ?> | Profile
    </title>
</head>

<body>
    <div class=" navbar">
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
            <div class="createPost">
                <button id="createPost_navButton">
                    <i class="fas fa-plus"></i> Create
                </button>
            </div>
            <div class="profileImage">
                <img src="../public/images/<?= $_SESSION['profile_pic'] ?>" alt="profile picture" />
                <?php include 'templates/underProfile.php'; ?>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="cover-photo-holder">
            <div class="shadow"></div>
            <div class="profile-con2 cover-photo-insider">
                <img src="" id="cover-img" alt="cover photo" />
            </div>
            <input type="file" name="cover-photo" style="display: none" id="cover-photo-btn"
                accept="image/jpeg,image/png,image/jpg" />
            <button class="edit-cover-photo">
                <i class="fas fa-camera"></i>
                Edit cover photo
            </button>
        </div>
        <div class="profile-con2">
            <div class="profile-holder">
                <div class="profile-holder-upper">
                    <div class="profile-holder-upper-infos-left">
                        <div class="imgbx">
                            <img id="user-profile-img" src="" alt="" />
                            <i class="fas fa-camera" id="edit-profile-photo"></i>
                        </div>
                        <input type="file" name="cover-profile-photo" style="display: none" id="cover-profile-photo-btn"
                            accept="image/jpeg,image/png,image/jpg" />
                        <div class="info">
                            <h5 id="user-fullname"></h5>
                            <span id="friends-number"></span>
                            <div class="profile-friends">
                                <ul id="profile-friends-circles">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="devider"></div>
                <div class="profile-holder-lower">
                    <ul>
                        <li class="data-type-display posts-153 active">Posts</li>
                        <li class="data-type-display friends-153">Friends</li>
                        <li class="data-type-display images-153">Images</li>
                        <li class="data-type-display videos-153">Videos</li>
                    </ul>
                </div>
            </div>

            <div class="main-con">
                <div class="col user-infos">
                    <div class="profile-item user-bio">
                        <div class="bio-con">
                            <div class="upper-side">Intro</div>
                            <div class="user-bio-content">

                            </div>
                        </div>
                        <button id="editBioBtn">Edit Bio</button>
                        <div class="hobbies-con"></div>
                        <button id="hobbies-btn">Add hobies</button>
                    </div>

                    <div class="profile-item profile-photos">
                        <div class="upper-side">
                            <span>Photos</span> <a href="#">See all photos</a>
                        </div>
                        <div class="user-photos-holder">
                            <p style="margin: 50px auto; font-size: 25px; color: var(--secondary-gray);">No Pictures Yet
                            </p>
                        </div>
                    </div>

                    <div class="profile-item profile-friends">
                        <div class="upper-side">
                            <span>Friends</span> <a href="#">See all friends</a>
                        </div>
                        <div class="user-friends-holder">
                            <p style="margin: 50px auto; font-size: 25px; color: var(--secondary-gray);">No Friends Yet
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col user-posts">
                    <p style="margin: 50px auto; font-size: 25px; color: var(--secondary-gray);">No POSTS</p>
                </div>
            </div>


            <div class="friends-container-profile">
                <div class="title">
                    Friends
                </div>
            </div>

            <div class="images-container-profile">
            </div>

            <div class="vids-container-profile">
            </div>

        </div>

    </div>

    <?php include 'templates/postmodal.php'; ?>
    <?php include 'templates/changecover.php'; ?>
    <?php include 'templates/changeProfile.php'; ?>
    <?php include 'templates/hobbies.php'; ?>
    <?php include 'templates/imageViewer.php'; ?>

    <!-- the main loaders  -->
    <div class="loader"></div>
</body>

</html>
