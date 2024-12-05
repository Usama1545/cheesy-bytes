function StatusUpdate(id, status, myurl) {
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
                    url: myurl,
                    data: { id: id, status: status },
                    method: 'POST',
                    success: function (response) {
                        if (response.status == 1) {
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
$(document).on("click", ".open-table-modal", function () {
    "use strict";
    $(".modal-body #bookingid").val($(this).data('id'));
    $(".modal-body #booking_number").val($(this).attr('data-booking-number'));
});
function set_table_number(status, tableurl) {
    "use strict";
    $('#preloader').show();
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: tableurl,
        method: 'POST',
        data: { 'id': $('#bookingid').val(), 'table_number': $('#table_number').val(), 'status': status },
        dataType: "json",
        success: function (response) {
            if (response.status == 1) {
                location.reload();
            } else {
                $('#preloader').hide();
                $('.table_error').show().html(response.message);
                $(".modal-body #bookingid").val(response.id);
            }
        }, error: function (response) {
            $('#preloader').hide();
            $('.table_error').show().html(response.message);
            $(".modal-body #bookingid").val(response.id);
            return false;
        }
    });
}