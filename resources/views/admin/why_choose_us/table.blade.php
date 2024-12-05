<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th></th>
            <th>#</th>
            <th>{{ trans('labels.image') }}</th>
            <th>{{ trans('labels.title') }}</th>
            <th>{{ trans('labels.subtitle') }}</th>
            <th>{{ trans('labels.action') }}</th>
        </tr>
    </thead>
    <tbody id="tabledetails" data-url="{{ url('admin/choose_us/reorder_choose_us') }}">
        @php $i = 1; @endphp
        @foreach ($getwhychooseus as $whychooseus)
            <tr class="row1" data-id="{{ $whychooseus->id }}">
                <td><a tooltip="{{ trans('labels.move') }}"><i class="fa-light fa-up-down-left-right mx-2"></i></a></td>
                <td>@php echo $i++; @endphp</td>
                <td><img src='{{ helper::image_path($whychooseus->image) }}' class='img-fluid rounded h-50px'></td>
                <td>{{ $whychooseus->title }}</td>
                <td>{{ $whychooseus->subtitle }}</td>
                <td>
                    <div class="d-flex flex-wrap gap-1">
                        <a class="btn btn-sm btn-info square" tooltip="{{ trans('labels.edit') }}"
                            href="{{ URL::to('admin/choose_us-' . $whychooseus->id) }}">
                            <i class="fa-solid fa-pen-to-square"></i></a>
                        <a class="btn btn-sm btn-danger square" tooltip="{{ trans('labels.delete') }}"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="Delete('{{ $whychooseus->id }}','{{ URL::to('admin/choose_us/delete') }}')" @endif>
                            <i class="fa fa-trash"></i></a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
