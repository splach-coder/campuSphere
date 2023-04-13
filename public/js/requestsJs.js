$(document).ready(function () {
    console.log('adsas')
    //get requests number
    $.ajax({
        url: '../controller/friendshipController/getRequestsNumber.php',
        type: 'GET',
        success: (data) => {
            $("#requests_number").html(data);
        },
        error: (error) => console.log(error),
    });

    //get friend requests
    getReqs('../controller/friendshipController/getRequests.php');
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


function getReqs(url) {
    return makeAjaxCall(url).then((data) => {
        if (data.length > 0) {
            $('.friends-req').children().eq(0).nextAll().remove();

            data.forEach(r => {
                $(".friends-req").append(requests(r.id, r.requester, r.fullname, r.user_image));
            });
        } else {
            $('.friends-req').append(`<div class="friend-request-con">
            <div class="friend-req-header">
                <p class="noreqs">No Requests now</p>
            </div>
            </div>`)
        }

        //accept a friend request
        $(".accept").click(function () {
            const id = $(this).parent().parent().parent().attr('data-request-id');
            $.ajax({
                url: '../controller/friendshipController/manipulateRequest.php',
                type: 'GET',
                data: {
                    request_id: id,
                    action: 'accept'
                },
                success: (data) => {
                    showToast('success', 'toast-top-center', data);
                    getReqs('../controller/friendshipController/getRequests.php');
                },
                error: (error) => console.log(error),
            });
        })

        //decline a friend request
        $(".decline").click(function () {
            const id = $(this).parent().parent().parent().attr('data-request-id');
            $.ajax({
                url: '../controller/friendshipController/manipulateRequest.php',
                type: 'GET',
                data: {
                    request_id: id,
                    action: 'decline'
                },
                success: (data) => {
                    showToast('success', 'toast-top-center', data);
                },
                error: (error) => console.log(error),
            });
        })
    });
}


function requests(id, requester, fullname, image) {
    return `<div class="friend-request-con" data-requester-id="${requester}" data-request-id="${id}">
    <div class="request first">
        <div class="upper">
            <div class="req-img-bx">
                <img src="${image}"
                    alt="">
            </div>
            <div class="req-img-infos">
                <span>${fullname}</span> Want to add you to friends
            </div>
        </div>
        <div class="req-btns">
            <button class="accept">Accept</button>
            <button class="decline">Decline</button>
        </div>
    </div>
</div>
`
}