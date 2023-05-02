$(document).ready(function () {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');

    $.ajax({
        url: '../controller/profile.php',
        type: 'GET',
        data: {
            id
        },
        success: (data) => {
            //get the main user data
            $("#cover-img").attr('src', data.cover);
            $("#user-fullname").html(data.fullname);
            $("#friends-number").html(data.friendsNumber + " friends");
            $("#user-profile-img").attr('src', data.image);
            $(".user-bio-content").html(data.bio);

            $.ajax({
                url: "../controller/profileSettings/getUserHobbies.php",
                type: 'GET',
                success: data => {
                    $(".hobbies-con").empty();
                    data.forEach(element => {
                        $(".hobbies-con").append(`<span data-id="${element.id}" class="hobbie-span"><i class="fas fa-${element.icon}"></i> ${element.name} <i class="fas fa-close remove-hobbie"> </i> </span>`);
                    });
                },
                error: err => console.log(err)
            })

            $("#profile-friends-circles").empty();
            data.friends.forEach(f => {
                $("#profile-friends-circles").append(`
                     <li data-friend-id="${f.id}" class="friend-circle"><img src="${f.image}" /></li>
                `);
            });

            $(".friend-circle").click(function () {
                window.location.href = "./profileVisit.php?id=" + $(this).attr("data-friend-id");
            });

            $(".user-photos-holder").empty();
            data.images.forEach(f => {
                $(".user-photos-holder").append(`
                    <img src="${f.url}" alt="" data-image-id="${f.id}" />
                `);
            });

            $(".user-friends-holder").empty();
            data.friends.forEach(f => {
                $(".user-friends-holder").append(`
                    <div class="friend-box" data-friend-id="${f.id}">
                        <img src="${f.image}" alt="" />
                        <a href="./profileVisit.php?id=${f.id}">${f.fullname}</a>
                    </div>
                `);
            });

            //set the vibrant
            const coverPic = $("#cover-img");
            const img = new Image();
            img.src = coverPic.attr('src'); // replace with your cover picture URL
            img.onload = function () {
                let vibrant = new Vibrant(img);
                let swatches = vibrant.swatches();
                $(".shadow").css("--main-color", swatches["Vibrant"].getHex());
            };

            getPosts('../controller/postController/getUserPosts.php?id=' + id, $(".col.user-posts"));
        },
        error: (xhr, status, error) => console.log(error),
    });


    $(window).on("scroll", function () {
        var navbar = $(".navbar");
        var navbarOffsetTop = navbar.offset().top;

        if ($(window).scrollTop() >= navbarOffsetTop) {
            navbar.addClass("fixed");
        } else {
            navbar.removeClass("fixed");
        }
    });

    $(".user-photos-holder").on('click', 'img', function () {
        $(".image-viewer-modal").css('display', 'flex');
        $('html, body').scrollTop(0);
        $("body").css('overflow', 'hidden');
        $("#img-viewer").attr('src', $(this).attr('src'));
    });

    $(".closeimageViewer").click(function () {
        $(".image-viewer-modal").css('display', 'none');
        $("body").css('overflow', 'auto');
        $("#img-viewer").attr('src', '');
    });
});