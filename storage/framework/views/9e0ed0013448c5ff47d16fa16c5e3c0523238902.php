<?php $__env->startSection('content'); ?>
    <?php
        if (request()->is('admin/bannersection-1*')) {
            $add_url = URL::to('admin/bannersection-1/add');
            $section = 1;
            $title = trans('labels.section-1');
        } elseif (request()->is('admin/bannersection-2*')) {
            $add_url = URL::to('admin/bannersection-2/add');
            $section = 2;
            $title = trans('labels.section-2');
        } elseif (request()->is('admin/bannersection-3*')) {
            $add_url = URL::to('admin/bannersection-3/add');
            $section = 3;
            $title = trans('labels.section-3');
        } else {
            $add_url = URL::to('admin/bannersection-4/add');
            $section = 4;
            $title = trans('labels.section-4');
        }
    ?>
    <?php echo $__env->make('admin.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="table-responsive" id="table-display">
                            <?php echo $__env->make('admin.banner.bannertable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(url(env('ASSETSPATHURL').'admin-assets/assets/js/custom/banner.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.theme.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/banner/banner.blade.php ENDPATH**/ ?>