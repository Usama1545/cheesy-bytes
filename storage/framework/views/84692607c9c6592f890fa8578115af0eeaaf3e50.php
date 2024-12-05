<?php $__env->startSection('page_title'); ?>
    | <?php echo e(trans('labels.home')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <!-- Slider Area Start Here -->
    <?php if(count($sliders) > 0): ?>
        <section class="slider-area">
            <div id="slidercarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $sliderdata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="carousel-item <?php echo e($key == 0 ? 'active' : ''); ?>">
                            <img src="<?php echo e(helper::image_path($sliderdata->image)); ?>" class="d-block img-fluid"
                                 alt="slider">
                            <div
                                class="carousel-caption d-flex h-100 align-items-center justify-content-center flex-column">
                                <h5 class="animate__animated animate__fadeInUp"><?php echo e($sliderdata->title); ?></h5>
                                <p class="animate__animated animate__fadeInUp"><?php echo e($sliderdata->description); ?></p>
                                <?php if($sliderdata['item_info'] != ''): ?>
                                    <a href="<?php echo e(URL::to('/item-' . $sliderdata['item_info']->slug)); ?>"
                                       class="btn btn-primary fw-500 px-4 py-2 animate__animated animate__fadeInUp"><?php echo e(trans('labels.explore')); ?>

                                        <i class="fa-solid fa-circle-arrow-right"></i> </a>
                                <?php endif; ?>
                                <?php if($sliderdata['category_info'] != ''): ?>
                                    <a href="<?php echo e(URL::to('/menu/?category=' . $sliderdata['category_info']->slug)); ?>"
                                       class="btn btn-primary fw-500 px-4 py-2 animate__animated animate__fadeInUp"><?php echo e(trans('labels.explore')); ?>

                                        <i class="fa-solid fa-circle-arrow-right"></i> </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <button class="carousel-control-prev <?php echo e(count($sliders) == 1 ? 'd-none' : ''); ?>" type="button"
                        data-bs-target="#slidercarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next <?php echo e(count($sliders) == 1 ? 'd-none' : ''); ?>" type="button"
                        data-bs-target="#slidercarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>
        </section>
    <?php endif; ?>
    <!-- Slider Area End Here -->

    <!-- Promotional topbanners Start Here -->
    <?php if(count($banners['topbanners']) > 0): ?>
        <section class="theme-1-banner1 sec-padding">
            <div class="container">
                <div class="slider-small owl-carousel owl-theme">
                    <?php $__currentLoopData = $banners['topbanners']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $bannerdata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="item">
                            <?php if($bannerdata['item_info'] != ''): ?>
                                <a href="<?php echo e(URL::to('/item-' . $bannerdata['item_info']->slug)); ?>">
                                    <?php elseif($bannerdata['category_info'] != ''): ?>
                                        <a href="<?php echo e(URL::to('/menu/?category=' . $bannerdata['category_info']->slug)); ?>">
                                            <?php else: ?>
                                                <a href="javascript:void(0);">
                                                    <?php endif; ?>
                                                    <img src="<?php echo e($bannerdata['image']); ?>" alt="banner"
                                                         class="rounded-4">
                                                </a>
                                        </a>
                                </a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
    <!-- Promotional topbanners End Here -->



    <!-- Category Section Start Here -->
    <?php if(count(helper::get_categories()) > 0): ?>
        <section class="category position-relative bg-section-gray sec-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="row g-2 align-items-center justify-content-between mb-sm-5 mb-4">
                            <div class="col-auto">
                                <h1 class="text-uppercase fw-bold"><?php echo e(trans('labels.categories')); ?></h1>
                                <p class="sub-lables text-capitalize mt-2 mb-0"><?php echo e(trans('labels.top_categories')); ?></p>
                            </div>
                            <div class="col-auto text-end align-center">
                                <a href="<?php echo e(route('categories')); ?>"
                                   class="btn btn-sm btn-outline-primary px-4 py-2 rounded-3"><?php echo e(trans('labels.view_all')); ?></a>
                            </div>
                        </div>
                        <div id="category" class="owl-carousel mt-2">
                            <?php $__currentLoopData = helper::get_categories(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categorydata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="category-wrapper category-item rounded-4">
                                    <a href="<?php echo e(URL::to('/menu/?category=' . $categorydata->slug)); ?>">
                                        <div class="d-flex justify-content-center">
                                            <div class="cat rounded-circle">
                                                <img src="<?php echo e(helper::image_path($categorydata->image)); ?>"
                                                     class="rounded-circle h-100 object-fit-cover" alt="category">
                                            </div>
                                        </div>
                                    </a>
                                    <div class="text-center pt-3 category-text">
                                        <p class="fs-6 fw-500 mb-0"><?php echo e($categorydata->category_name); ?></p>
                                        <p class="fs-7 fw-400 text-primary mb-0"><?php echo e($categorydata->item_info->count()); ?>

                                            <?php echo e(trans('labels.item')); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="burger-shape d-md-block d-none">
                <img src="https://modinatheme.com/html/foodking-html/assets/img/shape/burger-shape-2.png"
                     alt="shape-img">
            </div>
            <div class="fry-shape d-xl-block d-none">
                <img src="https://modinatheme.com/html/foodking-html/assets/img/shape/fry-shape.png" alt="shape-img">
            </div>
        </section>
    <?php endif; ?>
    <!-- Category Section End Here -->

    <!-- Top Deal Section Start Here -->
    <?php if(count($topdealsproduct) > 0 ): ?>
        <section class="theme-1-top-deal menu-special position-relative sec-padding bg-primary-rgb">
            <div class="container">
                <div class="row g-4">
                    <div class="col-6 align-self-start">
                        <div class=" rounded-4 overflow-hidden">
                            <div class="deals-heading mb-md-0 mb-3 text-start">
                                <p class="sub-lables text-capitalize mb-0 mt-md-2">
                                    <?php echo e(trans('labels.top_deals')); ?>

                                </p>
                            </div>
                            <div class="countdown d-flex justify-content-center gap-2 mt-3" id="countdown"></div>
                        </div>
                    </div>
                    <div class="col-6 d-flex flex-column align-items-end align-self-start">
                        <div class="px-4 rounded-4 overflow-hidden">
                            <div class="deals-heading mb-md-0 mb-3 text-end align-content-end">
                                <div class="col-lg-auto text-center">
                                    <a href="<?php echo e(URL::to('/view-all?type=topdeals')); ?>"
                                       class="btn btn-sm btn-outline-primary px-4 py-2 rounded-3">
                                        <?php echo e(trans('labels.view_all')); ?>

                                        <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="countdown d-flex justify-content-center gap-2 mt-3" id="countdown"></div>
                        </div>
                    </div>
                    <?php $__currentLoopData = $topdealsproduct; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $itemdata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo $__env->make('web.home1.todayitemview', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

            </div>

        </section>
    <?php endif; ?>
    <!-- Top Deal Section End Here -->

    <!-- Blog Section Start Here -->
    <?php if(@helper::checkaddons('blog')): ?>
        <?php if(count($getblogs) > 0): ?>
            <section>
                <div class="blog-wrapper sec-padding pt-0">
                    <div class="container">
                        <div class="row g-2 align-items-center justify-content-between mb-sm-5 mb-4">
                            <div class="col-auto blog-heading">
                                <h1 class="text-uppercase"><?php echo e(trans('labels.latest_blogs')); ?></h1>
                                <p class="sub-lables text-capitalize mt-2 mb-0"><?php echo e(trans('labels.top_blogs')); ?></p>
                            </div>
                            <div class="col-auto">
                                <a href="<?php echo e(route('blogs')); ?>"
                                   class="btn btn-sm btn-outline-primary px-4 py-2 rounded-3"><?php echo e(trans('labels.view_all')); ?></a>
                            </div>
                        </div>
                        <div class="row g-sm-4 g-3">
                            <?php $__currentLoopData = $getblogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bloglist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php echo $__env->make('web.blogs.blogview', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    <?php endif; ?>
    <!-- Blog Section End Here -->

    <!-- slider-gallery start Here -->
    <?php if(count($getgalleries) > 0): ?>
        <section class="gallery pb-5 position-relative">
            <div class="container">
                <div class="row align-items-center mb-sm-5 mb-4">
                    <div class="gallery-heading col-auto menu-heading">
                        <h1 class="text-uppercase"><?php echo e(trans('labels.gallery')); ?></h1>
                        <p class="sub-lables text-capitalize mt-2 mb-0"><?php echo e(trans('labels.our_gallery')); ?></p>
                    </div>
                </div>
            </div>
            <div class="gallery-slider owl-carousel owl-theme">
                <?php $__currentLoopData = $getgalleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="item" data-src="<?php echo e($image->image_url); ?>" data-fancybox="gallery"
                         data-thumb="<?php echo e($image->image_url); ?>">
                        <img src="<?php echo e(helper::image_path($image->image)); ?>" class="rounded-4" alt="">
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </section>
    <?php endif; ?>


    <section class="blog-wrapper sec-padding">
        <div class="mx-5 mt-2">
            <div class="row">
                <?php $__currentLoopData = helper::get_categories_list(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categorydata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 mt-2 position-relative">
                        <a href="<?php echo e(URL::to('/menu/?category=' . $categorydata->slug)); ?>" class="d-block text-decoration-none">
                            <div class="position-relative">
                                <img src="<?php echo e(helper::image_path($categorydata->image)); ?>"
                                     class="rounded-4 img-fluid" alt="category" style="height: 340px;">
                                <div class="position-absolute top-50 start-50 translate-middle text-black fw-bold px-3 rounded text-center">
                                    <p class="m-0" style="font-size: 16px;">Restaurant</p>
                                    <p class="m-0" style="font-size: 24px;"><?php echo e($categorydata->category_name); ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    <!-- slider-gallery end Here -->
<style>
    .gallery-slider .item {
        width: 345px !important; /* Fixed width */
        height: 340px;          /* Fixed height */
        margin: 10px;           /* Add spacing */
    }

    .gallery-slider .item img.fixed-dimensions {
        width: 100%;    /* Make the image fit the fixed container */
        height: 100%;   /* Stretch the image to fill the container */
        object-fit: cover; /* Ensure proper scaling */
    }
    /*.blog-wrapper .owl-item {*/
    /*    width: 360px !important; !* Set the fixed width *!*/
    /*}*/
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <!-- JS For Promotional Banner Section 1 -->
    <script>
        $(document).ready(function () {
            $("#news-slider ").owlCarousel({
                rtl: <?php if(session()->get('direction') == '2'): ?>
                    true
                <?php else: ?>
                    false
                <?php endif; ?> ,
                loop: true,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 2,
                        nav: false,
                        dots: false,
                        arrow: true,
                        margin: 10,
                        loop: false,
                        // rewind: true
                    },
                    400: {
                        items: 2,
                        nav: false,
                        dots: false,
                        arrow: true,
                        margin: 10,
                        loop: false,
                        // rewind: true
                    },
                    600: {
                        items: 2,
                        nav: false,
                        dots: false,
                        arrow: true,
                        margin: 10,
                        loop: false,
                        // rewind: true
                    },
                    800: {
                        items: 2,
                        nav: false,
                        dots: false,
                        arrow: true,
                        margin: 10,
                        loop: false,
                        // rewind: true
                    },
                    1000: {
                        items: 3,
                        nav: false,
                        dots: false,
                        arrow: true,
                        margin: 10,
                        loop: false,
                        // rewind: true
                    },
                    1200: {
                        items: 3,
                        nav: false,
                        dots: false,
                        arrow: true,
                        margin: 10,
                        loop: false,
                        // rewind: true
                    }
                }
            });
        });
    </script>
    <!-- JS For Category Section -->
    <script>
        $(document).ready(function () {
            $("#category").owlCarousel({
                rtl: <?php if(session()->get('direction') == '2'): ?>
                    true
                <?php else: ?>
                    false
                <?php endif; ?> ,
                loop: true,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 2,
                        nav: false,
                        dots: false,
                        arrow: true,
                        margin: 10,
                    },
                    426: {
                        items: 3,
                        nav: false,
                        dots: false,
                        arrow: true,
                        margin: 15,
                    },
                    600: {
                        items: 4,
                        nav: false,
                        dots: false,
                        margin: 15,
                    },
                    800: {
                        items: 4,
                        nav: false,
                        dots: false,
                        margin: 10,
                    },
                    1025: {
                        items: 5,
                        dots: false,
                        nav: false,
                        loop: false,
                        arrows: true,
                        margin: 20,
                    },
                }
            });
        });
    </script>
    <!-- JS For Promotional Banner Section 3 -->
    <script>
        $(document).ready(function () {
            $("#bannersection2").owlCarousel({
                rtl: <?php if(session()->get('direction') == '2'): ?>
                    true
                <?php else: ?>
                    false
                <?php endif; ?> ,
                loop: true,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 2,
                        nav: false,
                        dots: false,
                        arrow: true,
                        margin: 10,
                        loop: false,
                        // rewind: true
                    },
                    400: {
                        items: 2,
                        nav: false,
                        dots: false,
                        arrow: true,
                        margin: 10,
                        loop: false,
                        // rewind: true
                    },
                    600: {
                        items: 2,
                        nav: false,
                        dots: false,
                        arrow: true,
                        margin: 10,
                        loop: false,
                        // rewind: true
                    },
                    800: {
                        items: 2,
                        nav: false,
                        dots: false,
                        arrow: true,
                        margin: 10,
                        loop: false,
                        // rewind: true
                    },
                    1000: {
                        items: 3,
                        nav: false,
                        dots: false,
                        arrow: true,
                        margin: 10,
                        loop: false,
                        // rewind: true
                    },
                    1200: {
                        items: 4,
                        nav: false,
                        dots: false,
                        arrow: true,
                        margin: 10,
                        loop: false,
                        // rewind: true
                    }
                }
            });
            $('.testimonial-1').owlCarousel({
                rtl: <?php if(session()->get('direction') == '2'): ?>
                    true
                <?php else: ?>
                    false
                <?php endif; ?> ,
                loop: true,
                margin: 20,
                nav: false,
                dots: true,
                autoplay: true,
                autoplayTimeout: 4000,
                responsive: {
                    0: {
                        items: 1
                    },
                    500: {
                        items: 1
                    },
                    1000: {
                        items: 2
                    },
                    1200: {
                        items: 2
                    },
                }
            });
            $('.slider-small').owlCarousel({
                rtl: <?php if(session()->get('direction') == '2'): ?> true <?php else: ?> false <?php endif; ?>,
                loop: true,
                margin: 10,
                nav: false,
                dots: false,
                center: true,
                autoplay: true,
                slideTransition: 'linear',
                autoplaySpeed: 3000,
                smartSpeed: 3000,
                autoplayTimeout: 3000,
                responsive: {
                    0: {
                        items: 2,
                        margin: 10

                    },
                    500: {
                        items: 2,
                        margin: 15

                    },
                    600: {
                        items: 2,
                        margin: 20

                    },
                    1000: {
                        items: 2,
                        margin: 20

                    }
                }
            });
        });
    </script>
    <!-- slider-gallery -->
    <script>
        $('.gallery-slider').owlCarousel({
            rtl: <?php if(session()->get('direction') == '2'): ?> true <?php else: ?> false <?php endif; ?>,
            loop: true,
            margin: 10,
            nav: false,
            dots: false,
            center: true,
            autoplay: true,
            slideTransition: 'linear',
            autoplaySpeed: 3000,
            smartSpeed: 3000,
            autoplayTimeout: 3000,
            items: 5, // Set the number of visible items
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/web/home1/index.blade.php ENDPATH**/ ?>