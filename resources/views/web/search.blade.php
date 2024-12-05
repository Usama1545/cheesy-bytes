@extends('web.layout.default')
@section('page_title')
    | {{ trans('labels.search') }}
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
                            <a class="text-muted" href="javascript:void(0)">{{ trans('labels.search') }}</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section>
        <div class="container mt-5">
            <div class="menu-section menu-section-header">
                <form action="{{ URL::to('/search') }}" method="get">
                    <div class="form-group">
                        <div class="input-group input-group-lg gap-sm-3 gap-2">
                            <input type="text" class="form-control rounded" name="itemname"
                                placeholder="{{ trans('labels.search_here') }}" required
                                @isset($_GET['itemname']) value="{{ $_GET['itemname'] }}" @endisset>
                            <button class="input-group-text rounded fs-6 bg-gray mb-0" type="submit"
                                id="inputGroup-sizing-lg">{{ trans('labels.search') }}
                                <i class="fa-solid fa-magnifying-glass px-2"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="container">
            <div class="row my-5">
                <div class="menu m-0">
                    @if (count($getsearchitems) > 0)
                        <div class="row boxes g-4">
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
    </section>
@endsection
