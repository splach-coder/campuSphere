//first for the alert
fadeAlert();

function validateForm() {
    // Get form inputs
    var name = $("#username").val();
    var email = $("#password").val();

    // Sanitize inputs
    var clean_username = sanitizeInput(name);
    var clean_password = sanitizeInput(email);

    // Check if inputs are empty
    if (clean_username == "" || clean_password == "") {
        //my code here
        $('form').prepend(`<div class="alert alert-danger" role="alert">Please fill out all fields.</div>`);
        fadeAlert();
        return false;
    } else {
        return true;
    }
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