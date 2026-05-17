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
        <div class="col-xl-4 col-lg-5 col-md-6 overflow-hidden bg-black overflow-hidden">
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

                    <form class="my-3" method="POST" action="{{ URL::to('admin/auth') }}">
                        @csrf
                        <div class="form-group">
                            <input id="envato_username" type="text" class="form-control @error('envato_username') is-invalid @enderror" name="envato_username" value="{{ old('envato_username')}}" required autocomplete="envato_username" autofocus placeholder="Envato Username">
                            @error('envato_username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span> 
                            @enderror
                        </div>
                        <div class="form-group">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email')}}" required autocomplete="email" autofocus placeholder="Email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input id="purchase_key" type="text" class="form-control @error('purchase_key') is-invalid @enderror" name="purchase_key" required autocomplete="current-purchase_key" placeholder="Purchase Key">
                            @error('purchase_key')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <?php
                        $text = str_replace('auth', 'admin', url()->current());
                        ?>
                        <div class="form-group">
                            <input id="domain" type="hidden" class="form-control @error('domain') is-invalid @enderror" name="domain" required autocomplete="current-domain" value="{{$text}}" placeholder="domain" readonly="">
                        </div>
                        <button class="btn btn-secondary w-100 my-3"
                            type="submit">{{ trans('labels.submit') }}</button>
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
</body>

</html>
