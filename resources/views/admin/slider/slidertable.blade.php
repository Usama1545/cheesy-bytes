<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th></th>
            <th>#</th>
            <th>{{ trans('labels.image') }}</th>
            <th>{{ trans('labels.title') }}</th>
            <th>{{ trans('labels.category') }}</th>
            <th>{{ trans('labels.item') }}</th>
            <th>{{ trans('labels.description') }}</th>
            <th>{{ trans('labels.status') }}</th>
            <th>{{ trans('labels.created_date') }}</th>
            <th>{{ trans('labels.updated_date') }}</th>
            <th>{{ trans('labels.action') }}</th>
        </tr>
    </thead>
    <tbody id="tabledetails" data-url="{{ url('admin/slider/reorder_slider') }}">
        @php $i = 1; @endphp
        @foreach ($getslider as $slider)
            <tr class="row1" data-id="{{ $slider->id }}">
                <td><a tooltip="{{ trans('labels.move') }}"><i class="fa-light fa-up-down-left-right mx-2"></i></a></td>
                <td>@php echo $i++; @endphp</td>
                <td><img src='{{ helper::image_path($slider->image) }}' class='img-fluid rounded h-50px'></td>
                <td>{{ $slider->title }}</td>
                <td>
                    @if ($slider->type == '1')
                        {{ @$slider['category_info']->category_name }}
                    @else
                        --
                    @endif
                </td>
                <td>
                    @if ($slider->type == '2')
                        {{ @$slider['item_info']->item_name }}
                    @else
                        --
                    @endif
                </td>
                <td>{{ $slider->description }}</td>
                <td>
                    @if ($slider->is_available == 1)
                        <a class="btn btn-sm btn-success square" tooltip="{{ trans('labels.active') }}"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="StatusUpdate('{{ $slider->id }}','2','{{ URL::to('admin/slider/status') }}')" @endif><i
                                class="fa-sharp fa-solid fa-check"></i></a>
                    @else
                        <a class="btn btn-sm btn-danger square" tooltip="{{ trans('labels.deactive') }}"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="StatusUpdate('{{ $slider->id }}','1','{{ URL::to('admin/slider/status') }}')" @endif><i
                                class="fa-sharp fa-solid fa-xmark"></i></a>
                    @endif
                </td>
                <td>
                    {{ helper::date_format($slider->created_at) }} <br>
                    {{ helper::time_format($slider->created_at) }}
                </td>
                <td>
                    {{ helper::date_format($slider->updated_at) }} <br>
                    {{ helper::time_format($slider->updated_at) }}
                </td>
                <td>
                    <div class="d-flex flex-wrap gap-1 ">
                        <a class="btn btn-sm btn-info square" tooltip="{{ trans('labels.edit') }}"
                            href="{{ URL::to('admin/slider-' . $slider->id) }}"><i
                                class="fa-solid fa-pen-to-square"></i></a>
                        <a class="btn btn-sm btn-danger square" tooltip="{{ trans('labels.delete') }}"
                            href="javascript:void(0)"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="DeleteData('{{ $slider->id }}','{{ URL::to('admin/slider/destroy') }}')" @endif><i
                                class="fa fa-trash"></i></a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
