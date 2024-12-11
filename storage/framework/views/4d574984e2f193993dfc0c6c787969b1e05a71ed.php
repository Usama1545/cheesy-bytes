<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="form-validation">
                            <form action="<?php echo e(URL::to('admin/addongroup/store')); ?>" method="post">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-form-label" for=""><?php echo e(trans('labels.name')); ?>

                                                <span class="text-danger">*</span> </label>
                                            <input type="text" class="form-control" name="name" id="addons_name"
                                                placeholder="<?php echo e(trans('labels.name')); ?>" value="<?php echo e(old('name')); ?>"
                                                required>
                                        </div>
                                    </div>
                                    <!-- select_type -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label"
                                                for=""><?php echo e(trans('labels.selection_type')); ?>

                                                <span class="text-danger">*</span> </label>
                                            <div class="d-flex">
                                                <div class="form-check-inline">
                                                    <input class="form-check-input" type="radio" name="selection_type"
                                                        value="1" id="required" checked required>
                                                    <label class="form-check-label"
                                                        for="required"><?php echo e(trans('labels.required')); ?></label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <input class="form-check-input" type="radio" name="selection_type"
                                                        value="2" id="optional" required>
                                                    <label class="form-check-label text-nowrap"
                                                        for="optional"><?php echo e(trans('labels.optional')); ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- select_count -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label"
                                                for=""><?php echo e(trans('labels.selection_count')); ?>

                                                <span class="text-danger">*</span> </label>
                                            <div class="d-flex">
                                                <div class="form-check-inline">
                                                    <input class="form-check-input get_count" type="radio"
                                                        name="selection_count" value="1" id="single" checked
                                                        required>
                                                    <label class="form-check-label"
                                                        for="single"><?php echo e(trans('labels.single')); ?></label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <input class="form-check-input get_count" type="radio"
                                                        name="selection_count" value="2" id="multiple"
                                                        <?php echo e(old('selection_count') == 2 ? 'checked' : ''); ?> required>
                                                    <label class="form-check-label text-nowrap"
                                                        for="multiple"><?php echo e(trans('labels.multiple')); ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group count_row">
                                            <label class="col-form-label"
                                                for="min_count"><?php echo e(trans('labels.minimum_count')); ?>

                                                <span class="text-danger">*</span> </label>
                                            <input type="text" class="form-control numbers_only count_input"
                                                name="min_count" id="min_count"
                                                placeholder="<?php echo e(trans('labels.minimum_count')); ?>"
                                                value="<?php echo e(old('min_count')); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group count_row">
                                            <label class="col-form-label"
                                                for="max_count"><?php echo e(trans('labels.maximum_count')); ?>

                                                <span class="text-danger">*</span> </label>
                                            <input type="text" class="form-control numbers_only count_input"
                                                name="max_count" id="max_count"
                                                placeholder="<?php echo e(trans('labels.maximum_count')); ?>"
                                                value="<?php echo e(old('max_count')); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group <?php echo e(session()->get('direction') == '2' ? 'text-start' : 'text-end'); ?>">
                                    <a href="<?php echo e(URL::to('admin/addongroup')); ?>"
                                        class="btn btn-danger"><?php echo e(trans('labels.cancel')); ?></a>
                                    <button class="btn btn-primary"
                                        <?php if(env('Environment') == 'sendbox'): ?> type="button" onclick="myFunction()" <?php elseif(Auth::user()->type == 5): ?>  type="submit" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/addons.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.theme.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/addons-group/add.blade.php ENDPATH**/ ?>