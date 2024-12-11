<?php $modules = explode(',',helper::get_roles()); ?>
<ul class="navbar-nav">
    <li class="nav-item mb-2 fs-7">
        <a class="nav-link rounded d-flex <?php echo e(request()->is('admin/home*') ? 'active' : ''); ?>"
           href="<?php echo e(URL::to('/admin/home')); ?>" aria-expanded="false">
            <i class="fa-solid fa-house-user"></i><span class="nav-text "><?php echo e(trans('labels.dashboard')); ?></span>
        </a>
    </li>
    
    
    
    
    
    
    
    
    <?php if(@helper::checkaddons('pos')): ?>
        <?php if(Auth::user()->type != 1): ?>
            <?php if(in_array('25', $modules)): ?>
                <li class="nav-item mt-3">
                    <h6 class="text-muted mb-2 fs-7 text-uppercase"><?php echo e(trans('labels.pos_system')); ?></h6>
                </li>
            <?php endif; ?>
        <?php else: ?>
            <li class="nav-item mt-3">
                <h6 class="text-muted mb-2 fs-7 text-uppercase"><?php echo e(trans('labels.pos_system')); ?></h6>
            </li>
        <?php endif; ?>
        <li class="nav-item mb-2 fs-7 dropdown multimenu <?php echo e(Auth::user()->type != 1 ? (in_array('25', $modules) == true ? '' : 'd-none') : ''); ?>"
            id="25">
            <a class="nav-link collapsed rounded d-flex align-items-center justify-content-between dropdown-toggle mb-1"
               href="#pos" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="pos">
                <span class="d-flex"><i class="fa-solid fa-bag-shopping"></i>
                    <div class="w-100 gap-1 d-flex justify-content-between align-items-center">
                        <?php echo e(trans('labels.pos')); ?>

                        <?php if(env('Environment') == 'sendbox'): ?>
                            <small class="badge bg-danger"><?php echo e(trans('labels.addon')); ?></small>
                        <?php endif; ?>
                    </div></span>
            </a>
            <ul class="collapse" id="pos">
                <li class="nav-item ps-4 mb-1">
                    <a class="nav-link rounded <?php echo e(request()->is('admin/pos/items*') ? 'active' : ''); ?>"
                       aria-current="page" href="<?php echo e(URL::to('/admin/pos/items')); ?>">
                        <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                class="fa-solid fa-circle-small"></i><?php echo e(trans('labels.items')); ?></span>
                    </a>
                </li>
                <li class="nav-item ps-4 mb-1">
                    <a class="nav-link rounded <?php echo e(request()->is('admin/pos/orders*') ? 'active' : ''); ?>"
                       aria-current="page" href="<?php echo e(URL::to('/admin/pos/orders')); ?>">
                        <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                class="fa-solid fa-circle-small"></i><?php echo e(trans('labels.orders')); ?></span>
                    </a>
                </li>
            </ul>
        </li>
    <?php endif; ?>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    <?php if(Auth::user()->type != 1): ?>
        <?php if(in_array('1', $modules) || in_array('2', $modules)): ?>
            <li class="nav-item mt-3">
                <h6 class="text-muted mb-2 fs-7 text-uppercase"><?php echo e(trans('labels.orders_management')); ?></h6>
            </li>
        <?php endif; ?>
    <?php else: ?>
        <li class="nav-item mt-3">
            <h6 class="text-muted mb-2 fs-7 text-uppercase"><?php echo e(trans('labels.orders_management')); ?></h6>
        </li>
    <?php endif; ?>
    <li class="nav-item mb-2 fs-7 <?php echo e(Auth::user()->type != 1 ? (in_array('1', $modules) == true ? '' : 'd-none') : ''); ?>"
        id="1">
        <a class="nav-link rounded d-flex <?php echo e(request()->is('admin/orders*') || request()->is('admin/invoice*') ? 'active' : ''); ?>"
           href="<?php echo e(URL::to('/admin/orders')); ?>" aria-expanded="false">
            <i class="fa-solid fa-cart-shopping"></i><span class="nav-text "><?php echo e(trans('labels.orders')); ?></span>
        </a>
    </li>
    <li class="nav-item mb-2 fs-7 <?php echo e(Auth::user()->type != 1 ? (in_array('2', $modules) == true ? '' : 'd-none') : ''); ?>"
        id="2">
        <a class="nav-link rounded d-flex <?php echo e(request()->is('admin/report*') ? 'active' : ''); ?>"
           href="<?php echo e(URL::to('/admin/report')); ?>" aria-expanded="false">
            <i class="fa-solid fa-chart-mixed"></i><span class="nav-text "><?php echo e(trans('labels.report')); ?></span>
        </a>
    </li>
    <?php if(Auth::user()->type != 1): ?>
        <?php if(in_array('3', $modules) || in_array('4', $modules) || in_array('5', $modules) || in_array('6', $modules)): ?>
            <li class="nav-item mt-3">
                <h6 class="text-muted mb-2 fs-7 text-uppercase"><?php echo e(trans('labels.promotions')); ?></h6>
            </li>
        <?php endif; ?>
    <?php else: ?>
        <li class="nav-item mt-3">
            <h6 class="text-muted mb-2 fs-7 text-uppercase"><?php echo e(trans('labels.promotions')); ?></h6>
        </li>
    <?php endif; ?>
    <li class="nav-item mb-2 fs-7 <?php echo e(Auth::user()->type != 1 ? (in_array('3', $modules) == true ? '' : 'd-none') : ''); ?>"
        id="3">
        <a class="nav-link rounded d-flex <?php echo e(request()->is('admin/slider*') ? 'active' : ''); ?>"
           href="<?php echo e(URL::to('/admin/slider')); ?>" aria-expanded="false">
            <i class="fa-solid fa-images"></i><span class="nav-text "><?php echo e(trans('labels.sliders')); ?></span>
        </a>
    </li>
    <li class="nav-item mb-2 fs-7 dropdown multimenu <?php echo e(Auth::user()->type != 1 ? (in_array('4', $modules) == true ? '' : 'd-none') : ''); ?>"
        id="4">
        <a class="nav-link collapsed rounded d-flex align-items-center justify-content-between dropdown-toggle mb-1"
           href="#banners" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="banners">
            <span class="d-flex"><i class="fa-solid fa-list-tree"></i><span
                    class="multimenu-title"><?php echo e(trans('labels.banners')); ?></span></span>
        </a>
        <ul class="collapse" id="banners">
            <li class="nav-item ps-4 mb-1">
                <a class="nav-link rounded <?php echo e(request()->is('admin/bannersection-1*') ? 'active' : ''); ?>"
                   aria-current="page" href="<?php echo e(URL::to('/admin/bannersection-1')); ?>">
                    <span class="d-flex align-items-center multimenu-menu-indicator"><i
                            class="fa-solid fa-circle-small"></i><?php echo e(trans('labels.section-1')); ?></span>
                </a>
            </li>
            <li class="nav-item ps-4 mb-1">
                <a class="nav-link rounded <?php echo e(request()->is('admin/bannersection-2*') ? 'active' : ''); ?>"
                   aria-current="page" href="<?php echo e(URL::to('/admin/bannersection-2')); ?>">
                    <span class="d-flex align-items-center multimenu-menu-indicator"><i
                            class="fa-solid fa-circle-small"></i><?php echo e(trans('labels.section-2')); ?></span>
                </a>
            </li>
            <li class="nav-item ps-4 mb-1">
                <a class="nav-link rounded <?php echo e(request()->is('admin/bannersection-3*') ? 'active' : ''); ?>"
                   aria-current="page" href="<?php echo e(URL::to('/admin/bannersection-3')); ?>">
                    <span class="d-flex align-items-center multimenu-menu-indicator"><i
                            class="fa-solid fa-circle-small"></i><?php echo e(trans('labels.section-3')); ?></span>
                </a>
            </li>
            <li class="nav-item ps-4 mb-1">
                <a class="nav-link rounded <?php echo e(request()->is('admin/bannersection-4*') ? 'active' : ''); ?>"
                   aria-current="page" href="<?php echo e(URL::to('/admin/bannersection-4')); ?>">
                    <span class="d-flex align-items-center multimenu-menu-indicator"><i
                            class="fa-solid fa-circle-small"></i><?php echo e(trans('labels.section-4')); ?></span>
                </a>
            </li>
        </ul>
    </li>
    <?php if(@helper::checkaddons('coupon')): ?>
        <li class="nav-item mb-2 fs-7 <?php echo e(Auth::user()->type != 1 ? (in_array('5', $modules) == true ? '' : 'd-none') : ''); ?>"
            id="5">
            <a class="nav-link rounded d-flex <?php echo e(request()->is('admin/promocode*') ? 'active' : ''); ?>"
               href="<?php echo e(URL::to('/admin/promocode')); ?>" aria-expanded="false">
                <i class="fa-solid fa-tags"></i>
                <div class="w-100 d-flex justify-content-between align-items-center">
                    <?php echo e(trans('labels.promocodes')); ?>

                    <?php if(env('Environment') == 'sendbox'): ?>
                        <small class="badge bg-danger"><?php echo e(trans('labels.addon')); ?></small>
                    <?php endif; ?>
                </div>
            </a>
        </li>
    <?php endif; ?>
    <?php if(@helper::checkaddons('firebase_notification')): ?>
        <li class="nav-item mb-2 fs-7 <?php echo e(Auth::user()->type != 1 ? (in_array('6', $modules) == true ? '' : 'd-none') : ''); ?>"
            id="6">
            <a class="nav-link rounded d-flex <?php echo e(request()->is('admin/notification*') ? 'active' : ''); ?>"
               href="<?php echo e(URL::to('/admin/notification')); ?>" aria-expanded="false">
                <i class="fa-solid fa-bell"></i>
                <div class="w-100 d-flex justify-content-between align-items-center">
                    <?php echo e(trans('labels.notification')); ?>

                    <?php if(env('Environment') == 'sendbox'): ?>
                        <small class="badge bg-danger"><?php echo e(trans('labels.addon')); ?></small>
                    <?php endif; ?>
                </div>
            </a>
        </li>
    <?php endif; ?>
    <?php if(@helper::checkaddons('top_deals')): ?>
        <li class="nav-item mb-2 fs-7 <?php echo e(Auth::user()->type != 1 ? (in_array('33', $modules) == true ? '' : 'd-none') : ''); ?>"
            id="33">
            <a class="nav-link rounded d-flex <?php echo e(request()->is('admin/top_deals*') ? 'active' : ''); ?>"
               href="<?php echo e(URL::to('/admin/top_deals')); ?>" aria-expanded="false">
                <i class="fa-solid fa-bell"></i>
                <div class="w-100 d-flex justify-content-between align-items-center">
                    <?php echo e(trans('labels.top_deals')); ?>

                    <?php if(env('Environment') == 'sendbox'): ?>
                        <small class="badge bg-danger"><?php echo e(trans('labels.addon')); ?></small>
                    <?php endif; ?>
                </div>
            </a>
        </li>
    <?php endif; ?>
    <?php if(Auth::user()->type != 1): ?>
        <?php if(in_array('7', $modules) || in_array('8', $modules) || in_array('9', $modules) || in_array('10', $modules)): ?>
            <li class="nav-item mt-3">
                <h6 class="text-muted mb-2 fs-7 text-uppercase"><?php echo e(trans('labels.product_management')); ?></h6>
            </li>
        <?php endif; ?>
    <?php else: ?>
        <li class="nav-item mt-3">
            <h6 class="text-muted mb-2 fs-7 text-uppercase"><?php echo e(trans('labels.product_management')); ?></h6>
        </li>
    <?php endif; ?>
    <li class="nav-item mb-2 fs-7 <?php echo e(Auth::user()->type != 1 ? (in_array('7', $modules) == true ? '' : 'd-none') : ''); ?>"
        id="7">
        <a class="nav-link rounded d-flex <?php echo e(request()->is('admin/category*') ? 'active' : ''); ?>"
           href="<?php echo e(URL::to('/admin/category')); ?>" aria-expanded="false">
            <i class="fa-sharp fa-solid fa-list"></i><span class="nav-text "><?php echo e(trans('labels.categories')); ?></span>
        </a>
    </li>
    <li class="nav-item mb-2 fs-7 <?php echo e(Auth::user()->type != 1 ? (in_array('8', $modules) == true ? '' : 'd-none') : ''); ?>"
        id="8">
        <a class="nav-link rounded d-flex <?php echo e(request()->is('admin/sub-category*') ? 'active' : ''); ?>"
           href="<?php echo e(URL::to('/admin/sub-category')); ?>" aria-expanded="false">
            <i class="fa-solid fa-list-tree"></i><span class="nav-text "><?php echo e(trans('labels.subcategories')); ?></span>
        </a>
    </li>
    
    
    
    
    
    
    
    
    <li class="nav-item mb-2 fs-7 <?php echo e(Auth::user()->type != 1 ? (in_array('30', $modules) == true ? '' : 'd-none') : ''); ?>"
        id="30">
        <a class="nav-link rounded d-flex <?php echo e(request()->is('admin/tax*') ? 'active' : ''); ?>"
           href="<?php echo e(URL::to('/admin/tax')); ?>" aria-expanded="false">
            <i class="fa-solid fa-list-timeline"></i><span class="nav-text "><?php echo e(trans('labels.tax')); ?></span>
        </a>
    </li>
    <li class="nav-item mb-2 fs-7 <?php echo e(Auth::user()->type != 1 ? (in_array('31', $modules) == true ? '' : 'd-none') : ''); ?>"
        id="31">
        <a class="nav-link rounded d-flex <?php echo e(request()->is('admin/global_extras*') ? 'active' : ''); ?>"
           href="<?php echo e(URL::to('/admin/global_extras')); ?>" aria-expanded="false">
            <i class="fa-solid fa-list-timeline"></i><span
                class="nav-text "><?php echo e(trans('labels.global_extras')); ?></span>
        </a>
    </li>
    <li class="nav-item mb-2 fs-7 <?php echo e(Auth::user()->type != 1 ? (in_array('9', $modules) == true ? '' : 'd-none') : ''); ?>"
        id="9">
        <a class="nav-link rounded d-flex <?php echo e(request()->is('admin/addongroup*') ? 'active' : ''); ?>"
           href="<?php echo e(URL::to('/admin/addongroup')); ?>" aria-expanded="false">
            <i class="fa-solid fa-plus-minus"></i><span class="nav-text "><?php echo e(trans('labels.addons_group')); ?></span>
        </a>
    </li>
    <li class="nav-item mb-2 fs-7 <?php echo e(Auth::user()->type != 1 ? (in_array('9', $modules) == true ? '' : 'd-none') : ''); ?>"
        id="9">
        <a class="nav-link rounded d-flex <?php echo e(request()->is('admin/sides') ? 'active' : ''); ?>"
           href="<?php echo e(URL::to('/admin/dipping')); ?>" aria-expanded="false">
            <i class="fa-solid fa-plus-minus"></i><span class="nav-text ">Dipping</span>
        </a>
    </li>
    <li class="nav-item mb-2 fs-7 <?php echo e(Auth::user()->type != 1 ? (in_array('10', $modules) == true ? '' : 'd-none') : ''); ?>"
        id="10">
        <a class="nav-link rounded d-flex <?php echo e(request()->is('admin/item*') ? 'active' : ''); ?>"
           href="<?php echo e(URL::to('/admin/item')); ?>" aria-expanded="false">
            <i class="fa-solid fa-list-timeline"></i><span class="nav-text "><?php echo e(trans('labels.items')); ?></span>
        </a>
    </li>
    <li class="nav-item mb-2 fs-7 <?php echo e(Auth::user()->type != 1 ? (in_array('10', $modules) == true ? '' : 'd-none') : ''); ?>"
        id="10">
        <a class="nav-link rounded d-flex <?php echo e(request()->is('admin/custom_pizza*') ? 'active' : ''); ?>"
           href="<?php echo e(URL::to('/admin/custom_pizza')); ?>" aria-expanded="false">
            <i class="fa-solid fa-list-timeline"></i><span class="nav-text ">Custom Pizza</span>
        </a>
    </li>
    <?php if(@helper::checkaddons('product_review')): ?>
        <li class="nav-item mb-2 fs-7 <?php echo e(Auth::user()->type != 1 ? (in_array('29', $modules) == true ? '' : 'd-none') : ''); ?>"
            id="29">
            <a class="nav-link rounded d-flex <?php echo e(request()->is('admin/reviews*') ? 'active' : ''); ?>"
               href="<?php echo e(URL::to('/admin/reviews')); ?>" aria-expanded="false">
                <i class="fa-solid fa-star"></i><span class="nav-text "><?php echo e(trans('labels.product_reviews')); ?></span>
            </a>
        </li>
    <?php endif; ?>
    <li class="nav-item mt-3">
        <h6 class="text-muted mb-2 fs-7 text-uppercase"><?php echo e(trans('labels.restaurant_management')); ?></h6>
    </li>
    <li class="nav-item mb-2 fs-7 "
        id="11">
        <a class="nav-link rounded d-flex <?php echo e(request()->is('admin/branches*') ? 'active' : ''); ?>"
           href="<?php echo e(URL::to('/admin/branches')); ?>" aria-expanded="false">
            <i class="fa-solid fa-list-timeline"></i><span
                class="nav-text ">Branches</span>
        </a>
    </li>
    <li class="nav-item mb-2 fs-7 <?php echo e(Auth::user()->type != 1 ? (in_array('11', $modules) == true ? '' : 'd-none') : ''); ?>"
        id="11">
        <a class="nav-link rounded d-flex <?php echo e(request()->is('admin/shippingarea*') ? 'active' : ''); ?>"
           href="<?php echo e(URL::to('/admin/shippingarea')); ?>" aria-expanded="false">
            <i class="fa-solid fa-list-timeline"></i><span
                class="nav-text "><?php echo e(trans('labels.shippingarea')); ?></span>
        </a>
    </li>

    
    <li class="nav-item mb-2 fs-7 <?php echo e(Auth::user()->type != 1 ? (in_array('12', $modules) == true ? '' : 'd-none') : ''); ?>"
        id="12">
        <a class="nav-link rounded d-flex <?php echo e(request()->is('admin/time*') ? 'active' : ''); ?>"
           href="<?php echo e(URL::to('/admin/time')); ?>" aria-expanded="false">
            <i class="fa-solid fa-business-time"></i><span
                class="nav-text "><?php echo e(trans('labels.working_hours')); ?></span>
        </a>
    </li>
    <li class="nav-item mb-2 fs-7 <?php echo e(Auth::user()->type != 1 ? (in_array('13', $modules) == true ? '' : 'd-none') : ''); ?>"
        id="13">
        <a class="nav-link rounded d-flex <?php echo e(request()->is('admin/payment*') ? 'active' : ''); ?>"
           href="<?php echo e(URL::to('/admin/payment')); ?>" aria-expanded="false">
            <i class="fa-solid fa-money-check-dollar-pen"></i><span
                class="nav-text "><?php echo e(trans('labels.payment_methods')); ?></span>
        </a>
    </li>
    <?php if(Auth::user()->type != 1): ?>
        <?php if(in_array('17', $modules) || in_array('18', $modules)): ?>
            <li class="nav-item mt-3">
                <h6 class="text-muted mb-2 fs-7 text-uppercase"><?php echo e(trans('labels.user_management')); ?></h6>
            </li>
        <?php endif; ?>
    <?php else: ?>
        <li class="nav-item mt-3">
            <h6 class="text-muted mb-2 fs-7 text-uppercase"><?php echo e(trans('labels.user_management')); ?></h6>
        </li>
    <?php endif; ?>
    <li class="nav-item mb-2 fs-7 <?php echo e(Auth::user()->type != 1 ? (in_array('17', $modules) == true ? '' : 'd-none') : ''); ?>"
        id="17">
        <a class="nav-link rounded d-flex <?php echo e(request()->is('admin/users*') ? 'active' : ''); ?>"
           href="<?php echo e(URL::to('/admin/users')); ?>" aria-expanded="false">
            <i class="fa-solid fa-users"></i><span class="nav-text "><?php echo e(trans('labels.customers')); ?></span>
        </a>
    </li>

    <?php if(Auth::user()->type != 1): ?>
        <?php if(in_array('21', $modules) || in_array('22', $modules) || in_array('23', $modules) || in_array('24', $modules)): ?>
            <li class="nav-item mt-3">
                <h6 class="text-muted mb-2 fs-7 text-uppercase"><?php echo e(trans('labels.system_settings')); ?></h6>
            </li>
        <?php endif; ?>
    <?php else: ?>
        <li class="nav-item mt-3">
            <h6 class="text-muted mb-2 fs-7 text-uppercase"><?php echo e(trans('labels.system_settings')); ?></h6>
        </li>
    <?php endif; ?>
    <li class="nav-item mb-2 fs-7 dropdown multimenu <?php echo e(Auth::user()->type != 1 ? (in_array('21', $modules) == true ? '' : 'd-none') : ''); ?>"
        id="21">
        <a class="nav-link collapsed rounded d-flex align-items-center justify-content-between dropdown-toggle mb-1"
           href="#pages" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="pages">
            <span class="d-flex"><i class="fa-solid fa-list-tree"></i><span
                    class="multimenu-title"><?php echo e(trans('labels.pages')); ?></span></span>
        </a>

        <ul class="collapse" id="pages">
            <li class="nav-item ps-4 mb-1">
                <a class="nav-link rounded <?php echo e(request()->is('admin/privacypolicy*') ? 'active' : ''); ?>"
                   aria-current="page" href="<?php echo e(URL::to('/admin/privacypolicy')); ?>">
                    <span class="d-flex align-items-center multimenu-menu-indicator"><i
                            class="fa-solid fa-circle-small"></i><?php echo e(trans('labels.privacy_policy')); ?></span>
                </a>
            </li>
            <li class="nav-item ps-4 mb-1">
                <a class="nav-link rounded <?php echo e(request()->is('admin/refundpolicy*') ? 'active' : ''); ?>"
                   aria-current="page" href="<?php echo e(URL::to('/admin/refundpolicy')); ?>">
                    <span class="d-flex align-items-center multimenu-menu-indicator"><i
                            class="fa-solid fa-circle-small"></i><?php echo e(trans('labels.refund_policy')); ?></span>
                </a>
            </li>
            <li class="nav-item ps-4 mb-1">
                <a class="nav-link rounded <?php echo e(request()->is('admin/termscondition*') ? 'active' : ''); ?>"
                   aria-current="page" href="<?php echo e(URL::to('/admin/termscondition')); ?>">
                    <span class="d-flex align-items-center multimenu-menu-indicator"><i
                            class="fa-solid fa-circle-small"></i><?php echo e(trans('labels.terms_conditions')); ?></span>
                </a>
            </li>
            <li class="nav-item ps-4 mb-1">
                <a class="nav-link rounded <?php echo e(request()->is('admin/aboutus*') ? 'active' : ''); ?>"
                   aria-current="page" href="<?php echo e(URL::to('/admin/aboutus')); ?>">
                    <span class="d-flex align-items-center multimenu-menu-indicator"><i
                            class="fa-solid fa-circle-small"></i><?php echo e(trans('labels.about_us')); ?></span>
                </a>
            </li>
            <?php if(@helper::checkaddons('blog')): ?>
                <li class="nav-item ps-4 mb-1">
                    <a class="nav-link rounded <?php echo e(request()->is('admin/blogs*') ? 'active' : ''); ?>"
                       aria-current="page" href="<?php echo e(URL::to('/admin/blogs')); ?>">
                        <span class="d-flex align-items-center multimenu-menu-indicator">
                            <i class="fa-solid fa-circle-small"></i>
                            <div class="w-100 d-flex justify-content-between align-items-center">
                                <?php echo e(trans('labels.blogs')); ?>

                                <?php if(env('Environment') == 'sendbox'): ?>
                                    <small class="badge bg-danger ms-1"><?php echo e(trans('labels.addon')); ?></small>
                                <?php endif; ?>
                            </div>
                        </span>
                    </a>
                </li>
            <?php endif; ?>
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            <li class="nav-item ps-4 mb-1">
                <a class="nav-link rounded <?php echo e(request()->is('admin/faq*') ? 'active' : ''); ?>" aria-current="page"
                   href="<?php echo e(URL::to('/admin/faq')); ?>">
                    <span class="d-flex align-items-center multimenu-menu-indicator"><i
                            class="fa-solid fa-circle-small"></i><?php echo e(trans('labels.faq')); ?></span>
                </a>
            </li>

            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            


            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
        </ul>

    </li>
    <li class="nav-item mb-2 fs-7 <?php echo e(Auth::user()->type != 1 ? (in_array('22', $modules) == true ? '' : 'd-none') : ''); ?>"
        id="22">
        <a class="nav-link rounded d-flex <?php echo e(request()->is('admin/settings*') ? 'active' : ''); ?>"
           href="<?php echo e(URL::to('/admin/settings')); ?>" aria-expanded="false">
            <i class="fa-solid fa-gears"></i><span
                class="nav-text "><?php echo e(trans('labels.general_settings')); ?></span>
        </a>
    </li>
</ul>
<?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/theme/sidebarcontent.blade.php ENDPATH**/ ?>