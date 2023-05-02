$(document).ready(function () {
    //get categories
    $.ajax({
        url: '../controller/marketplace/getCategories.php',
        method: 'get',
        success: function (data) {
            $(".Categories").empty();

            data.forEach(e => {
                $(".Categories").append(category(e.id, e.name, e.icon))
            });

            $(".categories-section").click(function () {
                $('html, body').animate({
                    scrollTop: 0
                }, 'fast');
                const id = $(this).attr('data-id');

                //get produits
                $.ajax({
                    url: '../controller/marketplace/getProduitsByCategory.php',
                    method: 'get',
                    data: {
                        id
                    },
                    success: function (data) {
                        console.log(data);
                        $(".card-holder").empty();

                        data.forEach(e => {
                            $(".card-holder").append(product(e.id, e.name, e.price, e.image, e.location));
                        });

                        $(".card").click(function () {
                            $(".see-product-modal").css('display', 'flex');
                            $("body").css('overflow', 'hidden');
                        });
                    },
                    error: err => console.log(err)
                });
            });
        },
        error: err => console.log(err)
    });

    //get produits
    $.ajax({
        url: '../controller/marketplace/getProduits.php',
        method: 'get',
        success: function (data) {
            console.log(data);
            $(".card-holder").empty();

            data.forEach(e => {
                $(".card-holder").append(product(e.id, e.name, e.price, e.image, e.location));
            });

            $(".card").click(function () {
                $('html, body').animate({
                    scrollTop: 0
                }, 'fast');
                const id = $(this).attr('data-id');
                $(".see-product-modal").css('display', 'flex');
                $("body").css('overflow', 'hidden');

                $.ajax({
                    url: '../controller/marketplace/getProduct.php',
                    method: 'get',
                    data: {
                        id
                    },
                    success: function (data) {
                        console.log(data);
                        $("#4title").html(data.title);
                        $("#4price").html(data.prix + " DH");
                        $("#4location").html("Listed a " + data.date + ' in ' + data.location);
                        $("#4details").html(data.description);
                        $("#4sellerImage").attr('src', data.image);
                        $("#4username").html(data.username);

                        $("#4swiper").empty();

                        data.images.forEach(function (e) {
                            $("#4swiper").append(`<div class='swiper-slide'>
                                <img src='${e.url}' data-id='${e.id}' alt=''>
                            <div>`)
                        })
                    },
                    error: (data) => console.log(data)
                })

            });
        },
        error: err => console.log(err)
    });

    var swiper = new Swiper(".mySwiper", {
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });

    $(".market-section").click(function () {
        $(".market-section").each(function () {
            $(this).removeClass("active");
        });

        $(this).addClass("active");
    });

    $("#browseALL").click(function () {
        $(".row789").removeClass('d-none');
        $(".row456").addClass('d-none');
        //get produits
        $.ajax({
            url: '../controller/marketplace/getProduits.php',
            method: 'get',
            success: function (data) {
                console.log(data);
                $(".card-holder").empty();

                data.forEach(e => {
                    $(".card-holder").append(product(e.id, e.name, e.price, e.image, e.location));
                });

                $(".card").click(function () {
                    $('html, body').animate({
                        scrollTop: 0
                    }, 'fast');
                    const id = $(this).attr('data-id');
                    $(".see-product-modal").css('display', 'flex');
                    $("body").css('overflow', 'hidden');

                    $.ajax({
                        url: '../controller/marketplace/getProduct.php',
                        method: 'get',
                        data: {
                            id
                        },
                        success: function (data) {
                            console.log(data);
                            $("#4title").html(data.title);
                            $("#4price").html(data.prix + " DH");
                            $("#4location").html("Listed a " + data.date + ' in ' + data.location);
                            $("#4details").html(data.description);
                            $("#4sellerImage").attr('src', data.image);
                            $("#4username").html(data.username);

                            $("#4swiper").empty();

                            data.images.forEach(function (e) {
                                $("#4swiper").append(`<div class='swiper-slide'>
                                <img src='${e.url}' data-id='${e.id}' alt=''>
                            <div>`)
                            })
                        },
                        error: (data) => console.log(data)
                    })

                });
            },
            error: err => console.log(err)
        });
    });

    $("#notifications").click(function () {
        $(".row789").addClass('d-none');
        $(".row456").removeClass('d-none');

        $.ajax({
            url: '../controller/marketplace/getNotifications.php',
            method: 'get',
            success: function (data) {
                $(".notif-wrapper").empty();

                data.forEach(function (e) {
                    $(".notif-wrapper").append(`
                        <div class="notif my-1" data-id="${e.id}">
                            <div class="icon-box">
                                <i class="fas fa-shop"></i>
                            </div>
                            <div class="infos py-3">
                                <span class="fs-5">${e.text}</span>
                                <span class="fw-bold"><i class="fa-solid fa-circle"></i> &nbsp; ${e.date}</span>
                            </div>
                        </div>
                    `)
                })
            },
            error: err => console.log(err)
        })
    })

    $(".createProduct").click(function () {
        $('html, body').animate({
            scrollTop: 0
        }, 'fast');
        $(".add-product-modal").css('display', 'flex');
        $('body').css('overflow', 'hidden');



        //get categories
        $.ajax({
            url: '../controller/marketplace/getCategories.php',
            method: 'get',
            success: function (data) {
                $("#category-product").children().eq(0).nextAll().remove();

                data.forEach(e => {
                    $("#category-product").append(`<option value='${e.id}'>${e.name}</option>`);
                });
            },
            error: err => console.log(err)
        });
    });

    $(".close-product-modal").click(function () {
        $(".see-product-modal").css('display', 'none');
        $("body").css('overflow-y', 'auto');
    });

    /*sort searchees */
    $('#market-search-input').on('input', function () {
        var inputValue = $(this).val();

        if (inputValue.length > 0) {
            $(".search-history-products").addClass('show');
            //send an ajax to get searches
            searchesA(inputValue);
        } else {
            $(".search-history-products").removeClass('show');
        }
    });

    $('#searchbar').focus(function () {
        var inputValue = $(this).val();
        if (inputValue.length > 0) {
            $(".search-history-products").addClass('show');
        }
    });

    $('#searchbar').blur(function () {
        var inputValue = $(this).val();
        if (inputValue.length <= 0) {
            $(".search-history-products").removeClass('show');
        }
    });
});


