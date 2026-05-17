$("#imageupload").on('change',function() {
    "use strict";
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById("imgupload").src = e.target.result;
            $("#imagepreview").hide();
            $("#imagepreview").fadeIn(650);
        };
        reader.readAsDataURL(this.files[0]);
    }
});
$("#send_email-switch").on('change',function() {
    "use strict";
    $('#preload').show();
    location.href = $(this).attr('data-url');
});