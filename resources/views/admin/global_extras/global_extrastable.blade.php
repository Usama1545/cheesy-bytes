<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th></th>
            <th>#</th>
            <th>{{ trans('labels.name') }}</th>
            <th>{{ trans('labels.price') }}</th>
            <th>{{ trans('labels.status') }}</th>
            <th>{{ trans('labels.created_date') }}</th>
            <th>{{ trans('labels.updated_date') }}</th>
            <th>{{ trans('labels.action') }}</th>
        </tr>
    </thead>
    <tbody id="tabledetails" data-url="{{ url('admin/global_extras/reorder_global') }}">
        @php $i=1; @endphp
        @foreach ($globals as $extras)
            <tr class="row1" id="dataid{{ $extras->id }}" data-id="{{ $extras->id }}">
                <td><a tooltip="{{ trans('labels.move') }}"><i class="fa-light fa-up-down-left-right mx-2"></i></a></td>
                <td>@php echo $i++ @endphp</td>
                <td>{{ $extras->name }}</td>
                <td>{{ helper::currency_format($extras->price) }}</td>
                <td>
                    @if ($extras->is_available == 1)
                        <a class="btn btn-sm btn-success square hov" tooltip="{{ trans('labels.active') }}"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else  onclick="StatusUpdate('{{ $extras->id }}','2','{{ URL::to('admin/global_extras/status') }}')" @endif><i
                                class="fa-sharp fa-solid fa-check"></i></a>
                    @else
                        <a class="btn btn-sm btn-danger square hov" tooltip="{{ trans('labels.deactive') }}"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else  onclick="StatusUpdate('{{ $extras->id }}','1','{{ URL::to('admin/global_extras/status') }}')" @endif><i
                                class="fa-sharp fa-solid fa-xmark"></i></a>
                    @endif
                </td>
                <td>{{ helper::date_format($extras->created_at) }}<br>
                    {{ helper::time_format($extras->created_at) }}
                </td>
                <td>{{ helper::date_format($extras->updated_at) }}<br>
                    {{ helper::time_format($extras->updated_at) }}
                </td>
                <td>
                    <div class="d-flex flex-wrap gap-1">
                        <a href="{{ URL::to('admin/global_extras-' . $extras->id) }}" tooltip="{{ trans('labels.edit') }}"
                            class="btn btn-info square btn-sm hov">
                            <i class="fa fa-pen-to-square"></i></a>
    
                        <a class="btn btn-sm btn-danger square hov" tooltip="{{ trans('labels.delete') }}"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else  onclick="Delete('{{ $extras->id }}','{{ URL::to('admin/global_extras/delete') }}')" @endif><i
                                class="fa fa-trash"></i></a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
