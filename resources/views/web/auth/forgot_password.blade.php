<!doctype html>
<html lang="en" dir="{{ session('direction') == 2 ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title> {{ @helper::appdata()->title }} | {{ trans('labels.forgot_password') }} </title>
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
    <main>
        <div class="img-fluid">
            <div class="d-flex align-items-center justify-content-center vh-100 container">
                <div class="auth_form_inner box-login col-12">
                    <div class="d-lg-flex">
                        <div class="forgot-pass col-lg-4 col-12 px-sm-5 py-sm-5 my-3 px-4 d-flex align-items-center">
                            <form action="{{ route('sendpass') }}" method="POST" class="m-0">
                                @csrf
                                <div>
                                    <a href="{{ route('home') }}">
                                        <img src="{{ helper::image_path(@helper::appdata()->logo) }}" alt=""
                                            class="login-form-logo">
                                    </a>
                                </div>
                                <div class="mb-3">
                                    <h5 class="py-2 mt-3 bottom-line m-0 fw-bold w-auto text-white">
                                        {{ trans('labels.forgot_password') }}</h5>
                                    <p class="fs-7 col-10 text-white">{{ trans('labels.reset_pass_note') }}</p>
                                </div>
                                <div class="my-3">
                                    <div class="bg-transparent">
                                        <div>
                                            <label class="form-label fs-7 mb-1 text-white">{{ trans('labels.email') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group flex-nowrap  mb-1">
                                                <input type="email" name="email" class="form-control"
                                                    placeholder="{{ trans('labels.email') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="my-3 d-grid">
                                    <button
                                        @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                        class="btn btn-primary">{{ trans('labels.submit') }}</button>
                                </div>
                                <div class="my-3 text-center">
                                    <p class="mb-0 fs-7 text-white">
                                        {{ trans('labels.dont_account') }}
                                        <a href="{{ route('register') }}"
                                            class="text-primary fw-bold ">{{ trans('labels.signup') }}</a>
                                    </p>
                                </div>
                            </form>
                        </div>
                        <div class="image col-8">
                            <img src="{{ helper::image_path(helper::appdata()->auth_bg_image) }}" class="w-100">
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
        }
        @if (Session::has('success'))
            toastr.success("{{ session('success') }}");
        @endif
        @if (Session::has('error'))
            toastr.error("{{ session('error') }}");
        @endif

        function myFunction() {
            "use strict";
            toastr.error("This operation was not performed due to demo mode");
        }
    </script>
</body>

</html>
