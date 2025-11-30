@extends('admin.theme.default')
@section('styles')
    <link rel="stylesheet"
          href="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/css/bootstrap/bootstrap-select.v1.14.0-beta2.min.css') }}">
@endsection
@section('content')
    @include('admin.breadcrumb')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card border-0 box-shadow">
                    <div class="card-body pb-0">
                        <form action="{{ URL::to('admin/bmsmDeals/store') }}" method="POST">
                            @csrf
                            <div class="row">

                                <div class="form-group col-md-12">
                                    <label class="form-label">Products</label>
                                    <div class="dropdown bootstrap-select show-tick form-control w-100">
                                        <select class="form-control selectpicker w-100" name="product_id"
                                                data-live-search="true">

                                            @foreach(helper::getItems() as $item)
                                                <option value="{{ $item->id }}">
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
                                    <label class="form-label">Deal Type</label>
                                    <select class="form-control selectpicker w-100" id="bmsm_deal_type" name="bmsm_deal_type" data-live-search="true">
                                        <option value="1">Product Based</option>
                                        <option value="2">Cart Based</option>
                                    </select>
                                </div>


                                <div class="form-group col-md-6" id="product_selector_section" style="display: none;">
                                    <label class="form-label">Select Products</label>
                                    <select class="form-control selectpicker w-100" multiple name="product_ids[]"
                                            data-live-search="true">

                                        @foreach(helper::getItems() as $item)
                                            <option value="{{ $item->id }}">
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


                                <div class="col-sm-6 form-group" id="start_date">
                                    <label class="form-label">Start date
                                        <span class="text-danger"> *</span></label>
                                    <input type="date" class="form-control" id="start_date" name="start_date"
                                           required="">
                                </div>
                                <div class="col-sm-6 form-group" id="end_date">
                                    <label class="form-label">End date
                                        <span class="text-danger"> *</span></label>
                                    <input type="date" class="form-control" id="end_date" name="end_date"
                                           required="">
                                </div>


                                <div class="col-sm-6 form-group" id="start_time">
                                    <label class="form-label">Start Time
                                        <span class="text-danger"> *</span></label>
                                    <input type="time" class="form-control" name="start_time" id="start_time"
                                           required="">
                                </div>

                                <div class="col-sm-6 form-group" id="end_time">
                                    <label class="form-label">End Time
                                        <span class="text-danger"> *</span></label>
                                    <input type="time" class="form-control" name="end_time" id="end_time"
                                           required="">
                                </div>


                                <div class="col-md-6">
                                    <label class="form-label">Discount Type
                                        <span class="text-danger"> * </span></label>
                                    <select class="form-select" name="offer_type" required="">
                                        <option value=""> Select</option>
                                        <option value="1">
                                            Fixed
                                        </option>
                                        <option value="2">
                                            Percentage
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-label">Order
                                        <span class="text-danger"> *</span></label>
                                    <input type="text" class="form-control numbers_only" name="order"
                                           placeholder="Order By">
                                </div>

                                <hr/>
                                <div class="form-group col-md-12">
                                    <button class="btn btn-primary float-end" type="button" onclick="addBmsmTier()"
                                            id="add_more"><span style="margin-right: 10px">Add More</span><i
                                            class="fa fa-plus"></i>
                                    </button>
                                </div>
                                <hr />
                                <div class="form-group col-md-12">
                                    <div id="bmsm_tiers_container">
                                        <h5 class="mt-4">BMSM Tiers</h5>
                                        <div id="tier_fields_wrapper">
                                            <!-- Tiers will be appended here -->
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                    <a href="{{ URL::to('admin/bmsmDeals') }}"
                                       class="btn btn-danger">{{ trans('labels.cancel') }}</a>
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
    <script>
        let tierIndex = 0;

        $(document).ready(function () {
            $('#bmsm_deal_type').on('change', function () {
                const type = $(this).val();
                if (type === '1') {
                    $('#product_selector_section').show();
                } else {
                    $('#product_selector_section').hide();
                }
            });

            // Trigger on page load in case of edit
            $('#bmsm_deal_type').trigger('change');
        });

        function addBmsmTier() {
            const wrapper = document.getElementById('tier_fields_wrapper');

            const tier = document.createElement('div');
            tier.classList.add('row', 'mb-2', 'align-items-center');
            tier.innerHTML = `
                <div class="col-md-4">
                    <input name="tiers[${tierIndex}][min_qty]" type="number" class="form-control" placeholder="Min Qty / Amount" required>
                </div>
                <div class="col-md-3">
                    <input name="tiers[${tierIndex}][max_qty]" type="number" class="form-control" placeholder="Max Qty / Amount" required>
                </div>
                <div class="col-md-3">
                    <input name="tiers[${tierIndex}][discount_value]" type="number" class="form-control" placeholder="Discount Value" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.parentElement.remove()">Remove</button>
                </div>
            `;

            wrapper.appendChild(tier);
            tierIndex++;
        }
    </script>

@endsection
