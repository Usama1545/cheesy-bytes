if ($('#stripekey').val() !== "") {
    var stripe = Stripe($('#stripekey').val());
    var card = stripe.elements().create('card', {
        style: {
            base: {
                // Add your base input styles here. For example:
                fontSize: '16px',
                color: '#32325D',
            },
        }
    });
    card.mount('#card-element');
    $('.__PrivateStripeElement iframe').removeAttr('style');
}

// common-variables
var orderurl = $('#orderurl').val();
var mercadopagourl = $('#mercadopagourl').val();
var myfatoorahurl = $('#myfatoorahurl').val();
var toyyibpayurl = $('#toyyibpayurl').val();
var paytaburl = $('#paytaburl').val();
var phonepeurl = $('#phonepeurl').val();
var mollieurl = $('#mollieurl').val();
var khaltiurl = $('#khaltiurl').val();
var paypalurl = $('#paypalurl').val();
var paymentsuccess = $('#paymentsuccess').val();
var paymentfail = $('#paymentfail').val();
var continueurl = $('#continueurl').val();
var tax_amount = parseFloat($('#totaltaxamount').val());
var tax = $('#tax').val();
var tax_name = $('#tax_name').val();



// TO-HIDE-ADDRESS-ERROR
$('input:radio[name=myaddress]').click(function (event) {
    "use strict";
    $('#user_area').val($("input:radio[name=myaddress]:checked").attr('area'));
    $('#user_address').val($("input:radio[name=myaddress]:checked").attr('address'));
    $('#user_house_no').val($("input:radio[name=myaddress]:checked").attr('house_no'));
    $('#user_address_type').val($("input:radio[name=myaddress]:checked").attr('data-address-type'));
});
$('input:radio[name=myaddress]:checked').click(function (event) {
    "use strict";
    $('#user_area').val($("input:radio[name=myaddress]:checked").attr('area'));
    $('#user_address').val($("input:radio[name=myaddress]:checked").attr('address'));
    $('#user_house_no').val($("input:radio[name=myaddress]:checked").attr('house_no'));
    $('#user_address_type').val($("input:radio[name=myaddress]:checked").attr('data-address-type'));
}).click();

// TO-HIDE-PAYMENT-TYPE-ERROR
$('input:radio[name=transaction_type]').on('click', function (event) {
    "use strict";
    if ($(this).val() == 4) {
        $('#payment-form').removeClass('d-none');
    } else {
        $('#payment-form').addClass('d-none');
    }
});

$('input:radio[name=order_type]').on('click', function (event) {
    "use strict";
    var order_type = $("input:radio[name=order_type]:checked").val();
    if (order_type == 1) {
        $('#addressdiv').removeClass('d-none');
        $('#shipping_area').removeClass('d-none');
        $('#delivery_charge').removeClass('d-none');
        var delivery_charge = $("#delivery_area  option:selected").attr('data-charge');
        var sub_total = $('#sub_total').val();
        var totaltax = $('#totaltaxamount').val();
        var discount = $('#discount').val();
        var total = parseFloat(sub_total) + parseFloat(totaltax) + parseFloat(delivery_charge) - parseFloat(discount);
        $('#shipping_charge').val(delivery_charge);
        $('#delivery_amount').html(currency_format(parseFloat(delivery_charge)));
        $('#total_amount').html(currency_format(parseFloat(total)));
        $('#grand_total').val(parseFloat(total));
        $('#new_address').prop('required', true);
        $('#new_pincode').prop('required', true);
        $('#delivery_date').removeClass('d-none');
        $('#pickup_date').addClass('d-none');
        $('#pickup_time').addClass('d-none');
        $('#delivery_time').removeClass('d-none');
    } else if (order_type == 2) {
        $('#addressdiv').addClass('d-none');
        $('#shipping_area').addClass('d-none');
        $('#delivery_charge').addClass('d-none');
        var delivery_charge = 0;
        var sub_total = $('#sub_total').val();
        var totaltax = $('#totaltaxamount').val();
        var discount = $('#discount').val();
        var total = parseFloat(sub_total) + parseFloat(totaltax) + parseFloat(delivery_charge) - parseFloat(discount);
        $('#shipping_charge').val(delivery_charge);
        $('#delivery_amount').html(currency_format(parseFloat(delivery_charge)));
        $('#total_amount').html(currency_format(parseFloat(total)));
        $('#grand_total').val(parseFloat(total));
        $('#new_address').prop('required', false);
        $('#new_pincode').prop('required', false);
        $('#delivery_date').addClass('d-none');
        $('#delivery_time').addClass('d-none');
        $('#pickup_date').removeClass('d-none');
        $('#pickup_time').removeClass('d-none');
    }
}).change();

