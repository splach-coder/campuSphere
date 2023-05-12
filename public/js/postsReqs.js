$(document).ready(function () {

    getPosts('../controller/postController/suggestsPosts.php', $('.posts'));

    $(".posts-sort").click(function () {
        $(".posts-sort").each(function () {
            $(this).removeClass("active");
        });
        $(this).toggleClass('active');


        let type = $(this).attr('id');
        console.log(type)
        if (type == "populaire") {
            getPosts('../controller/postController/populairePosts.php', $('.posts'));
        } else if (type == "suggestion") {
            getPosts('../controller/postController/suggestsPosts.php', $('.posts'));
        }
    });

    $("#close-comments-modal").click(function () {
        $(".post-content-modal").css('display', 'none');
        $("body").css('overflow', 'auto');
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

function getPosts(url, posts_var) {
    return makeAjaxCall(url).then((data) => {
        console.log(data);
        posts = data;
        posts_var.empty();
        posts.forEach(post => {
            posts_var.append(postLayout(post.has_media, post.post_id, post.user_id, post.user_name, post.user_image, post.status, post.likes_number, post.comments_number, post.shares_number, post.saves_number, post.date, post.post_media, post.likedByUser));
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

        $(".addCommentInsideModal").click(function () {
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
                        $("#comments-number").html(`${data} comments`);
                        showToast('success', 'toast-top-center', "comment uploaded successfully");
                        showPost(postId);
                        //clear the comment input
                        comment.val('');
                    }
                },
                error: function (err) {
                    console.log(err)
                }
            });
        })

        //init the swipper
        var swiper = new Swiper(".mySwiper", {
            pagination: {
                el: ".swiper-pagination",
                staticBullets: true,
            },
        });

        $(".comment-button").click(function () {
            fillCommentsModal($(this));
            showPost($(this).parent().parent().parent().attr('data-post-id'));
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
                <a href="./profileVisit.php?id=${userID}">
                    <img src="${userImage}" alt="">
                </a>
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
        <p>${status}</p>
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

function showPost(id) {
    $.ajax({
        url: "../controller/postController/getComments.php",
        method: 'GET',
        data: {
            id
        },
        success: (data) => {
            $(".post-content-modal").css('display', 'block');
            $("body").css('overflow', 'hidden');
            $("#comments-").children().eq(1).nextAll().remove();
            data.forEach(e => {
                $("#comments-").append(`
                <div class="commented-section mt-2 mb-2" data-comment-id="${e.id}">
                    <div class="d-flex flex-row align-items-center commented-user">
                        <img class="img-fluid img-responsive rounded-circle mr-2 me-2"
                            src="${e.user_image}" width="32">
                        <h5 class="mr-2">${e.user_name}</h5><span class="dot mb-1"></span><span class="mb-1 ml-2">${e.date}</span>
                    </div>
                    <div class="comment-text-sm py-2"><span  class="text-muted ms-2">${e.content}</span></div>
                    <div class="reply-section">
                        <div class="d-flex flex-row align-items-center voting-icons ms-2">
                            <i class="fa-regular fa-heart like-icon-btn" data-comment-id="${e.id}" style="font-size: 14px;"></i>
                            <span class="ms-2">${e.likes}</span>
                            <span class="dot ml-2"></span>
                            <h6 class="ml-2 mt-1 reply" data-comment-id="${e.id}" style="cursor: pointer;">${e.replies} Replies</h6>
                        </div>
                    </div>
                </div>
                <hr>
                `);
            });

            $(".reply").click(function () {
                $(this).toggleClass('active');
                if ($(this).hasClass('active')) {
                    $(".replies").remove();
                    return;
                }
                let commentID = $(this).attr('data-comment-id');
                $.ajax({
                    url: "../controller/postController/getReplies.php",
                    method: 'GET',
                    data: {
                        id: commentID
                    },
                    success: data => {
                        $(".replies").remove();
                        let res = `<div class="replies">`;
                        data.forEach(e => {
                            res += `
                                <div class="d-flex flex-row align-items-center commented-user" data-reply-id="${e.id}">
                                    <h5 class="mr-2" data-user-id="${e.user_id}">${e.user_name}</h5><span class="dot mb-1"></span><span class="mb-1 ml-2">${e.date}</span>
                                </div>
                                <div class="comment-text-sm"><span class="text-muted ms-2">${e.content}</span></div>
                                <hr>                           
                            `;
                        });
                        res += `<div class="d-flex flex-row add-comment-section mt-4 mb-4">
                        <input type="text" class="form-control mr-3" placeholder="Add reply">
                        <button class="btn btn-primary ms-1 reply-button" type="button">Reply</button>
                         </div>
                         </div>`;

                        $(this).parent().parent().append(res);

                        $(".reply-button").click(function () {
                            let comment = $(this).prev();
                            let reply = $(this).parent().parent().prev().find(".reply").click();

                            //add comments
                            $.ajax({
                                url: '../controller/postController/addReply.php',
                                type: "POST",
                                data: {
                                    comment: comment.val(),
                                    id: commentID
                                },
                                success: function (data) {
                                    console.log(data);
                                    if (data) {

                                        showToast('success', 'toast-top-center', "reply uploaded successfully");
                                        reply.click();
                                        reply.text(data + " Replies")

                                        //clear the comment input
                                        comment.val('');

                                    }
                                },
                                error: function (err) {
                                    console.log(err)
                                }
                            });

                        });
                    },
                    error: (err) => console.log(err)
                });
            });

            //send likes button
            $(".like-icon-btn").click(function () {
                let commentID = $(this).attr('data-comment-id');

                let icon = $(this);
                let next = $(this).next();

                $(this).toggleClass('active');

                if ($(this).hasClass('active')) {
                    //like the post
                    $.ajax({
                        url: '../controller/postController/addLikeComment.php',
                        type: "Post",
                        data: {
                            id: commentID
                        },
                        success: function (data) {
                            icon.attr('class', `fa-solid fa-heart like-icon-btn active`);
                            next.html(`${data}`);
                        },
                        error: function (err) {
                            console.log(err)
                        }
                    });
                } else {
                    //unlike the post
                    $.ajax({
                        url: '../controller/postController/removeLikeComment.php',
                        type: "Post",
                        data: {
                            id: commentID
                        },
                        success: function (data) {
                            icon.attr('class', `fa-regular fa-heart like-icon-btn`);
                            next.html(`${data}`);
                        },
                        error: function (err) {
                            console.log(err)
                        }
                    });
                }
            });

        },
        error: (err) => console.log(err)
    });
}

function fillCommentsModal(e) {
    $("#comments-").attr('data-post-id', e.parent().parent().parent().attr('data-post-id'));
    $("#comments-number").html(e.next().text()); //get comments
    $("#post-date-modal").html(e.parent().parent().parent().children(".date").text());
    $("#post-username-author").html(`(${ e.parent().parent().parent().children(".post-header").children(".post-profile").children('.post-profile-info').children('.post-owner-username').text()})`);
    $("#post-image-author").attr('src', e.parent().parent().parent().children(".post-header").children(".post-profile").children('.post-profile-img').children('img').attr('src'))
}