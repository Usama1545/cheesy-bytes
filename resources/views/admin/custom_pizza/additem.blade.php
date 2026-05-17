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
                            <form method="post" action="{{ URL::to('admin/custom_pizza/store') }}" name="about"
                                  id="about"
                                  enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="cat_id" class="col-form-label">Size
                                                <span class="text-danger">*</span> </label>
                                            <input name="name" type="number" required class="form-control"
                                                   value="{{ old('name') }}" placeholder="size">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="cat_id" class="col-form-label">Label
                                                <span class="text-danger">*</span> </label>
                                            <input name="label" required class="form-control"
                                                   placeholder="Label">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="subcat_id"
                                                   class="col-form-label">{{ trans('labels.price') }}<span
                                                    class="text-danger">*</span></label>
                                            <input name="price" type="number" step=".01" class="form-control" required
                                                   value="{{ old('price') }}" placeholder="price">


                                        </div>
                                    </div>
                                </div>
                                <hr class="w-full">
                                <div class="row">
                                    <div class="d-flex justify-content-between align-items-center col-12 mb-3">
                                        <label for="name" class="fw-bold col-form-label">Pizza Crusts <span
                                                class="text-danger">*</span></label>
                                        <button type="button" title="Add Crust"
                                                class="btn btn--primary border add_additional_crust_option">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                    <!-- Existing Crust Options -->

                                    <!-- Placeholder for Adding New Crust Options -->
                                    <div class="col-12">
                                        <div id="additionalCrustOptions"></div>
                                    </div>

                                    <!-- Button to Add New Crust Option -->

                                </div>
                                <hr class="w-full">

                                <!-- Toppings  -->

                                <div class="row">
                                    <div class="d-flex justify-content-between align-items-center col-12 mb-3">
                                        <label for="name" class="fw-bold col-form-label">Pizza Toppings<span
                                                class="text-danger">*</span></label>
                                        <button type="button" title="Add Topping"
                                                class="btn btn--primary add_additional_topping_option">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                    <!-- Existing Crust Options -->


                                    <!-- Placeholder for Adding New Topping Options -->
                                    <div class="col-12">
                                        <div id="additionalToppingOptions"></div>
                                    </div>

                                    <!-- Button to Add New Crust Option -->

                                </div>
                                <hr class="w-full">


                                <!-- Sauce -->
                                <div class="row mb-3">
                                    <div class="d-flex justify-content-between align-items-center col-12 mb-3">

                                        <label for="name" class="fw-bold col-form-label">Pizza Sauce<span
                                                class="text-danger">*</span></label>
                                        <button type="button" title="Add Sauce"
                                                class="btn btn--primary add_additional_sauce_option">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                    <!-- Existing Crust Options -->


                                    <!-- Placeholder for Adding New Crust Options -->
                                    <div class="col-12">
                                        <div id="additionalSauceOptions"></div>
                                    </div>

                                    <!-- Button to Add New Crust Option -->

                                </div>


                                <div
                                    class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                    <a href="{{ URL::to('admin/item') }}"
                                       class="btn btn-danger">{{ trans('labels.cancel') }}</a>
                                    <button class="btn btn-primary"
                                            @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()"
                                            @else type="submit" @endif>{{ trans('labels.save') }}</button>
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


    <script>
        $(document).ready(function () {
            let crustAdded = $('.data-amenities').length;

            $('.add_additional_crust_option').on('click', function () {
                if (crustAdded >= 10) {
                    return false; // Prevent adding more than 10 crust options
                }
                crustAdded++;

                $("#additionalCrustOptions").append(`
            <div class="row data-amenities mb-3">
                <div class="form-group col-12 col-lg-4 col-md-4">
                    <label for="name" class="col-form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" name="crust_name[]" class="form-control" placeholder="Name" required>
                </div>
                <div class="form-group col-12 col-lg-4 col-md-4">
                    <label for="branch_id" class="col-form-label">Branch <span class="text-danger">*</span></label>
                    <select name="crust_branch[]" class="form-control selectpicker" required
                            data-live-search="true">
                        @foreach (helper::get_branchs() as $branch)
                <option value="{{ $branch->id }}">{{ $branch->name . '-' . $branch->city }}</option>
                        @endforeach
                </select>
            </div>
            <div class="form-group col-12 col-lg-3 col-md-4">
                <label for="price" class="col-form-label">Price <span class="text-danger">*</span></label>
                <input type="number" step=".01" name="crust_price[]" class="form-control" placeholder="Price" required>
            </div>
            <div class="col-12 col-lg-1 d-flex align-items-center">
                <button type="button" class="btn btn-outline-danger deleteCrustOption">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
            <div class="form-group col-12  d-none">
                <label for="description" class="col-form-label">Description <span class="text-danger">*</span></label>
                <textarea name="crust_description[]" class="form-control" placeholder="Description></textarea>
            </div>

        </div>
`);

                // Reinitialize selectpicker for dynamically added elements
                $('.selectpicker').selectpicker('refresh');
            });

            $(document).on('click', '.deleteCrustOption', function () {
                $(this).closest('.data-amenities').remove();
                crustAdded--;
            });
        });


        //for toppings

        $(document).ready(function () {
            $('.add_additional_topping_option').on('click', function () {
                $("#additionalToppingOptions").append(`
            <div class="row data-toppings mb-3">
                <div class="form-group col-12 col-lg-4 col-md-4">
                    <label for="name" class="col-form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" name="topping_name[]" class="form-control" placeholder="Name" required>
                </div>
                <div class="form-group col-12 col-lg-4 col-md-4">
                    <label for="branch_id" class="col-form-label">Branch <span class="text-danger">*</span></label>
                    <select name="topping_branch[]" class="form-control selectpicker" required
                            data-live-search="true">
                        @foreach (helper::get_branchs() as $branch)
                <option value="{{ $branch->id }}">
                                {{ $branch->name . '-' . $branch->city }}
                </option>
@endforeach
                </select>
            </div>
            <div class="form-group col-12 col-lg-3 col-md-4">
                <label for="price" class="col-form-label">Price <span class="text-danger">*</span></label>
                <input type="number" step=".01" name="topping_price[]" class="form-control" placeholder="Price" required>
            </div>
            <div class="col-12 col-lg-1 d-flex align-items-center">
                <button type="button" class="btn btn-outline-danger deleteToppingOption">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </div>
`);

                // Refresh selectpicker for dynamically added dropdown
                $('.selectpicker').selectpicker('refresh');
            });

            $(document).on('click', '.deleteToppingOption', function () {
                $(this).closest('.data-toppings').remove();
            });
        });


        //for Sauces

        $(document).ready(function () {
            $('.add_additional_sauce_option').on('click', function () {
                $("#additionalSauceOptions").append(`
            <div class="row data-sauces mb-3">
                <div class="form-group col-12 col-lg-4 col-md-4">
                    <label for="sauce_name" class="col-form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" name="sauce_name[]" class="form-control" placeholder="Name" required>
                </div>
                <div class="form-group col-12 col-lg-4 col-md-4">
                    <label for="sauce_branch" class="col-form-label">Branch <span class="text-danger">*</span></label>
                    <select name="sauce_branch[]" class="form-control selectpicker" required data-live-search="true">
                        @foreach (helper::get_branchs() as $branch)
                <option value="{{ $branch->id }}">
                                {{ $branch->name . '-' . $branch->city }}
                </option>
@endforeach
                </select>
            </div>
            <div class="form-group col-12 col-lg-3 col-md-4">
                <label for="sauce_price" class="col-form-label">Price <span class="text-danger">*</span></label>
                <input type="number" step=".01" name="sauce_price[]" class="form-control" placeholder="Price" required>
            </div>
            <div class="col-12 col-lg-1 d-flex align-items-center">
                <button type="button" class="btn btn-outline-danger deleteSauceOption">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </div>
`);

                // Refresh selectpicker for newly added dropdown
                $('.selectpicker').selectpicker('refresh');
            });

            $(document).on('click', '.deleteSauceOption', function () {
                $(this).closest('.data-sauces').remove();
            });
        });

    </script>
@endsection
