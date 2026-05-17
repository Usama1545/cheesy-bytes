// for update item
$(document).ready(function () {
    "use strict";
    $('#addproduct').on('submit', function (event) {
        "use strict";
        event.preventDefault();
        var form_data = new FormData(this);
        form_data.append('file', $('#file')[0].files);
        $('#preloader').show();
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: $("#storeimagesurl").val(),
            method: "POST",
            data: form_data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (result) {
                $('#preloader').hide();
                var msg = '';
                $('div.gallery').html('');
                if (result.error.length > 0) {
                    for (var count = 0; count < result.error.length; count++) {
                        msg += '<div class="alert alert-danger">' + result.error[count] + '</div>';
                    }
                    $('#iiemsg').html(msg);
                    setTimeout(function () {
                        $('#iiemsg').html('');
                    }, 5000);
                } else {
                    msg += '<div class="alert alert-success mt-1">' + result.success + '</div>';
                    $('#message').html(msg);
                    $("#AddProduct").modal('hide');
                    $("#addproduct")[0].reset();
                    location.reload();
                }
            },
        })
    });
    $('#editimg').on('submit', function (event) {
        "use strict";
        event.preventDefault();
        var form_data = new FormData(this);
        $('#preloader').show();
        $.ajax({
            url: $("#updateimageurl").val(),
            method: 'POST',
            data: form_data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (result) {
                $('#preloader').hide();
                var msg = '';
                if (result.error.length > 0) {
                    for (var count = 0; count < result.error.length; count++) {
                        msg += '<div class="alert alert-danger">' + result.error[count] + '</div>';
                    }
                    $('#emsg').html(msg);
                    setTimeout(function () {
                        $('#emsg').html('');
                    }, 5000);
                } else {
                    location.reload();
                }
            },
        });
    });
});
//Global Extras
$("#extras_no").on("change", function () {
    "use strict";
    if ($("#extras_no").prop("checked") == true) {
        $("#extras").addClass("d-none");
        $('#add_extra').addClass('d-none');
        $("#add_extras").addClass("d-none");
        $("#globalextra").addClass("d-none");
        $('#extras input:text').prop('required', false);
    }
}).change();
$("#extras_yes").on("change", function () {
    "use strict";
    if ($("#extras_yes").prop("checked") == true) {
        $("#extras").removeClass("d-none");
        $('#add_extra').removeClass('d-none');
        $("#add_extras").removeClass("d-none");
        $("#globalextra").removeClass("d-none");
        $('#extras input:text').prop('required', true);
    }
}).change();


var extras_row = 1;

function extras_fields(name, price) {
    "use strict";
    extras_row++;
    var divtest = document.createElement("div");
    divtest.setAttribute("class", "form-group mb-0 removeextras" + extras_row);

    var options = branches.map(function (branch) {
        return '<option value="' + branch.id + '">' + branch.name + '-' + branch.city + '</option>';
    }).join('');

    divtest.innerHTML = '' +
        '<div class="row mb-md-0 mb-2 variations">' +
        '<div class="col-md-4">' +
        '<div class="form-group">' +
        '<input type="text" class="form-control" name="extras_name[]" placeholder="' + name + '" required>' +
        '</div>' +
        '</div>' +
        '<div class="col-md-3">' +
        '<div class="form-group">' +
        '<div class="d-flex gap-2">' +
        '<input type="number" step="any" class="form-control" name="extras_price[]" placeholder="' + price + '" required>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '<div class="col-md-3">' +
        '<div class="form-group">' +
        '<select name="extras_branch_id[]" class="form-control selectpicker" required data-live-search="true">' +
        options +
        '</select>' +
        '</div>' +
        '</div>' +
        '<div class="col-md-1">' +
        '<input type="checkbox" class="form-check-input" name="extras_default[]">' +
        '<label class="form-check-label" for="flexCheckDefault">' +
        '    Default' +
        '</label>' +
        '</div>' +
        '<div class="col-md-1">' +
        '<button class="btn btn-danger btn-sm px-3" type="button" onclick="remove_extras_fields(' + extras_row + ');">' +
        '<i class="fa fa-solid fa-trash"></i>' +
        '</button>' +
        '</div>' +
        '</div>';

    $("#more_extras_fields").append(divtest);

    $('.selectpicker').selectpicker('refresh');

}


function remove_extras_fields(rid) {
    "use strict";
    $(".removeextras" + rid).remove();
}

