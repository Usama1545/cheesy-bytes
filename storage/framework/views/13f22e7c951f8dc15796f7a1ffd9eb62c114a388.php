<?php $__env->startSection('page_title'); ?>
    | <?php echo e(trans('labels.blogs')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="breadcrumb-sec">
        <div class="container">
            <div class="breadcrumb-sec-content">
                <nav class="text-dark breadcrumb-divider" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li
                            class="breadcrumb-item <?php echo e(session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : ''); ?>">
                            <a class="text-dark fw-600" href="<?php echo e(URL::to('/')); ?>"><?php echo e(trans('labels.home')); ?></a>
                        </li>
                        <li
                            class="breadcrumb-item <?php echo e(session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : ''); ?>">
                            <a class="text-muted" href="javascript:void(0)"><?php echo e(trans('labels.blogs')); ?></a>
                        </li>
                        <li
                            class="breadcrumb-item <?php echo e(session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : ''); ?> active">
                            <?php echo e($getblogdata->title); ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section>
        <div class="container">
            <div class="col-12 d-flex my-5">
                <div class="blog-details">
                    <div class="card">
                        <img src="<?php echo e(helper::image_path($getblogdata->image)); ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <div class="row justify-content-between">
                                <div class="col-auto blog-date mb-3">
                                    <span><?php echo e(helper::date_format($getblogdata->created_at)); ?></span>
                                </div>
                            </div>
                            <h3 class="card-title fw-600 dark_color mb-3"><?php echo e($getblogdata->title); ?></h3>
                            <p class="card-text"><?php echo e($getblogdata->description); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php if(count($recentblogs) > 0): ?>
        <section>
            <div class="blog-wrapper">
                <div class="container">
                    <div class="row align-items-center justify-content-between my-2 px-2">
                        <div class="col-auto blog-heading">
                            <h2 class="fs-1 fw-bold"><?php echo e(trans('labels.recent_blogs')); ?></h2>
                        </div>
                    </div>
                    <div class="row g-3">
                        <?php $__currentLoopData = $recentblogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bloglist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo $__env->make('web.blogs.blogview', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </section>
        <?php echo $__env->make('web.subscribeform', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/web/blogs/blogdetails.blade.php ENDPATH**/ ?>