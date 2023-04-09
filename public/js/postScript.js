$(document).ready(function () {
    const $container = $(".post-container");
    const $privacy = $container.find(".post .privacy");
    const $arrowBack = $container.find(".audience .arrow-back");
    const audienceNotWorking = ["Specific", "Custom"];
    const filesToUpload = [];

    $privacy.on("click", () => {
        $container.addClass("active");
    });

    $arrowBack.on("click", () => {
        $container.removeClass("active");
    });

    $(".audience ul li").click(function () {
        if (audienceNotWorking.includes($(this).attr("data-value"))) {
            //alert the message this features not working
        } else {
            setActiveToLists($(".audience ul li"), $(this));
            $("#audience").html($(this).attr("data-value"));
            $("#audience").attr("data-value", $(this).attr("data-value"));
            $arrowBack.click();
        }
    });

    $("#post-close-btn").click(function () {
        $(".post-modal").css("display", "none");
    });

    $(".new-post-con .input-holder").click(function () {
        openPostModal();
    });

    $(".new-post-con button").click(function () {
        openPostModal();
    });

    $("#createPost_navButton").click(function () {
        openPostModal();
    })

    $("#add-media").click(function () {
        if (!$(this).parent().hasClass("active")) {
            $(".media-area").css("display", "flex");
            $(this).parent().addClass("active");
            $(".post-container").css("height", "auto");
            $(".body-holder").animate({
                    scrollTop: $(".body-holder").prop("scrollHeight")
                },
                700
            );
        } else {
            $(".media-area").css("display", "none");
            $(this).parent().removeClass("active");
            $(".post-container").css("height", "440px");
        }
    });

    $("#close-media-area").click(function () {
        $(".media-area").css("display", "none");
        $("#add-media").parent().removeClass("active");
        $(".post-container").css("height", "440px");
        $(".slider").empty();
        filesToUpload.splice(0, filesToUpload.length);
        $("#post-button").removeClass('accepted');
    });


    /////the dragabble code
    // Prevent default drag behaviors
    ["dragenter", "dragover", "dragleave", "drop"].forEach((eventName) => {
        $(".media-area").on(eventName, function (e) {
            e.preventDefault();
            e.stopPropagation();
        });
    });

    // Highlight the container on drag over
    $(".media-area").on("dragenter", function () {
        $(this).addClass("hover");
    });

    // Remove the highlight on drag leave
    $(".media-area").on("dragleave", function () {
        $(this).removeClass("hover");
    });

    // handle the selected files from files explorer
    $("#post-media-file").on("change", function (event) {

        const files = event.target.files;
        //console.log(files);

        Array.from(files).forEach(function (file) {
            if (file.type.match("image.*")) {
                if (file.size <= 2 * 1024 * 1024) {
                    var reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = function (e) {
                        var img = $("<img>");
                        img.attr("src", e.target.result);
                        $(".slider").append(img);
                        filesToUpload.push(file);
                        $("#post-button").addClass('accepted');
                    };
                } else {
                    //alert the problem
                    alert('the image must be under 2 mega bytes');
                }
            } else if (file.type.match("video.*")) {
                if (file.size <= 5 * 1024 * 1024) {
                    var reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = function (e) {
                        var video = $("<video controls>");
                        video.attr("src", e.target.result);

                        // Wait for video metadata to load
                        video.on('loadedmetadata', function () {
                            // Check video duration
                            if (video[0].duration <= 60) {
                                $(".slider").append(video);
                                $("#post-button").addClass('accepted');
                                filesToUpload.push(file);
                            } else {
                                //alert the problem 
                                alert('the video must be under 1 min');
                            }
                        });
                    };
                } else {
                    alert('the video must be under 5 mega bytes');
                }
            } else {
                alert('the files must be .png / .jpg / .jpeg')
            }
        });

        $(".media-area").removeClass("hover");
    });

    // Handle the dropped files
    $(".media-area").on("drop", function (e) {
        $(this).removeClass("hover");
        var files = e.originalEvent.dataTransfer.files;

        // Loop through the files and create previews
        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            if (file.type.match("image.*")) {
                if (file.size <= 2 * 1024 * 1024) {
                    var reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = function (e) {
                        var img = $("<img>");
                        img.attr("src", e.target.result);
                        $(".slider").append(img);
                        filesToUpload.push(file);
                        $("#post-button").addClass('accepted');
                    };
                }
            } else if (file.type.match("video.*")) {
                if (file.size <= 5 * 1024 * 1024) {
                    var reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = function (e) {
                        var video = $("<video controls>");
                        video.attr("src", e.target.result);
                        // Wait for video metadata to load
                        video.on('loadedmetadata', function () {
                            // Check video duration
                            if (video[0].duration <= 60) {
                                $(".slider").append(video);
                                filesToUpload.push(file);
                                $("#post-button").addClass('accepted');
                            } else {
                                //alert the problem 
                                alert('the video must be under 1 min');
                            }
                        });
                    };
                }
            }
        }
        $(".body-holder").animate({
                scrollTop: $(".body-holder").prop("scrollHeight")
            },
            700
        );
    });


    $('#post_status').on('keyup', function () {
        if ($(this).val().length <= 0)
            $("#post-button").removeClass('accepted');
        else
            $("#post-button").addClass('accepted');
    });


    $("#post-button").click(function () {
        // Get references to the textarea and slider elements
        var myTextarea = $('#post_status');

        if ($(this).hasClass('accepted') && !$(this).hasClass('blocked')) {
            $(this).addClass('blocked');

            var data = new FormData();
            data.append('status', myTextarea[0].value);
            data.append('audience', $("#audience").attr('data-value'));
            for (let i = 0; i < filesToUpload.length; i++) {
                let file = filesToUpload[i];
                data.append('media[]', file);
            }

            console.log('test')
            $container.css('filter', 'blur(30px) grayscale(80%)');
            $(".loader").css("display", "block");

            setTimeout(function () {
                //Send the data to the server using AJAX
                $.ajax({
                    url: '../controller/postController/createPost.php',
                    method: 'POST',
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        console.log(response)
                        // Handle the response from the server here
                        if (response == "File uploaded successfully") {
                            $("#post-button").removeClass('blocked');
                            $("#post-button").removeClass('accepted');
                            resetPostCon();
                            showToast('success', 'toast-top-center', "post uploaded successfully");
                        }
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            }, 2500);
        }
    });

    function setActiveToLists(ul, li) {
        ul.each(function () {
            $(this).removeClass("active");
        });
        li.addClass("active");
    }

    function openPostModal() {
        $(".post-modal").css("display", "flex");
    }

    function resetPostCon() {
        $(".post-container").css('filter', 'none');
        $(".loader").css("display", "none");
        $(".post-modal").css("display", "none");
        $(".media-area").css("display", "none");
        $("#add-media").parent().removeClass("active");
        $(".post-container").css("height", "440px");
        $(".slider").empty();
        filesToUpload.splice(0, filesToUpload.length);
        $("#post-button").removeClass('accepted');
    }
});