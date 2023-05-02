$(document).ready(function () {
    const images = [];
    var id;

    $(".hobbies-close").click(function () {
        $(".wrapper-product").removeClass("active");
        $(".add-product-modal").css("display", "none");
        images.length = 0;
        $("#drop-box").empty();
        $("#drop-box").html(`<div class="zwa9">
        <i class="fa-solid fa-file-circle-plus"></i>
        <p>Drop your images here</p>
    </div>`);
        $('body').css('overflow', 'auto');
    });

    $("#icon-left").click(function () {
        $(".wrapper-product").removeClass("active");
    })

    $("#drop-box").on("dragover", function (e) {
        e.preventDefault();
        $(this).addClass("hover");
    });

    $("#drop-box").on("dragleave", function (e) {
        e.preventDefault();
        $(this).removeClass("hover");
    });

    $("#next-btn").click(function () {
        $(".wrapper-product").addClass("active");
    });

    $("#category-product").change(function () {
        id = $(this).val();
    });

    $("#list-product-final123").click(function () {

        // validate user inputs
        var title = $("#title").val();
        var price = $("#price").val();
        var details = $("#details").val();

        if (title == "" || price == "" || category == "" || details == "" || images.length == 0) {
            showToast('error', 'toast-top-center', "Please fill all required fields and select at least one image.");
            return false;
        }

        // create FormData object
        var data = new FormData();
        data.append("title", title);
        data.append("price", price);
        data.append("category", id);
        data.append("details", details);
        for (var i = 0; i < images.length; i++) {
            var file = images[i];
            data.append("images[]", file);
        }

        $(this).prop("disabled", true); // disable the button
        $(this).html("<i class='fa fa-spinner fa-spin'></i> Submitting..."); // change the button text to a loader

        // send AJAX request
        $.ajax({
            url: "../controller/marketplace/createProduct.php",
            type: "POST",
            data: data,
            processData: false, // tell jQuery not to process the data
            contentType: false, // tell jQuery not to set contentType
            success: function (response) {
                if (response) {
                    $(this).prop("disabled", false); // disable the button
                    $(this).html("List Produit");
                    $(".hobbies-close").click();

                }
            },
            error: function (xhr, textStatus, errorThrown) {
                // handle error
                console.log(xhr.responseText);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
    });

    function handleDrop(e) {
        e.preventDefault();
        $(this).removeClass("hover");
        $(".zwa9").css("display", "none");
        $("#next-btn").css("display", "block")

        var files = e.originalEvent.dataTransfer.files;

        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            var fileType = file.type.toLowerCase();

            if ($.inArray(fileType, ["image/jpg", "image/jpeg", "image/png"]) != -1) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    var preview = $('<div class="preview"></div>');
                    var image = $("<img>").attr("src", e.target.result);
                    var remove = $('<i class="fas fa-close"></i>');

                    remove.click(function () {
                        $(this).parent(".preview").remove();
                        images.splice($.inArray(file, images), 1);
                        $("#len").html(`${images.length} / 9`);
                        enableDrop();
                    });

                    preview.append(image).append(remove);
                    $("#drop-box").append(preview);

                    images.push(file);

                    $("#len").html(`${images.length} / 9`);

                    if (images.length >= 9) {
                        disableDrop();
                    }
                };

                reader.readAsDataURL(file);
            } else {
                alert("Please drop only image files of type JPG, JPEG, or PNG.");
            }
        }
    }

    function enableDrop() {
        $("#drop-box").on("drop", handleDrop);
        $("#drop-box").removeClass("full");
        $("#maxFiles").css('display', 'none')
    }

    function disableDrop() {
        $("#drop-box").off("drop");
        $("#drop-box").addClass("full");
        $("#maxFiles").css('display', 'block')
    }

    enableDrop();
});