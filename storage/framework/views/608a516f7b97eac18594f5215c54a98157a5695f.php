<!-- For Large Devices -->
<nav class="sidebar sidebar-lg">
    <div class="d-flex justify-content-center align-items-center mb-3 border-bottom border-white">
        <div class="navbar-header-logo pb-2">
            <a href="<?php echo e(URL::to('admin/home')); ?>" class="text-white fs-4">
                <?php if(Auth::user()->type == 1): ?>
                    <?php echo e(trans('labels.admin_title')); ?>

                <?php elseif(Auth::user()->type == 4): ?>
                    <?php echo e(trans('labels.employee')); ?>

                <?php endif; ?>
            </a>
        </div>
    </div>
    <?php echo $__env->make('admin.theme.sidebarcontent', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</nav>
<!-- For Small Devices -->
<nav class="collapse collapse-horizontal sidebar sidebar-md" id="sidebarcollapse">
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom border-white">
        <a href="<?php echo e(URL::to('admin/home')); ?>" class="text-white fs-4">
            <?php if(Auth::user()->type == 1): ?>
                <?php echo e(trans('labels.admin_title')); ?>

            <?php elseif(Auth::user()->type == 4): ?>
                <?php echo e(trans('labels.employee')); ?>

            <?php endif; ?>
        </a>
        <button class="btn text-white" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarcollapse"
            aria-expanded="false" aria-controls="sidebarcollapse"><i class="fa-light fa-xmark"></i></button>
    </div>
    <?php echo $__env->make('admin.theme.sidebarcontent', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</nav>
<?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/theme/sidebar.blade.php ENDPATH**/ ?>