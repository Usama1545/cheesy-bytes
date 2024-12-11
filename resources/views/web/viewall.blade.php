@extends('web.layout.default')
@section('page_title')
    | {{ trans('labels.view_all') }}
@endsection
@section('content')
    @if (isset($_GET['type']) && $_GET['type'] != '')
        <div class="breadcrumb-sec">
            <div class="container">
                <div class="breadcrumb-sec-content">
                    @php
                        $type = $_GET['type'];
                        if ($_GET['type'] == 'topitems') {
                            $title = trans('labels.trending');
                        } elseif ($_GET['type'] == 'todayspecial') {
                            $title = trans('labels.todays_special');
                        } elseif ($_GET['type'] == 'recommended') {
                            $title = trans('labels.recommended');
                        } elseif ($_GET['type'] == 'topdeals') {
                            $title = trans('labels.top_deals');
                        } else {
                            $title = '';
                        }
                    @endphp
                    <nav class="text-dark breadcrumb-divider" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li
                                class="breadcrumb-item {{ session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : '' }}">
                                <a class="text-dark fw-600" href="{{ URL::to('/') }}">{{ trans('labels.home') }}</a>
                            </li>
                            <li class="breadcrumb-item {{ session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : '' }} active"
                                aria-current="page"> {{ $title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

    @endif
    <div class="container mt-2" >
        @if ($_GET['type'] == 'topdeals')
            <div class="countdown" id="topdeals">
                <div class="countdown-counter rounded-3 mb-5 p-3" id="countdown"></div>
            </div>
        @endif
        <div class="row mb-5">
            <div class="menu my-0">
                @if (count($getsearchitems) > 0)
                    <div class="row g-4">
                        @foreach ($getsearchitems as $itemdata)
                            @include('web.home1.itemview')
                        @endforeach
                    </div>
                    <div class="mt-5 d-flex justify-content-center">
                        {{ $getsearchitems->appends(request()->query())->links() }}
                    </div>
                @else
                    @include('web.nodata')
                @endif
            </div>
        </div>
    </div>


@endsection
@section('scripts')
    <script>
        var topdeals = "{{ !empty(@$getsearchitems) ? 1 : 0 }}";
    </script>
@endsection