$(document).ready(function ($) {
    var order_type = $("input:radio[name=order_type]:checked").val();
    if (order_type == 1) {
        $('#addressdiv').removeClass('d-none');
        $('#shipping_area').removeClass('d-none');
        $('#delivery_charge').removeClass('d-none');
        var delivery_charge = $("#delivery_area option:selected").attr('data-charge');
        var sub_total = $('#sub_total').val();
        var totaltax = $('#totaltaxamount').val();
        var discount = $('#discount').val();
        var total = parseFloat(sub_total) + parseFloat(totaltax) + parseFloat(delivery_charge) - parseFloat(discount);
        $('#shipping_charge').val(delivery_charge);
        $('#delivery_amount').html(currency_format(parseFloat(delivery_charge)));
        $('#total_amount').html(currency_format(parseFloat(total)));
        $('#grand_total').val(parseFloat(total));
        $('#new_address').prop('required', true);
        $('#new_pincode').prop('required', true);
        $('#delivery_date').removeClass('d-none');
        $('#pickup_date').addClass('d-none');
        $('#pickup_time').addClass('d-none');
        $('#delivery_time').removeClass('d-none');
    } else if (order_type == 2) {
        $('#addressdiv').addClass('d-none');
        $('#shipping_area').addClass('d-none');
        $('#delivery_charge').addClass('d-none');
        var delivery_charge = 0;
        var sub_total = $('#sub_total').val();
        var totaltax = $('#totaltaxamount').val();
        var discount = $('#discount').val();
        var total = parseFloat(sub_total) + parseFloat(totaltax) + parseFloat(delivery_charge) - parseFloat(discount);
        $('#shipping_charge').val(delivery_charge);
        $('#delivery_amount').html(currency_format(parseFloat(delivery_charge)));
        $('#total_amount').html(currency_format(parseFloat(total)));
        $('#grand_total').val(parseFloat(total));
        $('#new_address').prop('required', false);
        $('#new_pincode').prop('required', false);
        $('#delivery_date').addClass('d-none');
        $('#delivery_time').addClass('d-none');
        $('#pickup_date').removeClass('d-none');
        $('#pickup_time').removeClass('d-none');
    }
});

$("#address_type").on('change', function () {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: $('#getaddress').val(),
        data: {
            id: this.value,
        },
        method: 'POST',
        success: function (response) {
            if (response.status == 1) {
                $('#new_address').text(response.data.address);
                $('#new_landmark').val(response.data.landmark);
                $('#new_pincode').val(response.data.postal_code);
                $('#new_country').val(response.data.country);
                $('#new_state').val(response.data.state);
                $('#new_city').val(response.data.city);
                if (response.data.address_type == 1) {
                    $('input[name=address_type]:eq(0)').prop('checked', true);
                }
                if (response.data.address_type == 2) {
                    $('input[name=address_type]:eq(1)').prop('checked', true);
                }
                if (response.data.address_type == 3) {
                    $('input[name=address_type]:eq(2)').prop('checked', true);
                }
            }
        },
        error: function (error) {
            toastr.error(error);
            return false;
        }
    });
}).change();
$('#shipping_area').on('change', function () {
    var delivery_charge = $(this).find(':selected').attr('data-charge');
    var sub_total = $('#sub_total').val();
    var totaltax = $('#totaltaxamount').val();
    var discount = $('#discount').val();
    var total = parseFloat(sub_total) + parseFloat(totaltax) + parseFloat(delivery_charge) - parseFloat(discount);
    $('#shipping_charge').val(delivery_charge);
    $('#delivery_amount').html(currency_format(parseFloat(delivery_charge)));
    $('#total_amount').html(currency_format(parseFloat(total)));
    $('#grand_total').val((parseFloat(total)));
});

