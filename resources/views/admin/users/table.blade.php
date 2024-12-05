<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('labels.name') }}</th>
            <th>{{ trans('labels.email') }}</th>
            <th>{{ trans('labels.mobile') }}</th>
            <th>{{ trans('labels.referral_code') }}</th>
            <th>{{ trans('labels.login_with') }}</th>
            <th>{{ trans('labels.otp_status') }}</th>
            <th>{{ trans('labels.status') }}</th>
            <th>{{ trans('labels.action') }}</th>
        </tr>
    </thead>
    <tbody>
        @php $i = 1; @endphp
        @foreach ($getusers as $users)
            <tr>
                <td>@php echo $i++; @endphp</td>
                <td> {{ $users->name }} </td>
                <td> {{ $users->email }} </td>
                <td> {{ $users->mobile }} </td>
                <td> {{ $users->referral_code }} </td>
                <td>
                    @if ($users->login_type == 'facebook')
                        {{ trans('labels.facebook') }}
                    @elseif($users->login_type == 'google')
                        {{ trans('labels.google') }}
                    @else
                        {{ trans('labels.email') }}
                    @endif
                </td>
                <td>{{ $users->is_verified == '1' ? trans('labels.verified') : trans('labels.unverified') }}</td>
                <td>
                    @if ($users->is_available == 1)
                        <a class="btn btn-sm btn-success square" tooltip="{{ trans('labels.active') }}"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="StatusUpdate('{{ $users->id }}','2','{{ URL::to('admin/users/status') }}')" @endif>
                            <i class="fa-sharp fa-solid fa-check"></i></a>
                    @else
                        <a class="btn btn-sm btn-danger square" tooltip="{{ trans('labels.deactive') }}"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="StatusUpdate('{{ $users->id }}','1','{{ URL::to('admin/users/status') }}')" @endif>
                            <i class="fa-sharp fa-solid fa-xmark"></i></a>
                    @endif
                </td>
                <td>
                    <div class="d-flex flex-wrap gap-1">
                        <a class="btn btn-sm btn-info square" tooltip="{{ trans('labels.edit') }}"
                            href="{{ URL::to('admin/users-' . $users->id) }}">
                            <i class="fa fa-pen-to-square"></i></a>
                        <a class="btn btn-sm btn-dark square" tooltip="{{ trans('labels.view') }}"
                            href="{{ URL::to('admin/users/details-' . $users->id) }}">
                            <i class="fa-solid fa-eye"></i></a>
                        <a class="btn btn-sm btn-danger square" tooltip="{{ trans('labels.delete') }}"
                            onclick="StatusUpdate('{{ $users->id }}','','{{ URL::to('admin/users/delete') }}')">
                            <i class="fa-solid fa-trash"></i></a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
