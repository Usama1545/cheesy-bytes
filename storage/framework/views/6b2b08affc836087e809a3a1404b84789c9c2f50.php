<?php $__env->startSection('content'); ?>
    <div class="row page-titles mx-0 mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item active fs-5 fw-500"><a href="javascript:void(0)">
                        <?php echo e(trans('labels.addons_manager')); ?> </a>
                </li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="alert alert-danger">
                                <?php echo e($error); ?>

                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <div id="privacy-policy-three" class="privacy-policy">
                            <form method="post" action="<?php echo e(URL::to('admin/systemaddons/store')); ?>" name="about"
                                id="about" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="col-sm-3 col-md-12">
                                        <div class="form-group">
                                            <label for="addon_zip" class="col-form-label"> <?php echo e(trans('labels.zip_file')); ?>

                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="file" class="form-control" name="addon_zip" id="addon_zip"
                                                required="">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group float-end">
                                            <a href="<?php echo e(URL::to('admin/systemaddons')); ?>" class="btn btn-outline-danger">
                                                <?php echo e(trans('labels.cancel')); ?> </a>
                                            <button class="btn btn-primary"
                                                <?php if(env('Environment') == 'sendbox'): ?> type="button" onclick="myFunction()" <?php else: ?> type="submit" <?php endif; ?>>
                                                <?php echo e(trans('labels.save')); ?> </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.theme.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/systemaddons/createsystem-addons.blade.php ENDPATH**/ ?>