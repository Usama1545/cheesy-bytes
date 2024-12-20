<!-- header section start -->
<header>

    <div class="header-bar" id="header1">

        <nav class="navbar navbar-expand-lg sticky-top p-0">
            <div class="container navbar-container">
                <a class="navbar-brand" href="<?php echo e(route('home')); ?>">
                    <img class="img-resposive img-fluid" src="<?php echo e(asset('assets/images/logo.png')); ?>"
                         alt="logo">
                </a>
                <!-- language-btn -->
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                

                
                
                <!-- language-btn -->

                
                <div class="navbar-collapse collapse">
                    <div class="navbar-nav mx-auto">
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        


                    </div>
                    <div class="d-flex gap-3 align-items-center justify-content-center nav-sidebar-d-none" style="padding: 10px;">
                        <!-- language-btn -->


                        <!-- cart-btn -->
                        <div class="navbar-nav mx-auto header-head-box">
                            <a class="nav-link px-3 <?php echo e(request()->is('/') ? 'active' : ''); ?>"
                               href="<?php echo e(route('home')); ?>"><?php echo e(trans('labels.home')); ?></a>
                            <a class="nav-link px-3 <?php echo e(request()->is('categories') ? 'active' : ''); ?>"
                               href="<?php echo e(route('categories')); ?>"><?php echo e(trans('labels.menu')); ?></a>
                            <a class="nav-link px-3 <?php echo e(request()->is('reward') ? 'active' : ''); ?>"
                               href="<?php echo e(URL::to('reward')); ?> ">Rewards</a>
                            <a class="nav-link px-3 <?php echo e(request()->is('location') ? 'active' : ''); ?>"
                               href="<?php echo e(URL::to('location')); ?> ">Location</a>
                            <div class="nav-link px-3">
                                <div class="header-banner">
                                    <div class="header-banner-content">
                                        <span class="text-primary fw-bold">NOW EARN</span>
                                        <span class="header-badge">FREE</span>
                                        <span class="text-primary fw-bold">CHEESY BITE</span>
                                    </div>
                                    <div class="header-banner-subtext">EVERY 2 ORDER'S</div>
                                </div>
                            </div>

                            
                            
                            
                            


                            <!-- user-btn -->
                            <div class="text-center" style="width: 110px">
                                <?php if(auth()->user() && auth()->user()->type == 2): ?>
                                    <a class="nav-link text-white" href="<?php echo e(route('user-profile')); ?>" role="button">
                                        <i class="fa-solid fa-user"></i>
                                    </a>
                                <?php else: ?>
                                    <span style="width: 120px;">
                                <a href="<?php echo e(route('login')); ?>" class="text-white" style="font-size: 12px">SIGN IN & EARN REWARD</a>
                                </span>
                                <?php endif; ?>
                            </div>
                            <div class="header-search header-box">
                                <input type="text" class="search-form" placeholder="<?php echo e(trans('labels.search_here')); ?>"
                                       required>
                                <?php if(session()->get('direction') == ''): ?>
                                    <a href="<?php echo e(route('search')); ?>" class="search-button">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </a>
                                <?php elseif(session()->get('direction') == '2'): ?>
                                    <a href="<?php echo e(route('search')); ?>" class="search-button">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </a>
                                <?php else: ?>
                                    <a href="<?php echo e(route('search')); ?>" class="search-button">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="cart-area header-box">
                                <a href="<?php echo e(route('cart')); ?>" class="text-white">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                    <span class="cart-badge"><?php echo e(helper::get_user_cart()); ?></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
        </nav>
    </div>
</header>
<!-- header section end -->