$("#delivery_dt").on("change", function () {
    "use strict";
    $("#delivery_slot_time").empty();
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: $("#sloturl").val(),
        type: "post",
        dataType: "json",
        data: {
            inputDate: $(this).val(),
        },
        success: function (response) {
            if (response == "1") {
                $("#store_close").removeClass("d-none");
                $("#delivery_slot_time").addClass("d-none");
            } else {
                $("#store_close").addClass("d-none");
                $("#delivery_slot_time").removeClass("d-none");
                $("#delivery_slot_time").append('<option value="">' + select + "</option>");
                for (var i in response) {
                    $("#delivery_slot_time").append(
                        '<option value="' + response[i]["slot"] + '">' + response[i]["slot"] + "</option>"
                    );
                }
            }
        }
    });
});
function isopenclose(opencloseurl, qty, order_amount) {
    "use strict";
    $('.checkout').prop("disabled", true);
    $('.checkout_loader').removeClass('d-none');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: opencloseurl,
        data: {
            qty: qty,
            order_amount: order_amount,
            buynow: $('#buynow').val(),
        },
        method: 'post',
        success: function (response) {
            $('.checkout').prop("disabled", false);
            $('.checkout_loader').addClass('d-none');
            if (response.status == 1) {
                validatedata();
            } else if (response.status == 2) {
                toastr.error(response.message);
            } else if (response.status == 3) {
                validatedata();
            } else {
                restaurantclosed();
                return false;
            }
        },
        error: function () {
            $('.checkout').prop("disabled", false);
            $('.checkout_loader').addClass('d-none');
            toastr.error(wrong);
            return false;
        }
    });
}

