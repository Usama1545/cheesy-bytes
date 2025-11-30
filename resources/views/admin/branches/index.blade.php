@extends('admin.theme.default')
@section('content')
    @include('admin.breadcrumb')

    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h3>Branches</h3>
            <a href="branches/add" class="btn btn-primary">Add New <i class="fa fa-plus"></i></a>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="table-responsive" id="table-display">
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>State</th>
                                    <th>City</th>
                                    <th>status</th>
                                    <th>Zip Code</th>

                                    <th>Printer</th>
                                    <th>{{ trans('labels.action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $i = 1; @endphp
                                @foreach ($getitem as $item)
                                    <tr class="row1" data-id="{{ $item->id }}">
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->state?->name }}</td>
                                        <td>
                                            {{ $item->city }} <br>
                                        </td>
                                         <td>
                                            @if ($item->is_available == 1)
                                                <a class="btn btn-sm btn-success square" tooltip="{{ trans('labels.active') }}"
                                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="StatusUpdate('{{ $item->id }}','2','{{ URL::to('admin/branch/status') }}')" @endif><i
                                                        class="fa-sharp fa-solid fa-check"></i></a>
                                            @else
                                                <a class="btn btn-sm btn-danger square" tooltip="{{ trans('labels.deactive') }}"
                                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="StatusUpdate('{{ $item->id }}','1','{{ URL::to('admin/branch/status') }}')" @endif><i
                                                        class="fa-sharp fa-solid fa-xmark"></i></a>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $item->zip }}
                                        </td>
                                        <td>
                                            {{ $item->printer_id }} <br>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-1">
                                                <a class="btn btn-sm btn-info square" tooltip="{{ trans('labels.edit') }}"
                                                   href="{{ URL::to('admin/branches-' . $item->id) }}"> <i class="fa-solid fa-pen-to-square"></i></a>
                                                <a class="btn btn-sm btn-danger square" tooltip="{{ trans('labels.delete') }}"
                                                   @if (env('Environment') == 'sendbox') onclick="myFunction()"
                                                   @else onclick="Delete('{{ $item->id }}','{{ URL::to('admin/branches/delete') }}')" @endif>
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
    <script src="{{url(env('ASSETSPATHURL').'admin-assets/assets/js/custom/banner.js') }}"></script>

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
