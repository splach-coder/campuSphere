$(document).ready(function () {
    //get requests number
    $.ajax({
        url: '../controller/friendshipController/getFriendsNumber.php',
        type: 'GET',
        success: (data) => {
            $("#friends_number").html(data);
        },
        error: (error) => console.log(error),
    });

    //get friend requests
    getFriends('../controller/friendshipController/getFriends.php');
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

function getFriends(url) {
    return makeAjaxCall(url).then((data) => {
        if (data.length > 0) {
            $('.friends-list').children().eq(0).nextAll().remove();
            data.forEach(r => {
                $(".friends-list").append(friends(r.id, r.friend, r.fullname, r.user_image));
            });
        } else {
            $('.friends-list').append(`<div class="friends">
                <p class="noreqs">No Requests now</p>
            </div>`);
        }
    });
}


function friends(id, friend, fullname, image) {
    return `
    <div class="friends" data-friendship-id="${id}" data-friend-id="${friend}">
        <div class="friends-img-box">
            <img src="${image}" alt="">
        </div>
        <div class="friends-infos">${fullname}</div>
        <div class="friends-notif">2</div>
    </div>
`
}