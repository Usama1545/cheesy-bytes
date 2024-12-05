<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('labels.role_name') }}</th>
            <th>{{ trans('labels.system_modules') }}</th>
            <th>{{ trans('labels.status') }}</th>
            <th>{{ trans('labels.action') }}</th>
        </tr>
    </thead>
    <tbody>
        @php $i=1; @endphp
        @foreach ($getroles as $role)
            <tr id="dataid{{ $role->id }}">
                <td>@php echo $i++; @endphp</td>
                <td>{{ $role->name }}</td>
                <td>
                    @foreach (explode(',', $role->titles) as $data)
                        <span class="badge rounded-pill bg-light text-dark">{{ $data }}</span>
                    @endforeach
                </td>
                <td>
                    @if ($role->is_available == 1)
                        <a class="btn btn-sm btn-success square"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="StatusUpdate('{{ $role->id }}','2','{{ URL::to('admin/roles/status') }}')" @endif><i
                                class="fa-sharp fa-solid fa-check"></i></a>
                    @else
                        <a class="btn btn-sm btn-danger square"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="StatusUpdate('{{ $role->id }}','1','{{ URL::to('admin/roles/status') }}')" @endif><i
                                class="fa-sharp fa-solid fa-xmark"></i></a>
                    @endif
                </td>
                <td>
                    <a class="btn btn-sm btn-info square" href="{{ URL::to('admin/roles-' . $role->id) }}"><i
                            class="fa-solid fa-pen-to-square"></i></a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
