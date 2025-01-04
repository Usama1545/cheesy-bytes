<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet"
          href="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/css/bootstrap/bootstrap-select.v1.14.0-beta2.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="form-validation">
                            <form action="<?php echo e(URL::to('admin/addons/update-' . $addonsdata->id)); ?>" method="post">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label"
                                                for=""><?php echo e(trans('labels.select_addongroup')); ?>

                                                <span class="text-danger">*</span> </label>
                                            <select class="form-select" name="addongroup_id" required>
                                                <option value="" disabled><?php echo e(trans('labels.select')); ?></option>
                                                <?php $__currentLoopData = $getaddongroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addongroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($addongroup->id); ?>"
                                                        <?php if($addonsdata->addongroup_id == $addongroup->id): ?> selected <?php endif; ?>>
                                                        <?php echo e($addongroup->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="getaddons_id"
                                                   class="col-form-label">Branch <span class="text-danger">*</span> </label>
                                            <?php $selected = explode(',', $addonsdata->branch_ids); ?>
                                            <select name="branch_ids[]" class="form-control selectpicker" multiple required
                                                    data-live-search="true" id="getaddons_id">
                                                <?php $__currentLoopData = helper::get_branchs(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($branch->id); ?>"
                                                        <?php echo e(in_array($branch->id, $selected) ? 'selected' : ''); ?>>
                                                        <?php echo e($branch->name.'-'.$branch->city); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-form-label"
                                                for="addons_name"><?php echo e(trans('labels.addons_name')); ?> <span
                                                    class="text-danger">*</span> </label>
                                            <input type="text" class="form-control" name="name" id="addons_name"
                                                placeholder="<?php echo e(trans('labels.addons_name')); ?>"
                                                value="<?php echo e($addonsdata->name); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label"><?php echo e(trans('labels.type')); ?> <span
                                                    class="text-danger">*</span> </label>
                                            <div class="d-flex">
                                                <div class="form-check-inline">
                                                    <input type="radio" name="type" value="1"
                                                        class="form-check-input get_price" id="free" required
                                                        <?php echo e($addonsdata->price <= 0 ? 'checked' : ''); ?>>
                                                    <label class="form-check-label"
                                                        for="free"><?php echo e(trans('labels.free')); ?></label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <input type="radio" name="type" value="2" id="paid"
                                                        class="form-check-input get_price" required
                                                        <?php echo e($addonsdata->price > 0 ? 'checked' : ''); ?>>
                                                    <label class="form-check-label"
                                                        for="paid"><?php echo e(trans('labels.paid')); ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group <?php if($addonsdata->price <= 0): ?> dn <?php endif; ?>" id="price_row">
                                            <label class="col-form-label" for=""><?php echo e(trans('labels.price')); ?> <span
                                                    class="text-danger">*</span> </label>
                                            <input type="text" class="form-control" name="price" id="price"
                                                placeholder="<?php echo e(trans('labels.price')); ?>" value="<?php echo e($addonsdata->price); ?>"
                                                required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group <?php echo e(session()->get('direction') == '2' ? 'text-start' : 'text-end'); ?>">
                                    <a href="<?php echo e(URL::to(url()->previous())); ?>"
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
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/addons.js')); ?>"></script>

    <script>
        var placehodername = "<?php echo e(trans('labels.name')); ?>";
        var placeholderprice = "<?php echo e(trans('labels.price')); ?>";
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.12.1/ckeditor.js"></script>
    <script type="text/javascript">
        CKEDITOR.replace('allergens');
    </script>
    <script
        src="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/js/bootstrap/bootstrap-select.v1.14.0-beta2.min.js')); ?>">
    </script>
    <script src="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/additem.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.theme.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/addons/edit.blade.php ENDPATH**/ ?>
