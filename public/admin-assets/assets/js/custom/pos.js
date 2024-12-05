function addtocart(addcarturl, id) {
    "use strict";
    var errorDetected = false; // Flag to track if any error is detected
    var addongroups = $('#addongroup_' + id).data('addongroup_val');

    addongroups.forEach((group) => {
        $('#item_addons_group_' + id + '_' + group.id).each(function () {
            if (group.availableAddons != '') {
                var selectedCount = $("input[name='addons_id_" + group.id + "_" + id + "']:checked").length;
                if (group.selection_type == 1) {
                    if (selectedCount < group.min_count) {
                        $("input[name='addons_id_" + group.id + "_" + id + "'][type='checkbox']:not(:checked)").prop('disabled', false);
                        $('.addons_error_' + group.id + '_' + id).text('Please select at least ' + group.min_count + ' addon(s)');
                        errorDetected = true; // Set flag to true indicating an error is detected
                    }
                } else if (group.selection_type == 2) {
                    if (selectedCount >= group.max_count) {
                        $("input[name='addons_id_" + group.id + "_" + id + "'][type='checkbox']:not(:checked)").prop('disabled', true);
                    }
                }
            }
        });
    });
    if (errorDetected) {
        // If any error is detected, prevent further actions like submitting the form
        return false;
    }
    var slug = $('#slug_' + id).val();
    var item_name = $('#item_name_' + id).val();
    var item_type = $('#item_type_' + id).val();
    var image_name = $('#image_name_' + id).val();
    var item_tax = $('#item_tax_' + id).val();
    var item_price = $('#item_price_' + id).val();
    var addons_id = $('.addons_chk_' + id + ':checked').map(function () {
        return $(this).attr('data-addons-id');
    }).get().join('| ');
    var addons_name = ($('.addons_chk_' + id + ':checked').map(function () {
        return $(this).attr('data-addons-name');
    }).get().join('| '));
    var addons_price = ($('.addons_chk_' + id + ':checked').map(function () {
        return $(this).attr('data-addons-price');
    }).get().join('| '));
    var extras_id = $(".extras_chk_" + id + ":checked").map(function () {
        return $(this).attr("data-extras-id");
    }).get().join("| ");
    var extras_name = $(".extras_chk_" + id + ":checked").map(function () {
        return $(this).attr("data-extras-name");
    }).get().join("| ");
    var extras_price = $(".extras_chk_" + id + ":checked").map(function () {
        return $(this).attr("data-extras-price");
    }).get().join("| ");
    var qtys = parseInt($('#item_qty_' + slug).val());

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: addcarturl,
        data: {
            slug: slug,
            item_name: item_name,
            item_type: item_type,
            image_name: image_name,
            tax: item_tax,
            item_price: item_price,
            qty: qtys,
            addons_id: addons_id,
            addons_name: addons_name,
            addons_price: addons_price,
            extras_id: extras_id,
            extras_name: extras_name,
            extras_price: extras_price,
        },
        method: 'POST',
        dataType: 'json',
        success: function (response) {
            if (response.status == 1) {
                location.reload();
            } else if (response.status == 0) {
                $("#modalitemdetails").modal('hide');
                toastr.error(response.message);
                if (response.buynow == 0) {
                    $('.cart').prop("disabled", false);
                    $('.cart_loader').addClass('d-none');
                } else {
                    $('.quick_order').prop("disabled", false);
                    $('.quick_order_loader').addClass('d-none');
                }
            }

        },
        error: function () {
            $('.cart').prop("disabled", false);
            $('.cart_loader').addClass('d-none');
            $('.quick_order').prop("disabled", false);
            $('.quick_order_loader').addClass('d-none');
            toastr.error(wrong);
            $("#modalitemdetails").modal('hide');
        }
    });
};

function showitem(id, showurl) {
    "use strict";
    $('#preloader').show();
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: showurl,
        data: { id: id },
        method: 'POST',
        dataType: 'json',
        success: function (response) {
            $("#modalitem_body").html(response.output);
            $("#modalitemdetails").modal('show');
            getaddons(response.id);
        },
        error: function () {
            toastr.error(wrong);
        }
    })
}

