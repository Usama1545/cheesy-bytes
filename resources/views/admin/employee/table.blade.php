<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('labels.name') }}</th>
            <th>{{ trans('labels.role_name') }}</th>
            <th>{{ trans('labels.email') }}</th>
            <th>{{ trans('labels.mobile') }}</th>
            <th>{{ trans('labels.status') }}</th>
            <th>{{ trans('labels.action') }}</th>
        </tr>
    </thead>
    <tbody>
        @php $i = 1; @endphp
        @foreach ($getemployee as $employee)
            <tr>
                <td>@php echo $i++; @endphp</td>
                <td> {{ $employee->name }} </td>
                <td> {{ $employee['role_info']->role_name }} </td>
                <td> {{ $employee->email }} </td>
                <td> {{ $employee->mobile }} </td>
                <td>
                    @if ($employee->is_available == 1)
                        <a class="btn btn-sm btn-success square"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="StatusUpdate('{{ $employee->id }}','2','{{ URL::to('admin/employee/status') }}')" @endif>
                            <i class="fa-sharp fa-solid fa-check"></i></a>
                    @else
                        <a class="btn btn-sm btn-danger square"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="StatusUpdate('{{ $employee->id }}','1','{{ URL::to('admin/employee/status') }}')" @endif>
                            <i class="fa-sharp fa-solid fa-xmark"></i></a>
                    @endif
                </td>
                <td><a class="btn btn-sm btn-info square" href="{{ URL::to('admin/employee-' . $employee->id) }}"> <i
                            class="fa fa-pen-to-square"></i></a></td>
            </tr>
        @endforeach
    </tbody>
</table>
