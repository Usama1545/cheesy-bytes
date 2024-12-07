<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="container-fluid">
        <div class="row g-4 my-3">
            <div class="col-xl-3 col-md-4 col-sm-4 col-12 d-flex">
                <div class="card border-0 w-100 h-100">
                    <div class="card-body">
                        <div class="text-center">
                            <img src='<?php echo e(helper::image_path($getusers->profile_image)); ?>'
                                class="rounded-circle user-profile-image" alt="">
                            <h5 class="mt-3 mb-1 fs-6 fw-500"><?php echo e($getusers->name); ?></h5>
                            <p class="m-0 fs-7"><?php echo e($getusers->email); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-4 col-12 d-flex">
                <div class="card border-0 w-100 h-100">
                    <div class="card-body d-flex justify-content-center align-items-center">
                        <div class="text-center">
                            <span class="card-icon mx-auto">
                                <i class="fa-solid fa-cart-shopping fs-5"></i>
                            </span>
                            <h5 class="mt-3 mb-1 fs-6 fw-500"><?php echo e(count($getorders)); ?></h5>
                            <p class="m-0 fs-7"><?php echo e(trans('labels.orders')); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-4 col-12 d-flex">
                <div class="card border-0 w-100 h-100">
                    <div class="card-body d-flex justify-content-center align-items-center">
                        <div class="text-center">
                            <span class="card-icon mx-auto">
                                <i class="fa-solid fa-share-from-square fs-5"></i>
                            </span>
                            <h5 class="mt-3 mb-1 fs-6 fw-500">
                                <?php echo e($getusers->referral_code == '' ? '-' : $getusers->referral_code); ?>

                            </h5>
                            <p class="m-0 fs-7"><?php echo e(trans('labels.referral_code')); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-sm-6 col-12">
                <div class="card border-0 w-100 h-100">
                    <div class="card-body">
                        <div>
                            <h5 class="card-title fw-500 text-dark text-left border-bottom pb-3 mb-3">
                                <?php echo e(trans('labels.wallet')); ?></h5>
                            <div class="d-flex">
                                <div class="w-100 text-left w-50">
                                    <p class="text-muted mb-0"><?php echo e(trans('labels.wallet_balance')); ?></p>
                                    <h4 class="media-heading fw-400 my_wallet">
                                        <?php echo e(helper::currency_format(@$getusers->wallet)); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card border-0 w-100 h-100">
                    <div class="card-body">
                        <h5 class="card-title fw-500 text-dark text-left border-bottom pb-3 mb-3">
                            <?php echo e(trans('labels.manage_wallet')); ?></h5>
                        <input type="hidden" name="id" id="id" value="<?php echo e(@$getusers->id); ?>">
                        <input type="hidden" name="price_message" id="price_message"
                            value="<?php echo e(trans('messages.amount_required')); ?>">
                        <input type="text" class="form-control mt-2 mb-2 numbers_only" name="money"
                            placeholder="<?php echo e(trans('labels.amount')); ?>" id="price">
                        <div class="row g-2">
                            <div class="col-xxl-6 col-xl-12 col-md-6">
                                <button class="btn btn-sm btn-success add w-100" data-type="add"
                                    data-url="<?php echo e(URL::to('admin/users/change-wallet')); ?>"> <i class="fa fa-arrow-up"></i>
                                    <small><?php echo e(trans('labels.add_money')); ?></small></button>
                            </div>
                            <div class="col-xxl-6 col-xl-12 col-md-6">
                                <button class="btn btn-sm btn-warning deduct w-100" data-type="deduct"
                                    data-url="<?php echo e(URL::to('admin/users/change-wallet')); ?>"> <i class="fa fa-arrow-down"></i>
                                    <small><?php echo e(trans('labels.deduct_money')); ?></small></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <h4 class="card-title"><?php echo e(trans('labels.orders')); ?></h4>
                        <div class="table-responsive" id="table-display">
                            <?php echo $__env->make('admin.orders.orderstable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-3">
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <h4 class="card-title"><?php echo e(trans('labels.transactions')); ?></h4>
                        <div class="table-responsive" id="table-display">
                            <?php echo $__env->make('admin.users.transactiontable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/orders.js')); ?>"></script>
    <script src="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/users.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.theme.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/users/user-details.blade.php ENDPATH**/ ?>