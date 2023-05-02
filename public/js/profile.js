$(document).ready(function () {
    var fileToUpload;

    $('.hobbies-con').on('click', '.remove-hobbie', function () {
        // Code to execute when span is clicked
        const id = $(this).parent().attr('data-id');

        $.ajax({
            url: "../controller/profileSettings/removeAhobbie.php",
            type: 'POST',
            data: {
                id
            },
            success: data => {
                if (data) {
                    $(this).parent().remove();
                }
            },
            error: err => console.log(err)
        });
    });

    $.ajax({
        url: '../controller/profile.php',
        type: 'GET',
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

            getPosts('../controller/postController/currentUserPosts.php', $(".col.user-posts"));
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

    /*change the cover photo*/

    //edit-cover-photo
    $(".edit-cover-photo").click(function () {
        $("#cover-photo-btn").click();
    });

    $('#cover-photo-btn').change(function (e) {
        changeCoverImage($(this));
    });

    $('#image-upload').change(function (e) {
        changeCoverImage($(this));
    });

    function changeCoverImage(btn) {
        $('html, body').scrollTop(0);
        $(".modal_cover_456").css('display', 'flex');
        $("body").css('overflow', 'hidden');
        const file = btn[0].files[0];
        if (file.type.match("image.*")) {
            if (file.size <= 2 * 1024 * 1024) {
                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function (e) {
                    var img = $("#cover-photo-show");
                    img.attr('src', e.target.result);
                    fileToUpload = file;
                };
            } else {
                //alert the problem
                showToast('alert', 'toast-top-center', "he image must be under 2 mega bytes");
            }
        }
    }

    $('.upload-btn').click(function () {
        $('#image-upload').click();
    });

    $('.save-btn').click(function () {
        console.log(fileToUpload);
        $(".close-icon-modal-cover").css('display', 'none');

        var data = new FormData();
        data.append('file', fileToUpload);

        $(".loader").css("display", "block");

        setTimeout(function () {
            //Send the data to the server using AJAX
            $.ajax({
                url: '../controller/profileSettings/updateCover.php',
                method: 'POST',
                data: data,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log(response)
                    // Handle the response from the server here
                    if (response) {
                        showToast('success', 'toast-top-center', "image uploaded successfully");
                        $(".modal_cover_456").css('display', 'none');
                        $("body").css('overflow', 'auto');
                        $(".loader").css("display", "none");
                        $("#cover-img").attr('src', '../public/images/' + response);
                        $("#cover-photo-show").attr('src', "");
                        $(".close-icon-modal-cover").css('display', 'block');
                        fileToUpload = null;

                        //set the vibrant
                        const coverPic = $("#cover-img");
                        const img = new Image();
                        img.src = coverPic.attr('src'); // replace with your cover picture URL
                        img.onload = function () {
                            let vibrant = new Vibrant(img);
                            let swatches = vibrant.swatches();
                            $(".shadow").css("--main-color", swatches["Vibrant"].getHex());
                        };
                    }
                },
                error: function (err) {
                    console.log(err);
                }
            });
        }, 2500);
    });

    $(".close-icon-modal-cover").click(function () {
        $(".modal_cover_456").css('display', 'none');
        $("body").css('overflow', 'auto');
    });


    /*change the profile photo*/

    $("#edit-profile-photo").click(function () {
        $("#cover-profile-photo-btn").click();
    });

    $(".close-icon-modal-cirlce-cover").click(function () {
        $(".modal_cover_circle_456").css('display', 'none');
        $("body").css('overflow', 'auto');
    })

    $('#cover-profile-photo-btn').change(function (e) {
        changeProfileImage($(this));
    });

    $('#image-circle-upload').change(function (e) {
        changeProfileImage($(this));
    });

    function changeProfileImage(btn) {
        $('html, body').scrollTop(0);
        $(".modal_cover_circle_456").css('display', 'flex');
        $("body").css('overflow', 'hidden');
        const file = btn[0].files[0];
        if (file.type.match("image.*")) {
            if (file.size <= 2 * 1024 * 1024) {
                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function (e) {
                    var img = $("#profile-photo-show");
                    img.attr('src', e.target.result);
                    fileToUpload = file;
                };
            } else {
                //alert the problem
                showToast('alert', 'toast-top-center', "he image must be under 2 mega bytes");
            }
        }
    }

    $('.upload-circle-btn').click(function () {
        $('#image-circle-upload').click();
    });

    $('.save-circle-btn').click(function () {
        console.log(fileToUpload);
        $(".close-icon-modal-cirlce-cover").css('display', 'none');

        var data = new FormData();
        data.append('file', fileToUpload);

        $(".loader").css("display", "block");

        setTimeout(function () {
            //Send the data to the server using AJAX
            $.ajax({
                url: '../controller/profileSettings/updateProfileImage.php',
                method: 'POST',
                data: data,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log(response)
                    // Handle the response from the server here
                    if (response) {
                        showToast('success', 'toast-top-center', "image uploaded successfully");
                        $(".modal_cover_circle_456").css('display', 'none');
                        $("body").css('overflow', 'auto');
                        $(".loader").css("display", "none");
                        $("#user-profile-img").attr('src', '../public/images/' + response);
                        $("#profile-photo-show").attr('src', "");
                        $(".close-icon-modal-cirlce-cover").css('display', 'block');
                        fileToUpload = null;
                    }
                },
                error: function (err) {
                    console.log(err);
                }
            });
        }, 2000);
    });


    $("#editBioBtn").click(function () {
        $(this).css('pointer-events', 'none');
        var Current_bio = $(".user-bio-content").html();
        $(".user-bio-content").empty();
        $(".user-bio-content").append(`
            <textarea id="biotext" name="biotext" rows="4" cols="50" maxlength="200">
                ${Current_bio}
            </textarea>
            <div style='display: flex; justify-content: space-between;'> <p>max length 200</p> <button id="edit-bio-primary-button"> Save </button> </div>
        `);


        $("#edit-bio-primary-button").click(function () {
            const bio = $('#biotext').val();
            $.ajax({
                url: '../controller/editBio.php',
                method: 'POST',
                data: {
                    bio
                },
                success: (data) => {
                    if (data == "updated") {
                        $(".user-bio-content").empty();
                        $(".user-bio-content").append(`
                                ${bio}
                        `);
                        $("#editBioBtn").css('pointer-events', 'auto');
                    }
                },
                error: (error) => console.log(error)
            });
        });
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