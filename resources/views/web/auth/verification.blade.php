<!doctype html>
<html lang="en" dir="{{ session('direction') == 2 ? 'rtl' : 'ltr' }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title> {{ @helper::appdata()->title }} | {{ trans('labels.otp_verification') }} </title>
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
            <!-- Sticky Background Image -->
            <div class="auth_form_container container d-flex justify-content-center align-items-center">
                <div class="auth_form_inner box-login col-12">
                    <div class="d-lg-flex">
                        <div class="col-lg-4 col-12 px-sm-5 py-4 my-3 px-4">
                            <!-- Authentication Form Body -->
                            <form action="{{ URL::to('verify-otp') }}" method="POST">
                                @csrf
                                <div class="text-center">
                                    <a href="{{ route('home') }}">
                                        <img src="{{ helper::image_path(@helper::appdata()->logo) }}" alt=""
                                            class="login-form-logo pb-2">
                                    </a>
                                    <h5 class="p-3 text-white bottom-line fw-bold w-auto text-white">
                                        {{ @helper::appdata()->short_title }}</h5>
                                </div>
                                <div class="m-3">
                                    <h5 class="text-center text-capitalize text-white fw-bold fs-2 mb-1">
                                        {{ trans('labels.otp_verification') }}</h5>
                                    <p class="text-white text-center">{{ trans('labels.otp_note') }} </p>
                                    <p class="text-white text-center">
                                        <strong>{{ session()->get('verification_email') }}</strong>
                                    </p>
                                </div>
                                <div class="m-3">
                                    <input type="text" name="otp" class="form-control rounded"
                                        placeholder="{{ trans('labels.otp') }}" required
                                        @if (env('Environment') == 'sendbox') value="{{ session()->get('verification_otp') }}" readonly @else value="{{ old('otp') }}" @endif>
                                </div>
                                <div class="m-3 d-grid">
                                    <button type="submit"
                                        class="btn btn-primary">{{ trans('labels.verify_proceed') }}</button>
                                </div>
                            </form>
                            <span
                                class="m-3 d-flex align-content-center align-items-center justify-content-center fw-bold text-white"
                                id="timer"></span>
                            <div class="m-3 d-flex align-content-center align-items-center justify-content-center d-none"
                                id="resend">
                                <p class="text-white mb-0">{{ trans('labels.dont_receive_otp') }}</p>
                                <a href="{{ URL::to('resend-otp') }}" class="text-primary fw-bold ms-1">
                                    {{ trans('labels.resend_otp') }}</a></p>
                            </div>
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
    </script>
    <script>
        let timerOn = true;
        timer(120);

        function timer(remaining) {
            var m = Math.floor(remaining / 60);
            var s = remaining % 60;
            m = m < 10 ? '0' + m : m;
            s = s < 10 ? '0' + s : s;
            document.getElementById('timer').innerHTML = m + ':' + s;
            remaining -= 1;
            if (remaining >= 0 && timerOn) {
                setTimeout(function() {
                    timer(remaining);
                }, 1000);
                return;
            }
            if (!timerOn) {
                return;
            }
            $('#timer').addClass('d-none');
            $('#resend').removeClass('d-none');
        }
    </script>
</body>

</html>
