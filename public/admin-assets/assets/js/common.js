$(window).on("load", function () {
    "use strict";
    $('#preloader').fadeOut('slow')
    if ($(".multimenu").find(".active")) {
        $(".multimenu").find(".active").parent().parent().addClass("show");
        $(".multimenu").find(".active").parent().parent().parent().attr("aria-expanded", true);
    }
});
$(function () {
    "use strict";
    for (var nk = window.location,
        o = $("ul#sidebar-mainmenu a").filter(function () {
            return this.href == nk;
        })
            .addClass("active")
            .parent()
            .addClass("active"); ;) {
        if (!o.is("li")) break;
        o = o.parent()
            .addClass("in")
            .parent()
            .addClass("active");
    }
});
$(function () {
    "use strict";
    $('#oldpassword').val('');
    var style = "";
    if (location.href.includes('home')) {
        style = "float:right !important;text-align:center;!important";
        $('.btn-orders-action').remove();
    }
    $('.zero-configuration').DataTable({
        dom: 'Bfrtip',
        searching: location.href.includes('dashboard') ? false : true,
        buttons: [{
            extend: 'excel',
            title: 'Single_Restaurant_Admin',
        },
        {
            extend: 'pdf',
            title: 'Single_Restaurant_Admin',
        }]
    });
    $('.dt-buttons').attr('style', style);
});



$(function () {
    $("#tabledetails").sortable({
        items: "tr",
        cursor: 'move',
        opacity: 0.6,
        update: function () {
            sendOrderToServer();
        }
    });

    function sendOrderToServer() {
        var order = [];
        $('tr.row1').each(function (index, element) {
            order.push({
                id: $(this).attr('data-id'),
                position: index + 1
            });
        });

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            dataType: "json",
            url: $('#tabledetails').attr('data-url'),
            data: {
                order: order,
            },
            success: function (response) {
                if (response.status == 1) {
                    toastr.success('Update sucess!!');
                } else {
                    console.log(response);
                }
            }
        });
    }
});


function myFunction() {
    "use strict";
    toastr.error("This operation was not performed due to demo mode");
}
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
})
$('.numbers_only').on('keyup', function () {
    "use strict";
    var val = $(this).val();
    if (isNaN(val)) {
        val = val.replace(/[^0-9\.]/g, '');
        if (val.split('.').length > 2) {
            val = val.replace(/\.+$/, "");
        }
    }
    $(this).val(val);
});
// For all sweet-alerts
const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-success mx-1',
        cancelButton: 'btn btn-danger mx-1'
    },
    buttonsStyling: false
})
function swal_cancelled(issettitle) {
    "use strict";
    var title = wrong;
    if (issettitle) {
        title = "" + issettitle + "";
    }
    swalWithBootstrapButtons.fire('Cancelled', title, 'error')
};
function logout(nexturl) {
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
function changeStatus(status, surl) {
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
            location.href = surl;
        } else {
            if ($('#open-close-switch').is(':checked')) {
                $('#open-close-switch').prop('checked', false);
            } else {
                $('#open-close-switch').prop('checked', true);
            }
            result.dismiss === Swal.DismissReason.cancel
        }
    })
}