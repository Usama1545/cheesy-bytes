<?php $__env->startSection('content'); ?>
    <section class="success">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-12">
                    <div class="success-image">
                        <img src="<?php echo e(url(env('ASSETSPATHURL') . 'web-assets/images/success.gif')); ?>" alt="">
                    </div>
                    <div class="">
                        <h4 class="fw-600 mb-3"><?php echo e(trans('labels.order_placed')); ?></h4>
                        <p><?php echo e(trans('labels.order_success_desc')); ?></p>
                    </div>
                    <div class="row g-3 justify-content-center mt-3">
                        <div class="col-sm-auto col-12"><a href="<?php echo e(URL::to('/')); ?>"
                                class="btn w-100 btn-outline-dark px-4 py-2 text-capitalize"><?php echo e(trans('labels.continue_shopping')); ?></a>
                        </div>
                        <?php if(@helper::checkaddons('whatsapp_message')): ?>
                            <?php if(whatsapp_helper::whatsapp_message_config()->order_created == 1): ?>
                                <?php if(whatsapp_helper::whatsapp_message_config()->message_type == 2): ?>
                                    <div class="col-sm-auto col-12"><a
                                            href="https://api.whatsapp.com/send?phone=<?php echo e(whatsapp_helper::whatsapp_message_config()->whatsapp_number); ?>&text=<?php echo e(@$whmessage); ?>"
                                            target="_blank"
                                            class="btn w-100 btn-success px-4 py-2 text-capitalize"><?php echo e(trans('labels.send_order_on_whatsapp')); ?></a>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                        <div class="col-sm-auto col-12"><a href="<?php echo e(URL::to('/orders-' . $orderdata->order_number)); ?>"
                                class="btn w-100 btn-primary px-4 py-2 text-capitalize"><?php echo e(trans('labels.track_order')); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/web/orders/success.blade.php ENDPATH**/ ?>