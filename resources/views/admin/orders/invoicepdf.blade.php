<html>

<head>
    <title>{{ helper::appdata()->site_title }}</title>
</head>
<style type="text/css">
    body {
        font-family: 'Roboto Condensed', sans-serif;
    }

    .m-0 {
        margin: 0px;
    }

    .p-0 {
        padding: 0px;
    }

    .pt-5 {
        padding-top: 5px;
    }

    .mt-10 {
        margin-top: 10px;
    }

    .text-center {
        text-align: center !important;
    }

    .w-100 {
        width: 100%;
    }

    .w-50 {
        width: 50%;
    }

    .w-85 {
        width: 85%;
    }

    .w-15 {
        width: 15%;
    }

    .logo img {
        width: 200px;
        height: 60px;
    }

    .gray-color {
        color: #5D5D5D;
    }

    .text-bold {
        font-weight: bold;
    }

    .border {
        border: 1px solid black;
    }

    table tr,
    th,
    td {
        border: 1px solid #d2d2d2;
        border-collapse: collapse;
        padding: 7px 8px;
    }

    table tr th {
        background: #F4F4F4;
        font-size: 15px;
    }

    table tr td {
        font-size: 13px;
    }

    table {
        border-collapse: collapse;
    }

    .box-text p {
        line-height: 14px;
    }

    .float-left {
        float: left;
    }

    .total-part {
        font-size: 16px;
        line-height: 12px;
    }

    .total-right p {
        padding-right: 20px;
    }
</style>

