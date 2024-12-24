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
                            <form action="<?php echo e(URL::to('admin/category/update-' . $catdata->id)); ?>" method="post"
                                  enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.category')); ?>

                                            <span class="text-danger">*</span> </label>
                                        <input type="text" class="form-control" name="category_name"
                                               placeholder="<?php echo e(trans('labels.category')); ?>"
                                               value="<?php echo e($catdata->category_name); ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label" for="">Branch
                                            <span class="text-danger">*</span> </label>
                                            <?php $selected = explode(',', $catdata->branch_ids); ?>
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
                                    <div class="col-md-6">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.image')); ?>

                                            <span class="text-danger">*</span> </label>
                                        <input type="file" class="form-control" name="image" id="image"
                                               accept="image/*">
                                        <img src="<?php echo e(helper::image_path($catdata->image)); ?>" alt=""
                                             class="img-fluid rounded h-50px mt-1">
                                    </div>
                                </div>
                                <div
                                    class="form-group <?php echo e(session()->get('direction') == '2' ? 'text-start' : 'text-end'); ?>">
                                    <a href="<?php echo e(URL::to('admin/category')); ?>"
                                       class="btn btn-danger"><?php echo e(trans('labels.cancel')); ?></a>
                                    <button class="btn btn-primary"
                                            <?php if(env('Environment') == 'sendbox'): ?> type="button" onclick="myFunction()"
                                            <?php else: ?> type="submit" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
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

<?php echo $__env->make('admin.theme.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/category/edit.blade.php ENDPATH**/ ?>