function changeqty(item_slug, type) {
    var qtys = parseInt($('#item_qty_' + item_slug).val());
    if (type == "minus") {
        qty = qtys - 1;
    } else {
        qty = qtys + 1;
    }
    if (qty >= "1") {
        $('#item_qty_' + item_slug).val(qty);
    }

}
function getaddons(id) {
    "use strict";

    var addongroups = $('#addongroup_' + id).data('addongroup_val');
    addongroups.forEach((group) => {
        $('#item_addons_group_' + id + '_' + group.id).each(function () {
            if (group.availableAddons != '') {
                var selectedCount = $("input[name='addons_id_" + group.id + "_" + id + "']:checked").length;
                if (group.selection_type == 1) {
                    if (selectedCount < group.min_count) {
                        $("input[name='addons_id_" + group.id + "_" + id + "'][type='checkbox']:not(:checked)").prop('disabled', false);
                        $('.addons_error_' + group.id + '_' + id).removeClass('d-none').text('Please select at least ' + group.min_count + ' addon(s)');
                        $('#addon_required_icon_' + group.id + '_' + id).removeClass('fa-circle-check text-success').addClass('fa-triangle-exclamation');
                        $('#addon_required_text_' + group.id + '_' + id).removeClass('text-success').addClass('addon_group_color');
                    } else if (selectedCount >= group.max_count) {
                        $("input[name='addons_id_" + group.id + "_" + id + "'][type='checkbox']:not(:checked)").prop('disabled', true);
                        $('.addons_error_' + group.id + '_' + id).addClass('d-none').text(''); // Clear error message if selection is valid
                        $('#addon_required_icon_' + group.id + '_' + id).removeClass('fa-triangle-exclamation').addClass('fa-circle-check text-success');
                        $('#addon_required_text_' + group.id + '_' + id).removeClass('addon_group_color').addClass('text-success');
                    } else {
                        $("input[name='addons_id_" + group.id + "_" + id + "'][type='checkbox']:not(:checked)").prop('disabled', false);
                        $('.addons_error_' + group.id + '_' + id).addClass('d-none').text(''); // Clear error message if selection is valid
                        $('#addon_required_icon_' + group.id + '_' + id).removeClass('fa-triangle-exclamation').addClass('fa-circle-check text-success');
                        $('#addon_required_text_' + group.id + '_' + id).removeClass('addon_group_color').addClass('text-success');
                    }
                } else if (group.selection_type == 2) {
                    if (selectedCount >= group.max_count) {
                        $("input[name='addons_id_" + group.id + "_" + id + "'][type='checkbox']:not(:checked)").prop('disabled', true);
                    } else {
                        $("input[name='addons_id_" + group.id + "_" + id + "'][type='checkbox']:not(:checked)").prop('disabled', false);
                    }
                }
            }
        });
    });
    var item_price = parseFloat($('#item_price_' + id).val());
    var addonstotal = 0;
    var subtotal = 0;

    var chk = document.querySelectorAll(".addons_chk_" + id + ":checked");
    if (chk.length) {
        chk.forEach(function (el) {
            addonstotal += parseFloat(el.getAttribute('data-addons-price'));
        });
    }
    subtotal = item_price + addonstotal;
    $('.subtotal_' + id).text(currency_format(subtotal));

}

function deletecartitem(id, deleteurl) {
    "use strict";
    $('#preloader').show();
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: deleteurl,
        data: { id: id },
        method: 'POST',
        dataType: 'json',
        success: function (response) {
            location.reload();
        },
        error: function (error) {
            $("html, body").animate({
                scrollTop: 0
            }, 600);
            $('#cartemsg').html(error).fadeIn('slow');
            $('#cartemsg').delay(5000).fadeOut('slow');
        }
    })
}
function qtyupdate(id, type, qtyurl) {
    "use strict";
    $('.qty_btn').prop('disabled', true);
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: qtyurl,
        data: {
            id: id,
            type: type,
        },
        method: 'POST',
        dataType: 'json',
        success: function (response) {
            if (response.status == 1) {
                location.reload();
            }
        },
        error: function (error) {
            $('.qty_btn').prop('disabled', false);
            $("html, body").animate({
                scrollTop: 0
            }, 600);
            $('#cartemsg').html(error).fadeIn('slow');
            $('#cartemsg').delay(5000).fadeOut('slow');
        }
    })
}

