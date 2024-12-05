@extends('web.layout.default')
@section('page_title')
    | {{ trans('labels.my_orders') }}
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
                            aria-current="page">{{ trans('labels.my_orders') }}</li>
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
                <div class="col-lg-9 d-flex">
                    <div class="user-content-wrapper my-order-list">
                        <p class="title border-bottom pb-3">{{ trans('labels.my_orders') }}</p>
                        <div class="border-bottom">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <a href="{{ URL::to('/orders?type=processing') }}"
                                        class="order-status-card {{ isset($_GET['type']) == true ? ($_GET['type'] == 'processing' || $_GET['type'] == '' ? 'border-warning' : '') : (!isset($_GET['type']) == true ? 'border-warning' : '') }}">
                                        <div class="icon bg-light-warning">
                                            <i class="fs-5 fa-solid fa-hourglass-empty"></i>
                                        </div>
                                        <div class="status-card-content px-3">
                                            <p class="text-warning">{{ trans('labels.processing') }}</p>
                                            <h5 class="mb-0 fw-600">{{ $totalprocessing }}</h5>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <a href="{{ URL::to('/orders?type=completed') }}"
                                        class="order-status-card {{ isset($_GET['type']) == true ? ($_GET['type'] == 'completed' ? 'border-green' : '') : '' }}">
                                        <div class="icon bg-light-green">
                                            <i class="fs-5 fa-solid fa-check"></i>
                                        </div>
                                        <div class="status-card-content px-3">
                                            <p class="green_color">{{ trans('labels.completed') }}</p>
                                            <h5 class="mb-0 fw-600">{{ $totalcompleted }}</h5>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <a href="{{ URL::to('/orders?type=cancelled') }}"
                                        class="order-status-card {{ isset($_GET['type']) == true ? ($_GET['type'] == 'cancelled' ? 'border-danger' : '') : '' }}">
                                        <div class="icon bg-light-danger">
                                            <i class="fs-5 fa-solid fa-xmark"></i>
                                        </div>
                                        <div class="status-card-content px-3">
                                            <p class="text-danger">{{ trans('labels.cancelled') }}</p>
                                            <h5 class="mb-0 fw-600">{{ $totalcancelled }}</h5>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @if (count($getorders) > 0)
                            <div class="row mb-3">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="rounded-top">
                                            <tr class="bg-light align-middle">
                                                <th class="fs-7 fw-600">#</th>
                                                <th class="fs-7 fw-600">{{ trans('labels.date') }}</th>
                                                <th class="fs-7 fw-600">{{ trans('labels.order_amount') }}</th>
                                                <th class="fs-7 fw-600">{{ trans('labels.status') }}</th>
                                                <th class="fs-7 fw-600">{{ trans('labels.action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="rounded-bottom">
                                            @foreach ($getorders as $orderdata)
                                                <tr class="align-middle">
                                                    <td class="fs-7 fw-600"> <a
                                                            href="{{ URL::to('orders-' . $orderdata->order_number) }}"
                                                            class="text-dark">#{{ $orderdata->order_number }}</a></td>
                                                    <td class="fs-7">{{ helper::date_format($orderdata->created_at) }}
                                                    </td>
                                                    <td class="fs-7">
                                                        {{ helper::currency_format($orderdata->grand_total) }} </td>
                                                    <td class="fs-7">
                                                        @if ($orderdata->status_type == 1)
                                                            <span
                                                                class="text-order-placed">{{ helper::gettype($orderdata->status, $orderdata->status_type, $orderdata->order_type)->name }}</span>
                                                        @elseif ($orderdata->status_type == 2)
                                                            <span
                                                                class="text-order-waitingpickup">{{ helper::gettype($orderdata->status, $orderdata->status_type, $orderdata->order_type)->name }}</span>
                                                        @elseif ($orderdata->status_type == 3)
                                                            <span
                                                                class="text-order-completed">{{ helper::gettype($orderdata->status, $orderdata->status_type, $orderdata->order_type)->name }}</span>
                                                        @elseif ($orderdata->status_type == 4)
                                                            <span
                                                                class="text-order-cancelled">{{ helper::gettype($orderdata->status, $orderdata->status_type, $orderdata->order_type)->name }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="fs-7">
                                                        <a href="{{ URL::to('orders-' . $orderdata->order_number) }}"
                                                            class="btn btn-information btn-sm mx-1" tooltip="View"><i
                                                                class="fa-regular fa-eye"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                {{ $getorders->appends(request()->query())->links() }}
                            </div>
                        @else
                            @include('web.nodata')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('scripts')
    <script src="{{ url(env('ASSETSPATHURL') . 'web-assets/js/custom/orders.js') }}"></script>
@endsection
