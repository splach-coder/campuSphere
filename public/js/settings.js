$(document).ready(function () {
    console.log('get')
    var submitBtn = $('#form button[type="submit"]');
    // Disable submit button initially
    submitBtn.prop('disabled', true);
    var alertBox = $('form .alert');

    $('#form').on('input', function () {
        var inputs = $('#form input');
        submitBtn.prop('disabled', true);
        inputs.each(function () {
            console.log($(this).attr('class') + " his value " + $(this).val())
            if ($(this).val() === '') {
                submitBtn.prop('disabled', true);
                return false; // Exit loop
            } else {
                submitBtn.prop('disabled', false);
            }
        });
    });

    $('#form').on('submit', function (e) {
        e.preventDefault(); // Prevent page from reloading
        submitBtn.html('<i class="fa fa-spinner fa-spin"></i> Editing...')
        var formdata = $(this).serialize();
        var url = '../controller/settings.php';
        setTimeout(() => {
            $.ajax({
                url: url,
                type: 'POST',
                data: formdata,
                success: function (response) {
                    submitBtn.prop('disabled', false).html('Edit');
                    if (response === 'updated') {
                        alertBox.text(response).removeClass('d-none').addClass('alert-success');
                    } else {
                        alertBox.text(response).removeClass('d-none').addClass('alert-danger');
                    }

                    setTimeout(() => {
                        alertBox.addClass('d-none').slideUp();
                    }, 1500)

                },
                error: function (error) {
                    console.log(error);
                    submitBtn.prop('disabled', false).html('Edit');
                }
            });
        }, 1500);
    });
});