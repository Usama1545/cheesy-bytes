<?php use App\Helpers\helper; ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 my-2 d-flex justify-content-end">


                <?php if($orderdata->status_type == 1 || $orderdata->status_type == 2): ?>
                    <button type="button" class="btn btn-dark dropdown-toggle px-4 py-2"
                            data-bs-toggle="dropdown"><?php echo e(@helper::gettype($orderdata->status, $orderdata->status_type, $orderdata->order_type)->name == null ? trans('labels.action') : @helper::gettype($orderdata->status, $orderdata->status_type, $orderdata->order_type)->name); ?></button>
                    <div class="dropdown-menu dropdown-menu-right branch-only cursor-pointer">
                        <?php $__currentLoopData = helper::customstauts($orderdata->order_type); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a class="dropdown-item w-auto <?php if($orderdata->status == $status->id): ?> fw-600 <?php endif; ?>"
                               data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e($status->name); ?>"
                               onclick="OrderStatusUpdate('<?php echo e($orderdata->id); ?>','<?php echo e($status->id); ?>','<?php echo e($status->type); ?>','<?php echo e(URL::to('admin/orders/update')); ?>')">
                                <?php echo e($status->name); ?> </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
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
                                    <?php echo e(trans('labels.your_order_details')); ?></h6>
                            </div>
                            <div class="card-body">
                                <div class="basic-list-group">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item px-0 fs-7 fw-400 d-flex justify-content-between align-items-center">
                                            <p><?php echo e(trans('labels.order_number')); ?></p>
                                            <p class="text-dark fw-600"><?php echo e($orderdata->order_number); ?></p>
                                        </li>
                                        <li class="list-group-item px-0 fs-7 fw-400 d-flex justify-content-between align-items-center">
                                            <?php echo e(trans('labels.order_date')); ?>

                                            <p class="text-muted">
                                                <?php echo e(helper::date_format($orderdata->created_at)); ?></p>
                                        </li>
                                        <?php if($orderdata->delivery_date != ''): ?>
                                            <li class="list-group-item px-0 fs-7 fw-400 d-flex justify-content-between align-items-center">
                                                <?php echo e($orderdata->order_type == '1' ? trans('labels.delivery_date') : trans('labels.pickup_date')); ?>

                                                <p class="text-muted">
                                                    <?php echo e(helper::date_format($orderdata->delivery_date)); ?></p>
                                            </li>
                                        <?php endif; ?>
                                        <?php if($orderdata->delivery_time != ''): ?>
                                            <li class="list-group-item px-0 fs-7 fw-400 d-flex justify-content-between align-items-center">
                                                <?php echo e($orderdata->order_type == '1' ? trans('labels.delivery_time') : trans('labels.pickup_time')); ?>

                                                <p class="text-muted">
                                                    <?php echo e($orderdata->delivery_time); ?></p>
                                            </li>
                                        <?php endif; ?>

                                        <li class="list-group-item px-0 fs-7 fw-400 d-flex justify-content-between align-items-center">
                                            <?php echo e(trans('labels.payment_type')); ?>

                                            <p class="text-muted">
                                                <?php if($orderdata->order_type == 3): ?>
                                                    <?php if($orderdata->transaction_type == 0): ?>
                                                        <?php echo e(trans('labels.online')); ?>

                                                    <?php elseif($orderdata->transaction_type == 1): ?>
                                                        <?php echo e(trans('labels.cash')); ?>

                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <?php echo e(helper::getpayment($orderdata->transaction_type)); ?>

                                                <?php endif; ?>
                                            </p>
                                        </li>

                                        <?php if(in_array($orderdata->transaction_type, [3, 4, 5, 6, 7, 8, 9, 10])): ?>
                                            <li class="list-group-item px-0 fs-7 fw-400 d-flex justify-content-between align-items-center">
                                                <?php echo e(trans('labels.transaction_id')); ?>

                                                <p class="text-muted">
                                                    <?php echo e($orderdata->transaction_id); ?>

                                                </p>
                                            </li>
                                        <?php endif; ?>
                                        <?php if($orderdata->order_notes != ''): ?>
                                            <li class="list-group-item px-0"><?php echo e(trans('labels.order_note')); ?>

                                                <p class="text-muted">
                                                    <?php echo e($orderdata->order_notes); ?>

                                                </p>
                                            </li>
                                        <?php endif; ?>
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
                                    <?php echo e(trans('labels.customer_info')); ?>

                                </h6>
                                <p class="text-muted cursor-pointer"
                                   onclick="editcustomerdata('<?php echo e($orderdata->order_number); ?>','<?php echo e($orderdata->name); ?>','<?php echo e($orderdata->mobile); ?>','<?php echo e($orderdata->email); ?>','<?php echo e($orderdata->address); ?>','<?php echo e($orderdata->city); ?>','<?php echo e($orderdata->state); ?>','<?php echo e($orderdata->country); ?>','<?php echo e($orderdata->landmark); ?>','<?php echo e($orderdata->postal_code); ?>','customer_info')">
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
                                                    <p><?php echo e(trans('labels.name')); ?></p>
                                                    <p class="text-muted">
                                                        <?php echo e($orderdata->name); ?>

                                                    </p>
                                                </li>
                                                <li class="list-group-item px-0 fs-7 fw-400 d-flex justify-content-between align-items-center">
                                                    <p><?php echo e(trans('labels.mobile')); ?></p>
                                                    <p class="text-muted">
                                                        <?php echo e($orderdata->mobile); ?>

                                                    </p>
                                                </li>
                                                <li class="list-group-item px-0 fs-7 fw-400 d-flex justify-content-between align-items-center">
                                                    <p><?php echo e(trans('labels.email')); ?></p>
                                                    <p class="text-muted">
                                                        <?php echo e($orderdata->email); ?>

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
                                    <?php echo e($orderdata->order_type == '2' ? trans('labels.info') : trans('labels.bill_to')); ?>

                                </h6>
                                <?php if($orderdata->order_from != 'pos' && $orderdata->order_type == '1'): ?>
                                    <p class="text-muted cursor-pointer"
                                       onclick="editcustomerdata('<?php echo e($orderdata->order_number); ?>','<?php echo e($orderdata->name); ?>','<?php echo e($orderdata->mobile); ?>','<?php echo e($orderdata->email); ?>','<?php echo e($orderdata->address); ?>','<?php echo e($orderdata->city); ?>','<?php echo e($orderdata->state); ?>','<?php echo e($orderdata->country); ?>','<?php echo e($orderdata->landmark); ?>','<?php echo e($orderdata->postal_code); ?>','bill_info')">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </p>
                                <?php endif; ?>
                            </div>
                            <div class="card-body">
                                <div class="basic-list-group">
                                    <div class="row">
                                        <div class="col-md-12 mb-2">
                                            <div class="basic-list-group">
                                                <ul class="list-group list-group-flush">
                                                    <?php if($orderdata->order_from == 'pos'): ?>
                                                        <li
                                                            class="list-group-item px-0 fs-7 fw-400 d-flex justify-content-between align-items-center">
                                                            <p><?php echo e(trans('labels.pos')); ?></p>
                                                        </li>
                                                    <?php elseif($orderdata->order_from == 'web' && $orderdata->order_type == '2'): ?>
                                                        <li
                                                            class="list-group-item px-0 fs-7 fw-400 d-flex justify-content-between align-items-center">
                                                            <p><?php echo e(trans('labels.take_away')); ?></p>
                                                        </li>
                                                    <?php else: ?>
                                                        <li
                                                            class="list-group-item px-0 fs-7 fw-400 d-flex justify-content-between align-items-center">
                                                            <p><?php echo e(trans('labels.address')); ?></p>
                                                            <p class="text-muted"><?php echo e($orderdata->address); ?></p>
                                                        </li>
                                                        <li class="list-group-item px-0 fs-7 fw-400 d-flex justify-content-between align-items-center">
                                                            <p><?php echo e(trans('labels.city')); ?></p>
                                                            <p class="text-muted"> <?php echo e($orderdata->city); ?></p>
                                                        </li>
                                                        <li class="list-group-item px-0 fs-7 fw-400 d-flex justify-content-between align-items-center">
                                                            <p><?php echo e(trans('labels.state')); ?></p>
                                                            <p class="text-muted"> <?php echo e($orderdata->state); ?></p>
                                                        </li>
                                                        <li class="list-group-item px-0 fs-7 fw-400 d-flex justify-content-between align-items-center">
                                                            <p><?php echo e(trans('labels.country')); ?></p>
                                                            <p class="text-muted"> <?php echo e($orderdata->country); ?></p>
                                                        </li>
                                                        <li class="list-group-item px-0 fs-7 fw-400 d-flex justify-content-between align-items-center">
                                                            <p><?php echo e(trans('labels.landmark')); ?></p>
                                                            <p class="text-muted"> <?php echo e($orderdata->landmark); ?></p>
                                                        </li>
                                                        <li class="list-group-item px-0 fs-7 fw-400 d-flex justify-content-between align-items-center">
                                                            <p><?php echo e(trans('labels.pincode')); ?></p>
                                                            <p class="text-muted"> <?php echo e($orderdata->postal_code); ?></p>
                                                        </li>
                                                    <?php endif; ?>
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
                                    <?php echo e(trans('labels.notes')); ?></h6>
                            </div>
                            <div class="card-body">
                                <div class="basic-list-group">
                                    <div class="row">
                                        <div class="basic-list-group">
                                            <?php if($orderdata->admin_notes != ''): ?>
                                                <div class="alert alert-info" role="alert">
                                                    <?php echo e($orderdata->admin_notes); ?>

                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-white">
                                <form action="<?php echo e(URL::to('admin/orders/order_note')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <div class="form-group col-md-12">
                                        <label for="note"> <?php echo e(trans('labels.note')); ?> </label>
                                        <div class="controls">
                                            <input type="hidden" name="order_id" class="form-control"
                                                   value="<?php echo e($orderdata->order_number); ?>">
                                            <input type="text" name="admin_notes" class="form-control" required>
                                        </div>
                                    </div>
                                    <div
                                        class="form-group <?php echo e(session()->get('direction') == '2' ? 'text-start' : 'text-end'); ?>">
                                        <button
                                            <?php if(env('Environment') == 'sendbox'): ?> type="button" onclick="myFunction()"
                                            type="submit" <?php endif; ?>
                                            class="btn btn-primary"> <?php echo e(trans('labels.update')); ?> </button>
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
                        <h6 class="px-2 fw-500"><?php echo e(trans('labels.orders')); ?></h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th><?php echo e(trans('labels.image')); ?></th>
                                    <th><?php echo e(trans('labels.item')); ?></th>
                                    <th class="text-end"><?php echo e(trans('labels.unit_cost')); ?></th>
                                    <th class="text-end"><?php echo e(trans('labels.qty')); ?></th>
                                    <th class="text-end"><?php echo e(trans('labels.total')); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $data = [];
                                ?>
                                <?php $__currentLoopData = $ordersdetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orders): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $total_price =
                                            ($orders['item_price'] +
                                                $orders['addons_total_price'] +
                                                $orders['extras_total_price']) *
                                            $orders['qty'];
                                        $data[] = ['total_price' => $total_price];
                                        $order_total = array_sum(array_column(@$data, 'total_price'));
                                        $addonstotal = $orders->addons_total_price + $orders->extras_total_price;
                                    ?>
                                    <tr>
                                        <td><img src="<?php echo e(helper::image_path($orders->item_image)); ?>"
                                                 class="rounded h-50px" alt=""></td>
                                            <td>
                                                <?php echo e($orders->item_name); ?>(<?php echo e($orders->size->name); ?> -<?php echo e($orders->size->name); ?>) <br>
                                                <?php if($orders['addons_id'] != '' || $orders['extras_id'] != ''): ?>
                                                    <small>
                                                        <a class="text-muted fw-500" href="javascript:void(0)"
                                                           onclick="showaddons('<?php echo e($orders['addons_name']); ?>','<?php echo e($orders['addons_price']); ?>','<?php echo e($orders['extras_name']); ?>','<?php echo e($orders['extras_price']); ?>','<?php echo e($orders['item_name']); ?>')"><?php echo e(trans('labels.customize')); ?>

                                                        </a>
                                                    </small>
                                                <?php endif; ?>
                                                <?php if($orders['dipping_quantity'] != ''): ?>
                                                    <small>
                                                        <span class="text-muted fw-500" data-bs-toggle="modal" data-bs-target="#dippingModal"
                                                           >Dipping
                                                        </span>
                                                    </small>
                                                <?php endif; ?>
                                            </td>
                                        <td class="text-end">
                                            <?php echo e(helper::currency_format($orders->item_price)); ?>

                                            <?php if($addonstotal != 0): ?>
                                                <br><small class="text-muted">+
                                                    <?php echo e(helper::currency_format($addonstotal)); ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end"><?php echo e($orders->qty); ?></td>
                                        <td class="text-end">
                                            <?php echo e(helper::currency_format($total_price)); ?></td>
                                    </tr>
                                    <div class="modal fade" id="dippingModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel"><?php echo e($orders->item_name); ?> - <?php echo e($orders->crust->name); ?> -<?php echo e($orders->size->name); ?></h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="mt-2 p-2 border-bottom">
                                                        <ul class="m-0 ps-2" >

                                                                <?php
                                                                // Exploding dipping_name, quantity, and price if they are in a delimited format
                                                                $dippingNames = explode('|', $orders['dipping_name']);
                                                                $dippingQuantities = $orders['dipping_quantity'];
                                                                $dippingPrices = $orders['dipping_price'];
                                                                ?>

                                                            <?php $__currentLoopData = $dippingNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <li class="list-group-item fs-7 d-flex text-muted">
                                                                    <span class="flex-grow-1"><?php echo e($name); ?></span>
                                                                    <span class="ml-3"><?php echo e($dippingQuantities[$key]); ?> (<?php echo e($dippingQuantities[$key] * $dippingPrices[$key]); ?>$)</span>
                                                                </li>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <?php $__currentLoopData = $orderCustomdetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orders): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $total_price =
                                            $orders['item_price']*$orders['qty'];
                                        $data[] = ['total_price' => $total_price];
                                        $order_total = array_sum(array_column($data, 'total_price'));
                                    ?>
                                    <tr>
                                        <td><img src="<?php echo e(helper::image_path($orders->item_image)); ?>"
                                                 class="rounded h-50px" alt=""></td>
                                        <?php if($orders->custom_pizza_id !== null): ?>
                                            <td>
                                                <?php echo e($orders->item_name); ?> <br>
                                                <small>
                                                    <a class="text-muted fw-500" href="javascript:void(0)"
                                                       data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                    ><?php echo e(trans('labels.customize')); ?>

                                                    </a>
                                                </small>
                                            </td>
                                        <?php else: ?>

                                            <td>
                                                <img
                                                    <?php if($orders['item_type'] == 1): ?> src="<?php echo e(helper::image_path('veg.svg')); ?>"
                                                    <?php else: ?> src="<?php echo e(helper::image_path('nonveg.svg')); ?>" <?php endif; ?>
                                                    class="item-type-img" alt="">
                                                <?php echo e($orders->item_name); ?> <br>
                                                <?php if($orders['addons_id'] != '' || $orders['extras_id'] != ''): ?>
                                                    <small>
                                                        <a class="text-muted fw-500" href="javascript:void(0)"
                                                           onclick="showaddons('<?php echo e($orders['addons_name']); ?>','<?php echo e($orders['addons_price']); ?>','<?php echo e($orders['extras_name']); ?>','<?php echo e($orders['extras_price']); ?>','<?php echo e($orders['item_name']); ?>')"><?php echo e(trans('labels.customize')); ?>

                                                        </a>
                                                    </small>
                                                <?php endif; ?>
                                            </td>
                                        <?php endif; ?>
                                        <td class="text-end">
                                            <?php echo e(helper::currency_format($orders->item_price)); ?>

                                            <?php if($addonstotal != 0): ?>
                                                <br><small class="text-muted">+
                                                    <?php echo e(helper::currency_format($addonstotal)); ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end"><?php echo e($orders->qty); ?></td>
                                        <td class="text-end">
                                            <?php echo e(helper::currency_format($total_price)); ?></td>
                                    </tr>
                                    <div class="modal fade" id="exampleModal" tabindex="-1"
                                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">

                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5"
                                                        id="exampleModalLabel"><?php echo e($orders->item_name); ?></h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <?php if($orders->custom_pizza_id !== null): ?>


                                                        <div class="mt-2 p-2 border-bottom" id="extras">
                                                            <p class="m-0 fs-6 fw-500">Size: <small
                                                                    class="text-muted"><?php echo e($orders->custom_pizza->size->label); ?>

                                                                    (<?php echo e($orders->custom_pizza->size->name); ?>")</small></p>
                                                            <p class="m-0 fs-6 fw-500">Special: <small
                                                                    class="text-muted"><?php echo e($orders->custom_pizza->cut); ?>

                                                                    / <?php echo e($orders->custom_pizza->bake); ?> / <?php echo e($orders->custom_pizza->seasoning); ?></small>
                                                            </p>
                                                            <p class="m-0 fs-6 fw-500">Crust: <small
                                                                    class="text-muted"><?php echo e($orders->custom_pizza->crust->name); ?></small>
                                                            </p>
                                                            <p class="m-0 fs-6 fw-500">Sauce: <small
                                                                    class="text-muted"><?php echo e($orders->custom_pizza->sauce->name); ?></small>
                                                            </p>
                                                            <p class="m-0 fs-6 fw-500">Toppings </p>
                                                            <ul class="m-0 ps-2" id="item-extras">
                                                                <?php $__currentLoopData = $orders->custom_pizza->toppings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topping): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <li class="list-group-item fs-7 d-flex  text-muted">
                                                                        <span
                                                                            class="flex-grow-1 "><?php echo e($topping->name); ?></span>
                                                                        <span
                                                                            class="ml-3"><?php echo e($topping->pivot->side); ?></span>
                                                                        <span
                                                                            class=" px-3"><?php echo e($topping->pivot->quantity); ?></span>
                                                                    </li>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </ul>
                                                            <p class="m-0 fs-6 fw-500">Dipping</p>
                                                            <ul class="m-0 ps-2" id="item-extras">
                                                                <?php $__currentLoopData = $orders->custom_pizza->dipping; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dipping): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <li class="list-group-item fs-7 d-flex  text-muted">
                                                                        <span
                                                                            class="flex-grow-1 "><?php echo e($dipping->name); ?></span>

                                                                        <span
                                                                            class=" px-3"><?php echo e($dipping->pivot->quantity); ?> x <?php echo e($dipping->price); ?>$</span>
                                                                        <span
                                                                            class="px-3"><?php echo e($dipping->pivot->quantity * $dipping->price); ?>$</span>
                                                                    </li>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </ul>
                                                        </div>
                                                    <?php endif; ?>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                <tr>
                                    <td class="text-end" colspan="4">
                                        <p class="fw-400"><?php echo e(trans('labels.subtotal')); ?></p>
                                    </td>
                                    <td class="text-end">
                                        <p class="fw-400"><?php echo e(helper::currency_format($order_total)); ?></p>
                                    </td>
                                </tr>
                                <?php if($orderdata->discount_amount > 0): ?>
                                    <tr>
                                        <td class="text-end" colspan="4">
                                            <p class="fw-400"><?php echo e(trans('labels.discount')); ?></p>
                                            <?php echo e($orderdata->offer_code != '' ? '(' . $orderdata->offer_code . ')' : ''); ?>

                                        </td>
                                        <td class="text-end">
                                            <p class="fw-400">-
                                                <?php echo e(helper::currency_format($orderdata->discount_amount)); ?></p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <?php
                                    $tax = explode('|', $orderdata->tax_amount);
                                    $tax_name = explode('|', $orderdata->tax_name);
                                ?>
                                <?php if($orderdata->tax_amount != null && $orderdata->tax_amount != ''): ?>
                                    <?php $__currentLoopData = $tax; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $tax_value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="text-end" colspan="4">
                                                <p class="fw-400"><?php echo e($tax_name[$key]); ?></p>
                                            </td>
                                            <td class="text-end">
                                                <p class="fw-400"><?php echo e(helper::currency_format($tax_value)); ?></p>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                                <?php if($orderdata->delivery_charge > 0): ?>
                                    <tr>
                                        <td class="text-end" colspan="4">
                                            <p class="fw-400"><?php echo e(trans('labels.delivery_charge')); ?></p>
                                        </td>
                                        <td class="text-end">
                                            <p class="fw-400"><?php echo e(helper::currency_format($orderdata->delivery_charge)); ?></p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <td class="text-end" colspan="4">
                                        <strong><?php echo e(trans('labels.grand_total')); ?></strong>
                                    </td>
                                    <td class="text-end">
                                        <strong><?php echo e(helper::currency_format($orderdata->grand_total)); ?></strong>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- custom pizza details -->


        <!-- Customer and Bill info Modal-->
        <div class="modal fade" id="customerinfo" tabindex="-1" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header justify-content-between">
                        <h5 class="modal-title" id="modalbankdetailsLabel"><?php echo e(trans('labels.edit')); ?></h5>
                        <button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form enctype="multipart/form-data" action="<?php echo e(URL::to('admin/orders/customerbillinfo')); ?>"
                          method="POST">
                        <div class="modal-body">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="order_id" id="modal_order_id" class="form-control"
                                   value="">
                            <input type="hidden" name="edit_type" id="edit_type" class="form-control" value="">
                            <div id="customer_info">
                                <div class="form-group col-md-12">
                                    <label for="user_name"> <?php echo e(trans('labels.name')); ?> </label>
                                    <div class="controls">
                                        <input type="text" name="user_name" id="user_name" class="form-control"
                                               required>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="user_mobile"> <?php echo e(trans('labels.mobile')); ?> </label>
                                    <div class="controls">
                                        <input type="text" name="user_mobile" id="user_mobile" class="form-control"
                                               required>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="user_email"> <?php echo e(trans('labels.email')); ?> </label>
                                    <div class="controls">
                                        <input type="text" name="user_email" id="user_email" class="form-control"
                                               required>
                                    </div>
                                </div>
                            </div>

                            <div id="bill_info">
                                <div class="form-group col-md-12">
                                    <label for="bill_address"> <?php echo e(trans('labels.address')); ?> </label>
                                    <div class="controls">
                                        <input type="text" name="bill_address" id="bill_address" class="form-control"
                                               required>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="bill_city"> <?php echo e(trans('labels.city')); ?> </label>
                                    <div class="controls">
                                        <input type="text" name="bill_city" id="bill_city" class="form-control"
                                               required>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="bill_state"> <?php echo e(trans('labels.state')); ?> </label>
                                    <div class="controls">

                                        <input type="text" name="bill_state" id="bill_state" class="form-control"
                                               required>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="bill_country"> <?php echo e(trans('labels.country')); ?> </label>
                                    <div class="controls">
                                        <input type="text" name="bill_country" id="bill_country" class="form-control"
                                               required>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="bill_landmark"> <?php echo e(trans('labels.landmark')); ?> </label>
                                    <div class="controls">
                                        <input type="text" name="bill_landmark" id="bill_landmark"
                                               class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="bill_pincode"> <?php echo e(trans('labels.pincode')); ?> </label>
                                    <div class="controls">
                                        <input type="text" name="bill_pincode" id="bill_pincode" class="form-control"
                                               required>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger"
                                    data-bs-dismiss="modal"><?php echo e(trans('labels.close')); ?></button>
                            <button
                                <?php if(env('Environment') == 'sendbox'): ?> type="button" onclick="myFunction()" type="submit"
                                <?php endif; ?>
                                class="btn btn-primary"> <?php echo e(trans('labels.save')); ?> </button>
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
                                class="btn-close m-0 <?php echo e(session()->get('direction') == 2 ? 'close m-0' : ''); ?>"
                                data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-0">
                        <!-- Addons -->
                        <div class="mt-2 p-2 border-bottom d-none" id="addons">
                            <p class="m-0 fs-6 fw-500"><?php echo e(trans('labels.addons')); ?></p>
                            <ul class="m-0 <?php echo e(session()->get('direction') == '2' ? 'pe-2' : 'ps-2'); ?>"
                                id="item-addons"></ul>
                        </div>
                        <!-- Extras -->
                        <div class="mt-2 p-2 border-bottom d-none" id="extras">
                            <p class="m-0 fs-6 fw-500"><?php echo e(trans('labels.extras')); ?> </p>
                            <ul class="m-0 <?php echo e(session()->get('direction') == '2' ? 'pe-2' : 'ps-2'); ?>"
                                id="item-extras"></ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL_SELECTED_ADDONS--END -->
    </div>
    <style>

    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/orders.js')); ?>"></script>
    <script>
        function showaddons(addon_name, addon_price, extra_name, extra_price, item_name) {
            "use strict";
            $('#addons').addClass('d-none');
            $('#extras').addClass('d-none');
            $('#modal_selected_addons').find('#addon_item_name').html(item_name);
            var response1 = '';
            if (addon_name.split('| ') != '') {
                $.each(addon_name.split('| '), function (key, value) {
                    response1 += '<li class="list-group-item fs-7 d-flex justify-content-between text-black">' + value +
                        ' <p class="mb-0">' + currency_format(addon_price.split('| ')[key]) + '</p> </li>';
                });
                $('#addons').removeClass('d-none');
            }
            $('#item-addons').html(response1);
            var response2 = '';
            if (extra_name.split('| ') != '') {
                $.each(extra_name.split('| '), function (key, value) {
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

        $('#driver').on('change', function () {
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                url: "<?php echo e(URL::to('admin/orders/assign-driver')); ?>",
                type: "post",
                dataType: "json",
                data: {
                    driver_id: $(this).val(),
                    order_id: "<?php echo e($orderdata->id); ?>",
                },
                success: function (response) {
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.theme.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/orders/invoice.blade.php ENDPATH**/ ?>