<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th></th>
            <th>#</th>
            <th>{{ trans('labels.title') }}</th>
            <th>{{ trans('labels.description') }}</th>
            <th>{{ trans('labels.created_date') }}</th>
            <th>{{ trans('labels.updated_date') }}</th>
            <th>{{ trans('labels.action') }}</th>
        </tr>
    </thead>
    <tbody id="tabledetails" data-url="{{ url('admin/faq/reorder_faq') }}">
        @php $i = 1; @endphp
        @foreach ($getfaqs as $faq)
            <tr class="row1" data-id="{{ $faq->id }}">
                <td><a tooltip="{{ trans('labels.move') }}"><i class="fa-light fa-up-down-left-right mx-2"></i></a></td>
                <td>@php echo $i++; @endphp</td>
                <td>{{ $faq->title }}</td>
                <td>{{ Str::limit($faq->description, 200) }}</td>
                <td>
                    {{ helper::date_format($faq->created_at) }} <br>
                    {{ helper::time_format($faq->created_at) }}
                </td>
                <td>
                    {{ helper::date_format($faq->updated_at) }} <br>
                    {{ helper::time_format($faq->updated_at) }}
                </td>
                <td>
                    <div class="d-flex flex-wrap gap-1">
                        <a class="btn btn-sm btn-info square" tooltip="{{ trans('labels.edit') }}"
                            href="{{ URL::to('admin/faq-' . $faq->id) }}"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a class="btn btn-sm btn-danger square" tooltip="{{ trans('labels.delete') }}"
                            href="javascript:void(0)"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="Delete('{{ $faq->id }}','{{ URL::to('admin/faq/delete') }}')" @endif><i
                                class="fa fa-trash"></i></a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
