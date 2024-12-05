@extends('web.layout.default')
@section('page_title')
    | {{ trans('labels.blogs') }}
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
                        <li
                            class="breadcrumb-item {{ session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : '' }}">
                            <a class="text-muted" href="javascript:void(0)">{{ trans('labels.blogs') }}</a>
                        </li>
                        <li
                            class="breadcrumb-item {{ session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : '' }} active">
                            {{ $getblogdata->title }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section>
        <div class="container">
            <div class="col-12 d-flex my-5">
                <div class="blog-details">
                    <div class="card">
                        <img src="{{ helper::image_path($getblogdata->image) }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <div class="row justify-content-between">
                                <div class="col-auto blog-date mb-3">
                                    <span>{{ helper::date_format($getblogdata->created_at) }}</span>
                                </div>
                            </div>
                            <h3 class="card-title fw-600 dark_color mb-3">{{ $getblogdata->title }}</h3>
                            <p class="card-text">{{ $getblogdata->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if (count($recentblogs) > 0)
        <section>
            <div class="blog-wrapper">
                <div class="container">
                    <div class="row align-items-center justify-content-between my-2 px-2">
                        <div class="col-auto blog-heading">
                            <h2 class="fs-1 fw-bold">{{ trans('labels.recent_blogs') }}</h2>
                        </div>
                    </div>
                    <div class="row g-3">
                        @foreach ($recentblogs as $bloglist)
                            @include('web.blogs.blogview')
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        @include('web.subscribeform')
    @endif
@endsection
