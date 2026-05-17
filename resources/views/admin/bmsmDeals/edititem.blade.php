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
                            <form method="post" action="{{ URL::to('admin/bmsmDeals/update') }}" name="about"
                                id="about" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" class="form-control" id="id" name="id"
                                    value="{{ $getitem->id }}">
                                <div class="row">

                                    <div class="form-group col-md-12">
                                        <label class="form-label">Deal Product</label>
                                        <div class="dropdown bootstrap-select show-tick form-control w-100">
                                            <select class="form-control selectpicker w-100" name="product_id"
                                                data-live-search="true">
                                                @foreach (helper::getItems() as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $item->id === $getitem->product_id ? 'selected' : '' }}>
                                                        {{ $item->item_name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <div class="dropdown-menu ">
                                                <div class="bs-searchbox"><input type="search" class="form-control"
                                                        autocomplete="off" role="combobox" aria-label="Search"
                                                        aria-controls="bs-select-1" aria-autocomplete="list"></div>
                                                <div class="inner show" role="listbox" id="bs-select-1" tabindex="-1"
                                                    aria-multiselectable="true">
                                                    <ul class="dropdown-menu inner show" role="presentation"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group col-md-6">
                                        <label class="form-label">Deal Type</label>
                                        <select class="form-control selectpicker w-100" id="bmsm_deal_type"
                                            name="bmsm_deal_type" data-live-search="true">
                                            <option value="1" {{ $getitem->bmsm_deal_type == 1 ? 'selected' : '' }}>
                                                Product Based</option>
                                            <option value="2" {{ $getitem->bmsm_deal_type == 2 ? 'selected' : '' }}>
                                                Cart Based</option>
                                        </select>
                                    </div>


                                    <div class="form-group col-md-6" id="product_selector_section" style="display: none;">
                                        <label class="form-label">Select Products</label>
                                        <?php
                                        $selectedDealItems = $getitem->bmsmProducts->pluck('item_id')->toArray() ?? [];
                                        ?>
                                        <select class="form-control selectpicker w-100" multiple name="product_ids[]"
                                            data-live-search="true">

                                            @foreach (helper::getItems() as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ in_array($item->id, $selectedDealItems) ? 'selected' : '' }}>
                                                    {{ $item->item_name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <div class="dropdown-menu ">
                                            <div class="bs-searchbox"><input type="search" class="form-control"
                                                    autocomplete="off" role="combobox" aria-label="Search"
                                                    aria-controls="bs-select-1" aria-autocomplete="list"></div>
                                            <div class="inner show" role="listbox" id="bs-select-1" tabindex="-1"
                                                aria-multiselectable="true">
                                                <ul class="dropdown-menu inner show" role="presentation"></ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 form-group" id="start_date">
                                        <label class="form-label">Start date
                                            <span class="text-danger"> *</span></label>
                                        <input type="date" class="form-control" value="{{ $getitem->start_date }}"
                                            id="start_date" name="start_date" required="">
                                    </div>
                                    <div class="col-sm-6 form-group" id="end_date">
                                        <label class="form-label">End date
                                            <span class="text-danger"> *</span></label>
                                        <input type="date" class="form-control" id="end_date"
                                            value="{{ $getitem->end_date }}" name="end_date" required="">
                                    </div>


                                    <div class="col-sm-6 form-group" id="start_time">
                                        <label class="form-label">Start Time
                                            <span class="text-danger"> *</span></label>
                                        <input type="time" class="form-control" value="{{ $getitem->start_time }}"
                                            name="start_time" id="start_time" required="">
                                    </div>

                                    <div class="col-sm-6 form-group" id="end_time">
                                        <label class="form-label">End Time
                                            <span class="text-danger"> *</span></label>
                                        <input type="time" class="form-control" value="{{ $getitem->end_time }}"
                                            name="end_time" id="end_time" required="">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Discount Type
                                            <span class="text-danger"> * </span></label>
                                        <select class="form-select" name="offer_type" required="">
                                            <option value=""> Select</option>
                                            <option value="1" {{ $getitem->offer_type == 1 ? 'selected' : '' }}>
                                                Fixed
                                            </option>
                                            <option value="2" {{ $getitem->offer_type == 2 ? 'selected' : '' }}>
                                                Percentage
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6 form-group" id="end_time">
                                        <label class="form-label">Order
                                            <span class="text-danger"> *</span></label>
                                        <input type="number" class="form-control" value="{{ $getitem->order }}"
                                            name="order" required="">
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

                                    <!-- adding category select and number of proects -->

                                    <hr />

                                    <div class="form-group col-md-12">
                                        <button class="btn btn-primary float-end" type="button"
                                            id="add_tier_button"><span style="margin-right: 10px">Add More</span><i
                                                class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                    <hr />
                                    <div class="form-group col-md-12">
                                        <div id="bmsm_tiers_container">
                                            <h5 class="mt-4">BMSM Tiers</h5>
                                            <div id="tier_fields_wrapper">
                                                @if ($getitem->bmsmTiers && $getitem->bmsmTiers->count())
                                                    @foreach ($getitem->bmsmTiers as $index => $tier)
                                                        <div class="tier-row row mb-2" data-index="{{ $index }}">
                                                            <div class="col-md-4">
                                                                <label>Min Qty</label>
                                                                <input type="number"
                                                                    name="tiers[{{ $index }}][min_qty]"
                                                                    class="form-control" placeholder="Min Qty / Amount"
                                                                    value="{{ $tier->min_qty }}" required>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label>Max Qty</label>
                                                                <input type="number"
                                                                    name="tiers[{{ $index }}][max_qty]"
                                                                    class="form-control" placeholder="Max Qty / Amount"
                                                                    value="{{ $tier->max_qty }}" required>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label>Discount</label>
                                                                <input type="number"
                                                                    name="tiers[{{ $index }}][discount_value]"
                                                                    class="form-control" placeholder="Discount Value"
                                                                    value="{{ $tier->discount_value }}" required>
                                                            </div>
                                                            <div class="col-md-2 d-flex align-items-end">
                                                                <button type="button"
                                                                    class="btn btn-danger remove-tier">Remove</button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Save Button -->

                                    <div
                                        class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                        <a href="{{ URL::to('admin/bogoDeals') }}"
                                            class="btn btn-danger">{{ trans('labels.cancel') }}</a>
                                        <button class="btn btn-primary"
                                            @if (env('Environment') == 'sendbox') type="button"
                                                onclick="myFunction()"
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
<style>
    .ml-2 {
        margin-left: 10px;
    }
</style>

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
        $(document).ready(function() {
            $('#bmsm_deal_type').on('change', function() {
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
    </script>
    <script>
        let tierIndex = {{ $getitem->bmsmTiers->count() ?? 0 }};

        document.getElementById('add_tier_button').addEventListener('click', function() {
            const wrapper = document.getElementById('tier_fields_wrapper');

            const row = document.createElement('div');
            row.className = 'tier-row row mb-2';
            row.setAttribute('data-index', tierIndex);

            row.innerHTML = `
            <div class="col-md-4">
                <label>Min Qty</label>
                <input type="number" name="tiers[${tierIndex}][min_qty]" class="form-control" placeholder="Min Qty / Amount" required>
            </div>
            <div class="col-md-3">
                <label>Max Qty</label>
                <input type="number" name="tiers[${tierIndex}][max_qty]" class="form-control" placeholder="Max Qty / Amount" required>
            </div>
            <div class="col-md-3">
                <label>Discount</label>
                <input type="number" name="tiers[${tierIndex}][discount_value]" class="form-control"  placeholder="Discount Value"  required>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-tier">Remove</button>
            </div>
        `;

            wrapper.appendChild(row);
            tierIndex++;
        });

        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-tier')) {
                console.log('triger');
                e.target.closest('.tier-row').remove();
            }
        });
    </script>
@endsection
