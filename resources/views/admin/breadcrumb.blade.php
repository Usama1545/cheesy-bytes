<div class="row page-titles mx-0 mb-3">
    <div class="d-flex justify-content-between align-items-center">
        <ol class="breadcrumb mb-0">
            @if (request()->is('admin/home'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/home') }}">{{ trans('labels.welcome_to_restaurant') }}</a>
                </li>
            @endif
            @if (request()->is('admin/bookings'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('admin/bookings') }}">{{ trans('labels.bookings') }}</a>
                </li>
            @endif
            @if (request()->is('admin/slider'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('admin/slider') }}">{{ trans('labels.sliders') }}</a>
                </li>
            @endif
            @if (request()->is('admin/category'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('admin/category') }}">{{ trans('labels.categories') }}</a>
                </li>
            @endif
            @if (request()->is('admin/sub-category'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('admin/sub-category') }}">{{ trans('labels.subcategories') }}</a>
                </li>
            @endif
            @if (request()->is('admin/shippingarea'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('admin/shippingarea') }}">{{ trans('labels.shippingarea') }}</a>
                </li>
            @endif
            @if (request()->is('admin/tax'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('admin/tax') }}">{{ trans('labels.tax') }}</a>
                </li>
            @endif
            @if (request()->is('admin/global_extras'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('admin/global_extras') }}">{{ trans('labels.global_extras') }}</a>
                </li>
            @endif
            @if (request()->is('admin/addongroup'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('admin/addongroup') }}">{{ trans('labels.addons_group') }}</a>
                </li>
            @endif
            @if (request()->is('admin/addons'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('admin/addongroup') }}">{{ trans('labels.addons') }}</a>
                </li>
            @endif
            @if (request()->is('admin/banner'))
                <li class="breadcrumb-item">
                    <a href="{{ @$table_url }}">{{ @$title }}</a>
                </li>
            @endif
            @if (request()->is('admin/subscribe'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('admin/subscribe') }}">{{ trans('labels.subscribe') }}</a>
                </li>
            @endif
            @if (request()->is('admin/promocode'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('admin/promocode') }}">{{ trans('labels.promocodes') }}</a>
                </li>
            @endif
            @if (request()->is('admin/time'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('admin/time') }}">{{ trans('labels.working_hours') }}</a>
                </li>
            @endif
            @if (request()->is('admin/payment'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('admin/payment') }}">{{ trans('labels.payment_methods') }}</a>
                </li>
            @endif
            @if (request()->is('admin/orders'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('admin/orders') }}">{{ trans('labels.orders') }}</a>
                </li>
            @endif
            @if (request()->is('admin/invoice'))
                <li class="breadcrumb-item">
                    <a href="{{ request()->url() }}">{{ trans('labels.invoice') }}</a>
                </li>
            @endif
            @if (request()->is('admin/reviews'))
                <li class="breadcrumb-item">
                    <a href="{{ request()->url() }}">{{ trans('labels.product_reviews') }}</a>
                </li>
            @endif
            @if (request()->is('admin/store-review'))
                <li class="breadcrumb-item">
                    <a href="{{ request()->url() }}">{{ trans('labels.store_reviews') }}</a>
                </li>
            @endif
            @if (request()->is('admin/report'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('admin/report') }}">{{ trans('labels.report') }}</a>
                </li>
            @endif
            @if (request()->is('admin/notification'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('admin/notification') }}">{{ trans('labels.notification') }}</a>
                </li>
            @endif
            @if (request()->is('admin/top_deals'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('admin/top_deals') }}">{{ trans('labels.top_deals') }}</a>
                </li>
            @endif
            @if (request()->is('admin/contact'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('admin/contact') }}">{{ trans('labels.inquiries') }}</a>
                </li>
            @endif
            @if (request()->is('admin/driver')||request()->is('admin/driver/details-*'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('admin/driver') }}">{{ trans('labels.drivers') }}</a>
                </li>
            @endif
            @if (request()->is('admin/users'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('admin/users') }}">{{ trans('labels.customers') }}</a>
                </li>
            @endif
            @if (request()->is('admin/privacypolicy'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('admin/privacypolicy') }}">{{ trans('labels.privacy_policy') }}</a>
                </li>
            @endif
            @if (request()->is('admin/refundpolicy'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('admin/refundpolicy') }}">{{ trans('labels.refund_policy') }}</a>
                </li>
            @endif
            @if (request()->is('admin/termscondition'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('admin/termscondition') }}">{{ trans('labels.terms_conditions') }}</a>
                </li>
            @endif
            @if (request()->is('admin/aboutus'))
                <li class="breadcrumb-item">
                    <a class="text-dark" href="{{ URL::to('admin/aboutus') }}">{{ trans('labels.about_us') }}</a>
                </li>
            @endif
            @if (request()->is('admin/blogs'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('admin/blogs') }}">{{ trans('labels.blogs') }}</a>
                </li>
            @endif
            @if (request()->is('admin/our-team'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('admin/our-team') }}">{{ trans('labels.our_team') }}</a>
                </li>
            @endif
            @if (request()->is('admin/choose_us'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('admin/choose_us') }}">{{ trans('labels.why_choose_us') }}</a>
                </li>
            @endif
            @if (request()->is('admin/tutorial'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('admin/tutorial') }}">{{ trans('labels.tutorial') }}</a>
                </li>
            @endif
            @if (request()->is('admin/faq'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('admin/faq') }}">{{ trans('labels.faq') }}</a>
                </li>
            @endif
            @if (request()->is('admin/custom_status'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('admin/custom_status') }}">{{ trans('labels.custom_status') }}</a>
                </li>
            @endif
            @if (request()->is('admin/gallery'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('admin/gallery') }}">{{ trans('labels.gallery') }}</a>
                </li>
            @endif
            @if (request()->is('admin/settings'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('admin/settings') }}">{{ trans('labels.general_settings') }}</a>
                </li>
            @endif
            @if (request()->is('admin/roles'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('admin/roles') }}">{{ trans('labels.employee_role') }}</a>
                </li>
            @endif
            @if (request()->is('admin/employee'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('admin/employee') }}">{{ trans('labels.employee') }}</a>
                </li>
            @endif
            @if (request()->is('admin/item'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('admin/item') }}">{{ trans('labels.items') }}</a>
                </li>
            @endif
            @if (request()->is('admin/item/import'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('admin/item/import') }}">{{ trans('labels.import') }}</a>
                </li>
            @endif
            {{-- common-for-add-update-title --}}
            @if (substr(request()->url(), strrpos(request()->url(), '/') + 1) == 'add')
                <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('labels.add_new') }}</a>
                </li>
            @endif
            @if (request()->is('admin/slider-*') ||
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
                    request()->is('admin/item-*'))
                <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('labels.update') }}</a>
                </li>
            @endif
        </ol>
        {{-- ADD BUTTON --}}
        @if (request()->is('admin/bannersection-1') ||
                request()->is('admin/bannersection-2') ||
                request()->is('admin/bannersection-3') ||
                request()->is('admin/bannersection-4'))
            <a href="{{ @$add_url }}" class="btn btn-primary"><i class="fa-regular fa-plus"></i> {{ trans('labels.add_new') }}</a>
        @endif
        @if (request()->is('admin/slider') ||
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
                request()->is('admin/zone'))
            <a href="{{ request()->url() . '/add' }}" class="btn btn-primary"><i class="fa-regular fa-plus"></i> {{ trans('labels.add_new') }}</a>
        @endif
        @if (@helper::checkaddons('custom_status'))
            @if (request()->is('admin/custom_status'))
                <a href="{{ request()->url() . '/add' }}" class="btn btn-primary"><i class="fa-regular fa-plus"></i> {{ trans('labels.add_new') }}</a>
            @endif
        @endif

    </div>
</div>
