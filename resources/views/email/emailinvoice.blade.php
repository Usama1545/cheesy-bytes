<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{$title}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        @media screen {
            @font-face {
                font-family: 'Source Sans Pro';
                font-style: normal;
                font-weight: 400;
                src: local('Source Sans Pro Regular'), local('SourceSansPro-Regular'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/ODelI1aHBYDBqgeIAH2zlBM0YzuT7MdOe03otPbuUS0.woff) format('woff');
            }
            @font-face {
                font-family: 'Source Sans Pro';
                font-style: normal;
                font-weight: 700;
                src: local('Source Sans Pro Bold'), local('SourceSansPro-Bold'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/toadOcfmlt9b38dHJxOBGFkQc6VGVFSmCnC_l7QZG60.woff) format('woff');
            }
        }
        body,table,td,a {-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;}
        body {width: 100% !important; height: 100% !important; padding: 0 !important; margin: 0 !important; }
        table,td {mso-table-rspace: 0pt; mso-table-lspace: 0pt; }
        table {border-collapse: collapse !important;}
        div[style*="margin: 16px 0;"] {margin: 0 !important;}
        a[x-apple-data-detectors] { font-family: inherit !important; font-size: inherit !important; font-weight: inherit !important; line-height: inherit !important; color: inherit !important;  text-decoration: none !important; }
        a {color: #1a82e2;}
        img {-ms-interpolation-mode: bicubic;height: auto; line-height: 100%; text-decoration: none; border: 0; outline: none; }
    </style>
</head>
<body style="background-color: #D2C7BA;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td align="center" bgcolor="#D2C7BA">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                        <tr>
                            <td align="center" valign="top" style="padding: 36px 24px;">
                                <img src="{!! $logo !!}" alt="Logo" border="0" width="48" style="display: block; width: 48px; max-width: 48px; min-width: 48px;">
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center" bgcolor="#D2C7BA">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                        <tr>
                            <td align="left" bgcolor="#ffffff"
                                style="padding: 36px 24px 0; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; border-top: 3px solid #d4dadf;">
                                <h1 style="margin: 0; font-size: 32px; font-weight: 700; letter-spacing: -1px; line-height: 48px;">{{ trans('labels.thanks_for_order') }}</h1>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center" bgcolor="#D2C7BA">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                        <tr>
                            <td align="left" bgcolor="#ffffff"
                                style="padding: 20px 24px 0; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 24px;">
                                <p style="margin: 0;">{{ trans('labels.dear') }} <span
                                        style="font-size: 12px; font-weight: 800; line-height: 24px; color: #777777;">{{ $orderdata->user_info->name }},</span>
                                </p>
                                <p style="margin: 0;">{{ $orderdata->user_info->email }}</p>
                                <p style="margin: 0;">{{ $orderdata->user_info->mobile }}</p>
                                @if ($orderdata->order_type == 1)
                                    <p style="margin: 0;"> {{ $orderdata->address }}</p>
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="left" bgcolor="#ffffff"
                    style="padding: 10px 24px 0; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 24px;">
                    <p style="margin: 0;"> {{ trans('labels.order_placed_with_number') }} <span style="font-size: 12px; font-weight: 800; line-height: 24px; color: #777777;">{{ $orderdata->order_number }}</span> {{ trans('labels.order_will_processed') }} </p>
                    <p style="margin: 0;"> {{ trans('labels.order_summary_note') }} <a href="{{ URL::to('/contactus') }}">{{ trans('labels.help_contact_us') }}</a>.</p>
                </td>
            </tr>
            @if ($orderdata['order_notes'] != '')
                <tr>
                    <td align="left" bgcolor="#ffffff"
                        style="padding: 10px 24px 0; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 24px;">
                        <strong style="margin: 0;">{{ trans('labels.order_note') }}</strong>
                        <p style="margin: 0;">{{ $orderdata['order_notes'] }}</p>
                    </td>
                </tr>
            @endif
        </table>
    </td>
    </tr>
    <tr>
        <td align="center" bgcolor="#D2C7BA">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                <tr>
                    <td align="left" bgcolor="#ffffff"
                        style="padding: 10px 24px 0; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td align="left" bgcolor="#D2C7BA" width="5%" style="font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 24px;"><strong>#</strong> </td>
                                <td align="left" bgcolor="#D2C7BA" width="55%" style="padding: 12px;font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 24px;"><strong>{{ trans('labels.items') }}</strong> </td>
                                <td align="left" bgcolor="#D2C7BA" width="15%" style="padding: 12px;font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 24px;text-align: right;"><strong>{{ trans('labels.unit_cost') }}</strong> </td>
                                <td align="left" bgcolor="#D2C7BA" width="10%" style="padding: 12px;font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 24px;text-align: right;"><strong>{{ trans('labels.qty') }}</strong> </td>
                                <td align="left" bgcolor="#D2C7BA" width="15%" style="padding: 12px;font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 24px;text-align: right;"><strong>{{ trans('labels.subtotal') }}</strong> </td>
                            </tr>
                            <?php
                                $i=1;
                                foreach ($itemdata as $idata){
                                    $idata['addons_price'] == '' ? ($addonsprice = 0) : ($addonsprice = array_sum(explode(',', $idata['addons_price'])));
                                    $total_price = ($idata['item_price'] + $addonsprice) * $idata['qty'];
                                    $data[] = ['total_price' => $total_price];
                                ?>
                            <tr>
                                <td align="left" width="5%" style="font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 24px;"><?php echo $i++; ?></td>
                                <td align="left" width="55%" style="padding: 10px 0;font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 24px;">
                                    {{ $idata['item_name'] }}
                                    @if ($idata->variation != '')
                                        [{{ $idata->variation }}]
                                    @endif
                                    <br>
                                    <?php
                                    $addons_name = explode(',', $idata->addons_name);
                                    $addons_price = explode(',', $idata->addons_price);
                                    ?>
                                    @if ($idata->addons_id != '')
                                        @foreach ($addons_name as $key => $val)
                                            <p style="margin: 0;color: #777777"><small>{{ $addons_name[$key] }} :
                                                    {{ helper::currency_format($addons_price[$key]) }}</small></p>
                                        @endforeach
                                    @endif
                                </td>
                                <td align="left" width="15%" style="padding: 10px 0;font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 24px;text-align: right;">
                                    {{ helper::currency_format($idata['item_price']) }}
                                    @if ($idata->addons_total_price > 0)
                                        <br><small>+
                                            {{ helper::currency_format($idata->addons_total_price) }}</small>
                                    @endif
                                </td>
                                <td align="left" width="10%" style="padding: 10px 0;font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 24px;text-align: right;">{{ $idata['qty'] }}</td>
                                <td align="left" width="15%" style="padding: 10px 0;font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 24px;text-align: right;">{{ helper::currency_format($total_price) }}</td>
                            </tr>
                            <?php
                                }
                                $order_total = array_sum(array_column(@$data, 'total_price'));
                            ?>
                            <tr>
                                <td align="left" colspan="4" width="75%" style="padding: 12px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 24px; border-top: 2px dashed #D2C7BA; border-bottom: 2px dashed #D2C7BA;"><strong>{{ trans('labels.order_total') }}</strong> </td>
                                <td align="left" width="25%" style="padding: 12px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 24px; border-top: 2px dashed #D2C7BA; border-bottom: 2px dashed #D2C7BA;text-align: right;"><strong>{{ helper::currency_format($order_total) }}</strong> </td>
                            </tr>
                            <tr>
                                <td align="left" colspan="4" width="75%" style="padding: 12px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 24px; border-top: 2px dashed #D2C7BA; border-bottom: 2px dashed #D2C7BA;"><strong>{{ trans('labels.order_type') }}</strong> </td>
                                <td align="left" width="25%" style="padding: 12px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 24px; border-top: 2px dashed #D2C7BA; border-bottom: 2px dashed #D2C7BA;text-align: right;"><strong>{{ $orderdata->order_type == 1 ? trans('labels.delivery') : trans('labels.pickup') }}</strong> </td>
                            </tr>
                            <tr>
                                <td align="left" colspan="4" width="75%" style="padding: 12px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 24px; border-top: 2px dashed #D2C7BA; border-bottom: 2px dashed #D2C7BA;"><strong>{{ trans('labels.order_number') }}</strong> </td>
                                <td align="left" width="25%" style="padding: 12px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 24px; border-top: 2px dashed #D2C7BA; border-bottom: 2px dashed #D2C7BA;text-align: right;"><strong>{{ $orderdata->order_number }}</strong> </td>
                            </tr>
                            <!-- TRANSACTION TYPE -->
                            <tr>
                                <td align="left" colspan="4" width="75%" style="padding: 12px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 24px; border-top: 2px dashed #D2C7BA; border-bottom: 2px dashed #D2C7BA;"><strong>{{ trans('labels.payment_type') }}</strong> </td>
                                <td align="left" width="25%" style="padding: 12px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 24px; border-top: 2px dashed #D2C7BA; border-bottom: 2px dashed #D2C7BA;text-align: right;">
                                    <strong>
                                        @if ($orderdata->transaction_type == 1)
                                            {{ trans('labels.cash') }}
                                        @endif
                                        @if ($orderdata->transaction_type == 2)
                                            {{ trans('labels.wallet') }}
                                        @endif
                                        @if ($orderdata->transaction_type == 3)
                                            {{ trans('labels.razorpay') }}
                                        @endif
                                        @if ($orderdata->transaction_type == 4)
                                            {{ trans('labels.stripe') }}
                                        @endif
                                        @if ($orderdata->transaction_type == 5)
                                            {{ trans('labels.flutterwave') }}
                                        @endif
                                        @if ($orderdata->transaction_type == 6)
                                            {{ trans('labels.paystack') }}
                                        @endif
                                    </strong>
                                </td>
                            </tr>
                            <!-- TRANSACTION ID -->
                            @if ($orderdata->transaction_type != 1 && $orderdata->transaction_type != 2)
                                <tr>
                                    <td align="left" colspan="4" width="75%" style="padding: 12px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 24px; border-top: 2px dashed #D2C7BA; border-bottom: 2px dashed #D2C7BA;"><strong>{{ trans('labels.transaction_id') }}</strong> </td>
                                    <td align="left" width="25%" style="padding: 12px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 24px; border-top: 2px dashed #D2C7BA; border-bottom: 2px dashed #D2C7BA;"><strong>{{ $orderdata->transaction_id }}</strong></td>
                                </tr>
                            @endif
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="left" bgcolor="#ffffff"
                        style="padding: 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 24px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td align="left" width="75%" style="padding: 10px 0;font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 24px;"> {{ trans('labels.order_total') }}</td> 
                                <td align="left" width="25%" style="padding: 10px 0;font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 24px;text-align: right;"> {{ helper::currency_format($order_total) }}</td> 
                            </tr>
                            <tr>
                                <td align="left" width="75%" style="padding: 10px 0;font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 24px;"> {{ trans('labels.tax') }}</td> 
                                <td align="left" width="25%" style="padding: 10px 0;font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 24px;text-align: right;"> {{ helper::currency_format($orderdata->tax_amount) }}</td> 
                            </tr>
                            @if ($orderdata->order_type == 1)
                                <tr>
                                    <td align="left" width="75%" style="padding: 10px 0;font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 24px;"> {{ trans('labels.delivery_charge') }}</td> 
                                    <td align="left" width="25%" style="padding: 10px 0;font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 24px;text-align: right;"> 
                                        @if ($orderdata->delivery_charge == 0 || $orderdata->delivery_charge == '') 
                                            {{ trans('labels.free') }}
                                        @else
                                            {{ helper::currency_format($orderdata->delivery_charge) }}
                                        @endif
                                    </td>
                                </tr>
                            @endif
                            @if ($orderdata->discount_amount != '')
                                <tr>
                                    <td align="left" width="75%" style="padding: 10px 0;font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 24px;"> {{ trans('labels.discount') }} </td>
                                    <td align="left" width="25%" style="padding: 10px 0;font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 24px;text-align: right;"> (-) {{ helper::currency_format($orderdata->discount_amount) }} </td>
                                </tr>
                            @endif
                            <tr>
                                <td align="left" width="75%" style="padding: 12px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 24px; border-top: 2px dashed #D2C7BA; border-bottom: 2px dashed #D2C7BA;"><strong>{{ trans('labels.grand_total') }}</strong></td>
                                <td align="left" width="25%" style="padding: 12px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 24px; border-top: 2px dashed #D2C7BA; border-bottom: 2px dashed #D2C7BA;text-align: right;"><strong>{{ helper::currency_format($orderdata->grand_total) }}</strong></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center" bgcolor="#D2C7BA" style="padding: 24px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                <tr>
                    <td align="center" bgcolor="#D2C7BA" style="padding: 12px 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; color: #666;">
                        <p style="margin: 0;"> {{ trans('labels.delete_email_if_not_ordered') }} </p>
                    </td>
                </tr>
                <tr>
                    <td align="center" bgcolor="#D2C7BA" style="padding: 12px 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; color: #666;">
                        <p style="font-size: 11px"><b>{{ trans('labels.note') }}</b> {{ trans('labels.do_not_reply') }}</p>
                        <p style="line-height:1;font-size:12px;margin:0 20px 30px 20px;padding:0 0 0 0;color:#777777;font-family:'Lato',Helvetica,Arial,sans-serif">{{ trans('labels.all_rights_reserved') }}</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
</body>
</html>