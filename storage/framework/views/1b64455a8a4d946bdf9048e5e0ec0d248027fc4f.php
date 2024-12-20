<?php $__env->startSection('page_title'); ?>
    | <?php echo e(trans('labels.checkout')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="breadcrumb-sec">
        <div class="container">
            <div class="breadcrumb-sec-content">
                <nav class="text-dark d-flex breadcrumb-divider" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li
                            class="breadcrumb-item <?php echo e(session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : ''); ?>">
                            <a class="text-dark fw-bold" href="<?php echo e(URL::to('/')); ?>"><?php echo e(trans('labels.home')); ?></a>
                        </li>
                        <li class="breadcrumb-item <?php echo e(session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : ''); ?> text-primary fw-bold active"
                            aria-current="page"><?php echo e(trans('labels.checkout')); ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <?php if(count($getcartlist) > 0): ?>
        <?php
            $totaltax = 0;
            $order_total = 0;
            $total_item_qty = 0;
            $totalcarttax = 0;
        ?>
        <?php $__currentLoopData = $taxArr['tax']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $rate = $taxArr['rate'][$k];
                $totalcarttax += (float) $taxArr['rate'][$k];
            ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php $__currentLoopData = $getcartlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $total_price =
                    ($item['item_price'] + $item['addons_total_price'] + $item['extras_total_price']) * $item['qty'];
                $order_total += (float) $total_price;
                $total_item_qty += $item['qty'];
            ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <section class="my-5">
            <div class="container">
                <h3 class="fw-bold fs-2 mb-4 truncate-2"><?php echo e(trans('labels.checkout')); ?></h3>
                <div class="cart-view">
                    <div class="row">
                        <div class="col-lg-8 order-md2">
                            <div class="card mb-3 order-option">
                                <div class="card-body">
                                    <div class="">
                                        <div class="heading mb-2 border-bottom">
                                            <h5><?php echo e(trans('labels.order_type')); ?></h5>
                                        </div>
                                        <div class="col-12 d-flex gap-3">
                                            <?php if($getsettings->pickup_delivery == 1): ?>
                                                <div class="form-check form-check-inline mb-0">
                                                    <input class="form-check-input" type="radio" name="order_type" value="1" id="delivery"
                                                        <?php echo e($address->address_type === 'delivery' ? 'checked' : ($address->address_type === 'carryout' ? '' : 'checked')); ?>>
                                                    <label class="form-check-label fs-7 fw-500" for="delivery">
                                                        <?php echo e(trans('labels.delivery')); ?>

                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline mb-0">
                                                    <input class="form-check-input" type="radio" name="order_type"
                                                        value="2" id="pickup" <?php echo e($address->address_type === 'carryout' ? 'checked' : ''); ?>>
                                                    <label class="form-check-label fs-7 fw-500" for="pickup">
                                                        <?php echo e(trans('labels.take_away')); ?>

                                                    </label>
                                                </div>
















                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if(helper::appdata()->ordertype_date_time == 1): ?>
                                <div class="card mb-3 date-view">
                                    <div class="card-body">
                                        <div class="heading mb-3 border-bottom">
                                            <h5><?php echo e(trans('labels.date_time')); ?></h5>
                                        </div>
                                        <div class="row g-3">
                                            <div
                                                class="col-sm-6 delivery-date <?php echo e(session()->get('direction') == '2' ? 'text-right' : ''); ?>">
                                                <label id="delivery_date"
                                                    class="form-label justify-content-start"><?php echo e(trans('labels.delivery_date')); ?>

                                                    <span class="text-danger">*</span>
                                                </label>
                                                <label id="pickup_date" class="form-label d-none">
                                                    <?php echo e(trans('labels.pickup_date')); ?>

                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text"
                                                    class="form-control rounded-2 p-3 delivery_pickup_date"
                                                    name="delivery_date" value="<?php echo e(old('delivery_date')); ?>"
                                                    id="delivery_dt" min="<?php echo date('Y-m-d'); ?>">
                                            </div>
                                            <div
                                                class="col-sm-6 delivery-time <?php echo e(session()->get('direction') == '2' ? 'text-right' : ''); ?>">
                                                <label id="delivery_time"
                                                    class="form-label justify-content-start"><?php echo e(trans('labels.delivery_time')); ?>

                                                    <span class="text-danger">*</span>
                                                </label>
                                                <label id="pickup_time"
                                                    class="form-label justify-content-start d-none"><?php echo e(trans('labels.pickup_time')); ?>

                                                    <span class="text-danger">*</span>
                                                </label>
                                                <label id="store_close"
                                                    class="d-none form-label text-danger label14"><?php echo e(trans('messages.restaurant_closed')); ?></label>
                                                <select name="delivery_time" id="delivery_slot_time"
                                                    class="form-select rounded-2 py-3">
                                                    <option value="<?php echo e(old('delivery_time')); ?>">
                                                        <?php echo e(trans('labels.select')); ?>

                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="heading mb-2 border-bottom">
                                        <h5><?php echo e(trans('labels.customer_info')); ?></h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="first_name" class="form-label"><?php echo e(trans('labels.first_name')); ?>

                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="first_name" id="first_name"
                                                placeholder="<?php echo e(trans('labels.first_name')); ?>"
                                                value="<?php echo e(Auth::user() && Auth::user()->type == 2 ? Auth::user()->name : old('first_name')); ?>"
                                                required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="last_name" class="form-label"><?php echo e(trans('labels.last_name')); ?>

                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="last_name" id="last_name"
                                                placeholder="<?php echo e(trans('labels.last_name')); ?>"
                                                value="<?php echo e(old('last_name')); ?>" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label"><?php echo e(trans('labels.email')); ?>

                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="email" id="email"
                                                placeholder="<?php echo e(trans('labels.email')); ?>"
                                                value="<?php echo e(Auth::user() && Auth::user()->type == 2 ? Auth::user()->email : old('email')); ?>"
                                                required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="mobile" class="form-label"><?php echo e(trans('labels.mobile')); ?>

                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="mobile" id="mobile"
                                                placeholder="<?php echo e(trans('labels.mobile')); ?>"
                                                value="<?php echo e(Auth::user() && Auth::user()->type == 2 ? Auth::user()->mobile : old('mobile')); ?>"
                                                required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-3" id="addressdiv">
                                <div class="card-body">
                                    <div
                                        class="d-flex justify-content-between align-items-center heading mb-2 border-bottom">
                                        <h5><?php echo e(trans('labels.delivery_address')); ?></h5>
                                    </div>
                                    <div class="row g-3">
                                        <?php if(Auth::user() && Auth::user()->type == 2): ?>
                                            <div class="col-md-9 col-sm-8">
                                                <?php if($getaddresses->count() > 0): ?>
                                                    <label class="form-label"><?php echo e(trans('labels.select_address')); ?></label>
                                                    <select name="address_type" id="address_type" class="form-select">
                                                        <?php $__currentLoopData = $getaddresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($address->id); ?>"
                                                                <?php echo e($address->is_default == 1 ? 'selected' : ''); ?>>
                                                                <?php echo e($address->title); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-md-3 col-sm-4 py-sm-4">
                                                <a href="<?php echo e(URL::to('/address')); ?>" type="button"
                                                    class="btn btn-address mt-sm-2 w-100">
                                                    <i class="fa-solid fa-plus mx-1"></i>
                                                    <?php echo e(trans('labels.add_address')); ?></a>
                                            </div>
                                        <?php endif; ?>
                                        <div class="col-12">
                                            <label for="address" class="form-label"><?php echo e(trans('labels.address')); ?>

                                                <span class="text-danger">*</span>
                                            </label>
                                            <textarea name="address" id="new_address" class="form-control" rows="6"
                                                placeholder="<?php echo e(trans('labels.address')); ?>" required><?php echo e($address->address ?? old('address')); ?></textarea>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="city" class="form-label"><?php echo e(trans('labels.city')); ?>

                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="city" id="new_city"
                                                placeholder="<?php echo e(trans('labels.city')); ?>" value="<?php echo e($address->city ?? old('city')); ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="state" class="form-label"><?php echo e(trans('labels.state')); ?>

                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control form-select" name="state_id" id="state">
                                                <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($state->name); ?>" <?php echo e($address->state == $state->id ? 'selected' : ''); ?>><?php echo e($state->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="pincode" class="form-label"><?php echo e(trans('labels.pincode')); ?>

                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="pincode" id="new_pincode"
                                                placeholder="<?php echo e(trans('labels.pincode')); ?>"
                                                value="<?php echo e($address->zip ?? old('pincode')); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3" id="pickupdiv">
                                <div class="card-body">
                                    <div class="heading mb-2 border-bottom">
                                        <h5><?php echo e(trans('labels.shippingarea')); ?></h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <select name="delivery_area" id="pickup_area" class="form-select">
                                                <option value="" data-charge="0"><?php echo e(trans('labels.select')); ?>

                                                </option>
                                                <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($area->id); ?>"
                                                            data-charge="0"><?php echo e($area->name.','.$area->address.' '.$area->city.' '.$area->state->name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3" id="shipping_area">
                                <div class="card-body">
                                    <div class="heading mb-2 border-bottom">
                                        <h5><?php echo e(trans('labels.shippingarea')); ?></h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <select name="delivery_area" id="shipping_delivery_area" class="form-select">
                                                <option value="" data-charge="0"><?php echo e(trans('labels.select')); ?>

                                                </option>
                                                <?php $__currentLoopData = $shippingarea; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($area->id); ?>"
                                                        data-charge="<?php echo e($area->delivery_charge); ?>"><?php echo e($area->name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="payment-option mb-3 border">
                                <div class="heading mb-2 border-bottom">
                                    <h2><?php echo e(trans('labels.choose_payment')); ?></h2>
                                </div>
                                <!-- payment-options -->
                                <?php echo $__env->make('web.paymentmethodsview', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <div class="row g-3 justify-content-between mt-4 align-items-center">
                                    <div class="align-items-center col-sm-6 col-12">
                                        <a href="<?php echo e(URL::to('/')); ?>" class="btn btn-outline-dark w-100 p-2"><i
                                                class="fa-solid fa-circle-arrow-left <?php echo e(session()->get('direction') == '2' ? 'ms-2' : 'me-2'); ?>"></i><?php echo e(trans('labels.continue_shopping')); ?></a>
                                    </div>
                                    <div class="align-items-center col-sm-6 col-12">
                                        <button
                                            class="btn btn-primary w-100 d-flex gap-3 justify-content-center align-items-center checkout"
                                            onclick="isopenclose('<?php echo e(URL::to('/isopenclose')); ?>','<?php echo e($total_item_qty); ?>','<?php echo e($order_total); ?>')">
                                            <?php echo e(trans('labels.proceed_pay')); ?>

                                            <div class="loader d-none checkout_loader"></div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 order-md1">
                            <?php if(@helper::checkaddons('coupon')): ?>
                                <div class="promocode mb-4 py-3">
                                    <label class="mb-3"><?php echo e(trans('labels.apply_promo')); ?></label>
                                    <div class="row justify-content-between align-items-center">
                                        <?php if(session()->get('discount_data')): ?>
                                            <form action="<?php echo e(URL::to('/promocodes/remove')); ?>" method="post">
                                                <?php echo csrf_field(); ?>
                                                <div class="d-flex">
                                                    <input type="text" class="form-control" name="offer_code"
                                                        value="<?php echo e(session()->get('discount_data')['offer_code']); ?>"
                                                        placeholder="<?php echo e(trans('labels.have_promocode')); ?>" disabled>
                                                    <button type="submit"
                                                        class="btn btn-primary bg-primary border-0 ms-2"><?php echo e(trans('labels.remove')); ?>

                                                    </button>
                                                </div>
                                            </form>
                                        <?php else: ?>
                                            <form action="<?php echo e(URL::to('/promocodes/apply')); ?>" method="post">
                                                <?php echo csrf_field(); ?>
                                                <div class="d-flex">
                                                    <input type="hidden" name="order_amount"
                                                        value="<?php echo e($order_total); ?>">
                                                    <input type="text" class="form-control" name="offer_code"
                                                        value="<?php echo e(old('offer_code')); ?>" id="offer_code"
                                                        placeholder="<?php echo e(trans('labels.have_promocode')); ?>" required>
                                                    <button type="submit"
                                                        class="btn px-4 btn-primary bg-primary border-0 <?php echo e(session()->get('direction') == '2' ? 'me-2' : 'ms-2'); ?>"><?php echo e(trans('labels.apply')); ?></button>
                                                </div>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <!-- payment-summary -->
                            <div class="summary py-3 mb-4">
                                <h2 class="border-bottom"><?php echo e(trans('labels.payment_summary')); ?></h2>
                                <div class="bill-details border-bottom pb-2">
                                    <div class="row justify-content-between align-items-center">
                                        <div class="col-auto"><span><?php echo e(trans('labels.subtotal')); ?></span></div>
                                        <div class="col-auto">
                                            <span><?php echo e(helper::currency_format($order_total)); ?></span>
                                        </div>
                                    </div>
                                    <?php
                                        if (session()->has('discount_data')) {
                                            $discount_amount = session()->get('discount_data')['offer_amount'];
                                        } else {
                                            $discount_amount = 0;
                                        }
                                        if (session()->has('addressdata')) {
                                            $grand_total = $order_total - $discount_amount + $totalcarttax;
                                        } else {
                                            $grand_total = $order_total - $discount_amount + $totalcarttax;
                                        }
                                    ?>

                                    <?php if(session()->has('discount_data')): ?>
                                        <div class="row justify-content-between align-items-center">
                                            <div class="col-auto"><span><?php echo e(trans('labels.discount')); ?>

                                                    <?php echo e(session()->has('discount_data') == true ? '(' . session()->get('discount_data')['offer_code'] . ')' : ''); ?>

                                                </span></div>
                                            <div class="col-auto">
                                                <span>- <?php echo e(helper::currency_format($discount_amount)); ?></span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php
                                        $totalcarttax = 0;
                                    ?>
                                    <?php $__currentLoopData = $taxArr['tax']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $rate = $taxArr['rate'][$k];
                                            $totalcarttax += (float) $taxArr['rate'][$k];
                                        ?>

                                        <div class="row justify-content-between align-items-center">
                                            <div class="col-auto"><span><?php echo e($tax); ?></span></div>
                                            <div class="col-auto">
                                                <span> <?php echo e(helper::currency_format($rate)); ?></span>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php $delivery_charge = 0; ?>
                                    <div class="row justify-content-between align-items-center" id="delivery_charge">
                                        <div class="col-auto"><span><?php echo e(trans('labels.delivery_charge')); ?></span>
                                        </div>
                                        <div class="col-auto">
                                            <span class="delivery_charge" id="delivery_amount">
                                                <?php echo e(helper::currency_format(0)); ?>

                                            </span>
                                        </div>
                                    </div>

                                </div>
                                <div class="bill-total mt-2">
                                    <div class="row justify-content-between align-items-center">
                                        <div class="col-auto"><span><?php echo e(trans('labels.grand_total')); ?></span></div>
                                        <div class="col-auto"><span class="grand_total"
                                                id="total_amount"><?php echo e(helper::currency_format($grand_total)); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- special-instruction -->
                            <div class="special-instruction mb-3 border">
                                <label class="form-label mb-3 border-bottom pb-2 w-100"
                                    for="order_notes"><?php echo e(trans('labels.special_instruction')); ?></label>
                                <textarea class="form-control" name="order_notes" id="order_notes" rows="3"
                                    placeholder="<?php echo e(trans('labels.special_instruction')); ?>"></textarea>
                            </div>
                        </div>
                    </div>
                </div>


                <input type="hidden" name="user_id" id="user_id" value="<?php echo e(@Auth::user()->id); ?>">
                <input type="hidden" name="session_id" id="session_id" value="<?php echo e(@Session::getId()); ?>">
                <input type="hidden" name="order_type" id="order_type" value="<?php echo e(session()->get('order_type')); ?>">
                <input type="hidden" name="grand_total" id="grand_total" value="<?php echo e(helper::currency_format($grand_total)); ?>">
                <input type="hidden" name="sub_total" id="sub_total" value="<?php echo e($order_total); ?>">
                <input type="hidden" name="discount" id="discount" value="<?php echo e($discount_amount); ?>">
                <input type="hidden" name="totaltaxamount" id="totaltaxamount" value="<?php echo e($totalcarttax); ?>">
                <input type="hidden" name="tax" id="tax" value="<?php echo e(implode('|', $taxArr['rate'])); ?>">
                <input type="hidden" name="tax_name" id="tax_name" value="<?php echo e(implode('|', $taxArr['tax'])); ?>">
                <input type="hidden" name="shipping_charge" id="shipping_charge" value="">
                <input type="hidden" name="delivery_charge" id="delivery_charge" value="<?php echo e($delivery_charge); ?>">
                <input type="hidden" name="user_name" id="user_name" value="<?php echo e(@Auth::user()->name); ?>">
                <input type="hidden" name="user_email" id="user_email" value="<?php echo e(@Auth::user()->email); ?>">
                <input type="hidden" name="user_mobile" id="user_mobile" value="<?php echo e(@Auth::user()->mobile); ?>">
                <input type="hidden" name="buynow" id="buynow" value="<?php echo e(request()->get('buynow')); ?>">
                <input type="hidden" name="delivery_area" id="buynow" value="<?php echo e(request()->get('buynow')); ?>">

                <input type="hidden" name="sloturl" id="sloturl" value="<?php echo e(URL::to('/timeslot')); ?>">
                <input type="hidden" name="orderurl" id="orderurl" value="<?php echo e(URL::to('placeorder')); ?>">
                <input type="hidden" name="paymentsuccess" id="paymentsuccess"
                    value="<?php echo e(URL::to('/paymentsuccess')); ?>">
                <input type="hidden" name="paymentfail" id="paymentfail" value="<?php echo e(URL::to('/paymentfail')); ?>">
                <input type="hidden" name="continueurl" id="continueurl" value="<?php echo e(URL::to('/')); ?>">
                <input type="hidden" name="environment" id="environment" value="<?php echo e(env('Environment')); ?>">
                <input type="hidden" name="myfatoorahurl" id="myfatoorahurl" value="<?php echo e(URL::to('/myfatoorah')); ?>">
                <input type="hidden" name="mercadopagourl" id="mercadopagourl"
                    value="<?php echo e(URL::to('/mercadorequest')); ?>">
                <input type="hidden" name="paypalurl" id="paypalurl" value="<?php echo e(URL::to('/paypal')); ?>">
                <input type="hidden" name="toyyibpayurl" id="toyyibpayurl" value="<?php echo e(URL::to('/toyyibpay')); ?>">
                <input type="hidden" name="paytaburl" id="paytaburl" value="<?php echo e(URL::to('/paytab')); ?>">
                <input type="hidden" name="phonepeurl" id="phonepeurl" value="<?php echo e(URL::to('/phonepe')); ?>">
                <input type="hidden" name="mollieurl" id="mollieurl" value="<?php echo e(URL::to('/mollie')); ?>">
                <input type="hidden" name="khaltiurl" id="khaltiurl" value="<?php echo e(URL::to('/khalti')); ?>">

                <input type="hidden" value="<?php echo e(URL::to('getaddress')); ?>" name="getaddress" id="getaddress">

                <input type="hidden" value="<?php echo e(trans('messages.delivery_date_required')); ?>"
                    name="delivery_date_message" id="delivery_date_message">
                <input type="hidden" value="<?php echo e(trans('messages.delivery_time_required')); ?>"
                    name="delivery_time_message" id="delivery_time_message">
                <input type="hidden" value="<?php echo e(trans('messages.pickup_date_required')); ?>" name="pickup_date_message"
                    id="pickup_date_message">
                <input type="hidden" value="<?php echo e(trans('messages.pickup_time_required')); ?>" name="pickup_time_message"
                    id="pickup_time_message">
                <input type="hidden" value="<?php echo e(trans('messages.first_name_required')); ?>" name="first_name_message"
                    id="first_name_message">
                <input type="hidden" value="<?php echo e(trans('messages.last_name_required')); ?>" name="last_name_message"
                    id="last_name_message">
                <input type="hidden" value="<?php echo e(trans('messages.email_required')); ?>" name="email_message"
                    id="email_message">
                <input type="hidden" value="<?php echo e(trans('messages.mobile_required')); ?>" name="mobile_message"
                    id="mobile_message">
                <input type="hidden" value="<?php echo e(trans('messages.address_required')); ?>" name="new_address_message"
                    id="new_address_message">
                <input type="hidden" value="<?php echo e(trans('messages.landmark_required')); ?>" name="new_landmark_message"
                    id="new_landmark_message">
                <input type="hidden" value="<?php echo e(trans('messages.pincode_required')); ?>" name="new_pincode_message"
                    id="new_pincode_message">
                <input type="hidden" value="<?php echo e(trans('messages.country_required')); ?>" name="new_country_message"
                    id="new_country_message">
                <input type="hidden" value="<?php echo e(trans('messages.state_required')); ?>" name="new_state_message"
                    id="new_state_message">
                <input type="hidden" value="<?php echo e(trans('messages.city_required')); ?>" name="new_city_message"
                    id="new_city_message">
                <input type="hidden" value="<?php echo e(trans('messages.select_shipping_area')); ?>" name="shipping_area_message"
                    id="shipping_area_message">
                <input type="hidden" value="<?php echo e(trans('messages.payment_selection_required')); ?>"
                    name="payment_type_message" id="payment_type_message">

                <form action="<?php echo e(URL::to('paypal')); ?>" method="post" class="d-none">
                    <?php echo e(csrf_field()); ?>

                    <input type="hidden" name="return" value="2">
                    <input type="submit" class="callpaypal" name="submit">
                </form>
            </div>
        </section>
    <?php else: ?>
        <?php echo $__env->make('web.nodata', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
    <input type="hidden" name="buynow_key" id="buynow_key" value="0">
    <div class="modal fade" id="modalbankdetails" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalbankdetailsLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalbankdetailsLabel"><?php echo e(trans('labels.banktransfer')); ?></h5>
                    <button type="button" class="btn-close bg-white border-0" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form enctype="multipart/form-data" action="<?php echo e(URL::to('createorder')); ?>" method="POST">
                    <div class="modal-body">
                        <?php echo csrf_field(); ?>

                        <input type="hidden" name="payment_type" id="payment_type" class="form-control"
                            value="">
                        <input type="hidden" name="modal_customer_name" id="modal_customer_name" class="form-control"
                            value="">
                        <input type="hidden" name="modal_customer_email" id="modal_customer_email" class="form-control"
                            value="">
                        <input type="hidden" name="modal_customer_mobile" id="modal_customer_mobile"
                            class="form-control" value="">
                        <input type="hidden" name="modal_delivery_date" id="modal_delivery_date" class="form-control"
                            value="">
                        <input type="hidden" name="modal_delivery_time" id="modal_delivery_time" class="form-control"
                            value="">
                        <input type="hidden" name="modal_delivery_area" id="modal_delivery_area" class="form-control"
                            value="">
                        <input type="hidden" name="modal_delivery_charge" id="modal_delivery_charge"
                            class="form-control" value="">
                        <input type="hidden" name="modal_address" id="modal_address" class="form-control"
                            value="">
                        <input type="hidden" name="modal_address_type" id="modal_address_type" class="form-control"
                            value="">

                        <input type="hidden" name="modal_landmark" id="modal_landmark" class="form-control"
                            value="">
                        <input type="hidden" name="modal_pincode" id="modal_pincode" class="form-control"
                            value="">

                        <input type="hidden" name="modal_message" id="modal_message" class="form-control"
                            value="">
                        <input type="hidden" name="modal_subtotal" id="modal_subtotal" class="form-control"
                            value="">
                        <input type="hidden" name="modal_discount_amount" id="modal_discount_amount"
                            class="form-control" value="">
                        <input type="hidden" name="modal_couponcode" id="modal_couponcode" class="form-control"
                            value="">
                        <input type="hidden" name="modal_ordertype" id="modal_ordertype" class="form-control"
                            value="">
                        <input type="hidden" name="modal_vendor_id" id="modal_vendor_id" class="form-control"
                            value="">
                        <input type="hidden" name="modal_grand_total" id="modal_grand_total" class="form-control"
                            value="">
                        <input type="hidden" name="modal_tax" id="modal_tax" class="form-control" value="">
                        <input type="hidden" name="modal_tax_name" id="modal_tax_name" class="form-control"
                            value="">
                        <input type="hidden" name="modal_order_type" id="modal_order_type" class="form-control"
                            value="">

                        <input type="hidden" name="modal_buynow" id="modal_buynow" class="form-control"
                            value="">
                        <p><?php echo e(trans('labels.payment_description')); ?></p>
                        <hr>
                        <p class="payment_description" id="payment_description"></p>
                        <hr>
                        <div class="form-group col-md-12">
                            <label for="screenshot"> <?php echo e(trans('labels.screenshot')); ?> </label>
                            <div class="controls">
                                <input type="file" name="screenshot" id="screenshot"
                                    class="form-control  <?php $__errorArgs = ['screenshot'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <?php $__errorArgs = ['screenshot'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"> <?php echo e($message); ?> </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger"
                            data-bs-dismiss="modal"><?php echo e(trans('labels.close')); ?></button>
                        <button type="submit" class="btn btn-primary"> <?php echo e(trans('labels.save')); ?> </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script src="https://checkout.stripe.com/v2/checkout.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="https://checkout.flutterwave.com/v3.js"></script>
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <script src="<?php echo e(url(env('ASSETSPATHURL') . 'web-assets/js/custom/checkout.js')); ?>"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        var select = "<?php echo e(trans('labels.select')); ?>";
        var dateFormat = "<?php echo e(helper::appdata()->date_format); ?>";
        var placeholderFormat = dateFormat
            .replace(/Y/g, 'yyyy') // Full year
            .replace(/m/g, 'mm') // Month
            .replace(/d/g, 'dd'); // Day

        document.getElementById("delivery_dt").setAttribute("placeholder", placeholderFormat);

        flatpickr(".delivery_pickup_date", {
            dateFormat: dateFormat,
            enableTime: false,
            altInput: true,
            altFormat: dateFormat,
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const pickupRadio = document.getElementById("pickup");
            const deliveryRadio = document.getElementById("delivery");
            const pickupDiv = document.getElementById("pickupdiv");
            const addressDiv = document.getElementById("addressdiv");

            // Function to toggle display
            function togglePickupCard() {
                if (pickupRadio.checked) {
                    pickupDiv.style.display = "block";
                } else {
                    pickupDiv.style.display = "none";
                }
            }
            function toggleAddressCard() {
                if (deliveryRadio.checked) {
                    pickupDiv.style.display = "none";
                }
            }

            // Initial check on page load
            togglePickupCard();
            toggleAddressCard();

            // Listen for changes to the radio button
            pickupRadio.addEventListener("change", togglePickupCard);
            deliveryRadio.addEventListener("change", toggleAddressCard);
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/web/checkout/checkout.blade.php ENDPATH**/ ?>