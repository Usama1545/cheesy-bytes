@extends('admin.theme.default')
@section('content')
    @include('admin.breadcrumb')
    <div class="container-fluid">
        <div class="row settings">
            <div class="col-xl-3 mb-3">
                <div class="card card-sticky-top border-0">
                    <ul class="list-group list-options">
                        <a href="#edit_profile" data-tab="edit_profile"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center active"
                            aria-current="true">{{ trans('labels.edit_profile') }}
                            <i class="fa-regular fa-angle-{{ session()->get('direction') == '2' ? 'left' : 'right' }}"></i>
                        </a>
                        <a href="#change_password" data-tab="change_password"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true">{{ trans('labels.change_password') }}
                            <i class="fa-regular fa-angle-{{ session()->get('direction') == '2' ? 'left' : 'right' }}"></i>
                        </a>
                        <a href="#contact_settings" data-tab="contact_settings"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true">{{ trans('labels.contact_settings') }}
                            <i class="fa-regular fa-angle-{{ session()->get('direction') == '2' ? 'left' : 'right' }}"></i>
                        </a>
                        <a href="#seo_settings" data-tab="seo_settings"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true">{{ trans('labels.seo_settings') }}
                            <i class="fa-regular fa-angle-{{ session()->get('direction') == '2' ? 'left' : 'right' }}"></i>
                        </a>
                        @if (@helper::checkaddons('notification'))
                            <a href="#noti_settings" data-tab="noti_settings"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">
                                <div class="w-100 d-flex justify-content-between align-items-center me-1">
                                    {{ trans('labels.noti_settings') }}
                                    @if (env('Environment') == 'sendbox')
                                        <span class="badge bg-danger">{{ trans('labels.addon') }}</span>
                                    @endif
                                </div>
                                <i class="fa-regular fa-angle-{{ session()->get('direction') == '2' ? 'left' : 'right' }}"></i>
                            </a>
                        @endif
                        <a href="#theme_settings" data-tab="theme_settings"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true">
                            <div class="w-100 d-flex justify-content-between align-items-center me-1">
                                {{ trans('labels.theme_settings') }}
                            </div>
                            <i class="fa-regular fa-angle-{{ session()->get('direction') == '2' ? 'left' : 'right' }}"></i>
                        </a>
                        <a href="#business_settings" data-tab="business_settings"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true"> {{ trans('labels.business_settings') }}
                            <i class="fa-regular fa-angle-{{ session()->get('direction') == '2' ? 'left' : 'right' }}"></i>
                        </a>
                        <a href="#website_settings" data-tab="website_settings"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true"> {{ trans('labels.website_settings') }}
                            <i class="fa-regular fa-angle-{{ session()->get('direction') == '2' ? 'left' : 'right' }}"></i>
                        </a>
                        <a href="#social_links" data-tab="social_links"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true"> {{ trans('labels.social_links') }}
                            <i class="fa-regular fa-angle-{{ session()->get('direction') == '2' ? 'left' : 'right' }}"></i>
                        </a>
                        <a href="#footer_settings" data-tab="footer_settings"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true"> {{ trans('labels.footer_settings') }}
                            <i class="fa-regular fa-angle-{{ session()->get('direction') == '2' ? 'left' : 'right' }}"></i>
                        </a>
                        <a href="#mobile_settings" data-tab="mobile_settings"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true"> {{ trans('labels.mobile_app_settings') }}
                            <i class="fa-regular fa-angle-{{ session()->get('direction') == '2' ? 'left' : 'right' }}"></i>
                        </a>
                        @if (@helper::checkaddons('pwa'))
                            <a href="#pwa" data-tab="pwa"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">
                                <div class="w-100 d-flex justify-content-between align-items-center me-1">
                                    {{ trans('labels.pwa') }}
                                    @if (env('Environment') == 'sendbox')
                                        <span class="badge bg-danger">{{ trans('labels.addon') }}</span>
                                    @endif
                                </div>
                                <i class="fa-regular fa-angle-{{ session()->get('direction') == '2' ? 'left' : 'right' }}"></i>
                            </a>
                        @endif
                        @if (@helper::checkaddons('email_settings'))
                            <a href="#email_settings" data-tab="email_settings"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">
                                <div class="w-100 d-flex justify-content-between align-items-center me-1">
                                    {{ trans('labels.email_settings') }}
                                    @if (env('Environment') == 'sendbox')
                                        <span class="badge bg-danger">{{ trans('labels.addon') }}</span>
                                    @endif
                                </div>
                                <i class="fa-regular fa-angle-{{ session()->get('direction') == '2' ? 'left' : 'right' }}"></i>
                            </a>
                        @endif
                        @if (@helper::checkaddons('recaptcha'))
                            <a href="#google_recaptcha" data-tab="google_recaptcha"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">
                                <div class="w-100 d-flex justify-content-between align-items-center me-1">
                                    {{ trans('labels.google_recaptcha') }}
                                    @if (env('Environment') == 'sendbox')
                                        <span class="badge bg-danger">{{ trans('labels.addon') }}</span>
                                    @endif
                                </div>
                                <i class="fa-regular fa-angle-{{ session()->get('direction') == '2' ? 'left' : 'right' }}"></i>
                            </a>
                        @endif
                        @if (@helper::checkaddons('google_login'))
                            <a href="#google_login_settings" data-tab="google_login_settings"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">
                                <div class="w-100 d-flex justify-content-between align-items-center me-1">
                                    {{ trans('labels.google_login') }}
                                    @if (env('Environment') == 'sendbox')
                                        <span class="badge bg-danger">{{ trans('labels.addon') }}</span>
                                    @endif
                                </div>
                                <i class="fa-regular fa-angle-{{ session()->get('direction') == '2' ? 'left' : 'right' }}"></i>
                            </a>
                        @endif
                        @if (@helper::checkaddons('facebook_login'))
                            <a href="#facebook_login_settings" data-tab="facebook_login_settings"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">
                                <div class="w-100 d-flex justify-content-between align-items-center me-1">
                                    {{ trans('labels.facebook_login') }}
                                    @if (env('Environment') == 'sendbox')
                                        <span class="badge bg-danger">{{ trans('labels.addon') }}</span>
                                    @endif
                                </div>
                                <i class="fa-regular fa-angle-{{ session()->get('direction') == '2' ? 'left' : 'right' }}"></i>
                            </a>
                        @endif
                        @if (@helper::checkaddons('pixel'))
                            <a href="#pixel_settings" data-tab="pixel_settings"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">
                                <div class="w-100 d-flex justify-content-between align-items-center me-1">
                                    {{ trans('labels.pixel_settings') }}
                                    @if (env('Environment') == 'sendbox')
                                        <span class="badge bg-danger">{{ trans('labels.addon') }}</span>
                                    @endif
                                </div>
                                <i class="fa-regular fa-angle-{{ session()->get('direction') == '2' ? 'left' : 'right' }}"></i>
                            </a>
                        @endif
                        @if (@helper::checkaddons('product_review'))
                            <a href="#review_settings" data-tab="review_settings"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">
                                <div class="w-100 d-flex justify-content-between align-items-center me-1">
                                    {{ trans('labels.review_settings') }}
                                    @if (env('Environment') == 'sendbox')
                                        <span class="badge bg-danger">{{ trans('labels.addon') }}</span>
                                    @endif
                                </div>
                                <i class="fa-regular fa-angle-{{ session()->get('direction') == '2' ? 'left' : 'right' }}"></i>
                            </a>
                        @endif
                        <a href="#admin_setting" data-tab="admin_setting"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true"> {{ trans('labels.admin_setting') }}
                            <i class="fa-regular fa-angle-{{ session()->get('direction') == '2' ? 'left' : 'right' }}"></i>
                        </a>
                        @if (@helper::checkaddons('tawk_addons'))
                        <a href="#tawk_settings" data-tab="tawk_settings"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true">
                            <div class="w-100 d-flex justify-content-between align-items-center me-1">
                                {{ trans('labels.tawk_to_settings') }}
                                @if (env('Environment') == 'sendbox')
                                    <span class="badge bg-danger">{{ trans('labels.addon') }}</span>
                                @endif
                            </div>
                            <i class="fa-regular fa-angle-{{ session()->get('direction') == '2' ? 'left' : 'right' }}"></i>
                        </a>
                        @endif
                        @if (@helper::checkaddons('wizz_chat'))
                        <a href="#wizz_chat_settings" data-tab="wizz_chat_settings"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true">
                            <div class="w-100 d-flex justify-content-between align-items-center me-1">
                                {{ trans('labels.wizz_chat_settings') }}
                                @if (env('Environment') == 'sendbox')
                                    <span class="badge bg-danger">{{ trans('labels.addon') }}</span>
                                @endif
                            </div>
                            <i class="fa-regular fa-angle-{{ session()->get('direction') == '2' ? 'left' : 'right' }}"></i>
                        </a>
                        @endif
                        @if (@helper::checkaddons('age_verification'))
                        <a href="#age_verification" data-tab="age_verification"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true">
                            <div class="w-100 d-flex justify-content-between align-items-center me-1">
                                {{ trans('labels.age_verification') }}
                                @if (env('Environment') == 'sendbox')
                                    <span class="badge bg-danger">{{ trans('labels.addon') }}</span>
                                @endif
                            </div>
                            <i class="fa-regular fa-angle-{{ session()->get('direction') == '2' ? 'left' : 'right' }}"></i>
                        </a>
                        @endif
                        @if (@helper::checkaddons('quick_call'))
                        <a href="#quick_call" data-tab="quick_call"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true">
                            <div class="w-100 d-flex justify-content-between align-items-center me-1">
                                {{ trans('labels.quick_call') }}
                                @if (env('Environment') == 'sendbox')
                                    <span class="badge bg-danger">{{ trans('labels.addon') }}</span>
                                @endif
                            </div>
                            <i class="fa-regular fa-angle-{{ session()->get('direction') == '2' ? 'left' : 'right' }}"></i>
                        </a>
                        @endif
                        @if (@helper::checkaddons('sales_notification'))
                        <a href="#fake_sales_notification" data-tab="fake_sales_notification"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true">
                            <div class="w-100 d-flex justify-content-between align-items-center me-1">
                                {{ trans('labels.fake_sales_notification') }}
                                @if (env('Environment') == 'sendbox')
                                    <span class="badge bg-danger">{{ trans('labels.addon') }}</span>
                                @endif
                            </div>
                            <i class="fa-regular fa-angle-{{ session()->get('direction') == '2' ? 'left' : 'right' }}"></i>
                        </a>
                        @endif
                        @if (@helper::checkaddons('fake_view'))
                        <a href="#product_fake_view" data-tab="product_fake_view"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true">
                            <div class="w-100 d-flex justify-content-between align-items-center me-1">
                                {{ trans('labels.product_fake_view') }}
                                @if (env('Environment') == 'sendbox')
                                    <span class="badge bg-danger">{{ trans('labels.addon') }}</span>
                                @endif
                            </div>
                            <i class="fa-regular fa-angle-{{ session()->get('direction') == '2' ? 'left' : 'right' }}"></i>
                        </a>
                        @endif
                        <a href="#other" data-tab="other"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true"> {{ trans('labels.other') }}
                            <i class="fa-regular fa-angle-{{ session()->get('direction') == '2' ? 'left' : 'right' }}"></i>
                        </a>
                    </ul>
                </div>
            </div>

            <div class="col-xl-9">
                <div id="settingmenuContent">
                    <div id="edit_profile">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="card border-0 box-shadow">
                                    <div class="card-header p-3 bg-secondary">
                                        <h5 class="text-white">
                                            {{ trans('labels.edit_profile') }}
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ URL::to('admin/edit-profile') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="name">{{ trans('labels.name') }}
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="name"
                                                            id="name" value="{{ Auth::user()->name }}"
                                                            placeholder="{{ trans('labels.name') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="email">{{ trans('labels.email') }}
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="email"
                                                            value="{{ Auth::user()->email }}"
                                                            placeholder="{{ trans('labels.email') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.mobile') }}
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control numbers_only"
                                                            name="mobile" value="{{ Auth::user()->mobile }}"
                                                            placeholder="{{ trans('labels.mobile') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.image') }}
                                                            <span class="text-danger">*</span></label>
                                                        <input type="file" class="form-control" name="profile">
                                                        <img src="{{ helper::image_path(Auth::user()->profile_image) }}"
                                                            class="img-fluid rounded user-profile-image mt-1"
                                                            alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div
                                                    class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                                    <button class="btn btn-primary"
                                                        @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" name="contact_update" value="1" @endif>{{ trans('labels.save') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="change_password">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="card border-0 box-shadow">
                                    <div class="card-header p-3 bg-secondary">
                                        <h5 class="text-white">
                                            {{ trans('labels.change_password') }}
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ URL::to('admin/change-password') }}" method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="old_password">{{ trans('labels.old_password') }}
                                                            <span class="text-danger">*</span></label>
                                                        <input type="password" class="form-control" name="oldpassword"
                                                            id="old_password"
                                                            placeholder="{{ trans('labels.old_password') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="new_password">{{ trans('labels.new_password') }}
                                                        </label>
                                                        <input type="password" class="form-control" name="newpassword"
                                                            placeholder="{{ trans('labels.new_password') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="confirm_password">{{ trans('labels.confirm_password') }}
                                                        </label>
                                                        <input type="password" class="form-control"
                                                            name="confirmpassword"
                                                            placeholder="{{ trans('labels.confirm_password') }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div
                                                    class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                                    <button class="btn btn-primary"
                                                        @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" name="contact_update" value="1" @endif>{{ trans('labels.save') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="contact_settings">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="card border-0 box-shadow">
                                    <div class="card-header p-3 bg-secondary">
                                        <h5 class="text-white">
                                            {{ trans('labels.contact_settings') }}
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ URL::to('admin/settings/update') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.email') }}
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="email"
                                                            value="{{ @$getsettings->email == '' ? old('email') : @$getsettings->email }}"
                                                            placeholder="{{ trans('labels.email') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.mobile') }}
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control numbers_only"
                                                            name="mobile"
                                                            value="{{ @$getsettings->mobile == '' ? old('mobile') : @$getsettings->mobile }}"
                                                            placeholder="{{ trans('labels.mobile') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.address') }}
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="address"
                                                            id="address" placeholder="{{ trans('labels.address') }}"
                                                            value="{{ @$getsettings->address == '' ? old('address') : @$getsettings->address }}"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.address_url') }}
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="address_url"
                                                            id="address_url"
                                                            placeholder="{{ trans('labels.address_url') }}"
                                                            value="{{ @$getsettings->address_url == '' ? old('address_url') : @$getsettings->address_url }}"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div
                                                    class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                                    <button class="btn btn-primary"
                                                        @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" name="contact_update" value="1" @endif>{{ trans('labels.save') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="seo_settings">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="card border-0 box-shadow">
                                    <div class="card-header p-3 bg-secondary">
                                        <h5 class="text-white">
                                            {{ trans('labels.seo_settings') }}
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ URL::to('admin/settings/update') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.og_title') }}</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="{{ trans('labels.og_title') }}" name="og_title"
                                                            id="og_title"
                                                            value="{{ @$getsettings->og_title == '' ? old('og_title') : @$getsettings->og_title }}">
                                                        @error('og_title')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.og_image') }}
                                                            (1200 x 650) </label>
                                                        <input type="file" class="form-control" name="og_image"
                                                            id="og_image">
                                                        @error('image')
                                                            <span class="text-danger">{{ $message }}</span><br>
                                                        @enderror
                                                        <img src="{{ helper::image_path(@$getsettings->og_image) }}"
                                                            class="img-fluid rounded h-50px mt-1">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.og_description') }}</label>
                                                        <textarea class="form-control" name="og_description" placeholder="{{ trans('labels.og_description') }}"
                                                            id="og_description" rows="6">{{ @$getsettings->og_description == '' ? old('og_description') : @$getsettings->og_description }}</textarea>
                                                        @error('og_description')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div
                                                    class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                                    <button class="btn btn-primary"
                                                        @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" name="seo_update" value="1" @endif>{{ trans('labels.save') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (@helper::checkaddons('notification'))
                        <div id="noti_settings">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="card border-0 box-shadow">
                                        <div class="card-header p-3 bg-secondary">
                                            <h5 class="text-white">
                                                {{ trans('labels.noti_settings') }}</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="{{ URL::to('admin/settings/update') }}" method="post"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="col-form-label"
                                                                for="">{{ trans('labels.noti_tone') }}
                                                                (mp3 only) </label>
                                                            <input type="file" class="form-control" name="noti_tune"
                                                                id="noti_tune" accept="audio/mp3" required>
                                                            @error('noti_tune')
                                                                <span class="text-danger">{{ $message }}</span><br>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group mt-4">
                                                            @if ($getsettings->notification_tune != '')
                                                                <audio controls>
                                                                    <source
                                                                        src="{{ url('/') }}/storage/app/public/admin-assets/notification/{{ $getsettings->notification_tune }}"
                                                                        type="audio/mp3">
                                                                    Your Browser Does Not Support The Audio Element.
                                                                </audio>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div
                                                        class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                                        <button class="btn btn-primary"
                                                            @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" name="notification_update" value="1" @endif>{{ trans('labels.save') }}</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div id="theme_settings">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="card border-0 box-shadow">
                                    <div class="card-header p-3 bg-secondary">
                                        <h5 class="text-white">
                                            {{ trans('labels.theme_settings') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ URL::to('admin/settings/update') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-12 selectimg">
                                                    <div class="form-group">
                                                        <label class="form-label">{{ trans('labels.themes') }}
                                                            <span class="text-danger"> * </span> </label>
                                                        <div>
                                                        @php
                                                            $checktheme = @Helper::checkthemeaddons('theme_');
                                                            $themes = array();
                                                            foreach ($checktheme as $ttlthemes) {
                                                                array_push($themes,str_replace("theme_","",$ttlthemes->unique_identifier));
                                                            }
                                                        @endphp
                                                        @foreach ($themes as $key => $item)
                                                        <label for="template{{ $item }}" class="radio-card position-relative">
                                                            <input type="radio" name="template" id="template{{ $item }}" value="{{ $item }}" 
                                                            {{ @$getsettings->theme == $item ? 'checked' : '' }}>
                                                            <div class="card-content-wrapper border rounded-2">
                                                                <span class="check-icon position-absolute"></span>
                                                                <div class="selecimg">
                                                                    <img
                                                                        src="{{ helper::image_path('theme-' . $item . '.png') }}">
                                                                </div>
                                                            </div>
                                                        </label>
                                                        @endforeach
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div
                                                    class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                                    <button class="btn btn-primary"
                                                        @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" name="theme_update" value="1" @endif>{{ trans('labels.save') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="business_settings">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="card border-0 box-shadow">
                                    <div class="card-header p-3 bg-secondary">
                                        <h5 class="text-white">
                                            {{ trans('labels.business_settings') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ URL::to('admin/settings/update') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.currency') }}
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text"
                                                            placeholder="{{ trans('labels.currency') }}"
                                                            value="{{ @$getsettings->currency == '' ? old('currency') : @$getsettings->currency }}"
                                                            class="form-control" name="currency" id="currency" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.currency_position') }}
                                                        </label>
                                                        <div>
                                                            <div class="form-check-inline w-100 mb-2 {{ session()->get('direction') == '2' ? 'd-flex gap-1' : 'form-check' }}">
                                                                <input class="form-check-input me-0" type="radio"
                                                                    name="currency_position" id="inlineRadio1"
                                                                    value="1" required
                                                                    {{ @$getsettings->currency_position == 1 ? 'checked' : '' }}
                                                                    checked>
                                                                <label class="form-check-label"
                                                                    for="inlineRadio1">{{ trans('labels.left') }}</label>
                                                            </div>
                                                            <div class="form-check-inline w-100 mb-2 {{ session()->get('direction') == '2' ? 'd-flex gap-1' : 'form-check' }}">
                                                                <input class="form-check-input me-0" type="radio"
                                                                    name="currency_position" id="inlineRadio2"
                                                                    value="2" required
                                                                    {{ @$getsettings->currency_position == 2 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="inlineRadio2">{{ trans('labels.right') }}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Currency Space -->
                                                <div class="form-group col-md-3">
                                                    <label
                                                        class="form-label">{{ trans('labels.currency_space') }}</label>
                                                    <div class="">
                                                        <div class="form-check-inline w-100 mb-2 {{ session()->get('direction') == '2' ? 'd-flex gap-1' : 'form-check' }}">
                                                            <input type="radio" class="form-check-input me-0"
                                                                name="currency_space" value="1" id="currency_space1"
                                                                required
                                                                {{ @$getsettings->currency_space == '1' ? 'checked' : '' }}>
                                                            <label for="currency_space1"
                                                                class="form-check-label">{{ trans('labels.yes') }}</label>
                                                        </div>
                                                        <div class="form-check-inline w-100 mb-2 {{ session()->get('direction') == '2' ? 'd-flex gap-1' : 'form-check' }}">
                                                            <input type="radio" class="form-check-input me-0"
                                                                name="currency_space" value="2" id="currency_space2"
                                                                required
                                                                {{ @$getsettings->currency_space == '2' ? 'checked' : '' }}>
                                                            <label for="currency_space2"
                                                                class="form-check-label">{{ trans('labels.no') }}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Decimal Number Format -->
                                                <div class="form-group col-md-6">
                                                    <label
                                                        class="form-label">{{ trans('labels.decimal_number_format') }}</label>
                                                    <input type="text" class="form-control" name="currency_formate"
                                                        value="{{ @$getsettings->currency_formate }}"
                                                        placeholder="{{ trans('labels.decimal_number_format') }}">
                                                </div>
                                                <!-- Decimal Number Separator -->
                                                <div class="form-group col-md-6">
                                                    <label
                                                        class="form-label">{{ trans('labels.decimal_separator') }}</label><br>
                                                    <div class="form-check-inline w-100 mb-2 {{ session()->get('direction') == '2' ? 'd-flex gap-1' : 'form-check' }}">
                                                        <input class="form-check-input me-0" type="radio"
                                                            name="decimal_separator" id="dot" value="1"
                                                            required
                                                            {{ @$getsettings->decimal_separator == '1' ? 'checked' : '' }}>
                                                        <label for="dot"
                                                            class="form-check-label">{{ trans('labels.dot') }}(.)</label>
                                                    </div>
                                                    <div class="form-check-inline w-100 mb-2 {{ session()->get('direction') == '2' ? 'd-flex gap-1' : 'form-check' }}">
                                                        <input class="form-check-input me-0" type="radio"
                                                            name="decimal_separator" id="comma" value="2"
                                                            required
                                                            {{ @$getsettings->decimal_separator == '2' ? 'checked' : '' }}>
                                                        <label for="comma"
                                                            class="form-check-label">{{ trans('labels.comma') }}(,)</label>
                                                    </div>
                                                </div>
                                                <!-- Time Format -->
                                                <div class="col-md-6 form-group">
                                                    <label class="form-label">{{ trans('labels.time_format') }}</label>
                                                    <select class="form-select" name="time_format">
                                                        <option value="2"
                                                            {{ @$getsettings->time_format == 2 ? 'selected' : '' }}>12
                                                            {{ trans('labels.hour') }}
                                                        </option>
                                                        <option value="1"
                                                            {{ @$getsettings->time_format == 1 ? 'selected' : '' }}>24
                                                            {{ trans('labels.hour') }}
                                                        </option>
                                                    </select>
                                                </div>
                                                <!-- Date Format -->
                                                <div class="col-md-6 form-group">
                                                    <label class="form-label">{{ trans('labels.date_format') }}</label>
                                                    <select class="form-select" name="date_format">
                                                        <option value="d M, Y"
                                                            {{ @$getsettings->date_format == 'd M, Y' ? 'selected' : '' }}>
                                                            dd MMM, yyyy</option>
                                                        <option value="M d, Y"
                                                            {{ @$getsettings->date_format == 'M d, Y' ? 'selected' : '' }}>
                                                            MMM dd, yyyy</option>
                                                        <option value="d-m-Y"
                                                            {{ @$getsettings->date_format == 'd-m-Y' ? 'selected' : '' }}>
                                                            dd-MM-yyyy</option>
                                                        <option value="m-d-Y"
                                                            {{ @$getsettings->date_format == 'm-d-Y' ? 'selected' : '' }}>
                                                            MM-dd-yyyy</option>
                                                        <option value="d/m/Y"
                                                            {{ @$getsettings->date_format == 'd/m/Y' ? 'selected' : '' }}>
                                                            dd/MM/yyyy</option>
                                                        <option value="m/d/Y"
                                                            {{ @$getsettings->date_format == 'm/d/Y' ? 'selected' : '' }}>
                                                            MM/dd/yyyy</option>
                                                        <option value="Y/m/d"
                                                            {{ @$getsettings->date_format == 'Y/m/d' ? 'selected' : '' }}>
                                                            yyyy/MM/dd</option>
                                                        <option value="Y-m-d"
                                                            {{ @$getsettings->date_format == 'Y-m-d' ? 'selected' : '' }}>
                                                            yyyy-MM-dd</option>
                                                    </select>
                                                </div>
                                                <!-- Referral Amount -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.referral_amount') }}
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text"
                                                            placeholder="{{ trans('labels.referral_amount') }}"
                                                            value="{{ @$getsettings->referral_amount == '' ? old('referral_amount') : @$getsettings->referral_amount }}"
                                                            class="form-control numbers_only" name="referral_amount"
                                                            id="referral_amount" required>
                                                    </div>
                                                </div>
                                                <!-- Max Order Qty -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.max_order_qty') }}
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text"
                                                            placeholder="{{ trans('labels.max_order_qty') }}"
                                                            value="{{ @$getsettings->max_order_qty == '' ? old('max_order_qty') : @$getsettings->max_order_qty }}"
                                                            class="form-control numbers_only" name="max_order_qty"
                                                            id="max_order_qty" required>
                                                    </div>
                                                </div>
                                                <!-- Min Amount -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.min_amount') }}
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text"
                                                            placeholder="{{ trans('labels.min_amount') }}"
                                                            value="{{ @$getsettings->min_order_amount == '' ? old('min_order_amount') : @$getsettings->min_order_amount }}"
                                                            class="form-control numbers_only" name="min_order_amount"
                                                            id="min_order_amount" required>
                                                    </div>
                                                </div>
                                                <!-- Max Amount -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.max_amount') }}
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text"
                                                            placeholder="{{ trans('labels.max_amount') }}"
                                                            value="{{ @$getsettings->max_order_amount == '' ? old('max_order_amount') : @$getsettings->max_order_amount }}"
                                                            class="form-control numbers_only" name="max_order_amount"
                                                            id="max_order_amount" required>
                                                    </div>
                                                </div>
                                                <!-- Maintenance Mode -->
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.maintenance_mode') }}
                                                        </label>
                                                        <input id="maintenance_mode-switch" type="checkbox"
                                                            class="checkbox-switch" name="maintenance_mode"
                                                            value="1"
                                                            {{ $getsettings->maintenance_mode == 1 ? 'checked' : '' }}>
                                                        <label for="maintenance_mode-switch" class="switch">
                                                            <span
                                                                class="switch__circle {{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}"><span
                                                                    class="switch__circle-inner"></span></span>
                                                            <span
                                                                class="switch__left {{ session()->get('direction') == 2 ? 'pe-2' : 'ps-2' }}">{{ trans('labels.off') }}</span>
                                                            <span
                                                                class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <!-- Online Table Booking -->
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.online_table_booking') }}
                                                        </label>
                                                        <input id="online_table_booking-switch" type="checkbox"
                                                            class="checkbox-switch" name="online_table_booking"
                                                            value="1"
                                                            {{ $getsettings->online_table_booking == 1 ? 'checked' : '' }}>
                                                        <label for="online_table_booking-switch" class="switch">
                                                            <span
                                                                class="switch__circle {{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}"><span
                                                                    class="switch__circle-inner"></span></span>
                                                            <span
                                                                class="switch__left {{ session()->get('direction') == 2 ? 'pe-2' : 'ps-2' }}">{{ trans('labels.off') }}</span>
                                                            <span
                                                                class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="">{{ trans('labels.timezone') }}
                                                        </label>
                                                        <select class="form-control" name="timezone" id="timezone"
                                                            data-live-search="true">
                                                            <option value="" selected>
                                                                {{ trans('labels.select') }}
                                                            </option>
                                                            <option value="Pacific/Midway" {{ @$getsettings->timezone ==
                                                                'Pacific/Midway' ? 'selected' : '' }}>
                                                                (GMT-11:00) Midway Island, Samoa</option>
                                                            <option value="America/Adak" {{ @$getsettings->timezone ==
                                                                'America/Adak' ? 'selected' : '' }}>
                                                                (GMT-10:00) Hawaii-Aleutian</option>
                                                            <option value="Etc/GMT+10" {{ @$getsettings->timezone ==
                                                                'Etc/GMT+10' ? 'selected' : '' }}>
                                                                (GMT-10:00) Hawaii</option>
                                                            <option value="Pacific/Marquesas" {{ @$getsettings->timezone ==
                                                                'Pacific/Marquesas' ? 'selected' : '' }}>
                                                                (GMT-09:30) Marquesas Islands</option>
                                                            <option value="Pacific/Gambier" {{ @$getsettings->timezone ==
                                                                'Pacific/Gambier' ? 'selected' : '' }}>
                                                                (GMT-09:00) Gambier Islands</option>
                                                            <option value="America/Anchorage" {{ @$getsettings->timezone ==
                                                                'America/Anchorage' ? 'selected' : '' }}>
                                                                (GMT-09:00) Alaska</option>
                                                            <option value="America/Ensenada" {{ @$getsettings->timezone ==
                                                                'America/Ensenada' ? 'selected' : '' }}>
                                                                (GMT-08:00) Tijuana, Baja California</option>
                                                            <option value="Etc/GMT+8" {{ @$getsettings->timezone == 'Etc/GMT+8'
                                                                ? 'selected' : '' }}>
                                                                (GMT-08:00) Pitcairn Islands</option>
                                                            <option value="America/Los_Angeles" {{ @$getsettings->timezone ==
                                                                'America/Los_Angeles' ? 'selected' : '' }}>
                                                                (GMT-08:00) Pacific Time (US & Canada)</option>
                                                            <option value="America/Denver" {{ @$getsettings->timezone ==
                                                                'America/Denver' ? 'selected' : '' }}>
                                                                (GMT-07:00) Mountain Time (US & Canada)</option>
                                                            <option value="America/Chihuahua" {{ @$getsettings->timezone ==
                                                                'America/Chihuahua' ? 'selected' : '' }}>
                                                                (GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
                                                            <option value="America/Dawson_Creek" {{ @$getsettings->timezone ==
                                                                'America/Dawson_Creek' ? 'selected' : '' }}>
                                                                (GMT-07:00) Arizona</option>
                                                            <option value="America/Belize" {{ @$getsettings->timezone ==
                                                                'America/Belize' ? 'selected' : '' }}>
                                                                (GMT-06:00) Saskatchewan, Central America</option>
                                                            <option value="America/Cancun" {{ @$getsettings->timezone ==
                                                                'America/Cancun' ? 'selected' : '' }}>
                                                                (GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
                                                            <option value="Chile/EasterIsland" {{ @$getsettings->timezone ==
                                                                'Chile/EasterIsland' ? 'selected' : '' }}>
                                                                (GMT-06:00) Easter Island</option>
                                                            <option value="America/Chicago" {{ @$getsettings->timezone ==
                                                                'America/Chicago' ? 'selected' : '' }}>
                                                                (GMT-06:00) Central Time (US & Canada)</option>
                                                            <option value="America/New_York" {{ @$getsettings->timezone ==
                                                                'America/New_York' ? 'selected' : '' }}>
                                                                (GMT-05:00) Eastern Time (US & Canada)</option>
                                                            <option value="America/Havana" {{ @$getsettings->timezone ==
                                                                'America/Havana' ? 'selected' : '' }}>
                                                                (GMT-05:00) Cuba</option>
                                                            <option value="America/Bogota" {{ @$getsettings->timezone ==
                                                                'America/Bogota' ? 'selected' : '' }}>
                                                                (GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
                                                            <option value="America/Caracas" {{ @$getsettings->timezone ==
                                                                'America/Caracas' ? 'selected' : '' }}>
                                                                (GMT-04:30) Caracas</option>
                                                            <option value="America/Santiago" {{ @$getsettings->timezone ==
                                                                'America/Santiago' ? 'selected' : '' }}>
                                                                (GMT-04:00) Santiago</option>
                                                            <option value="America/La_Paz" {{ @$getsettings->timezone ==
                                                                'America/La_Paz' ? 'selected' : '' }}>
                                                                (GMT-04:00) La Paz</option>
                                                            <option value="Atlantic/Stanley" {{ @$getsettings->timezone ==
                                                                'Atlantic/Stanley' ? 'selected' : '' }}>
                                                                (GMT-04:00) Faukland Islands</option>
                                                            <option value="America/Campo_Grande" {{ @$getsettings->timezone ==
                                                                'America/Campo_Grande' ? 'selected' : '' }}>
                                                                (GMT-04:00) Brazil</option>
                                                            <option value="America/Goose_Bay" {{ @$getsettings->timezone ==
                                                                'America/Goose_Bay' ? 'selected' : '' }}>
                                                                (GMT-04:00) Atlantic Time (Goose Bay)</option>
                                                            <option value="America/Glace_Bay" {{ @$getsettings->timezone ==
                                                                'America/Glace_Bay' ? 'selected' : '' }}>
                                                                (GMT-04:00) Atlantic Time (Canada)</option>
                                                            <option value="America/St_Johns" {{ @$getsettings->timezone ==
                                                                'America/St_Johns' ? 'selected' : '' }}>
                                                                (GMT-03:30) Newfoundland</option>
                                                            <option value="America/Araguaina" {{ @$getsettings->timezone ==
                                                                'America/Araguaina' ? 'selected' : '' }}>
                                                                (GMT-03:00) UTC-3</option>
                                                            <option value="America/Montevideo" {{ @$getsettings->timezone ==
                                                                'America/Montevideo' ? 'selected' : '' }}>
                                                                (GMT-03:00) Montevideo</option>
                                                            <option value="America/Miquelon" {{ @$getsettings->timezone ==
                                                                'America/Miquelon' ? 'selected' : '' }}>
                                                                (GMT-03:00) Miquelon, St. Pierre</option>
                                                            <option value="America/Godthab" {{ @$getsettings->timezone ==
                                                                'America/Godthab' ? 'selected' : '' }}>
                                                                (GMT-03:00) Greenland</option>
                                                            <option value="America/Argentina/Buenos_Aires" {{ @$getsettings->
                                                                timezone == 'America/Argentina/Buenos_Aires' ? 'selected' : ''
                                                                }}>
                                                                (GMT-03:00) Buenos Aires</option>
                                                            <option value="America/Sao_Paulo" {{ @$getsettings->timezone ==
                                                                'America/Sao_Paulo' ? 'selected' : '' }}>
                                                                (GMT-03:00) Brasilia</option>
                                                            <option value="America/Noronha" {{ @$getsettings->timezone ==
                                                                'America/Noronha' ? 'selected' : '' }}>
                                                                (GMT-02:00) Mid-Atlantic</option>
                                                            <option value="Atlantic/Cape_Verde" {{ @$getsettings->timezone ==
                                                                'Atlantic/Cape_Verde' ? 'selected' : '' }}>
                                                                (GMT-01:00) Cape Verde Is.</option>
                                                            <option value="Atlantic/Azores" {{ @$getsettings->timezone ==
                                                                'Atlantic/Azores' ? 'selected' : '' }}>
                                                                (GMT-01:00) Azores</option>
                                                            <option value="Europe/Belfast" {{ @$getsettings->timezone ==
                                                                'Europe/Belfast' ? 'selected' : '' }}>
                                                                (GMT) Greenwich Mean Time : Belfast</option>
                                                            <option value="Europe/Dublin" {{ @$getsettings->timezone ==
                                                                'Europe/Dublin' ? 'selected' : '' }}>
                                                                (GMT) Greenwich Mean Time : Dublin</option>
                                                            <option value="Europe/Lisbon" {{ @$getsettings->timezone ==
                                                                'Europe/Lisbon' ? 'selected' : '' }}>
                                                                (GMT) Greenwich Mean Time : Lisbon</option>
                                                            <option value="Europe/London" {{ @$getsettings->timezone ==
                                                                'Europe/London' ? 'selected' : '' }}>
                                                                (GMT) Greenwich Mean Time : London</option>
                                                            <option value="Africa/Abidjan" {{ @$getsettings->timezone ==
                                                                'Africa/Abidjan' ? 'selected' : '' }}>
                                                                (GMT) Monrovia, Reykjavik</option>
                                                            <option value="Europe/Amsterdam" {{ @$getsettings->timezone ==
                                                                'Europe/Amsterdam' ? 'selected' : '' }}>
                                                                (GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna
                                                            </option>
                                                            <option value="Europe/Belgrade" {{ @$getsettings->timezone ==
                                                                'Europe/Belgrade' ? 'selected' : '' }}>
                                                                (GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague
                                                            </option>
                                                            <option value="Europe/Brussels" {{ @$getsettings->timezone ==
                                                                'Europe/Brussels' ? 'selected' : '' }}>
                                                                (GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
                                                            <option value="Africa/Algiers" {{ @$getsettings->timezone ==
                                                                'Africa/Algiers' ? 'selected' : '' }}>
                                                                (GMT+01:00) West Central Africa</option>
                                                            <option value="Africa/Windhoek" {{ @$getsettings->timezone ==
                                                                'Africa/Windhoek' ? 'selected' : '' }}>
                                                                (GMT+01:00) Windhoek</option>
                                                            <option value="Asia/Beirut" {{ @$getsettings->timezone ==
                                                                'Asia/Beirut' ? 'selected' : '' }}>
                                                                (GMT+02:00) Beirut</option>
                                                            <option value="Africa/Cairo" {{ @$getsettings->timezone ==
                                                                'Africa/Cairo' ? 'selected' : '' }}>
                                                                (GMT+02:00) Cairo</option>
                                                            <option value="Asia/Gaza" {{ @$getsettings->timezone == 'Asia/Gaza'
                                                                ? 'selected' : '' }}>
                                                                (GMT+02:00) Gaza</option>
                                                            <option value="Africa/Blantyre" {{ @$getsettings->timezone ==
                                                                'Africa/Blantyre' ? 'selected' : '' }}>
                                                                (GMT+02:00) Harare, Pretoria</option>
                                                            <option value="Asia/Jerusalem" {{ @$getsettings->timezone ==
                                                                'Asia/Jerusalem' ? 'selected' : '' }}>
                                                                (GMT+02:00) Jerusalem</option>
                                                            <option value="Europe/Minsk" {{ @$getsettings->timezone ==
                                                                'Europe/Minsk' ? 'selected' : '' }}>
                                                                (GMT+02:00) Minsk</option>
                                                            <option value="Asia/Damascus" {{ @$getsettings->timezone ==
                                                                'Asia/Damascus' ? 'selected' : '' }}>
                                                                (GMT+02:00) Syria</option>
                                                            <option value="Europe/Moscow" {{ @$getsettings->timezone ==
                                                                'Europe/Moscow' ? 'selected' : '' }}>
                                                                (GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
                                                            <option value="Africa/Addis_Ababa" {{ @$getsettings->timezone ==
                                                                'Africa/Addis_Ababa' ? 'selected' : '' }}>
                                                                (GMT+03:00) Nairobi</option>
                                                            <option value="Asia/Tehran" {{ @$getsettings->timezone ==
                                                                'Asia/Tehran' ? 'selected' : '' }}>
                                                                (GMT+03:30) Tehran</option>
                                                            <option value="Asia/Dubai" {{ @$getsettings->timezone ==
                                                                'Asia/Dubai' ? 'selected' : '' }}>
                                                                (GMT+04:00) Abu Dhabi, Muscat</option>
                                                            <option value="Asia/Yerevan" {{ @$getsettings->timezone ==
                                                                'Asia/Yerevan' ? 'selected' : '' }}>
                                                                (GMT+04:00) Yerevan</option>
                                                            <option value="Asia/Kabul" {{ @$getsettings->timezone ==
                                                                'Asia/Kabul' ? 'selected' : '' }}>
                                                                (GMT+04:30) Kabul</option>
                                                            <option value="Asia/Yekaterinburg" {{ @$getsettings->timezone ==
                                                                'Asia/Yekaterinburg' ? 'selected' : '' }}>
                                                                (GMT+05:00) Ekaterinburg</option>
                                                            <option value="Asia/Tashkent" {{ @$getsettings->timezone ==
                                                                'Asia/Tashkent' ? 'selected' : '' }}>
                                                                (GMT+05:00) Tashkent</option>
                                                            <option value="Asia/Kolkata" {{ @$getsettings->timezone ==
                                                                'Asia/Kolkata' ? 'selected' : '' }}>
                                                                (GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
                                                            <option value="Asia/Katmandu" {{ @$getsettings->timezone ==
                                                                'Asia/Katmandu' ? 'selected' : '' }}>
                                                                (GMT+05:45) Kathmandu</option>
                                                            <option value="Asia/Dhaka" {{ @$getsettings->timezone ==
                                                                'Asia/Dhaka' ? 'selected' : '' }}>
                                                                (GMT+06:00) Astana, Dhaka</option>
                                                            <option value="Asia/Novosibirsk" {{ @$getsettings->timezone ==
                                                                'Asia/Novosibirsk' ? 'selected' : '' }}>
                                                                (GMT+06:00) Novosibirsk</option>
                                                            <option value="Asia/Rangoon" {{ @$getsettings->timezone ==
                                                                'Asia/Rangoon' ? 'selected' : '' }}>
                                                                (GMT+06:30) Yangon (Rangoon)</option>
                                                            <option value="Asia/Bangkok" {{ @$getsettings->timezone ==
                                                                'Asia/Bangkok' ? 'selected' : '' }}>
                                                                (GMT+07:00) Bangkok, Hanoi, Jakarta</option>
                                                            <option value="Asia/Krasnoyarsk" {{ @$getsettings->timezone ==
                                                                'Asia/Krasnoyarsk' ? 'selected' : '' }}>
                                                                (GMT+07:00) Krasnoyarsk</option>
                                                            <option value="Asia/Hong_Kong" {{ @$getsettings->timezone ==
                                                                'Asia/Hong_Kong' ? 'selected' : '' }}>
                                                                (GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
                                                            <option value="Asia/Irkutsk" {{ @$getsettings->timezone ==
                                                                'Asia/Irkutsk' ? 'selected' : '' }}>
                                                                (GMT+08:00) Irkutsk, Ulaan Bataar</option>
                                                            <option value="Australia/Perth" {{ @$getsettings->timezone ==
                                                                'Australia/Perth' ? 'selected' : '' }}>
                                                                (GMT+08:00) Perth</option>
                                                            <option value="Australia/Eucla" {{ @$getsettings->timezone ==
                                                                'Australia/Eucla' ? 'selected' : '' }}>
                                                                (GMT+08:45) Eucla</option>
                                                            <option value="Asia/Tokyo" {{ @$getsettings->timezone ==
                                                                'Asia/Tokyo' ? 'selected' : '' }}>
                                                                (GMT+09:00) Osaka, Sapporo, Tokyo</option>
                                                            <option value="Asia/Seoul" {{ @$getsettings->timezone ==
                                                                'Asia/Seoul' ? 'selected' : '' }}>
                                                                (GMT+09:00) Seoul</option>
                                                            <option value="Asia/Yakutsk" {{ @$getsettings->timezone ==
                                                                'Asia/Yakutsk' ? 'selected' : '' }}>
                                                                (GMT+09:00) Yakutsk</option>
                                                            <option value="Australia/Adelaide" {{ @$getsettings->timezone ==
                                                                'Australia/Adelaide' ? 'selected' : '' }}>
                                                                (GMT+09:30) Adelaide</option>
                                                            <option value="Australia/Darwin" {{ @$getsettings->timezone ==
                                                                'Australia/Darwin' ? 'selected' : '' }}>
                                                                (GMT+09:30) Darwin</option>
                                                            <option value="Australia/Brisbane" {{ @$getsettings->timezone ==
                                                                'Australia/Brisbane' ? 'selected' : '' }}>
                                                                (GMT+10:00) Brisbane</option>
                                                            <option value="Australia/Hobart" {{ @$getsettings->timezone ==
                                                                'Australia/Hobart' ? 'selected' : '' }}>
                                                                (GMT+10:00) Hobart</option>
                                                            <option value="Asia/Vladivostok" {{ @$getsettings->timezone ==
                                                                'Asia/Vladivostok' ? 'selected' : '' }}>
                                                                (GMT+10:00) Vladivostok</option>
                                                            <option value="Australia/Lord_Howe" {{ @$getsettings->timezone ==
                                                                'Australia/Lord_Howe' ? 'selected' : '' }}>
                                                                (GMT+10:30) Lord Howe Island</option>
                                                            <option value="Etc/GMT-11" {{ @$getsettings->timezone ==
                                                                'Etc/GMT-11' ? 'selected' : '' }}>
                                                                (GMT+11:00) Solomon Is., New Caledonia</option>
                                                            <option value="Asia/Magadan" {{ @$getsettings->timezone ==
                                                                'Asia/Magadan' ? 'selected' : '' }}>
                                                                (GMT+11:00) Magadan</option>
                                                            <option value="Pacific/Norfolk" {{ @$getsettings->timezone ==
                                                                'Pacific/Norfolk' ? 'selected' : '' }}>
                                                                (GMT+11:30) Norfolk Island</option>
                                                            <option value="Asia/Anadyr" {{ @$getsettings->timezone ==
                                                                'Asia/Anadyr' ? 'selected' : '' }}>
                                                                (GMT+12:00) Anadyr, Kamchatka</option>
                                                            <option value="Pacific/Auckland" {{ @$getsettings->timezone ==
                                                                'Pacific/Auckland' ? 'selected' : '' }}>
                                                                (GMT+12:00) Auckland, Wellington</option>
                                                            <option value="Etc/GMT-12" {{ @$getsettings->timezone ==
                                                                'Etc/GMT-12' ? 'selected' : '' }}>
                                                                (GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
                                                            <option value="Pacific/Chatham" {{ @$getsettings->timezone ==
                                                                'Pacific/Chatham' ? 'selected' : '' }}>
                                                                (GMT+12:45) Chatham Islands</option>
                                                            <option value="Pacific/Tongatapu" {{ @$getsettings->timezone ==
                                                                'Pacific/Tongatapu' ? 'selected' : '' }}>
                                                                (GMT+13:00) Nuku'alofa</option>
                                                            <option value="Pacific/Kiritimati" {{ @$getsettings->timezone ==
                                                                'Pacific/Kiritimati' ? 'selected' : '' }}>
                                                                (GMT+14:00) Kiritimati</option>
                                                        </select>
                                                        @error('timezone')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                @if (@helper::checkaddons('customer_login'))
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="col-form-label"
                                                                for="">{{ trans('labels.customer_login_required') }}
                                                            </label>
                                                            <input id="login_required-switch" type="checkbox"
                                                                class="checkbox-switch" name="login_required"
                                                                value="1"
                                                                {{ $getsettings->login_required == 1 ? 'checked' : '' }}>
                                                            <label for="login_required-switch" class="switch">
                                                                <span
                                                                    class="switch__circle {{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}"><span
                                                                        class="switch__circle-inner"></span></span>
                                                                <span
                                                                    class="switch__left {{ session()->get('direction') == 2 ? 'pe-2' : 'ps-2' }}">{{ trans('labels.off') }}</span>
                                                                <span
                                                                    class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 {{ $getsettings->login_required == 1 ? '' : 'd-none' }}"
                                                        id="is_checkout_login_required">
                                                        <div class="form-group">
                                                            <label class="col-form-label"
                                                                for="">{{ trans('labels.is_checkout_login_required') }}
                                                            </label>
                                                            @if (env('Environment') == 'sendbox')
                                                                <span
                                                                    class="badge bg-danger">{{ trans('labels.addon') }}</span>
                                                            @endif
                                                            <input id="is_checkout_login_required-switch" type="checkbox"
                                                                class="checkbox-switch" name="is_checkout_login_required"
                                                                value="1"
                                                                {{ $getsettings->is_checkout_login_required == 1 ? 'checked' : '' }}>
                                                            <label for="is_checkout_login_required-switch" class="switch">
                                                                <span
                                                                    class="switch__circle {{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}"><span
                                                                        class="switch__circle-inner"></span></span>
                                                                <span
                                                                    class="switch__left {{ session()->get('direction') == 2 ? 'pe-2' : 'ps-2' }}">{{ trans('labels.off') }}</span>
                                                                <span
                                                                    class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.pickup_delivery') }}
                                                        </label>
                                                        <select class="form-control selectpicker" name="pickup_delivery"
                                                            id="pickup_delivery" data-live-search="true">
                                                            <option value="1"
                                                                {{ $getsettings->pickup_delivery == 1 ? 'selected' : '' }}>
                                                                {{ trans('labels.both') }}</option>
                                                            <option value="2"
                                                                {{ $getsettings->pickup_delivery == 2 ? 'selected' : '' }}>
                                                                {{ trans('labels.delivery') }}</option>
                                                            <option value="3"
                                                                {{ $getsettings->pickup_delivery == 3 ? 'selected' : '' }}>
                                                                {{ trans('labels.pickup') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.order_prefix_number') }}
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text"
                                                            placeholder="{{ trans('labels.order_prefix_number') }}"
                                                            value="{{ @$getsettings->order_prefix == '' ? old('order_prefix') : @$getsettings->order_prefix }}"
                                                            class="form-control" name="order_prefix" id="order_prefix"
                                                            required>
                                                    </div>
                                                </div>
                                                @if (count($order) == 0)
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="col-form-label"
                                                                for="">{{ trans('labels.order_number_start') }}
                                                                <span class="text-danger">*</span></label>
                                                            <input type="text"
                                                                placeholder="{{ trans('labels.order_number_start') }}"
                                                                value="{{ @$getsettings->order_number_start == '' ? old('order_number_start') : @$getsettings->order_number_start }}"
                                                                class="form-control numbers_only"
                                                                name="order_number_start" id="order_number_start"
                                                                required>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="row">
                                                <div
                                                    class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                                    <button class="btn btn-primary"
                                                        @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" name="business_update" value="1" @endif>{{ trans('labels.save') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="website_settings">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="card border-0 box-shadow">
                                    <div class="card-header p-3 bg-secondary">
                                        <h5 class="text-white">

                                            {{ trans('labels.website_settings') }}
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ URL::to('admin/settings/update') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.title_for_title_bar') }}
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="title"
                                                            id="title"
                                                            value="{{ @$getsettings->title == '' ? old('title') : @$getsettings->title }}"
                                                            placeholder="{{ trans('labels.title_for_title_bar') }}"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.short_title') }}
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="short_title"
                                                            id="short_title"
                                                            value="{{ @$getsettings->short_title == '' ? old('short_title') : @$getsettings->short_title }}"
                                                            placeholder="{{ trans('labels.short_title') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.logo') }} (250
                                                            x 250) </label>
                                                        <input type="file" class="form-control" name="logo"
                                                            id="logo">
                                                        <img src="{{ helper::image_path(@$getsettings->logo) }}"
                                                            class="img-fluid rounded h-50px mt-1">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.Favicon') }}
                                                            (16 x 16) </label>
                                                        <input type="file" class="form-control" name="favicon"
                                                            id="favicon">
                                                        <img src="{{ helper::image_path(@$getsettings->favicon) }}"
                                                            class="img-fluid rounded h-50px mt-1">
                                                    </div>
                                                </div>
                                                <!-- Primary Color -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label
                                                            class="col-form-label">{{ trans('labels.primary_color') }}</label>
                                                        <input type="color"
                                                            class="form-control form-control-color w-100 border-0"
                                                            name="web_primary_color"
                                                            value="{{ @$getsettings->web_primary_color }}">
                                                    </div>
                                                </div>
                                                <!-- Secondary Color -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label
                                                            class="col-form-label">{{ trans('labels.secondary_color') }}</label>
                                                        <input type="color"
                                                            class="form-control form-control-color w-100 border-0"
                                                            name="web_secondary_color"
                                                            value="{{ @$getsettings->web_secondary_color }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.copyright') }}
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="copyright"
                                                            id="copyright"
                                                            value="{{ @$getsettings->copyright == '' ? old('copyright') : @$getsettings->copyright }}"
                                                            placeholder="{{ trans('labels.copyright') }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div
                                                    class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                                    <button class="btn btn-primary"
                                                        @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" name="web_update" value="1" @endif>{{ trans('labels.save') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="social_links">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="card border-0 box-shadow">
                                    <div class="card-header p-3 bg-secondary">
                                        <h5 class="text-white">
                                            {{ trans('labels.social_links') }}
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ URL::to('admin/settings/update') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="col-form-label">
                                                            {{ trans('labels.social_links') }}
                                                            <span class="" data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                title="Ex. <i class='fa-solid fa-truck-fast'></i> Visit https://fontawesome.com/ for more info">
                                                                <i class="fa-solid fa-circle-info"></i>
                                                            </span>
                                                        </label>
                                                        @forelse ($getsociallink as $key => $sociallink)
                                                            <div class="row">
                                                                <input type="hidden" name="edit_icon_key[]"
                                                                    value="{{ $sociallink->id }}">
                                                                <div class="col-md-6 form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control {{ session()->get('direction') == '2' ? 'rounded-end rounded-0' : 'rounded-start' }}"
                                                                            name="edit_sociallink_icon[{{ $sociallink->id }}]"
                                                                            placeholder="{{ trans('labels.icon') }}"
                                                                            value="{{ $sociallink->icon }}" required>
                                                                        <p class="input-group-text {{ session()->get('direction') == '2' ? 'rounded-start rounded-0' : 'rounded-end' }}">
                                                                            {!! $sociallink->icon !!}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="col-md-6 form-group d-flex gap-2 align-items-center">
                                                                    <input type="text" class="form-control"
                                                                        name="edit_sociallink_link[{{ $sociallink->id }}]"
                                                                        placeholder="{{ trans('labels.link') }}"
                                                                        value="{{ $sociallink->link }}" required>
                                                                    <button class="btn btn-danger px-3" type="button"
                                                                        onclick="delete_social_links('{{ URL::to('admin/settings/delete-social-link-' . $sociallink->id) }}')">
                                                                        <i class="fa fa-trash"></i> </button>
                                                                </div>
                                                            </div>
                                                        @empty
                                                            <div class="row">
                                                                <div class="col-md-6 form-group">
                                                                    <div class="input-group">
                                                                        <input type="text"
                                                                            class="form-control feature_required"
                                                                            onkeyup="show_feature_icon(this)"
                                                                            name="social_icon[]"
                                                                            placeholder="{{ trans('labels.icon') }}">
                                                                        <p class="input-group-text"></p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 form-group d-flex align-items-center">
                                                                    <input type="text"
                                                                        class="form-control feature_required"
                                                                        name="social_link[]"
                                                                        placeholder="{{ trans('labels.link') }}">
                                                                    <button class="btn btn-secondary mx-2" type="button"
                                                                        onclick="add_social_link('{{ trans('labels.icon') }}','{{ trans('labels.link') }}')">
                                                                        <i class="fa-sharp fa-solid fa-plus"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        @endforelse
                                                        <span class="extra_social_links"></span>
                                                        @if (count($getsociallink) > 0)
                                                            <button class="btn btn-secondary" type="button"
                                                                onclick="add_social_link('{{ trans('labels.icon') }}','{{ trans('labels.link') }}')">
                                                                <i class="fa-sharp fa-solid fa-plus"></i>
                                                                {{ trans('labels.add_new') }} </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div
                                                    class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                                    <button class="btn btn-primary"
                                                        @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" name="social_link_update" value="1" @endif>{{ trans('labels.save') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="footer_settings">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="card border-0 box-shadow">
                                    <div class="card-header p-3 bg-secondary">
                                        <h5 class="text-white">
                                            {{ trans('labels.footer_settings') }}
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ URL::to('admin/settings/update') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="col-form-label"
                                                        for="">{{ trans('labels.footer_title') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control"
                                                        placeholder="{{ trans('labels.footer_title') }}"
                                                        name="footer_title" id="footer_title"
                                                        value="{{ @$getsettings->footer_title == '' ? old('footer_title') : @$getsettings->footer_title }}"
                                                        required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-form-label"
                                                        for="">{{ trans('labels.footer_logo') }}
                                                        (250 x 250) </label>
                                                    <input type="file" class="form-control" name="footer_logo"
                                                        id="footer_logo">
                                                    <img src="{{ helper::image_path(@$getsettings->footer_logo) }}"
                                                        class="img-fluid rounded h-50px mt-1">
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.footer_description') }}
                                                            <span class="text-danger">*</span></label>
                                                        <textarea class="form-control" name="footer_description" placeholder="{{ trans('labels.footer_description') }}"
                                                            id="footer_description" rows="5" required>{{ @$getsettings->footer_description == '' ? old('footer_description') : @$getsettings->footer_description }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.footer_features') }}
                                                            <span class="" data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                title="Ex. <i class='fa-solid fa-truck-fast'></i> Visit https://fontawesome.com/ for more info">
                                                                <i class="fa-solid fa-circle-info"></i>
                                                            </span>
                                                        </label>
                                                        @forelse ($getfooterfeatures as $key => $features)
                                                            <div class="row">
                                                                <input type="hidden" name="edit_icon_key[]"
                                                                    value="{{ $features->id }}">
                                                                <div class="col-md-4 form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control {{ session()->get('direction') == '2' ? 'rounded-end rounded-0' : 'rounded-start' }}"
                                                                            name="edi_feature_icon[{{ $features->id }}]"
                                                                            placeholder="{{ trans('labels.icon') }}"
                                                                            value="{{ $features->icon }}" required>
                                                                        <p class="input-group-text {{ session()->get('direction') == '2' ? 'rounded-start rounded-0' : 'rounded-end' }}">
                                                                            {!! $features->icon !!}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 form-group">
                                                                    <input type="text" class="form-control"
                                                                        name="edi_feature_title[{{ $features->id }}]"
                                                                        placeholder="{{ trans('labels.title') }}"
                                                                        value="{{ $features->title }}" required>
                                                                </div>
                                                                <div class="col-md-4 form-group">
                                                                    <div class="d-flex gap-2">
                                                                        <input type="text" class="form-control"
                                                                            name="edi_feature_description[{{ $features->id }}]"
                                                                            placeholder="{{ trans('labels.description') }}"
                                                                            value="{{ $features->description }}"
                                                                            required>
                                                                        <div>
                                                                            <button class="btn btn-danger px-3"
                                                                                type="button"
                                                                                onclick="delete_features('{{ URL::to('admin/settings/delete-feature-' . $features->id) }}')">
                                                                                <i class="fa fa-trash"></i> </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @empty
                                                            <div class="row">
                                                                <div class="col-md-3 form-group">
                                                                    <div class="input-group">
                                                                        <input type="text"
                                                                            class="form-control feature_required"
                                                                            onkeyup="show_feature_icon(this)"
                                                                            name="feature_icon[]"
                                                                            placeholder="{{ trans('labels.icon') }}">
                                                                        <p class="input-group-text"></p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 form-group">
                                                                    <input type="text"
                                                                        class="form-control feature_required"
                                                                        name="feature_title[]"
                                                                        placeholder="{{ trans('labels.title') }}">
                                                                </div>
                                                                <div class="col-md-5 form-group">
                                                                    <input type="text"
                                                                        class="form-control feature_required"
                                                                        name="feature_description[]"
                                                                        placeholder="{{ trans('labels.description') }}">
                                                                </div>
                                                                <div class="col-md-1 form-group">
                                                                    <button class="btn btn-secondary" type="button"
                                                                        onclick="add_features('{{ trans('labels.icon') }}','{{ trans('labels.title') }}','{{ trans('labels.description') }}')">
                                                                        <i class="fa-sharp fa-solid fa-plus"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        @endforelse
                                                        <span class="extra_footer_features"></span>
                                                        @if (count($getfooterfeatures) > 0)
                                                            <button class="btn btn-secondary" type="button"
                                                                onclick="add_features('{{ trans('labels.icon') }}','{{ trans('labels.title') }}','{{ trans('labels.description') }}')">
                                                                <i class="fa-sharp fa-solid fa-plus"></i>
                                                                {{ trans('labels.add_new') }} </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div
                                                    class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                                    <button class="btn btn-primary"
                                                        @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" name="footer_settings_update" value="1" @endif>{{ trans('labels.save') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="mobile_settings">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="card border-0 box-shadow">
                                    <div class="card-header p-3 bg-secondary">
                                        <h5 class="text-white">
                                            {{ trans('labels.mobile_app_settings') }}
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ URL::to('admin/settings/update') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.ios_app_link') }}
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="ios"
                                                            id="ios"
                                                            value="{{ @$getsettings->ios == '' ? old('ios') : @$getsettings->ios }}"
                                                            placeholder="{{ trans('labels.ios_app_link') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.android_app_link') }}
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="android"
                                                            id="android"
                                                            value="{{ @$getsettings->android == '' ? old('android') : @$getsettings->android }}"
                                                            placeholder="{{ trans('labels.android_app_link') }}"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.app_bottom_image') }}
                                                        </label>
                                                        <input type="file" class="form-control"
                                                            name="app_bottom_image" id="app_bottom_image">
                                                        <img src="{{ helper::image_path(@$getsettings->app_bottom_image) }}"
                                                            class="img-fluid rounded h-50px mt-1">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-form-label"
                                                        for="">{{ trans('labels.mobile_app_title') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control"
                                                        placeholder="{{ trans('labels.mobile_app_title') }}"
                                                        name="mobile_app_title" id="mobile_app_title" required
                                                        value="{{ @$getsettings->mobile_app_title == '' ? old('mobile_app_title') : @$getsettings->mobile_app_title }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-form-label"
                                                        for="">{{ trans('labels.mobile_app_image') }}
                                                    </label>
                                                    <input type="file" class="form-control" name="mobile_app_image"
                                                        id="mobile_app_image">
                                                    <img src="{{ helper::image_path(@$getsettings->mobile_app_image) }}"
                                                        class="img-fluid rounded h-50px mt-1">
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.mobile_app_description') }}
                                                            <span class="text-danger">*</span></label>
                                                        <textarea class="form-control" name="mobile_app_description"
                                                            placeholder="{{ trans('labels.mobile_app_description') }}" required id="mobile_app_description"
                                                            rows="5">{{ @$getsettings->mobile_app_description == '' ? old('mobile_app_description') : @$getsettings->mobile_app_description }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div
                                                    class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                                    <button class="btn btn-primary"
                                                        @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" name="mobileapp_update" value="1" @endif>{{ trans('labels.save') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (@helper::checkaddons('pwa'))
                        @include('admin.pwa.pwa_settings')
                    @endif
                    @if (@helper::checkaddons('email_settings'))
                        @include('admin.email_settings.email_settings')
                    @endif
                    @if (@helper::checkaddons('recaptcha'))
                        @include('admin.google_recaptcha.recaptcha')
                    @endif

                    @if (@helper::checkaddons('google_login'))
                        @include('admin.sociallogin.google_login')
                    @endif
                    @if (@helper::checkaddons('facebook_login'))
                        @include('admin.sociallogin.facebook_login')
                    @endif
                    @if (@helper::checkaddons('pixel'))
                        @include('admin.pixel.pixel_setting')
                    @endif

                    @if (@helper::checkaddons('product_review'))
                        @include('admin.reviews.review_setting')
                    @endif

                    <div id="admin_setting">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="card border-0 box-shadow">
                                    <div class="card-header p-3 bg-secondary">
                                        <h5 class="text-white">{{ trans('labels.admin_setting') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ URL::to('admin/settings/update') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <!-- Primary Color -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label
                                                            class="col-form-label">{{ trans('labels.primary_color') }}</label>
                                                        <input type="color"
                                                            class="form-control form-control-color w-100 border-0"
                                                            name="admin_primary_color"
                                                            value="{{ @$getsettings->admin_primary_color }}">
                                                        @error('admin_primary_color')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <!-- Secondary Color -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label
                                                            class="col-form-label">{{ trans('labels.secondary_color') }}</label>
                                                        <input type="color"
                                                            class="form-control form-control-color w-100 border-0"
                                                            name="admin_secondary_color"
                                                            value="{{ @$getsettings->admin_secondary_color }}">
                                                        @error('admin_secondary_color')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div
                                                    class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                                    <button class="btn btn-primary"
                                                        @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" name="admin_update" value="1" @endif>{{ trans('labels.save') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (@helper::checkaddons('tawk_addons'))
                    @include('admin.tawk_settings.index')
                    @endif
                    @if (@helper::checkaddons('wizz_chat'))
                    @include('admin.wizz_chat_settings.index')
                    @endif
                    @if (@helper::checkaddons('age_verification'))
                    @include('admin.age_verification.index')
                    @endif
                    @if (@helper::checkaddons('quick_call'))
                    @include('admin.quick_call.index')
                    @endif
                    @if (@helper::checkaddons('sales_notification'))
                    @include('admin.fake_sales_notification.index')
                    @endif
                    @if (@helper::checkaddons('fake_view'))
                    @include('admin.product_fake_view.index')
                    @endif

                    <div id="other">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="card border-0 box-shadow">
                                    <div class="card-header p-3 bg-secondary">
                                        <h5 class="text-white">
                                            {{ trans('labels.other') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ URL::to('admin/settings/update') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <!-- Google Review URL -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label
                                                            class="col-form-label">{{ trans('labels.google_review_url') }}</label>
                                                        <input type="text" class="form-control"
                                                            name="google_review_url"
                                                            placeholder="{{ trans('labels.google_review_url') }}"
                                                            value="{{ @$getsettings->google_review_url }}">
                                                    </div>
                                                </div>
                                                <!-- FAQs Image -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.faqs_image') }}
                                                        </label>
                                                        <input type="file" class="form-control" name="faqs_image"
                                                            id="faqs_image">
                                                        <img src="{{ helper::image_path(@$getsettings->faqs_image) }}"
                                                            class="img-fluid rounded h-50px mt-1">
                                                    </div>
                                                </div>
                                                <!-- Auth Bg Image -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.auth_bg_image') }}</label>
                                                        <input type="file" class="form-control"
                                                            name="auth_bg_image" id="auth_bg_image">
                                                        <img src="{{ helper::image_path(@$getsettings->auth_bg_image) }}"
                                                            class="img-fluid rounded h-50px mt-1">
                                                    </div>
                                                </div>
                                                <!-- Table Booking Bg Image -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.booknow_bg_image') }}</label>
                                                        <input type="file" class="form-control"
                                                            name="booknow_bg_image" id="booknow_bg_image">
                                                        <img src="{{ helper::image_path(@$getsettings->booknow_bg_image) }}"
                                                            class="img-fluid rounded h-50px mt-1">
                                                    </div>
                                                </div>
                                                <!-- Refer & Earn Bg Image -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.refer_earn_bg_image') }}</label>
                                                        <input type="file" class="form-control"
                                                            name="refer_earn_bg_image" id="refer_earn_bg_image">
                                                        <img src="{{ helper::image_path(@$getsettings->refer_earn_bg_image) }}"
                                                            class="img-fluid rounded h-50px mt-1">
                                                    </div>
                                                </div>
                                                <!-- Subscribe Newsletter Image -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.subscribe_newsletter_image') }}</label>
                                                        <input type="file" class="form-control"
                                                            name="subscribe_newsletter_image"
                                                            id="subscribe_newsletter_image">
                                                        <img src="{{ helper::image_path(@$getsettings->subscribe_newsletter_image) }}"
                                                            class="img-fluid rounded h-50px mt-1">
                                                    </div>
                                                </div>
                                                <!-- No Data Image -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.no_data_image') }}</label>
                                                        <input type="file" class="form-control"
                                                            name="no_data_image" id="no_data_image">
                                                        <img src="{{ helper::image_path(@$getsettings->no_data_image) }}"
                                                            class="img-fluid rounded h-50px mt-1">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div
                                                    class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                                    <button class="btn btn-primary"
                                                        @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" name="other_update" value="1" @endif>{{ trans('labels.save') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/settings.js') }}"></script>
@endsection
