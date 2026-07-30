@extends('web.layout.default')
@section('page_title')
    | {{ trans('labels.gallery') }}
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
                            aria-current="page">{{ trans('labels.gallery') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section>
        <div class="container my-5">
            @if (count($getgalleries) > 0)
                <div id="galleryimg">
                    @foreach ($getgalleries as $image)
                        <div data-src="{{ $image->image_url }}" data-fancybox="gallery"
                            data-thumb="{{ $image->image_url }}">
                            <img src="{{ $image->image_url }}" width="200" height="150" loading="lazy" decoding="async" />
                        </div>
                    @endforeach
                </div>
            @else
                @include('web.nodata')
            @endif
        </div>
    </section>


@endsection