function more_editextras_fields(name, price) {
    "use strict";
    if (!$("span").hasClass("hiddenextrascount")) {
        $("#more_editextras_fields").prepend(
            '<span class="hiddenextrascount d-none">' + 1 + "</span>"
        );
    }
    var options = branches.map(function (branch) {
        return '<option value="' + branch.id + '">' + branch.name + '-' + branch.city + '</option>';
    }).join('');
    var editroom = $("span.hiddenextrascount:last()").html();
    editroom++;
    var editdivtest = document.createElement("div");
    editdivtest.setAttribute("class", "row mb-md-0 mb-2 editextrasclass" + editroom);
    editdivtest.innerHTML =
        '<input type="hidden" class="form-control" name="extras_id[]">' +
        '<div class="col-md-4">' +
        '<div class="form-group">' +
        '<input type="text" class="form-control" name="extras_name[]" placeholder="' + name + '" required>' +
        '</div>' +
        '</div>' +
        '<div class="col-md-3">' +
        '<div class="form-group">' +
        '<div class="d-flex gap-2">' +
        '<input type="number" step="any" class="form-control numbers_only" name="extras_price[]" placeholder="' + price + '" required>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '<div class="col-md-3">' +
        '<div class="form-group">' +
        '<div class="d-flex gap-2">' +
        '<select name="extras_branch_id[]" class="form-control selectpicker" required data-live-search="true">' + options + '</select>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '<div class="col-md-1">' +
        '<div class="form-group">' +
        '<div class="d-flex gap-2">' +
        '<input type="checkbox" class="form-check-input" name="extras_default[]" required>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '<div class="col-md-1">' +
        '<div class="form-group">' +
        '<div class="d-flex gap-2">' +
        '<button class="btn btn-danger px-3" type="button" onclick="remove_editextras_fields(' + editroom + ');">' +
        '<i class="fa-sharp fa-solid fa-trash"></i>' +
        '</button>' +
        '</div>' +
        '</div>' +
        '</div>'
    ;
    $("span.hiddenextrascount:last()").html(editroom);
    $("#more_editextras_fields").append(editdivtest);
    $('.selectpicker').selectpicker('refresh');

    if ($("#more_editextras_fields").find(".form-group").length > 1) {
        $(".extras_name, .extras_price").prop("required", true);
    }
}


function remove_editextras_fields(rid) {
    "use strict";
    $(".editextrasclass" + rid).remove();
    if ($("#more_editextras_fields").find(".form-group").length == 0) {
        $(".extras_name, .extras_price").prop("required", false);
    }
}

function global_extras(extrasurl, placehodername, placeholderprice) {
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: extrasurl,
        method: "get",
        success: function (response) {
            if (response.status == 1) {
                if (extras_row == 0) {
                    extras_row = 1;
                }
                var html = "";
                for (i in response.responsdata) {
                    {
                        extras_row++;
                        html +=
                            '<div class="row mb-md-0 mb-2 removeextras' +
                            extras_row +
                            '"><div class="col-md-6 form-group"><input type="text" class="form-control" name="extras_name[]" value="' +
                            response.responsdata[i].name +
                            '" placeholder="' +
                            placehodername +
                            '"></div><div class="col-md-6"><div class="d-flex gap-2"><input type="number" step="any" class="form-control numbers_only" value="' +
                            response.responsdata[i].price +
                            '" name="extras_price[]" placeholder="' +
                            placeholderprice +
                            '"><button class="btn btn-danger px-3" type="button" onclick="remove_extras_fields(' +
                            extras_row +
                            ');"><i class="fa-sharp fa-solid fa-trash"></i></button></div></div></div>';
                    }
                    $("#global-extras").html(html);
                }
            }
        },
        error: function (e) {
        }
    });
}

function updateItemImage(id, imageurl) {
    "use strict";
    $('#preloader').show();
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: imageurl,
        data: {id: id},
        method: 'POST',
        dataType: 'json',
        success: function (response) {
            $('#preloader').hide();
            jQuery("#EditImages").modal('show');
            $('#idd').val(response.ResponseData.id);
            $('.galleryim').html("<img src=" + response.ResponseData.img + " class='img-fluid rounded mx-h-200'>");
            $('#old_img').val(response.ResponseData.image);
        },
        error: function (error) {
            $('#preloader').hide();
        }
    })
}

function deleteItemExtras(id, item_id, deleteurl) {
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
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: deleteurl,
                    data: {id: id, item_id: item_id,},
                    method: 'POST',
                    success: function (response) {
                        if (response == 1) {
                            location.reload();
                        } else if (response == 2) {
                            swal_cancelled(last_image)
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

function deleteItemImage(id, item_id, deleteurl) {
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
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: deleteurl,
                    data: {id: id, item_id: item_id,},
                    method: 'POST',
                    success: function (response) {
                        if (response == 1) {
                            location.reload();
                        } else if (response == 2) {
                            swal_cancelled(last_image)
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

$('#cat_id').on('change', function () {
    "use strict";
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: $(this).attr('data-url'),
        data: {id: $(this).val()},
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.status == 1) {
                var html = '<option value="" selected>' + select + '</option>';
                $.each(response.data, function (key, value) {
                    html += '<option value="' + value.id + '" data-cat-id="' + value.cat_id + '">' + value.subcategory_name + '</option>';
                });
                $('#subcat_id').html(html);
            } else {
                $('.emsg').html(wrong)
            }
        },
        error: function (e) {
            $('.emsg').html(wrong)
        }
    });
});

$(document).ready(function () {
    "use strict";
    $('#image').on('change', function () {
        "use strict";
        if (this.files) {
            var filesAmount = this.files.length;
            $('div.gallery').html('');
            $('div.gallery').addClass('row px-3');
            var n = 0;
            for (var i = 0; i < filesAmount; i++) {
                var reader = new FileReader();
                reader.onload = function (event) {
                    $($.parseHTML('<div>')).attr('class', 'imgdiv col-lg-2 col-md-3 col-4 text-center pb-2').attr('id', 'img_' + n).html('<img src="' + event.target.result + '" class="img-fluid rounded">').appendTo('div.gallery');
                    n++;
                }
                reader.readAsDataURL(this.files[i]);
            }
        }
    });
});

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
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: statusurl,
                    data: {id: id, status: status},
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

function StatusFeatured(id, status, featuredurl) {
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
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: featuredurl,
                    data: {id: id, status: status},
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

// delete item
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
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: deleteurl,
                    data: {id: id},
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
