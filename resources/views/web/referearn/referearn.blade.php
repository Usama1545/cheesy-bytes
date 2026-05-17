@extends('web.layout.default')
@section('page_title')
    | {{ trans('labels.refer_earn') }}
@endsection
@section('content')
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL') . 'web-assets/social-sharing/css/socialsharing.css') }}">
    <div class="breadcrumb-sec">
        <div class="container">
            <div class="breadcrumb-sec-content">
                <nav class="text-dark breadcrumb-divider" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li
                            class="breadcrumb-item {{ session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : '' }}">
                            <a class="text-dark fw-600" href="{{ route('home') }}">{{ trans('labels.home') }}</a>
                        </li>
                        <li class="breadcrumb-item {{ session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : '' }} active"
                            aria-current="page">{{ trans('labels.refer_earn') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section>
        <div class="container my-5">
            <div class="row">
                <div class="col-lg-3">
                    @include('web.layout.usersidebar')
                </div>
                <div class="col-lg-9">
                    <div class="user-content-wrapper">
                        <p class="title border-bottom pb-3">{{ trans('labels.refer_earn') }}</p>
                        <div class="d-flex flex-column align-items-center">
                            <div class="col-sm-4 col-9">
                                <img class="mb-4 w-100 h-100"
                                    src="{{ helper::image_path(helper::appdata()->refer_earn_bg_image) }}">
                            </div>
                            <h5 class="text-uppercase">{{ trans('labels.refer_earn') }}</h5>
                            <p class="fs-7 text-center text-muted">{{ trans('labels.refer_note_1') }}
                                {{ helper::currency_format(@helper::appdata()->referral_amount) }}
                                {{ trans('labels.refer_note_2') }}</p>
                                <div class="col-sm-8">
                                    <input type="url" class="form-control mb-3 bg-gray" id="data"
                                        value="{{ URL::to('/register?referral=' . Auth::user()->referral_code) }}" readonly>
                                </div>
                        </div>
                        <div class="sharing-section d-flex align-items-center justify-content-center"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="{{ url(env('ASSETSPATHURL') . 'web-assets/social-sharing/js/socialsharing.js') }}"></script>
    <script src="{{ url(env('ASSETSPATHURL') . 'web-assets/js/custom/referearn.js') }}"></script>
@endsection