function placeorder(orderurl, sucecssurl) {
    "use strict";
    if ($("#ramin_amount").val() > 0) {
        toastr.error("Total amount must be less than recived amount!!");
        $("#paymentModal").modal("show");
        return false;
    }
    var tax = $('#tax').val();
    var tax_name = $("#tax_name").val();
    var discount_amount = parseFloat($('#discount_amount').val());
    var grand_total = parseFloat($('#grand_total').val());
    var payment_type = $('input[name="payment_type"]:checked').val();
    if (payment_type == null || payment_type == "") {
        toastr.error("Please select payment type!!");
        return false;
    }
    var customer = $("#customer").val();
    if (customer == "walk-in customer") {
        $("#customermodal").modal("show");
    } else {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: orderurl,
            data: {
                tax: tax,
                tax_name: tax_name,
                discount_amount: discount_amount,
                grand_total: grand_total,
                customer: customer,
                payment_type: payment_type,
            },
            method: 'POST',
            success: function (response) {
                if (response.status == 1) {
                    window.location.href = sucecssurl;
                } else {
                    $("html, body").animate({ scrollTop: 50 }, 600);
                    $('#emsg').html(response.message).addClass('alert alert-danger my-3').fadeIn('slow');
                    $('#emsg').delay(5000).fadeOut('slow');
                }
            },
            error: function (error) {
                $('#preloader').hide();
                $("html, body").animate({ scrollTop: 50 }, 600);
                $('#emsg').html(error).fadeIn('slow');
                $('#emsg').delay(5000).fadeOut('slow');
            }
        });
    }
}

function Order(orderurl, sucecssurl) {
    var tax = $('#tax').val();
    var tax_name = $("#tax_name").val();
    var discount_amount = parseFloat($('#discount_amount').val());
    var grand_total = parseFloat($('#grand_total').val());
    var customer = $("#customer").val();
    var payment_type = $('input[name="payment_type"]:checked').val();
    var name = $("#customer_name").val();
    var email = $("#customer_email").val();
    var mobile = $("#customer_mobile").val();
    if (mobile == "") {
        toastr.error($('#mobile_message').val());
    }
    if (email == "") {
        toastr.error($('#email_message').val());
    }
    if (name == "") {
        toastr.error($('#name_message').val());
    }
    if (name != "" && email != "" && mobile != "") {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: orderurl,
            data: {
                tax: tax,
                tax_name: tax_name,
                discount_amount: discount_amount,
                grand_total: grand_total,
                customer: customer,
                payment_type: payment_type,
                name: name,
                email: email,
                mobile: mobile,
            },
            method: 'POST',
            success: function (response) {
                $('#preloader').hide();
                if (response.status == 1) {
                    window.location.href = sucecssurl;
                } else {
                    $("html, body").animate({ scrollTop: 50 }, 600);
                    $('#emsg').html(response.message).addClass('alert alert-danger my-3').fadeIn('slow');
                    $('#emsg').delay(5000).fadeOut('slow');
                }
            },
            error: function (error) {
                $("html, body").animate({ scrollTop: 50 }, 600);
                $('#emsg').html(error).fadeIn('slow');
                $('#emsg').delay(5000).fadeOut('slow');
            }
        });
    }
}

function validation(value) {
    var remaining = $("#modal_total_amount").val() - value;
    $("#ramin_amount").val(remaining.toFixed(2));
}

$("input[type=radio]").click(function () {
    var sub_total = $("#sub_total").val();
    if (parseFloat(minorderamount) > parseFloat(sub_total)) {
        toastr.error(minorderamountmsg);
        return false;
    } else {
        if ($(this).val() == "1") {
            $("#modal_total_amount").val($("#grand_total").val());
            $("#paymentModal").modal("show");
        }
    }

});

function showaddons(addon_name, addon_price, extra_name, extra_price, item_name) {
    "use strict";
    $('#addons').addClass('d-none');
    $('#extras').addClass('d-none');
    $('#modal_selected_addons').find('#addon_item_name').html(item_name);
    var response1 = '';
    if (addon_name.split('| ') != '') {
        $.each(addon_name.split('| '), function(key, value) {
            response1 += '<li class="list-group-item fs-7 d-flex justify-content-between text-black">' + value +
                ' <p class="mb-0">' + currency_format(addon_price.split('| ')[key]) + '</p> </li>';
        });
        $('#addons').removeClass('d-none');
    }
    $('#item-addons').html(response1);
    var response2 = '';
    if (extra_name.split('| ') != '') {
        $.each(extra_name.split('| '), function(key, value) {
            response2 += '<li class="list-group-item fs-7 d-flex justify-content-between text-black"> ' + value +
                ' <p class="mb-0">' + currency_format(extra_price.split('| ')[key]) + '</p> </li>';
        });
        $('#extras').removeClass('d-none');
    }
    $('#item-extras').html(response2);
    $('#modal_selected_addons').modal('show');
}