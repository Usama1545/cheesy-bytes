<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="form-validation">
                            <form action="<?php echo e(URL::to('admin/sub-category/update-' . $subcatdata->id)); ?>" method="post"
                                enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.subcategory')); ?>

                                            <span class="text-danger">*</span> </label>
                                        <input type="text" class="form-control" name="name"
                                            placeholder="<?php echo e(trans('labels.subcategory')); ?>"
                                            value="<?php echo e($subcatdata->subcategory_name); ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.category')); ?>

                                            <span class="text-danger">*</span> </label>
                                        <select class="form-select" name="category" required>
                                            <option value="" selected><?php echo e(trans('labels.select')); ?></option>
                                            <?php $__currentLoopData = $getcategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($category->id); ?>"
                                                    <?php echo e($subcatdata->cat_id == $category->id ? 'selected' : ''); ?>>
                                                    <?php echo e($category->category_name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group <?php echo e(session()->get('direction') == '2' ? 'text-start' : 'text-end'); ?>">
                                    <a href="<?php echo e(URL::to('admin/sub-category')); ?>"
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

<?php echo $__env->make('admin.theme.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/subcategory/edit.blade.php ENDPATH**/ ?>