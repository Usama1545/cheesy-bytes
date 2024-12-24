<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="form-validation">
                            <form action="<?php echo e(URL::to('admin/store-review/update-' . $getstorereviewdata->id)); ?>"
                                method="post" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label class="col-form-label" for="name"><?php echo e(trans('labels.full_name')); ?>

                                                <span class="text-danger">*</span> </label>
                                            <input type="text" class="form-control" name="name" id="name"
                                                placeholder="<?php echo e(trans('labels.name')); ?>"
                                                value="<?php echo e($getstorereviewdata->name); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="ratting"><?php echo e(trans('labels.rating')); ?>

                                                <span class="text-danger">*</span> </label>
                                            <select id="ratting" name="ratting" class="form-select" aria-label=""
                                                required>
                                                <option value="" hidden><?php echo e(trans('labels.select')); ?></option>
                                                <option value="1"
                                                    <?php echo e($getstorereviewdata->ratting == '1' ? 'selected' : ''); ?>>
                                                    1</option>
                                                <option value="2"
                                                    <?php echo e($getstorereviewdata->ratting == '2' ? 'selected' : ''); ?>>2</option>
                                                <option value="3"
                                                    <?php echo e($getstorereviewdata->ratting == '3' ? 'selected' : ''); ?>>
                                                    3</option>
                                                <option value="4"
                                                    <?php echo e($getstorereviewdata->ratting == '4' ? 'selected' : ''); ?>>
                                                    4</option>
                                                <option value="5"
                                                    <?php echo e($getstorereviewdata->ratting == '5' ? 'selected' : ''); ?>>
                                                    5</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="image"><?php echo e(trans('labels.image')); ?>

                                                <span class="text-danger">*</span> </label>
                                            <input type="file" class="form-control" name="image" id="image">
                                            <img src="<?php echo e(helper::image_path($getstorereviewdata->image)); ?>" alt=""
                                                class="img-fluid rounded h-50px mt-1">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="comment"><?php echo e(trans('labels.description')); ?>

                                                <span class="text-danger">*</span> </label>
                                            <textarea class="form-control" name="comment" id="comment" rows="2" required
                                                placeholder="<?php echo e(trans('labels.description')); ?>"><?php echo e($getstorereviewdata->comment); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group <?php echo e(session()->get('direction') == '2' ? 'text-start' : 'text-end'); ?>">
                                    <a href="<?php echo e(URL::to('admin/store-review')); ?>"
                                        class="btn btn-danger"><?php echo e(trans('labels.cancel')); ?></a>
                                    <button class="btn btn-primary"
                                        <?php if(env('Environment') == 'sendbox'): ?> type="button"
                                    onclick="myFunction()" <?php else: ?> type="submit" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.theme.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/store_review/edit.blade.php ENDPATH**/ ?>