<div class="profile-con">
    <div class="profile-image-box">
        <a href="profile.php">
            <img src="../public/images/<?= $_SESSION['profile_pic'] ?>" alt="">
        </a>
    </div>
    <div class="profile-infos-con">
        <span class="full-name"><?= $_SESSION['fullname'] ?></span>
        <span class="user-name">@<?= $_SESSION['username'] ?></span>
    </div>
</div>