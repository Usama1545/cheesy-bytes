<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('labels.date') }}</th>
            <th>{{ trans('labels.description') }}</th>
            <th>{{ trans('labels.amount') }}</th>
        </tr>
    </thead>
    <tbody>
        @php $i = 1; @endphp
        @foreach ($gettransactions as $tdata)
            <tr>
                <td>@php echo $i++; @endphp</td>
                <td>{{ helper::date_format($tdata->created_at) }}</td>
                <td>
                    @if (in_array($tdata->transaction_type, [101, 102, 103]))
                        {{ trans('labels.wallet_recharge') }}
                        [
                            @if ($tdata->transaction_type == 102)
                                {{ trans('labels.added_by_admin') }}
                            @elseif ($tdata->transaction_type == 103)
                                {{ trans('labels.deducted_by_admin') }}
                            @endif
                        ]
                    @elseif(in_array($tdata->transaction_type, [3, 4, 5, 6 , 7, 8, 9, 10, 11, 12, 13, 14]))
                        {{ helper::getpayment($tdata->transaction_type) }}
                        {{ $tdata->transaction_id }}
                    @elseif ($tdata->transaction_type == 2)
                        {{ trans('labels.order_cancelled') }}
                    @elseif ($tdata->transaction_type == 1)
                        {{ trans('labels.order_placed') }}
                    @elseif ($tdata->transaction_type == 101)
                        {{ trans('labels.referral_earning') }}
                        [{{ $tdata->username }}]
                    @else
                        -
                    @endif
                    @if (in_array($tdata->transaction_type, [1, 2]))
                        [{{ $tdata->order_number }}]
                    @endif
                </td>
                <td
                    class="{{ in_array($tdata->transaction_type, [102, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]) == true ? 'text-success' : 'text-danger' }}">
                    {{ helper::currency_format($tdata->amount) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
