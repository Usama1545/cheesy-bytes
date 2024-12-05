<div class="row page-titles mx-0 mb-3">
    <div class="d-flex justify-content-between align-items-center">
        <ol class="breadcrumb mb-0">
            <?php if(request()->is('admin/home')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(URL::to('/admin/home')); ?>"><?php echo e(trans('labels.welcome_to_restaurant')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/bookings')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(URL::to('admin/bookings')); ?>"><?php echo e(trans('labels.bookings')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/slider')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(URL::to('admin/slider')); ?>"><?php echo e(trans('labels.sliders')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/category')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(URL::to('admin/category')); ?>"><?php echo e(trans('labels.categories')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/sub-category')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(URL::to('admin/sub-category')); ?>"><?php echo e(trans('labels.subcategories')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/shippingarea')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(URL::to('admin/shippingarea')); ?>"><?php echo e(trans('labels.shippingarea')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/tax')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(URL::to('admin/tax')); ?>"><?php echo e(trans('labels.tax')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/global_extras')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(URL::to('admin/global_extras')); ?>"><?php echo e(trans('labels.global_extras')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/addongroup')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(URL::to('admin/addongroup')); ?>"><?php echo e(trans('labels.addons_group')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/addons')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(URL::to('admin/addongroup')); ?>"><?php echo e(trans('labels.addons')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/banner')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(@$table_url); ?>"><?php echo e(@$title); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/subscribe')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(URL::to('admin/subscribe')); ?>"><?php echo e(trans('labels.subscribe')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/promocode')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(URL::to('admin/promocode')); ?>"><?php echo e(trans('labels.promocodes')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/time')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(URL::to('admin/time')); ?>"><?php echo e(trans('labels.working_hours')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/payment')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(URL::to('admin/payment')); ?>"><?php echo e(trans('labels.payment_methods')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/orders')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(URL::to('admin/orders')); ?>"><?php echo e(trans('labels.orders')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/invoice')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(request()->url()); ?>"><?php echo e(trans('labels.invoice')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/reviews')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(request()->url()); ?>"><?php echo e(trans('labels.product_reviews')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/store-review')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(request()->url()); ?>"><?php echo e(trans('labels.store_reviews')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/report')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(URL::to('admin/report')); ?>"><?php echo e(trans('labels.report')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/notification')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(URL::to('admin/notification')); ?>"><?php echo e(trans('labels.notification')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/top_deals')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(URL::to('admin/top_deals')); ?>"><?php echo e(trans('labels.top_deals')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/contact')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(URL::to('admin/contact')); ?>"><?php echo e(trans('labels.inquiries')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/driver')||request()->is('admin/driver/details-*')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(URL::to('admin/driver')); ?>"><?php echo e(trans('labels.drivers')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/users')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(URL::to('admin/users')); ?>"><?php echo e(trans('labels.customers')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/privacypolicy')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(URL::to('admin/privacypolicy')); ?>"><?php echo e(trans('labels.privacy_policy')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/refundpolicy')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(URL::to('admin/refundpolicy')); ?>"><?php echo e(trans('labels.refund_policy')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/termscondition')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(URL::to('admin/termscondition')); ?>"><?php echo e(trans('labels.terms_conditions')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/aboutus')): ?>
                <li class="breadcrumb-item">
                    <a class="text-dark" href="<?php echo e(URL::to('admin/aboutus')); ?>"><?php echo e(trans('labels.about_us')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/blogs')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(URL::to('admin/blogs')); ?>"><?php echo e(trans('labels.blogs')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/our-team')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(URL::to('admin/our-team')); ?>"><?php echo e(trans('labels.our_team')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/choose_us')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(URL::to('admin/choose_us')); ?>"><?php echo e(trans('labels.why_choose_us')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/tutorial')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(URL::to('admin/tutorial')); ?>"><?php echo e(trans('labels.tutorial')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/faq')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(URL::to('admin/faq')); ?>"><?php echo e(trans('labels.faq')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/custom_status')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(URL::to('admin/custom_status')); ?>"><?php echo e(trans('labels.custom_status')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/gallery')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(URL::to('admin/gallery')); ?>"><?php echo e(trans('labels.gallery')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/settings')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(URL::to('admin/settings')); ?>"><?php echo e(trans('labels.general_settings')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/roles')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(URL::to('admin/roles')); ?>"><?php echo e(trans('labels.employee_role')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/employee')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(URL::to('admin/employee')); ?>"><?php echo e(trans('labels.employee')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/item')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(URL::to('admin/item')); ?>"><?php echo e(trans('labels.items')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/item/import')): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(URL::to('admin/item/import')); ?>"><?php echo e(trans('labels.import')); ?></a>
                </li>
            <?php endif; ?>
            
            <?php if(substr(request()->url(), strrpos(request()->url(), '/') + 1) == 'add'): ?>
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo e(trans('labels.add_new')); ?></a>
                </li>
            <?php endif; ?>
            <?php if(request()->is('admin/slider-*') ||
                    request()->is('admin/category-*') ||
                    request()->is('admin/sub-category-*') ||
                    request()->is('admin/addons-*') ||
                    request()->is('admin/addongroup-*') ||
                    request()->is('admin/global_extras-*') ||
                    request()->is('admin/tax-*') ||
                    request()->is('admin/shippingarea-*') ||
                    request()->is('admin/bannersection-*-*') ||
                    request()->is('admin/promocode-*') ||
                    request()->is('admin/driver-*') ||
                    request()->is('admin/users-*') ||
                    request()->is('admin/blogs-*') ||
                    request()->is('admin/our-team-*') ||
                    request()->is('admin/choose_us-*') ||
                    request()->is('admin/tutorial-*') ||
                    request()->is('admin/faq-*') ||
                    request()->is('admin/gallery-*') ||
                    request()->is('admin/custom_status-*') ||
                    request()->is('admin/roles-*') ||
                    request()->is('admin/employee-*') ||
                    request()->is('admin/store-review-*') ||
                    request()->is('admin/item-*')): ?>
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo e(trans('labels.update')); ?></a>
                </li>
            <?php endif; ?>
        </ol>
        
        <?php if(request()->is('admin/bannersection-1') ||
                request()->is('admin/bannersection-2') ||
                request()->is('admin/bannersection-3') ||
                request()->is('admin/bannersection-4')): ?>
            <a href="<?php echo e(@$add_url); ?>" class="btn btn-primary"><i class="fa-regular fa-plus"></i> <?php echo e(trans('labels.add_new')); ?></a>
        <?php endif; ?>
        <?php if(request()->is('admin/slider') ||
                request()->is('admin/addongroup') ||
                request()->is('admin/shippingarea') ||
                request()->is('admin/tax') ||
                request()->is('admin/global_extras') ||
                request()->is('admin/category') ||
                request()->is('admin/sub-category') ||
                request()->is('admin/promocode') ||
                request()->is('admin/driver') ||
                request()->is('admin/users') ||
                request()->is('admin/blogs') ||
                request()->is('admin/our-team') ||
                request()->is('admin/tutorial') ||
                request()->is('admin/faq') ||
                request()->is('admin/gallery') ||
                request()->is('admin/roles') ||
                request()->is('admin/employee') ||
                request()->is('admin/store-review') ||
                request()->is('admin/item') ||
                request()->is('admin/zone')): ?>
            <a href="<?php echo e(request()->url() . '/add'); ?>" class="btn btn-primary"><i class="fa-regular fa-plus"></i> <?php echo e(trans('labels.add_new')); ?></a>
        <?php endif; ?>
        <?php if(@helper::checkaddons('custom_status')): ?>
            <?php if(request()->is('admin/custom_status')): ?>
                <a href="<?php echo e(request()->url() . '/add'); ?>" class="btn btn-primary"><i class="fa-regular fa-plus"></i> <?php echo e(trans('labels.add_new')); ?></a>
            <?php endif; ?>
        <?php endif; ?>

    </div>
</div>
<?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/breadcrumb.blade.php ENDPATH**/ ?>