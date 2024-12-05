@extends('admin.theme.default')
@section('content')
    @include('admin.breadcrumb')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 my-2 d-flex justify-content-end">
                @if ($getdriver->count() > 0)
                    @if ($orderdata->order_type == 1 && ($orderdata->status_type == 1 || $orderdata->status_type == 2))
                        <select class="form-select w-25 mx-1" name="driver" id="driver" tooltip="assign deliveryman">
                            <option value="0">{{ trans('labels.select') }}</option>
                            @foreach ($getdriver as $driver)
                                <option value="{{ $driver->id }}"
                                    {{ $orderdata->driver_id == $driver->id ? 'selected' : '' }}>{{ $driver->name }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                @endif
                
                @if ($orderdata->status_type == 1 || $orderdata->status_type == 2)
                    <button type="button" class="btn btn-dark dropdown-toggle px-4 py-2"
                        data-bs-toggle="dropdown">{{ @helper::gettype($orderdata->status, $orderdata->status_type, $orderdata->order_type)->name == null ? trans('labels.action') : @helper::gettype($orderdata->status, $orderdata->status_type, $orderdata->order_type)->name }}</button>
                    <div class="dropdown-menu dropdown-menu-right branch-only cursor-pointer">
                        @foreach (helper::customstauts($orderdata->order_type) as $status)
                            <a class="dropdown-item w-auto @if ($orderdata->status == $status->id) fw-600 @endif"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $status->name }}"
                                onclick="OrderStatusUpdate('{{ $orderdata->id }}','{{ $status->id }}','{{ $status->type }}','{{ URL::to('admin/orders/update') }}')">
                                {{ $status->name }} </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row justify-content-between g-md-4 g-lg-4">
                    <div class="col-xl-3 col-md-6">

                        <div class="card border-0 mb-3 h-100 d-flex shadow">
                            <div
                                class="card-header d-flex align-items-center bg-transparent text-dark py-3 justify-content-between">
                                <h6 class="px-2 fw-500"><i class="fa-solid fa-clipboard fs-5"></i>
                                    {{ trans('labels.your_order_details') }}</h6>
                            </div>
                            <div class="card-body">
                                <div class="basic-list-group">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item px-0 fs-7 fw-400 d-flex justify-content-between align-items-center">
                                            <p>{{ trans('labels.order_number') }}</p>
                                            <p class="text-dark fw-600">{{ $orderdata->order_number }}</p>
                                        </li>
                                        <li class="list-group-item px-0 fs-7 fw-400 d-flex justify-content-between align-items-center">
                                            {{ trans('labels.order_date') }}
                                            <p class="text-muted">
                                                {{ helper::date_format($orderdata->created_at) }}</p>
                                        </li>
                                        @if ($orderdata->delivery_date != '')
                                            <li class="list-group-item px-0 fs-7 fw-400 d-flex justify-content-between align-items-center">
                                                {{ $orderdata->order_type == '1' ? trans('labels.delivery_date') : trans('labels.pickup_date') }}
                                                <p class="text-muted">
                                                    {{ helper::date_format($orderdata->delivery_date) }}</p>
                                            </li>
                                        @endif
                                        @if ($orderdata->delivery_time != '')
                                            <li class="list-group-item px-0 fs-7 fw-400 d-flex justify-content-between align-items-center">
                                                {{ $orderdata->order_type == '1' ? trans('labels.delivery_time') : trans('labels.pickup_time') }}
                                                <p class="text-muted">
                                                    {{ $orderdata->delivery_time }}</p>
                                            </li>
                                        @endif

                                        <li class="list-group-item px-0 fs-7 fw-400 d-flex justify-content-between align-items-center">
                                            {{ trans('labels.payment_type') }}
                                            <p class="text-muted">
                                                @if ($orderdata->order_type == 3)
                                                    @if ($orderdata->transaction_type == 0)
                                                        {{ trans('labels.online') }}
                                                    @elseif ($orderdata->transaction_type == 1)
                                                        {{ trans('labels.cash') }}
                                                    @endif
                                                @else
                                                    {{ helper::getpayment($orderdata->transaction_type) }}
                                                @endif
                                            </p>
                                        </li>

                                        @if (in_array($orderdata->transaction_type, [3, 4, 5, 6, 7, 8, 9, 10]))
                                            <li class="list-group-item px-0 fs-7 fw-400 d-flex justify-content-between align-items-center">
                                                {{ trans('labels.transaction_id') }}
                                                <p class="text-muted">
                                                    {{ $orderdata->transaction_id }}
                                                </p>
                                            </li>
                                        @endif
                                        @if ($orderdata->order_notes != '')
                                            <li class="list-group-item px-0">{{ trans('labels.order_note') }}
                                                <p class="text-muted">
                                                    {{ $orderdata->order_notes }}
                                                </p>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card border-0 mb-3 h-100 d-flex shadow">
                            <div
                                class="card-header d-flex align-items-center bg-transparent text-dark py-3 justify-content-between">
                                <h6 class="px-2 fw-500"><i class="fa-solid fa-user fs-5"></i>
                                    {{ trans('labels.customer_info') }}
                                </h6>
                                <p class="text-muted cursor-pointer"
                                    onclick="editcustomerdata('{{ $orderdata->order_number }}','{{ $orderdata->name }}','{{ $orderdata->mobile }}','{{ $orderdata->email }}','{{ $orderdata->address }}','{{ $orderdata->city }}','{{ $orderdata->state }}','{{ $orderdata->country }}','{{ $orderdata->landmark }}','{{ $orderdata->postal_code }}','customer_info')">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </p>
                            </div>
                            <div class="card-body">
                                <div class="basic-list-group">
                                    <div class="row">
                                        <div class="basic-list-group">
                                            <ul class="list-group list-group-flush">
                                                <li
                                                    class="list-group-item px-0 fs-7 fw-400 d-flex justify-content-between align-items-center">
                                                    <p>{{ trans('labels.name') }}</p>
                                                    <p class="text-muted">
                                                        {{ $orderdata->name }}
                                                    </p>
                                                </li>
                                                <li class="list-group-item px-0 fs-7 fw-400 d-flex justify-content-between align-items-center">
                                                    <p>{{ trans('labels.mobile') }}</p>
                                                    <p class="text-muted">
                                                        {{ $orderdata->mobile }}
                                                    </p>
                                                </li>
                                                <li class="list-group-item px-0 fs-7 fw-400 d-flex justify-content-between align-items-center">
                                                    <p>{{ trans('labels.email') }}</p>
                                                    <p class="text-muted">
                                                        {{ $orderdata->email }}
                                                    </p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card border-0 mb-3 h-100 d-flex shadow">
                            <div
                                class="card-header d-flex align-items-center bg-transparent text-dark py-3 justify-content-between">
                                <h6 class="px-2 fw-500"><i class="fa-solid fa-file-invoice fs-5"></i>
                                    {{ $orderdata->order_type == '2' ? trans('labels.info') : trans('labels.bill_to') }}
                                </h6>
                                @if ($orderdata->order_from != 'pos' && $orderdata->order_type == '1')
                                    <p class="text-muted cursor-pointer"
                                        onclick="editcustomerdata('{{ $orderdata->order_number }}','{{ $orderdata->name }}','{{ $orderdata->mobile }}','{{ $orderdata->email }}','{{ $orderdata->address }}','{{ $orderdata->city }}','{{ $orderdata->state }}','{{ $orderdata->country }}','{{ $orderdata->landmark }}','{{ $orderdata->postal_code }}','bill_info')">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </p>
                                @endif
                            </div>
                            <div class="card-body">
                                <div class="basic-list-group">
                                    <div class="row">
                                        <div class="col-md-12 mb-2">
                                            <div class="basic-list-group">
                                                <ul class="list-group list-group-flush">
                                                    @if ($orderdata->order_from == 'pos')
                                                        <li
                                                            class="list-group-item px-0 fs-7 fw-400 d-flex justify-content-between align-items-center">
                                                            <p>{{ trans('labels.pos') }}</p>
                                                        </li>
                                                    @elseif ($orderdata->order_from == 'web' && $orderdata->order_type == '2')
                                                        <li
                                                            class="list-group-item px-0 fs-7 fw-400 d-flex justify-content-between align-items-center">
                                                            <p>{{ trans('labels.take_away') }}</p>
                                                        </li>
                                                    @else
                                                        <li
                                                            class="list-group-item px-0 fs-7 fw-400 d-flex justify-content-between align-items-center">
                                                            <p>{{ trans('labels.address') }}</p>
                                                            <p class="text-muted">{{ $orderdata->address }}</p>
                                                        </li>
                                                        <li class="list-group-item px-0 fs-7 fw-400 d-flex justify-content-between align-items-center">
                                                            <p>{{ trans('labels.city') }}</p>
                                                            <p class="text-muted"> {{ $orderdata->city }}</p>
                                                        </li>
                                                        <li class="list-group-item px-0 fs-7 fw-400 d-flex justify-content-between align-items-center">
                                                            <p>{{ trans('labels.state') }}</p>
                                                            <p class="text-muted"> {{ $orderdata->state }}</p>
                                                        </li>
                                                        <li class="list-group-item px-0 fs-7 fw-400 d-flex justify-content-between align-items-center">
                                                            <p>{{ trans('labels.country') }}</p>
                                                            <p class="text-muted"> {{ $orderdata->country }}</p>
                                                        </li>
                                                        <li class="list-group-item px-0 fs-7 fw-400 d-flex justify-content-between align-items-center">
                                                            <p>{{ trans('labels.landmark') }}</p>
                                                            <p class="text-muted"> {{ $orderdata->landmark }}</p>
                                                        </li>
                                                        <li class="list-group-item px-0 fs-7 fw-400 d-flex justify-content-between align-items-center">
                                                            <p>{{ trans('labels.pincode') }}</p>
                                                            <p class="text-muted"> {{ $orderdata->postal_code }}</p>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card border-0 mb-3 h-100 d-flex shadow">
                            <div
                                class="card-header d-flex align-items-center bg-transparent text-dark py-3 justify-content-between">
                                <h6 class="px-2 fw-500"><i class="fa-solid fa-clipboard fs-5"></i>
                                    {{ trans('labels.notes') }}</h6>
                            </div>
                            <div class="card-body">
                                <div class="basic-list-group">
                                    <div class="row">
                                        <div class="basic-list-group">
                                            @if ($orderdata->admin_notes != '')
                                                <div class="alert alert-info" role="alert">
                                                    {{ $orderdata->admin_notes }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-white">
                                <form action="{{ URL::to('admin/orders/order_note') }}" method="POST">
                                    @csrf
                                    <div class="form-group col-md-12">
                                        <label for="note"> {{ trans('labels.note') }} </label>
                                        <div class="controls">
                                            <input type="hidden" name="order_id" class="form-control"
                                                value="{{ $orderdata->order_number }}">
                                            <input type="text" name="admin_notes" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                        <button
                                            @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" type="submit" @endif
                                            class="btn btn-primary"> {{ trans('labels.update') }} </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 mt-4">
                    <div class="card-header d-flex align-items-center bg-transparent text-dark py-3">
                        <i class="fa-solid fa-bag-shopping fs-5"></i>
                        <h6 class="px-2 fw-500">{{ trans('labels.orders') }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>{{ trans('labels.image') }}</th>
                                        <th>{{ trans('labels.item') }}</th>
                                        <th class="text-end">{{ trans('labels.unit_cost') }}</th>
                                        <th class="text-end">{{ trans('labels.qty') }}</th>
                                        <th class="text-end">{{ trans('labels.total') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $data = [];
                                    @endphp
                                    @foreach ($ordersdetails as $orders)
                                        @php
                                            $total_price =
                                                ($orders['item_price'] +
                                                    $orders['addons_total_price'] +
                                                    $orders['extras_total_price']) *
                                                $orders['qty'];
                                            $data[] = ['total_price' => $total_price];
                                            $order_total = array_sum(array_column(@$data, 'total_price'));
                                            $addonstotal = $orders->addons_total_price + $orders->extras_total_price;
                                        @endphp
                                        <tr>
                                            <td><img src="{{ helper::image_path($orders->item_image) }}"
                                                    class="rounded h-50px" alt=""></td>
                                            <td>
                                                <img @if ($orders['item_type'] == 1) src="{{ helper::image_path('veg.svg') }}" @else src="{{ helper::image_path('nonveg.svg') }}" @endif
                                                    class="item-type-img" alt="">
                                                {{ $orders->item_name }} <br>
                                                @if ($orders['addons_id'] != '' || $orders['extras_id'] != '')
                                                    <small>
                                                        <a class="text-muted fw-500" href="javascript:void(0)"
                                                            onclick="showaddons('{{ $orders['addons_name'] }}','{{ $orders['addons_price'] }}','{{ $orders['extras_name'] }}','{{ $orders['extras_price'] }}','{{ $orders['item_name'] }}')">{{ trans('labels.customize') }}
                                                        </a>
                                                    </small>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                {{ helper::currency_format($orders->item_price) }}
                                                @if ($addonstotal != 0)
                                                    <br><small class="text-muted">+
                                                        {{ helper::currency_format($addonstotal) }}</small>
                                                @endif
                                            </td>
                                            <td class="text-end">{{ $orders->qty }}</td>
                                            <td class="text-end">
                                                {{ helper::currency_format($total_price) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td class="text-end" colspan="4">
                                            <p class="fw-400">{{ trans('labels.subtotal') }}</p>
                                        </td>
                                        <td class="text-end">
                                            <p class="fw-400">{{ helper::currency_format($order_total) }}</p>
                                        </td>
                                    </tr>
                                    @if ($orderdata->discount_amount > 0)
                                        <tr>
                                            <td class="text-end" colspan="4">
                                                <p class="fw-400">{{ trans('labels.discount') }}</p>
                                                {{ $orderdata->offer_code != '' ? '(' . $orderdata->offer_code . ')' : '' }}
                                            </td>
                                            <td class="text-end">
                                                <p class="fw-400">-
                                                    {{ helper::currency_format($orderdata->discount_amount) }}</p>
                                            </td>
                                        </tr>
                                    @endif
                                    @php
                                        $tax = explode('|', $orderdata->tax_amount);
                                        $tax_name = explode('|', $orderdata->tax_name);
                                    @endphp
                                    @if ($orderdata->tax_amount != null && $orderdata->tax_amount != '')
                                        @foreach ($tax as $key => $tax_value)
                                            <tr>
                                                <td class="text-end" colspan="4">
                                                    <p class="fw-400">{{ $tax_name[$key] }}</p>
                                                </td>
                                                <td class="text-end">
                                                    <p class="fw-400">{{ helper::currency_format($tax_value) }}</p>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    @if ($orderdata->delivery_charge > 0)
                                        <tr>
                                            <td class="text-end" colspan="4">
                                                <p class="fw-400">{{ trans('labels.delivery_charge') }}</p>
                                            </td>
                                            <td class="text-end">
                                                <p class="fw-400">{{ helper::currency_format($orderdata->delivery_charge) }}</p>
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td class="text-end" colspan="4">
                                            <strong>{{ trans('labels.grand_total') }}</strong>
                                        </td>
                                        <td class="text-end">
                                            <strong>{{ helper::currency_format($orderdata->grand_total) }}</strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Customer and Bill info Modal-->
        <div class="modal fade" id="customerinfo" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header justify-content-between">
                        <h5 class="modal-title" id="modalbankdetailsLabel">{{ trans('labels.edit') }}</h5>
                        <button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form enctype="multipart/form-data" action="{{ URL::to('admin/orders/customerbillinfo') }}"
                        method="POST">
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" name="order_id" id="modal_order_id" class="form-control"
                                value="">
                            <input type="hidden" name="edit_type" id="edit_type" class="form-control" value="">
                            <div id="customer_info">
                                <div class="form-group col-md-12">
                                    <label for="user_name"> {{ trans('labels.name') }} </label>
                                    <div class="controls">
                                        <input type="text" name="user_name" id="user_name" class="form-control"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="user_mobile"> {{ trans('labels.mobile') }} </label>
                                    <div class="controls">
                                        <input type="text" name="user_mobile" id="user_mobile" class="form-control"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="user_email"> {{ trans('labels.email') }} </label>
                                    <div class="controls">
                                        <input type="text" name="user_email" id="user_email" class="form-control"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div id="bill_info">
                                <div class="form-group col-md-12">
                                    <label for="bill_address"> {{ trans('labels.address') }} </label>
                                    <div class="controls">
                                        <input type="text" name="bill_address" id="bill_address" class="form-control"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="bill_city"> {{ trans('labels.city') }} </label>
                                    <div class="controls">
                                        <input type="text" name="bill_city" id="bill_city" class="form-control"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="bill_state"> {{ trans('labels.state') }} </label>
                                    <div class="controls">
                                        <input type="text" name="bill_state" id="bill_state" class="form-control"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="bill_country"> {{ trans('labels.country') }} </label>
                                    <div class="controls">
                                        <input type="text" name="bill_country" id="bill_country" class="form-control"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="bill_landmark"> {{ trans('labels.landmark') }} </label>
                                    <div class="controls">
                                        <input type="text" name="bill_landmark" id="bill_landmark"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="bill_pincode"> {{ trans('labels.pincode') }} </label>
                                    <div class="controls">
                                        <input type="text" name="bill_pincode" id="bill_pincode" class="form-control"
                                            required>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger"
                                data-bs-dismiss="modal">{{ trans('labels.close') }}</button>
                            <button
                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" type="submit" @endif
                                class="btn btn-primary"> {{ trans('labels.save') }} </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- MODAL_SELECTED_ADDONS--START -->
        <div class="modal addons fade" id="modal_selected_addons" tabindex="-1" aria-labelledby="selected_addons_Label"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header justify-content-between">
                        <div class="pro-name d-flex gap-1 align-items-center">
                            <p class="mb-0 fw-600 fs-5" id="addon_item_name"></p>
                        </div>
                        <button type="button"
                            class="btn-close m-0 {{ session()->get('direction') == 2 ? 'close m-0' : '' }}"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-0">
                        <!-- Addons -->
                        <div class="mt-2 p-2 border-bottom d-none" id="addons">
                            <p class="m-0 fs-6 fw-500">{{ trans('labels.addons') }}</p>
                            <ul class="m-0 {{ session()->get('direction') == '2' ? 'pe-2' : 'ps-2' }}" id="item-addons"></ul>
                        </div>
                        <!-- Extras -->
                        <div class="mt-2 p-2 border-bottom d-none" id="extras">
                            <p class="m-0 fs-6 fw-500">{{ trans('labels.extras') }} </p>
                            <ul class="m-0 {{ session()->get('direction') == '2' ? 'pe-2' : 'ps-2' }}" id="item-extras"></ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL_SELECTED_ADDONS--END -->
    </div>
@endsection
@section('script')
    <script src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/orders.js') }}"></script>
    <script>
        function showaddons(addon_name, addon_price, extra_name, extra_price, item_name) {
            "use strict";
            $('#addons').addClass('d-none');
            $('#extras').addClass('d-none');
            $('#modal_selected_addons').find('#addon_item_name').html(item_name);
            var response1 = '';
            if (addon_name.split('| ') != '') {
                $.each(addon_name.split('| '), function(key, value) {
                    response1 += '<li class="list-group-item fs-7 d-flex justify-content-between text-black">' + value +
                        ' <p class="mb-0">' + currency_format(addon_price.split('| ')[key]) + '</p> </li>';
                });
                $('#addons').removeClass('d-none');
            }
            $('#item-addons').html(response1);
            var response2 = '';
            if (extra_name.split('| ') != '') {
                $.each(extra_name.split('| '), function(key, value) {
                    response2 += '<li class="list-group-item fs-7 d-flex justify-content-between text-black"> ' + value +
                        ' <p class="mb-0">' + currency_format(extra_price.split('| ')[key]) + '</p> </li>';
                });
                $('#extras').removeClass('d-none');
            }
            $('#item-extras').html(response2);
            $('#modal_selected_addons').modal('show');
        }

        function editcustomerdata(order_id, customer_name, customer_mobile, customer_email, bill_address, bill_city,
            bill_state, bill_country, bill_landmark, bill_pincode, type) {
            "use strict";
            $('#modal_order_id').val(order_id);
            if (type == "customer_info") {
                $('#user_name').val(customer_name);
                $('#user_mobile').val(customer_mobile);
                $('#user_email').val(customer_email);
                $('#edit_type').val(type);
                $('#bill_info').hide();
                $('#customer_info').show();
                $('#bill_address').removeAttr('required');
                $('#bill_city').removeAttr('required');
                $('#bill_state').removeAttr('required');
                $('#bill_country').removeAttr('required');
                $('#bill_landmark').removeAttr('required');
                $('#bill_pincode').removeAttr('required');
            } else {
                $('#bill_address').val(bill_address.replace(/[|]+/g, ","));
                $('#bill_city').val(bill_city);
                $('#bill_state').val(bill_state);
                $('#bill_country').val(bill_country);
                $('#bill_landmark').val(bill_landmark);
                $('#bill_pincode').val(bill_pincode);
                $('#edit_type').val(type);
                $('#bill_info').show();
                $('#customer_info').hide();
                $('#user_name').removeAttr('required');
                $('#user_email').removeAttr('required');
                $('#user_mobile').removeAttr('required');
            }
            $('#customerinfo').modal('show');

        }

        $('#driver').on('change', function() {
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                url: "{{ URL::to('admin/orders/assign-driver') }}",
                type: "post",
                dataType: "json",
                data: {
                    driver_id: $(this).val(),
                    order_id: "{{ $orderdata->id }}",
                },
                success: function(response) {
                    $("#preload").hide();
                    if (response.status == 0) {
                        toastr.error(response.message);
                    } else {
                        location.reload();
                    }
                }
            });
        });
    </script>
@endsection
