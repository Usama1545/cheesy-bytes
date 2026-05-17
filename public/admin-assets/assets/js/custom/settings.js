// setting page js
$('.basicinfo').on('click', function () {
    "use strict";
    $('#settingmenuContent').find('.card').attr('style', '');
    if ($(this).attr('data-tab') == 'edit_profile') {
        $('html, body').animate({
            scrollTop: 0
        }, '1000');
    } else {
        if (!$(this).is(':last-child')) {
            $('#' + $(this).attr('data-tab')).find('.card').attr('style', 'margin-top: 80px;');
        }
    }
    $('.list-options').find('.active').removeClass('active');
    $(this).addClass('active');
});

$(document).ready(function () {
    "use strict";
    setTimeout(function () {
        $('#address').prop('disabled', false);
    }, 1000);
});

$(document).ready(function () {
    $('#recaptcha_version').on('change', function () {
        var recaptcha_version = $(this).val();
        if (recaptcha_version == 'v3') {
            $("#score_threshold").show();
            $('#score_threshold_input').prop('required', true);
        } else {
            $("#score_threshold").hide();
            $('#score_threshold_input').prop('required', false);
        }
    });
});

$('#review_approved_status-switch').on('change', function () {
    if ($(this).is(':checked')) {
        $(this).val(1);
        document.querySelector('#checkbox5').disabled = false;
        document.querySelector('#checkbox4').disabled = false;
        document.querySelector('#checkbox3').disabled = false;
        document.querySelector('#checkbox2').disabled = false;
        document.querySelector('#checkbox1').disabled = false;
        document.querySelector('#review_setting_update_btn').disabled = false;
    } else {
        $(this).val(2);
        document.querySelector('#checkbox5').disabled = true;
        document.querySelector('#checkbox4').disabled = true;
        document.querySelector('#checkbox3').disabled = true;
        document.querySelector('#checkbox2').disabled = true;
        document.querySelector('#checkbox1').disabled = true;
    }
});

$("#login_required-switch").on("change", function (e) {
    if (this.checked) {
        $("#is_checkout_login_required").removeClass("d-none");
    } else {
        $("#is_checkout_login_required").addClass("d-none");
    }
});

function show_feature_icon(x) {
    "use strict";
    $(x).next().html($(x).val())
}
var id = 1;
function add_features(icon, title, description) {
    "use strict";
    var html = '<div class="row remove' + id + '"><div class="col-md-4 form-group"><div class="input-group"><input type="text" class="form-control feature_icon" onkeyup="show_feature_icon(this)" name="feature_icon[]" placeholder="' + icon + '" required><p class="input-group-text"></p></div></div><div class="col-md-4 form-group"><input type="text" class="form-control" name="feature_title[]" placeholder="' + title + '" required></div><div class="col-md-4 form-group"><div class="d-flex gap-2"><input type="text" class="form-control" name="feature_description[]" placeholder="' + description + '" required><div class=""><button class="btn btn-danger px-3" type="button" onclick="remove_features(' + id + ')"><i class="fa-sharp fa-solid fa-trash"></i></button></div></div></div></div>';
    $('.extra_footer_features').append(html);
    $(".feature_required").prop('required', true);
    id++;
}
function add_social_link(icon, link) {
    "use strict";
    var html = '<div class="row remove' + id + '"><div class="col-md-6 form-group"><div class="input-group"><input type="text" class="form-control feature_icon" onkeyup="show_feature_icon(this)" name="social_icon[]" placeholder="' + icon + '" required><p class="input-group-text"></p></div></div><div class="col-md-6 form-group d-flex gap-2 align-items-center"><input type="text" class="form-control" name="social_link[]" placeholder="' + link + '" required><button class="btn btn-danger px-3" type="button" onclick="remove_features(' + id + ')"><i class="fa-sharp fa-solid fa-trash"></i></button></div></div>';
    $('.extra_social_links').append(html);
    $(".soaciallink_required").prop('required', true);
    id++;
}
function remove_features(id) {
    "use strict";
    $('.remove' + id).remove();
    if ($('.extra_footer_features .row').length == 0) {
        $(".feature_required").prop('required', false);
    }
    if ($('.extra_social_links .row').length == 0) {
        $(".soaciallink_required").prop('required', false);
    }
}
function delete_features(nexturl) {
    "use strict";
    swalWithBootstrapButtons.fire({
        icon: 'warning',
        title: are_you_sure,
        showCancelButton: true,
        allowOutsideClick: false,
        allowEscapeKey: false,
        confirmButtonText: yes,
        cancelButtonText: no,
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            location.href = nexturl;
        } else {
            result.dismiss === Swal.DismissReason.cancel
        }
    })
}
function delete_social_links(nexturl) {
    "use strict";
    swalWithBootstrapButtons.fire({
        icon: 'warning',
        title: are_you_sure,
        showCancelButton: true,
        allowOutsideClick: false,
        allowEscapeKey: false,
        confirmButtonText: yes,
        cancelButtonText: no,
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            location.href = nexturl;
        } else {
            result.dismiss === Swal.DismissReason.cancel
        }
    })
}

function statusupdate(statusurl) {
    "use strict";
    swalWithBootstrapButtons.fire({
        icon: 'warning',
        title: are_you_sure,
        showCancelButton: true,
        allowOutsideClick: false,
        allowEscapeKey: false,
        confirmButtonText: yes,
        cancelButtonText: no,
        reverseButtons: true,
        showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve, reject) {
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url: statusurl,
                    method: 'GET',
                    success: function (response) {
                        if (response == 1) {
                            location.reload();
                        } else {
                            swal_cancelled()
                        }
                    },
                    error: function (e) {
                        swal_cancelled()
                    }
                });
            });
        },
    }).then((result) => {
        if (!result.isConfirmed) {
            result.dismiss === Swal.DismissReason.cancel
        }
    })
}