function validatedata() {
    "use strict";
    // erroe messages
    var neworder_type = $("input:radio[name=order_type]:checked").val();
    if ($('#delivery_dt').val() == '') {
        if (neworder_type == 1) {
            toastr.error($('#delivery_date_message').val());
        } else if (neworder_type == 2) {
            toastr.error($('#pickup_date_message').val());
        }
        return false;
    }
    if ($('#delivery_slot_time').val() == '') {
        if (neworder_type == 1) {
            toastr.error($('#delivery_time_message').val());
        } else if (neworder_type == 2) {
            toastr.error($('#pickup_time_message').val());
        }
        return false;
    }
    if ($('#first_name').val() == '') {
        toastr.error($('#first_name_message').val());
        return false;
    }
    if ($('#last_name').val() == '') {
        toastr.error($('#last_name_message').val());
        return false;
    }
    if ($('#email').val() == '') {
        toastr.error($('#email_message').val());
        return false;
    }
    if ($('#mobile').val() == '') {
        toastr.error($('#mobile_message').val());
        return false;
    }
    if (neworder_type == 1) {
        if ($('#new_address').val() == '') {
            toastr.error($('#new_address_message').val());
            return false;
        }
        if ($('#new_landmark').val() == '') {
            toastr.error($('#new_landmark_message').val());
            return false;
        }
        if ($('#new_city').val() == '') {
            toastr.error($('#new_city_message').val());
        }
        if ($('#new_state').val() == '') {
            toastr.error($('#new_state_message').val());
            return false;
        }
        if ($('#new_country').val() == '') {
            toastr.error($('#new_country_message').val());
            return false;
        }
        if ($('#new_pincode').val() == '') {
            toastr.error($('#new_pincode_message').val());
            return false;
        }
        if ($('#shipping_delivery_area').is(':visible') && $('#shipping_delivery_area').val() == '') {
            toastr.error($('#shipping_area_message').val());
            return false;
        }

        if ($('#pickupdiv').is(':visible') && $('#pickup_area').val() == '') {
            toastr.error($('#pickup_area_message').val());
            return false;
        }
    }
    if ($('input[name="transaction_type"]:checked').length <= 0) {
        toastr.error($('#payment_type_message').val());
    }

    $('.checkout').prop("disabled", true);
    $('.checkout_loader').removeClass('d-none');

    var name = $('#first_name').val() + ' ' + $('#last_name').val();
    var email = $('#email').val();
    var mobile = $('#mobile').val();
    var address = $('#new_address').val();
    var landmark = $('#new_landmark').val();
    var pincode = $('#new_pincode').val();
    var country = $('#new_country').val();
    var state = $('#new_state').val();
    var delivery_area = $('#shipping_delivery_area').val() || $('#pickup_area').val();
    var city = $('#new_city').val();
    var address_type = $("input:radio[name=address_type]:checked").val();
    var order_notes = $('#order_notes').val();

    var transaction_type = $("input:radio[name=transaction_type]:checked").val();
    var transaction_currency = $("input:radio[name=transaction_type]:checked").attr('data-currency');
    var delivery_charge = parseFloat($('#shipping_charge').val());
    var tax_amount = parseFloat($('#totaltaxamount').val());
    var total = parseFloat($('#grand_total').val());
    var buynow = $('#buynow').val();
    var delivery_time = $('#delivery_slot_time').val();
    var delivery_date = $('#delivery_dt').val();

    // COD || Wallet
    if (transaction_type == 1 || transaction_type == 2) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: orderurl,
            data: {
                order_type: neworder_type,
                delivery_charge: delivery_charge,
                grand_total: total,
                delivery_area: delivery_area,
                tax_amount: tax_amount,
                address_type: address_type,
                address: address,
                landmark: landmark,
                pincode: pincode,
                order_notes: order_notes,
                transaction_type: transaction_type,
                name: name,
                mobile: mobile,
                email: email,
                tax: tax,
                tax_name: tax_name,
                buynow: buynow,
                country: country,
                state: state,
                city: city,
                delivery_time: delivery_time,
                delivery_date: delivery_date,

            },
            method: 'POST',
            success: function (response) {
                if (response.status == 1) {
                    ordersuccess(response.order_id, continueurl);
                } else {
                    $('.checkout').prop("disabled", false);
                    $('.checkout_loader').addClass('d-none');
                    toastr.error(response.message);
                    return false;
                }
            },
            error: function () {
                $('.checkout').prop("disabled", false);
                $('.checkout_loader').addClass('d-none');
                toastr.error(wrong);
                return false;
            }
        });
    }
    //Razorpay
    if (transaction_type == 3) {
        var options = {
            "key": $('#razorpaykey').val(),
            "amount": parseInt(total * 100),
            "name": "SingleRestaurant",
            "description": "Razorpay Order payment",
            "image": 'https://badges.razorpay.com/badge-light.png',
            "handler": function (response) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: orderurl,
                    type: 'post',
                    dataType: 'json',
                    data: {
                        order_type: neworder_type,
                        delivery_charge: delivery_charge,
                        grand_total: total,
                        tax_amount: tax_amount,
                        address_type: address_type,
                        address: address,
                        landmark: landmark,
                        pincode: pincode,
                        order_notes: order_notes,
                        transaction_type: transaction_type,
                        transaction_id: response.razorpay_payment_id,
                        name: name,
                        mobile: mobile,
                        email: email,
                        tax: tax,
                        tax_name: tax_name,
                        buynow: buynow,
                        country: country,
                        state: state,
                        city: city,
                        delivery_time: delivery_time,
                        delivery_date: delivery_date,
                    },
                    success: function (response) {
                        if (response.status == 1) {
                            ordersuccess(response.order_id, continueurl);
                        } else {
                            toastr.error(response.message);
                            $('.checkout').prop("disabled", false);
                            $('.checkout_loader').addClass('d-none');
                            return false;
                        }
                    },
                    error: function () {
                        toastr.error(wrong);
                        $('.checkout').prop("disabled", false);
                        $('.checkout_loader').addClass('d-none');
                        return false;
                    }
                });
            },
            "modal": {
                "ondismiss": function () {
                    $('.checkout').prop("disabled", false);
                    $('.checkout_loader').addClass('d-none');
                }
            },
            "prefill": {
                "name": name,
                "email": email,
                "contact": mobile,
            },
            "theme": {
                "color": "#366ed4"
            }
        };

        var rzp1 = new Razorpay(options);
        rzp1.open();
    }
    // stripe
    if (transaction_type == 4) {
        stripe.createToken(card).then(function (result) {
            if (result.error) {
                toastr.error(result.error.message);
                $('.checkout').prop("disabled", false);
                $('.checkout_loader').addClass('d-none');
                return false;
            } else {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: orderurl,
                    data: {
                        order_type: neworder_type,
                        delivery_charge: delivery_charge,
                        grand_total: total,
                        tax_amount: tax_amount,
                        address_type: address_type,
                        address: address,
                        landmark: landmark,
                        pincode: pincode,
                        order_notes: order_notes,
                        transaction_type: transaction_type,
                        name: name,
                        mobile: mobile,
                        email: email,
                        tax: tax,
                        tax_name: tax_name,
                        buynow: buynow,
                        country: country,
                        state: state,
                        city: city,
                        delivery_time: delivery_time,
                        delivery_date: delivery_date,
                        transaction_id: result.token.id,
                    },
                    method: 'POST',
                    success: function (response) {
                        if (response.status == 1) {
                            ordersuccess(response.order_id, continueurl);
                        } else {
                            toastr.error(response.message);
                            $('.checkout').prop("disabled", false);
                            $('.checkout_loader').addClass('d-none');
                            return false;
                        }
                    },
                    error: function () {
                        toastr.error(wrong);
                        $('.checkout').prop("disabled", false);
                        $('.checkout_loader').addClass('d-none');
                        return false;
                    }
                });
            }
        });
    }
    //Flutterwave
    if (transaction_type == 5) {
        FlutterwaveCheckout({
            public_key: $('#flutterwavekey').val(),
            tx_ref: name,
            amount: total,
            currency: transaction_currency,
            payment_options: "",
            customer: {
                name: name,
                email: email,
                phone_number: mobile,
            },
            callback: function (data) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: orderurl,
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        order_type: neworder_type,
                        delivery_charge: delivery_charge,
                        grand_total: total,
                        tax_amount: tax_amount,
                        address_type: address_type,
                        address: address,
                        landmark: landmark,
                        pincode: pincode,
                        order_notes: order_notes,
                        transaction_type: transaction_type,
                        transaction_id: data.flw_ref,
                        name: name,
                        mobile: mobile,
                        email: email,
                        tax: tax,
                        tax_name: tax_name,
                        buynow: buynow,
                        country: country,
                        state: state,
                        city: city,
                        delivery_time: delivery_time,
                        delivery_date: delivery_date,
                    },
                    success: function (response) {
                        if (response.status == 1) {
                            ordersuccess(response.order_id, continueurl);
                        } else {
                            toastr.error(wrong);
                            $('.checkout').prop("disabled", false);
                            $('.checkout_loader').addClass('d-none');
                        }
                    },
                    error: function () {
                        toastr.error(wrong);
                        $('.checkout').prop("disabled", false);
                        $('.checkout_loader').addClass('d-none');
                    }
                });
            },
            onclose: function () {
                $('.checkout').prop("disabled", false);
                $('.checkout_loader').addClass('d-none');
            },
            customizations: {
                title: "SingleRestaurant",
                description: 'Flutterwave Order payment',
                logo: "https://flutterwave.com/images/logo/logo-mark/full.svg",
            },
        });
    }
    //Paystack
    if (transaction_type == 6) {
        let handler = PaystackPop.setup({
            key: $('#paystackkey').val(),
            email: email,
            amount: parseInt(total * 100),
            currency: transaction_currency, // Use USD for US Dollars OR GHS for Ghana Cedis
            ref: 'trx_' + Math.random().toString(16).slice(2),
            label: "Paystack Order payment",
            onClose: function () {
                $('.checkout').prop("disabled", false);
                $('.checkout_loader').addClass('d-none');
            },
            callback: function (response) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: orderurl,
                    data: {
                        order_type: neworder_type,
                        delivery_charge: delivery_charge,
                        grand_total: total,
                        tax_amount: tax_amount,
                        address_type: address_type,
                        address: address,
                        landmark: landmark,
                        pincode: pincode,
                        order_notes: order_notes,
                        transaction_type: transaction_type,
                        transaction_id: response.trxref,
                        name: name,
                        mobile: mobile,
                        email: email,
                        tax: tax,
                        tax_name: tax_name,
                        buynow: buynow,
                        country: country,
                        state: state,
                        city: city,
                        delivery_time: delivery_time,
                        delivery_date: delivery_date,
                    },
                    method: 'POST',
                    success: function (response) {
                        if (response.status == 1) {
                            ordersuccess(response.order_id, continueurl);
                        } else {
                            toastr.error(wrong);
                            $('.checkout').prop("disabled", false);
                            $('.checkout_loader').addClass('d-none');
                            return false;
                        }
                    },
                    error: function () {
                        toastr.error(wrong);
                        $('.checkout').prop("disabled", false);
                        $('.checkout_loader').addClass('d-none');
                        return false;
                    }
                });
            }
        });
        handler.openIframe();
    }

    //mercadopago
    if (transaction_type == 7) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: mercadopagourl,
            data: {
                order_type: neworder_type,
                delivery_charge: delivery_charge,
                grand_total: total,
                tax_amount: tax_amount,
                address_type: address_type,
                address: address,
                landmark: landmark,
                pincode: pincode,
                order_notes: order_notes,
                transaction_type: transaction_type,
                name: name,
                mobile: mobile,
                email: email,
                successurl: paymentsuccess,
                failurl: paymentfail,
                tax: tax,
                tax_name: tax_name,
                buynow: buynow,
                country: country,
                state: state,
                city: city,
                delivery_time: delivery_time,
                delivery_date: delivery_date,
            },
            method: 'POST',
            success: function (response) {
                if (response.status == 1) {
                    window.location.href = response.redirecturl;
                } else {
                    toastr.error(response.message);
                    $('.checkout').prop("disabled", false);
                    $('.checkout_loader').addClass('d-none');
                    return false;
                }
            },
            error: function () {
                toastr.error(wrong);
                $('.checkout').prop("disabled", false);
                $('.checkout_loader').addClass('d-none');
                return false;
            }
        });
    }
    //myfatoorah
    if (transaction_type == 8) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: myfatoorahurl,
            data: {
                order_type: neworder_type,
                delivery_charge: delivery_charge,
                grand_total: total,
                tax_amount: tax_amount,
                address_type: address_type,
                address: address,
                landmark: landmark,
                pincode: pincode,
                order_notes: order_notes,
                transaction_type: transaction_type,
                name: name,
                mobile: mobile,
                email: email,
                successurl: paymentsuccess,
                failurl: paymentfail,
                tax: tax,
                tax_name: tax_name,
                buynow: buynow,
                country: country,
                state: state,
                city: city,
                delivery_time: delivery_time,
                delivery_date: delivery_date,
            },
            method: 'POST',
            success: function (response) {
                if (response.status == 1) {
                    window.location.href = response.nexturl;
                } else {
                    toastr.error(response.message);
                    $('.checkout').prop("disabled", false);
                    $('.checkout_loader').addClass('d-none');
                    return false;
                }
            },
            error: function () {
                toastr.error(wrong);
                $('.checkout').prop("disabled", false);
                $('.checkout_loader').addClass('d-none');
                return false;
            }
        });
    }


    //paypal
    if (transaction_type == 9) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: paypalurl,
            data: {
                order_type: neworder_type,
                delivery_charge: delivery_charge,
                grand_total: total,
                tax_amount: tax_amount,
                address_type: address_type,
                address: address,
                landmark: landmark,
                pincode: pincode,
                order_notes: order_notes,
                transaction_type: transaction_type,
                name: name,
                mobile: mobile,
                email: email,
                successurl: paymentsuccess,
                failurl: paymentfail,
                tax: tax,
                tax_name: tax_name,
                return: '1',
                buynow: buynow,
                country: country,
                state: state,
                city: city,
                delivery_time: delivery_time,
                delivery_date: delivery_date,
            },
            method: 'POST',
            success: function (response) {
                if (response.status == 1) {
                    $(".callpaypal").trigger("click")
                } else {
                    $('.checkout').prop("disabled", false);
                    $('.checkout_loader').addClass('d-none');
                    toastr.error(response.message);
                    return false;
                }
            },
            error: function () {
                toastr.error(wrong);
                $('.checkout').prop("disabled", false);
                $('.checkout_loader').addClass('d-none');
                return false;
            }
        });
    }
    //toyyibpay
    if (transaction_type == 10) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: toyyibpayurl,
            data: {
                order_type: neworder_type,
                delivery_charge: delivery_charge,
                grand_total: total,
                tax_amount: tax_amount,
                address_type: address_type,
                address: address,
                landmark: landmark,
                pincode: pincode,
                order_notes: order_notes,
                transaction_type: transaction_type,
                name: name,
                mobile: mobile,
                email: email,
                successurl: paymentsuccess,
                failurl: paymentfail,
                tax: tax,
                tax_name: tax_name,
                buynow: buynow,
                country: country,
                state: state,
                city: city,
                delivery_time: delivery_time,
                delivery_date: delivery_date,
            },
            method: 'POST',
            success: function (response) {
                if (response.status == 1) {
                    window.location.href = response.redirecturl;
                } else {
                    toastr.error(response.message);
                    $('.checkout').prop("disabled", false);
                    $('.checkout_loader').addClass('d-none');
                    return false;
                }
            },
            error: function () {
                toastr.error(wrong);
                $('.checkout').prop("disabled", false);
                $('.checkout_loader').addClass('d-none');
                return false;
            }
        });
    }
    //paytab
    if (transaction_type == 11) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: paytaburl,
            data: {
                order_type: neworder_type,
                delivery_charge: delivery_charge,
                grand_total: total,
                tax_amount: tax_amount,
                address_type: address_type,
                address: address,
                landmark: landmark,
                pincode: pincode,
                order_notes: order_notes,
                transaction_type: transaction_type,
                name: name,
                mobile: mobile,
                email: email,
                successurl: paymentsuccess,
                failurl: paymentfail,
                tax: tax,
                tax_name: tax_name,
                buynow: buynow,
                country: country,
                state: state,
                city: city,
                delivery_time: delivery_time,
                delivery_date: delivery_date,
            },
            method: 'POST',
            success: function (response) {
                if (response.status == 1) {
                    window.location.href = response.redirecturl;
                } else {
                    toastr.error(response.message);
                    $('.checkout').prop("disabled", false);
                    $('.checkout_loader').addClass('d-none');
                    return false;
                }
            },
            error: function () {
                toastr.error(wrong);
                $('.checkout').prop("disabled", false);
                $('.checkout_loader').addClass('d-none');
                return false;
            }
        });
    }
    //phonepe
    if (transaction_type == 12) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: phonepeurl,
            data: {
                order_type: neworder_type,
                delivery_charge: delivery_charge,
                grand_total: total,
                tax_amount: tax_amount,
                address_type: address_type,
                address: address,
                landmark: landmark,
                pincode: pincode,
                order_notes: order_notes,
                transaction_type: transaction_type,
                name: name,
                mobile: mobile,
                email: email,
                successurl: paymentsuccess,
                failurl: paymentfail,
                tax: tax,
                tax_name: tax_name,
                buynow: buynow,
                country: country,
                state: state,
                city: city,
                delivery_time: delivery_time,
                delivery_date: delivery_date,
            },
            method: 'POST',
            success: function (response) {
                if (response.status == 1) {
                    window.location.href = response.redirecturl;
                } else {
                    toastr.error(response.message);
                    $('.checkout').prop("disabled", false);
                    $('.checkout_loader').addClass('d-none');
                    return false;
                }
            },
            error: function () {
                toastr.error(wrong);
                $('.checkout').prop("disabled", false);
                $('.checkout_loader').addClass('d-none');
                return false;
            }
        });
    }

    //mollie
    if (transaction_type == 13) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: mollieurl,
            data: {
                order_type: neworder_type,
                delivery_charge: delivery_charge,
                grand_total: total,
                tax_amount: tax_amount,
                address_type: address_type,
                address: address,
                landmark: landmark,
                pincode: pincode,
                order_notes: order_notes,
                transaction_type: transaction_type,
                name: name,
                mobile: mobile,
                email: email,
                successurl: paymentsuccess,
                failurl: paymentfail,
                tax: tax,
                tax_name: tax_name,
                buynow: buynow,
                country: country,
                state: state,
                city: city,
                delivery_time: delivery_time,
                delivery_date: delivery_date,
            },
            method: 'POST',
            success: function (response) {
                if (response.status == 1) {
                    window.location.href = response.redirecturl;
                } else {
                    toastr.error(response.message);
                    $('.checkout').prop("disabled", false);
                    $('.checkout_loader').addClass('d-none');
                    return false;
                }
            },
            error: function () {
                toastr.error(wrong);
                $('.checkout').prop("disabled", false);
                $('.checkout_loader').addClass('d-none');
                return false;
            }
        });
    }

    //khalti
    if (transaction_type == 14) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: khaltiurl,
            data: {
                order_type: neworder_type,
                delivery_charge: delivery_charge,
                grand_total: total,
                tax_amount: tax_amount,
                address_type: address_type,
                address: address,
                landmark: landmark,
                pincode: pincode,
                order_notes: order_notes,
                transaction_type: transaction_type,
                name: name,
                mobile: mobile,
                email: email,
                successurl: paymentsuccess,
                failurl: paymentfail,
                tax: tax,
                tax_name: tax_name,
                buynow: buynow,
                country: country,
                state: state,
                city: city,
                delivery_time: delivery_time,
                delivery_date: delivery_date,
            },
            method: 'POST',
            success: function (response) {
                if (response.status == 1) {
                    window.location.href = response.redirecturl;
                } else {
                    toastr.error(response.message);
                    $('.checkout').prop("disabled", false);
                    $('.checkout_loader').addClass('d-none');
                    return false;
                }
            },
            error: function () {
                toastr.error(wrong);
                $('.checkout').prop("disabled", false);
                $('.checkout_loader').addClass('d-none');
                return false;
            }
        });
    }
}

function getoffercode(code) {
    "use strict";
    $('#offer_code').val(code);
}


