$(document).ready(function () {

    getPosts('../controller/postController/suggestsPosts.php');

    $(".posts-sort").click(function () {
        $(".posts-sort").each(function () {
            $(this).removeClass("active");
        });
        $(this).toggleClass('active');


        let type = $(this).attr('id');
        console.log(type)
        if (type == "populaire") {
            getPosts('../controller/postController/populairePosts.php');
        } else if (type == "suggestion") {
            getPosts('../controller/postController/suggestsPosts.php');
        }
    })

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

function getPosts(url) {
    return makeAjaxCall(url).then((data) => {
        posts = data;
        console.log(posts);
        $('.posts').empty();

        posts.forEach(post => {
            $('.posts').append(postLayout(post.has_media, post.post_id, post.user_id, post.user_name, post.user_image, post.status, post.likes_number, post.comments_number, post.shares_number, post.saves_number, post.date, post.post_media, post.likedByUser));
        });

        //add comments
        $(".addComment").click(function () {
            let comment = $(this).prev();
            let postId = $(this).parent().parent().attr('data-post-id');

            //add comments
            $.ajax({
                url: '../controller/postController/addComment.php',
                type: "POST",
                data: {
                    comment: comment.val(),
                    postId
                },
                success: function (data) {
                    console.log(data);
                    if (data) {
                        $(".comment-count").html(`${data} comments`);
                        showToast('success', 'toast-top-center', "comment uploaded successfully");

                        //clear the comment input
                        comment.val('');
                    }
                },
                error: function (err) {
                    console.log(err)
                }
            });
        });

        //init the swipper
        var swiper = new Swiper(".mySwiper", {
            pagination: {
                el: ".swiper-pagination",
                staticBullets: true,
            },
        });


        //send likes button
        $(".like-button").click(function () {
            let postId = $(this).parent().parent().parent().attr('data-post-id');

            $(this).toggleClass('active');
            let icon = $(this);
            let next = $(this).next();

            if ($(this).hasClass('active')) {
                //like the post
                $.ajax({
                    url: '../controller/postController/addLike.php',
                    type: "Post",
                    data: {
                        postId
                    },
                    success: function (data) {
                        icon.html(`<i class="fa-solid fa-heart"></i>`)
                        next.html(`${data} likes`);
                    },
                    error: function (err) {
                        console.log(err)
                    }
                });
            } else {
                //unlike the post
                $.ajax({
                    url: '../controller/postController/removeLike.php',
                    type: "Post",
                    data: {
                        postId
                    },
                    success: function (data) {
                        icon.html(`<i class="fa-regular fa-heart"></i>`)
                        next.html(`${data} likes`);
                    },
                    error: function (err) {
                        console.log(err)
                    }
                });
            }
        });

    }).catch((error) => {
        console.error(error);
    });
}


function postLayout(has_media, postID, userID, username, userImage, status, likes, comments, shares, saves, date, images, likedByUser) {
    let nomedia = "nomedia"
    if (has_media == "true") {
        nomedia = "";
    }

    let res = `<div class="post ${nomedia}" data-post-id="${postID}" data-user-id="${userID}">
    <div class="post-header">
        <div class="post-profile">
            <div class="post-profile-img">
                <img src="${userImage}" alt="">
            </div>
            <div class="post-profile-info">
                <span class="post-owner-username">
                    ${username}
                </span>
                <span class="post-owner-location">Upm</span>
            </div>
        </div>
        <div class="post-params"><i class="fa-solid fa-ellipsis" style="color: #000000;"></i></div>
    </div>`;

    if (has_media == "true") {
        res += `
        <div class="content-media">
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">`;
        images.forEach(img => {
            let media = (img.type == "image") ? `<img src="${img.media_url}" alt="">` : `<video src="${img.media_url}" controls autoplay>`;
            res += `
                <div class="swiper-slide">
                   ${media}
                </div>`;
        });
        res += `</div>
        <div class="swiper-pagination"></div>
    </div>
</div>`;
    } else {
        res += `<div class="content-bar">
        ${status}
      </div>`;
    }

    res += `
    <div class="interaction-bar">
        <div class="item">`;

    if (likedByUser) {
        res += `<button class="like-button active">
                <i class="fa-solid fa-heart"></i>
        </button> `;
    } else {
        res += `<button class="like-button">
                <i class="fa-regular fa-heart"></i>
        </button> `;
    }

    res += `<span class="like-count">${likes} likes</span>
        </div>
        <div class="item"> <button class="comment-button">
                <i class="fa-regular fa-comment-dots"></i>
            </button>
            <span class="comment-count">${comments} comments</span>
        </div>
        <div class="item"><button class="share-button">
                <i class="fa fa-share"></i>
            </button>
            <span class="share-count">${shares} shares</span>
        </div>
        <div class="item"><button class="save-button">
                <i class="fa fa-bookmark"></i>
            </button>
            <span class="save-count">${saves} saves</span>
        </div>
    </div>
    <div class="devider"></div>
    <div class="comment-bar">
        <input name="comment" class="comment commentInput" placeholder="Add a comment..." />
        <button class="addComment" type="submit">Comment</button>
    </div>
    <div class="date">
       ${date}
    </div>
</div>`;


    return res;
}