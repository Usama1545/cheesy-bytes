<!DOCTYPE html>
<html lang="en" dir="{{ session('direction') == 2 ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ @helper::appdata()->title }}</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ helper::image_path(@helper::appdata()->favicon) }}">
    <!-- Favicon icon -->
    <link rel="stylesheet"
        href="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/css/bootstrap/bootstrap.min.css') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/css/fontawesome/all.min.css') }}">
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/css/toastr/toastr.min.css') }}">
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/css/style.css') }}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/css/responsive.css') }}">
    <!-- Responsive CSS -->
    <style>
        :root {
            --bs-primary: {{ @helper::appdata()->admin_primary_color != null ? @helper::appdata()->admin_primary_color : '#01112B' }};
            --bs-secondary: {{ @helper::appdata()->admin_secondary_color != null ? @helper::appdata()->admin_secondary_color : '#0a98af' }};
        }
    </style>
</head>

<body>
    @include('admin.theme.preloader')


    <div class="row align-items-center g-0 w-100 h-100vh position-relative login-admin">
        <div class="col-xl-4 col-lg-5 col-md-6 overflow-hidden overflow-hidden" style="background-color: #D6B62B">
            <div class="login-right-content login-forgot-padding d-flex flex-column">
                <div class="w-100">
                    <div class="img-logo mb-4">
                        <img src="{{ helper::image_path(@helper::appdata()->logo) }}" class="" alt="">
                    </div>
                    <div class="text-primary d-flex justify-content-between">
                        <div>
                            <h2 class="fw-500 text-white title-text mb-2">Sign In</h2>
                            <p class="text-white fs-7">Please Login to continue to your account</p>
                        </div>
                        <!-- language -->
                        <div class="lag-btn dropdown border-0 shadow-none login-lang">
                            <button class="btn px-2 py-1 border-white" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="fa-solid fa-globe fs-6 text-white"></i>
                            </button>
                            <ul class="dropdown-menu drop-menu shadow border-0 drop-menu">
                                @foreach (helper::language() as $lang)
                                    <li>
                                        <a class="dropdown-item d-flex text-start d-flex"
                                            href="{{ URL::to('/language-' . $lang->code) }}">
                                            <img src="{{ helper::image_path($lang->image) }}" alt=""
                                                class="img-fluid mx-1 rounded-5 language-width">
                                            {{ $lang->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>

                    <form class="my-3" method="POST" action="{{ URL::to('/admin/check-login') }}" id="login-form">
                        @csrf
                        <div class="form-group">
                            <label for="email" class="form-label fs-7 text-white">Email<span class="text-danger">
                                *
                            </span></label>
                            <input id="email" type="email"
                                class="form-control py-2 @error('email') is-invalid @enderror" name="email"
                                required="" autocomplete="email" autofocus placeholder="{{ trans('labels.email') }}">
                            @error('email')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group">

                            <label for="password" class="form-label fs-7 text-white">Password<span class="text-danger">
                                * </span></label>
                            <div class="form-control d-flex align-items-center gap-3">
                                <input id="password" type="password"
                                    class="form-control border-0 p-0 @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="current-password"
                                    placeholder="{{ trans('labels.password') }}">
                                <span>
                                    <a href="#"><i class="fa-light fa-eye-slash" id="eye"></i></a>
                                </span>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="d-flex flex-wrap">
                            <div class="form-group mb-2 col-sm-6 col-12 d-flex align-items-center">
                                <input class="form-check-input secondary mt-0" type="checkbox" value="" name="check_terms"
                                    id="check_terms" checked="" required="">
                                <label class="form-check-label cursor-pointer mx-1" for="check_terms">
                                    <span class="fs-7 text-white">
                                        Remember me
                                    </span>
                                </label>
                            </div>

                            <div class="mb-2 col-sm-6 col-12 text-sm-end">
                                <a href="{{ URL::to('admin/forgot-password') }}" class="text-white fs-7 fw-500">
                                    <i
                                        class="fa-solid fa-lock-keyhole fs-7 {{ session()->get('direction') == 2 ? 'ms-1' : 'me-1' }}"></i>{{ trans('labels.forgot_password_q') }}
                                </a>
                            </div>
                        </div>

                        <button class="btn btn-secondary w-100 py-2 my-3" type="submit" id="login-btn">{{ trans('labels.signin') }}</button>


                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-8 col-lg-7 col-md-6 d-md-block d-none">

            <div class="image-1">
                <img src="{{helper::image_path(@helper::appdata()->auth_bg_image)}}"
                    alt="" class="object h-100vh">
            </div>
        </div>
    </div>



    <script src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/jquery/jquery.min.js') }}"></script><!-- jQuery JS -->
    <script src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script><!-- Bootstrap JS -->
    <script src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/toastr/toastr.min.js') }}"></script><!-- Toastr JS -->
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function () {
            let audioContext = new (window.AudioContext || window.webkitAudioContext)();
            
            function enableAudio() {
                if (audioContext.state === "suspended") {
                    audioContext.resume().then(() => {
                        console.log("Audio enabled after login.");
                    }).catch(error => {
                        console.error("Error enabling audio:", error);
                    });
                }
            }
    
            // Attach to login button
            document.getElementById("login-btn").addEventListener("click", enableAudio);
        });
    </script>

    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        @if (Session::has('success'))
            toastr.success("{{ session('success') }}");
        @endif
        @if (Session::has('error'))
            toastr.error("{{ session('error') }}");
        @endif
        $(window).on("load", function() {
            "use strict";
            $('#preloader').fadeOut('slow')
        });
    </script>
    <script>
        function AdminFill(email, password) {
            $('#email').val(email);
            $('#password').val(password);
        }

        $(document).on("click", "#admin_free_addon_login", function() {
            $("#admin_free_addon_login").attr("disabled", true);

            $("#email").val('admin@gmail.com');
            $("#password").val('123456');
            SessionSave('free-addon');
        });

        $(document).on("click", "#all-addon", function() {
            $("#all-addon").attr("disabled", true);

            $("#email").val('admin@gmail.com');
            $("#password").val('123456');
            SessionSave('all-addon');
        });

        function SessionSave(addon = null) {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                dataType: "json",
                url: "{{ URL::to('add-on/session/save') }}",
                data: {
                    'demo_type': addon,
                },
                success: function(response) {
                    $('#login-form').submit();
                }
            });
        }
    </script>
</body>

</html>
