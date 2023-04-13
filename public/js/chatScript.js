$(document).ready(function () {
    $(".get-messages-center").click(function () {
        $(this).css("display", "none");
        $("#messages-side-bar").css("display", "block");


        $("#chat").animate({
            scrollTop: $("#chat").prop("scrollHeight")
        }, 1500);
    });

    $("#close-messages-center").click(function () {
        $("#messages-side-bar").css("display", "none");
        $(".get-messages-center").css("display", "flex");

        $("#chat").animate({
            scrollTop: 0
        }, 100);
    });

    //click 
    $(".contact").click(function () {

    });
});