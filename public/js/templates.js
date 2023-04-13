$(document).ready(function () {
    $(".sidebar a").click(function () {
        $(".sidebar a").each(function () {
            $(this).removeClass("active");
        });

        $(this).toggleClass("active");
    })
})