$('#addons_name').on('keyup', function () {
    "use strict";
    $(this).val($(this).val().replace(/,/g, ''));
});
$('.get_price').on('click', function () {
    "use strict";
    check_price($(this).val())
});
$('.get_price:checked').on('click', function () {
    "use strict";
    check_price($(this).val())
}).click();
function check_price(value) {
    "use strict";
    if (value == 1) {
        $('#price_row').hide();
        $('#price').prop('required', false);
    } else {
        $('#price_row').show();
        $('#price').prop('required', true);
    }
};
//Addons Group js
$('.get_count').on('click', function () {
    "use strict";
    check_count($(this).val())
});
$('.get_count:checked').on('click', function () {
    "use strict";
    check_count($(this).val())
}).click();
function check_count(value) {
    "use strict";
    if (value == 1) {
        $('.count_row').hide();
        $('.count_input').prop('required', false);
    } else {
        $('.count_row').show();
        $('.count_input').prop('required', true);
    }
};
function StatusUpdate(id, status, statusurl) {
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
                    data: { id: id, status: status },
                    method: 'POST',
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
function Delete(id, deleteurl) {
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
                    url: deleteurl,
                    data: { id: id },
                    method: 'POST',
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