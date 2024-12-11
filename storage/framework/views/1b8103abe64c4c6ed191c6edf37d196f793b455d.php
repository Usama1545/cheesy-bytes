<?php $__env->startSection('page_title'); ?>
    | <?php echo e(trans('labels.categories')); ?>

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
                            class="breadcrumb-item <?php echo e(session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : ''); ?> active">
                            <?php echo e(trans('labels.categories')); ?>

                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row g-3 mb-3 mt-5">
            <?php $__currentLoopData = helper::get_categories(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categorydata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-2-4 col-md-4 col-sm-6 col-12">
                    <div class="category-wrapper mx-2">
                        <a href="<?php echo e(URL::to('/menu/' . $categorydata->slug)); ?>">
                            <img src="<?php echo e(helper::image_path($categorydata->image)); ?>" class="category-image" alt="category">
                        </a>
                        <p class="my-2 text-start"><?php echo e($categorydata->category_name); ?></p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <style>
        .category-wrapper {
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .category-image {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Ensures the image covers the entire space */
        }

        @media (min-width: 992px) {
            .col-lg-2-4 {
                flex: 0 0 20%;  /* Makes the columns take up 20% of the container on large screens */
                max-width: 20%;
            }
        }

    </style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/web/categoryviewall.blade.php ENDPATH**/ ?>