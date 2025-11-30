@extends('admin.theme.default')
@section('content')
    @include('admin.breadcrumb')
    <div class="container-fluid">
        @include('admin.orders.statistics')
        <div class="row">
            @foreach($getorders as $branchOrder)
                {{-- todays-orders --}}
                <div class="col-12 mb-3">
                    <div class="card border-0 box-shadow h-100">
                        <div class="card-body">
                            <h5 class="card-title border-bottom pb-3 mb-3">Today's Orders - {{ $branchOrder['branch_name'] }}</h5>
                            <div class="table-responsive" id="table-display">
                                    <?php  $getorders =  $branchOrder['orders']?>
                                <table class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ trans('labels.order_number') }}</th>
                                        <th>{{ trans('labels.date') }}</th>
                                        <th>{{ trans('branch name') }}</th>
                                        <th>{{ trans('labels.order_type') }}</th>
                                        <th>{{ trans('labels.payment_type') }}</th>
                                         <th>Tip </th>
            <th>Order Amount</th>
            <th>{{ trans('labels.grand_total') }}</th>
                                        <th>{{ trans('labels.status') }}</th>
                                        <th>{{ trans('labels.action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($getorders as $key => $orderdata)
                                        <tr id="dataid{{ $orderdata['id'] }}">
                                            <td>{{ ++$key }}</td>
                                            <td>
                                                <div class="d-flex justify-content-between">
                                                    <a href="{{ URL::to('admin/invoice/' . $orderdata['id']) }}" class="text-dark">{{ $orderdata['order_number'] }}</a>
                                                    @if ($orderdata['admin_notes'] != null)
                                                        <a href="javascript:void(0)" class="btn btn-primary btn-sm hov square" tooltip="{{ $orderdata['admin_notes'] }}">
                                                            <i class="fa-solid fa-clipboard"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>{{ $orderdata['created_at'] }}</td>
                                            <td>{{ $branchOrder['branch_name'] }}</td>
                                            <td>
                                                @if ($orderdata['order_type'] == 1)
                                                    {{ trans('labels.delivery') }}
                                                @elseif ($orderdata['order_type'] == 2)
                                                    {{ trans('labels.pickup') }}
                                                @elseif ($orderdata['order_type'] == 3)
                                                    {{ trans('labels.pos') }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($orderdata['order_type'] == 3)
                                                    @if ($orderdata['transaction_type'] == 0)
                                                        {{ trans('labels.online') }}
                                                    @elseif ($orderdata['transaction_type'] == 1)
                                                        {{ trans('labels.cash') }}
                                                    @endif
                                                @else
                                                    {{ helper::getpayment($orderdata['transaction_type']) }}
                                                @endif
                                                <br>
                                                @if ($orderdata['payment_status'] == 1)
                                                    <small class="text-danger"> <i class="fa-regular fa-clock"></i>
                                                        {{ trans('labels.unpaid') }}</small>
                                                @else
                                                    <small class="text-success"> <i class="fa-regular fa-check"></i>
                                                        {{ trans('labels.paid') }}</small>
                                                @endif
                                            </td>
                                              <td>{{ helper::currency_format($orderdata['tip']) }}</td>
                <td>{{ helper::currency_format($orderdata['grand_total'] - $orderdata['tip']) }}</td>
                <td>{{ helper::currency_format($orderdata['grand_total']) }}</td>
                                            <td>
                                                @if ($orderdata['status_type'] == 1)
                                                    <small class="text-order-placed">{{ helper::gettype($orderdata['status'], $orderdata['status_type'], $orderdata['order_type'])->name }}</small>
                                                @elseif ($orderdata['status_type'] == 2)
                                                    <small class="text-order-waitingpickup">{{ helper::gettype($orderdata['status'], $orderdata['status_type'], $orderdata['order_type'])->name }}</small>
                                                @elseif ($orderdata['status_type'] == 3)
                                                    <small class="text-order-completed">{{ helper::gettype($orderdata['status'], $orderdata['status_type'], $orderdata['order_type'])->name }}</small>
                                                @elseif ($orderdata['status_type'] == 4)
                                                    <small class="text-order-cancelled">{{ helper::gettype($orderdata['status'], $orderdata['status_type'], $orderdata['order_type'])->name }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex flex-wrap gap-1">
                                                    <a class="btn btn-lg btn-secondary square" tooltip="View" title="{{ trans('labels.view') }}" href="{{ URL::to('admin/invoice/' . $orderdata['id']) }}">
                                                        <i class="fa-regular fa-eye"></i>
                                                    </a>
                                                    <a class="btn btn-lg btn-primary square" tooltip="Print" title="{{ trans('labels.print') }}" href="{{ URL::to('admin/print/' . $orderdata['id']) }}">
                                                        <i class="fa-regular fa-print"></i>
                                                    </a>
                                                    <a href="{{ URL::to('admin/generatepdf/' . $orderdata['id']) }}" class="btn btn-lg btn-warning square" tooltip="Download PDF">
                                                        <i class="fa-solid fa-file-pdf" aria-hidden="true"></i>
                                                    </a>
                        <!--                             <a href="{{ URL::to('admin/deleteOrder/' . $orderdata['id']) }}" class="btn btn-danger square"-->
                        <!--    tooltip="Delete Order">-->
                        <!--    <i class="fa-solid fa-trash" aria-hidden="true"></i>-->
                        <!--</a>-->
                                                    @if ($orderdata['transaction_type'] == 1 && $orderdata['payment_status'] == 1 && $orderdata['status_type'] == 3)
                                                        <a class="btn btn-sm btn-info square" tooltip="Payment Status" onclick="codpayment('{{ $orderdata['order_number'] }}','{{ $orderdata['grand_total'] }}')">
                                                            <i class="fa-solid fa-file-invoice-dollar"></i>
                                                        </a>
                                                    @endif
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
            @endforeach
        </div>
            {{-- top items --}}

    <!-- Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">{{ trans('labels.payment') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action=" {{ URL::to('admin/orders/payment_status-' . '2') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div>
                            <input type="hidden" id="booking_number" name="booking_number" value="">
                            <label for="modal_total_amount" class="form-label">
                                {{ trans('labels.total') }} {{ trans('labels.amount') }}
                            </label>
                            <input type="text" class="form-control numbers_only" name="modal_total_amount"
                                id="modal_total_amount" disabled value="">

                            <label for="modal_amount" class="form-label mt-2">
                                {{ trans('labels.cash_received') }}
                            </label>
                            <input type="text" class="form-control numbers_only" name="modal_amount" id="modal_amount"
                                value="" onkeyup="validation($(this).val())">
                            <label for="modal_amount" class="form-label mt-2">
                                {{ trans('labels.change_amount') }}
                            </label>
                            <input type="number" class="form-control" name="ramin_amount" id="ramin_amount" value=""
                                readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-secondary">{{ trans('labels.submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function codpayment(booking_number, grand_total) {
            $('#modal_total_amount').val(grand_total);
            $('#booking_number').val(booking_number);
            $('#paymentModal').modal('show');
        }

        function validation(value) {
            var remaining = $('#modal_total_amount').val() - value;
            $('#ramin_amount').val(remaining.toFixed(2));
        }
    </script>
    <script src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/orders.js') }}"></script>
@endsection
