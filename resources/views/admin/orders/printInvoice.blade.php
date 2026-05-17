<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ trans('labels.print') }}</title>
    <link rel="stylesheet" href="{{ url('storage/app/public/admin-assets/assets/css/bootstrap/bootstrap.min.css') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ helper::image_path(@helper::appdata()->favicon) }}">
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap');

        :root {
            --bs-primary: {{ @helper::appdata()->admin_primary_color != null ? @helper::appdata()->admin_primary_color : '#01112B' }};
            --bs-secondary: {{ @helper::appdata()->admin_secondary_color != null ? @helper::appdata()->admin_secondary_color : '#0a98af' }};
        }

        body {
            width: 88mm;
            height: 100%;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            font-family: 'Montserrat', sans-serif;
            --webkit-font-smoothing: antialiased;
        }

        #printDiv {
            font-weight: 600;
            margin: 0;
            padding: 0;
            background: #ffffff;
        }

        .btn-primary,
        .btn-primary:active,
        .btn-primary:focus,
        .btn-primary:hover {
            background-color: #6a696a;
        }

        #printDiv div,
        #printDiv p,
        #printDiv a,
        #printDiv li,
        #printDiv td {
            -webkit-text-size-adjust: none;
        }

        .center {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 50%;
        }

        @media print {
            @page {
                size: 80mm auto; /* force receipt printer width */
                margin: 0;
            }

            body {
                margin: .5cm;
            }

            #btnPrint {
                display: none;
            }
        }

        /* =================add extra css (Dhruvil)================= */
        .resept {
            width: 80mm;
            background-color: #ececec;
        }

        .fs-10 {
            font-size: 12px !important;
        }

        .underline-3 {
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
        }

        .resept .table > :not(caption) > * > * {
            background-color: transparent !important;
        }

        .product-text-size {
            font-size: .75rem !important;
        }

        .line-1 {
            text-overflow: ellipsis;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
        }

        .line-2 {
            text-overflow: ellipsis;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .txt-resept-font-size {
            font-size: 11px;
        }

        .fs-8 {
            font-size: 14px !important;
        }

        .fw-600 {
            font-weight: 600;
        }

        .fw-500 {
            font-weight: 500;
        }
    </style>
</head>

<body>
<div id="printDiv">
    <div class="resept">
        <div class="address" style="text-align: center">
            <h5 class="m-0 text-uppercase fs-8 text-center line-2 fw-600">{{ @helper::appdata()->short_title }}</h5>
            <div class="col-12 mt-1 d-flex gap-1 align-items-center justify-content-center ">
                <small class=" text-uppercase fs-10 text-center text-dark fw-500 line-2">
                    @if ($orderdata->order_type == 1)
                        {{ @$orderdata->address . ' ' . @$orderdata->landmark . ',' . @$orderdata->city . ',' . @$orderdata->state . ',' . @$orderdata->country . ',' . @$orderdata->postal_code }}
                    @elseif ($orderdata->order_type == 2)
                        {{ trans('labels.pickup') }}
                    @elseif ($orderdata->order_type == 3)
                        {{ trans('labels.pos') }}
                    @endif
                </small>
            </div>
            <div class="col-12 mt-1 d-flex gap-1 align-items-center justify-content-center">
                <p class=" m-0 fw-500 text-uppercase fs-10 text-center text-dark line-1">
                    {{ trans('labels.name') }} :
                    <small class="fw-500 text-uppercase fs-10 text-center text-dark ">
                        {{ @$orderdata->name }}
                    </small></p>
            </div>
            <div class="col-12 mt-1 d-flex gap-1 align-items-center justify-content-center">
                <p class="fw-500 m-0 text-uppercase fs-10 text-center text-dark line-1">
                    {{ trans('labels.email') }} :
                    <small class="fw-500 text-uppercase fs-10 text-center text-dark  ">
                        {{ @$orderdata->email }}
                    </small></p>
            </div>
            <div class="col-12 mt-1 d-flex gap-1 align-items-center justify-content-center">
                <p class="fw-500 m-0 text-uppercase fs-10 text-center text-dark line-1">
                    {{ trans('labels.mobile') }} :
                    <small class="fw-500 text-uppercase fs-10 text-center text-dark">
                        {{ @$orderdata->mobile }}
                    </small></p>
            </div>
        </div>
        <div class="total-billes-amount" style="text-align: center">
            <div
                class="fw-500 d-flex gap-1 align-items-center justify-content-center mt-1 text-uppercase fs-10 text-center text-dark">
                {{ trans('labels.order_number') }} :
                <small class="fw-500 text-uppercase fs-10 text-center text-dark ">
                    #{{ $orderdata->order_number }}
                </small>
            </div>
            <p
                class="fw-500 d-flex gap-1 align-items-center justify-content-center m-0 text-uppercase fs-10 text-center text-dark line-1">
                {{ trans('labels.order_date') }} :
                <small
                    class="fw-500 text-uppercase fs-10 text-center text-dark">{{ $orderdata->created_at }}
                </small>
            </p>
        </div>
        <div class="total-billes-amount" style="text-align: center">
            @if ($orderdata->delivery_date != '')
                <div
                    class="fw-500 d-flex gap-1 align-items-center justify-content-center m-0 text-uppercase fs-10 text-center text-dark">
                    {{ $orderdata->order_type == '1' ? trans('labels.delivery_date') : trans('labels.pickup_date') }}
                    :
                    <small class="fw-500 text-uppercase fs-10 text-center text-dark ">
                        {{ $orderdata->delivery_date }}
                    </small>
                </div>
            @endif
            @if ($orderdata->delivery_time != '')
                <p
                    class="fw-500 d-flex gap-1 align-items-center justify-content-center m-0 text-uppercase fs-10 text-center text-dark line-1">
                    {{ $orderdata->order_type == '1' ? trans('labels.delivery_time') : trans('labels.pickup_time') }}
                    :
                    <small
                        class="fw-500 text-uppercase fs-10 text-center text-dark">{{ $orderdata->delivery_time }}
                    </small>
                </p>
            @endif
        </div>
        <table class="table table-borderless my-2 bg-transparent" style="width: 100%">
            <thead class="underline-3">
            <tr class="text-dark">
                <th scope="col" class="product-text-size fw-bold">#</th>
                <th scope="col" class="product-text-size fw-bold">{{ trans('labels.item') }}
                </th>
                <th scope="col" class="product-text-size fw-bold text-center">{{ trans('labels.price') }}
                </th>
                <th scope="col" class="product-text-size fw-bold text-center">{{ trans('labels.qty') }}
                </th>
                <th scope="col" class="product-text-size fw-bold text-center pe-0">
                    {{ trans('labels.total') }}
                </th>
            </tr>
            </thead>
            <tbody>
            @php
                $order_total = 0;
                $qty = 0;
            @endphp
            @foreach ($ordersdetails as $key => $orders)
                @php
                   $order_total +=
                         ($orders['item_price'] +
                             $orders['addons_total_price'] +
                             $orders['extras_total_price']) *
                         ($orders['qty'] ?? 1);
                     
                     $qty += $orders['qty'] ?? 1;

                @endphp
                <tr class="align-middle">
                    <td class="py-2">
                        <p class="fw-500 text-dark line-1 m-0 product-text-size">{{ ++$key }}</p>
                    </td>
                    <td class="py-2">
                        <h6 class="m-0 fw-500 product-text-size">
                            {{ $orders->item_name }}

                            @if(!is_null($orders->size) && !is_null($orders->crust))
                                <small> ({{ $orders->size->name }} - {{ $orders->crust->name }})</small>
                            @endif
                            <br>
                            @php
                                $addons_name = explode('| ', $orders->addons_name);
                                $addons_price = explode('| ', $orders->addons_price);
                                $extras_name = explode('| ', $orders->extras_name);
                                $extras_price = explode('| ', $orders->extras_price);
                            @endphp
                            @if ($orders->addons_id != '')
                                @foreach ($addons_name as $key => $val)
                                    <span class="text-muted">{{ $addons_name[$key] }} :
                                                <span>{{ helper::currency_format($addons_price[$key]) }}</span>
                                            </span><br>
                                @endforeach
                            @endif
                            @if ($orders->extras_id != '')
                                @foreach ($extras_name as $key => $val)
                                    <span class="text-muted">{{ $extras_name[$key] }} :
                                                <span>{{ helper::currency_format($extras_price[$key] ?? 0) }}</span>
                                            </span><br>
                                @endforeach
                            @endif
                            @if ($orders['dipping_name'] != '')
                                <p class="m-0 ">Dipping</p>
                                    <?php
                                    // Exploding dipping_name, quantity, and price if they are in a delimited format
                                    $dippingNames = explode('|', $orders['dipping_name']);
                                    $dippingQuantities = $orders['dipping_quantity'];
                                    $dippingPrices = $orders['dipping_price'];
                                    ?>
                                <ul class="m-0 p-0" id="item-extras">

                                    @foreach($dippingNames as $key => $name)
                                        <li class="list-group-item  d-flex  text-muted">
                                            <small
                                                class="flex-grow-1 ">{{ $name }}</small>
                                            <small
                                                class=" px-3">{{ $dippingQuantities[$key] }} </small>
                                            <small
                                                class="px-3">{{ $dippingQuantities[$key] * $dippingPrices[$key] }}
                                                $</small>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            @if ($orders->custom_pizza_id != null)
                                    <?php $data = (new App\Helpers\helper)->getCustomPizzaDetails($orders->custom_pizza_id) ?>
                                <div class="mt-2 border-bottom" id="extras">
                                    <p class="m-0 ">Size: <small class="text-muted">{{ $data->size->label }}
                                            ({{$data->size->name }}")</small></p>
                                    <p class="m-0 ">Special: <small class="text-muted">{{ $data->cut }}
                                            / {{ $data->bake }} / {{ $data->seasoning }}</small></p>
                                    <p class="m-0 ">Crust: <small class="text-muted">{{ $data->crust?->name }}</small>
                                    </p>
                                    <!--<p class="m-0 ">Sauce: <small class="text-muted">{{ $data->sauce?->name }}</small>-->
                                    </p>
                                    <p class="m-0 ">Toppings </p>
                                    <ul class="m-0 p-0" id="item-extras">
                                        @foreach($data->toppings as $topping)
                                            <li class="list-group-item  d-flex  text-muted">
                                                <small
                                                    class="flex-grow-1 ">{{ $topping->name }}</small>
                                                <small
                                                    class="ml-3">{{ $topping->pivot->side }}</small>
                                                <small
                                                    class=" px-3">{{ $topping->pivot->quantity }}</small>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <p class="m-0 ">Extra Toppings </p>
                                    <ul class="m-0 p-0" id="item-extras">
                                        @foreach($data->sauces as $topping)
                                            <li class="list-group-item  d-flex  text-muted">
                                                <small
                                                    class="flex-grow-1 ">{{ $topping->name }}</small>
                                                <small
                                                    class="ml-3">{{ $topping->pivot->side }}</small>
                                                <small
                                                    class=" px-3">{{ $topping->pivot->quantity }}</small>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <p class="m-0 ">Dipping</p>
                                    <ul class="m-0 p-0" id="item-extras">
                                        @foreach($data->dipping as $dipping)
                                            <li class="list-group-item  d-flex  text-muted">
                                                <small
                                                    class="flex-grow-1 ">{{ $dipping->name }}</small>

                                                <small
                                                    class=" px-3">{{ $dipping->pivot->quantity }}
                                                </small>
                                                <small
                                                    class="px-3">{{ $dipping->pivot->quantity * $dipping->price }}
                                                    $</small>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                            @endif
                        </h6>
                    </td>
                    <td class="py-2 text-end">
                        <div class="fw-500 product-text-size d-flex align-items-center justify-content-center">
                            <p class="m-0 text-dark">
                                {{ helper::currency_format($orders->item_price) }}
                                @if ($orders->addons_total_price != 0 || $orders->extras_total_price != 0)
                                    <br><small class="text-muted">+
                                        {{ helper::currency_format($orders->addons_total_price + $orders->extras_total_price) }}</small>
                                @endif
                            </p>
                        </div>
                    </td>
                    <td class="py-2 text-end">
                        <div class="fw-500 product-text-size d-flex align-items-center justify-content-center">
                            <p class="m-0 text-dark">{{ $orders->qty }}</p>
                        </div>
                    </td>
                    <td class="py-2 pe-0 text-end">
                        <p class="text-dark fw-500 line-1 m-0  product-text-size">
                            {{ helper::currency_format($orders->item_price * $orders->qty + $orders->addons_total_price + $orders->extras_total_price) }}
                        </p>
                    </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr class="underline-3">
                <td class="py-2" colspan="3">
                    <h6 class="line-1 m-0 fw-600 product-text-size">{{ trans('labels.subtotal') }}</h6>
                </td>
                <td class="py-2 text-end">
                    <div class=" product-text-size d-flex align-items-center justify-content-center">
                        <p class="m-0 text-dark">{{ $qty }}</p>
                    </div>
                </td>
                <td class="py-2 pe-0 text-end">
                    <p class="text-dark line-1 fw-500 m-0  product-text-size">
                        {{ helper::currency_format($order_total) }}
                    </p>
                </td>
            </tr>
            </tfoot>
        </table>
        <div class="col-12 d-flex mb-2 justify-content-end">
            <div class="col-7">
                <div class="col-12">
                    <div class="text-dark">
                        @if (!empty($orderdata->discount_amount))
                            <div class="d-flex justify-content-between text-dark my-1">
                                <div class="">
                                        <span class="txt-resept-font-size fw-500 text-uppercase line-1">
                                            {{ trans('labels.discount') }}
                                            {{ $orderdata->offer_code != '' ? '(' . $orderdata->offer_code . ')' : '' }}
                                        </span>
                                </div>
                                <div class="">
                                        <span class="txt-resept-font-size fw-500 text-uppercase text-end line-1">
                                            {{ helper::currency_format($orderdata->discount_amount) }}
                                        </span>
                                </div>
                            </div>
                        @endif
                        @php
                            $tax = explode('|', $orderdata->tax_amount);
                            $tax_name = explode('|', $orderdata->tax_name);
                        @endphp
                        @if ($orderdata->tax_amount != null && $orderdata->tax_name != null)
                            @foreach ($tax as $key => $tax_value)
                                <div class="d-flex justify-content-between text-dark my-1">
                                    <span
                                        class="txt-resept-font-size fw-500 text-uppercase ">{{ $tax_name[$key] }}</span>

                                    <span class="txt-resept-font-size fw-500 float-right text-uppercase text-end "
                                          style="float: right;">
                                                {{ helper::currency_format($tax_value) }}
                                            </span>
                                </div>
                            @endforeach
                        @endif
                        @if ($orderdata->delivery_charge != 0)
                            <div class="d-flex justify-content-between text-dark my-1">
                                        <span class="txt-resept-font-size fw-500 text-uppercase ">
                                            {{ trans('labels.delivery_charge') }}
                                        </span>

                                <span class="txt-resept-font-size fw-500 text-uppercase text-end" style="float: right;">
                                            {{ helper::currency_format($orderdata->delivery_charge) }}
                                        </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 d-flex justify-content-between underline-3 py-2">
            <span class="fw-semibold product-text-size ">{{ trans('labels.grand_total') }}</span>
            <span
                class="fw-semibold line-1 product-text-size" style="float: right;">{{ helper::currency_format($orderdata->grand_total) }}</span>
        </div>
        <h2 class="my-2 fs-8 fw-600 text-center line-1" style="text-align: center">{{ trans('labels.thanks_for_order') }}</h2>
        <div class="col-12 mt-2 d-flex justify-content-center text-center" style="text-align: center">
            <button type='button' id="btnPrint"
                    class="rounded border-0 btn btn-primary text-white text-capitalize fs-8 px-3 py-2" style="color: white">{{ trans('labels.print') }}</button>
        </div>
    </div>
</div>
<script>
    const $btnPrint = document.querySelector("#btnPrint");
    $btnPrint.addEventListener("click", () => {
        window.print();
    });
</script>
</body>
