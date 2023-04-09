function Toast(type, css, msg) {
    this.type = type;
    this.css = css;
    this.msg = msg;
}

toastr.options.positionClass = 'toast-top-full-width';
toastr.options.extendedTimeOut = 0; //1000;
toastr.options.timeOut = 8000;
// toastr.options.fadeOut = 250;
// toastr.options.fadeIn = 250;
toastr.options.showMethod = 'slideDown';
toastr.options.hideMethod = 'slideUp';
toastr.options.closeMethod = 'slideUp';

var i = 0;

function showToast(type, css, msg) {
    var t = new Toast(type, css, msg);
    toastr.options.positionClass = t.css;
    toastr[t.type](t.msg);
    i++;
}