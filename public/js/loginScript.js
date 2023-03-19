//first for the alert
fadeAlert();

function validateForm() {
    // Get form inputs
    var formInputs = $('form').find('input[type!="checkbox"][type!="submit"]');
    var allInputsFilled = true;

    // Loop through all inputs
    formInputs.each(function () {
        var inputValue = $(this).val();
        // Sanitize inputs
        var cleanInput = sanitizeInput(inputValue);

        // Check if input is empty
        if (cleanInput == "") {
            // Add error message and mark flag as false
            $('form').prepend(`<div class="alert alert-danger" role="alert">Please fill out all fields.</div>`);
            fadeAlert();
            allInputsFilled = false;
            return false; // break out of loop early
        }
    });

    return allInputsFilled;
}



function sanitizeInput(input) {
    // Remove any HTML and JavaScript tags
    var clean_input = input.replace(/<[^>]*>/g, "");

    // Replace < and > characters with their corresponding HTML entities
    clean_input = clean_input.replace(/</g, "&lt;").replace(/>/g, "&gt;");

    return clean_input;
}

function fadeAlert() {
    setTimeout(function () {
        $('.alert').fadeOut();
    }, 1500)
}