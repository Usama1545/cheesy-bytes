<!doctype html>
<html lang="en" dir="{{ session('direction') == 2 ? 'rtl' : 'ltr' }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title> {{ @helper::appdata()->title }} | {{ trans('labels.signup') }} </title>
    <link rel="icon" href="{{ helper::image_path(@helper::appdata()->favicon) }}"><!-- Favicon -->
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL') . 'web-assets/css/bootstrap.min.css') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL') . 'web-assets/css/font_awesome/all.css') }}">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL') . 'web-assets/css/style.css') }}"><!-- Custom CSS -->
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL') . 'web-assets/css/responsive.css') }}">
    <!-- Media Query Resposive CSS -->
    <!-- COMMON-CSS -->
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/css/toastr/toastr.min.css') }}">
    <!-- Toastr CSS -->
    <style>
        :root {
            --bs-primary: {{ helper::appdata()->web_primary_color != null ? helper::appdata()->web_primary_color : '#F82647' }};
            --bs-secondary: {{ helper::appdata()->web_secondary_color != null ? helper::appdata()->web_secondary_color : '#FFC344' }};
        }
    </style>
</head>

<body>
<main >
    <div class="img-fluid">
        <!-- Sticky Background Image -->
        <div class=" d-flex justify-content-center align-items-center">
            <div class="auth_form_inner box-login col-12 " >
                <div class="d-lg-flex">
                    <div class="col-lg-4 col-12 px-sm-5 py-4 my-3 px-4">
                        <!-- Authentication Form Body -->
                        <form action="{{ route('adduser') }}" method="POST">
                            @csrf
                            <!-- Authentication Form Inner Content -->
                            <a href="{{ route('home') }}">
                                <img src="{{ helper::image_path(@helper::appdata()->logo) }}" alt=""
                                     class="login-form-logo" loading="lazy" decoding="async"></a>
                            <h5 class="bottom-line py-2 mt-3 mb-0 fw-bold w-auto text-white">{{ trans('labels.signup') }}</h5>
                            <h6 class="fs-7 text-white">{{ trans('labels.signup_note') }}</h6>
                            <div class="form-body mt-4">
                                <div class="form-group mb-md-3 mb-2">
                                    <label class="form-label fs-7 mb-1 text-white"
                                           for="name">{{ trans('labels.full_name') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    @if (session()->has('social_login'))
                                        <input type="text" class="form-control rounded mb-1" name="name"
                                               value="{{ session()->get('social_login')['name'] }}" id="name"
                                               placeholder="{{ trans('labels.full_name') }}" required>
                                    @else
                                        <input type="text" class="form-control rounded mb-1" name="name"
                                               value="{{ old('name') }}" id="name"
                                               placeholder="{{ trans('labels.full_name') }}" required>
                                    @endif
                                </div>
                                <div class="form-group mb-md-3 mb-2">
                                    <label class="form-label fs-7 mb-1 text-white" for="email">{{ trans('labels.email') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    @if (session()->has('social_login'))
                                        <input type="email" class="form-control rounded mb-1" name="email"
                                               value="{{ session()->get('social_login')['email'] }}" id="email"
                                               placeholder="{{ trans('labels.email') }}" required>
                                    @else
                                        <input type="email" class="form-control rounded mb-1" name="email"
                                               value="{{ old('email') }}" id="email"
                                               placeholder="{{ trans('labels.email') }}" required>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="row g-2 mb-md-3 mb-3">
                                        <div class="col-md">
                                            <label class="form-label fs-7 mb-1 text-white"
                                                   for="mobile">{{ trans('labels.mobile') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="tel" id="mobile" name="mobile"
                                                   class="form-control numbers_only rounded"
                                                   placeholder="{{ trans('labels.mobile') }}"
                                                   value="{{ old('mobile') }}" required>
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label fs-7 mb-1 text-white"
                                                   for="referral_code">{{ trans('labels.referral_code') }} </label>
                                            <input type="text" class="form-control rounded" id="referral_code"
                                                   name="referral_code"
                                                   placeholder="{{ trans('labels.referral_code_o') }}"
                                                   @isset($_GET['referral']) value="{{ $_GET['referral'] }}" @endisset>
                                        </div>
                                    </div>
                                </div>
                                @if (!session()->has('social_login'))
                                    @if (@helper::checkaddons('otp'))
                                    @else
                                        <div class="form-group mb-md-3 mb-2">
                                            <div class="row g-2">
                                                <div class="col-md">
                                                    <label class="form-label fs-7 mb-1 text-white"
                                                           for="password">{{ trans('labels.password') }}
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="password" class="form-control rounded mb-1"
                                                           id="password" name="password"
                                                           placeholder="{{ trans('labels.password') }}"
                                                           value="{{ old('password') }}" required>
                                                </div>
                                                <div class="col-md">
                                                    <label class="form-label fs-7 mb-1 text-white"
                                                           for="confirm_password">{{ trans('labels.confirm_password') }}
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="password" class="form-control rounded mb-1"
                                                           id="confirm_password" name="password_confirmation"
                                                           placeholder="{{ trans('labels.confirm_password') }}"
                                                           value="{{ old('password_confirmation') }}" required>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                <div class="form-group">
                                    <input type="checkbox" name="checkbox" id="checkbox" value="1"
                                           required class="form-check-input me-1"
                                        {{ old('checkbox') == 1 ? 'checked' : '' }}>
                                    <label for="checkbox" class="form-check-label m-auto fs-7 text-white">
                                        {{ trans('labels.i_accepts_the') }} <a
                                            href="{{ URL::to('terms-conditions') }}"
                                            class="text-primary text-decoration-none fw-medium">{{ trans('labels.terms_conditions') }}</a></label>
                                </div>
                                <div class="form-group mt-2">
                                    <button type="submit"
                                            class="btn btn-primary w-100">{{ trans('labels.signup') }}</button>
                                </div>
                            </div>
                            <div class="form-group text-center mt-3">
                                <p class="mb-0 fs-7 text-white">
                                    {{ trans('labels.already_account') }}
                                    <a href="{{ 'login' }}"
                                       class="text-primary fw-medium text-decoration-none">{{ trans('labels.signin') }}</a>
                                </p>
                            </div>
                        </form>
                    </div>
                    <div class="image col-8 d-none d-md-block" >
                        <img src="{{ helper::image_path(helper::appdata()->auth_bg_image) }}" class="w-100" style="border-radius: 0px" loading="lazy" decoding="async">
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="{{ url(env('ASSETSPATHURL') . 'web-assets/js/jquery/jquery-3.6.0.js') }}"></script><!-- jQuery JS -->
<script src="{{ url(env('ASSETSPATHURL') . 'web-assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script><!-- Bootstrap JS -->
<!-- COMMON-JS -->
<script src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/toastr/toastr.min.js') }}"></script><!-- Toastr JS -->
<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
    }
    @if (Session::has('success'))
    toastr.success("{{ session('success') }}");
    @endif
    @if (Session::has('error'))
    toastr.error("{{ session('error') }}");
    @endif

    $('.numbers_only').on('keyup', function() {
        "use strict";
        var val = $(this).val();
        if (isNaN(val)) {
            val = val.replace(/[^0-9\.]/g, '');
            if (val.split('.').length > 2) {
                val = val.replace(/\.+$/, "");
            }
        }
        $(this).val(val);
    });
</script>
@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            toastr.error('{{ $error }}');
        </script>
    @endforeach
@endif
<!-- IF VERSION 2  -->
@if (helper::appdata()->recaptcha_version == 'v2')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endif
<!-- IF VERSION 3  -->
@if (helper::appdata()->recaptcha_version == 'v3')
    {!! RecaptchaV3::initJs() !!}
@endif
</body>

</html>
