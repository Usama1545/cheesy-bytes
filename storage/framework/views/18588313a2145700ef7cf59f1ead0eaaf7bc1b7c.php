<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet"
          href="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/css/bootstrap/bootstrap-select.v1.14.0-beta2.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card border-0">
                    <div class="card-body">
                        <div id="privacy-policy-three" class="privacy-policy">
                            <form method="post" action="<?php echo e(URL::to('admin/dipping/update')); ?>" name="about" id="about"
                                  enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" class="form-control" id="id" name="id"
                                       value="<?php echo e($getitem->id); ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cat_id" class="col-form-label">Name
                                                <span class="text-danger">*</span> </label>
                                            <input name="name" required class="form-control"
                                                   value="<?php echo e($getitem->name); ?>" placeholder="name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subcat_id"
                                                   class="col-form-label"><?php echo e(trans('labels.price')); ?><span
                                                    class="text-danger">*</span></label>
                                            <input name="price" type="number" class="form-control" required
                                                   value="<?php echo e($getitem->price); ?>" placeholder="price">


                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.image')); ?>

                                            <span class="text-danger">*</span> </label>
                                        <input type="file" class="form-control" name="image" id="image"
                                               accept="image/*">
                                        <img src="<?php echo e(helper::image_path($getitem->image)); ?>" alt=""
                                             class="img-fluid rounded h-50px mt-1">
                                    </div>
                                    <div class="form-group col-12 col-lg-6 col-md-6">
                                        <label for="branch_id" class="col-form-label">Branch <span class="text-danger">*</span></label>
                                        <select name="branch_id" class="form-control selectpicker" multiple
                                                data-live-search="true">
                                            <?php $__currentLoopData = helper::get_branchs(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($branch->id); ?>"
                                                <?php echo e($getitem->branch_id == $branch->id ? 'selected' : ''); ?>

                                                ><?php echo e($branch->name . '-' . $branch->city); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>

                                <div
                                    class="form-group <?php echo e(session()->get('direction') == '2' ? 'text-start' : 'text-end'); ?>">
                                    <a href="<?php echo e(URL::to('admin/dipping')); ?>"
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.12.1/ckeditor.js"></script>
    <script type="text/javascript">
        CKEDITOR.replace('allergens');
    </script>
    <script
        src="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/js/bootstrap/bootstrap-select.v1.14.0-beta2.min.js')); ?>">
    </script>
    <script src="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/additem.js')); ?>"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.theme.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/dipping/edititem.blade.php ENDPATH**/ ?>