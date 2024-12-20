<div class="row g-3 justify-content-between">
    <?php
        $i = 0;
    ?>
    <?php $__currentLoopData = $getpaymentmethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $pmdata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            // Check if the current $pmdata is a system addon and activated
            if ($pmdata->payment_type == '1' || $pmdata->payment_type == '2' || $pmdata->payment_type == '4') {
                $systemAddonActivated = true;
            } else {
                $systemAddonActivated = false;
            }
            $addon = App\Models\SystemAddons::where('unique_identifier', $pmdata->unique_identifier)->first();
            if ($addon != null && $addon->activated == 1) {
                $systemAddonActivated = true;
            }
            $transaction_type = $pmdata->payment_type;
        ?>
        <?php if($systemAddonActivated): ?>
            <label class="form-check-label col-md-6" for="payment<?php echo e($transaction_type); ?>">
                <input class="form-check-input" type="radio" name="transaction_type" id="payment<?php echo e($transaction_type); ?>"
                    data-payment-type="<?php echo e($transaction_type); ?>" value="<?php echo e($transaction_type); ?>"
                    data-currency="<?php echo e($pmdata->currency); ?>" <?php echo e($i++ == 0 ? 'checked' : ''); ?>>
                <div class="payment-gateway mb-0 justify-content-between">
                    <span> <img src="<?php echo e(helper::image_path($pmdata->image)); ?>" class="<?php echo e(session()->get('direction') == '2' ? 'ms-2' : 'me-2'); ?>" alt="">
                        <?php echo e(ucfirst($pmdata->payment_name)); ?>

                    </span>
                    <div class="d-flex gap-2">
                        <?php if($transaction_type == 2): ?>
                            <span class="text-end text-muted"><?php echo e(helper::currency_format(Auth::user()->wallet)); ?></span>
                        <?php endif; ?>

                        <span class="check-icon"></span>
                    </div>
                </div>
            </label>
        <?php endif; ?>
        <?php if(in_array($transaction_type, [3, 4, 5, 6])): ?>
            <?php if($transaction_type == 3): ?>
                <input type="hidden" name="razorpaykey" id="razorpaykey" value="<?php echo e($pmdata->public_key); ?>">
            <?php endif; ?>
            <?php if($transaction_type == 4): ?>
                <input type="hidden" name="stripekey" id="stripekey" value="<?php echo e($pmdata->public_key); ?>">
            <?php endif; ?>
            <?php if($transaction_type == 5): ?>
                <input type="hidden" name="flutterwavekey" id="flutterwavekey" value="<?php echo e($pmdata->public_key); ?>">
            <?php endif; ?>
            <?php if($transaction_type == 6): ?>
                <input type="hidden" name="paystackkey" id="paystackkey" value="<?php echo e($pmdata->public_key); ?>">
            <?php endif; ?>
        <?php endif; ?>
        <?php if($transaction_type == 4): ?>
            <form action="" method="" id="payment-form" class="d-none">
                <div class="my-3" id="card-element"></div>
            </form>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php if(!in_array(4, array_column($getpaymentmethods->toArray(), 'id'))): ?>
        <input type="hidden" name="stripekey" id="stripekey" value="">
    <?php endif; ?>
</div>
<?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/web/paymentmethodsview.blade.php ENDPATH**/ ?>