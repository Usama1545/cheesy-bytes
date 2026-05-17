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
                            <form method="post" action="{{ URL::to('admin/deals/update') }}" name="about" id="about"
                                  enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" class="form-control" id="id" name="id"
                                       value="{{ $getitem->id }}">
                                <div class="row">

                                    <div class="form-group col-md-6">
                                        <label class="form-label">Deal Product</label>
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

                                    <div class="form-group col-md-6">
                                        <label class="form-label">Listed Products</label>
                                        <?php $selected = explode(',', $getitem->product_ids); ?>
                                        <div class="dropdown bootstrap-select show-tick form-control w-100">
                                            <select class="form-control selectpicker  w-100" multiple name="product_ids[]"
                                                    data-live-search="true">
                                                @foreach(helper::getItems(false) as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ in_array($item->id, $selected) ? 'selected' : '' }}>
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

                                    <div class="form-group col-md-6">
                                        <label class="form-label">Size
                                            <span class="text-danger"> *</span></label>
                                        <select class="form-control selectpicker w-100 multiple" multiple name="size_id[]"
                                                data-live-search="true">
                                            <?php $selected = explode(',', $getitem->size_id); ?>

                                            @foreach(helper::get_sizes() as $item)
                                                <option value="{{ $item->id }}" {{ in_array($item->id, $selected) ? 'selected' : '' }}>
                                                    {{ $item->name.'('.$item->label.')' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6 form-group" id="end_time">
                                        <label class="form-label">Min Count
                                            <span class="text-danger"> *</span></label>
                                        <input type="number" class="form-control" value="{{ $getitem->min_count }}" name="min_count"
                                               required="">
                                    </div>
                                     <div class="form-group col-md-6">
                                        <label class="form-label">Price
                                            <span class="text-danger"> *</span></label>
                                        <input type="text" class="form-control numbers_only" name="offer_amount"
                                               placeholder="Price" value="{{ $getitem->offer_amount }}" required="">
                                    </div>
                                     <div class="col-sm-6 form-group" id="end_time">
                                        <label class="form-label">Order
                                            <span class="text-danger"> *</span></label>
                                        <input type="number" class="form-control" value="{{ $getitem->order }}" name="order"
                                               required="">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label" for="">{{ trans('labels.image') }}
                                        </label>
                                        <input type="file" class="form-control" name="web_image" accept="image/*">
                                        @error('web_image')
                                            <span class="text-danger">{{ $message }}</span><br>
                                        @enderror
                                        <img src="{{ helper::image_path($getitem->web_image) }}" alt=""
                                            class="img-fluid rounded mt-1 h-50px">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label" for="">Mobile Image
                                        </label>
                                        <input type="file" class="form-control" name="mobile_image" accept="image/*">
                                        @error('mobile_image')
                                            <span class="text-danger">{{ $message }}</span><br>
                                        @enderror
                                        <img src="{{ helper::image_path($getitem->mobile_image) }}" alt=""
                                            class="img-fluid rounded mt-1 h-50px">
                                    </div>
                                    <div class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                        <a href="{{ URL::to('admin/deals') }}" class="btn btn-danger">{{ trans('labels.cancel') }}</a>
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
