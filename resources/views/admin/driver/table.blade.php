<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('labels.name') }}</th>
            <th>{{ trans('labels.email') }}</th>
            <th>{{ trans('labels.mobile') }}</th>
            <th>{{ trans('labels.status') }}</th>
            <th>{{ trans('labels.action') }}</th>
        </tr>
    </thead>
    <tbody>
        @php $i = 1; @endphp
        @foreach ($getdriverlist as $driver)
            <tr>
                <td>@php echo $i++; @endphp</td>
                <td> {{ $driver->name }} </td>
                <td> {{ $driver->email }} </td>
                <td> {{ $driver->mobile }} </td>
                <td>
                    @if ($driver->is_available == 1)
                        <a class="btn btn-sm btn-success square" tooltip="{{ trans('labels.active') }}"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="StatusUpdate('{{ $driver->id }}','2','{{ URL::to('admin/driver/status') }}')" @endif>
                            <i class="fa-sharp fa-solid fa-check"></i></a>
                    @else
                        <a class="btn btn-sm btn-danger square" tooltip="{{ trans('labels.deactive') }}"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="StatusUpdate('{{ $driver->id }}','1','{{ URL::to('admin/driver/status') }}')" @endif>
                            <i class="fa-sharp fa-solid fa-xmark"></i></a>
                    @endif
                </td>
                <td>
                    <div class="d-flex flex-wrap gap-1">
                        <a class="btn btn-sm btn-info square" tooltip="{{ trans('labels.edit') }}"
                            href="{{ URL::to('admin/driver-' . $driver->id) }}"><i class="fa fa-pen-to-square"></i></a>
                        <a class="btn btn-sm btn-dark square" tooltip="{{ trans('labels.view') }}"
                            href="{{ URL::to('admin/driver/details-' . $driver->id) }}"><i class="fa-solid fa-eye"></i>
                        </a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
