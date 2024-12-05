@extends('web.layout.default')
@section('page_title')
    | {{ trans('labels.my_addresses') }}
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
                            aria-current="page">{{ trans('labels.my_addresses') }}</li>
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
                    <div class="user-content-wrapper">
                        <div class="d-flex flex-wrap gap-2 justify-content-between mb-3 border-bottom pb-3">
                            <p class="col-auto mb-0 title">{{ trans('labels.my_addresses') }}</p>
                            <a href="{{ route('add-address') }}"
                                class="col-auto py-2 px-4 text-capitalize btn btn-primary text-white btn btn-sm d-flex align-items-center">{{ trans('labels.add_new_address') }}
                                <i class="fa-solid fa-plus px-2"></i></a>
                        </div>
                        @if (count($getaddresses) > 0)
                            <div class="row mb-3">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="rounded-top">
                                            <tr class="bg-light align-middle">
                                                <th class="fs-7 fw-600">#</th>
                                                <th class="fs-7 fw-600">{{ trans('labels.title') }}</th>
                                                <th class="fs-7 fw-600">{{ trans('labels.address') }}</th>
                                                <th class="fs-7 fw-600">{{ trans('labels.default') }}</th>
                                                <th class="fs-7 fw-600">{{ trans('labels.action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="rounded-bottom">
                                            @php $i = 1; @endphp
                                            @foreach ($getaddresses as $item)
                                                <tr class="align-middle">
                                                    <td class="fs-7 fw-600">@php echo $i++; @endphp</td>
                                                    <td class="fs-7 fw-600">{{ $item->title }}</td>
                                                    <td class="fs-7">{{ $item->address }} </td>
                                                    <td class="fs-7">
                                                        @if ($item->is_default == 1)
                                                            <a class="btn btn-sm btn-address-status bg-success text-white border-success"
                                                                onclick="StatusUpdate('{{ $item->id }}','2','{{ URL::to('address/status') }}')"><i
                                                                    class="fa-sharp fa-solid fa-check"></i></a>
                                                        @else
                                                            <a class="btn btn-sm btn-address-status bg-danger text-white border-danger"
                                                                onclick="StatusUpdate('{{ $item->id }}','1','{{ URL::to('address/status') }}')"><i
                                                                    class="fa-sharp fa-solid fa-xmark"></i></a>
                                                        @endif
                                                    </td>

                                                    <td class="fs-7">
                                                        <div class="px-3">
                                                            <a class="text-danger mx-1" href="javascript:void(0)"
                                                                onclick="deleteaddress('{{ $item->id }}','{{ URL::to('/address/delete') }} ') "><i
                                                                    class="fa-solid fa-trash-can"></i></a>
                                                            <a class="text-info mx-1"
                                                                href="{{ URL::to('/address-' . $item->id) }}"><i
                                                                    class="fa-solid fa-pen-to-square"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                {{ $getaddresses->appends(request()->query())->links() }}
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
    <script src="{{ url(env('ASSETSPATHURL') . 'web-assets/js/custom/address.js') }}"></script>
@endsection
