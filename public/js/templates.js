$(document).ready(function () {
    $(".sidebar a").click(function () {
        $(".sidebar a").each(function () {
            $(this).removeClass("active");
        });

        $(this).toggleClass("active");
    });

    //get the under profile
    $(".profileImage").click(function () {
        $(".underprofile-holder").toggleClass("show");
    });

    // Attach click event listener to a parent element using event delegation
    $(".searchers-con").on("click", ".search-bar", function () {
        let text = $(this).children(".search-bar-info").children("span").eq(0).text();

        $.ajax({
            url: '../controller/user-searches/insertRecentSearch.php',
            type: 'POST',
            data: {
                text
            },
            success: function (response) {
                // Code to handle search results here...
                console.log(response)
            },
            error: function () {
                console.log('Error: Could not search for users.');
            }
        });

        //go to the search part
    });

    // Attach click event listener to a parent element using event delegation
    $(".recent-searches").on("click", ".delete-recent-search", function () {
        let id = $(this).parent().attr("data-id");

        //go to the search part
        $.ajax({
            url: '../controller/user-searches/deleteRecentSearch.php',
            type: 'POST',
            data: {
                id
            },
            success: function (response) {
                // Code to handle search results here...
                console.log(response);
                //send an ajax to get recent searches
                getRecentSearches();
            },
            error: function () {
                console.log('Error: Could not delete for users.');
            }
        });
    });


    /*sort searchees */
    $('#searchbar').on('input', function () {
        var inputValue = $(this).val();

        if (inputValue.length > 0) {
            $(".recent-searches").removeClass("show");
            $('.searchers-con').addClass('show');

            //send an ajax to get searches
            getSearches(inputValue);

        } else {
            $(".recent-searches").addClass("show");
            $('.searchers-con').removeClass('show');

            //send an ajax to get recent searches
            getRecentSearches();

        }
    });

    $('#searchbar').focus(function () {
        var inputValue = $(this).val();
        if (inputValue.length > 0) {
            $(".recent-searches").removeClass("show");
            $('.searchers-con').addClass('show');
        } else {
            $(".recent-searches").addClass("show");
            getRecentSearches();
        }
    });

    $('#searchbar').blur(function () {
        var inputValue = $(this).val();
        if (inputValue.length <= 0) {
            $(".recent-searches").removeClass("show");
            $('.searchers-con').removeClass('show');
        }
    });

})


function usersearch(image, fullname, relation, id) {
    return `<div class="search-bar" data-user-id="${id}">
    <div class="search-bar-img">
    <a href='./profileVisit.php?id=${id}'>  
        <img src="${image}" alt="">
         </a>
    </div>
    <div class="search-bar-info">
        <span>${fullname}</span>
        <span>${relation}</span>
    </div>
    </div>`
}

function recentsearch(id, text) {
    return `
    <div class="search" data-id='${id}'> 
        <span>${text}</span>
        <i class="fas fa-times delete-recent-search"></i>
    </div>
    `;
}

function getRecentSearches() {
    $.ajax({
        url: '../controller/user-searches/recentsearches.php',
        type: 'GET',
        success: function (response) {
            // Code to handle search results here...
            $(".recent-searches").empty();
            if (response.length > 0) {
                $(".recent-searches").append(` <div class="top-bar">
                <h5>Recent searches</h5>
            </div>`);
                response.forEach(res => {
                    $(".recent-searches").append(recentsearch(res.id, res.text));
                });
            } else {
                $(".recent-searches").html('<p>No recent searches</p>');
            }
        },
        error: function (err) {
            console.log('Error: Could not search for recent searches.');
            console.log(err);
        }
    });
}

function getSearches(inputValue) {
    $.ajax({
        url: '../controller/user-searches/searchForUsers.php',
        type: 'POST',
        data: {
            query: inputValue
        },
        success: function (response) {
            // Code to handle search results here...
            $(".searchers-con").empty();
            if (response.length > 0) {

                response.forEach(res => {
                    $(".searchers-con").append(usersearch(res.image, res.fullname, res.relation, res.id));
                    console.log(res)
                });

            } else {
                $(".searchers-con").html('<p>no user matches</p>')
            }
        },
        error: function () {
            console.log('Error: Could not search for users.');
        }
    });
}