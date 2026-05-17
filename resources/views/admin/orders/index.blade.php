@extends('admin.theme.default')
@section('content')
    @include('admin.breadcrumb')
    <div class="container-fluid">
        @if (auth()->user()->type == 1)
            <form method="GET" action="{{ url()->current() }}" class="row g-3 mb-4">

                {{-- From Date --}}
                <div class="col-md-2">
                    <label class="form-label">From Date</label>
                    <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                </div>

                {{-- To Date --}}
                <div class="col-md-2">
                    <label class="form-label">To Date</label>
                    <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                </div>

                {{-- Branch --}}
                <div class="col-md-3">
                    <label class="form-label">Select Branch</label>
                    <select name="branch_id" class="form-control selectpicker" data-live-search="true">
                        <option value="">All Branches</option>
                        @foreach (helper::get_branchs() as $branch)
                            <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Order From --}}
                <div class="col-md-2">
                    <label class="form-label">Order From</label>
                    <select name="order_from" class="form-control">
                        <option value="">All</option>
                        <option value="web" {{ request('order_from') == 'web' ? 'selected' : '' }}>Web</option>
                        <option value="api" {{ request('order_from') == 'api' ? 'selected' : '' }}>Mobile App</option>
                    </select>
                </div>

                {{-- Search --}}
                <div class="col-md-2">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Order # / Name"
                        value="{{ request('search') }}">
                </div>

                {{-- Submit --}}
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>

            </form>
        @endif
        @include('admin.orders.statistics')

        <div class="row">
            <div class="col-12 mb-3">
                <div class="card border-0 box-shadow h-100">
                    <div class="card-body">
                        <h5 class="card-title border-bottom pb-3 mb-3">
                            Orders
                        </h5>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ trans('labels.order_number') }}</th>
                                        <th>{{ trans('labels.date') }}</th>
                                        <th>Branch</th>
                                        <th>{{ trans('labels.order_type') }}</th>
                                        <th>{{ trans('labels.payment_type') }}</th>
                                        <th>Tip</th>
                                        <th>Order Amount</th>
                                        <th>{{ trans('labels.grand_total') }}</th>
                                        <th>Order From</th>
                                        <th>{{ trans('labels.status') }}</th>
                                        <th>{{ trans('labels.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($getorders as $key => $orderdata)
                                        <tr>
                                            <td>{{ $getorders->firstItem() + $key }}</td>

                                            <td>
                                                <a href="{{ url('admin/invoice/' . $orderdata->id) }}">
                                                    {{ $orderdata->order_number }}
                                                </a>
                                            </td>

                                            <td>{{ $orderdata->created_at->format('Y-m-d H:i:s') }}</td>

                                            <td>{{ $orderdata->branch->name ?? 'Unknown' }}</td>

                                            <td>
                                                {{ $orderdata->order_type == 1 ? 'Delivery' : ($orderdata->order_type == 2 ? 'Pickup' : 'POS') }}
                                            </td>

                                            <td>
                                                {{ helper::getpayment($orderdata->transaction_type) }}
                                                <br>
                                                <small
                                                    class="{{ $orderdata->payment_status == 2 ? 'text-success' : 'text-danger' }}">
                                                    {{ $orderdata->payment_status == 2 ? 'Paid' : 'Unpaid' }}
                                                </small>
                                            </td>

                                            <td>{{ helper::currency_format($orderdata->tip) }}</td>

                                            <td>{{ helper::currency_format($orderdata->grand_total - $orderdata->tip) }}
                                            </td>

                                            <td>{{ helper::currency_format($orderdata->grand_total) }}</td>

                                            <td>
                                                @if ($orderdata->order_from == 'web')
                                                    <small class="bg-warning text-white py-1 px-2 rounded">
                                                        Web App
                                                    </small>
                                                @else
                                                    <small class="bg-success text-white py-1 px-2 rounded">
                                                        Mobile App
                                                    </small>
                                                @endif
                                            </td>

                                            <td>
                                                {{ helper::gettype($orderdata->status, $orderdata->status_type, $orderdata->order_type)->name ?? '' }}
                                            </td>

                                            <td>
                                                <div class="d-flex flex-wrap gap-1">
                                                    <a class="btn btn-lg btn-secondary square" tooltip="View"
                                                        title="{{ trans('labels.view') }}"
                                                        href="{{ URL::to('admin/invoice/' . $orderdata->id) }}">
                                                        <i class="fa-regular fa-eye"></i>
                                                    </a>
                                                    <a class="btn btn-lg btn-primary square" tooltip="Print"
                                                        title="{{ trans('labels.print') }}"
                                                        href="{{ URL::to('admin/print/' . $orderdata->id) }}">
                                                        <i class="fa-regular fa-print"></i>
                                                    </a>
                                                    <a href="{{ URL::to('admin/generatepdf/' . $orderdata->id) }}"
                                                        class="btn btn-lg btn-warning square" tooltip="Download PDF">
                                                        <i class="fa-solid fa-file-pdf" aria-hidden="true"></i>
                                                    </a>
                                                    <!--                             <a href="{{ URL::to('admin/deleteOrder/' . $orderdata->id) }}" class="btn btn-danger square"-->
                                                    <!--    tooltip="Delete Order">-->
                                                    <!--    <i class="fa-solid fa-trash" aria-hidden="true"></i>-->
                                                    <!--</a>-->

                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11" class="text-center">No orders found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="mt-3">
                            {{ $getorders->links() }}
                        </div>
                    </div>
                </div>
            </div>
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
                                <input type="text" class="form-control numbers_only" name="modal_amount"
                                    id="modal_amount" value="" onkeyup="validation($(this).val())">
                                <label for="modal_amount" class="form-label mt-2">
                                    {{ trans('labels.change_amount') }}
                                </label>
                                <input type="number" class="form-control" name="ramin_amount" id="ramin_amount"
                                    value="" readonly>
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
