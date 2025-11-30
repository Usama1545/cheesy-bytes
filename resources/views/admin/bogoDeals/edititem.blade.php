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
                            <form method="post" action="{{ URL::to('admin/bogoDeals/update') }}" name="about"
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
                                    <div class="form-group col-md-6">
                                        <label class="form-label">Discount
                                            <span class="text-danger"> *</span></label>
                                        <input type="text" class="form-control numbers_only" name="offer_amount"
                                            value="{{ $getitem->offer_amount }}" placeholder="Discount" required="">
                                    </div>
                                    <div class="col-sm-6 form-group" id="end_time">
                                        <label class="form-label">Order
                                            <span class="text-danger"> *</span></label>
                                        <input type="number" class="form-control" value="{{ $getitem->order }}"
                                            name="order" required="">
                                    </div>

                                    <!-- adding category select and number of proects -->

                                    <hr />
                                    <div class="w-100 mb-2">
                                        <button type="button" class="btn btn-success mt-3 float-end" id="add-rule-btn">
                                            + Add Rule
                                        </button>
                                    </div>

                                    <div id="deal-rules-container">
                                        @php
                                            $rules = old('deal_rules', $deal_rules ?? []);
                                        @endphp

                                        @foreach ($rules as $index => $rule)
                                            <div class="border p-3 mb-3 rounded">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <label>Category</label>
                                                        <select name="deal_rules[{{ $index }}][category_id]"
                                                            class="form-control">
                                                            @foreach (helper::getAdminCategories() as $cat)
                                                                <option value="{{ $cat->id }}"
                                                                    {{ $rule['category_id'] == $cat->id ? 'selected' : '' }}>
                                                                    {{ $cat->category_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label>Products</label>
                                                        <select name="deal_rules[{{ $index }}][products][]"
                                                            class="form-control selectpicker" multiple
                                                            data-live-search="true">
                                                            @php $selectedProducts = $rule['products'] ?? []; @endphp
                                                            @foreach (helper::getItemsByCategory($rule['category_id']) as $product)
                                                                <option value="{{ $product->id }}"
                                                                    {{ in_array($product->id, $selectedProducts) ? 'selected' : '' }}>
                                                                    {{ $product->item_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label>Size</label>
                                                        <select name="deal_rules[{{ $index }}][size_id]"
                                                            class="form-control selectpicker" data-live-search="true">
                                                            @foreach (helper::get_sizes() as $item)
                                                                <option value="{{ $item->id }}"
                                                                    {{ $rule['size_id'] == $item->id ? 'selected' : '' }}>
                                                                    {{ $item->name . '(' . $item->label . ')' }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label>Max</label>
                                                        <input type="text" name="deal_rules[{{ $index }}][max]"
                                                            class="form-control" value="{{ $rule['max'] }}">
                                                    </div>

                                                    <div class="col-md-1 d-flex align-items-center">
                                                        <label class="form-check">
                                                            <input type="checkbox"
                                                                name="deal_rules[{{ $index }}][is_free]"
                                                                class="form-check-input"
                                                                {{ !empty($rule['is_free']) ? 'checked' : '' }}>
                                                            Free
                                                        </label>
                                                    </div>

                                                    <div class="col-md-1 d-flex align-items-center">
                                                        <label class="form-check">
                                                            <input type="checkbox"
                                                                name="deal_rules[{{ $index }}][unique]"
                                                                class="form-check-input"
                                                                {{ !empty($rule['unique']) ? 'checked' : '' }}>
                                                            Unique
                                                        </label>
                                                    </div>

                                                    <div class="col-md-1 d-flex align-items-center">
                                                        <button type="button" class="btn btn-danger remove-rule"><i
                                                                class="fa fa-trash"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
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
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelector = document.getElementById('category-selector');
            const categoryBlocks = document.querySelectorAll('.category-block');

            function updateCategoryVisibility() {
                const selectedIds = Array.from(categorySelector.selectedOptions).map(option => option.value);

                categoryBlocks.forEach(block => {
                    const catId = block.dataset.categoryId;
                    if (selectedIds.includes(catId)) {
                        block.classList.remove('d-none');
                    } else {
                        block.classList.add('d-none');
                    }
                });
            }

            // Initial state
            updateCategoryVisibility();

            // On change
            categorySelector.addEventListener('change', updateCategoryVisibility);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('deal-rules-container');
            const addBtn = document.getElementById('add-rule-btn');
            let ruleIndex = {{ count($rules) }}; // ✅ start from existing rules count

            addBtn.addEventListener('click', function() {
                const block = document.createElement('div');
                block.classList.add('border', 'p-3', 'mb-3', 'rounded');

                block.innerHTML = `
            <div class="row">
                <div class="col-md-2">
                    <label>Category</label>
                    <select name="deal_rules[${ruleIndex}][category_id]" class="form-control selectpicker"  data-live-search="true">
                        @foreach (helper::getAdminCategories() as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                        @endforeach
                    </select>
                </div>
               
                <div class="col-md-3">
                    <label>Products</label>
                    <select name="deal_rules[${ruleIndex}][products][]" class="form-control selectpicker" multiple data-live-search="true">
                        @foreach (helper::getItems() as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->item_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-2">
                    <label>Size <span class="text-muted">(select if applied)</span></label>
                    <select class="form-control selectpicker" name="deal_rules[${ruleIndex}][size_id]" data-live-search="true">
                        @foreach (helper::get_sizes() as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->name . '(' . $item->label . ')' }}
                            </option>
                        @endforeach
                    </select>
                    
                </div>
                 <div class="col-md-2">
                    <label>Max Quantity</label>
                    <input type="number" name="deal_rules[${ruleIndex}][max]" class="form-control" step="1">
                </div>

                <div class="col-md-1 d-flex align-items-center">
                    <label class="form-check">
                        <input type="checkbox" name="deal_rules[${ruleIndex}][is_free]" class="form-check-input">
                        Free
                    </label>
                </div>

                <div class="col-md-1 d-flex align-items-center">
                    <label class="form-check">
                        <input type="checkbox" name="deal_rules[${ruleIndex}][unique]" class="form-check-input">
                        Unique
                    </label>
                </div>

                <div class="col-md-1 d-flex align-items-center">
                    <button type="button" class="btn btn-danger remove-rule"><i class="fa fa-trash"></i></button>
                </div>
            </div>
        `;

                container.appendChild(block);
                ruleIndex++;

                // re-init bootstrap-select
                $('.selectpicker').selectpicker('refresh');

                // handle remove
                block.querySelector('.remove-rule').addEventListener('click', function() {
                    block.remove();
                });
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            // Handle delete for already rendered rules (old values)
            document.querySelectorAll('#deal-rules-container .remove-rule').forEach(btn => {
                btn.addEventListener('click', function() {
                    btn.closest('.border').remove();
                });
            });

            // Your existing "Add Rule" logic here...
        });
    </script>
@endsection
