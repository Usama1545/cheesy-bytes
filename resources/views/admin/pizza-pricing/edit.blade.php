@extends('admin.theme.default')
@section('styles')
    <link rel="stylesheet"
        href="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/css/bootstrap/bootstrap-select.v1.14.0-beta2.min.css') }}">
@endsection
@section('content')
    @include('admin.breadcrumb')
    <div class="row mt-3">
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <form action="{{ URL::to('/admin/pizza_sizes_price/update') }}" method="POST">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="id" value="{{ $id }}">
                            <div class="d-flex justify-content-between align-items-center col-12 mb-3">
                                <label for="name" class="fw-bold col-form-label">Pizza Size Price
                                    ({{ $pizza->name }})<span class="text-danger">*</span></label>
                                <button type="button" title="Add Size Price"
                                    class="btn btn--primary add_additional_price_option">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                            @foreach ($sizes as $index => $option)
                                <div class="row price-amenities align-items-center mb-3"
                                    data-index="edit_{{ $index }}">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="size_{{ $index }}" class="col-form-label">
                                                Size <span class="text-danger">*</span>
                                            </label>
                                            <select name="size_prices[edit_{{ $index }}][size]"
                                                class="form-control selectpicker" required data-live-search="true"
                                                id="size_edit_{{ $index }}">
                                                @foreach (helper::get_sizes() as $branch)
                                                    <option value="{{ $branch->id }}"
                                                        {{ $branch->id === $option['size_id'] ? 'selected' : '' }}>
                                                        {{ $branch->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="crust_edit_{{ $index }}" class="col-form-label">
                                                Branch <span class="text-danger">*</span>
                                            </label>
                                            <select name="size_prices[edit_{{ $index }}][branch_id]"
                                                class="form-control selectpicker" multiple required data-live-search="true"
                                                id="branch_edit_{{ $index }}">
                                                @foreach (helper::get_branchs() as $crust)
                                                    <option value="{{ $crust->id }}"
                                                        {{ $crust->id === $option['branch_id'] ? 'selected' : '' }}>
                                                        {{ $crust->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="price_edit_{{ $index }}" class="col-form-label">
                                                Price <span class="text-danger">*</span>
                                            </label>
                                            <input type="number" step="0.01"
                                                name="size_prices[edit_{{ $index }}][price]" class="form-control"
                                                value="{{ $option['price'] }}" placeholder="Price" required
                                                id="price_edit_{{ $index }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-1 d-flex align-items-center">
                                        <button type="button" class="btn btn-outline-danger deletePriceOption">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach


                            <!-- Placeholder for Adding New Crust Options -->
                            <div class="col-12">
                                <div id="additionalPriceOptions"></div>
                            </div>
                            <div class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                <a href="{{ URL::to('admin/sizes') }}"
                                    class="btn btn-danger">{{ trans('labels.cancel') }}</a>
                                <button class="btn btn-primary "
                                    @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()"
                                        @else type="submit" @endif>{{ trans('labels.save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card border-0 mt-3 box-shadow">
                <div class="card-body">
                    <form action="{{ URL::to('/admin/pizza_crusts/update') }}" method="POST">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="id" value="{{ $id }}">
                            <div class="d-flex justify-content-between align-items-center col-12 mb-3">
                                <label for="name" class="fw-bold col-form-label">Pizza Size and Crust<span
                                        class="text-danger">*</span></label>
                                <button type="button" title="Add Topping"
                                    class="btn btn--primary add_additional_crust_option">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                            @foreach ($groupedData as $index => $option)
                                <div class="row data-amenities align-items-center mb-3"
                                    data-index="edit_{{ $index }}">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="size_edit_{{ $index }}" class="col-form-label">
                                                Size <span class="text-danger">*</span>
                                            </label>
                                            <select name="size_crusts[edit_{{ $index }}][size]"
                                                class="form-control selectpicker" required data-live-search="true"
                                                id="size_edit_{{ $index }}">
                                                @foreach (helper::get_sizes() as $branch)
                                                    <option value="{{ $branch->id }}"
                                                        {{ $branch->id === $option['size_id'] ? 'selected' : '' }}>
                                                        {{ $branch->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="crust_edit_{{ $index }}" class="col-form-label">
                                                Crust <span class="text-danger">*</span>
                                            </label>
                                            <select name="size_crusts[edit_{{ $index }}][crusts][]"
                                                class="form-control selectpicker" multiple required data-live-search="true"
                                                id="crust_edit_{{ $index }}">
                                                @foreach (helper::get_crusts() as $crust)
                                                    <option value="{{ $crust->id }}"
                                                        {{ in_array($crust->id, $option['crust_ids']) ? 'selected' : '' }}>
                                                        {{ $crust->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="price_edit_{{ $index }}" class="col-form-label">
                                                Price <span class="text-danger">*</span>
                                            </label>
                                            <input type="number" step="0.01"
                                                name="size_crusts[edit_{{ $index }}][price]" class="form-control"
                                                value="{{ $option['price'] }}" placeholder="Price" required
                                                id="price_edit_{{ $index }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-1 d-flex align-items-center">
                                        <button type="button" class="btn btn-outline-danger deleteCrustOption">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach


                            <!-- Placeholder for Adding New Crust Options -->
                            <div class="col-12">
                                <div id="additionalCrustOptions"></div>
                            </div>
                            <div class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                <a href="{{ URL::to('admin/sizes') }}"
                                    class="btn btn-danger">{{ trans('labels.cancel') }}</a>
                                <button class="btn btn-primary "
                                    @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()"
                                        @else type="submit" @endif>{{ trans('labels.save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        var placehodername = "{{ trans('labels.name') }}";
        var placeholderprice = "{{ trans('labels.price') }}";
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.12.1/ckeditor.js"></script>

    <script
        src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/bootstrap/bootstrap-select.v1.14.0-beta2.min.js') }}">
    </script>
    <script src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/additem.js') }}"></script>

    <script>
        $(document).ready(function() {
            let crustAdded = $('.data-amenities').length;

            $('.add_additional_crust_option').on('click', function() {
                crustAdded++;

                const uniqueIndex = `crustOption_${crustAdded}`; // Unique identifier for each set

                $("#additionalCrustOptions").append(`
                <div class="row data-amenities mb-3" data-index="${uniqueIndex}">
                    <div class="form-group col-12 col-lg-4 col-md-4">
                        <label for="size_${uniqueIndex}" class="col-form-label">Size <span class="text-danger">*</span></label>
                        <select name="size_crusts[${uniqueIndex}][size]" class="form-control selectpicker" required data-live-search="true" id="size_${uniqueIndex}">
                        @foreach (helper::get_sizes() as $branch)
                <option value="{{ $branch->id }}">
                                {{ $branch->name }}
                </option>
@endforeach
                </select>
            </div>
            <div class="form-group col-12 col-lg-4 col-md-4">
                <label for="crust_${uniqueIndex}" class="col-form-label">Crust <span class="text-danger">*</span></label>
                        <select name="size_crusts[${uniqueIndex}][crusts][]" class="form-control selectpicker" multiple required data-live-search="true" id="crust_${uniqueIndex}">
                        @foreach (helper::get_crusts() as $branch)
                <option value="{{ $branch->id }}">
                                {{ $branch->name }}
                </option>
@endforeach
                </select>
            </div>
            <div class="form-group col-12 col-lg-3 col-md-3">
                <label for="price_${uniqueIndex}" class="col-form-label">Price <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="size_crusts[${uniqueIndex}][price]" class="form-control" placeholder="Price" required id="price_${uniqueIndex}">
                    </div>
                    <div class="col-12 col-lg-1 d-flex align-items-center">
                        <button type="button" class="btn btn-outline-danger deleteCrustOption">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>
            `);

                // Refresh selectpicker for dynamically added selects
                $('.selectpicker').selectpicker('refresh');
            });

            $(document).on('click', '.deleteCrustOption', function() {
                $(this).closest('.data-amenities').remove();
                crustAdded--;
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            let priceAdded = $('.price-amenities').length;

            $('.add_additional_price_option').on('click', function() {
                priceAdded++;

                const uniqueIndex = `crustOption_${priceAdded}`; // Unique identifier for each set

                $("#additionalPriceOptions").append(`
                <div class="row data-amenities mb-3" data-index="${uniqueIndex}">
                    <div class="form-group col-12 col-lg-4 col-md-4">
                        <label for="size_${uniqueIndex}" class="col-form-label">Size <span class="text-danger">*</span></label>
                        <select name="size_prices[${uniqueIndex}][size]" class="form-control selectpicker" required data-live-search="true" id="size_${uniqueIndex}">
                        @foreach (helper::get_sizes() as $branch)
                <option value="{{ $branch->id }}">
                                {{ $branch->name }}
                </option>
@endforeach
                </select>
            </div>
            <div class="form-group col-12 col-lg-4 col-md-4">
                <label for="crust_${uniqueIndex}" class="col-form-label">Branch <span class="text-danger">*</span></label>
                        <select name="size_prices[${uniqueIndex}][branch_id]" class="form-control selectpicker" required data-live-search="true" id="branch_${uniqueIndex}">
                        @foreach (helper::get_branchs() as $branch)
                <option value="{{ $branch->id }}">
                                {{ $branch->name }}
                </option>
@endforeach
                </select>
            </div>
            <div class="form-group col-12 col-lg-3 col-md-3">
                <label for="price_${uniqueIndex}" class="col-form-label">Price <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="size_prices[${uniqueIndex}][price]" class="form-control" placeholder="Price" required id="price_${uniqueIndex}">
                    </div>
                    <div class="col-12 col-lg-1 d-flex align-items-center">
                        <button type="button" class="btn btn-outline-danger deletePriceOption">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>
            `);

                // Refresh selectpicker for dynamically added selects
                $('.selectpicker').selectpicker('refresh');
            });

            $(document).on('click', '.deletePriceOption', function() {
                $(this).closest('.price-amenities').remove();
                priceAdded--;
            });
        });
    </script>
@endsection
