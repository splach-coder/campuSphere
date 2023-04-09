$(document).ready(function () {
    myFunction('../controller/getStories.php');

    $(".story-viewer").each(function () {
        $(this).append(`<span class="heart" style="position: absolute; bottom: 50px; right: 50px;"><i class="fa-regular fa-heart fa-2xl"></i></span>`);

        $(".heart").click(function () {
            if ($(this).hasClass("liked")) {
                $(this).html('<i class="fa-regular fa-heart fa-2xl">');
                $(this).removeClass("liked");
            } else {
                $(this).html('<i class="fa-solid fa-heart active fa-2xl"></i>');
                $(this).addClass("liked");
            }
        });
    });
});


function makeAjaxCall(url) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: url,
            type: 'GET',
            success: (data) => resolve(data),
            error: (xhr, status, error) => reject(error),
        });
    });
}

function myFunction(url) {
    return makeAjaxCall(url).then((data) => {
        stories = data;
       
        initializeZuck(stories)
    }).catch((error) => {
        console.error(error);
    });
}

function initializeZuck(stories) {
    var config = {
        skin: "snapssenger",
        backNative: true,
        previousTap: true,
        autoFullScreen: false,
        avatars: true,
        list: false,
        cubeEffect: true,
        localStorage: true,
        stories: stories,
    };

    var storiesContainer = document.getElementById("stories");
    var stories = Zuck(storiesContainer, config);
}