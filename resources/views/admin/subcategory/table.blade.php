<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th></th>
            <th>#</th>
            <th>{{ trans('labels.subcategory') }}</th>
            <th>{{ trans('labels.category') }}</th>
            <th>{{ trans('labels.status') }}</th>
            <th>{{ trans('labels.created_date') }} </th>
            <th>{{ trans('labels.updated_date') }} </th>
            <th>{{ trans('labels.action') }}</th>
        </tr>
    </thead>
    <tbody id="tabledetails" data-url="{{ url('admin/sub-category/reorder_subcategory') }}">
        @php $i = 1; @endphp
        @foreach ($getsubcategory as $category)
            <tr class="row1" data-id="{{ $category->id }}">
                <td><a tooltip="{{ trans('labels.move') }}"><i class="fa-light fa-up-down-left-right mx-2"></i></a></td>
                <td>@php echo $i++; @endphp</td>
                <td>{{ $category->subcategory_name }}</td>
                <td>{{ @$category['category_info']->category_name }}</td>
                <td>
                    @if ($category->is_available == 1)
                        <a class="btn btn-sm btn-success square" tooltip="{{ trans('labels.active') }}"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="StatusUpdate('{{ $category->id }}','2','{{ URL::to('admin/sub-category/status') }}')" @endif><i
                                class="fa-sharp fa-solid fa-check"></i></a>
                    @else
                        <a class="btn btn-sm btn-danger square" tooltip="{{ trans('labels.deactive') }}"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="StatusUpdate('{{ $category->id }}','1','{{ URL::to('admin/sub-category/status') }}')" @endif><i
                                class="fa-sharp fa-solid fa-xmark"></i></a>
                    @endif
                </td>
                <td>
                    {{ helper::date_format($category->created_at) }} <br>
                    {{ helper::time_format($category->created_at) }}
                </td>
                <td>
                    {{ helper::date_format($category->updated_at) }} <br>
                    {{ helper::time_format($category->updated_at) }}
                </td>
                <td>
                    <div class="d-flex flex-wrap gap-1">
                        <a class="btn btn-sm btn-info square" tooltip="{{ trans('labels.edit') }}"
                            href="{{ URL::to('admin/sub-category-' . $category->id) }}"><i
                                class="fa-solid fa-pen-to-square"></i></a>
                        <a class="btn btn-sm btn-danger square" tooltip="{{ trans('labels.delete') }}"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="Delete('{{ $category->id }}','{{ URL::to('admin/sub-category/delete') }}')" @endif><i
                                class="fa fa-trash"></i></a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
