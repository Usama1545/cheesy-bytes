@extends('web.layout.default')
@section('page_title')
    | {{ trans('labels.privacy_policy') }}
@endsection
@section('content')
    <div class="breadcrumb-sec">
        <div class="container">
            <div class="breadcrumb-sec-content">
                <nav class="text-dark breadcrumb-divider" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li
                            class="breadcrumb-item {{ session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : '' }}">
                            <a class="text-dark fw-600" href="{{ URL::to('/') }}">{{ trans('labels.home') }}</a>
                        </li>
                        <li class="breadcrumb-item {{ session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : '' }} active"
                            aria-current="page">{{ trans('labels.privacy_policy') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section>
        <div class="container cms-section text-justify my-5">
            @if (@$getprivacypolicy->privacypolicy_content != '')
                <div class="cms-section">
                    <p>
                        {!! $getprivacypolicy->privacypolicy_content !!}
                    </p>
                </div>
            @else
                @include('web.nodata')
            @endif
        </div>
    </section>
    @include('web.subscribeform')
@endsection
