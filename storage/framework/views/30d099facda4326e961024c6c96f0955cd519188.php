<!doctype html>
<html lang="en" dir="<?php echo e(session('direction') == 2 ? 'rtl' : 'ltr'); ?>">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta property="og:title" content="<?php echo e(@helper::appdata()->og_title); ?>"/>
    <meta property="og:description" content="<?php echo e(@helper::appdata()->og_description); ?>"/>
    <meta property="og:image" content='<?php echo e(helper::image_path(@helper::appdata()->og_image)); ?>'/>
    <title> <?php echo e(@helper::appdata()->title); ?> <?php echo $__env->yieldContent('page_title'); ?></title>
    <link rel="icon" href="<?php echo e(helper::image_path(@helper::appdata()->favicon)); ?>"><!-- Favicon -->
    <link rel="stylesheet" href="<?php echo e(url(env('ASSETSPATHURL') . 'web-assets/css/bootstrap.min.css')); ?>">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="<?php echo e(url(env('ASSETSPATHURL') . 'web-assets/css/owl_carousel/owl.carousel.min.css')); ?>">
    <!-- owl-carousel css -->
    <link rel="stylesheet"
          href="<?php echo e(url(env('ASSETSPATHURL') . 'web-assets/css/owl_carousel/owl.theme.default.min.css')); ?>">
    <!-- owl-carousel css -->
    <link rel="stylesheet" href="<?php echo e(url(env('ASSETSPATHURL') . 'web-assets/css/font_awesome/all.css')); ?>">
    <!-- Font Awesome CSS -->
    <!-- COMMON-CSS -->
    <link rel="stylesheet" href="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/css/toastr/toastr.min.css')); ?>">
    <!-- Toastr CSS -->
    <link rel="stylesheet"
          href="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/css/sweetalert/sweetalert2.min.css')); ?>">
    <!-- Sweetalert CSS -->
    <link rel="stylesheet" href="<?php echo e(url(env('ASSETSPATHURL') . 'web-assets/css/style.css')); ?>"><!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo e(url(env('ASSETSPATHURL') . 'web-assets/css/responsive.css')); ?>">
    <!-- Media Query Resposive CSS -->
    <link rel="stylesheet" href="<?php echo e(url(env('ASSETSPATHURL') . 'web-assets/css/fancybox/fancybox-v4-0-27.css')); ?>">
    <!-- Fancybox 4.0 CSS -->
    <link rel="stylesheet" href="<?php echo e(url(env('ASSETSPATHURL') . 'web-assets/css/animate.min.css')); ?>">
    <!-- home banner animation CSS -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>"/>
    <!-- PWA -->
    <?php if(@helper::checkaddons('pwa')): ?>
        <?php if(helper::appdata()->pwa == 1): ?>
            <?php echo $__env->make('web.pwa.pwa', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
    <?php endif; ?>
    <style>
        :root {
            --bs-primary: <?php echo e(helper::appdata()->web_primary_color != null ? helper::appdata()->web_primary_color : '#F82647'); ?>;
            --bs-secondary: <?php echo e(helper::appdata()->web_secondary_color != null ? helper::appdata()->web_secondary_color : '#FFC344'); ?>;
        }
    </style>
    <?php echo $__env->yieldContent('styles'); ?>
</head>

<body>
<main id="main-content" class="">
    <div class="wrapper">
        <input type="hidden" name="hdnsession" id="hdnsession" value="<?php echo e(session()->get('direction')); ?>">
        <?php echo $__env->make('web.layout.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="content-wrapper">
            <?php echo $__env->yieldContent('content'); ?>
            <?php echo $__env->make('web.layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <!-- index CART item modal -->
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        

        
        <?php echo $__env->make('cookie-consent::index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </div>
</main>

<!-- Modal Item Details -->
<div class="modal modalitemdetails" id="modalitemdetails" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" id="modalitem_body">
        </div>
    </div>
</div>

<!-- All modals here -->

<!-- Product Allergens Modal -->
<div class="modal" id="itemallergens" tabindex="-1" aria-labelledby="itemallergensTitle" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-between">
                <h1 class="modal-title fs-5" id="itemallergensTitle"><?php echo e(trans('labels.allergens')); ?></h1>
                <button type="button" class="btn-close <?php echo e(session()->get('direction') == '2' ? 'm-0' : ''); ?>"
                        data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-0" id="allergensDisplay"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary"
                        data-bs-dismiss="modal"><?php echo e(trans('labels.close')); ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="PizzaModal" tabindex="-1" aria-labelledby="PizzaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="PizzaModalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row">
                <div class="col-md-7 border-end">
                    <!-- Size Selection -->
                    <div class="card mb-3">
                        <div class="card-header" style="background: #D6B62B">Select Size</div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between flex-wrap gap-2 mx-5" id="pizzaSizesContainer">
                                <!-- Dynamically loaded sizes will go here -->
                            </div>
                            <hr>
                            <div class="card-body d-flex flex-wrap gap-2" id="pizzaCrustContainer">
                                <!-- Dynamically loaded crusts will go here -->
                            </div>
                        </div>
                    </div>
                    <!-- Crust Selection -->

                    <div id="pizzaAddonsContainer"></div>

                    <div class="card mb-3">
                        <div class="card-header" style="background: #D6B62B">Select Dipping Sause</div>
                        <div class="card-body">
                            <?php $__currentLoopData = helper::getSides(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dipping): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="d-flex align-items-center gap-3 mb-3 pizza-dipping-item"
                                     data-name="<?php echo e($dipping->name); ?>"
                                     data-price="<?php echo e($dipping->price); ?>"
                                     data-id="<?php echo e($dipping->id); ?>">
                                    <!-- Dipping Image -->
                                    <img src="<?php echo e(helper::image_path($dipping->image)); ?>"
                                         alt="Dipping Sauce"
                                         class="img-fluid rounded h-70px"
                                         style="object-fit: cover;">

                                    <!-- Dipping Name -->
                                    <span class="flex-grow-1 text-sm"><?php echo e($dipping->name); ?></span>

                                    <!-- Quantity Controls -->
                                    <div class="d-flex align-items-center ms-auto">
                                        <!-- Decrease Button -->
                                        <button data-action="decrease"
                                                class="btn btn-secondary bg-gray rounded-circle d-flex justify-content-center align-items-center"
                                                style="width: 40px; height: 40px; font-size: 1.2rem; background: #a8a7a7; border-color: gray;">
                                            -
                                        </button>

                                        <!-- Quantity Display -->
                                        <span class="fw-semibold mx-3 quantity"
                                              style="min-width: 30px; text-align: center;">0</span>

                                        <!-- Increase Button -->
                                        <button data-action="increase"
                                                class="btn btn-primary rounded-circle d-flex justify-content-center align-items-center"
                                                style="width: 40px; height: 40px; font-size: 1.2rem;">
                                            +
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>

                <!-- Sauce Selection -->
                <div class="col-md-5">
                    <div id="myPizzaCard">
                        <div class="card mb-3">
                            <div class="card-header" id="PizzaModalLabel" style="background: #D6B62B">My Pizza</div>
                            <div class="card-body">
                                <div id="MyPizzaSummary" class="pizza-summary"></div>
                                <hr style="margin: 10px 0; border: 1px solid #ddd;">
                                <div class="d-flex align-items-center gap-3" style="font-size: 0.800rem;">
                                    <span class="">Quantity:</span>
                                    <button data-action="decrease_pizza_quantity"
                                            class="btn btn-secondary rounded-circle d-flex justify-content-center align-items-center"
                                            style="width: 40px; height: 40px; font-size: 1.5rem;background: #a8a7a7; border-color: gray;">
                                        -
                                    </button>
                                    <span id="overall-pizza-quantity" class="fw-semibold"
                                          style="min-width: 30px; text-align: center;">1</span>
                                    <button data-action="increase_pizza_quantity"
                                            class="btn btn-primary rounded-circle d-flex justify-content-center align-items-center"
                                            style="width: 40px; height: 40px; font-size: 1.5rem;">
                                        +
                                    </button>
                                </div>
                                <button id="addToCartButton" class="btn btn-primary mt-3"
                                        style="width: 100%;font-size: 15px">Add To Cart
                                </button>
                            </div>
                        </div>
                        <div id="img-container"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="customPizzaModal" tabindex="-1" aria-labelledby="customPizzaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="customPizzaModalLabel">Customize Your Pizza</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row">
                <div class="col-md-7 border-end">
                    <!-- Size Selection -->
                    <div class="card mb-3">
                        <div class="card-header" style="background: #D6B62B">Select Size</div>
                        <div class="card-body">
                            <div class=" d-flex justify-content-between flex-wrap gap-2 mx-5" id="sizeContainer">
                                <?php $__currentLoopData = helper::customPizzaSize(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <button type="button"
                                            class="btn round-button size-btn"
                                            data-size-id="<?php echo e($size->id); ?>"
                                            data-label="<?php echo e($size->label); ?>"
                                            data-price="<?php echo e($size->price); ?>">
                                        <?php echo e($size->name); ?>"
                                    </button>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <hr>
                            <div class="card-body d-flex flex-wrap gap-2" id="crustContainer"></div>
                        </div>
                    </div>
                    <!-- Crust Selection -->

                    <!-- Topping Selection -->
                    <div class="card mb-3">
                        <div class="card-header" style="background: #D6B62B">Select Toppings</div>
                        <div class="card-body">
                            <div class="topping-grid" id="toppingContainer"></div>
                        </div>
                    </div>

                    <!-- Sauce Selection -->
                    <div class="card mb-3">
                        <div class="card-header" style="background: #D6B62B">Select Sauces</div>
                        <div class="card-body justify-content-between gap-2" id="sauceContainer"></div>
                    </div>


                    <!-- Dipping Selection -->
                    <div class="card mb-3">
                        <div class="card-header" style="background: #D6B62B">Select Dipping Sause</div>
                        <div class="card-body">
                            <?php $__currentLoopData = helper::getSides(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dipping): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="d-flex align-items-center gap-3 mb-3 dipping-item"
                                     data-name="<?php echo e($dipping->name); ?>">
                                    <!-- Dipping Image -->
                                    <img src="<?php echo e(helper::image_path($dipping->image)); ?>"
                                         alt="Dipping Sauce"
                                         class="img-fluid rounded h-70px"

                                         style="object-fit: fill;width: 40px;height: 40px">

                                    <!-- Dipping Name -->
                                    <span class="flex-grow-1 text-sm"><?php echo e($dipping->name); ?></span>

                                    <!-- Quantity Controls -->
                                    <div class="d-flex align-items-center ms-auto">
                                        <!-- Decrease Button -->
                                        <button data-action="decrease"
                                                class="btn btn-secondary bg-gray rounded-circle d-flex justify-content-center align-items-center"
                                                style="width: 40px; height: 40px; font-size: 1.2rem; background: #a8a7a7; border-color: gray;">
                                            -
                                        </button>

                                        <!-- Quantity Display -->
                                        <span class="fw-semibold mx-3 quantity"
                                              style="min-width: 30px; text-align: center;">0</span>

                                        <!-- Increase Button -->
                                        <button data-action="increase"
                                                class="btn btn-primary rounded-circle d-flex justify-content-center align-items-center"
                                                style="width: 40px; height: 40px; font-size: 1.2rem;">
                                            +
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <!-- Special Selection -->

                    <div class="card mb-3">
                        <div class="card-header" style="background: #D6B62B">Special Instructions</div>
                        <div class="card-body">
                            <div class="row col-12" style="">
                                <!-- Bake Options -->
                                <div class="col-12 col-md-3" style="border-right: 1px solid #cccaca">
                                    <h6>BAKE</h6>
                                    <div>
                                        <label class="text-sm" style="font-size: 11px">
                                            <input type="radio" name="bake" class="form-check-input" value="well-done">
                                            Well Done
                                        </label>
                                    </div>
                                    <div>
                                        <label class="text-sm" style="font-size: 11px">
                                            <input type="radio" name="bake" class="form-check-input" value="normal-bake"
                                                   checked>
                                            Normal Bake
                                        </label>
                                    </div>
                                </div>

                                <!-- Seasoning Options -->
                                <div class="col-12 col-md-5" style="border-right: 1px solid #cccaca">
                                    <h6>SEASONING</h6>
                                    <div>
                                        <label class="text-sm" style="font-size: 11px">
                                            <input type="radio" name="seasoning" class="form-check-input"
                                                   value="garlic-seasoned-crust" checked>
                                            Garlic-Seasoned Crust
                                        </label>
                                    </div>
                                    <div>
                                        <label class="text-sm" style="font-size: 11px">
                                            <input type="radio" name="seasoning" class="form-check-input"
                                                   value="no-garlic-seasoned-crust">
                                            No Garlic-Seasoned Crust
                                        </label>
                                    </div>
                                </div>

                                <!-- Cut Options -->
                                <div class="col-12 col-md-4">
                                    <h6>CUT</h6>
                                    <div>
                                        <label class="text-sm" style="font-size: 11px">
                                            <input type="radio" name="cut" class="form-check-input" value="pie-cut"
                                                   checked>
                                            Pie Cut
                                        </label>
                                    </div>
                                    <div>
                                        <label class="text-sm" style="font-size: 11px">
                                            <input type="radio" name="cut" class="form-check-input" value="square-cut">
                                            Square Cut
                                        </label>
                                    </div>
                                    <div>
                                        <label class="text-sm" style="font-size: 11px">
                                            <input type="radio" name="cut" class="form-check-input" value="uncut">
                                            Uncut
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-5">
                    <div class="card mb-3" id="myPizzaCard">
                        <div class="card-header" style="background: #D6B62B">My Pizza</div>
                        <div class="card-body">
                            <div id="PizzaSummary" class="pizza-summary"></div>
                            <hr style="margin: 10px 0; border: 1px solid #ddd;">
                            <div class="d-flex align-items-center gap-3" style="font-size: 0.800rem;">
                                <span class="">Quantity:</span>
                                <button data-action="decrease_quantity"
                                        class="btn btn-secondary rounded-circle d-flex justify-content-center align-items-center"
                                        style="width: 40px; height: 40px; font-size: 1.5rem;background: #a8a7a7; border-color: gray;">
                                    -
                                </button>
                                <span id="overall-quantity" class="fw-semibold"
                                      style="min-width: 30px; text-align: center;">1</span>
                                <button data-action="increase_quantity"
                                        class="btn btn-primary rounded-circle d-flex justify-content-center align-items-center"
                                        style="width: 40px; height: 40px; font-size: 1.5rem;">
                                    +
                                </button>
                            </div>
                            <button id="submit-quantity" class="btn btn-primary mt-3"
                                    style="width: 100%;font-size: 15px">Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="errorAlert" class="alert alert-danger d-none" role="alert">
    A simple danger alert—check it out!
</div>
<!-- Modal Subscribe-->
<div class="modal" id="NewsModal" tabindex="-1" aria-labelledby="NewsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 overflow-hidden">
            <div class="modal-body p-0 position-relative">
                <button type="button"
                        class="btn-close box-shadow-none <?php echo e(session()->get('direction') == '2' ? 'rtl' : ''); ?>"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="row g-0 align-items-center justify-content-between">
                    <div class="col-6 d-none d-lg-block">
                        <img src="<?php echo e(helper::image_path(@helper::appdata()->subscribe_newsletter_image)); ?>"
                             alt="" class="w-100 object-fit-cover newslatter-img">
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="py-5 px-4 px-sm-5">
                            <h2 class="subscribe-title mt-1"><?php echo e(trans('labels.newsletter')); ?></h2>
                            <p class="text-dark fw-500 fs-7 mb-4">
                                <?php echo e(trans('labels.subscribe_title')); ?>

                            </p>
                            <form method="post" action="<?php echo e(route('subscribe')); ?>">
                                <?php echo csrf_field(); ?>
                                <label
                                        class="text-black form-label fs-7 mb-1"><?php echo e(trans('labels.email')); ?></label>
                                <div class="input-group mb-3">
                                    <input type="email" class="form-control border text-dark fw-500 bg-light"
                                           name="subscribe_email" placeholder="<?php echo e(trans('labels.email')); ?>"
                                           required="">
                                </div>
                                <button type="submit"
                                        class="btn btn-secondary w-100 py-2"><?php echo e(trans('labels.subscribe')); ?></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if(@helper::checkaddons('age_verification')): ?>
    <?php echo $__env->make('web.age_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<?php if(@helper::checkaddons('sales_notification')): ?>
    <?php echo $__env->make('web.sales_notification', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>

<!-- Quick call -->







<!-- MODAL_working_hours--START -->
<div class="modal" id="modal_working_hours" tabindex="-1" aria-labelledby="working_hours_Label"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-between">
                <h5 class="modal-title" id="working_hours_Label"><?php echo e(trans('labels.working_hours')); ?></h5>
                <button type="button" class="btn-close m-0" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group list-group-flush">
                    <?php $__currentLoopData = helper::gettime(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $time): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="list-group-item d-flex justify-content-between fs-7"> <?php echo e(ucfirst($time->day)); ?>

                            <?php if($time->always_close == 1): ?>
                                <span class="text-danger fs-6"><?php echo e(trans('labels.closing_time')); ?></span>
                            <?php else: ?>
                                <span><?php echo e($time->open_time); ?> <b><?php echo e(trans('labels.to')); ?></b>
                                        <?php echo e($time->break_start); ?>

                                        <br>
                                        <?php echo e($time->break_end); ?> <b><?php echo e(trans('labels.to')); ?></b>
                                        <?php echo e($time->close_time); ?>

                                    </span>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger px-4 py-2"
                        data-bs-dismiss="modal"><?php echo e(trans('labels.close')); ?></button>
            </div>
        </div>
    </div>
</div>
<!-- MODAL_working_hours--END -->

<!-- MODAL_USER_TYPE_SELECTION--START -->
<div class="modal" id="useroption" tabindex="-1" aria-labelledby="useroptionLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-between">
                <h5 class="modal-title" id="useroptionLabel">
                    <?php echo e(trans('labels.proceed_as_guest_or_login')); ?>

                </h5>
                <button type="button" class="btn-close m-0" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="fs-7 twoline">
                    <?php echo e(trans('labels.dont_have_account_guest')); ?>

                </p>
                <div class="row g-2 justify-content-start social-share-icon mt-3">
                    <div class="col-md-6 col-12">
                        <a class="btn btn-outline-dark w-100 p-2" href="javascript:void(0)"
                           onclick="showlogin()" type="button">
                            <i class="fa-solid fa-user-plus"></i>
                            <span class="px-2"><?php echo e(trans('labels.create_account')); ?></span>
                        </a>
                    </div>
                    <div class="col-md-6 col-12">
                        <a class="btn btn-primary w-100 p-2" target="_blank" onclick="checkout()">
                            <i class="fa-solid fa-address-card"></i>
                            <span
                                    class="px-2"><?php echo e(trans('labels.continue_as_guest')); ?></span>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- MODAL_USER_TYPE_SELECTION--END -->

<!-- ADD_REVIEW_ODAL_START -->
<div class="modal" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-4">
            <div class="modal-header">
                <h4 class="modal-title fw-bold" id="reviewmodalLabel">
                    <?php echo e(trans('labels.add_review')); ?></h4>
                <button type="button" class="btn-close <?php echo e(session()->get('direction') == 2 ? 'close' : ''); ?>"
                        data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(URL::to('/add-review')); ?>" method="POST" class="mb-0">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-body">
                        <div class="form-group col-lg-12">
                            <div class="d-flex align-items-center gap-3">
                                <div class="review-modal-img">
                                    <img src="" class="h-100 w-100 object-fit-cover rounded-4 border"/>
                                </div>
                                <p class="fw-600 mb-0" id="data-item-name"></p>
                            </div>
                            <div class="star-rating">
                                <?php for($i = 5; $i > 0; $i = $i - 1): ?>
                                    <input type="radio" id="<?php echo e($i); ?>" name="rating"
                                           onclick="$('#ratting').val('<?php echo e($i); ?>')"
                                            <?php echo e($i == 1 ? 'checked' : ''); ?>>
                                    <label for="<?php echo e($i); ?>"><i class="fa-solid fa-star fs-4"
                                                             aria-hidden="true"></i></label>
                                <?php endfor; ?>
                            </div>
                            <input type="hidden" name="ratting" id="ratting" value="1">
                        </div>
                        <div class="mt-3">
                            <label for="form-label"><span class="fs-7"><?php echo e(trans('labels.write_review')); ?>

                                        (<?php echo e(trans('labels.optional')); ?>)</span></label>
                            <textarea name="comment" rows="2" class="form-control mt-1"
                                      placeholder="Message"></textarea>
                        </div>
                        <input type="hidden" name="item_id" id="data-item-id" value="">
                    </div>
                </div>
                <div class="modal-footer justify-content-center border-0">
                    <div class="row g-2 w-100">
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-outline-danger px-4 fs-7 w-100"
                                    data-bs-dismiss="modal"><?php echo e(trans('labels.close')); ?></button>
                        </div>
                        <div class="col-sm-6">
                            <button type="submit"
                                    class="btn btn-primary px-4 fs-7 w-100"><?php echo e(trans('labels.save')); ?></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ADD_REVIEW_ODAL_END -->


<script src="<?php echo e(url(env('ASSETSPATHURL') . 'web-assets/js/jquery/jquery-3.6.0.js')); ?>"></script>
<!-- jQuery JS -->
<script src="<?php echo e(url(env('ASSETSPATHURL') . 'web-assets/js/owl_carousel/owl.carousel.js')); ?>"></script>
<!-- owl carousel js -->
<script src="<?php echo e(url(env('ASSETSPATHURL') . 'web-assets/js/bootstrap/bootstrap.bundle.min.js')); ?>"></script>
<!-- Bootstrap CSS -->
<!-- COMMON-FOR-TOASTER-&-SWEETALERT -->
<script src="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/js/toastr/toastr.min.js')); ?>"></script>
<!-- Toastr JS -->
<script src="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/js/sweetalert/sweetalert2.min.js')); ?>"></script>
<!-- Sweetalert JS -->
<script src="<?php echo e(url(env('ASSETSPATHURL') . 'web-assets/js/fancybox/fancybox-v4-0-27.js')); ?>"></script>
<!-- Fancybox 4.0 JS -->

<script>
    const roundButtons = document.querySelectorAll('.round-button');

    // Add event listeners to toggle the selected state
    roundButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove the 'selected' class from all buttons
            roundButtons.forEach(btn => btn.classList.remove('selected'));

            // Add the 'selected' class to the clicked button
            button.classList.add('selected');
        });
    });

    document.querySelectorAll('.circle').forEach(circle => {
        circle.addEventListener('click', function () {
            circle.classList.toggle('filled');
        });
    });


    function updateOverallQuantity(change) {
        const quantityDisplay = document.getElementById('overall-quantity');
        let currentQuantity = parseInt(quantityDisplay.textContent, 10);
        console.log(currentQuantity);
        currentQuantity = Math.max(1, currentQuantity + change); // Ensure the quantity is at least 1
        quantityDisplay.textContent = currentQuantity;
        document.getElementById('overall-quantity').textContent = currentQuantity;
    }


    document.addEventListener('DOMContentLoaded', function () {
        const sizeContainer = document.getElementById('sizeContainer');
        const crustContainer = document.getElementById('crustContainer');
        const toppingContainer = document.getElementById('toppingContainer');
        const sauceContainer = document.getElementById('sauceContainer');
        const quantityValue = document.getElementById('overall-quantity');
        const decreaseButton = document.querySelector('button[data-action="decrease"]');
        const increaseButton = document.querySelector('button[data-action="increase"]');
        const decreaseQuantityButton = document.querySelector('button[data-action="decrease_quantity"]');
        const increaseQuantityButton = document.querySelector('button[data-action="increase_quantity"]');
        const submitButton = document.getElementById('submit-quantity');
        const dippingItems = document.querySelectorAll('.dipping-item');
        const selectedDippingsElement = document.getElementById('selected-dippings');
        const selectedDippings = {};
        let dippingsArray = [];
        let bake = '';
        let cut = '';
        let seasoning = '';
        let dippingName = '';

        let quantity = 1;
        let pizzaQuantity = 1;

        function updateQuantityDisplay() {
            quantityValue.textContent = pizzaQuantity;
        }

        increaseButton.addEventListener('click', () => {
            quantity++;
            updateQuantityDisplay();
        });

        increaseQuantityButton.addEventListener('click', () => {
            pizzaQuantity++;
            updateQuantityDisplay();
        });

        decreaseButton.addEventListener('click', () => {
            if (quantity > 1) {
                quantity--;
                updateQuantityDisplay();
            }
        });
        decreaseQuantityButton.addEventListener('click', () => {
            if (pizzaQuantity > 1) {
                pizzaQuantity--;
                updateQuantityDisplay();
            }
        });

        submitButton.addEventListener('click', () => {
            const payload = {
                size: selectedSize,
                crust: selectedCrusts,
                toppings: selectedToppings,
                sauce: selectedSauces,
                quantity: pizzaQuantity,
                bake: bake,
                cut: cut,
                seasoning: seasoning,
                selectedDippings: dippingsArray
            };

            fetch('/create-pizza', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify(payload)
            })
                .then(response => response.json())
                .then(data => {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('customPizzaModal'));
                    if (modal) {
                        modal.hide();
                    }
                    window.location.reload();
                })
                .catch(error => {
                    const alert = document.getElementById("errorAlert");
                    alert.textContent = "Error submitting order: " + error.message;
                    alert.classList.remove("d-none");
                });
        });

        updateQuantityDisplay();


        let selectedToppings = [];
        let selectedCrusts = null;
        let selectedSauces = null;

        let allCrusts = [];
        let allToppings = [];
        let allSauces = [];
        let selectedSize = null;

        // Fetch all options on page load
        function fetchOptions() {
            Promise.all([
                fetch('/getCrusts').then(res => res.json()),
                fetch('/getToppings').then(res => res.json()),
                fetch('/getSauces').then(res => res.json()),
            ])
                .then(([crusts, toppings, sauces]) => {
                    allCrusts = crusts;
                    allToppings = toppings;
                    allSauces = sauces;
                    displayOptions(); // Initially empty until size is selected
                    autoSelectFirstSize();
                    autoSelectFirstCrust();
                })
                .catch(error => console.error('Error fetching options:', error));
        }

        function autoSelectFirstSize() {
            const firstSize = sizeContainer.querySelector('.size-btn');
            if (firstSize) {
                firstSize.click();
            }
        }

        function autoSelectFirstCrust() {
            const firstSize = crustContainer.querySelector('.crust-checkbox');
            if (firstSize) {
                firstSize.click();
            }
        }

        // Display options based on the selected size
        function displayOptions() {
            if (!selectedSize) return;

            selectedSauces = null;
            selectedCrusts = null;
            selectedToppings = [];
            // Filter and display crusts
            displayCrusts();

            // Filter and display toppings
            displayToppings();

            // Filter and display sauces
            displaySauces();
        }

        function displayCrusts() {
            crustContainer.innerHTML = ''; // Clear crust container
            console.log(selectedSize);
            const filteredCrusts = allCrusts.filter(crust =>
                String(crust.size_id) === String(selectedSize.id)
            );

            filteredCrusts.forEach(crust => {
                const label = document.createElement('label');
                label.className = 'form-check-label d-block';
                label.innerHTML = `
            <input
                type="radio"
                name="crust"
                class="form-check-input crust-checkbox"
                data-crust-id="${crust.id}"
                data-price="${crust.price}"
            />
             <span>${crust.name}</span>
        <div class="text-muted small mx-4">${crust.description}</div> <!-- Added description -->

        `;
                label.querySelector('input').addEventListener('change', () => selectCrust(crust));
                crustContainer.appendChild(label);
            });
            autoSelectFirstCrust();
        }

        function displayToppings() {
            toppingContainer.innerHTML = ''; // Clear toppings container
            const filteredToppings = allToppings.filter(topping =>
                String(topping.size_id) === String(selectedSize.id)
            );

            filteredToppings.forEach(topping => {
                const label = document.createElement('label');
                label.className = 'form-check-label d-block text-sm';
                label.innerHTML = `
            <input
                type="checkbox"
                class="form-check-input topping-checkbox"
                data-topping-id="${topping.id}"
                data-price="${topping.price}"
            />
            ${topping.name} ($${topping.price})
            <div class="topping-options" style="display: none; margin-top: 10px;">
                <div class="form-group justify-content-between">
                    <div class="btn-group" role="group" data-topping-id="${topping.id}">
                        <div class="pizza-topping">
                            <!-- Left -->
                            <label data-quid="topping-portion-C-1/2-left" class="pizza-topping__part pizza-topping__part--left">
                                <input aria-label="Cheese on left side" data-part="left" name="Part|${topping.id}" hidden type="radio" value="1/2">
                                <svg aria-hidden="true" fill="none" focusable="false" height="24" viewBox="0 0 25 24" width="25" class="pizza-topping__icon">
                                    <path d="M11.4847 21.876L12.5861 21.9883V20.8811V3.11841V2.01126L11.4847 2.12357C9.03877 2.37296 6.77239 3.52107 5.12442 5.34558C3.47646 7.17009 2.56415 9.54119 2.56415 11.9998C2.56415 14.4583 3.47646 16.8294 5.12442 18.6539C6.77238 20.4785 9.03876 21.6266 11.4847 21.876Z"></path>
                                </svg>
                                <span class="pizza-topping__label">Left</span>
                            </label>

                            <!-- Full -->
                            <label data-quid="topping-portion-C-full" class="pizza-topping__part pizza-topping__part--full">
                                <input aria-label="Cheese on full pizza" data-part="full" name="Part|${topping.id}" hidden type="radio" value="1">
                                <svg aria-hidden="true" fill="none" focusable="false" height="24" viewBox="0 0 25 24" width="25" class="pizza-topping__icon">
                                    <circle cx="12.5" cy="12" r="10"></circle>
                                </svg>
                                <span class="pizza-topping__label">Full</span>
                            </label>

                            <!-- Right -->
                            <label data-quid="topping-portion-C-1/2-right" class="pizza-topping__part pizza-topping__part--right">
                                <input aria-label="Cheese on right side" data-part="right" name="Part|${topping.id}" hidden type="radio" value="1/2">
                                <svg aria-hidden="true" fill="none" focusable="false" height="24" viewBox="0 0 25 24" width="25" class="pizza-topping__icon">
                                    <path d="M12.5861 2.01126V2.12357C15.0321 2.37296 17.2985 3.52107 18.9465 5.34558C20.5945 7.17009 21.5068 9.54119 21.5068 11.9998C21.5068 14.4583 20.5945 16.8294 18.9465 18.6539C17.2985 20.4785 15.0321 21.6266 12.5861 21.876V2.01126Z"></path>
                                </svg>
                                <span class="pizza-topping__label">Right</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group mt-2 justify-content-between">
                    <div class="btn-group" role="group" data-topping-id="${topping.id}">
                        <button type="button" class="btn btn-outline-primary quantity-btn p-1 text-sm" data-quantity="none">None</button>
                        <button type="button" class="btn btn-outline-primary quantity-btn p-1 text-sm" data-quantity="light">Light</button>
                        <button type="button" class="btn btn-outline-primary quantity-btn p-1 text-sm" data-quantity="normal">Normal</button>
                        <button type="button" class="btn btn-outline-primary quantity-btn p-1 text-sm" data-quantity="extra">Extra</button>
                    </div>
                </div>
            </div>
        `;

                const input = label.querySelector('input.topping-checkbox');
                const optionsContainer = label.querySelector('.topping-options');
                const sideInputs = label.querySelectorAll('[data-part]');
                const quantityButtons = label.querySelectorAll('.quantity-btn');

                // Handle topping checkbox toggle
                input.addEventListener('change', (event) => {
                    const isChecked = event.target.checked;
                    optionsContainer.style.display = isChecked ? 'block' : 'none';
                    if (!isChecked) {
                        const index = selectedToppings.findIndex(t => t.topping_id === topping.id);
                        if (index > -1) {
                            selectedToppings.splice(index, 1);
                        }
                        label.querySelectorAll('[data-part]').forEach(input => input.checked = false);
                        label.querySelectorAll('.quantity-btn').forEach(btn => btn.classList.add('btn-outline-primary'));
                        label.querySelectorAll('.quantity-btn').forEach(btn => btn.classList.remove('btn-primary'));

                        renderPizzaSummary();

                    } else {
                        selectedToppings.push({
                            topping_id: topping.id,
                            topping_name: topping.name,
                            side: null,
                            quantity: null
                        }); // Initialize if checked
                        clearOtherToppingOptions(topping.id);
                    }
                });

                sideInputs.forEach(sideInput => {
                    sideInput.addEventListener('change', () => {
                        const selectedSide = label.querySelector(
                            'input[name="Part|' + topping.id + '"]:checked'
                        )?.dataset.part || null;
                        updateToppingSelection(topping.id, topping.name, selectedSide, undefined);
                    });
                });

                quantityButtons.forEach(button => {
                    button.addEventListener('click', (event) => {
                        updateButtonGroup(button, 'quantity-btn');
                        const selectedQuantity = button.dataset.quantity;
                        updateToppingSelection(topping.id, topping.name, undefined, selectedQuantity);
                    });
                });

                toppingContainer.appendChild(label);
            });
        }

        function clearOtherToppingOptions(selectedToppingId) {
            const allOptions = document.querySelectorAll('.topping-options');
            allOptions.forEach(options => {
                const toppingId = options.querySelector('.side-btn')?.closest('.form-group').dataset.toppingId;
                if (toppingId && toppingId !== String(selectedToppingId)) {
                    options.style.display = 'none';
                    const input = document.querySelector(`.topping-checkbox[data-topping-id="${toppingId}"]`);
                    if (input) input.checked = false; // Uncheck the other topping
                }
            });
        }

        function updateToppingSelection(toppingId, toppingName, side, quantity) {
            const index = selectedToppings.findIndex(t => t.topping_id === toppingId);

            if (index === -1) {
                // Add a new topping if it doesn't exist
                selectedToppings.push({
                    topping_id: toppingId || null,
                    topping_name: toppingName || null,
                    side: side || null,
                    quantity: quantity || null
                });
            } else {
                // Update the existing topping's values
                if (side !== undefined) {
                    selectedToppings[index].side = side;
                }
                if (quantity !== undefined) {
                    selectedToppings[index].quantity = quantity;
                }
            }
            console.log(selectedToppings);
            renderPizzaSummary();
        }

        function displaySauces() {
            sauceContainer.innerHTML = ''; // Clear sauces container
            const filteredSauces = allSauces.filter(sauce =>
                String(sauce.size_id) === String(selectedSize.id)
            );
            filteredSauces.forEach(sauce => {
                const label = document.createElement('label');
                label.className = 'form-check-label d-block text-sm mb-1';
                label.innerHTML = `
            <input
                type="radio"
                name="sauce"
                class="form-check-input sauce-checkbox"
                data-sauce-id="${sauce.id}"
                data-price="${sauce.price}"
            />
            ${sauce.name} ($${sauce.price})
        `;
                label.querySelector('input').addEventListener('change', (event) => toggleSauce(sauce, event.target.checked));
                sauceContainer.appendChild(label);
            });
        }

        // Handle size selection
        sizeContainer.addEventListener('click', function (event) {
            const card = event.target.closest('.size-btn');
            if (card) {
                selectedSize = {
                    id: card.dataset.sizeId,
                    label: card.dataset.label,
                    name: card.textContent.trim(),
                    price: parseFloat(card.dataset.price),
                };
                displayOptions(); // Update options based on size
            }
        });

        // Fetch all options on page load
        fetchOptions();

        function selectCrust(crust) {
            selectedCrusts = crust;
            renderPizzaSummary();
        }

        function toggleSauce(sauce, isChecked) {
            selectedSauces = sauce;
            renderPizzaSummary();
        }

        function updateButtonGroup(selectedButton, className) {
            const buttons = selectedButton.parentElement.querySelectorAll(`.${className}`);
            buttons.forEach(button => button.classList.remove('btn-primary'));
            buttons.forEach(button => button.classList.add('btn-outline-primary'));
            selectedButton.classList.remove('btn-outline-primary');
            selectedButton.classList.add('btn-primary');
        }

        dippingItems.forEach(item => {
            const decreaseButton = item.querySelector('button[data-action="decrease"]');
            const increaseButton = item.querySelector('button[data-action="increase"]');
            const quantityElement = item.querySelector('.quantity');
            const dippingName = item.getAttribute('data-name');

            // Increase quantity
            increaseButton.addEventListener('click', () => {
                const currentQuantity = parseInt(quantityElement.textContent, 10);
                const newQuantity = currentQuantity + 1;
                quantityElement.textContent = newQuantity;

                selectedDippings[dippingName] = newQuantity;

                dippingsArray.push({'name': dippingName, 'quantity': newQuantity});
                updateSelectedDippings();
            });

            // Decrease quantity
            decreaseButton.addEventListener('click', () => {
                const currentQuantity = parseInt(quantityElement.textContent, 10);
                if (currentQuantity > 0) {
                    const newQuantity = currentQuantity - 1;
                    quantityElement.textContent = newQuantity;

                    if (newQuantity === 0) {
                        dippingsArray = dippingsArray.filter(dipping => dipping.name !== dippingName);
                        delete selectedDippings[dippingName];
                    } else {
                        selectedDippings[dippingName] = newQuantity;
                    }


                    updateSelectedDippings();
                }
            });
        });

        // Update the selected dippings display
        function updateSelectedDippings() {
            const namesWithQuantities = Object.entries(selectedDippings)
                .filter(([name, quantity]) => quantity > 0)
                .map(([name, quantity]) => `${quantity} ${name}`);

            dippingName = namesWithQuantities.length > 0 ? namesWithQuantities.join(', ') : '';
            renderPizzaSummary();
        }

        function getSelectedValues() {
            // Get the selected radio value for each category
            bake = document.querySelector('input[name="bake"]:checked')?.value || '';
            seasoning = document.querySelector('input[name="seasoning"]:checked')?.value || '';
            cut = document.querySelector('input[name="cut"]:checked')?.value || '';

        }

        // Add event listener to all radio buttons
        document.querySelectorAll('input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', getSelectedValues);
        });

        // Initial fetch to show default values
        getSelectedValues();

        function renderPizzaSummary() {
            const pizzaSummaryElement = document.getElementById('PizzaSummary');
            pizzaSummaryElement.innerHTML = ''; // Clear previous summary

            // Size and Crust
            const sizeCrustElement = document.createElement('div');
            sizeCrustElement.style.marginBottom = '10px';

            sizeCrustElement.innerHTML = `<strong>  ${selectedSize.label} (${selectedSize.name}), ${selectedCrusts.name}</strong> `;
            pizzaSummaryElement.appendChild(sizeCrustElement);


            // Sauce
            const sauceElement = document.createElement('div');
            sauceElement.style.marginBottom = '10px';
            if (selectedSauces) {
                sauceElement.innerHTML = `<span class="text-sm" style="font-size: 12px">${selectedSauces.name}</span>`;
            }
            pizzaSummaryElement.appendChild(sauceElement);

            const dippingElement = document.createElement('div');
            dippingElement.style.marginBottom = '10px';

            dippingElement.innerHTML = `<span class="fw-bold text-sm" style="font-size: 12px">Dippings</span>:<span class="text-sm" style="font-size: 12px"> ${dippingName} </span>`;
            if (dippingName) {
                pizzaSummaryElement.appendChild(dippingElement);
            }

            // Toppings grouped by side
            const sides = ['left', 'right', 'full'];
            sides.forEach(side => {
                const toppingsOnSide = selectedToppings.filter(topping => topping.side === side);
                if (toppingsOnSide.length > 0) {
                    const toppingElement = document.createElement('div');
                    toppingElement.style.display = 'flex';
                    toppingElement.style.alignItems = 'center'; // Vertically center content
                    toppingElement.style.marginBottom = '10px'; // Add spacing between elements if needed

                    const sideSvg = side === 'left'
                        ? `
                            <div style="display: inline-flex; justify-content: center; align-items: center; border: 2px solid #DE1616; border-radius: 50%; width: 30px; height: 30px; flex-shrink: 0;">
                                <svg aria-hidden="true" fill="none" focusable="false" height="24" viewBox="0 0 25 24" width="25" class="pizza-topping__icon" style="fill: #DE1616">
                                    <path d="M11.4847 21.876L12.5861 21.9883V20.8811V3.11841V2.01126L11.4847 2.12357C9.03877 2.37296 6.77239 3.52107 5.12442 5.34558C3.47646 7.17009 2.56415 9.54119 2.56415 11.9998C2.56415 14.4583 3.47646 16.8294 5.12442 18.6539C6.77238 20.4785 9.03876 21.6266 11.4847 21.876Z"></path>
                                </svg>
                            </div>`
                        : side === 'right'
                            ? `
                                <div style="display: inline-flex; justify-content: center; align-items: center; border: 2px solid #DE1616; border-radius: 50%; width: 30px; height: 30px; flex-shrink: 0;">
                                    <svg aria-hidden="true" fill="none" focusable="false" height="24" viewBox="0 0 25 24" width="25" class="pizza-topping__icon" style="fill: #DE1616">
                                        <path d="M12.5861 2.01126V2.12357C15.0321 2.37296 17.2985 3.52107 18.9465 5.34558C20.5945 7.17009 21.5068 9.54119 21.5068 11.9998C21.5068 14.4583 20.5945 16.8294 18.9465 18.6539C17.2985 20.4785 15.0321 21.6266 12.5861 21.876V2.01126Z"></path>
                                    </svg>
                                </div>`
                            : `
                                <div style="display: inline-flex; justify-content: center; align-items: center; border: 2px solid #DE1616; border-radius: 50%; width: 30px; height: 30px; flex-shrink: 0;">
                                    <svg aria-hidden="true" fill="none" focusable="false" height="24" viewBox="0 0 25 24" width="25" class="pizza-topping__icon" style="fill: #DE1616">
                                        <circle cx="12.5" cy="12" r="10"></circle>
                                    </svg>
                                </div>`;

                    toppingElement.innerHTML = `
                        ${sideSvg}
                        <div  class="text-sm" style="margin-left: 10px; font-size: 12px;">
                            ${toppingsOnSide.map(topping => `${topping.topping_name} (${topping.quantity || ''})`).join(', ')}
                        </div>
                    `;

                    pizzaSummaryElement.appendChild(toppingElement);
                }
            });


        }

        renderPizzaSummary();


    });

