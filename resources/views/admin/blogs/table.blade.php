<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th></th>
            <th>#</th>
            <th>{{ trans('labels.image') }}</th>
            <th>{{ trans('labels.title') }}</th>
            <th>{{ trans('labels.description') }}</th>
            <th>{{ trans('labels.created_date') }}</th>
            <th>{{ trans('labels.updated_date') }}</th>
            <th>{{ trans('labels.action') }}</th>
        </tr>
    </thead>
    <tbody id="tabledetails" data-url="{{ url('admin/blogs/reorder_blog') }}">
        @php $i = 1; @endphp
        @foreach ($getblogs as $blog)
            <tr class="row1" data-id="{{ $blog->id }}">
                <td><a tooltip="{{ trans('labels.move') }}"><i class="fa-light fa-up-down-left-right mx-2"></i></a></td>
                <td>@php echo $i++; @endphp</td>
                <td><img src='{{ helper::image_path($blog->image) }}' class='img-fluid rounded h-50px'></td>
                <td>{{ $blog->title }}</td>
                <td>{{ Str::limit($blog->description, 200) }}</td>
                <td>
                    {{ helper::date_format($blog->created_at) }} <br>
                    {{ helper::time_format($blog->created_at) }}
                </td>
                <td>
                    {{ helper::date_format($blog->updated_at) }} <br>
                    {{ helper::time_format($blog->updated_at) }}
                </td>
                <td>
                    <div class="d-flex flex-wrap gap-1">
                        <a class="btn btn-sm btn-info square" tooltip="{{ trans('labels.edit') }}"
                            href="{{ URL::to('admin/blogs-' . $blog->id) }}">
                            <i class="fa-solid fa-pen-to-square"></i></a>
                        <a class="btn btn-sm btn-danger square" tooltip="{{ trans('labels.delete') }}"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="Delete('{{ $blog->id }}','{{ URL::to('admin/blogs/delete') }}')" @endif><i
                                class="fa fa-trash"></i></a>
                    </div>
                </td>
            </tr>
        @endforeach
        </>
</table>
