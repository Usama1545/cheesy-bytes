@extends('web.layout.default')
@section('page_title')
    | {{ trans('labels.my_wallet') }}
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
                            aria-current="page">{{ trans('labels.my_wallet') }}</li>
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
                        <div
                            class="d-flex flex-wrap gap-2 align-items-center justify-content-between mb-3 border-bottom pb-3">
                            <div class="col-auto">
                                <p class="title mb-0">{{ trans('labels.my_wallet') }} :- <small
                                        class="green_color">{{ helper::currency_format(Auth::user()->wallet) }}</small></p>
                            </div>
                            <div class="col-auto"><a href="{{ route('add-money') }}"
                                    class="btn btn-sm text-white bg-primary px-4 py-2"><i
                                        class="fa-solid fa-plus px-1"></i>{{ trans('labels.add_money') }}</a></div>
                        </div>
                        <div class="border-bottom">
                            <ul class="mb-3">
                                <li><i
                                        class="fa-regular fa-circle-check mx-2 text-success"></i>{{ trans('labels.fast_payment') }}
                                </li>
                                <li><i
                                        class="fa-regular fa-circle-check mx-2 text-success"></i>{{ trans('labels.secure_payment') }}
                                </li>
                                <li><i
                                        class="fa-regular fa-circle-check mx-2 text-success"></i>{{ trans('labels.no_document_required') }}
                                </li>
                                <li><i
                                        class="fa-regular fa-circle-check mx-2 text-success"></i>{{ trans('labels.wallet_note') }}
                                </li>
                            </ul>
                        </div>
                        @if (count($gettransactions) > 0)
                            <div class="row mb-3">
                                <div class="table-responsive wallet-history">
                                    <table class="table table-hover">
                                        <thead class="rounded-top">
                                            <tr class="bg-light text-center align-middle">
                                                <th class="fs-7 fw-600">{{ trans('labels.date') }}</th>
                                                <th class="fs-7 fw-600">{{ trans('labels.amount') }}</th>
                                                <th class="fs-7 fw-600">{{ trans('labels.description') }}</th>
                                                <th class="fs-7 fw-600">{{ trans('labels.status') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="rounded-bottom">
                                            @foreach ($gettransactions as $tdata)
                                                <tr class="text-center align-middle">
                                                    <td class="fs-7">{{ helper::date_format($tdata->created_at) }}</td>
                                                    <td
                                                    class="fs-7 {{ in_array($tdata->transaction_type, [101, 102, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]) == true ? 'text-success' : 'text-danger' }}">
                                                    {{ helper::currency_format($tdata->amount) }}</td>
                                                    <td class="fs-7 w-410">

                                                        @if (in_array($tdata->transaction_type, [101, 102, 103]))
                                                            @if ($tdata->transaction_type == 101)
                                                                {{ trans('labels.referral_earning') }}
                                                                [{{ $tdata->username }}]
                                                            @elseif ($tdata->transaction_type == 102)
                                                                {{ trans('labels.wallet_recharge') }}
                                                                {{ trans('labels.added_by_admin') }}
                                                            @elseif ($tdata->transaction_type == 103)
                                                                {{ trans('labels.deducted_by_admin') }}
                                                            @endif
                                                        @elseif(in_array($tdata->transaction_type, [3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]))
                                                            {{ trans('labels.wallet_recharge') }}
                                                            {{ helper::getpayment($tdata->transaction_type) }}
                                                            {{ $tdata->transaction_id }}
                                                        @elseif ($tdata->transaction_type == 2)
                                                            {{ trans('labels.order_cancelled') }}
                                                        @elseif ($tdata->transaction_type == 1)
                                                            {{ trans('labels.order_placed') }}
                                                        @else
                                                            -
                                                        @endif
                                                        @if (in_array($tdata->transaction_type, [1, 2]))
                                                            [{{ $tdata->order_number }}]
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @if (in_array($tdata->transaction_type, [101, 102, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]))
                                                            <div class="badge bg-debit custom-badge rounded-0 bg-completed rounded-1">
                                                                <span class="fw-400">{{ trans('labels.credit') }}</span>
                                                            </div>
                                                        @else
                                                            <div class="badge bg-debit custom-badge bg-cancelled rounded-0 rounded-1">
                                                                <span class="fw-400">{{ trans('labels.debit') }}</span>
                                                            </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                {{ $gettransactions->links() }}
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
