@extends('web.layout.default')
@section('page_title')
    | {{ trans('labels.categories') }}
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
                            class="breadcrumb-item {{ session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : '' }} active">
                            {{ trans('labels.categories') }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row g-3 mb-3 mt-5">
            @foreach (helper::get_categories() as $categorydata)
                <div class="col-lg-2-4 col-md-3 col-sm-4 col-12">
                    <div class="category-wrapper mx-2" style="width: 270px; height: 270px">
                        <a href="{{ URL::to('/menu/?category=' . $categorydata->slug) }}">

                                <img src="{{ helper::image_path($categorydata->image) }}" class="" style="width: 165px;height: 160px"
                                    alt="category">
                        </a>
                        <p class="my-2 text-start">{{ $categorydata->category_name }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <style>
        @media (min-width: 992px) {
            .col-lg-2-4 {
                flex: 0 0 20%;  /* Makes the columns take up 20% of the container on large screens */
                max-width: 20%;
            }
        }

    </style>
@endsection
