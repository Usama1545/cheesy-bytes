<table class="table table-striped table-bordered py-3 zero-configuration w-100">
    <thead>
        <tr class="text-uppercase fw-500">
            <th></th>
            <th>#</th>
            <th>{{ trans('labels.area_name') }}</th>
            <th>{{ trans('labels.delivery_charge') }}</th>
            <th>{{ trans('labels.created_date') }}</th>
            <th>{{ trans('labels.updated_date') }}</th>
            <th>{{ trans('labels.action') }}</th>
        </tr>
    </thead>
    <tbody id="tabledetails" data-url="{{ url('admin/shippingarea/reorder_shippingarea') }}">
        @php $i=1; @endphp
        @foreach ($shippingarealist as $shippingarea)
            <tr class="row1" data-id="{{ $shippingarea->id }}">
                <td><a tooltip="{{ trans('labels.move') }}"><i class="fa-light fa-up-down-left-right mx-2"></i></a></td>
                <td>@php echo $i++ @endphp</td>
                <td>{{ $shippingarea->name }}</td>
                <td>{{ helper::currency_format($shippingarea->delivery_charge, $shippingarea->vendor_id) }}
                </td>
                <td>{{ helper::date_format($shippingarea->created_at) }}<br>
                    {{ helper::time_format($shippingarea->created_at) }}
                </td>
                <td>{{ helper::date_format($shippingarea->updated_at) }}<br>
                    {{ helper::time_format($shippingarea->updated_at) }}
                </td>
                <td>
                    <div class="d-flex flex-wrap gap-1">
                        <a href="{{ URL::to('admin/shippingarea-' . $shippingarea->id) }}"
                            tooltip="{{ trans('labels.edit') }}" class="btn btn-info square">
                            <i class="fa-solid fa-pen-to-square"></i></a>
    
                        <a href="javascript:void(0)" tooltip="{{ trans('labels.delete') }}"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" 
                            @else onclick="Delete('{{ $shippingarea->id }}','{{ URL::to('/admin/shippingarea/delete') }}')" @endif
                            class="btn btn-danger square"> <i class="fa-solid fa-trash"></i></a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
