<?php
  require_once '../../auth/forwardAuthentication.php';
?>
<html>

<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="../../public/icons/campushpere.ico" />
    <title>campuSphere: Sign in</title>

    <!-- link the bootstrap -->
    <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css" />

    <!-- link the css files -->
    <link rel="stylesheet" type="text/css" href="../../public/css/loginStyle.css">

    <!-- link the js files -->
    <script src="../../public/js/loginScript.js">

    </script>
</head>

<body>
    <div class=" login-root">
        <div class="box-root flex-flex flex-direction--column" style="min-height: 100vh;flex-grow: 1;">
            <div class="loginbackground box-background--white padding-top--64">
                <div class="loginbackground-gridContainer">
                    <div class="box-root flex-flex" style="grid-area: top / start / 8 / end;">
                        <div class="box-root"
                            style="background-image: linear-gradient(white 0%, rgb(247, 250, 252) 33%); flex-grow: 1;">
                        </div>
                    </div>
                    <div class="box-root flex-flex" style="grid-area: 4 / 2 / auto / 5;">
                        <div class="box-root box-divider--light-all-2 animationLeftRight tans3s" style="flex-grow: 1;">
                        </div>
                    </div>
                    <div class="box-root flex-flex" style="grid-area: 6 / start / auto / 2;">
                        <div class="box-root box-background--blue800" style="flex-grow: 1;"></div>
                    </div>
                    <div class="box-root flex-flex" style="grid-area: 7 / start / auto / 4;">
                        <div class="box-root box-background--blue animationLeftRight" style="flex-grow: 1;"></div>
                    </div>
                    <div class="box-root flex-flex" style="grid-area: 8 / 4 / auto / 6;">
                        <div class="box-root box-background--gray100 animationLeftRight tans3s" style="flex-grow: 1;">
                        </div>
                    </div>
                    <div class="box-root flex-flex" style="grid-area: 2 / 15 / auto / end;">
                        <div class="box-root box-background--cyan200 animationRightLeft tans4s" style="flex-grow: 1;">
                        </div>
                    </div>
                    <div class="box-root flex-flex" style="grid-area: 3 / 14 / auto / end;">
                        <div class="box-root box-background--blue animationRightLeft" style="flex-grow: 1;"></div>
                    </div>
                    <div class="box-root flex-flex" style="grid-area: 4 / 17 / auto / 20;">
                        <div class="box-root box-background--gray100 animationRightLeft tans4s" style="flex-grow: 1;">
                        </div>
                    </div>
                    <div class="box-root flex-flex" style="grid-area: 5 / 14 / auto / 17;">
                        <div class="box-root box-divider--light-all-2 animationRightLeft tans3s" style="flex-grow: 1;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-root padding-top--24 flex-flex flex-direction--column" style="flex-grow: 1; z-index: 9;">
                <div class="box-root padding-top--48 padding-bottom--24 flex-flex flex-justifyContent--center">
                    <h1><a href="#" rel="dofollow">campuSphere</a></h1>
                </div>
                <div class="formbg-outer">
                    <div class="formbg">
                        <div class="formbg-inner padding-horizontal--48">
                            <span class="padding-bottom--15">Sign in to your account</span>
                            <form id="stripe-login" method="post" action="../../controller/reset_password.php"
                                onsubmit="return validateForm()">
                                <?php if(isset($_GET['message']) && isset($_GET['type'])){?>
                                <div class="alert alert-<?=$_GET['type']?>" role="alert">
                                    <?= $_GET['message']?>
                                </div>
                                <?php }?>
                                <div class="field padding-bottom--24">
                                    <label for="email">email</label>
                                    <input type="email" id="email" name="email">
                                </div>
                                <div class="field padding-bottom--24">
                                    <input type="submit" name="submit" value="Continue">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="footer-link padding-top--24">
                        <span>Don't have an account? <a href="">Sign up</a></span>
                        <div class="listing padding-top--24 padding-bottom--24 flex-flex center-center">
                            <span><a href="#">© Stackfindover</a></span>
                            <span><a href="#">Contact</a></span>
                            <span><a href="#">Privacy & terms</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- implement jquery and bootstrap -->
    <script src="../../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
</body>

</html>