</script>

<script>
    $(document).ready(function () {
        let productId = null;
        const selectedDippings = {}; // To track selected dippings and their quantities
        let size_id = '';
        const quantityValue = document.getElementById('overall-pizza-quantity');
        const decreaseQuantityButton = document.querySelector('button[data-action="decrease_pizza_quantity"]');
        const increaseQuantityButton = document.querySelector('button[data-action="increase_pizza_quantity"]');
        let totalPrice = 0;
        let basePrice = 0;
        let details = {};

        let pizzaQuantity = 1;

        function updateQuantityDisplay() {
            quantityValue.textContent = pizzaQuantity;
            updatePriceSummary();
        }

        increaseQuantityButton.addEventListener('click', () => {
            console.log('clicked');
            pizzaQuantity++;
            updateQuantityDisplay();
        });

        decreaseQuantityButton.addEventListener('click', () => {
            if (pizzaQuantity > 1) {
                pizzaQuantity--;
                updateQuantityDisplay();
            }
        });


        // Open modal and load product data
        $(document).on('click', '[data-bs-target="#PizzaModal"]', function () {
            productId = $(this).data('product-id'); // Fetch product ID
            loadPizzaData(productId);
        });

        // Handle dipping quantity changes
        $(document).on('click', '.pizza-dipping-item button[data-action]', function () {
            const action = $(this).data('action');
            const item = $(this).closest('.pizza-dipping-item');
            const dippingId = item.data('id');
            const dippingPrice = parseFloat(item.data('price'));
            const quantityElement = item.find('.quantity');
            let currentQuantity = parseInt(quantityElement.text(), 10);


            if (action === 'increase') {
                currentQuantity++;
            } else if (action === 'decrease' && currentQuantity > 0) {
                currentQuantity--;
            }

            quantityElement.text(currentQuantity);

            if (currentQuantity > 0) {
                selectedDippings[dippingId] = {
                    price: dippingPrice,
                    id: dippingId,
                    quantity: currentQuantity,
                };
            } else {
                delete selectedDippings[dippingId];
            }

            updatePriceSummary();
        });

        // Load product details
        function loadPizzaData(itemId) {
            $.ajax({
                url: `/products/${itemId}/details`, // Replace with your API endpoint
                method: 'GET',
                success: function (response) {
                    details = response.responce.item_detail;
                    $('#pizzaSizesContainer').empty();
                    $('#pizzaCrustContainer').empty();
                    $('#PizzaDetailsSummary').empty();
                    $('#pizzaAddonsContainer').empty();
                    const itemCard = `
                        <div class="card mb-3">
                            <img
                                src="${response.responce.item_detail.item_image.image_url}"
                                class="card-img-top border-0 rounded-0 rounded-top position-relative"
                                alt="${response.responce.item_detail.item_name}"
                                height="190px">
                        </div>
                    `;
                    $('#img-container').html(itemCard); //
                    if (response) {
                        basePrice = parseFloat(response.responce.item_detail.price || 0);
                        $('#PizzaModalLabel').text(response.responce.item_detail.item_name);
                        $('#MyPizzaSummary').html(`
                            <div class="d-flex justify-content-between">
                                <span id="PizzaName">${response.responce.item_detail.item_name}</span>
                                <span id="PizzaPrice" class="text-muted">$${basePrice.toFixed(2)}</span>
                            </div>
                        `);

                        loadSizesAndCrusts(response.responce.crust_data);
                        loadAddonGroups(response.responce.item_detail.addons_group);
                    }
                },
                error: function (err) {
                    alert("Failed to load product details. Please try again.");
                    console.error("Error loading product data:", err);
                }
            });
        }

        $(document).on('click', '#addToCartButton', function () {
            const payload = buildAddToCartPayload();
            console.log(payload);
            $.ajax({
                url: '/addpizzatocart',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                data: JSON.stringify(payload),
                success: function (response) {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('PizzaModal'));
                    if (modal) {
                        modal.hide();
                    }
                    window.location.reload();                },
                error: function (err) {
                    console.error('Error adding item to cart:', err);
                }
            });
        });

        // Build Payload for Add-to-Cart
        function buildAddToCartPayload() {
            const addons = [];
            const extras = [];

            // Gather selected addons
            $('.addon-input:checked').each(function () {
                const addonId = $(this).data('addon-id');
                const addonName = $(this).closest('label').find('span:first').text();
                const addonPrice = parseFloat($(this).data('price')).toFixed(2);

                addons.push({
                    id: addonId,
                    name: addonName,
                    price: addonPrice,
                });
            });

            // Generate addons data
            const addonsId = addons.map(addon => addon.id).join('|');
            const addonsName = addons.map(addon => addon.name).join('|');
            const addonsPrice = addons.map(addon => addon.price).join('|');
            const selectedCrust = $('#pizzaCrustContainer input:checked');
            let crust_id = selectedCrust.data('crust-id');

            // Gather crust data
            return {
                slug: details.slug, // Replace with the server-side slug generation logic
                item_name: details.item_name,
                item_type: 1, // Assuming item type is fixed
                image_name: details.item_image.image_name,
                tax: '',
                item_price: totalPrice,
                qty: pizzaQuantity,
                addons_id: addonsId,
                addons_name: addonsName,
                addons_price: addonsPrice,
                size_id: size_id,
                crust_id: crust_id,
                dippings: selectedDippings,
                extras_id: '', // Include extras if applicable
                extras_name: '',
                extras_price: '',
                buynow: 0, // Assuming 0 for add-to-cart, 1 for buy now
            };
        }

        // Load sizes and crusts
        function loadSizesAndCrusts(crustData) {
            crustData.forEach(size => {
                const sizeButton = $(`
                    <button type="button" class="btn round-button size-btn" data-size-id="${size.id}">
                        ${size.label}
                    </button>
                `);
                $('#pizzaSizesContainer').append(sizeButton);
            });

            if (crustData.length > 0) {
                updateCrusts(crustData[0].crusts);
            }

            $('.size-btn').on('click', function () {
                const selectedSizeId = $(this).data('size-id');
                size_id = selectedSizeId;
                const selectedSize = crustData.find(size => size.id === selectedSizeId);

                $('.size-btn').removeClass('active');
                $(this).addClass('active');
                updateCrusts(selectedSize.crusts);
            });
        }

        // Update crusts
        function updateCrusts(crusts) {
            const crustContainer = $('#pizzaCrustContainer').empty();

            crusts.forEach(crust => {
                const crustOption = $(`
                    <label class="form-check-label w-100 d-flex justify-content-between align-items-center">
                        <span>
                            <input type="radio" name="crust" class="form-check-input crust-checkbox" data-crust-id="${crust.id}" data-price="${crust.price}">
                            <span>${crust.name}</span>
                        </span>
                        <span>$${parseFloat(crust.price).toFixed(2)}</span>
                    </label>
                `);
                crustOption.find('input').on('change', function () {
                    updatePriceSummary();
                });
                crustContainer.append(crustOption);
            });

            crustContainer.find('input:first').prop('checked', true).trigger('change');
        }

        // Load addons
        function loadAddonGroups(addonsGroup) {
            const addonsContainer = $('#pizzaAddonsContainer'); // Addons container in the modal
            addonsContainer.empty(); // Clear any previous content

            addonsGroup.forEach(group => {
                // Create a card for each addon group
                const card = $(`
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center" style="background: #D6B62B">
                    ${group.name}
                    <span class="badge bg-info">${group.selection_type === 1 ? 'Required' : 'Optional'}</span>
                </div>
                <div class="card-body">
                    <p class="text-muted">Select ${group.selection_count === 1 ? 'one' : `up to ${group.max_count}`}</p>
                    <div class="row gy-3" id="group-${group.id}-addons"></div>
                </div>
            </div>
        `);

                const addonsRow = card.find(`#group-${group.id}-addons`);
                let selectedAddons = []; // Track selected addons for this group

                const addons = Array.isArray(group.availableAddons)
                    ? group.availableAddons
                    : Object.values(group.availableAddons); // Handle both array and object formats

                addons.forEach(addon => {
                    const inputType = group.selection_count === 1 ? 'radio' : 'checkbox';

                    // Create addon input with label
                    const addonItem = $(`
                <div class="col-12 col-md-12">
                    <div class="form-check">
                        <input
                            type="${inputType}"
                            class="form-check-input addon-input"
                            id="addon-${addon.id}"
                            name="addon-group-${group.id}"
                            data-addon-id="${addon.id}"
                            data-price="${addon.price}"
                            ${group.selection_type === 1 ? 'required' : ''}
                            ${selectedAddons.includes(addon.id) ? 'checked' : ''}
                            ${inputType === 'checkbox' && selectedAddons.length >= group.max_count ? 'disabled' : ''}
                        />
                        <label class="form-check-label d-flex justify-content-between" for="addon-${addon.id}">
                            <span>${addon.name}</span>
                            <span class="text-muted">$${parseFloat(addon.price).toFixed(2)}</span>
                        </label>
                    </div>
                </div>
            `);

                    addonsRow.append(addonItem);

                    // Handle addon selection changes
                    addonItem.find('input').on('change', function () {
                        const addonId = parseInt($(this).data('addon-id'));
                        const price = parseFloat($(this).data('price'));

                        if (this.checked) {
                            if (inputType === 'checkbox' && selectedAddons.length >= group.max_count) {
                                this.checked = false;
                                return;
                            }
                            selectedAddons.push(addonId);
                        } else {
                            selectedAddons = selectedAddons.filter(id => id !== addonId);
                        }

                        // Update the price summary dynamically
                        updatePriceSummary();
                    });
                });

                // Append the card to the container
                addonsContainer.append(card);
            });
        }

        // Update price summary
        function updatePriceSummary() {
            let totalAddonPrice = basePrice; // Start with the pizza's base price

            // Add selected addons price
            $('.addon-input:checked').each(function () {
                totalAddonPrice += parseFloat($(this).data('price'));
            });

            // Add selected dippings price
            Object.values(selectedDippings).forEach(dipping => {
                totalAddonPrice += dipping.price * dipping.quantity;
            });

            // Add selected crust price
            const selectedCrust = $('#pizzaCrustContainer input:checked');
            if (selectedCrust.length) {
                totalAddonPrice += parseFloat(selectedCrust.data('price'));
            }
            totalAddonPrice = totalAddonPrice * pizzaQuantity;
            totalPrice = totalAddonPrice;
            $('#PizzaPrice').text(`$${totalAddonPrice.toFixed(2)}`);
        }
    });
