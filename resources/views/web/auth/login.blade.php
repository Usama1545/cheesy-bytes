<!doctype html>
<html lang="en" dir="{{ session('direction') == 2 ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title> {{ @helper::appdata()->title }} | {{ trans('labels.signin') }} </title>
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
<main class="">
    <div class="img-fluid">
        <!-- Sticky Background Image -->
        <div class=" d-flex justify-content-center align-items-center">
            <div class="auth_form_inner box-login col-12 ">
                <!-- Authentication Form Body -->
                <div class="d-lg-flex">
                    <div class="col-lg-4 col-12 p-sm-5 p-4">
                        <form action="{{ URL::to('/checklogin') }}" method="POST">
                            @csrf
                            <a href="{{ route('home') }}">
                                <img src="{{ helper::image_path(@helper::appdata()->logo) }}" alt=""
                                     class="login-form-logo"></a>
                            <h5 class="bottom-line py-2 mt-3 m-0 fw-bold text-white">{{ trans('labels.sign_to_continue') }}</h5>
                            <h6 class="fs-7 text-white">{{ trans('labels.sign_in_note') }}</h6>
                            <div class="form-body mt-4">
                                @if (@helper::checkaddons('otp'))
                                    <div class="col-md">
                                        <label class="text-black form-label text-white"
                                               for="mobile">{{ trans('labels.mobile') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <input type="text" id="mobile" name="mobile"
                                                   class="form-control numbers_only rounded mb-3"
                                                   placeholder="{{ trans('labels.mobile') }}"
                                                   value="{{ old('mobile') }}" required>
                                        </div>
                                    </div>
                                @else
                                    <div class="form-group mb-3">
                                        <label class="text-black form-label fs-7 mb-1 text-white">{{ trans('labels.email') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="email" name="email" class="form-control custom-input mb-1"
                                               placeholder="{{ trans('labels.email') }}" required
                                               @if (env('Environment') == 'sendbox') value="user@gmail.com" @endif>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label
                                            class="text-black form-label fs-7 mb-1 text-white">{{ trans('labels.password') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="password" name="password"
                                               class="form-control custom-input mb-1"
                                               placeholder="{{ trans('labels.password') }}" required
                                               @if (env('Environment') == 'sendbox') value="123456" @endif>
                                    </div>
                                    <div class="form-group d-flex justify-content-end">
                                        <a href="{{ URL::to('forgot-password') }}"
                                           class="text-primary fw-medium fs-7 float-end">{{ trans('labels.forgot_password_q') }}</a>
                                    </div>
                                @endif
                                <div class="form-group mt-3">
                                    <button type="submit"
                                            class="btn btn-primary w-100">{{ trans('labels.signin') }}</button>
                                </div>
                            </div>
                            <div class="or_section">
                                <div class="line ms-4"></div>
                                <p class="mb-0 fw-light text-white">{{ trans('labels.or') }}</p>
                                <div class="line me-4"></div>
                            </div>
                            <div class="row social_icon">
                                <div class="col d-sm-flex justify-content-center text-center d-sm-flex p-0">
                                    @if (@helper::checkaddons('google_login'))
                                        @if (helper::appdata()->google_mode == 1)
                                            <div class="col-sm-5 col bg-white rounded-2 py-2 m-2">
                                                <a
                                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else href="{{ URL::to('login/google') }}" @endif>
                                                    <img src="{{ helper::web_image_path('google.svg') }}"
                                                         alt="social-icon" class="brands-logo"><span
                                                        class="text-dark px-1">Sign in</span>
                                                </a>
                                            </div>
                                        @endif
                                    @endif
                                    @if (@helper::checkaddons('facebook_login'))
                                        @if (helper::appdata()->facebook_mode == 1)
                                            <div class="col-sm-5 col bg-white rounded-2 py-2 m-2">
                                                <a
                                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else href="{{ URL::to('login/facebook') }}" @endif>
                                                    <img src="{{ helper::web_image_path('facebook.svg') }}"
                                                         alt="social-icon" class="brands-logo"><span
                                                        class="text-dark px-1">Sign in</span>
                                                </a>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="m-3 text-center">
                                <p class="text-white mb-0 fs-7">
                                    {{ trans('labels.dont_account') }}
                                    <a href="{{ 'register' }}"
                                       class="text-primary fw-medium ">{{ trans('labels.signup') }}</a>
                                </p>
                            </div>
                        </form>
                    </div>
                    <div class="image col-8 d-none d-md-block">
                        <img src="{{ helper::image_path(helper::appdata()->auth_bg_image) }}" class="w-100" style="border-radius: 0px">
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="{{ url(env('ASSETSPATHURL') . 'web-assets/js/jquery/jquery-3.6.0.js') }}"></script><!-- jQuery JS -->
<script src="{{ url(env('ASSETSPATHURL') . 'web-assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script><!-- Bootstrap JS -->
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
</script>
<script>
    function myFunction() {
        "use strict";
        toastr.error("This operation was not performed due to demo mode");
    }
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
</body>

</html>