<body>
    <div class="head-title">
        <h1 class="text-center m-0 p-0">{{ trans('labels.invoice') }}</h1>
    </div>
    <div class="add-detail mt-10">
        <div class="float-left mt-10">
            <p class="m-0 pt-5 text-bold w-100">{{ trans('labels.invoice_id') }} - <span
                    class="gray-color">#{{ $getorderdata->id }}</span></p>
            <p class="m-0 pt-5 text-bold w-100">{{ trans('labels.order_number') }} - <span
                    class="gray-color">#{{ $getorderdata->order_number }}</span></p>
            <p class="m-0 pt-5 text-bold w-100">{{ trans('labels.order_date') }} - <span
                    class="gray-color">{{ helper::date_format($getorderdata->created_at) }}</span>
            </p>
            @if ($getorderdata->delivery_date != '')
                <p class="m-0 pt-5 text-bold w-100">
                    {{ $getorderdata->order_type == '1' ? trans('labels.delivery_date') : trans('labels.pickup_date') }}
                    -
                    <span class="gray-color">{{ helper::date_format($getorderdata->delivery_date) }}</span>
                </p>
            @endif
            @if ($getorderdata->delivery_time != '')
                <p class="m-0 pt-5 text-bold w-100">
                    {{ $getorderdata->order_type == '1' ? trans('labels.delivery_time') : trans('labels.pickup_time') }}
                    -
                    <span class="gray-color">{{ $getorderdata->delivery_time }}</span>
                </p>
            @endif
            @if ($getorderdata->order_notes != '')
                <p class="m-0 pt-5 text-bold w-100">{{ trans('labels.notes') }} - <span
                        class="gray-color">{{ $getorderdata->order_notes }}</span>
                </p>
            @endif
        </div>
        <div style="clear: both;"></div>
    </div>
    <div class="table-section bill-tbl w-100 mt-10">
        <table class="table w-100 mt-10">
            <tr>
                <th class="w-50">{{ trans('labels.customer_info') }}</th>
                <th class="w-50">
                    @if ($getorderdata->order_type == 1)
                        {{ trans('labels.billing_details') }}
                    @else
                        {{ trans('labels.info') }}
                    @endif
                </th>
            </tr>
            <tr>
                <td>
                    <div class="box-text">
                        <p><i class="fa-regular fa-user"></i> {{ $getorderdata->name }}</p>
                        <p><i class="fa-regular fa-phone"></i> {{ $getorderdata->mobile }} </p>
                        <p><i class="fa-regular fa-phone"></i> {{ $getorderdata->email }} </p>
                    </div>
                </td>
                <td>
                    <div class="box-text">
                        @if ($getorderdata->order_type == 1)
                            <p>{{ $getorderdata->address }},{{ $getorderdata->landmark }},{{ $getorderdata->city }},{{ $getorderdata->state }},{{ $getorderdata->country }},{{ $getorderdata->postal_code }}
                            </p>
                        @elseif ($getorderdata->order_type == 2)
                            {{ trans('labels.pickup') }}
                        @elseif ($getorderdata->order_type == 3)
                            {{ trans('labels.pos') }}
                        @endif
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="table-section bill-tbl w-100 mt-10">
        <table class="table w-100 mt-10">
            <tr>
                <th class="w-50">{{ trans('labels.payment_methods') }}</th>
            </tr>
            <tr>
                <td>
                    @if ($getorderdata->order_type == 3)
                        @if ($getorderdata->transaction_type == 0)
                            {{ trans('labels.online') }}
                        @elseif ($getorderdata->transaction_type == 1)
                            {{ trans('labels.cash') }}
                        @endif
                    @else
                        {{ helper::getpayment($getorderdata->transaction_type) }}
                    @endif
                </td>
            </tr>
        </table>
    </div>
    <div class="table-section bill-tbl w-100 mt-10">
        <table class="table w-100 mt-10">
            <tr>
                <th class="w-50">{{ trans('labels.item_name') }}</th>
                <th class="w-50">{{ trans('labels.price') }}</th>
                <th class="w-50">{{ trans('labels.qty') }}</th>
                <th class="w-50">{{ trans('labels.subtotal') }}</th>
            </tr>
            @php $data = []; @endphp
            @foreach ($ordersdetails as $orders)
                @php
                    $total_price =
                        ($orders['item_price'] + $orders['addons_total_price'] + $orders['extras_total_price']) *
                        $orders['qty'];
                    $data[] = ['total_price' => $total_price];
                @endphp
                <tr align="center">
                    <td>{{ $orders->item_name }}
                        [{{ $orders->item_type == 1 ? trans('labels.veg') : trans('labels.nonveg') }}] <br>
                        @php
                            $addons_name = explode('| ', $orders->addons_name);
                            $addons_price = explode('| ', $orders->addons_price);
                            $extras_name = explode('| ', $orders->extras_name);
                            $extras_price = explode('| ', $orders->extras_price);
                        @endphp
                        @if ($orders->addons_id != '')
                            @foreach ($addons_name as $key => $val)
                                <small class="text-muted">{{ $addons_name[$key] }} :
                                    <span>{{ helper::currency_format($addons_price[$key]) }}</span>
                                </small><br>
                            @endforeach
                        @endif
                        @if ($orders->extras_id != '')
                            @foreach ($extras_name as $key => $val)
                                <small class="text-muted">{{ $extras_name[$key] }} :
                                    <span>{{ helper::currency_format($extras_price[$key]) }}</span>
                                </small><br>
                            @endforeach
                        @endif
                    </td>
                    <td>{{ helper::currency_format($orders->item_price) }}
                        @if ($orders->addons_total_price != 0 || $orders->extras_total_price != 0)
                            <br><small class="text-muted">+
                                {{ helper::currency_format($orders->addons_total_price + $orders->extras_total_price) }}</small>
                        @endif
                    </td>
                    <td>{{ $orders->qty }}</td>
                    <td>{{ helper::currency_format($total_price) }}
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4">
                    <div class="total-part">
                        <div class="total-left w-85 float-left" align="right">
                            <p>{{ trans('labels.subtotal') }}</p>
                            @if ($getorderdata->discount_amount > 0)
                                <p>{{ trans('labels.discount') }}{{ $getorderdata->offer_code != '' ? '(' . $getorderdata->offer_code . ')' : '' }}
                                </p>
                            @endif
                            @php
                                $tax = explode('|', $getorderdata->tax_amount);
                                $tax_name = explode('|', $getorderdata->tax_name);
                            @endphp
                            @if ($getorderdata->tax_amount != null && $getorderdata->tax_amount != '')
                                @foreach ($tax_name as $key => $tax_value)
                                    <p>{{ $tax_value }}</p>
                                @endforeach
                            @endif
                            @if ($getorderdata->delivery_charge > 0)
                                <p>{{ trans('labels.delivery_charge') }}</p>
                            @endif
                            <p><strong>{{ trans('labels.grand_total') }}</strong></p>
                        </div>
                        <div class="total-right w-15 float-left" align="right">
                            @php
                                $order_total = array_sum(array_column(@$data, 'total_price'));
                            @endphp
                            <p> {{ helper::currency_format($order_total) }}</p>
                            @if ($getorderdata->discount_amount > 0)
                                <p> {{ helper::currency_format($getorderdata->discount_amount) }}</p>
                            @endif
                            @if ($getorderdata->tax_amount != null && $getorderdata->tax_amount != '')
                                @foreach ($tax as $key => $tax_value)
                                    <p>{{ helper::currency_format($tax_value) }}</p>
                                @endforeach
                            @endif
                            @if ($getorderdata->delivery_charge > 0)
                                <p>{{ helper::currency_format($getorderdata->delivery_charge) }}</p>
                            @endif
                            <p><strong>{{ helper::currency_format($getorderdata->grand_total) }}</strong>
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
