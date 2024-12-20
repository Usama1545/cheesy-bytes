@extends('admin.theme.default')
@section('styles')
    <link rel="stylesheet"
          href="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/css/bootstrap/bootstrap-select.v1.14.0-beta2.min.css') }}">
@endsection
@section('content')
    @include('admin.breadcrumb')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card border-0">
                    <div class="card-body">
                        <div id="privacy-policy-three" class="privacy-policy">
                            <form method="post" action="{{ URL::to('admin/topDeals/update') }}" name="about" id="about"
                                  enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" class="form-control" id="id" name="id"
                                       value="{{ $getitem->id }}">
                                <div class="row">

                                    <div class="form-group col-md-12">
                                        <label class="form-label">Products</label>
                                        <div class="dropdown bootstrap-select show-tick form-control w-100">
                                            <select class="form-control selectpicker w-100" name="product_id"
                                                    data-live-search="true">
                                                @foreach(helper::getItems() as $item)
                                                    <option value="{{ $item->id }}" {{ $item->id === $getitem->product_id ? 'selected' : '' }}>
                                                        {{ $item->item_name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <div class="dropdown-menu ">
                                                <div class="bs-searchbox"><input type="search" class="form-control"
                                                                                 autocomplete="off" role="combobox"
                                                                                 aria-label="Search"
                                                                                 aria-controls="bs-select-1"
                                                                                 aria-autocomplete="list"></div>
                                                <div class="inner show" role="listbox" id="bs-select-1" tabindex="-1"
                                                     aria-multiselectable="true">
                                                    <ul class="dropdown-menu inner show" role="presentation"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 form-group" id="start_date">
                                        <label class="form-label">Start date
                                            <span class="text-danger"> *</span></label>
                                        <input type="date" class="form-control" value="{{ $getitem->start_date }}" id="start_date" name="start_date"
                                               required="">
                                    </div>
                                    <div class="col-sm-6 form-group" id="end_date">
                                        <label class="form-label">End date
                                            <span class="text-danger"> *</span></label>
                                        <input type="date" class="form-control" id="end_date" value="{{ $getitem->end_date }}" name="end_date"
                                               required="">
                                    </div>


                                    <div class="col-sm-6 form-group" id="start_time">
                                        <label class="form-label">Start Time
                                            <span class="text-danger"> *</span></label>
                                        <input type="time" class="form-control" value="{{ $getitem->start_time }}" name="start_time" id="start_time"
                                               required="">
                                    </div>

                                    <div class="col-sm-6 form-group" id="end_time">
                                        <label class="form-label">End Time
                                            <span class="text-danger"> *</span></label>
                                        <input type="time" class="form-control" value="{{ $getitem->end_time }}" name="end_time" id="end_time"
                                               required="">
                                    </div>


                                    <div class="col-md-6">
                                        <label class="form-label">Discount Type
                                            <span class="text-danger"> * </span></label>
                                        <select class="form-select" name="offer_type" required="">
                                            <option value=""> Select</option>
                                            <option value="1" {{ $getitem->offer_type == 1 ? 'selected': '' }}>
                                                Fixed
                                            </option>
                                            <option value="2" {{ $getitem->offer_type == 2 ? 'selected': '' }}>
                                                Percentage
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label">Discount
                                            <span class="text-danger"> *</span></label>
                                        <input type="text" class="form-control numbers_only" name="offer_amount" value="{{ $getitem->offer_amount }}"
                                               placeholder="Discount" required="">
                                    </div>


                                    <div class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                        <a href="{{ URL::to('admin/item') }}" class="btn btn-danger">{{ trans('labels.cancel') }}</a>
                                        <button class="btn btn-primary"
                                            @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()"
                                            @else type="submit" @endif>{{ trans('labels.save') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.12.1/ckeditor.js"></script>
    <script type="text/javascript">
        CKEDITOR.replace('allergens');
    </script>
    <script
        src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/bootstrap/bootstrap-select.v1.14.0-beta2.min.js') }}">
    </script>
    <script src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/additem.js') }}"></script>

@endsection