</script>

<?php if(@helper::checkaddons('age_verification')): ?>
    <?php if(@helper::getagedetails($vendordata->id)->age_verification_on_off == 1): ?>
        <script src="<?php echo e(url('resources/js/age.js')); ?>"></script>
    <?php endif; ?>
<?php else: ?>
    <script>
        $('#main-content').removeClass('blur');
    </script>
<?php endif; ?>

<!-- whatsapp chat -->
<?php if(@helper::checkaddons('whatsapp_message')): ?>
    <?php if(@helper::getwhatsappmessage()->whatsapp_chat_on_off == 1): ?>
        <?php echo $__env->make('web.whatsapp_chat', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php endif; ?>
<!-- whatsapp_message btn end -->

<!-- tawk chat -->
<?php if(@helper::checkaddons('tawk_addons')): ?>
    <?php if(@helper::appdata()->tawk_on_off == 1): ?>
        <?php echo @helper::appdata()->tawk_widget_id; ?>

    <?php endif; ?>
<?php endif; ?>

<!-- wizz chat -->
<?php if(@helper::checkaddons('wizz_chat')): ?>
    <?php if(@helper::appdata()->wizz_chat_on_off == 1): ?>
        <?php echo @helper::appdata()->wizz_chat_settings; ?>

    <?php endif; ?>
<?php endif; ?>

<script>
    // COMMON-SCRIPTS
    // to-display-success-error-message
    toastr.options = {
        "closeButton": true,
    }
    <?php if(Session::has('success')): ?>
    toastr.success("<?php echo e(session('success')); ?>");
    <?php endif; ?>
    <?php if(Session::has('error')): ?>
    toastr.error("<?php echo e(session('error')); ?>");
    <?php endif; ?>
    // for-sweetalert
    let are_you_sure = "<?php echo e(trans('messages.are_you_sure')); ?>";
    let yes = "<?php echo e(trans('messages.yes')); ?>";
    let no = "<?php echo e(trans('messages.no')); ?>";
    let wrong = "<?php echo e(trans('messages.wrong')); ?>";
    let record_safe = "<?php echo e(trans('messages.record_safe')); ?>";
    let okay = "<?php echo e(trans('labels.okay')); ?>";
    let track_order = "<?php echo e(trans('labels.track_order')); ?>";
    let continue_shopping = "<?php echo e(trans('labels.continue_shopping')); ?>";
    let order_placed = "<?php echo e(trans('labels.order_placed')); ?>";
    let order_placed_note = "<?php echo e(trans('messages.order_placed_note')); ?>";
    let restaurant_closed = "<?php echo e(trans('messages.restaurant_closed')); ?>";

    // others
    function currency_format(price) {
        "use strict";
        if ("<?php echo e(@helper::appdata()->currency_position); ?>" == 1) {
            return "<?php echo e(@helper::appdata()->currency); ?>" + parseFloat(price).toFixed(2);
        } else {
            return parseFloat(price).toFixed(2) + "<?php echo e(@helper::appdata()->currency); ?>";
        }
    }

    // top deals parameter
    var start_date = "<?php echo e(@$topdeals->start_date); ?>";
    var start_time = "<?php echo e(@$topdeals->start_time); ?>";
    var end_date = "<?php echo e(@$topdeals->end_date); ?>";
    var end_time = "<?php echo e(@$topdeals->end_time); ?>";
    <?php if(@helper::checkaddons('top_deals')): ?>
    var enddate = "<?php echo e(App\Models\TopDeals::first()->end_date); ?>";
    var endtime = "<?php echo e(App\Models\TopDeals::first()->end_time); ?>";
    var deal_type = "<?php echo e(App\Models\TopDeals::first()->deal_type); ?>";
    <?php else: ?>
    var enddate = null;
    var endtime = null;
    <?php endif; ?>
    var topdeals = "<?php echo e(!empty(@$topdealsproduct) ? 1 : 0); ?>";
    var time_zone = "<?php echo e(helper::appdata()->timezone); ?>";
    var current_date = "<?php echo e(\Carbon\Carbon::now()->toDateString()); ?>";

    var siteurl = "<?php echo e(URL::to('/')); ?>";
</script>
<script src="<?php echo e(url(env('ASSETSPATHURL') . 'web-assets/js/custom/top_deals.js')); ?>"></script>
<script src="<?php echo e(url(env('ASSETSPATHURL') . 'web-assets/js/common.js')); ?>"></script><!-- web-common-js -->

<?php if(@helper::checkaddons('sales_notification')): ?>
    <?php if(helper::appdata()->fake_sales_notification == 1): ?>
        <script>
            if ("<?php echo e(@helper::appdata()->fake_sales_notification); ?>" == "1") {
                // Select the element with the ID 'sales-booster-popup'
                const popup = document.getElementById('sales-booster-popup');

                if (popup) {
                    // Define a function to add and remove the 'loaded' class
                    let isMouseOver = false;
                    const toggleLoadedClass = () => {
                        // Add the 'loaded' class
                        popup.classList.add('loaded');
                        // Remove the 'loaded' class after 5 seconds, unless the mouse is over the popup
                        setTimeout(() => {
                            if (!isMouseOver) {
                                popup.classList.remove('loaded');
                            }
                        }, "<?php echo e(helper::appdata()->notification_display_time); ?>"); // 4000 milliseconds = 4 seconds for demo purposes
                    };

                    // Function to handle mouseover event
                    const handleMouseOver = () => {
                        isMouseOver = true;
                        // You can perform actions here when mouse is over the popup
                    };

                    // Function to handle mouseout event
                    const handleMouseOut = () => {
                        isMouseOver = false;
                    };

                    // Call the function initially
                    toggleLoadedClass();

                    setInterval(function () {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: "<?php echo e(URL::to('get_notification_data')); ?>",

                            method: 'POST',
                            success: function (response) {
                                toggleLoadedClass();
                                $('#sales-booster-popup').show();
                                $('#notification_body').html(response.output);
                            },
                        });
                    }, "<?php echo e(helper::appdata()->notification_display_time+helper::appdata()->next_time_popup); ?>"); // 8000 milliseconds = 8 seconds

                    // Add mouseover and mouseout event listeners to the popup
                    popup.addEventListener('mouseover', handleMouseOver);
                    popup.addEventListener('mouseout', handleMouseOut);

                    // Select the close button within the popup
                    const closeButton = popup.querySelector('.close'); // Close button selector

                    if (closeButton) {
                        // Add an event listener to the close button
                        closeButton.addEventListener('click', () => {
                            // Remove the 'loaded' class immediately
                            popup.classList.remove('loaded');
                        });
                    }
                }
            }
        </script>
    <?php endif; ?>
<?php endif; ?>
<?php echo $__env->yieldContent('scripts'); ?>

</body>

</html>
<?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/web/layout/default.blade.php ENDPATH**/ ?>