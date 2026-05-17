@extends('admin.theme.default')
@section('content')
@include('admin.breadcrumb')
<div class="container-fluid">
    <div class="row">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h3>Deal Notifications</h3>
            <a href="{{ route('admin.deal-notifications.create') }}" class="btn btn-primary">
                Add New <i class="fa fa-plus"></i>
            </a>        
        </div>
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body">
                    <div class="table-responsive" id="table-display">
                        <table class="table table-striped table-bordered zero-configuration">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Deal</th>
                                    <th>Repeat</th>
                                    <th>Date/Day</th>
                                    <th>Time</th>
                                    <th>{{ trans('labels.status') }}</th>
                                    <th>{{ trans('labels.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($notifications as $notification)
                                    <tr>
                                        <td>@php echo $i++; @endphp</td>
                                       <td>
                                            {{ $notification->deal?->product?->item_name ?? 'N/A' }}
                                        </td>

                                        {{-- Repeat --}}
                                        <td>
                                            {{ ucfirst($notification->repeat_type) }}
                                        </td>

                                        {{-- Date or Days --}}
                                        <td>
                                            @if ($notification->repeat_type === 'weekly')
                                                {{ implode(', ', array_map('ucfirst', $notification->days ?? [])) }}
                                            @else
                                                {{ optional($notification->date)->format('Y-m-d') }}
                                            @endif
                                        </td>

                                        {{-- Time --}}
                                        <td>
                                            {{ \Carbon\Carbon::parse($notification->time)->format('H:i') }}
                                        </td>
                                        
                                        <td>
                                            @if ($notification->is_active == 1)
                                                <a class="btn btn-sm btn-success square"
                                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="StatusUpdate('{{ $notification->id }}','2','{{ URL::to('admin/deal-notifications/status') }}')" @endif>
                                                    <i class="fa-sharp fa-solid fa-check"></i></a>
                                            @else
                                                <a class="btn btn-sm btn-danger square"
                                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="StatusUpdate('{{ $notification->id }}','1','{{ URL::to('admin/deal-notifications/status') }}')" @endif>
                                                    <i class="fa-sharp fa-solid fa-xmark"></i></a>
                                            @endif
                                        </td>
                                         <td>
                                            <a href="{{ route('admin.deal-notifications.edit', $notification->id) }}"
                                               class="btn btn-sm btn-info">
                                                <i class="fa fa-pen-to-square"></i>
                                            </a>

                                            <a class="btn btn-sm btn-danger "
                                                        tooltip="{{ trans('labels.delete') }}"
                                                        @if (env('Environment') == 'sendbox') onclick="myFunction()"
                                                   @else onclick="Delete('{{ $notification->id }}','{{ URL::to('admin/deal-notifications/delete') }}')" @endif>
                                                        <i class="fa fa-trash"></i></a>
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
<script src="{{url(env('ASSETSPATHURL').'admin-assets/assets/js/custom/employee.js')}}"></script>

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
                preConfirm: function() {
                    return new Promise(function(resolve, reject) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: deleteurl,
                            data: {
                                id: id
                            },
                            method: 'POST',
                            success: function(response) {
                                if (response == 1) {
                                    location.reload();
                                } else {
                                    swal_cancelled()
                                }
                            },
                            error: function(e) {
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
