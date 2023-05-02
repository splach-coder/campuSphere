$(document).ready(function () {
    $('.data-type-display').click(function () {
        $('.data-type-display').each(function () {
            $(this).removeClass('active');
        })

        $(this).addClass('active');
    });

    $(".friends-153").click(function () {
        $.ajax({
            url: '../controller/friendshipController/getFriends.php',
            method: 'GET',
            success: function (data) {
                $(".friends-container-profile").children().eq(0).remove();
                data.forEach(e => {
                    $(".friends-container-profile").append(`
                    <div class="friend-triangle">
                        <div class="imgbx">
                            <a href="./profileVisit.php?id=${e.friend}"><img src="${e.user_image}" alt=""></a>
                        </div>
                        <div class="user-name">${e.fullname}</div>
                    </div>`);
                });
            },
            error: err => {
                console.log(err);
            }
        });
        $(".main-con").css('display', 'none');
        $(".friends-container-profile").css('display', 'flex');
    });

    $(".posts-153").click(function () {
        $(".main-con").css('display', 'flex');
        $(".friends-container-profile").css('display', 'none');
    });
});