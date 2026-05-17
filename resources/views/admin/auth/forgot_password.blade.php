<!DOCTYPE html>
<html lang="en" dir="{{ session('direction') == 2 ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ @helper::appdata()->title }}</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ helper::image_path(@helper::appdata()->favicon) }}">
    <!-- FAVICON ICON -->
    <link rel="stylesheet"
        href="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/css/bootstrap/bootstrap.min.css') }}">
    <!-- BOOTSTRAP CSS -->
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/css/fontawesome/all.min.css') }}">
    <!-- FONTAWESOME CSS -->
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/css/toastr/toastr.min.css') }}">
    <!-- FONTAWESOME CSS -->
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/css/style.css') }}">
    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/css/responsive.css') }}">
    <!-- RESPONSIVE CSS -->
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
        <div class="col-xl-4 col-lg-5 col-md-6 overflow-hidden bg-black overflow-hidden">
            <div class="login-right-content login-forgot-padding d-flex flex-column">
                <div class="w-100">
                    <div class="img-logo mb-4">
                        <img src="{{ helper::image_path(@helper::appdata()->logo) }}" class="" alt="">
                    </div>
                    <div class="text-primary d-flex justify-content-between">
                        <div>
                            <h2 class="fw-500 text-white title-text mb-2">Forgot password</h2>
                            <p class="text-white fs-7">Enter Your Email To Forgot Your Passwordt</p>
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

                    <form class="my-3" method="POST" action="{{ URL::to('admin/send-pass') }}">
                        @csrf
                        <div class="form-group">
                            <label for="password" class="form-label fs-7 text-white">Email<span class="text-danger">
                                * </span></label>
                            <input id="email" type="email"
                                class="form-control py-2 @error('email') is-invalid @enderror" name="email"
                                required="" autocomplete="email" autofocus
                                placeholder="{{ trans('labels.email') }}"
                                @if (env('Environment') == 'sendbox') value="admin@gmail.com" readonly="" @endif>
                            @error('email')
                                <span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <button class="btn btn-secondary w-100 my-3"
                            @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.send') }}</button>
                        <p class="fs-7 text-center text-white">{{ trans('labels.already_account') }}
                            <a href="{{ URL::to('admin') }}"
                                class="text-secondary fw-semibold py-2">{{ trans('labels.signin') }}</a>
                        </p>
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



    <script src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/jquery/jquery.min.js') }}"></script><!-- JQUERY JS -->
    <script src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script><!-- BOOTSTRAP JS -->
    <script src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/toastr/toastr.min.js') }}"></script><!-- TOASTR JS -->
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

        function myFunction() {
            "use strict";
            toastr.error("This operation was not performed due to demo mode");
        }
    </script>
</body>

</html>
