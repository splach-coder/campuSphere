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

            //pop for friends
            $(".friends").click(function () {
                $(this).children(".popup").toggleClass("show");
            });

            $(".popup button").click(function () {
                let id = $(this).attr('data-friend-id')
                if ($(this).hasClass('send-message-button')) {
                    $(".get-messages-center").click();

                    $.ajax({
                        url: '../controller/chat-controller/getMessages.php',
                        type: 'POST',
                        data: {
                            friend_id: id
                        },
                        success: (data) => {
                            $("#chat-con").empty();
                            $("#chat-con").append(chatUI(data.fullname, data.image, data.chat, data.lastSeen));
                            $("#chat").animate({
                                scrollTop: $("#chat").prop("scrollHeight")
                            }, 500);

                            $("#close-messages-center").click(function () {
                                $("#messages-side-bar").css("display", "none");
                                $(".get-messages-center").css("display", "flex");
                                $("#chat-con").empty();
                                $("#chat-con").append(`<div class="fas fa-times" id="close-messages-center" title="close"></div> <div class="chat free">
                            <img src="../public/images/campushpereblue.png" alt="">
                            <p>Envoyez et recevez des messages.</p>
                        </div>`);
                                $("#chat").animate({
                                    scrollTop: 0
                                }, 100);
                            });

                            //send message
                            $("#send-message").click(function () {
                                let message = $("#message-input-short").val();

                                $.ajax({
                                    url: '../controller/chat-controller/sendMessage.php',
                                    type: 'POST',
                                    data: {
                                        friend_id: id,
                                        message: message
                                    },
                                    success: (data) => {
                                        $("#message-input-short").val('');
                                        $.ajax({
                                            url: '../controller/chat-controller/getMessages.php',
                                            type: 'POST',
                                            data: {
                                                friend_id
                                            },
                                            success: (data) => {
                                                $("#chat-con").empty();
                                                $("#chat-con").append(chatUI(data.fullname, data.image, data.chat, data.lastSeen));
                                                $("#chat").animate({
                                                    scrollTop: $("#chat").prop("scrollHeight")
                                                }, 0);
                                                getContacts('../controller/chat-controller/getContacts.php');
                                            }
                                        })
                                    },
                                    error: (xhr, status, error) => console.log(error),
                                });
                            });
                        },
                        error: (xhr, status, error) => console.log(error),
                    });
                }
            })

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

        <div class="popup" id="popup">
            <i class="fa-solid fa-caret-up"></i>
            <button data-friend-id="${friend}" class="send-message-button"><i class="fa-solid fa-user"></i> Send message</button>
            <button data-friend-id="${friend}" class="show-profile-button">
            <a href="./profileVisit.php?id=${friend}"><i class="fa-solid fa-message"></i> Show profile</a>
            </button>
        </div>
    </div>
`
}