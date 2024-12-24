
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="row mt-3">
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <form action="<?php echo e(URL::to('/admin/branches/update-' . $branch->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <input type="hidden" name="id" value="<?php echo e($branch->id); ?>">
                            <div class="form-group col-md-6">
                                <label class="form-label"><?php echo e(trans('labels.name')); ?><span class="text-danger"> *
                                        </span></label>
                                <input type="text" class="form-control" name="name" value="<?php echo e($branch->name); ?>"
                                       placeholder="<?php echo e(trans('labels.name')); ?>" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">State<span
                                        class="text-danger"> * </span></label>
                                <input type="text" class="form-control" name="state"
                                       value="<?php echo e($branch->state->name); ?>"
                                       placeholder="state" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">city<span
                                        class="text-danger"> * </span></label>
                                <input type="text" class="form-control " name="city"
                                       value="<?php echo e($branch->city); ?>"
                                       placeholder="city" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">Zip<span
                                        class="text-danger"> * </span></label>
                                <input type="text" class="form-control numbers_only" name="zip"
                                       value="<?php echo e($branch->zip); ?>"
                                       placeholder="zip" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Address<span
                                        class="text-danger"> * </span></label>
                                <input type="text" class="form-control " name="address"
                                       value="<?php echo e($branch->address); ?>"
                                       placeholder="address" required>
                            </div>
                            <div
                                class="form-group <?php echo e(session()->get('direction') == '2' ? 'text-start' : 'text-end'); ?>">
                                <a href="<?php echo e(URL::to('admin/branches')); ?>"
                                   class="btn btn-danger"><?php echo e(trans('labels.cancel')); ?></a>
                                <button class="btn btn-primary "
                                    <?php if(env('Environment') == 'sendbox'): ?> type="button" onclick="myFunction()" <?php else: ?> type="submit" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.theme.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/branches/edit.blade.php ENDPATH**/ ?>