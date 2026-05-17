@extends('admin.theme.default')
@section('content')
    @include('admin.breadcrumb')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="form-group">
                            <label class="col-form-label" for="item_name">{{ trans('labels.item_name') }}</label>
                            <select name="item_name" class="form-select" id="item_name">
                                <option value="" selected>{{ trans('labels.select') }}</option>
                                @foreach ($getproduct as $product)
                                    <option value="{{ @$product->id }}" {{ $sorter == @$product->id ? 'selected' : '' }}>
                                        {{ @$product->item_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="table-responsive" id="table-display">
                            @include('admin.reviews.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form id="filter_review">
        <input type="hidden" name="item_id" id="sorter_item_name" value="{{ @$sorter }}">
    </form>
@endsection
@section('script')
    <script src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/reviews.js') }}"></script>
@endsection
