<!-- Footer Start Here -->
<footer>
    <!------------------- Footer Features Start Here ------------------->
    <div class="theme-2-product-service">
        <div class="container">
            <div class="row justify-content-center my-4">
                <?php $__currentLoopData = helper::footer_features(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-xl-3 col-md-6 col-sm-6">
                        <div class="card border-0 bg-transparent">
                            <div class="card-body d-flex gap-3 p-md-3 p-2">
                                <div class="quality-icon col-3">
                                    <?php echo $feature->icon; ?>

                                </div>
                                <div class="quality-content">
                                    <h3 style="color: black"><?php echo e($feature->title); ?></h3>
                                    <p class="m-0 text-muted fs-7" style="color: black"><?php echo e($feature->description); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
    <!------------------- Footer Features End Here ------------------->

    <div class="footer pt-3">
        <div class="container">
            <div class="py-sm-5 py-4 border-bottom-primary">
                <div class="row justify-content-between g-4 footer-area py-4">
                    <div class="col-lg-4 left-side mt-3">
                        <a href="<?php echo e(route('home')); ?>">
                            <img src="<?php echo e(helper::image_path(@helper::appdata()->logo)); ?>" height="55" class="my-3"
                                alt="footer_logo">
                        </a>
                        <h1 style="color: black"><?php echo e(@helper::appdata()->footer_title); ?></h1>
                        <p class="mb-0" style="color: black"><?php echo e(@helper::appdata()->footer_description); ?></p>
                    </div>

                    <div class="col-lg-8 right-side">
                        <div class="row g-3">
                            <div class="col-md-4 col-lg-4 col-xl-4 col-6 mb-4 mb-sm-0">
                                <h4><?php echo e(trans('labels.pages')); ?></h4>
                                <ul>
                                    <li style="color: black !important"><a style="color: black !important" href="<?php echo e(route('about-us')); ?>"
                                            class="text-white"><?php echo e(trans('labels.about')); ?></a>
                                    </li>
                                    <li style="color: black !important"><a style="color: black !important" href="<?php echo e(route('privacy-policy')); ?>"
                                            class="text-white"><?php echo e(trans('labels.privacy_policy')); ?></a></li>
                                    <li style="color: black !important"><a style="color: black !important" href="<?php echo e(route('refund-policy')); ?>"
                                            class="text-white"><?php echo e(trans('labels.refund_policy')); ?></a></li>
                                    <li style="color: black !important"><a style="color: black !important" href="<?php echo e(route('terms-conditions')); ?>"
                                            class="text-white"><?php echo e(trans('labels.terms_condition')); ?></a></li>
                                </ul>
                            </div>
                            <div class="col-md-4 col-lg-4 col-xl-4 col-6 mb-4 mb-sm-0">
                                <h4><?php echo e(trans('labels.other')); ?></h4>
                                <ul>
                                    <li style="color: black !important"><a style="color: black !important" href="<?php echo e(route('categories')); ?>"
                                            class="text-white"><?php echo e(trans('labels.menu')); ?></a>
                                    </li>
                                    <li style="color: black !important"><a style="color: black !important" href="<?php echo e(route('faq')); ?>" class="text-white"><?php echo e(trans('labels.faq')); ?></a>
                                    </li>
                                    <li style="color: black !important"><a style="color: black !important" href="<?php echo e(route('contact-us')); ?>"
                                            class="text-white"><?php echo e(trans('labels.help_contact_us')); ?></a></li>

                                    <?php if(@helper::checkaddons('blog')): ?>
                                        <li style="color: black !important"><a style="color: black !important" href="<?php echo e(route('blogs')); ?>"
                                                class="text-white"><?php echo e(trans('labels.blogs')); ?></a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                            <div class="col-md-4 col-lg-4 col-xl-4 col-12 mb-4 mb-sm-0">
                                <h4><?php echo e(trans('labels.help_contact_us')); ?></h4>
                                <ul class="contact-detail">
                                    <a href="callto:<?php echo e(helper::appdata()->mobile); ?>">
                                        <li class="d-flex align-items-center text-white">
                                            <i  style="color: black !important"
                                                class="fa-light fa-phone <?php echo e(session()->get('direction') == '2' ? 'ms-2' : 'me-2'); ?>"></i>
                                            <p class="mb-0"  style="color: black !important"><?php echo e(helper::appdata()->mobile); ?></p>
                                        </li>
                                    </a>
                                    <a href="mailto:<?php echo e(helper::appdata()->email); ?>">
                                        <li class="d-flex align-items-center text-white">
                                            <i  style="color: black !important"
                                                class="fa-light fa-envelope <?php echo e(session()->get('direction') == '2' ? 'ms-2' : 'me-2'); ?>"></i>
                                            <p class="mb-0"  style="color: black !important"><?php echo e(helper::appdata()->email); ?></p>
                                        </li>
                                    </a>
                                </ul>
                                <div class="col-auto mt-3 d-flex flex-wrap gap-2">
                                    <?php $__currentLoopData = helper::sociallinks(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sociallink): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="footer-box">
                                            <a class="text-white " href="<?php echo e($sociallink->link); ?>" target="_blank">
                                                <?php echo $sociallink->icon; ?> </a>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-black">
        <div class="container">
            <div
                class="d-flex flex-wrap gap-2 align-items-center justify-between justify-content-center text-center py-3">
                <p class="text-white fs-7 mb-0"><?php echo e(helper::appdata()->copyright); ?></p>

            </div>
        </div>
    </div>
</footer>
<!-- Footer End here -->
<?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/web/layout/footer.blade.php ENDPATH**/ ?>