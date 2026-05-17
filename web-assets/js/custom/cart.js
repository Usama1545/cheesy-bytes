function isopenclose(opencloseurl, qty, order_amount) {
    "use strict";
    $('.cart_checkout').prop("disabled", true);
    $('.cart_checkout_loader').removeClass('d-none');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: opencloseurl,
        data: {
            qty: qty,
            order_amount: order_amount
        },
        method: 'post',
        success: function (response) {
            $('.cart_checkout').prop("disabled", false);
            $('.cart_checkout_loader').addClass('d-none');
            if (response.status == 1) {
                $('#useroption').modal('show');
            } else if (response.status == 2) {
                toastr.error(response.message);
            } else if (response.status == 3) {
                location.href = "\checkout?buynow=0";
            } else if (response.status == 4) {
                window.location.href = "login";
            } else {
                restaurantclosed();
                return false;
            }
        },
        error: function () {
            toastr.error(wrong);
            $('.cart_checkout').prop("disabled", false);
            $('.cart_checkout_loader').addClass('d-none');
            return false;
        }
    });
}
function deletecartitem(id, deleteurl) {
    "use strict";
    swalWithBootstrapButtons.fire({
        icon: 'warning',
        title: are_you_sure,
        showCancelButton: true,
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
function qtyupdate(id, type, qtyurl) {
    "use strict";
    $('.qty_button').prop('disabled', true);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: qtyurl,
        data: {
            id: id,
            type: type
        },
        method: 'POST',
        success: function (response) {
            if (response.status == 1) {
                location.reload();
            } else if (response.status == 2) {
                $('.qty_button').prop('disabled', false);
                toastr.error(response.message);
            } else {
                $('.qty_button').prop('disabled', false);
                $('.err' + id).html(response.message);
                return false;
            }
        },
        error: function (e) {
            $('.qty_button').prop('disabled', false);
            $('.err' + id).html(e.message);
            return false;
        }
    });
}

function showaddons(addon_name, addon_price, extra_name, extra_price, item_name) {
    "use strict";
    $('#addons').addClass('d-none');
    $('#extras').addClass('d-none');
    $('#modal_selected_addons').find('#addon_item_name').html(item_name);
    var response1 = '';
    if (addon_name.split('| ') != '') {
        $.each(addon_name.split('| '), function (key, value) {
            response1 += '<li class="px-0 d-flex justify-content-between fs-7 text-black">' + value + ' <p class="mb-0">' + currency_format(addon_price.split('| ')[key]) + '</p> </li>';
        });
        $('#addons').removeClass('d-none');
    }
    $('#item-addons').html(response1);
    var response2 = '';
    if (extra_name.split('| ') != '') {
        $.each(extra_name.split('| '), function (key, value) {
            response2 += '<li class="px-0 d-flex justify-content-between fs-7 text-black"> ' + value + ' <p class="mb-0">' + currency_format(extra_price.split('| ')[key]) + '</p> </li>';
        });
        $('#extras').removeClass('d-none');
    }
    $('#item-extras').html(response2);
    $('#modal_selected_addons').modal('show');
}