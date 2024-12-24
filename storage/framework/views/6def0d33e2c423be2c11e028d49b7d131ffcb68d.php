<html>

<head>
    <title><?php echo e(helper::appdata()->site_title); ?></title>
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
        <h1 class="text-center m-0 p-0"><?php echo e(trans('labels.invoice')); ?></h1>
    </div>
    <div class="add-detail mt-10">
        <div class="float-left mt-10">
            <p class="m-0 pt-5 text-bold w-100"><?php echo e(trans('labels.invoice_id')); ?> - <span
                    class="gray-color">#<?php echo e($getorderdata->id); ?></span></p>
            <p class="m-0 pt-5 text-bold w-100"><?php echo e(trans('labels.order_number')); ?> - <span
                    class="gray-color">#<?php echo e($getorderdata->order_number); ?></span></p>
            <p class="m-0 pt-5 text-bold w-100"><?php echo e(trans('labels.order_date')); ?> - <span
                    class="gray-color"><?php echo e(helper::date_format($getorderdata->created_at)); ?></span>
            </p>
            <?php if($getorderdata->delivery_date != ''): ?>
                <p class="m-0 pt-5 text-bold w-100">
                    <?php echo e($getorderdata->order_type == '1' ? trans('labels.delivery_date') : trans('labels.pickup_date')); ?>

                    -
                    <span class="gray-color"><?php echo e(helper::date_format($getorderdata->delivery_date)); ?></span>
                </p>
            <?php endif; ?>
            <?php if($getorderdata->delivery_time != ''): ?>
                <p class="m-0 pt-5 text-bold w-100">
                    <?php echo e($getorderdata->order_type == '1' ? trans('labels.delivery_time') : trans('labels.pickup_time')); ?>

                    -
                    <span class="gray-color"><?php echo e($getorderdata->delivery_time); ?></span>
                </p>
            <?php endif; ?>
            <?php if($getorderdata->order_notes != ''): ?>
                <p class="m-0 pt-5 text-bold w-100"><?php echo e(trans('labels.notes')); ?> - <span
                        class="gray-color"><?php echo e($getorderdata->order_notes); ?></span>
                </p>
            <?php endif; ?>
        </div>
        <div style="clear: both;"></div>
    </div>
    <div class="table-section bill-tbl w-100 mt-10">
        <table class="table w-100 mt-10">
            <tr>
                <th class="w-50"><?php echo e(trans('labels.customer_info')); ?></th>
                <th class="w-50">
                    <?php if($getorderdata->order_type == 1): ?>
                        <?php echo e(trans('labels.billing_details')); ?>

                    <?php else: ?>
                        <?php echo e(trans('labels.info')); ?>

                    <?php endif; ?>
                </th>
            </tr>
            <tr>
                <td>
                    <div class="box-text">
                        <p><i class="fa-regular fa-user"></i> <?php echo e($getorderdata->name); ?></p>
                        <p><i class="fa-regular fa-phone"></i> <?php echo e($getorderdata->mobile); ?> </p>
                        <p><i class="fa-regular fa-phone"></i> <?php echo e($getorderdata->email); ?> </p>
                    </div>
                </td>
                <td>
                    <div class="box-text">
                        <?php if($getorderdata->order_type == 1): ?>
                            <p><?php echo e($getorderdata->address); ?>,<?php echo e($getorderdata->landmark); ?>,<?php echo e($getorderdata->city); ?>,<?php echo e($getorderdata->state); ?>,<?php echo e($getorderdata->country); ?>,<?php echo e($getorderdata->postal_code); ?>

                            </p>
                        <?php elseif($getorderdata->order_type == 2): ?>
                            <?php echo e(trans('labels.pickup')); ?>

                        <?php elseif($getorderdata->order_type == 3): ?>
                            <?php echo e(trans('labels.pos')); ?>

                        <?php endif; ?>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="table-section bill-tbl w-100 mt-10">
        <table class="table w-100 mt-10">
            <tr>
                <th class="w-50"><?php echo e(trans('labels.payment_methods')); ?></th>
            </tr>
            <tr>
                <td>
                    <?php if($getorderdata->order_type == 3): ?>
                        <?php if($getorderdata->transaction_type == 0): ?>
                            <?php echo e(trans('labels.online')); ?>

                        <?php elseif($getorderdata->transaction_type == 1): ?>
                            <?php echo e(trans('labels.cash')); ?>

                        <?php endif; ?>
                    <?php else: ?>
                        <?php echo e(helper::getpayment($getorderdata->transaction_type)); ?>

                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>
    <div class="table-section bill-tbl w-100 mt-10">
        <table class="table w-100 mt-10">
            <tr>
                <th class="w-50"><?php echo e(trans('labels.item_name')); ?></th>
                <th class="w-50"><?php echo e(trans('labels.price')); ?></th>
                <th class="w-50"><?php echo e(trans('labels.qty')); ?></th>
                <th class="w-50"><?php echo e(trans('labels.subtotal')); ?></th>
            </tr>
            <?php $data = []; ?>
            <?php $__currentLoopData = $ordersdetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orders): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $total_price =
                        ($orders['item_price'] + $orders['addons_total_price'] + $orders['extras_total_price']) *
                        $orders['qty'];
                    $data[] = ['total_price' => $total_price];
                ?>
                <tr align="center">
                    <td><?php echo e($orders->item_name); ?>

                        [<?php echo e($orders->item_type == 1 ? trans('labels.veg') : trans('labels.nonveg')); ?>] <br>
                        <?php
                            $addons_name = explode('| ', $orders->addons_name);
                            $addons_price = explode('| ', $orders->addons_price);
                            $extras_name = explode('| ', $orders->extras_name);
                            $extras_price = explode('| ', $orders->extras_price);
                        ?>
                        <?php if($orders->addons_id != ''): ?>
                            <?php $__currentLoopData = $addons_name; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <small class="text-muted"><?php echo e($addons_name[$key]); ?> :
                                    <span><?php echo e(helper::currency_format($addons_price[$key])); ?></span>
                                </small><br>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        <?php if($orders->extras_id != ''): ?>
                            <?php $__currentLoopData = $extras_name; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <small class="text-muted"><?php echo e($extras_name[$key]); ?> :
                                    <span><?php echo e(helper::currency_format($extras_price[$key])); ?></span>
                                </small><br>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </td>
                    <td><?php echo e(helper::currency_format($orders->item_price)); ?>

                        <?php if($orders->addons_total_price != 0 || $orders->extras_total_price != 0): ?>
                            <br><small class="text-muted">+
                                <?php echo e(helper::currency_format($orders->addons_total_price + $orders->extras_total_price)); ?></small>
                        <?php endif; ?>
                    </td>
                    <td><?php echo e($orders->qty); ?></td>
                    <td><?php echo e(helper::currency_format($total_price)); ?>

                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td colspan="4">
                    <div class="total-part">
                        <div class="total-left w-85 float-left" align="right">
                            <p><?php echo e(trans('labels.subtotal')); ?></p>
                            <?php if($getorderdata->discount_amount > 0): ?>
                                <p><?php echo e(trans('labels.discount')); ?><?php echo e($getorderdata->offer_code != '' ? '(' . $getorderdata->offer_code . ')' : ''); ?>

                                </p>
                            <?php endif; ?>
                            <?php
                                $tax = explode('|', $getorderdata->tax_amount);
                                $tax_name = explode('|', $getorderdata->tax_name);
                            ?>
                            <?php if($getorderdata->tax_amount != null && $getorderdata->tax_amount != ''): ?>
                                <?php $__currentLoopData = $tax_name; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $tax_value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <p><?php echo e($tax_value); ?></p>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            <?php if($getorderdata->delivery_charge > 0): ?>
                                <p><?php echo e(trans('labels.delivery_charge')); ?></p>
                            <?php endif; ?>
                            <p><strong><?php echo e(trans('labels.grand_total')); ?></strong></p>
                        </div>
                        <div class="total-right w-15 float-left" align="right">
                            <?php
                                $order_total = array_sum(array_column(@$data, 'total_price'));
                            ?>
                            <p> <?php echo e(helper::currency_format($order_total)); ?></p>
                            <?php if($getorderdata->discount_amount > 0): ?>
                                <p> <?php echo e(helper::currency_format($getorderdata->discount_amount)); ?></p>
                            <?php endif; ?>
                            <?php if($getorderdata->tax_amount != null && $getorderdata->tax_amount != ''): ?>
                                <?php $__currentLoopData = $tax; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $tax_value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <p><?php echo e(helper::currency_format($tax_value)); ?></p>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            <?php if($getorderdata->delivery_charge > 0): ?>
                                <p><?php echo e(helper::currency_format($getorderdata->delivery_charge)); ?></p>
                            <?php endif; ?>
                            <p><strong><?php echo e(helper::currency_format($getorderdata->grand_total)); ?></strong>
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
<?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/orders/invoicepdf.blade.php ENDPATH**/ ?>