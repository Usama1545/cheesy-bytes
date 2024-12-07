@extends('admin.theme.default')
@section('content')
    @include('admin.breadcrumb')

    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h3>Custom Pizzas</h3>
            <a href="custom_pizza/add" class="btn btn-primary">Add New <i class="fa fa-plus"></i></a>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="table-responsive" id="table-display">
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead>
                                <tr>
                                    <th>Size</th>
                                    <th>{{ trans('labels.price') }}</th>
                                    <th>{{ trans('labels.created_date') }}</th>
                                    <th>{{ trans('labels.updated_date') }}</th>
                                    <th>{{ trans('labels.action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $i = 1; @endphp
                                @foreach ($getitem as $item)
                                    <tr class="row1" data-id="{{ $item->id }}">
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->price }}</td>
                                        <td>
                                            {{ helper::date_format($item->created_at) }} <br>
                                            {{ helper::time_format($item->created_at) }}
                                        </td>
                                        <td>
                                            {{ helper::date_format($item->updated_at) }} <br>
                                            {{ helper::time_format($item->updated_at) }}
                                        </td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-1">
                                                <a class="btn btn-sm btn-info square" tooltip="{{ trans('labels.edit') }}"
                                                   href="{{ URL::to('admin/custom_pizza-' . $item->id) }}"> <i class="fa-solid fa-pen-to-square"></i></a>
                                                <a class="btn btn-sm btn-danger square" tooltip="{{ trans('labels.delete') }}"
                                                   @if (env('Environment') == 'sendbox') onclick="myFunction()"
                                                   @else onclick="Delete('{{ $item->id }}','{{ URL::to('admin/custom_pizza/delete') }}')" @endif>
                                                    <i class="fa fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
@endsection
