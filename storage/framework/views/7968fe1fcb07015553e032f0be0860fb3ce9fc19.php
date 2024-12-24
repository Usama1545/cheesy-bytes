<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="form-validation">
                            <form action="<?php echo e(URL::to('admin/users/update-' . $customersdata->id)); ?>" method="post"
                                enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="name"><?php echo e(trans('labels.name')); ?> <span
                                                    class="text-danger">*</span> </label>
                                            <input type="text" class="form-control" name="name"
                                                value="<?php echo e($customersdata->name); ?>" id="name"
                                                placeholder="<?php echo e(trans('labels.name')); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="mobile"><?php echo e(trans('labels.mobile')); ?> <span
                                                    class="text-danger">*</span> </label>
                                            <input type="tel" class="form-control numbers_only" name="mobile"
                                                value="<?php echo e($customersdata->mobile); ?>" id="mobile"
                                                placeholder="<?php echo e(trans('labels.mobile')); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="email"><?php echo e(trans('labels.email')); ?> <span
                                                    class="text-danger">*</span> </label>
                                            <input type="email" class="form-control" name="email"
                                                value="<?php echo e($customersdata->email); ?>" id="email"
                                                placeholder="<?php echo e(trans('labels.email')); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group <?php echo e(session()->get('direction') == '2' ? 'text-start' : 'text-end'); ?>">
                                    <a href="<?php echo e(URL::to('admin/users')); ?>"
                                        class="btn btn-danger"><?php echo e(trans('labels.cancel')); ?></a>
                                    <button class="btn btn-primary"
                                        <?php if(env('Environment') == 'sendbox'): ?> type="button" onclick="myFunction()" <?php else: ?> type="submit" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.theme.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/users/update.blade.php ENDPATH**/ ?>