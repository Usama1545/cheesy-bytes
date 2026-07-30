@extends('web.layout.default')
@section('page_title')
    | {{ trans('labels.our_team') }}
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
                            <a class="text-muted" href="javascript:void(0)">{{ trans('labels.our_team') }}</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section>
        <div class="testimonials-wrapper">
            <div class="container">
                @if (count($getteams) > 0)
                    <div class="row g-4 my-5">
                        @foreach ($getteams as $teamdata)
                            <div class="col-md-4 col-6">
                                <div class="team-card rounded-4 overflow-hidden">
                                    <div class="member-img overflow-hidden position-relative">
                                        <img src="{{ helper::image_path($teamdata->image) }}"
                                            class="img-circle img-responsive" loading="lazy" decoding="async" />
                                        <div class="team-social">
                                            @if ($teamdata->fb != '')
                                                <div class="icons">
                                                    <a href="{{ $teamdata->fb }}" target="_blank">
                                                        <i class="fa-brands fa-facebook-f text-white"></i>
                                                    </a>
                                                </div>
                                            @endif
                                            @if ($teamdata->youtube != '')
                                                <div class="icons">
                                                    <a href="{{ $teamdata->youtube }}" target="_blank">
                                                        <i class="fa-brands fa-youtube text-white"></i>
                                                    </a>
                                                </div>
                                            @endif
                                            @if ($teamdata->insta != '')
                                                <div class="icons">
                                                    <a href="{{ $teamdata->insta }}" target="_blank">
                                                        <i class="fa-brands fa-instagram text-white"></i>
                                                    </a>
                                                </div>
                                            @endif
                                            @if ($teamdata->twitter != '')
                                                <div class="icons">
                                                    <a href="{{ $teamdata->twitter }}" target="_blank">
                                                        <i class="fa-brands fa-twitter text-white"></i>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="member-details">
                                        <span class="member-name">{{ $teamdata->name }}</span>
                                        <p class="mb-0 fs-7 fw-500">{{ $teamdata->designation }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    @include('web.nodata')
                @endif
            </div>
        </div>
    </section>

@endsection
