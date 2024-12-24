<?php $__env->startSection('page_title'); ?>
    | <?php echo e(trans('labels.order_details')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="breadcrumb-sec">
        <div class="container">
            <div class="breadcrumb-sec-content">
                <nav class="text-dark breadcrumb-divider" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li
                            class="breadcrumb-item <?php echo e(session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : ''); ?>">
                            <a class="text-dark fw-600" href="<?php echo e(route('home')); ?>"><?php echo e(trans('labels.home')); ?></a>
                        </li>
                        <li class="breadcrumb-item <?php echo e(session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : ''); ?> active"
                            aria-current="page"><?php echo e(trans('labels.order_details')); ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section>
        <div class="container my-5">
            <div class="row">
                <?php if(Auth::user() && Auth::user()->type == 2): ?>
                    <div class="col-lg-3">
                        <?php echo $__env->make('web.layout.usersidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                <?php endif; ?>
                <div class="<?php echo e(Auth::user() && Auth::user()->type == 2 ? 'col-lg-9' : 'col-lg-12'); ?> ">
                    <div class="user-content-wrapper">
                        <div class="d-flex flex-wrap gap-2 mb-3 border-bottom pb-3 align-items-center justify-content-between">
                            <p class="title mb-0"><?php echo e(trans('labels.order_details')); ?></p>
                            <div class="">
                                <?php if(@helper::checkaddons('whatsapp_message')): ?>
                                    <?php if(whatsapp_helper::whatsapp_message_config()->order_created == 1): ?>
                                        <?php if(whatsapp_helper::whatsapp_message_config()->message_type == 2): ?>
                                            <a href="https://api.whatsapp.com/send?phone=<?php echo e(whatsapp_helper::whatsapp_message_config()->whatsapp_number); ?>&text=<?php echo e(@$whmessage); ?>"
                                                class="btn btn-success btn-sm mx-1 my-sm-0 my-2 px-4 py-2" target="_blank">
                                                <i
                                                    class="fab fa-whatsapp <?php echo e(session()->get('direction') == '2' ? 'ms-1' : 'me-1'); ?>"></i><?php echo e(trans('labels.whatsapp_order')); ?>

                                            </a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if($orderdata->status_type == 1): ?>
                                    <a class="btn btn-danger btn-sm mx-1 px-4 py-2 " href="javascript:void(0)"
                                        onclick="cancelorder('<?php echo e($orderdata->order_number); ?>','<?php echo e(URL::to('/orders/cancel')); ?>')"><i class="fa-regular fa-trash <?php echo e(session()->get('direction') == '2' ? 'ms-1' : 'me-1'); ?>"></i><?php echo e(trans('labels.cancel_order')); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row mb-5 g-3">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-transparent">
                                        <h5 class="fw-bold fs-6 mb-0 py-1"><?php echo e(trans('labels.order_info')); ?></h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <p class="fw-semibold fs-7 mb-2"><?php echo e(trans('labels.order_number')); ?> : </p>&nbsp;
                                            <p class="fw-400 fs-7 text-muted mb-2"><?php echo e($orderdata->order_number); ?></p>
                                        </div>
                                        <div class="d-flex">
                                            <p class="fw-semibold fs-7 mb-2"><?php echo e(trans('labels.order_type')); ?> : </p>&nbsp;
                                            <p class="fw-400 fs-7 text-muted mb-2">
                                                <?php echo e($orderdata->order_type == '1' ? trans('labels.delivery') : trans('labels.pickup')); ?>

                                            </p>
                                        </div>
                                        <div class="d-flex">
                                            <p class="fw-semibold fs-7 mb-2"><?php echo e(trans('labels.order_date')); ?> : </p>&nbsp;
                                            <p class="fw-400 fs-7 text-muted mb-2">
                                                <?php echo e(helper::date_format($orderdata->created_at)); ?>

                                            </p>
                                        </div>
                                        <div class="d-flex">
                                            <p class="fw-semibold fs-7 mb-2">
                                                <?php echo e($orderdata->order_type == '1' ? trans('labels.delivery_date') : trans('labels.pickup_date')); ?>

                                                : </p>&nbsp;
                                            <p class="fw-400 fs-7 text-muted mb-2">
                                                <?php echo e(helper::date_format($orderdata->delivery_date)); ?></p>
                                        </div>
                                        <div class="d-flex">
                                            <p class="fw-semibold fs-7 mb-2">
                                                <?php echo e($orderdata->order_type == '1' ? trans('labels.delivery_time') : trans('labels.pickup_time')); ?>

                                                : </p>&nbsp;
                                            <p class="fw-400 fs-7 text-muted mb-2"><?php echo e($orderdata->delivery_time); ?></p>
                                        </div>
                                        <div class="d-flex">
                                            <p class="fw-semibold fs-7 mb-2"><?php echo e(trans('labels.order_status')); ?> : </p>&nbsp;
                                            <?php if($orderdata->status_type == '1'): ?>
                                                <p class="text-order-placed mb-1 fw-500 fs-7">
                                                    <?php echo e(@helper::gettype($orderdata->status, $orderdata->status_type, $orderdata->order_type)->name == null ? '-' : @helper::gettype($orderdata->status, $orderdata->status_type, $orderdata->order_type)->name); ?>

                                                </p>
                                            <?php elseif($orderdata->status_type == '2'): ?>
                                                <p class="text-order-waitingpickup mb-1 fw-500 fs-7">
                                                    <?php echo e(@helper::gettype($orderdata->status, $orderdata->status_type, $orderdata->order_type)->name == null ? '-' : @helper::gettype($orderdata->status, $orderdata->status_type, $orderdata->order_type)->name); ?>

                                                </p>
                                            <?php elseif($orderdata->status_type == '3'): ?>
                                                <p class="text-order-completed mb-1 fw-500 fs-7">
                                                    <?php echo e(@helper::gettype($orderdata->status, $orderdata->status_type, $orderdata->order_type)->name == null ? '-' : @helper::gettype($orderdata->status, $orderdata->status_type, $orderdata->order_type)->name); ?>

                                                </p>
                                            <?php elseif($orderdata->status_type == '4'): ?>
                                                <p class="text-order-cancelled mb-1 fw-500 fs-7">
                                                    <?php echo e(@helper::gettype($orderdata->status, $orderdata->status_type, $orderdata->order_type)->name == null ? '-' : @helper::gettype($orderdata->status, $orderdata->status_type, $orderdata->order_type)->name); ?>

                                                </p>
                                            <?php endif; ?>

                                        </div>
                                        <div class="d-flex">
                                            <p class="fw-semibold fs-7 mb-2"><?php echo e(trans('labels.payment_type')); ?> : </p>&nbsp;
                                            <p class="fw-400 fs-7 text-muted mb-2">
                                                <?php echo e(helper::getpayment($orderdata->transaction_type)); ?>

                                                <?php if(!in_array($orderdata->transaction_type, [1, 2, 15])): ?>
                                                    [<?php echo e($orderdata->transaction_id); ?>]
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                        <?php if($orderdata->order_notes != ''): ?>
                                            <div class="d-flex">
                                                <p class="fw-semibold fs-7 mb-2 col-auto"><?php echo e(trans('labels.order_note')); ?> :
                                                </p>&nbsp;
                                                <p class="fw-400 fs-7 text-muted mb-2">
                                                    <?php echo e($orderdata->order_notes); ?>

                                                </p>
                                            </div>
                                        <?php endif; ?>
                                        <?php if($orderdata->admin_notes != ''): ?>
                                            <div class="d-flex">
                                                <p class="fw-semibold fs-7 mb-2 col-auto"><?php echo e(trans('labels.admin_note')); ?> :
                                                </p>&nbsp;
                                                <p class="fw-400 fs-7 text-muted mb-2">
                                                    <?php echo e($orderdata->admin_notes); ?>

                                                </p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-transparent">
                                        <h5 class="fw-bold fs-6 mb-0 py-1"><?php echo e(trans('labels.address_info')); ?></h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <p class="fw-semibold fs-7 mb-2"><?php echo e(trans('labels.name')); ?> : </p>&nbsp;
                                            <p class="fw-400 fs-7 text-muted mb-2"><?php echo e($orderdata->name); ?></p>
                                        </div>
                                        <div class="d-flex">
                                            <p class="fw-semibold fs-7 mb-2"><?php echo e(trans('labels.email')); ?> : </p>&nbsp;
                                            <p class="fw-400 fs-7 text-muted mb-2"><?php echo e($orderdata->email); ?></p>
                                        </div>
                                        <?php if($orderdata->address != null && $orderdata->address != ''): ?>
                                            <div class="d-flex">
                                                <p class="fw-semibold fs-7 mb-2"><?php echo e(trans('labels.address')); ?> : </p>&nbsp;
                                                <p class="fw-400 fs-7 text-muted mb-2"><?php echo e($orderdata->address); ?></p>
                                            </div>
                                        <?php endif; ?>
                                        <?php if($orderdata->city != null && $orderdata->city != ''): ?>
                                            <div class="d-flex">
                                                <p class="fw-semibold fs-7 mb-2"><?php echo e(trans('labels.city')); ?> : </p>&nbsp;
                                                <p class="fw-400 fs-7 text-muted mb-2"><?php echo e($orderdata->city); ?></p>
                                            </div>
                                        <?php endif; ?>
                                        <?php if($orderdata->state != null && $orderdata->state != ''): ?>
                                            <div class="d-flex">
                                                <p class="fw-semibold fs-7 mb-2"><?php echo e(trans('labels.state')); ?> : </p>&nbsp;
                                                <p class="fw-400 fs-7 text-muted mb-2"><?php echo e($orderdata->state); ?></p>
                                            </div>
                                        <?php endif; ?>
                                        <?php if($orderdata->country != null && $orderdata->country != ''): ?>
                                            <div class="d-flex">
                                                <p class="fw-semibold fs-7 mb-2"><?php echo e(trans('labels.country')); ?> : </p>&nbsp;
                                                <p class="fw-400 fs-7 text-muted mb-2"><?php echo e($orderdata->country); ?></p>
                                            </div>
                                        <?php endif; ?>
                                        <?php if($orderdata->landmark != null && $orderdata->landmark != ''): ?>
                                            <div class="d-flex">
                                                <p class="fw-semibold fs-7 mb-2"><?php echo e(trans('labels.landmark')); ?> : </p>&nbsp;
                                                <p class="fw-400 fs-7 text-muted mb-2"><?php echo e($orderdata->landmark); ?></p>
                                            </div>
                                        <?php endif; ?>
                                        <?php if($orderdata->postal_code != null && $orderdata->postal_code != ''): ?>
                                            <div class="d-flex">
                                                <p class="fw-semibold fs-7 mb-2"><?php echo e(trans('labels.pincode')); ?> : </p>&nbsp;
                                                <p class="fw-400 fs-7 text-muted mb-2"><?php echo e($orderdata->postal_code); ?></p>
                                            </div>
                                        <?php endif; ?>
                                        <div class="d-flex">
                                            <p class="fw-semibold fs-7 mb-2"><?php echo e(trans('labels.mobile')); ?> : </p>&nbsp;
                                            <p class="fw-400 fs-7 text-muted mb-2"><?php echo e($orderdata->mobile); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive border-top">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><?php echo e(trans('labels.image')); ?></th>
                                        <th><?php echo e(trans('labels.item')); ?></th>
                                        <th class="text-end"><?php echo e(trans('labels.unit_cost')); ?></th>
                                        <th class="text-end"><?php echo e(trans('labels.qty')); ?></th>
                                        <th class="text-end"><?php echo e(trans('labels.subtotal')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                $data = array();
                                foreach ($ordersdetails as $orders) {
                                    $total_price = ($orders['item_price'] + $orders['addons_total_price'] + $orders['extras_total_price']) * $orders['qty'];
                                    $data[] = array("total_price" => $total_price,);
                                    $addonstotal = $orders->addons_total_price + $orders['extras_total_price'];
                                ?>
                                    <tr>
                                        <td><img src="<?php echo e(helper::image_path($orders->item_image)); ?>" class="rounded hw-50"
                                                alt=""></td>
                                        <td>
                                            <img <?php if($orders['item_type'] == 1): ?> src="<?php echo e(helper::image_path('veg.svg')); ?>" <?php else: ?> src="<?php echo e(helper::image_path('nonveg.svg')); ?>" <?php endif; ?>
                                                class="item-type-img" alt="">
                                            <span class="fs-7"><?php echo e($orders->item_name); ?></span>
                                            <p class="mb-0 mt-1">
                                                <?php if($orders['addons_id'] != '' || $orders['extras_id'] != ''): ?>
                                                    <small>
                                                        <a class="text-muted fw-5400" href="javascript:void(0)"
                                                            onclick="showaddons('<?php echo e($orders['addons_name']); ?>','<?php echo e($orders['addons_price']); ?>','<?php echo e($orders['extras_name']); ?>','<?php echo e($orders['extras_price']); ?>','<?php echo e($orders['item_name']); ?>')"><?php echo e(trans('labels.customize')); ?>

                                                        </a>
                                                    </small>
                                                <?php endif; ?>
                                            </p>
                                        </td>
                                        <td class="text-end fs-7"><?php echo e(helper::currency_format($orders->item_price)); ?>

                                            <?php if($addonstotal != '0'): ?>
                                                <br><small class="text-muted">+
                                                    <?php echo e(helper::currency_format($addonstotal)); ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end fs-7"><?php echo e($orders->qty); ?></td>
                                        <td class="text-end fs-7"><?php echo e(helper::currency_format($total_price)); ?></td>
                                    </tr>
                                    <?php
                                }
                                $order_total = array_sum(array_column(@$data, 'total_price'));
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end pb-3">
                            <div class="col-md-4 col-12">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-0 d-flex justify-content-between">
                                        <span class=""> <?php echo e(trans('labels.order_total')); ?> </span>
                                        <span class="text-break fw-400"><?php echo e(helper::currency_format($order_total)); ?></span>
                                    </li>
                                    <?php if($orderdata->offer_code != null && $orderdata->discount_amount != null): ?>
                                        <li class="list-group-item px-0 d-flex justify-content-between">
                                            <span class=""> <?php echo e(trans('labels.discount')); ?>

                                                <?php echo e($orderdata->offer_code != '' ? '(' . $orderdata->offer_code . ')' : ''); ?>

                                            </span>
                                            <span class="text-break fw-400">-
                                                <?php echo e(helper::currency_format($orderdata->discount_amount)); ?></span>
                                        </li>
                                    <?php endif; ?>
                                    <?php
                                        $tax = explode('|', $orderdata->tax_amount);
                                        $tax_name = explode('|', $orderdata->tax_name);
                                    ?>
                                    <?php if($orderdata->tax_amount != null && $orderdata->tax_amount != ''): ?>
                                        <?php $__currentLoopData = $tax; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $tax_value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="list-group-item px-0 d-flex justify-content-between">
                                                <span class=""> <?php echo e($tax_name[$key]); ?></span>
                                                <span
                                                    class="text-break fw-400"><?php echo e(helper::currency_format($tax[$key])); ?></span>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <?php if($orderdata->order_type == 1): ?>
                                        <li class="list-group-item px-0 d-flex justify-content-between">
                                            <span class=""> <?php echo e(trans('labels.delivery_charge')); ?> </span>
                                            <span
                                                class="text-break fw-400"><?php echo e(helper::currency_format($orderdata->delivery_charge)); ?></span>
                                        </li>
                                    <?php endif; ?>
                                    <li class="list-group-item px-0 d-flex justify-content-between">
                                        <span class="fw-600 text-black"> <?php echo e(trans('labels.grand_total')); ?> </span>
                                        <span
                                            class="fw-600 text-black text-break"><?php echo e(helper::currency_format($orderdata->grand_total)); ?></span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<!-- MODAL_SELECTED_ADDONS--START -->
<div class="modal addons" id="modal_selected_addons" tabindex="-1" aria-labelledby="selected_addons_Label"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-between">
                <div class="pro-name d-flex gap-1 align-items-center">
                    <p class="mb-0 fw-600 fs-5" id="addon_item_name"></p>
                </div>
                <button type="button"
                    class="btn-close m-0 <?php echo e(session()->get('direction') == 2 ? 'close m-0' : ''); ?>"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-0">
                <!-- Addons -->
                <div class="mt-2 px-1 py-2 border-bottom d-none" id="addons">
                    <p class="fw-bold m-0"><?php echo e(trans('labels.addons')); ?></p>
                    <ul class="m-0 ps-2" id="item-addons"></ul>
                </div>
                <!-- Extras -->
                <div class="mt-2 px-1 py-2 border-bottom d-none" id="extras">
                    <p class="fw-bold m-0"><?php echo e(trans('labels.extras')); ?> </p>
                    <ul class="m-0 ps-2" id="item-extras"></ul>
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- MODAL_SELECTED_ADDONS--END -->

<script type="text/javascript">
    toastr.options = {
        "closeButton": true,
        "progressBar": true
    }
    <?php if(Session::has('success')): ?>
        toastr.success("<?php echo e(session('success')); ?>");
    <?php endif; ?>
    <?php if(Session::has('error')): ?>
        toastr.error("<?php echo e(session('error')); ?>");
    <?php endif; ?>
</script>
<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(url(env('ASSETSPATHURL') . 'web-assets/js/custom/orders.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/web/orders/orderdetails.blade.php ENDPATH**/ ?>