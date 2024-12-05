@extends('web.layout.default')
@section('page_title')
    | {{ trans('labels.faq') }}
@endsection
@section('content')
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
                            aria-current="page">{{ trans('labels.faq') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section>
        <div class="container my-5">
            @if (count($getfaqs) > 0)
                <div class="faqs">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="accordion" id="accordionfaq">
                                @foreach ($getfaqs as $key => $faqdata)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="faq{{ $key }}">
                                            <button
                                                class="accordion-button {{ $key == 0 ? '' : 'collapsed' }} {{ session()->get('direction') == '2' ? 'rtl' : '' }} "
                                                type="button" data-bs-toggle="collapse"
                                                data-bs-target="#faqs{{ $key }}" aria-expanded="true"
                                                aria-controls="faqs{{ $key }}">
                                                {{ $faqdata->title }}
                                            </button>
                                        </h2>
                                        <div id="faqs{{ $key }}"
                                            class="accordion-collapse collapse {{ $key == 0 ? 'show' : '' }}"
                                            aria-labelledby="faq{{ $key }}" data-bs-parent="#accordionfaq">
                                            <div class="accordion-body">
                                                {{ $faqdata->description }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-lg-6 col-12 d-md-block d-none">
                            <img src="{{ helper::image_path(@helper::appdata()->faqs_image) }}"
                                class="w-100 object-fit-cover rounded-4" alt="">
                        </div>
                    </div>
                </div>
            @else
                @include('web.nodata')
            @endif
        </div>
    </section>
    @include('web.subscribeform')
@endsection
