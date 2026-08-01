// common-variables
var orderurl = $("#orderurl").val();
var continueurl = $("#continueurl").val();
var tax_amount = parseFloat($("#totaltaxamount").val());
var tax = $("#tax").val();
var tax_name = $("#tax_name").val();

// pickup-only: no order_type toggle anymore, just compute the total once.
$(document).ready(function ($) {
    "use strict";
    var sub_total = parseFloat($("#sub_total").val()) || 0;
    var totaltax = parseFloat($("#totaltaxamount").val()) || 0;
    var totalOfferDiscount = parseFloat($("#totalOfferDiscount").val()) || 0;
    var discount = parseFloat($("#discount").val()) || 0;
    var total = sub_total + totaltax - totalOfferDiscount - discount;

    $("#shipping_charge").val(0);
    $("#delivery_amount").html(currency_format(0));
    $("#total_amount").html(currency_format(total));
    $("#grand_total").val(total);
});

$("#delivery_dt").on("change", function () {
    "use strict";
    setTimeout(() => {
        const inputDate = $("#delivery_dt").val();
        console.log("[checkout] pickup date selected:", inputDate);
        if (inputDate) {
            $("#delivery_slot_time").empty();
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content",
                    ),
                },
                url: $("#sloturl").val(),
                type: "post",
                dataType: "json",
                data: {
                    inputDate: inputDate,
                },
                success: function (response) {
                    if (response == "1") {
                        $("#store_close").removeClass("d-none");
                        $("#delivery_slot_time").addClass("d-none");
                    } else {
                        $("#store_close").addClass("d-none");
                        $("#delivery_slot_time").removeClass("d-none");
                        $("#delivery_slot_time").append(
                            '<option value="">' + select + "</option>",
                        );
                        for (var i in response) {
                            $("#delivery_slot_time").append(
                                '<option value="' +
                                    response[i]["slot"] +
                                    '">' +
                                    response[i]["slot"] +
                                    "</option>",
                            );
                        }
                    }
                },
                error: function (xhr) {
                    console.log(
                        "[checkout] timeslot ajax error",
                        xhr && xhr.status,
                        xhr && xhr.responseText,
                    );
                },
            });
        }
    }, 100); // Delay of 100ms
});

function isopenclose(opencloseurl, qty, order_amount) {
    "use strict";
    console.log("[checkout] isopenclose: checking if restaurant is open");
    $(".checkout").prop("disabled", true);
    $(".checkout_loader").removeClass("d-none");
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: opencloseurl,
        data: {
            qty: qty,
            order_amount: order_amount,
            buynow: $("#buynow").val(),
        },
        method: "post",
        success: function (response) {
            console.log("[checkout] isopenclose response:", response);
            $(".checkout").prop("disabled", false);
            $(".checkout_loader").addClass("d-none");
            try {
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
            } catch (e) {
                console.log("[checkout] isopenclose: exception handling response", e);
                toastr.error(wrong);
            }
        },
        error: function (xhr) {
            console.log(
                "[checkout] isopenclose ajax error",
                xhr && xhr.status,
                xhr && xhr.responseText,
            );
            $(".checkout").prop("disabled", false);
            $(".checkout_loader").addClass("d-none");
            toastr.error(wrong);
            return false;
        },
    });
}

function validatedata() {
    "use strict";
    console.log("[checkout] validatedata: start");

    try {
        var neworder_type = $("input:radio[name=order_type]:checked").val();

        if ($("#delivery_dt").val() == "") {
            console.log("[checkout] validatedata: blocked - pickup date missing");
            toastr.error($("#pickup_date_message").val());
            return false;
        }
        if ($("#delivery_slot_time").val() == "") {
            console.log("[checkout] validatedata: blocked - pickup time missing");
            toastr.error($("#pickup_time_message").val());
            return false;
        }
        if ($("#first_name").val() == "") {
            console.log("[checkout] validatedata: blocked - first name missing");
            toastr.error($("#first_name_message").val());
            return false;
        }
        if ($("#last_name").val() == "") {
            console.log("[checkout] validatedata: blocked - last name missing");
            toastr.error($("#last_name_message").val());
            return false;
        }
        if ($("#email").val() == "") {
            console.log("[checkout] validatedata: blocked - email missing");
            toastr.error($("#email_message").val());
            return false;
        }
        if ($("#mobile").val() == "") {
            console.log("[checkout] validatedata: blocked - mobile missing");
            toastr.error($("#mobile_message").val());
            return false;
        }
        if ($('input[name="transaction_type"]:checked').length <= 0) {
            console.log("[checkout] validatedata: blocked - no payment method selected");
            toastr.error($("#payment_type_message").val());
            return false;
        }

        $(".checkout").prop("disabled", true);
        $(".checkout_loader").removeClass("d-none");

        var name = $("#first_name").val() + " " + $("#last_name").val();
        var email = $("#email").val();
        var mobile = $("#mobile").val();
        var address = $("#new_address").val();
        var order_notes = $("#order_notes").val();
        var tip = $("#tip").val();
        var transaction_type = $(
            "input:radio[name=transaction_type]:checked",
        ).val();
        var tax_amount = parseFloat($("#totaltaxamount").val());
        var total = parseFloat($("#grand_total").val());
        var buynow = $("#buynow").val();
        var delivery_time = $("#delivery_slot_time").val();
        var delivery_date = $("#delivery_dt").val();

        var payload = {
            order_type: neworder_type,
            grand_total: total,
            tax_amount: tax_amount,
            address: address,
            order_notes: order_notes,
            tip: tip,
            transaction_type: transaction_type,
            name: name,
            mobile: mobile,
            email: email,
            tax: tax,
            tax_name: tax_name,
            buynow: buynow,
            delivery_time: delivery_time,
            delivery_date: delivery_date,
        };

        // Stripe (hosted checkout) is the only supported payment method;
        // backend always redirects to Stripe's hosted checkout page.
        console.log("[checkout] validatedata: posting order", payload);

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: orderurl,
            data: payload,
            method: "POST",
            success: function (response) {
                console.log("[checkout] placeorder response:", response);
                if (response.status == 1) {
                    window.location.href = response.redirecturl;
                } else {
                    toastr.error(response.message);
                    $(".checkout").prop("disabled", false);
                    $(".checkout_loader").addClass("d-none");
                }
            },
            error: function (xhr) {
                console.log(
                    "[checkout] placeorder ajax error",
                    xhr && xhr.status,
                    xhr && xhr.responseText,
                );
                toastr.error(wrong);
                $(".checkout").prop("disabled", false);
                $(".checkout_loader").addClass("d-none");
            },
        });
    } catch (e) {
        console.log("[checkout] validatedata: exception", e);
        toastr.error(wrong);
        $(".checkout").prop("disabled", false);
        $(".checkout_loader").addClass("d-none");
    }
}

function getoffercode(code) {
    "use strict";
    $("#offer_code").val(code);
}
