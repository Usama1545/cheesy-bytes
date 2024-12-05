<?php $__env->startSection('page_title'); ?>
    | <?php echo e(trans('labels.faq')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="breadcrumb-sec">
        <div class="container">
            <div class="breadcrumb-sec-content">
                <nav class="text-dark breadcrumb-divider" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li
                            class="breadcrumb-item <?php echo e(session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : ''); ?>">
                            <a class="text-dark fw-600" href="<?php echo e(route('home')); ?>"><?php echo e(trans('labels.home')); ?></a>
                        </li>
                        <li class="breadcrumb-item <?php echo e(session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : ''); ?> active"
                            aria-current="page"><?php echo e(trans('labels.faq')); ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section>
        <div class="container my-5">
            <?php if(count($getfaqs) > 0): ?>
                <div class="faqs">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="accordion" id="accordionfaq">
                                <?php $__currentLoopData = $getfaqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $faqdata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="faq<?php echo e($key); ?>">
                                            <button
                                                class="accordion-button <?php echo e($key == 0 ? '' : 'collapsed'); ?> <?php echo e(session()->get('direction') == '2' ? 'rtl' : ''); ?> "
                                                type="button" data-bs-toggle="collapse"
                                                data-bs-target="#faqs<?php echo e($key); ?>" aria-expanded="true"
                                                aria-controls="faqs<?php echo e($key); ?>">
                                                <?php echo e($faqdata->title); ?>

                                            </button>
                                        </h2>
                                        <div id="faqs<?php echo e($key); ?>"
                                            class="accordion-collapse collapse <?php echo e($key == 0 ? 'show' : ''); ?>"
                                            aria-labelledby="faq<?php echo e($key); ?>" data-bs-parent="#accordionfaq">
                                            <div class="accordion-body">
                                                <?php echo e($faqdata->description); ?>

                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12 d-md-block d-none">
                            <img src="<?php echo e(helper::image_path(@helper::appdata()->faqs_image)); ?>"
                                class="w-100 object-fit-cover rounded-4" alt="">
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <?php echo $__env->make('web.nodata', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
        </div>
    </section>
    <?php echo $__env->make('web.subscribeform', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/web/faq.blade.php ENDPATH**/ ?>