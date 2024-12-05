<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('labels.item_name') }}</th>
            <th>{{ trans('labels.rating') }}</th>
            <th>{{ trans('labels.review') }}</th>
            <th>{{ trans('labels.status') }}</th>
            <th>{{ trans('labels.created_date') }}</th>
            <th>{{ trans('labels.updated_date') }}</th>
            <th>{{ trans('labels.action') }}</th>
        </tr>
    </thead>
    <tbody>
        @php $i = 1; @endphp
        @foreach ($getreview as $reviews)
            <tr>
                <td>@php echo $i++; @endphp</td>
                <td>{{ @$reviews->item_info->item_name }}</td>
                <td><i class="fa fa-star text-warning"></i> {{ number_format($reviews->ratting, 1) }} </td>
                <td><small>{{ $reviews->comment }}</small></td>
                <td>
                    @if ($reviews->status == 1)
                        <a class="btn btn-sm btn-success square" tooltip="Avtive"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()"
                    @else onclick="StatusUpdate('{{ $reviews->id }}','2','{{ URL::to('admin/reviews/status') }}')" @endif>
                            <i class="fa-sharp fa-solid fa-check"></i></a>
                    @else
                        <a class="btn btn-sm btn-danger square" tooltip="Deavtive"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()"
                    @else onclick="StatusUpdate('{{ $reviews->id }}','1','{{ URL::to('admin/reviews/status') }}')" @endif>
                            <i class="fa-sharp fa-solid fa-xmark"></i></a>
                    @endif
                </td>
                <td>
                    {{ helper::date_format($reviews->created_at) }} <br>
                    {{ helper::time_format($reviews->created_at) }}
                </td>
                <td>
                    {{ helper::date_format($reviews->updated_at) }} <br>
                    {{ helper::time_format($reviews->updated_at) }}
                </td>
                <td>
                    <a class="btn btn-sm btn-danger square" tooltip="Delete"
                        @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="DeleteData('{{ $reviews->id }}','{{ URL::to('admin/reviews/destroy') }}')" @endif><i
                            class="fa fa-trash"></i></a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