function category(id, name, icon) {
    return `
    <div class="categories-section" data-id="${id}">
        <i class="fas ${icon}"></i>
        ${name}
    </div>
    `;
}

function product(id, name, price, image, location) {
    return `
        <div class="card" data-id="${id}">
            <div class="card-img-box">
                <img src="${image}" alt="">
            </div>
            <div class="card-price">
                ${price} DH
            </div>
            <div class="card-infos">
                ${name}
            </div>
            <div class="card-location">
                ${location}
            </div>
        </div>
    `;
}

function searchesA(input) {
    //get produits
    $.ajax({
        url: '../controller/marketplace/getProduitsNames.php',
        method: 'GET',
        data: {
            str: input
        },
        success: function (data) {
            console.log(data);
            $(".search-history-products").empty();

            data.forEach(function (e) {
                $(".search-history-products").append(` 
                    <div class="search-product" data-id="${e.id}">
                        <i class="fas fa-search"></i>
                        ${e.str}
                    </div>
                `)
            });


            $(".search-product").click(function () {
                let str = $(this).text().trim();
                console.log(str);
                $.ajax({
                    url: '../controller/marketplace/getProduitsByNames.php',
                    method: 'GET',
                    data: {
                        str
                    },
                    success: function (data) {
                        $(".card-holder").empty();
                        $(".search-history-products").removeClass('show');

                        data.forEach(e => {
                            $(".card-holder").append(product(e.id, e.name, e.price, e.image, e.location));
                        });

                        $(".card").click(function () {
                            $('html, body').animate({
                                scrollTop: 0
                            }, 'fast');
                            const id = $(this).attr('data-id');
                            $(".see-product-modal").css('display', 'flex');
                            $("body").css('overflow', 'hidden');

                            $.ajax({
                                url: '../controller/marketplace/getProduct.php',
                                method: 'get',
                                data: {
                                    id
                                },
                                success: function (data) {
                                    console.log(data);
                                    $("#4title").html(data.title);
                                    $("#4price").html(data.prix + " DH");
                                    $("#4location").html("Listed a " + data.date + ' in ' + data.location);
                                    $("#4details").html(data.description);
                                    $("#4sellerImage").attr('src', data.image);
                                    $("#4username").html(data.username);

                                    $("#4swiper").empty();

                                    data.images.forEach(function (e) {
                                        $("#4swiper").append(`<div class='swiper-slide'>
                                <img src='${e.url}' data-id='${e.id}' alt=''>
                            <div>`)
                                    })
                                },
                                error: (data) => console.log(data)
                            })

                        });
                    },
                    error: err => console.log(err)
                })
            })
        },
        error: err => console.log(err)
    });
}