<div class="offer">
    <div class="offcanvas <?php echo e(session()->get('direction') == '2' ? 'offcanvas-start' : 'offcanvas-end'); ?>"
         tabindex="-1" id="offcanvasOffer" aria-labelledby="offcanvasOfferLabel">
        <div class="offcanvas-header border-bottom bg-light">
            <div class="d-flex d-grid gap-2 align-items-center">
                <i class="fa-sharp fa-solid fa-badge-percent"></i>
                <h5 class="offcanvas-title fw-600" id="offcanvasOfferLabel"><?php echo e(trans('labels.offers')); ?></h5>
            </div>
            <button type="button"
                    class="btn-close <?php echo e(session()->get('direction') == '2' ? 'me-auto ms-0' : 'ms-auto me-0'); ?>"
                    data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="row g-3">
                <?php $__currentLoopData = helper::getoffers(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $offers): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $count = helper::getcouponcodecount($offers->offer_code);
                    ?>
                    <?php if($offers->usage_type == 1): ?>
                        <?php if($count < $offers->usage_limit): ?>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <span class="coupons-label"><?php echo e($offers->offer_code); ?></span>
                                            <?php if(request()->is('checkout')): ?>
                                                <p class="fw-500 cursor-pointer copy_coupon_code mb-0"
                                                   data-bs-dismiss="offcanvas"
                                                   onclick="getoffercode('<?php echo e($offers->offer_code); ?>')">
                                                    <?php echo e(trans('labels.copy_code')); ?>

                                                </p>
                                            <?php endif; ?>
                                        </div>
                                        <h5 class="pt-3 mb-0 offer-text"><?php echo e($offers->offer_name); ?></h5>
                                        <p class="text-muted fw-400 fs-8 pt-2 mb-0"><?php echo e($offers->description); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <span class="coupons-label"><?php echo e($offers->offer_code); ?></span>
                                        <?php if(request()->is('checkout')): ?>
                                            <p class="fw-500 cursor-pointer copy_coupon_code mb-0"
                                               data-bs-dismiss="offcanvas"
                                               onclick="getoffercode('<?php echo e($offers->offer_code); ?>')">
                                                <?php echo e(trans('labels.copy_code')); ?>

                                            </p>
                                        <?php endif; ?>
                                    </div>
                                    <h5 class="pt-3 mb-0 offer-text"><?php echo e($offers->offer_name); ?></h5>
                                    <p class="text-muted fw-400 fs-8 pt-2 mb-0"><?php echo e($offers->description); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</div>
<!-- offer btn end-->

<div class="mobile_menu_footer d-lg-none">
    <div class="container">
        <ul class="d-flex justify-content-between align-items-center mb-0 gap-3">
            <li class="text-center">
                <a href="<?php echo e(route('home')); ?>" class="<?php echo e(request()->is('/') ? 'active1' : ''); ?>">
                    <i class="fa-light fa-house"></i>
                    <p class="mb-0"><?php echo e(trans('labels.home')); ?></p>
                </a>
            </li>
            <li class="text-center">
                <a href="<?php echo e(route('search')); ?>" class="<?php echo e(request()->is('search') ? 'active1' : ''); ?>">
                    <i class="fa-light fa-magnifying-glass"></i>
                    <p class="mb-0"><?php echo e(trans('labels.search')); ?></p>
                </a>
            </li>
            <li class="text-center">
                <a href="<?php echo e(route('cart')); ?>" class="<?php echo e(request()->is('cart') ? 'active1' : ''); ?>">
                    <div class="position-relative">
                        <i class="fa-light fa-bag-shopping"></i>
                        <span class="qut_counter"><?php echo e(helper::get_user_cart()); ?></span>
                    </div>
                    <p class="mb-0"><?php echo e(trans('labels.cart')); ?></p>
                </a>
            </li>
            <li class="text-center">
                <a href="<?php echo e(route('categories')); ?>"
                   class="<?php echo e(request()->is('categories') ? 'active1' : ''); ?>">
                    <i class="fa-light fa-file"></i>
                    <p class="mb-0">Menu</p>
                </a>
            </li>
            <li class="text-center">
                <a href="<?php echo e(Auth::user() ? route('user-profile') : route('login')); ?>"
                   class="<?php echo e(request()->is('profile') ? 'active1' : ''); ?>">
                    <i class="fa-light fa-user"></i>
                    <p class="mb-0"><?php echo e(trans('labels.account')); ?></p>
                </a>
            </li>
        </ul>
    </div>
</div>
<style>
    /* Header Banner Container */
    .header-banner {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background-color: #ffffff; /* Gold background */
        padding: 12px 16px;
        margin: 0 auto;
        width: 250px;
        clip-path: polygon(10% 0%, 90% 0%, 100% 50%, 90% 100%, 10% 100%, 0% 50%);
        -webkit-clip-path: polygon(10% 0%, 90% 0%, 100% 50%, 90% 100%, 10% 100%, 0% 50%);
    }

    /* Banner Content */
    .header-banner-content {
        display: flex;
        align-items: center;
        gap: 6px;
        text-align: center;
    }

    /* Free Badge */
    .header-badge {
        background-color: #ff0000; /* Red background */
        color: #ffffff; /* White text */
        font-size: 6px;
        font-weight: bold;
        padding: 2px 6px;
        border-radius: 4px;
        text-transform: uppercase;
    }

    /* Primary Text Styles */
    .text-primary {
        color: #3d2b1f; /* Dark brown text */
        font-size: 10px;
        font-weight: bold;
    }

    /* Subtext */
    .header-banner-subtext {
        font-size: 10px;
        color: #4d4d4d; /* Gray text */
    }

    .header-head-box{
        height: 40px;
        /* width: 40px; */
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 8px;
    }

</style>
<?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/web/layout/header.blade.php ENDPATH**/ ?>