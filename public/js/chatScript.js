$(document).ready(function () {
    getContacts('../controller/chat-controller/getContacts.php');

    setInterval(function () {
        getContacts('../controller/chat-controller/getContacts.php');
    }, 1000 * 60);

    $(".get-messages-center").click(function () {
        $(this).css("display", "none");
        $("#messages-side-bar").css("display", "block");
    });

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

function getContacts(url) {
    return makeAjaxCall(url).then((data) => {
        if ($(".contacts").children(".contact").length != data.length) {
            if (data.length > 0) {
                $(".contacts").children().eq(1).nextAll().remove();
                data.forEach(contact => {
                    $(".contacts").append(contactUI(contact.contact, contact.image, contact.fullname, contact.message, contact.online))
                });

                //click 
                $(".contact").click(function () {
                    setActiveForContact($(this));
                    let friend_id = $(this).attr("data-contact-id");
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
                                        friend_id: friend_id,
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
                });
            } else {
                $(".contacts").append('<div style="color: #999;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);width: 100%;text-align: center;"> no Contacts send message to some one </div>')
            }
        }
    });
}


function contactUI(contact, image, fullname, message, online) {
    let oc = (online) ? 'online' : '';
    let res = `<div class="contact" data-contact-id="${contact}">
    <div class="pic ${oc}" style="background-image:url('${image}');"></div>
    <div class="badge">
        1
    </div>
    <div class="name">
       ${fullname}
    </div>
    <div class="message">
        ${message}
    </div>
</div>`

    return res;
}


function chatUI(fullname, image, messages, lastSeen) {
    let res = `
    <div class="contact bar">
            <div class="pic stark" style='background-image: url("${image}");'></div>
            <div class="name">
                ${fullname}
            </div>
            <div class="seen">
                ${lastSeen}
            </div>
            <div class="fas fa-times" id="close-messages-center" title="close"></div>
    </div>`;

    res += `<div class="messages" id="chat">`
    if (messages.length > 0) {
        messages.forEach(msg => {
            res += `
            <!--div class="time">
                Today at 11:41
            </div-->
            <div class="message ${msg.sender}">
                ${msg.message}
            </div>`;
        });
    } else {
        res += `
        <p>
            say hello to your friend
        </p>`;
    }
    res += `
        <!--div class="message stark">
            <div class="typing typing-1"></div>
            <div class="typing typing-2"></div>
            <div class="typing typing-3"></div>
        </div-->
    </div>
    <div class="input">
        <i class="fas fa-camera"></i><i class="far fa-laugh-beam"></i><input placeholder="Type your message here!"
                type="text" id="message-input-short" /><i class="fa-solid fa-paper-plane" id="send-message"></i>
    </div>
    `;

    return res;
}

function setActiveForContact(contact) {
    $(".contact").each(function () {
        $(this).removeClass('active');
    });
    contact.addClass("active");
}