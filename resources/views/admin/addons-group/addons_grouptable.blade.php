<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th></th>
            <th>#</th>
            <th>{{ trans('labels.name') }}</th>
            <th>{{ trans('labels.selection_type') }}</th>
            <th>{{ trans('labels.selection_count') }}</th>
            <th>{{ trans('labels.status') }}</th>
            <th>{{ trans('labels.created_date') }}</th>
            <th>{{ trans('labels.updated_date') }}</th>
            <th>{{ trans('labels.action') }}</th>
        </tr>
    </thead>
    <tbody id="tabledetails" data-url="{{ url('admin/addongroup/reorder_addongroup') }}">
        @php $i = 1 @endphp
        @foreach ($getaddongroup as $addongroup)
            <tr class="row1" data-id="{{ $addongroup->id }}">
                <td><a tooltip="{{ trans('labels.move') }}"><i class="fa-light fa-up-down-left-right mx-2"></i></a></td>
                <td>@php echo $i++ @endphp</td>
                <td><a href="{{ URL::to('admin/addongroup-' . $addongroup->id) }}">{{ $addongroup->name }}</a></td>
                <td>
                    @if ($addongroup->selection_type == 1)
                        {{ trans('labels.required') }}
                    @elseif ($addongroup->selection_type == 2)
                        {{ trans('labels.optional') }}
                    @endif
                </td>
                <td>
                    @if ($addongroup->selection_count == 1)
                        {{ trans('labels.single') }}
                    @elseif ($addongroup->selection_count == 2)
                        {{ trans('labels.multiple') }}
                        ({{ $addongroup->min_count }})
                    @endif
                </td>
                <td>
                    @if ($addongroup->is_available == 1)
                        <a class="btn btn-sm btn-success square" tooltip="{{ trans('labels.active') }}"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="StatusUpdate('{{ $addongroup->id }}','2','{{ URL::to('admin/addongroup/status') }}')" @endif><i
                                class="fa-sharp fa-solid fa-check"></i></a>
                    @else
                        <a class="btn btn-sm btn-danger square" tooltip="{{ trans('labels.deactive') }}"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="StatusUpdate('{{ $addongroup->id }}','1','{{ URL::to('admin/addongroup/status') }}')" @endif><i
                                class="fa-sharp fa-solid fa-xmark"></i></a>
                    @endif
                </td>
                <td>
                    {{ helper::date_format($addongroup->created_at) }} <br>
                    {{ helper::time_format($addongroup->created_at) }}
                </td>
                <td>
                    {{ helper::date_format($addongroup->updated_at) }} <br>
                    {{ helper::time_format($addongroup->updated_at) }}
                </td>
                <td class="branch-only">
                    <div class="d-flex flex-wrap gap-1">
                        <a class="btn btn-sm btn-info square" tooltip="{{ trans('labels.edit') }}"
                            href="{{ URL::to('admin/addongroup-' . $addongroup->id) }}"><i
                                class="fa-solid fa-pen-to-square"></i></a>
                        <a class="btn btn-sm btn-danger square" tooltip="{{ trans('labels.delete') }}"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="Delete('{{ $addongroup->id }}','{{ URL::to('admin/addongroup/delete') }}')" @endif><i
                                class="fa fa-trash"></i></a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
