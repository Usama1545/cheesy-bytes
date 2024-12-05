@extends('admin.theme.default')
@section('content')
@include('admin.breadcrumb')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body">
                    <div class="table-responsive" id="table-display">
                        <table class="table table-striped table-bordered zero-configuration">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{trans('labels.name')}}</th>
                                    <th>{{trans('labels.email')}}</th>
                                    <th>{{trans('labels.message')}}</th>
                                    <th>{{trans('labels.action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @foreach ($getcontact as $contact)
                                <tr>
                                    <td>@php echo $i++; @endphp</td>
                                    <td>{{$contact->firstname}} {{$contact->lastname}}</td>
                                    <td>{{$contact->email}}</td>
                                    <td>{{$contact->message}}</td>
                                    <td>
                                        <a class="btn btn-sm btn-danger square" @if(env('Environment')=='sendbox') onclick="myFunction()" @else onclick="DeleteData('{{$contact->id}}','{{URL::to('admin/contact/destroy')}}')" @endif><i class="fa fa-trash"></i></a>
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
        function DeleteData(id, deleteurl) {
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
    </script>
@endsection