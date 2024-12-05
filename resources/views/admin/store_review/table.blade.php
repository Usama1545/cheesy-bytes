<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th></th>
            <th>#</th>
            <th>{{ trans('labels.name') }}</th>
            <th>{{ trans('labels.image') }}</th>
            <th>{{ trans('labels.rating') }}</th>
            <th>{{ trans('labels.description') }}</th>
            <th>{{ trans('labels.created_date') }}</th>
            <th>{{ trans('labels.updated_date') }}</th>
            <th>{{ trans('labels.action') }}</th>
        </tr>
    </thead>
    <tbody id="tabledetails" data-url="{{ url('admin/store-review/reorder_ratting') }}">
        @php $i = 1; @endphp
        @foreach ($getstorereviewlist as $storereview)
            <tr class="row1" data-id="{{ $storereview->id }}">
                <td><a tooltip="{{ trans('labels.move') }}"><i class="fa-light fa-up-down-left-right mx-2"></i></a></td>
                <td>@php echo $i++; @endphp</td>
                <td> {{ $storereview->name }} </td>
                <td>
                    <img src="{{ helper::image_path($storereview->image) }}" alt=""
                        class="img-fluid rounded h-50px mt-1">
                </td>
                <td> {{ $storereview->ratting }} </td>
                <td> {{ $storereview->comment }} </td>
                <td>
                    {{ helper::date_format($storereview->created_at) }} <br>
                    {{ helper::time_format($storereview->created_at) }}
                </td>
                <td>
                    {{ helper::date_format($storereview->updated_at) }} <br>
                    {{ helper::time_format($storereview->updated_at) }}
                </td>
                <td>
                    <div class="d-flex flex-wrap gap-1">
                        <a class="btn btn-sm btn-info square" tooltip="{{ trans('labels.edit') }}"
                            href="{{ URL::to('admin/store-review-' . $storereview->id) }}"><i
                                class="fa fa-pen-to-square"></i></a>
                        <a class="btn btn-sm btn-danger square" tooltip="{{ trans('labels.delete') }}"
                            href="javascript:void(0)"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="DeleteData('{{ $storereview->id }}','{{ URL::to('admin/store-review/destroy') }}')" @endif>
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
