@extends('admin.theme.default')
@section('content')
    @include('admin.breadcrumb')

    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h3>Deals</h3>
            <a href="deals/add" class="btn btn-primary">Add New <i class="fa fa-plus"></i></a>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="table-responsive" id="table-display">
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Selective Product</th>
                                    <th>Offer Amount</th>
                                    <th>Start Date /Time</th>
                                    <th>End Date / Time</th>
                                    <th>{{ trans('labels.action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $i = 1; @endphp
                                @foreach ($deals as $item)
                                    <tr class="row1" data-id="{{ $item->id }}">
                                        <td>{{ $item->product->item_name }}</td>
                                        <td>{{ $item->min_count }}  </td>
                                        <td>{{ $item->offer_amount }}</td>
                                        <td>
                                            {{ helper::date_format($item->start_date) }} <br>
                                            {{ helper::time_format($item->start_time) }}
                                        </td>
                                        <td>
                                            {{ helper::date_format($item->end_date) }} <br>
                                            {{ helper::time_format($item->end_time) }}
                                        </td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-1">
                                                <a class="btn btn-sm btn-info square"
                                                   tooltip="{{ trans('labels.edit') }}"
                                                   href="{{ URL::to('admin/deals-' . $item->id) }}"> <i
                                                        class="fa-solid fa-pen-to-square"></i></a>
                                                <a class="btn btn-sm btn-danger square"
                                                   tooltip="{{ trans('labels.delete') }}"
                                                   onclick="Delete('{{ $item->id }}','{{ URL::to('admin/deals/delete') }}')">
                                                    <i class="fa fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
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

    </script>
@endsection
