<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th></th>
            <th>#</th>
            <th>{{ trans('labels.name') }}</th>
            <th>{{ trans('labels.designation') }}</th>
            <th>{{ trans('labels.social_links') }}</th>
            <th>{{ trans('labels.action') }}</th>
        </tr>
    </thead>
    <tbody id="tabledetails" data-url="{{ url('admin/our-team/reorder_our_team') }}">
        @php $i = 1; @endphp
        @foreach ($getteams as $team)
            <tr class="row1" data-id="{{ $team->id }}">
                <td><a tooltip="{{ trans('labels.move') }}"><i class="fa-light fa-up-down-left-right mx-2"></i></a></td>
                <td>@php echo $i++; @endphp</td>
                <td>{{ $team->name }}</td>
                <td>{{ $team->designation }}</td>
                <td>
                    <div class="d-flex flex-wrap gap-1">
                        @if ($team->fb != '')
                            <a class="btn btn-sm btn-primary square" tooltip="{{ trans('labels.facebook') }}"
                                href="{{ $team->fb }}" target="_blank">
                                <i class="fab fa-facebook-square"></i> </a>
                        @endif
                        @if ($team->youtube != '')
                            <a class="btn btn-sm btn-primary square" tooltip="{{ trans('labels.youtube') }}"
                                href="{{ $team->youtube }}" target="_blank">
                                <i class="fab fa-youtube"></i> </a>
                        @endif
                        @if ($team->insta != '')
                            <a class="btn btn-sm btn-primary square" tooltip="{{ trans('labels.instagram') }}"
                                href="{{ $team->insta }}" target="_blank">
                                <i class="fab fa-instagram-square"></i> </a>
                        @endif
                        @if ($team->twitter != '')
                            <a class="btn btn-sm btn-primary square" tooltip="{{ trans('labels.twitter') }}"
                                href="{{ $team->twitter }}" target="_blank">
                                <i class="fab fa-twitter-square"></i> </a>
                        @endif
                    </div>
                </td>
                <td>
                    <div class="d-flex flex-wrap gap-1">
                        <a class="btn btn-sm btn-info square" tooltip="{{ trans('labels.edit') }}"
                            href="{{ URL::to('admin/our-team-' . $team->id) }}">
                            <i class="fa-solid fa-pen-to-square"></i></a>
                        <a class="btn btn-sm btn-danger square" tooltip="{{ trans('labels.delete') }}"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="Delete('{{ $team->id }}','{{ URL::to('admin/our-team/delete') }}')" @endif>
                            <i class="fa fa-trash"></i></a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
