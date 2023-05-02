<?php
require_once '../auth/ensureAuthentication.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Market Place</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="../public/icons/campushpere.ico" />
    <!-- link the css files   -->
    <link rel="stylesheet" href="../node_modules/normalize.css/normalize.css" />
    <link href="../public/css/dashboard.css" rel="stylesheet" />
    <link href="../public/css/templates.css" rel="stylesheet" />

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

    <!-- link the toastr css files -->
    <link rel="stylesheet" href="../node_modules/toastr/build/toastr.css">

    <!-- link the bootstrap -->
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css" />


    <!-- link the css file for the marketplace -->
    <link rel="stylesheet" href="../public/css/marketplace.css">
    <link rel="stylesheet" href="../public/css/listProducts.css">


    <!-- link the jquery and toastr and the zuck.js for the stories -->
    <script defer src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script defer src="../node_modules/toastr/build/toastr.min.js"></script>
    <script defer src="../node_modules/swiper/swiper-bundle.min.js"></script>

    <!-- link the js file  -->
    <script defer src="../public/js/notificationSys.js"></script>
    <script defer src="../public/js/dashboard.js"></script>
    <script defer src="../public/js/templates.js"></script>
    <script defer src="../public/js/marketplace.js"></script>
    <script defer src="../public/js/addproduit.js"></script>


    <style>
    .tools {
        margin-right: 30px;
    }

    .createProduct {
        width: 100%;
        display: flex;
        gap: 15px;
        padding: 8px;
        border-radius: 5px;
        cursor: pointer;
        align-items: center;
        font-size: 15px;
        line-height: 20px;
        font-weight: 700;
        color: #fff;
        background-color: var(--primary-blue);
    }

    .createProduct i {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .searchers-con,
    .recent-searches {
        left: 0;
    }

    .underprofile-holder {
        left: calc(100% - 350px);
    }

    .notifications {
        width: 680px;
        margin: auto;
        background: white;
        border-radius: 15px;
    }

    .notif {
        display: flex;
        gap: 15px;
        align-items: center;
        cursor: pointer;
        border-radius: 10px;
    }

    .notif .icon-box {
        width: 50px;
        height: 50px;
        border: 1px solid #f0f2f5;
        border-radius: 5px;
    }

    .notif .icon-box i {
        font-size: 20px;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: white;
        background: #1771E6;
    }

    .notif .infos {
        color: #050505;
        display: flex;
        flex-direction: column;
    }

    .notif .infos span:last-child {
        color: #1771E6;
    }

    .notif .infos span:last-child i {
        font-size: 10px;
    }

    .notif:hover {
        background: #f0f2f5;
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
        <div class="row">
            <div class="col-md-3 bg-white h-100 py-3"
                style="min-height: calc(100vh - 88px);box-shadow: 2px 3px 14px -6px rgba(0, 0, 0, 0.1);">
                <h4>Marketplace</h4>
                <div class="market-search-bar my-2">
                    <i class="fas fa-search"></i>
                    <input type="text" name="market-search" id="market-search-input" placeholder="Search Marketplace">
                    <?php include "templates/search-history-products.php"; ?>
                </div>
                <div class="market-sections py-3">
                    <div class="market-section active" id="browseALL">
                        <i class="fas fa-store"></i>
                        Browse All
                    </div>

                    <div class="market-section" id="notifications">
                        <i class="fas fa-bell"></i>
                        Notifications
                    </div>

                    <div class="market-section">
                        <i class="fas fa-bag-shopping"></i>
                        Buying
                    </div>

                    <div class="market-section">
                        <i class="fas fa-tag"></i>
                        Selling
                    </div>
                    <div class="createProduct">
                        <i class="fas fa-plus"></i>
                        Create new listing
                    </div>
                </div>
                <h5>Categories</h5>
                <div class="Categories py-3">
                </div>
            </div>
            <div class=" col-md-9">
                <div class="row py-5 row789">
                    <h4 class="text-right ms-1 py-2">Produits</h4>
                    <!-- Ajoutez ici votre liste de produits -->
                    <div class="card-holder">

                    </div>
                </div>
                <div class="row py-5 row456 d-none">
                    <div class="notifications px-3">
                        <h3 class="py-4 fw-bold">Notifications</h3>
                        <h5 class="py-2">Earlier</h5>
                        <div class="notif-wrapper">
                            <div class="notif my-1">
                                <div class="icon-box">
                                    <i class="fas fa-shop"></i>
                                </div>
                                <div class="infos py-3">
                                    <span class="fs-5">Browse more house shit fucked up.</span>
                                    <span class="fw-bold"><i class="fa-solid fa-circle"></i> &nbsp; 2d</span>
                                </div>
                            </div>
                            <div class="notif my-1">
                                <div class="icon-box">
                                    <i class="fas fa-shop"></i>
                                </div>
                                <div class="infos py-3">
                                    <span class="fs-5">Browse more house shit fucked up.</span>
                                    <span class="fw-bold"><i class="fa-solid fa-circle"></i> &nbsp; 2d</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="see-product-modal">
        <div class="col-md-9 swiper mySwiper">

            <div class="close-product-modal">
                <i class="fas fa-close"></i>
            </div>

            <div class="logo">
                <a href="dashboard.php">
                    <img src="../public/images/campushpereblue.png" alt="logo" title="campushpere" />
                </a>
            </div>
            <div class="swiper-wrapper" id="4swiper">
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
        <div class="col-md-3 d-flex flex-column h-100 bg-white right-column-product-viewer">
            <h4 class="display-6 fw-bold py-2" id="4title">نضارة طبية 😍الحماية من أشعة الهاتف</h4>
            <h5 id="4price"> 0 DH</h5>
            <p class="text-muted" id="4location">
                Listed a week ago in مراكش, مراكش - آسفي
            </p>
            <h4 class="display-6 fw-bold py-2">Details</h4>
            <p class="details" id="4details">
                نضارة طبية بمناسبة عيد الفطر 😍
                من اجل الحماية من أشعة الهاتف ❤️
                ثمن مناسب 🔥🔥🔥
                توصيل بالمجان داخل مراكش 🛵🛵🛵
            </p>
            <hr>
            <h4 class="fw-bold py-2">
                Seller information
            </h4>
            <div class="product-user">
                <img src="" alt="Profile Image" class="img-circle bg-black" width="50px" height="50px"
                    id="4sellerImage">
                <p class="fw-bold" id="4username">Anas ben</p>
            </div>
            <p class="py-4 ms-3 fs-5">Joined campuSphere in 2023</p>
            <div class="product-sendMessage mt-auto py-2">
                <p class="text-muted ps-3 fs-5">
                    Send seller a message
                </p>
                <input type="text" class="form-control p-2" placeholder="Send a private messae">
                <button class="btn btn-primary my-2 p-2 w-100"> Send </button>
            </div>
        </div>
    </div>

    <?php include 'templates/listProduct.php'; ?>
</body>

</html>
