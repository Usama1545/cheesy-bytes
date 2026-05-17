<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th></th>
            <th>#</th>
            <th>{{ trans('labels.offer_name') }}</th>
            <th>{{ trans('labels.offer_code') }}</th>
            <th>{{ trans('labels.discount') }}</th>
            <th>{{ trans('labels.status') }} </th>
            <th>{{ trans('labels.created_date') }} </th>
            <th>{{ trans('labels.updated_date') }} </th>
            <th>{{ trans('labels.action') }}</th>
        </tr>
    </thead>
    <tbody id="tabledetails" data-url="{{ url('admin/promocode/reorder_promocode') }}">
        @php $i = 1; @endphp
        @foreach ($getpromocode as $promocode)
            <tr class="row1" data-id="{{ $promocode->id }}">
                <td><a tooltip="{{ trans('labels.move') }}"><i class="fa-light fa-up-down-left-right mx-2"></i></a></td>
                <td>@php echo $i++; @endphp</td>
                <td>{{ $promocode->offer_name }}</td>
                <td>{{ $promocode->offer_code }}</td>
                <td>{{ $promocode->offer_type == 1 ? helper::currency_format($promocode->offer_amount) : $promocode->offer_amount . '%' }}
                </td>
                <td>
                    @if ($promocode->is_available == 1)
                        <a class="btn btn-sm btn-success square" tooltip="{{ trans('labels.active') }}"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="StatusUpdate('{{ $promocode->id }}','2','{{ URL::to('admin/promocode/status') }}')" @endif><i
                                class="fa-sharp fa-solid fa-check"></i></a>
                    @else
                        <a class="btn btn-sm btn-danger square" tooltip="{{ trans('labels.deactive') }}"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="StatusUpdate('{{ $promocode->id }}','1','{{ URL::to('admin/promocode/status') }}')" @endif><i
                                class="fa-sharp fa-solid fa-xmark"></i></a>
                    @endif
                </td>
                <td>
                    {{ helper::date_format($promocode->created_at) }} <br>
                    {{ helper::time_format($promocode->created_at) }}
                </td>
                <td>
                    {{ helper::date_format($promocode->updated_at) }} <br>
                    {{ helper::time_format($promocode->updated_at) }}
                </td>
                <td>
                    <div class="d-flex flex-wrap gap-1">
                        <a class="btn btn-sm btn-info square" tooltip="{{ trans('labels.edit') }}"
                            href="{{ URL::to('admin/promocode-' . $promocode->id) }}"><i
                                class="fa-solid fa-pen-to-square"></i></a>
                        <a class="btn btn-sm btn-danger square" tooltip="{{ trans('labels.delete') }}"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="DeleteData('{{ $promocode->id }}','{{ URL::to('admin/promocode/delete') }}')" @endif><i
                                class="fa-solid fa-trash"></i></a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
