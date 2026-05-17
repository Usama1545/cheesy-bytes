@extends('web.layout.default')
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
                            <a class="text-muted" href="javascript:void(0)">{{ trans('labels.testimonials') }}</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section>
        <div class="testimonials-wrapper-1">
            <div class="container">
                @if (count($testimonials) > 0)
                    <div class="row mt-5 mb-3">
                        @foreach ($testimonials as $testimonialdata)
                            <div class="col-lg-4 col-md-6 col-sm-12 d-flex mb-3">
                                <div class="review">
                                    <div class="d-flex taxt-start col-12 p-2">
                                        <img src="{{ $testimonialdata['user_info']->profile_image }}"
                                            class="img-circle img-responsive"/>
                                        <div class="mx-2">
                                            <h4>{{ $testimonialdata['user_info']->name }}</h4>
                                            <div class="review-star">
                                                @if ($testimonialdata->ratting == 1)
                                                    <i class="fa-solid fa-star fs-8"></i>
                                                @elseif($testimonialdata->ratting == 2)
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                @elseif($testimonialdata->ratting == 3)
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                @elseif($testimonialdata->ratting == 4)
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                @elseif($testimonialdata->ratting == 5)
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <p class="gray"><span class="text-primary">"</span>{{ Str::limit($testimonialdata->comment, 150) }}<span
                                                class="text-primary">"</span></p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mb-5 d-flex justify-content-center">
                        {{ $testimonials->links() }}
                    </div>
                @else
                    @include('web.nodata')
                @endif
                @if (Auth::user() && Auth::user()->type == 2)
                    @if (!helper::check_review_exist(Auth::user()->id))
                    <div class="col-12 d-flex justify-content-center">
                        <a class="btn btn-primary my-5 px-3 py-2" data-bs-toggle="modal" data-bs-target="#addreviewmodal">{{ trans('labels.add_review') }}<i class="fa-solid fa-plus px-1"></i> </a>
                    </div>
                    @endif
                @else
                <div class="col-12 d-flex justify-content-center">
                    <a class="btn btn-primary my-5 px-3 py-2" href="{{ URL::to('/login') }}">{{ trans('labels.add_review') }}</a>
                </div>
                @endif
            </div>
            <!-- ADD_REVIEW_ODAL_START -->
            <div class="modal fade" id="addreviewmodal" tabindex="-1" aria-labelledby="addreviewmodalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title fw-bold" id="addreviewmodalLabel">{{ trans('labels.add_review') }}</h4>
                            <button type="button" class="btn-close {{ session()->get('direction') == 2 ? 'close' : '' }}" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ URL::to('/add-review') }}" method="POST" class="mb-0">
                            @csrf
                            <div class="modal-body">
                                <div class="form-body">
                                    <div class="form-group col-lg-12 text-center">
                                        <div class="review border-0 py-2">
                                            <img src="{{ helper::image_path(@Auth::user()->profile_image) }}"
                                                class="img-circle img-responsive mb-0" />
                                            <h4 class="mb-0 mt-3">{{ @Auth::user()->name }}</h4>
                                        </div>
                                        <div class="star-rating">
                                            @for ($i = 5; $i > 0; $i=$i-1)
                                                <input type="radio" id="{{$i}}" name="rating" onclick="$('#ratting').val('{{$i}}')" {{$i == 1 ? 'checked' : ''}}>
                                                <label for="{{$i}}"><i class="fa-solid fa-star" aria-hidden="true"></i></label>
                                            @endfor
                                            @error('ratting')
                                                <span class="text-danger"> <br> {{ $message }} </span>
                                            @enderror
                                        </div>
                                        <input type="hidden" name="ratting" id="ratting" value="1">
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <textarea name="message" rows="4" class="form-control" placeholder="Message" required></textarea>
                                        @error('message')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-center border-0">
                                <button type="button" class="btn btn-outline-danger px-4 py-2 fs-7" data-bs-dismiss="modal">{{ trans('labels.close') }}</button>
                                <button type="submit" class="btn btn-primary px-4 py-2 fs-7">{{ trans('labels.save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- ADD_REVIEW_ODAL_END -->
        </div>
    </section>

@endsection
