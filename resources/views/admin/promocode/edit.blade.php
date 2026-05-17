@extends('admin.theme.default')
@section('styles')
    <link rel="stylesheet"
          href="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/css/bootstrap/bootstrap-select.v1.14.0-beta2.min.css') }}">
@endsection
@section('content')
    @include('admin.breadcrumb')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="form-validation">
                            <form action="{{ URL::to('admin/promocode/update-' . $getpromocode->id) }}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label"
                                                   for="offer_name">{{ trans('labels.offer_name') }}
                                                <span class="text-danger">*</span> </label>
                                            <input type="text" class="form-control" name="offer_name"
                                                   value="{{ $getpromocode->offer_name }}" id="offer_name"
                                                   placeholder="{{ trans('labels.offer_name') }}" required>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="col-form-label" for="">{{ trans('labels.offer_type') }}
                                                        <span class="text-danger">*</span> </label>
                                                    <select class="form-select" name="offer_type" required>
                                                        <option value="" selected>{{ trans('labels.select') }}
                                                        </option>
                                                        <option value="1"
                                                            {{ $getpromocode->offer_type == '1' ? 'selected' : '' }}>
                                                            {{ trans('labels.fixed') }}</option>
                                                        <option value="2"
                                                            {{ $getpromocode->offer_type == '2' ? 'selected' : '' }}>
                                                            {{ trans('labels.percentage') }}</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-form-label" for="">{{ trans('labels.discount') }}
                                                        <span class="text-danger">*</span> </label>
                                                    <input type="text" class="form-control numbers_only"
                                                           name="offer_amount" value="{{ $getpromocode->offer_amount }}"
                                                           id="price" placeholder="{{ trans('labels.discount') }}"
                                                           required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">

                                                    <label class="col-form-label" for="" style="padding-top: 0px">{{ trans('labels.usage_type') }}
                                                        <span class="text-danger">*</span> </label>
                                                    <select class="form-select usage_type" name="usage_type" required>
                                                        <option value="" selected>{{ trans('labels.select') }}
                                                        </option>
                                                        <option value="1"
                                                            {{ $getpromocode->usage_type == '1' ? 'selected' : '' }}>
                                                            {{ trans('labels.once_time') }}</option>
                                                        <option value="2"
                                                            {{ $getpromocode->usage_type == '2' ? 'selected' : '' }}>
                                                            {{ trans('labels.multiple_times') }}</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6" id="usage_limit_input">
                                                    <label class="form-label">{{ trans('labels.usage_limit') }}
                                                        <span class="text-danger">* </span></label>
                                                    <input type="text" class="form-control" name="usage_limit"
                                                           value="{{ $getpromocode->usage_limit }}"
                                                           placeholder="{{ trans('labels.usage_limit') }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6" style="z-index: 1000">
                                                    <label class="col-form-label" style="padding-top: 0px" for="">
                                                        Applied On Category <span class="text-danger">*</span>
                                                    </label>
                                                    <?php $selectedCategories = explode(',', $getpromocode->category_ids); ?>
                                                    <select name="category_ids[]" id="category_ids" class="form-control selectpicker" multiple required
                                                            required data-live-search="true">
                                                        @foreach(helper::getAllCategory() as $category)
                                                            <option value="{{ $category->id }}" {{ in_array($category->id, $selectedCategories) ? 'selected' : '' }}>
                                                                {{ $category->category_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-form-label" style="padding-top: 0px" for="">
                                                        Product Excluded <span class="text-danger">*</span>
                                                    </label>
                                                    <select name="product_ids[]" id="product_ids" class="form-control selectpicker" multiple required data-live-search="true">
                                                        <?php $selectedProducts = explode(',', $getpromocode->product_ids); ?>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="col-form-label"
                                                           for="">{{ trans('labels.offer_code') }}
                                                        <span class="text-danger">*</span> </label>
                                                    <input type="text" class="form-control" name="offer_code"
                                                           value="{{ $getpromocode->offer_code }}" id="offer_code"
                                                           placeholder="{{ trans('labels.offer_code') }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-form-label"
                                                           for="min_amount">{{ trans('labels.min_amount') }}
                                                        <span class="text-danger">*</span> </label>
                                                    <input type="text" class="form-control numbers_only"
                                                           name="min_amount" value="{{ $getpromocode->min_amount }}"
                                                           id="min_amount"
                                                           placeholder="{{ trans('labels.min_amount') }}"
                                                           required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="col-form-label"
                                                           for="start_date">{{ trans('labels.start_date') }}
                                                        <span class="text-danger">*</span> </label>
                                                    <input type="date" class="form-control" name="start_date"
                                                           value="{{ $getpromocode->start_date }}" id="start_date"
                                                           placeholder="{{ trans('labels.start_date') }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-form-label"
                                                           for="expire_date">{{ trans('labels.end_date') }}
                                                        <span class="text-danger">*</span> </label>
                                                    <input type="date" class="form-control" name="expire_date"
                                                           value="{{ $getpromocode->expire_date }}" id="expire_date"
                                                           placeholder="{{ trans('labels.expire_date') }}"
                                                           min="@php echo date('Y-m-d') @endphp" required>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                               <div class="col-sm-6 form-group" id="start_time">
                                        <label class="form-label">Start Time
                                            <span class="text-danger"> *</span></label>
                                        <input type="time" class="form-control" value="{{ $getpromocode->start_time }}" name="start_time" id="start_time"
                                               required="">
                                    </div>

                                    <div class="col-sm-6 form-group" id="end_time">
                                        <label class="form-label">End Time
                                            <span class="text-danger"> *</span></label>
                                        <input type="time" class="form-control" value="{{ $getpromocode->end_time }}" name="end_time" id="end_time"
                                               required="">
                                    </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label"
                                                   for="description">{{ trans('labels.description') }} <span
                                                    class="text-danger">*</span> </label>
                                            <textarea class="form-control" name="description" rows="4" id="description"
                                                      placeholder="{{ trans('labels.description') }}"
                                                      required>{{ $getpromocode->description }}</textarea>
                                        </div>
                                    </div>
                                    <div
                                        class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                        <a href="{{ URL::to('admin/promocode') }}"
                                           class="btn btn-danger">{{ trans('labels.cancel') }}</a>
                                        <button class="btn btn-primary"
                                                @if (env('Environment') == 'sendbox') type="button"
                                                onclick="myFunction()"
                                                @elseif(Auth::user()->type == 5)  type="submit" @endif>{{ trans('labels.save') }}</button>
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
    <script src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/promocode.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.12.1/ckeditor.js"></script>

    <script
        src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/bootstrap/bootstrap-select.v1.14.0-beta2.min.js') }}">
    </script>
    <script src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/additem.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const categorySelect = document.getElementById('category_ids');
            const selectedCategories = Array.from(categorySelect.selectedOptions).map(option => option.value);

            // Function to fetch products based on selected categories
            function fetchProductsByCategories(categories) {
                fetch('{{ route('get.products') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ category_ids: categories })
                })
                    .then(response => response.json())
                    .then(data => {
                        const productSelect = document.getElementById('product_ids');
                        productSelect.innerHTML = ''; // Clear existing options

                        data.forEach(product => {
                            const option = document.createElement('option');
                            option.value = product.id;
                            option.textContent = product.item_name;

                            // Check if the product was previously selected
                            if ({!! json_encode($selectedProducts) !!}.includes(product.id.toString())) {
                                option.selected = true;
                            }

                            productSelect.appendChild(option);
                        });

                        $('.selectpicker').selectpicker('refresh'); // Refresh Bootstrap select
                    })
                    .catch(error => console.error('Error:', error));
            }

            // Trigger fetch on page load for pre-selected categories
            if (selectedCategories.length > 0) {
                fetchProductsByCategories(selectedCategories);
            }

            // Add change event listener
            categorySelect.addEventListener('change', function () {
                const categories = Array.from(this.selectedOptions).map(option => option.value);
                fetchProductsByCategories(categories);
            });
        });
    </script>

@endsection
