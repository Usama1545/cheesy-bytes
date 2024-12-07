<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-12">
            <div class="card mb-3 border-0 box-shadow">
                <div class="px-4 py-4">
                    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-1 fw-bold">Visit our store to purchase addons</h5>
                            <p class="text-muted fw-medium">Install our addons to unlock premium features</p>
                        </div>
                        <a href="https://infotechgravity.com/category?category=foodefy-single-restaurant" target="_blank" class="btn btn-success">Visit Our Store</a>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
                <h5 class="fs-4 fw-600"><?php echo e(trans('labels.addons_manager')); ?></h5>
                <div class="d-inline-flex">
                    <a href="<?php echo e(URL::to('admin/createsystem-addons')); ?>" class="btn btn-secondary px-4 d-flex">
                        <i class="fa-regular fa-plus mx-1"></i><?php echo e(trans('labels.install_update_addons')); ?></a>
                </div>
            </div>
            <div class="card border-0 mb-3 box-shadow">
                <div class="card-body">
                    <div class="card border-0 box-shadow h-100">
                        <div class="card-body">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-link active" id="installed-tab" data-bs-toggle="tab" href="#installed" role="tab" aria-controls="installed" aria-selected="true"><?php echo e(trans('labels.installed_addons')); ?> (<?php echo e(count($addons)); ?>)</a>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="installed" role="tabpanel" aria-labelledby="installed-tab">
                                    <div class="row">
                                    <?php if(count($addons) > 0): ?>
                                        <?php $__currentLoopData = $addons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-md-6 col-lg-3 mt-3 d-flex">
                                                <div class="card h-100 w-100">
                                                    <img class="img-fluid" src='<?php echo asset('storage/app/public/addons/' . $addon->image); ?>' alt="">
                                                    <div class="card-body">
                                                        
                                                        <h5 class="card-title">
                                                            <?php echo e($addon->name); ?>

                                                        </h5>
                                                    </div>
                                                    <div class="card-footer">
                                                        <p class="card-text d-inline"><small class="text-muted"><?php echo e(date('d M Y', strtotime($addon->created_at))); ?></small></p>
                                                        <?php if($addon->activated == 1): ?>
                                                            <a <?php if(env('Environment') == 'sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="StatusUpdate('<?php echo e($addon->id); ?>','2','<?php echo e(URL::to('admin/systemaddons/update')); ?>')" <?php endif; ?> class="btn btn-sm btn-success <?php echo e(session()->get('direction') == 2 ? 'float-start' : 'float-end'); ?>"><?php echo e(trans('labels.activated')); ?></a>
                                                        <?php else: ?>
                                                            <a <?php if(env('Environment') == 'sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="StatusUpdate('<?php echo e($addon->id); ?>','1','<?php echo e(URL::to('admin/systemaddons/update')); ?>')" <?php endif; ?> class="btn btn-sm btn-danger <?php echo e(session()->get('direction') == 2 ? 'float-start' : 'float-end'); ?>"><?php echo e(trans('labels.deactivated')); ?></a>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Col -->
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <div class="col col-md-12 text-center text-muted mt-4">
                                            <h4><?php echo e(trans('labels.no_addon_installed')); ?></h4>
                                            <a href="https://infotechgravity.com/category?category=foodefy-single-restaurant" target="_blank" class="btn btn-success mt-4">Visit Our Store</a>
                                        </div>
                                    <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/systemaddons.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.theme.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/systemaddons/system-addons.blade.php ENDPATH**/ ?>