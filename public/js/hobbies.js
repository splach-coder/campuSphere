$(document).ready(function () {
    const hobbies = [];
    const allHobbies = [];

    $("#hobbies-btn").click(function () {
        $(".hobbies-modal").css('display', 'flex');
        $('html, body').scrollTop(0);
        $("body").css('overflow', 'hidden');

        //get recomended hobbies
        $.ajax({
            url: "../controller/profileSettings/getPopulareHobbies.php",
            type: 'GET',
            success: data => {
                // Get the div element and all its spans
                var myDiv = $('.hobbies-icons-holder');
                var mySpans = myDiv.find('span');

                // Remove all the spans except the last one
                mySpans.not(':last').remove();

                var spans = ``;
                data.forEach(element => {
                    spans += `<span data-id="${element.id}" class="hobbie-span"><i class="fas fa-${element.icon}"></i> ${element.name}</span>`;
                });

                // Append new spans before the last span
                myDiv.children(':last').before(spans);

                //span click event
                $("span.hobbie-span").click(function () {
                    $(this).toggleClass("active");
                    const id = $(this).attr("data-id");

                    if ($(this).hasClass("active")) {
                        if (!hobbies.includes(id)) {
                            hobbies.push(id);
                        }
                    } else {
                        if (hobbies.includes(id)) {
                            const index = hobbies.indexOf(id);
                            if (index !== -1) {
                                hobbies.splice(index, 1);
                            }
                        }
                    }

                    if (hobbies.length > 0) {
                        $(".shit-buttons").addClass('active');
                    } else {
                        $(".shit-buttons").removeClass('active');
                    }
                });
            },
            error: err => console.log(err)
        });
    })


    $(".searchOthers").click(function () {
        $(".hobbies-holder").addClass("active");

        //get all hobbies
        $.ajax({
            url: "../controller/profileSettings/getHobbies.php",
            type: 'GET',
            success: data => {
                data.forEach(e => {
                    allHobbies.push(e);
                });
            },
            error: err => console.log(err)
        });
    });

    $(".hobbies-close").click(function () {
        $(".hobbies-holder").removeClass("active");
        $(".hobbies-modal").css("display", "none");
        $("body").css('overflow', 'auto');
    });


    $("#searchHobbie").on("input", function () {
        if ($(this).val().length > 0) {
            $(".results-hobbies span").text($(this).val());
            $(".results-hobbies").css("display", "flex");

            $(".searchesHobbies").empty();
            allHobbies.forEach(element => {
                if (element.name.toLowerCase().includes($(this).val().toLowerCase())) {
                    $(".searchesHobbies").append(`<span data-id="${element.id}" class="hobbie-span"><i class="fas fa-${element.icon}"></i> ${element.name}</span>`)
                }
            });

            //span click event
            $("span.hobbie-span").click(function () {
                $(this).toggleClass("active");
                const id = $(this).attr("data-id");

                if ($(this).hasClass("active")) {
                    if (!hobbies.includes(id)) {
                        hobbies.push(id);
                    }
                } else {
                    if (hobbies.includes(id)) {
                        const index = hobbies.indexOf(id);
                        if (index !== -1) {
                            hobbies.splice(index, 1);
                        }
                    }
                }

                if (hobbies.length > 0) {
                    $(".shit-shit-buttons").addClass('active');
                } else {
                    $(".shit-shit-buttons").removeClass('active');
                }
            });

        } else {
            $(".results-hobbies span").text("");
            $(".results-hobbies").css("display", "none");
            $(".searchesHobbies").empty();
        }
    });


    $("#cancel1").click(function () {
        cancel();
    });

    $("#cancel2").click(function () {
        cancel();
    });

    $("#save1").click(function () {
        save(hobbies);
    });

    $("#save2").click(function () {
        save(hobbies);
    });


    function cancel() {
        hobbies.length = 0;
        $("span.hobbie-span").each(function () {
            $(this).removeClass('active');
        })

        $(".results-hobbies span").text("");
        $(".results-hobbies").css("display", "none");
        $(".searchesHobbies").empty();
        $("#searchHobbie").val(' ');
        $(".shit-shit-buttons").removeClass('active');
        $(".shit-buttons").removeClass('active');
    }


    function save(hobbies) {
        $.ajax({
            url: "../controller/profileSettings/insertAhobbie.php",
            type: 'POST',
            data: {
                hobbies
            },
            success: data => {
                console.log(data);
                if (data) {
                    cancel();
                    $(".hobbies-close").click();
                    $.ajax({
                        url: "../controller/profileSettings/getUserHobbies.php",
                        type: 'GET',
                        success: data => {
                            $(".hobbies-con").empty();
                            data.forEach(element => {
                                $(".hobbies-con").append(`<span data-id="${element.id}" class="hobbie-span"><i class="fas fa-${element.icon}"></i> ${element.name} <i class="fas fa-close remove-hobbie"> </i> </span>`);
                            });
                        },
                        error: err => console.log(err)
                    });

                  
                }
            },
            error: err => console.log(err)
        })
    }
});