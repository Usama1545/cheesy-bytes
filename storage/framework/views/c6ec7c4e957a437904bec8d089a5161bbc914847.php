<?php $__env->startSection('page_title'); ?>
    | <?php echo e(trans('labels.refer_earn')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <link rel="stylesheet" href="<?php echo e(url(env('ASSETSPATHURL') . 'web-assets/social-sharing/css/socialsharing.css')); ?>">
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
                            aria-current="page"><?php echo e(trans('labels.refer_earn')); ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section>
        <div class="container my-5">
            <div class="row">
                <div class="col-lg-3">
                    <?php echo $__env->make('web.layout.usersidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="col-lg-9">
                    <div class="user-content-wrapper">
                        <p class="title border-bottom pb-3"><?php echo e(trans('labels.refer_earn')); ?></p>
                        <div class="d-flex flex-column align-items-center">
                            <div class="col-sm-4 col-9">
                                <img class="mb-4 w-100 h-100"
                                    src="<?php echo e(helper::image_path(helper::appdata()->refer_earn_bg_image)); ?>">
                            </div>
                            <h5 class="text-uppercase"><?php echo e(trans('labels.refer_earn')); ?></h5>
                            <p class="fs-7 text-center text-muted"><?php echo e(trans('labels.refer_note_1')); ?>

                                <?php echo e(helper::currency_format(@helper::appdata()->referral_amount)); ?>

                                <?php echo e(trans('labels.refer_note_2')); ?></p>
                                <div class="col-sm-8">
                                    <input type="url" class="form-control mb-3 bg-gray" id="data"
                                        value="<?php echo e(URL::to('/register?referral=' . Auth::user()->referral_code)); ?>" readonly>
                                </div>
                        </div>
                        <div class="sharing-section d-flex align-items-center justify-content-center"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(url(env('ASSETSPATHURL') . 'web-assets/social-sharing/js/socialsharing.js')); ?>"></script>
    <script src="<?php echo e(url(env('ASSETSPATHURL') . 'web-assets/js/custom/referearn.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/web/referearn/referearn.blade.php ENDPATH**/ ?>