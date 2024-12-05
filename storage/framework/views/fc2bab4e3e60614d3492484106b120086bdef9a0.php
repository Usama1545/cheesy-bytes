<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <form action="<?php echo e(URL::to('/admin/report')); ?>" class="my-3">
                    <div class="input-group col-md-12 ps-0 justify-content-end">
                        <div class="input-group-append col-auto px-1">
                            <input type="date" class="form-control rounded" name="startdate"
                                <?php if(isset($_GET['startdate'])): ?> value="<?php echo e($_GET['startdate']); ?>" <?php endif; ?>
                                aria-label="<?php echo e(trans('labels.type_and_enter')); ?>" aria-describedby="basic-addon2" required>
                        </div>
                        <div class="input-group-append col-auto px-1">
                            <input type="date" class="form-control rounded" name="enddate"
                                <?php if(isset($_GET['enddate'])): ?> value="<?php echo e($_GET['enddate']); ?>" <?php endif; ?>
                                aria-label="<?php echo e(trans('labels.type_and_enter')); ?>" aria-describedby="basic-addon2" required>
                        </div>
                        <div class="input-group-append">
                            <button class="btn btn-primary rounded" type="submit"><?php echo e(trans('labels.fetch')); ?></button>
                        </div>
                    </div>
                </form>
                <?php echo $__env->make('admin.orders.statistics', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="table-responsive reportstable" id="table-display">
                            <?php echo $__env->make('admin.orders.orderstable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/orders.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.theme.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/orders/report.blade.php ENDPATH**/ ?>