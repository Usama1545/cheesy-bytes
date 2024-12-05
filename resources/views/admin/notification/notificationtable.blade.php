<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('labels.title') }}</th>
            <th>{{ trans('labels.message') }}</th>
            <th>{{ trans('labels.category') }}</th>
            <th>{{ trans('labels.item') }}</th>
        </tr>
    </thead>
    <tbody>
        @php $i = 1; @endphp
        @foreach ($getnotification as $notification)
            <tr>
                <td>@php echo $i++; @endphp</td>
                <td>{{ $notification->title }}</td>
                <td>{{ $notification->message }}</td>
                <td>{{ $notification->cat_id == '' ? '--' : @$notification['category_info']->category_name }}</td>
                <td>{{ $notification->item_id == '' ? '--' : @$notification['item_info']->item_name }}
            </tr>
        @endforeach
    </tbody>
</table>
