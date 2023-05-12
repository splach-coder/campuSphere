$(document).ready(function () {
    //open and close the sidebar
    $(".toggle").click(function () {
        $(".sidebar").toggleClass('close');
    });

    // Initialize Swiper
    var swiper = new Swiper(".mySwiper", {
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });

    $(".close.first").click(function () {
        $(".modal").css('display', 'none');
        $("body").css('overflow', 'auto');
    });

    $(".close.second").click(function () {
        $(".modall").css('display', 'none');
    })

    //get products
    getProduit(getDate('today'));

    $(".reason").click(function () {
        const id = $(".reject-button").attr('data-id');
        manipluateProduct(id, 'reject', $(this).text().trim());
        getProduit(getDate($('#date-filter').val()));
    });

    $(".reject-button").click(function () {
        $('html, body').animate({
            scrollTop: 0
        }, 'fast');
        $(".modall.second ").css('display', 'block');
        $("body").css('overflow', 'hidden');
    });

    $(".accept-button").click(function () {
        const id = $(this).attr('data-id');
        manipluateProduct(id, 'accept', 'accepted');
        getProduit(getDate($('#date-filter').val()));
    });

    $('#date-filter').on('change', function () {
        var selectedValue = $(this).val();
        var date = getDate(selectedValue); // get the date based on the selected value

        getProduit(date);
    });
});


function manipluateProduct(id, type, msg) {
    console.log(id);

    $.ajax({
        url: "../../controller/marketplace/manipulateProduct.php",
        method: 'post',
        data: {
            id,
            type,
            msg
        },
        success: function (data) {
            if (data = 'product modified') {
                showToast('success', 'toast-top-center', data);
            }
        },
        error: err => console.log(err)
    });

    $(".close.first").click();
}

function getProduit(date) {
    //get produits
    $.ajax({
        url: '../../controller/marketplace/getProduitsAdmin.php',
        method: 'get',
        data: {
            date
        },
        success: function (data) {
            $(".card-holder").empty();

            data.forEach(e => {
                $(".card-holder").append(product(e.id, e.name, e.price, e.image, e.location));
            });

            $(".card").click(function () {
                $('html, body').animate({
                    scrollTop: 0
                }, 'fast');
                const id = $(this).attr('data-id');
                $(".modal").css('display', 'block');
                $("body").css('overflow', 'hidden');

                $.ajax({
                    url: '../../controller/marketplace/getProduct.php',
                    method: 'get',
                    data: {
                        id
                    },
                    success: function (data) {
                        console.log(data);
                        $(".product-title").html(data.title);
                        $(".product-price").html(data.prix + " DH");
                        $(".product-details").html(data.description);
                        $(".author-img").attr('src', '../' + data.image);
                        $(".author-name").html(data.username);
                        $(".buttons-div button").each(function () {
                            $(this).attr('data-id', data.id);
                        });
                        $("#4swiper").empty();

                        data.images.forEach(function (e) {
                            $("#4swiper").append(`<div class='swiper-slide'>
                            <img src='../${e.url}' data-id='${e.id}' alt=''>
                        <div>`)
                        })
                    },
                    error: (data) => console.log(data)
                })

            });
        },
        error: err => console.log(err)
    });
}


function getDate(selectedValue) {
    var date = new Date();

    switch (selectedValue) {
        case 'yesterday':
            date.setDate(date.getDate() - 1);
            break;
        case '3days':
            date.setDate(date.getDate() - 3);
            break;
        case '5days':
            date.setDate(date.getDate() - 5);
            break;
        case 'week':
            date.setDate(date.getDate() - 7);
            break;
        case 'month':
            date.setMonth(date.getMonth() - 1);
            break;
        default:
            // today
    }

    return formatDate(date);
}

function formatDate(date) {
    var year = date.getFullYear();
    var month = ('0' + (date.getMonth() + 1)).slice(-2);
    var day = ('0' + date.getDate()).slice(-2);

    return year + '-' + month + '-' + day;
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