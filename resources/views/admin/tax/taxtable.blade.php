<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th></th>
            <th>#</th>
            <th>{{ trans('labels.name') }}</th>
            <th>{{ trans('labels.tax') }}</th>
            <th>{{ trans('labels.status') }}</th>
            <th>{{ trans('labels.created_date') }}</th>
            <th>{{ trans('labels.updated_date') }}</th>
            <th>{{ trans('labels.action') }}</th>
        </tr>
    </thead>
    <tbody id="tabledetails" data-url="{{ url('admin/tax/reorder_tax') }}">
        @php $i = 1 @endphp
        @foreach ($gettax as $tax)
            <tr class="row1" data-id="{{ $tax->id }}">
                <td><a tooltip="{{ trans('labels.move') }}"><i class="fa-light fa-up-down-left-right mx-2"></i></a></td>
                <td>@php echo $i++ @endphp</td>
                <td>{{ $tax->name }}</td>
                <td>
                    @if ($tax->type == 1)
                        {{ helper::currency_format($tax->tax) }}
                    @else
                        {{ $tax->tax }}%
                    @endif
                </td>
                <td>
                    @if ($tax->is_available == 1)
                        <a class="btn btn-sm btn-success square hov" tooltip="{{ trans('labels.active') }}"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="StatusUpdate('{{ $tax->id }}','2','{{ URL::to('admin/tax/status') }}')" @endif><i
                                class="fa-sharp fa-solid fa-check"></i></a>
                    @else
                        <a class="btn btn-sm btn-danger square hov" tooltip="{{ trans('labels.deactive') }}"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="StatusUpdate('{{ $tax->id }}','1','{{ URL::to('admin/tax/status') }}')" @endif><i
                                class="fa-sharp fa-solid fa-xmark"></i></a>
                    @endif
                </td>
                <td>
                    {{ helper::date_format($tax->created_at) }} <br>
                    {{ helper::time_format($tax->created_at) }}
                </td>
                <td>
                    {{ helper::date_format($tax->updated_at) }} <br>
                    {{ helper::time_format($tax->updated_at) }}
                </td>
                <td>
                    <div class="d-flex flex-wrap gap-1">
                        <a class="btn btn-sm btn-info square hov" tooltip="{{ trans('labels.edit') }}"
                            href="{{ URL::to('admin/tax-' . $tax->id) }}"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a class="btn btn-sm btn-danger square hov" tooltip="{{ trans('labels.delete') }}"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="Delete('{{ $tax->id }}','{{ URL::to('admin/tax/delete') }}')" @endif><i
                                class="fa fa-trash"></i></a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
