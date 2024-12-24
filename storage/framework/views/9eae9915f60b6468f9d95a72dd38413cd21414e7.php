
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="row mt-3">
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <form action="<?php echo e(URL::to('/admin/shippingarea/update-' . $shippingareadata->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <input type="hidden" name="id"value="<?php echo e($shippingareadata->id); ?>">
                            <div class="form-group">
                                <label class="form-label"><?php echo e(trans('labels.state')); ?><span class="text-danger"> *
                                        </span></label>
                                <select class="form-control form-select" name="state_id">
                                    <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($state->id); ?>" <?php echo e($state->id == $shippingareadata->state_id ? 'selected' : ''); ?>><?php echo e($state->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Branch</label>
                                <select class="form-control form-select" name="branch_id">
                                    <?php $__currentLoopData = helper::get_branchs(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($branch->id); ?>" <?php echo e($branch->id == $shippingareadata->branch_id ? 'selected' : ''); ?>><?php echo e($branch->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><?php echo e(trans('labels.city')); ?><span class="text-danger"> *
                                        </span></label>
                                <input type="text" class="form-control" name="city" value="<?php echo e($shippingareadata->city); ?>"
                                       placeholder="<?php echo e(trans('labels.city')); ?>" required>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label"><?php echo e(trans('labels.area_name')); ?>

                                        <span class="text-danger"> * </span></label>
                                    <input type="text" class="form-control" name="name"
                                        value="<?php echo e($shippingareadata->name); ?>" placeholder="<?php echo e(trans('labels.area_name')); ?>"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label"><?php echo e(trans('labels.delivery_charge')); ?>

                                        <span class="text-danger"> * </span></label>
                                    <input type="text" class="form-control numbers_only" name="delivery_charge"
                                        value="<?php echo e($shippingareadata->delivery_charge); ?>"
                                        placeholder="<?php echo e(trans('labels.delivery_charge')); ?>" required>
                                </div>
                            </div>
                            <div class="form-group <?php echo e(session()->get('direction') == '2' ? 'text-start' : 'text-end'); ?>">
                                <a href="<?php echo e(URL::to('admin/shippingarea')); ?>"
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

<?php echo $__env->make('admin.theme.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/shippingarea/edit.blade.php ENDPATH**/ ?>