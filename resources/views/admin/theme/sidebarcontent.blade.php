@php $modules = explode(',',helper::get_roles()); @endphp
<ul class="navbar-nav">
    @if (Auth::user()->type == 1)
        <li class="nav-item mb-2 fs-7">
            <a class="nav-link rounded d-flex {{ request()->is('admin/home*') ? 'active' : '' }}"
                href="{{ URL::to('/admin/home') }}" aria-expanded="false">
                <i class="fa-solid fa-house-user"></i><span class="nav-text ">{{ trans('labels.dashboard') }}</span>
            </a>
        </li>
        <li class="nav-item mb-2 fs-7">
            <a class="nav-link rounded d-flex {{ request()->is('admin/mobile-home*') ? 'active' : '' }}"
                href="{{ URL::to('/admin/mobile-home') }}" aria-expanded="false">
                <i class="fa-solid fa-house-user"></i><span class="nav-text ">Mobile Dashboard</span>
            </a>
        </li>
    @endif
    {{--    <li class="nav-item mb-2 fs-7 {{ Auth::user()->type != 1 ? (in_array('23', $modules) == true ? '' : 'd-none') : '' }}" --}}
    {{--        id="23"> --}}
    {{--        <a class="nav-link rounded d-flex {{ request()->is('admin/systemaddons*') ? 'active' : '' }}" --}}
    {{--            href="{{ URL::to('/admin/systemaddons') }}" aria-expanded="false"> --}}
    {{--            <i class="fa fa-puzzle-piece"></i><span class="nav-text d-flex justify-content-between w-100">{{ trans('labels.addons_manager') }}</span> --}}
    {{--            <span class="rainbowText float-right mr-1 mt-1">Premium</span> --}}
    {{--        </a> --}}
    {{--    </li> --}}
    @if (@helper::checkaddons('pos'))
        @if (Auth::user()->type != 1)
            @if (in_array('25', $modules))
                <li class="nav-item mt-3">
                    <h6 class="text-muted mb-2 fs-7 text-uppercase">{{ trans('labels.pos_system') }}</h6>
                </li>
            @endif
        @else
            <li class="nav-item mt-3">
                <h6 class="text-muted mb-2 fs-7 text-uppercase">{{ trans('labels.pos_system') }}</h6>
            </li>
        @endif
        <li class="nav-item mb-2 fs-7 dropdown multimenu {{ Auth::user()->type != 1 ? (in_array('25', $modules) == true ? '' : 'd-none') : '' }}"
            id="25">
            <a class="nav-link collapsed rounded d-flex align-items-center justify-content-between dropdown-toggle mb-1"
                href="#pos" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="pos">
                <span class="d-flex"><i class="fa-solid fa-bag-shopping"></i>
                    <div class="w-100 gap-1 d-flex justify-content-between align-items-center">
                        {{ trans('labels.pos') }}
                        @if (env('Environment') == 'sendbox')
                            <small class="badge bg-danger">{{ trans('labels.addon') }}</small>
                        @endif
                    </div>
                </span>
            </a>
            <ul class="collapse" id="pos">
                <li class="nav-item ps-4 mb-1">
                    <a class="nav-link rounded {{ request()->is('admin/pos/items*') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/pos/items') }}">
                        <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                class="fa-solid fa-circle-small"></i>{{ trans('labels.items') }}</span>
                    </a>
                </li>
                <li class="nav-item ps-4 mb-1">
                    <a class="nav-link rounded {{ request()->is('admin/pos/orders*') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/pos/orders') }}">
                        <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                class="fa-solid fa-circle-small"></i>{{ trans('labels.orders') }}</span>
                    </a>
                </li>
            </ul>
        </li>
    @endif
    {{--    @if (@helper::checkaddons('otp')) --}}
    {{--        <li class="nav-item mb-2 fs-7 {{ Auth::user()->type != 1 ? (in_array('26', $modules) == true ? '' : 'd-none') : '' }}" --}}
    {{--            id="26"> --}}
    {{--            <a class="nav-link rounded d-flex {{ request()->is('admin/otp-configuration*') ? 'active' : '' }}" --}}
    {{--               href="{{ URL::to('/admin/otp-configuration') }}" aria-expanded="false"> --}}
    {{--                <i class="fa-solid fa-key-skeleton"></i> --}}
    {{--                <div class="w-100 d-flex justify-content-between align-items-center"> --}}
    {{--                    {{ trans('labels.otp_configuration') }} --}}
    {{--                    @if (env('Environment') == 'sendbox') --}}
    {{--                        <small class="badge bg-danger">{{ trans('labels.addon') }}</small> --}}
    {{--                    @endif --}}
    {{--                </div> --}}
    {{--            </a> --}}
    {{--        </li> --}}
    {{--    @endif --}}
    @if (Auth::user()->type != 1)
        @if (in_array('1', $modules) || in_array('2', $modules))
            <li class="nav-item mt-3">
                <h6 class="text-muted mb-2 fs-7 text-uppercase">{{ trans('labels.orders_management') }}</h6>
            </li>
        @endif
    @else
        <li class="nav-item mt-3">
            <h6 class="text-muted mb-2 fs-7 text-uppercase">{{ trans('labels.orders_management') }}</h6>
        </li>
    @endif
    <li class="nav-item mb-2 fs-7 {{ Auth::user()->type != 1 ? (in_array('1', $modules) == true ? '' : 'd-none') : '' }}"
        id="1">
        <a class="nav-link rounded d-flex {{ request()->is('admin/orders*') || request()->is('admin/invoice*') ? 'active' : '' }}"
            href="{{ URL::to('/admin/orders') }}" aria-expanded="false">
            <i class="fa-solid fa-cart-shopping"></i><span class="nav-text ">{{ trans('labels.orders') }}</span>
        </a>
    </li>
    <li class="nav-item mb-2 fs-7 {{ Auth::user()->type != 1 ? (in_array('15', $modules) == true ? '' : 'd-none') : '' }}"
        id="11">
        <a class="nav-link rounded d-flex {{ request()->is('admin/bookings*') ? 'active' : '' }}"
            href="{{ URL::to('/admin/bookings') }}" aria-expanded="false">
            <i class="fa-solid fa-table"></i>
            <span class="nav-text">Catering Bookings
                @if (@helper::getBookingCount() > 0)
                    <span class="badge bg-danger ms-2">{{ @helper::getBookingCount() }}</span>
                @endif
            </span>
        </a>

    </li>
    <li class="nav-item mb-2 fs-7 {{ Auth::user()->type != 1 ? (in_array('2', $modules) == true ? '' : 'd-none') : '' }}"
        id="2">
        <a class="nav-link rounded d-flex {{ request()->is('admin/report*') ? 'active' : '' }}"
            href="{{ URL::to('/admin/report') }}" aria-expanded="false">
            <i class="fa-solid fa-chart-mixed"></i><span class="nav-text ">{{ trans('labels.report') }}</span>
        </a>
    </li>
    @if (Auth::user()->type != 1)
        @if (in_array('3', $modules) || in_array('4', $modules) || in_array('5', $modules) || in_array('6', $modules))
            <li class="nav-item mt-3">
                <h6 class="text-muted mb-2 fs-7 text-uppercase">{{ trans('labels.promotions') }}</h6>
            </li>
        @endif
    @else
        <li class="nav-item mt-3">
            <h6 class="text-muted mb-2 fs-7 text-uppercase">{{ trans('labels.promotions') }}</h6>
        </li>
    @endif
    <li class="nav-item mb-2 fs-7 {{ Auth::user()->type != 1 ? (in_array('3', $modules) == true ? '' : 'd-none') : '' }}"
        id="3">
        <a class="nav-link rounded d-flex {{ request()->is('admin/slider*') ? 'active' : '' }}"
            href="{{ URL::to('/admin/slider') }}" aria-expanded="false">
            <i class="fa-solid fa-images"></i><span class="nav-text ">{{ trans('labels.sliders') }}</span>
        </a>
    </li>
    <li class="nav-item mb-2 fs-7 dropdown multimenu {{ Auth::user()->type != 1 ? (in_array('4', $modules) == true ? '' : 'd-none') : '' }}"
        id="4">
        <a class="nav-link collapsed rounded d-flex align-items-center justify-content-between dropdown-toggle mb-1"
            href="#banners" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="banners">
            <span class="d-flex"><i class="fa-solid fa-list-tree"></i><span
                    class="multimenu-title">{{ trans('labels.banners') }}</span></span>
        </a>
        <ul class="collapse" id="banners">
            <li class="nav-item ps-4 mb-1">
                <a class="nav-link rounded {{ request()->is('admin/bannersection-1*') ? 'active' : '' }}"
                    aria-current="page" href="{{ URL::to('/admin/bannersection-1') }}">
                    <span class="d-flex align-items-center multimenu-menu-indicator"><i
                            class="fa-solid fa-circle-small"></i>{{ trans('labels.section-1') }}</span>
                </a>
            </li>
            {{--            <li class="nav-item ps-4 mb-1"> --}}
            {{--                <a class="nav-link rounded {{ request()->is('admin/bannersection-2*') ? 'active' : '' }}" --}}
            {{--                   aria-current="page" href="{{ URL::to('/admin/bannersection-2') }}"> --}}
            {{--                    <span class="d-flex align-items-center multimenu-menu-indicator"><i --}}
            {{--                            class="fa-solid fa-circle-small"></i>{{ trans('labels.section-2') }}</span> --}}
            {{--                </a> --}}
            {{--            </li> --}}
            {{--            <li class="nav-item ps-4 mb-1"> --}}
            {{--                <a class="nav-link rounded {{ request()->is('admin/bannersection-3*') ? 'active' : '' }}" --}}
            {{--                   aria-current="page" href="{{ URL::to('/admin/bannersection-3') }}"> --}}
            {{--                    <span class="d-flex align-items-center multimenu-menu-indicator"><i --}}
            {{--                            class="fa-solid fa-circle-small"></i>{{ trans('labels.section-3') }}</span> --}}
            {{--                </a> --}}
            {{--            </li> --}}
            {{--            <li class="nav-item ps-4 mb-1"> --}}
            {{--                <a class="nav-link rounded {{ request()->is('admin/bannersection-4*') ? 'active' : '' }}" --}}
            {{--                   aria-current="page" href="{{ URL::to('/admin/bannersection-4') }}"> --}}
            {{--                    <span class="d-flex align-items-center multimenu-menu-indicator"><i --}}
            {{--                            class="fa-solid fa-circle-small"></i>{{ trans('labels.section-4') }}</span> --}}
            {{--                </a> --}}
            {{--            </li> --}}
        </ul>
    </li>
    @if (@helper::checkaddons('coupon'))
        <li class="nav-item mb-2 fs-7 {{ Auth::user()->type != 1 ? (in_array('5', $modules) == true ? '' : 'd-none') : '' }}"
            id="5">
            <a class="nav-link rounded d-flex {{ request()->is('admin/promocode*') ? 'active' : '' }}"
                href="{{ URL::to('/admin/promocode') }}" aria-expanded="false">
                <i class="fa-solid fa-tags"></i>
                <div class="w-100 d-flex justify-content-between align-items-center">
                    {{ trans('labels.promocodes') }}
                    @if (env('Environment') == 'sendbox')
                        <small class="badge bg-danger">{{ trans('labels.addon') }}</small>
                    @endif
                </div>
            </a>
        </li>
    @endif
    @if (@helper::checkaddons('firebase_notification'))
        <li class="nav-item mb-2 fs-7 {{ Auth::user()->type != 1 ? (in_array('6', $modules) == true ? '' : 'd-none') : '' }}"
            id="6">
            <a class="nav-link rounded d-flex {{ request()->is('admin/notification*') ? 'active' : '' }}"
                href="{{ URL::to('/admin/notification') }}" aria-expanded="false">
                <i class="fa-solid fa-bell"></i>
                <div class="w-100 d-flex justify-content-between align-items-center">
                    {{ trans('labels.notification') }}
                    @if (env('Environment') == 'sendbox')
                        <small class="badge bg-danger">{{ trans('labels.addon') }}</small>
                    @endif
                </div>
            </a>
        </li>
    @endif
    @if (@helper::checkaddons('top_deals'))
        <li class="nav-item mb-2 fs-7 {{ Auth::user()->type != 1 ? (in_array('33', $modules) == true ? '' : 'd-none') : '' }}"
            id="33">
            <a class="nav-link rounded d-flex {{ request()->is('admin/top_deals*') ? 'active' : '' }}"
                href="{{ URL::to('/admin/top_deals') }}" aria-expanded="false">
                <i class="fa-solid fa-bell"></i>
                <div class="w-100 d-flex justify-content-between align-items-center">
                    {{ trans('labels.top_deals') }}
                    @if (env('Environment') == 'sendbox')
                        <small class="badge bg-danger">{{ trans('labels.addon') }}</small>
                    @endif
                </div>
            </a>
        </li>
    @endif
    @if (Auth::user()->type != 1)
        @if (in_array('7', $modules) || in_array('8', $modules) || in_array('9', $modules) || in_array('10', $modules))
            <li class="nav-item mt-3">
                <h6 class="text-muted mb-2 fs-7 text-uppercase">{{ trans('labels.product_management') }}</h6>
            </li>
        @endif
    @else
        <li class="nav-item mt-3">
            <h6 class="text-muted mb-2 fs-7 text-uppercase">{{ trans('labels.product_management') }}</h6>
        </li>
    @endif
    <li class="nav-item mb-2 fs-7 {{ Auth::user()->type != 1 ? (in_array('7', $modules) == true ? '' : 'd-none') : '' }}"
        id="7">
        <a class="nav-link rounded d-flex {{ request()->is('admin/category*') ? 'active' : '' }}"
            href="{{ URL::to('/admin/category') }}" aria-expanded="false">
            <i class="fa-sharp fa-solid fa-list"></i><span class="nav-text ">{{ trans('labels.categories') }}</span>
        </a>
    </li>
    <li class="nav-item mb-2 fs-7 {{ Auth::user()->type != 1 ? (in_array('8', $modules) == true ? '' : 'd-none') : '' }}"
        id="8">
        <a class="nav-link rounded d-flex {{ request()->is('admin/sub-category*') ? 'active' : '' }}"
            href="{{ URL::to('/admin/sub-category') }}" aria-expanded="false">
            <i class="fa-solid fa-list-tree"></i><span class="nav-text ">{{ trans('labels.subcategories') }}</span>
        </a>
    </li>
    {{--    <li class="nav-item mb-2 fs-7 {{ Auth::user()->type != 1 ? (in_array('11', $modules) == true ? '' : 'd-none') : '' }}" --}}
    {{--        id="11"> --}}
    {{--        <a class="nav-link rounded d-flex {{ request()->is('admin/shippingarea*') ? 'active' : '' }}" --}}
    {{--           href="{{ URL::to('/admin/shippingarea') }}" aria-expanded="false"> --}}
    {{--            <i class="fa-solid fa-list-timeline"></i><span --}}
    {{--                class="nav-text ">{{ trans('labels.shippingarea') }}</span> --}}
    {{--        </a> --}}
    {{--    </li> --}}
    <li class="nav-item mb-2 fs-7 {{ Auth::user()->type != 1 ? (in_array('30', $modules) == true ? '' : 'd-none') : '' }}"
        id="30">
        <a class="nav-link rounded d-flex {{ request()->is('admin/tax*') ? 'active' : '' }}"
            href="{{ URL::to('/admin/tax') }}" aria-expanded="false">
            <i class="fa-solid fa-list-timeline"></i><span class="nav-text ">{{ trans('labels.tax') }}</span>
        </a>
    </li>
    <li class="nav-item mb-2 fs-7 {{ Auth::user()->type != 1 ? (in_array('31', $modules) == true ? '' : 'd-none') : '' }}"
        id="31">
        <a class="nav-link rounded d-flex {{ request()->is('admin/global_extras*') ? 'active' : '' }}"
            href="{{ URL::to('/admin/global_extras') }}" aria-expanded="false">
            <i class="fa-solid fa-list-timeline"></i><span
                class="nav-text ">{{ trans('labels.global_extras') }}</span>
        </a>
    </li>
    <li class="nav-item mb-2 fs-7 {{ Auth::user()->type != 1 ? (in_array('9', $modules) == true ? '' : 'd-none') : '' }}"
        id="9">
        <a class="nav-link rounded d-flex {{ request()->is('admin/addongroup*') ? 'active' : '' }}"
            href="{{ URL::to('/admin/addongroup') }}" aria-expanded="false">
            <i class="fa-solid fa-plus-minus"></i><span class="nav-text ">{{ trans('labels.addons_group') }}</span>
        </a>
    </li>
    <li class="nav-item mb-2 fs-7 {{ Auth::user()->type != 1 ? (in_array('9', $modules) == true ? '' : 'd-none') : '' }}"
        id="9">
        <a class="nav-link rounded d-flex {{ request()->is('admin/sides') ? 'active' : '' }}"
            href="{{ URL::to('/admin/dipping') }}" aria-expanded="false">
            <i class="fa-solid fa-plus-minus"></i><span class="nav-text ">Dipping</span>
        </a>
    </li>
    <li class="nav-item mb-2 fs-7 {{ Auth::user()->type != 1 ? (in_array('10', $modules) == true ? '' : 'd-none') : '' }}"
        id="10">
        <a class="nav-link rounded d-flex {{ request()->is('admin/item*') ? 'active' : '' }}"
            href="{{ URL::to('/admin/item') }}" aria-expanded="false">
            <i class="fa-solid fa-list-timeline"></i><span class="nav-text ">{{ trans('labels.items') }}</span>
        </a>
    </li>

    <li class="nav-item mb-2 fs-7 dropdown multimenu" id="4">
        <a class="nav-link collapsed rounded {{ Auth::user()->type != 1 ? (in_array('10', $modules) == true ? '' : 'd-none') : '' }} d-flex align-items-center justify-content-between dropdown-toggle mb-1"
            href="#deals" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="deals">
            <span class="d-flex"><i class="fa-solid fa-badge-percent"></i><span
                    class="multimenu-title">Deals</span></span>
        </a>
        <ul class="collapse" id="deals">
            <li class="nav-item ps-4" id="10">
                <a class="nav-link rounded d-flex {{ request()->is('admin/topDeals*') ? 'active' : '' }}"
                    href="{{ URL::to('/admin/topDeals') }}" aria-expanded="false">
                    <i class="fa-solid fa-circle-small"></i><span class="nav-text ">Flat Deals</span>
                </a>
            </li>
            <li class="nav-item ps-4" id="10">
                <a class="nav-link rounded d-flex {{ request()->is('admin/bogoDeals*') ? 'active' : '' }}"
                    href="{{ URL::to('/admin/bogoDeals') }}" aria-expanded="false">
                    <i class="fa-solid fa-circle-small"></i><span class="nav-text ">Bogo Deals</span>
                </a>
            </li>
            <li class="nav-item ps-4" id="10">
                <a class="nav-link rounded d-flex {{ request()->is('admin/bmsmDeals*') ? 'active' : '' }}"
                    href="{{ URL::to('/admin/bmsmDeals') }}" aria-expanded="false">
                    <i class="fa-solid fa-circle-small"></i><span class="nav-text ">BmSm Deals</span>
                </a>
            </li>
            <li class="nav-item ps-4" id="7">
                <a class="nav-link rounded d-flex {{ request()->is('admin/category*') ? 'active' : '' }}"
                    href="{{ URL::to('/admin/deals') }}" aria-expanded="false">
                    <i class="fa-sharp fa-solid fa-circle-small"></i><span class="nav-text ">Selective Deal</span>
                </a>
            </li>
        </ul>
    </li>
    @if (@helper::checkaddons('product_review'))
        <li class="nav-item mb-2 fs-7 {{ Auth::user()->type != 1 ? (in_array('29', $modules) == true ? '' : 'd-none') : '' }}"
            id="29">
            <a class="nav-link rounded d-flex {{ request()->is('admin/reviews*') ? 'active' : '' }}"
                href="{{ URL::to('/admin/reviews') }}" aria-expanded="false">
                <i class="fa-solid fa-star"></i><span class="nav-text ">{{ trans('labels.product_reviews') }}</span>
            </a>
        </li>
    @endif
    <li class="nav-item mt-3 {{ Auth::user()->type != 1 ? (in_array('10', $modules) == true ? '' : 'd-none') : '' }}">
        <h6 class="text-muted mb-2 fs-7 text-uppercase">Pizza Management</h6>
    </li>
    <li class="nav-item mb-2 fs-7 {{ Auth::user()->type != 1 ? (in_array('10', $modules) == true ? '' : 'd-none') : '' }}"
        id="10">
        <a class="nav-link rounded d-flex {{ request()->is('admin/custom_pizza*') ? 'active' : '' }}"
            href="{{ URL::to('/admin/custom_pizza') }}" aria-expanded="false">
            <i class="fa-solid fa-pizza-slice"></i><span class="nav-text ">Custom Pizza</span>
        </a>
    </li>
    <li class="nav-item mb-2 fs-7 dropdown multimenu {{ Auth::user()->type != 1 ? (in_array('10', $modules) == true ? '' : 'd-none') : '' }}"
        id="4">
        <a class="nav-link collapsed rounded d-flex align-items-center justify-content-between dropdown-toggle mb-1"
            href="#banners" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="banners">
            <span class="d-flex"><i class="fa-solid fa-list-tree"></i><span
                    class="multimenu-title">Size-Crust</span></span>
        </a>
        <ul class="collapse" id="banners">
            <li class="nav-item ps-4 mb-1">
                <a class="nav-link rounded d-flex {{ request()->is('admin/pizza_crusts*') ? 'active' : '' }}"
                    href="{{ URL::to('/admin/pizza_crusts') }}" aria-expanded="false">
                    <i class="fa-solid fa-dollar-circle"></i><span class="nav-text ">Pizza Crusts</span>
                </a>
            </li>
            <li class="nav-item ps-4 mb-1">
                <a class="nav-link rounded d-flex {{ request()->is('admin/sizes*') ? 'active' : '' }}"
                    href="{{ URL::to('/admin/sizes') }}" aria-expanded="false">
                    <i class="fa-solid fa-plus-minus"></i><span class="nav-text ">Sizes</span>
                </a>
            </li>
            <li class="nav-item ps-4 mb-1">
                <a class="nav-link rounded d-flex {{ request()->is('admin/crusts*') ? 'active' : '' }}"
                    href="{{ URL::to('/admin/crusts') }}" aria-expanded="false">
                    <i class="fa-solid fa-plus-minus"></i><span class="nav-text ">Crusts</span>
                </a>
            </li>
        </ul>
    </li>
    <li
        class="nav-item mt-3 {{ Auth::user()->type != 1 ? (in_array('10', $modules) == true ? '' : 'd-none') : '' }}">
        <h6 class="text-muted mb-2 fs-7 text-uppercase">{{ trans('labels.restaurant_management') }}</h6>
    </li>
    <li class="nav-item mb-2 fs-7 {{ Auth::user()->type != 1 ? (in_array('10', $modules) == true ? '' : 'd-none') : '' }}"
        id="11">
        <a class="nav-link rounded d-flex {{ request()->is('admin/branches*') ? 'active' : '' }}"
            href="{{ URL::to('/admin/branches') }}" aria-expanded="false">
            <i class="fa-solid fa-list-timeline"></i><span class="nav-text ">Branches</span>
        </a>
    </li>
    <li class="nav-item mb-2 fs-7 {{ Auth::user()->type != 1 ? (in_array('10', $modules) == true ? '' : 'd-none') : '' }}"
        id="11">
        <a class="nav-link rounded d-flex {{ request()->is('admin/scripts*') ? 'active' : '' }}"
            href="{{ URL::to('/admin/scripts') }}" aria-expanded="false">
            <i class="fa-solid fa-code"></i><span class="nav-text ">Tags/Scripts</span>
        </a>
    </li>
    <li class="nav-item mb-2 fs-7 {{ Auth::user()->type != 1 ? (in_array('10', $modules) == true ? '' : 'd-none') : '' }}"
        id="11">
        <a class="nav-link rounded d-flex {{ request()->is('admin/carrier*') ? 'active' : '' }}"
            href="{{ URL::to('/admin/carrier') }}" aria-expanded="false">
            <i class="fa-solid fa-bicycle"></i><span class="nav-text ">Carriers</span>
        </a>
    </li>
    <li class="nav-item mb-2 fs-7 {{ Auth::user()->type != 1 ? (in_array('11', $modules) == true ? '' : 'd-none') : '' }}"
        id="11">
        <a class="nav-link rounded d-flex {{ request()->is('admin/shippingarea*') ? 'active' : '' }}"
            href="{{ URL::to('/admin/shippingarea') }}" aria-expanded="false">
            <i class="fa-solid fa-list-timeline"></i><span
                class="nav-text ">{{ trans('labels.shippingarea') }}</span>
        </a>
    </li>

    {{--    @endif --}}
    <li class="nav-item mb-2 fs-7 {{ Auth::user()->type != 1 ? (in_array('12', $modules) == true ? '' : 'd-none') : '' }}"
        id="12">
        <a class="nav-link rounded d-flex {{ request()->is('admin/time*') ? 'active' : '' }}"
            href="{{ URL::to('/admin/time') }}" aria-expanded="false">
            <i class="fa-solid fa-business-time"></i><span
                class="nav-text ">{{ trans('labels.working_hours') }}</span>
        </a>
    </li>
    <li class="nav-item mb-2 fs-7 {{ Auth::user()->type != 1 ? (in_array('13', $modules) == true ? '' : 'd-none') : '' }}"
        id="13">
        <a class="nav-link rounded d-flex {{ request()->is('admin/payment*') ? 'active' : '' }}"
            href="{{ URL::to('/admin/payment') }}" aria-expanded="false">
            <i class="fa-solid fa-money-check-dollar-pen"></i><span
                class="nav-text ">{{ trans('labels.payment_methods') }}</span>
        </a>
    </li>
    @if (Auth::user()->type != 1)
        @if (in_array('17', $modules) || in_array('18', $modules))
            <li class="nav-item mt-3">
                <h6 class="text-muted mb-2 fs-7 text-uppercase">{{ trans('labels.user_management') }}</h6>
            </li>
        @endif
    @else
        <li class="nav-item mt-3">
            <h6 class="text-muted mb-2 fs-7 text-uppercase">{{ trans('labels.user_management') }}</h6>
        </li>
    @endif
    <li class="nav-item mb-2 fs-7 {{ Auth::user()->type != 1 ? (in_array('17', $modules) == true ? '' : 'd-none') : '' }}"
        id="17">
        <a class="nav-link rounded d-flex {{ request()->is('admin/users*') ? 'active' : '' }}"
            href="{{ URL::to('/admin/users') }}" aria-expanded="false">
            <i class="fa-solid fa-users"></i><span class="nav-text ">{{ trans('labels.customers') }}</span>
        </a>
    </li>
    <li class="nav-item mb-2 fs-7 {{ Auth::user()->type != 1 ? (in_array('17', $modules) == true ? '' : 'd-none') : '' }}"
        id="17">
        <a class="nav-link rounded d-flex {{ request()->is('admin/employee*') ? 'active' : '' }}"
            href="{{ URL::to('/admin/employee') }}" aria-expanded="false">
            <i class="fa-solid fa-users"></i><span class="nav-text ">{{ trans('labels.employee') }}</span>
        </a>
    </li>

    @if (Auth::user()->type != 1)
        @if (in_array('21', $modules) || in_array('22', $modules) || in_array('23', $modules) || in_array('24', $modules))
            <li class="nav-item mt-3">
                <h6 class="text-muted mb-2 fs-7 text-uppercase">{{ trans('labels.system_settings') }}</h6>
            </li>
        @endif
    @else
        <li class="nav-item mt-3">
            <h6 class="text-muted mb-2 fs-7 text-uppercase">{{ trans('labels.system_settings') }}</h6>
        </li>
    @endif
    <li class="nav-item mb-2 fs-7 dropdown multimenu {{ Auth::user()->type != 1 ? (in_array('21', $modules) == true ? '' : 'd-none') : '' }}"
        id="21">
        <a class="nav-link collapsed rounded d-flex align-items-center justify-content-between dropdown-toggle mb-1"
            href="#pages" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="pages">
            <span class="d-flex"><i class="fa-solid fa-list-tree"></i><span
                    class="multimenu-title">{{ trans('labels.pages') }}</span></span>
        </a>

        <ul class="collapse" id="pages">
            <li class="nav-item ps-4 mb-1">
                <a class="nav-link rounded {{ request()->is('admin/privacypolicy*') ? 'active' : '' }}"
                    aria-current="page" href="{{ URL::to('/admin/privacypolicy') }}">
                    <span class="d-flex align-items-center multimenu-menu-indicator"><i
                            class="fa-solid fa-circle-small"></i>{{ trans('labels.privacy_policy') }}</span>
                </a>
            </li>
            <li class="nav-item ps-4 mb-1">
                <a class="nav-link rounded {{ request()->is('admin/refundpolicy*') ? 'active' : '' }}"
                    aria-current="page" href="{{ URL::to('/admin/refundpolicy') }}">
                    <span class="d-flex align-items-center multimenu-menu-indicator"><i
                            class="fa-solid fa-circle-small"></i>{{ trans('labels.refund_policy') }}</span>
                </a>
            </li>
            <li class="nav-item ps-4 mb-1">
                <a class="nav-link rounded {{ request()->is('admin/termscondition*') ? 'active' : '' }}"
                    aria-current="page" href="{{ URL::to('/admin/termscondition') }}">
                    <span class="d-flex align-items-center multimenu-menu-indicator"><i
                            class="fa-solid fa-circle-small"></i>{{ trans('labels.terms_conditions') }}</span>
                </a>
            </li>
            <li class="nav-item ps-4 mb-1">
                <a class="nav-link rounded {{ request()->is('admin/aboutus*') ? 'active' : '' }}"
                    aria-current="page" href="{{ URL::to('/admin/aboutus') }}">
                    <span class="d-flex align-items-center multimenu-menu-indicator"><i
                            class="fa-solid fa-circle-small"></i>{{ trans('labels.about_us') }}</span>
                </a>
            </li>
            @if (@helper::checkaddons('blog'))
                <li class="nav-item ps-4 mb-1">
                    <a class="nav-link rounded {{ request()->is('admin/blogs*') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/blogs') }}">
                        <span class="d-flex align-items-center multimenu-menu-indicator">
                            <i class="fa-solid fa-circle-small"></i>
                            <div class="w-100 d-flex justify-content-between align-items-center">
                                {{ trans('labels.blogs') }}
                                @if (env('Environment') == 'sendbox')
                                    <small class="badge bg-danger ms-1">{{ trans('labels.addon') }}</small>
                                @endif
                            </div>
                        </span>
                    </a>
                </li>
            @endif
            {{--            <li class="nav-item ps-4 mb-1"> --}}
            {{--                <a class="nav-link rounded {{ request()->is('admin/choose_us*') ? 'active' : '' }}" --}}
            {{--                    aria-current="page" href="{{ URL::to('/admin/choose_us') }}"> --}}
            {{--                    <span class="d-flex align-items-center multimenu-menu-indicator"><i --}}
            {{--                            class="fa-solid fa-circle-small"></i>{{ trans('labels.why_choose_us') }}</span> --}}
            {{--                </a> --}}
            {{--            </li> --}}
            {{--            <li class="nav-item ps-4 mb-1"> --}}
            {{--                <a class="nav-link rounded {{ request()->is('admin/our-team*') ? 'active' : '' }}" --}}
            {{--                    aria-current="page" href="{{ URL::to('/admin/our-team') }}"> --}}
            {{--                    <span class="d-flex align-items-center multimenu-menu-indicator"><i --}}
            {{--                            class="fa-solid fa-circle-small"></i>{{ trans('labels.our_team') }}</span> --}}
            {{--                </a> --}}
            {{--            </li> --}}
            {{--            <li class="nav-item ps-4 mb-1"> --}}
            {{--                <a class="nav-link rounded {{ request()->is('admin/tutorial*') ? 'active' : '' }}" --}}
            {{--                    aria-current="page" href="{{ URL::to('/admin/tutorial') }}"> --}}
            {{--                    <span class="d-flex align-items-center multimenu-menu-indicator"><i --}}
            {{--                            class="fa-solid fa-circle-small"></i>{{ trans('labels.tutorial') }}</span> --}}
            {{--                </a> --}}
            {{--            </li> --}}
            <li class="nav-item ps-4 mb-1">
                <a class="nav-link rounded {{ request()->is('admin/choose_us*') ? 'active' : '' }}"
                    aria-current="page" href="{{ URL::to('/admin/choose_us') }}">
                    <span class="d-flex align-items-center multimenu-menu-indicator"><i
                            class="fa-solid fa-circle-small"></i>{{ trans('labels.why_choose_us') }}</span>
                </a>
            </li>
            <li class="nav-item ps-4 mb-1">
                <a class="nav-link rounded {{ request()->is('admin/faq*') ? 'active' : '' }}" aria-current="page"
                    href="{{ URL::to('/admin/faq') }}">
                    <span class="d-flex align-items-center multimenu-menu-indicator"><i
                            class="fa-solid fa-circle-small"></i>{{ trans('labels.faq') }}</span>
                </a>
            </li>
            <li class="nav-item ps-4 mb-1">
                <a class="nav-link rounded {{ request()->is('admin/gallery*') ? 'active' : '' }}"
                    aria-current="page" href="{{ URL::to('/admin/gallery') }}">
                    <span class="d-flex align-items-center multimenu-menu-indicator"><i
                            class="fa-solid fa-circle-small"></i>{{ trans('labels.gallery') }}</span>
                </a>
            </li>

            {{--            <li class="nav-item ps-4 mb-1"> --}}
            {{--                <a class="nav-link rounded {{ request()->is('admin/gallery*') ? 'active' : '' }}" --}}
            {{--                    aria-current="page" href="{{ URL::to('/admin/gallery') }}"> --}}
            {{--                    <span class="d-flex align-items-center multimenu-menu-indicator"><i --}}
            {{--                            class="fa-solid fa-circle-small"></i>{{ trans('labels.gallery') }}</span> --}}
            {{--                </a> --}}
            {{--            </li> --}}
            {{--        </ul> --}}
            {{--    </li> --}}
            {{--    @if (@helper::checkaddons('custom_status')) --}}
            {{--        <li class="nav-item mb-2 fs-7 {{ Auth::user()->type != 1 ? (in_array('32', $modules) == true ? '' : 'd-none') : '' }}" --}}
            {{--            id="32"> --}}
            {{--            <a class="nav-link rounded d-flex {{ request()->is('admin/custom_status*') ? 'active' : '' }}" --}}
            {{--                href="{{ URL::to('/admin/custom_status') }}" aria-expanded="false"> --}}
            {{--                <i class="fa-solid fa-clipboard-list-check"></i> --}}
            {{--                <div class="w-100 d-flex justify-content-between align-items-center"> --}}
            {{--                    {{ trans('labels.custom_status') }} --}}
            {{--                    @if (env('Environment') == 'sendbox') --}}
            {{--                        <small class="badge bg-danger ms-1">{{ trans('labels.addon') }}</small> --}}
            {{--                    @endif --}}
            {{--                </div> --}}
            {{--            </a> --}}
            {{--        </li> --}}
            {{--    @endif --}}


            {{--    <li class="nav-item mb-2 fs-7" --}}
            {{--        {{ Auth::user()->type != 1 ? (in_array('27', $modules) == true ? '' : 'd-none') : '' }}" id="27"> --}}
            {{--        <a class="nav-link rounded d-flex {{ request()->is('admin/language-settings*') ? 'active' : '' }}" --}}
            {{--            href="{{ URL::to('/admin/language-settings') }}" aria-expanded="false"> --}}
            {{--            <i class="fa-solid fa-language"></i> --}}
            {{--            <div class="w-100 d-flex justify-content-between align-items-center"> --}}
            {{--                {{ trans('labels.language') }} --}}
            {{--                @if (env('Environment') == 'sendbox') --}}
            {{--                    <small class="badge bg-danger">{{ trans('labels.addon') }}</small> --}}
            {{--                @endif --}}
            {{--            </div> --}}
            {{--        </a> --}}
            {{--    </li> --}}

        </ul>

    </li>
    <li class="nav-item mb-2 fs-7 {{ Auth::user()->type != 1 ? (in_array('22', $modules) == true ? '' : 'd-none') : '' }}"
        id="22">
        <a class="nav-link rounded d-flex {{ request()->is('admin/settings*') ? 'active' : '' }}"
            href="{{ URL::to('/admin/settings') }}" aria-expanded="false">
            <i class="fa-solid fa-gears"></i><span class="nav-text ">{{ trans('labels.general_settings') }}</span>
        </a>
    </li>
    <li class="nav-item mb-2 fs-7 {{ Auth::user()->type != 1 ? (in_array('24', $modules) == true ? '' : 'd-none') : '' }}"
        id="24">
        <a class="nav-link rounded d-flex {{ request()->is('admin/clear-cache*') ? 'active' : '' }}"
            href="{{ URL::to('/admin/clear-cache') }}" aria-expanded="false">
            <i class="fa fa-refresh"></i><span class="nav-text ">{{ trans('labels.clear_cache') }}</span>
        </a>
    </li>
</ul>
