<?php $__env->startSection('page_title'); ?>
    | <?php echo e(trans('labels.view_all')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php if(isset($_GET['type']) && $_GET['type'] != ''): ?>
        <div class="breadcrumb-sec">
            <div class="container">
                <div class="breadcrumb-sec-content">
                    <?php
                        $type = $_GET['type'];
                        if ($_GET['type'] == 'topitems') {
                            $title = trans('labels.trending');
                        } elseif ($_GET['type'] == 'todayspecial') {
                            $title = trans('labels.todays_special');
                        } elseif ($_GET['type'] == 'recommended') {
                            $title = trans('labels.recommended');
                        } elseif ($_GET['type'] == 'topdeals') {
                            $title = trans('labels.top_deals');
                        } else {
                            $title = '';
                        }
                    ?>
                    <nav class="text-dark breadcrumb-divider" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li
                                class="breadcrumb-item <?php echo e(session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : ''); ?>">
                                <a class="text-dark fw-600" href="<?php echo e(URL::to('/')); ?>"><?php echo e(trans('labels.home')); ?></a>
                            </li>
                            <li class="breadcrumb-item <?php echo e(session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : ''); ?> active"
                                aria-current="page"> <?php echo e($title); ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

    <?php endif; ?>
    <div class="container mt-2" >
        <?php if($_GET['type'] == 'topdeals'): ?>
            <div class="countdown" id="topdeals">
                <div class="countdown-counter rounded-3 mb-5 p-3" id="countdown"></div>
            </div>
        <?php endif; ?>
        <div class="row mb-5">
            <div class="menu my-0">
                <?php if(count($getsearchitems) > 0): ?>
                    <div class="row g-4">
                        <?php $__currentLoopData = $getsearchitems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $itemdata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo $__env->make('web.home1.itemview', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="mt-5 d-flex justify-content-center">
                        <?php echo e($getsearchitems->appends(request()->query())->links()); ?>

                    </div>
                <?php else: ?>
                    <?php echo $__env->make('web.nodata', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        var topdeals = "<?php echo e(!empty(@$getsearchitems) ? 1 : 0); ?>";
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/web/viewall.blade.php ENDPATH**/ ?>