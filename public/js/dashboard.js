$(document).ready(function () {
    var globFile;

    $(window).on('scroll', function () {
        var navbar = $('.navbar');
        var navbarOffsetTop = navbar.offset().top;

        if ($(window).scrollTop() >= navbarOffsetTop) {
            navbar.addClass('fixed');
        } else {
            navbar.removeClass('fixed');
        }
    });


    // Prevent default drag behaviors
    ["dragenter", "dragover", "dragleave", "drop"].forEach((eventName) => {
        $(".modal-content").on(eventName, function (e) {
            e.preventDefault();
            e.stopPropagation();
        });
    });

    // Highlight the container on drag over
    $(".modal-content").on("dragenter", function () {
        $(this).addClass("hover");
    });

    // Remove the highlight on drag leave
    $(".modal-content").on("dragleave", function () {
        $(this).removeClass("hover");
    });

    // handle the selected files from files explorer
    $("#media-file").on("change", function (event) {
        const file = event.target.files[0];
        if (file.type.match("image.*")) {
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function (e) {
                var img = $("<img>");
                img.attr("src", e.target.result);
                $(".modal-content.second .body").append(img);
            };
        } else if (file.type.match("video.*")) {
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function (e) {
                var video = $("<video controls>");
                video.attr("src", e.target.result);
                $(".modal-content.second .body").append(video);
            };
        }
        globFile = file;
        $(".modal-content.second").css("display", "block");
    });

    // Handle the dropped files
    $(".modal-content").on("drop", function (e) {
        $(this).removeClass("hover");
        var files = e.originalEvent.dataTransfer.files;
        $(".modal-content.second").css("display", "block");
        // Loop through the files and create previews
        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            if (file.type.match("image.*")) {
                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function (e) {
                    var img = $("<img>");
                    img.attr("src", e.target.result);
                    $(".modal-content.second .body").append(img);
                };
            }
            // } else if (file.type.match("video.*")) {
            //     var reader = new FileReader();
            //     reader.readAsDataURL(file);
            //     reader.onload = function (e) {
            //         var video = $("<video controls>");
            //         video.attr("src", e.target.result);
            //         $(".modal-content.second .body").append(video);
            //     };
            // }

            globFile = file;
        }
    });



    /*open the modal*/
    // Get the modal and trigger button
    var modal = $("#myModal");
    var secondModal = $("#second-modal");
    var btn = $("#addStory");
    var back = $("#back");
    var nextBtn = $("#nextbtn");

    // Get the <span> element that closes the modal
    var span = $(".close");
    var cancel = $("#cancel");
    var discard = $("#discard");

    // When the user clicks on the button, open the modal
    btn.click(function () {
        modal.css("display", "block");
        $("body").css("background-color", "rgba(0,0,0,0.6)");
    });

    back.click(function () {
        secondModal.css("display", "block");
        $("body").css("background-color", "rgba(0,0,0,0.6)");
    });

    //when the user discard all his changes
    discard.click(function () {
        discardChanges();
    });

    // When the user clicks on <span> (x), close the modal
    span.click(function () {
        modal.css("display", "none");
        $("body").css("background-color", "white");
    });

    cancel.click(function () {
        secondModal.css("display", "none");
        $("body").css("background-color", "white");
    });

    // When the user clicks anywhere outside of the modal, close it
    $(window).click(function (event) {
        if (event.target == modal[0]) {
            modal.css("display", "none");
            $("body").css("background-color", "white");
        }
    });

    //when the user clicks in next button
    nextBtn.click(function () {
        discardChanges();
        $(".loader").css("display", "block");
        console.log(globFile);
        addStory(globFile);
    });
});

function discardChanges() {
    $(".modal-content.second .body").empty();
    $(".modal-content.second").css("display", "none");
    $(".modal").css("display", "none");
    $("body").css("background-color", "white");
}

function addStory(file) {
    // sanitize file input with DOMPurify
    const sanitizedFile = DOMPurify.sanitize(file.name);
    const fileType = file.type.split('/')[0]; // get the file type (e.g. 'image' or 'video')

    if (fileType == "image") {
        // validate file input with jQuery
        if (file.type !== 'image/jpeg' && file.type !== 'image/png') {
            alert('Only JPEG and PNG images are allowed');
        } else if (file.size > 2 * 1024 * 1024) {
            alert('File size cannot exceed 5MB');
        } else {
            // file input is valid
            const fileObject = {
                file: file,
                fileName: sanitizedFile,
                fileType: fileType
            };

            const formData = new FormData();
            formData.append('file', fileObject.file);
            formData.append('fileName', fileObject.fileName);
            formData.append('fileType', fileObject.fileType);

            $.ajax({
                url: '../controller/createStory.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    // handle success response from server
                    console.log(response);
                    $(".loader").css("display", "none");
                },
                error: function (xhr, status, error) {
                    // handle error response from server
                    console.log(error);
                }
            });
        }
    } else {
        alert("sorry but we accept just images we're working no this feature soon")
    }
}