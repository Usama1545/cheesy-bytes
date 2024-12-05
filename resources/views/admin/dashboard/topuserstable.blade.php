@php
    $ran = array("gradient-1","gradient-2","gradient-3","gradient-4","gradient-5","gradient-6","gradient-7","gradient-8","gradient-9");
@endphp
<table class="table">
<thead>
    <tr>
        <th>{{trans('labels.image')}}</th>
        <th>{{trans('labels.user_info')}}</th>
        <th>{{trans('labels.orders')}}</th>
    </tr>
</thead>
<tbody>
    @php $i = 1; @endphp
    @foreach ($topusers as $user)
        <tr>
            <td><img src="{{helper::image_path($user->profile_image)}}" class="rounded h-50px" alt=""></td>
            <td><a href="{{ URL::to('admin/users-'.$user->id) }}"><small>{{$user->name}} <br> {{$user->email}} <br> {{$user->mobile}}</small></a></td>
            <td>
                @php
                    $per = ($user->user_order_counter * 100) / count(@$getorderscount) ;
                @endphp
                {{number_format($per,2)}}%
                <div class="progress h-10-px">
                    <div class="progress-bar {{$ran[array_rand($ran, 1)]}}" style="width: {{$per}}%;" role="progressbar">
                        <span class="sr-only">{{ $per }}% {{ trans('labels.orders') }}</span>
                    </div>
                </div>    
            </td>
        </tr>
    @endforeach
</tbody>
</table>