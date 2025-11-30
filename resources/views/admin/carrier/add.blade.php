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
                            <form action="{{ URL::to('admin/carrier/store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="col-form-label" for="">Name
                                            <span class="text-danger">*</span> </label>
                                        <input type="text" class="form-control" name="category_name"
                                            placeholder="Carrier Name" value="{{ old('category_name') }}"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label" for="">Description
                                           </label>
                                        <input type="text" class="form-control" name="category_description"
                                               placeholder="description"
                                               value="{{ old('category_description') }}" >
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="getaddons_id"
                                                   class="col-form-label">Branch<span class="text-danger">*</span></label>
                                            <select name="branch_id" class="form-control selectpicker" required
                                                    data-live-search="true" id="getaddons_id">
                                                @foreach (helper::get_branchs() as $branch)
                                                    <option value="{{ $branch->id }}"
                                                        >
                                                        {{ $branch->name.'-'.$branch->city }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label" for="">Link
                                            <span class="text-danger">*</span> </label>
                                        <input type="text" class="form-control" name="link"
                                               placeholder="link" value="{{ old('link') }}"
                                               required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label" for="">{{ trans('labels.image') }}
                                            <span class="text-danger">*</span> </label>
                                        <input type="file" class="form-control" name="image" accept="image/*" required>
                                    </div>

                                </div>
                                <div class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                    <a href="{{ URL::to('admin/carrier') }}"
                                        class="btn btn-danger">{{ trans('labels.cancel') }}</a>
                                    <button class="btn btn-primary"
                                        @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
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
    <script>
        var placehodername = "{{ trans('labels.name') }}";
        var placeholderprice = "{{ trans('labels.price') }}";
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.12.1/ckeditor.js"></script>
    <script type="text/javascript">
        CKEDITOR.replace('allergens');
    </script>
    <script
        src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/bootstrap/bootstrap-select.v1.14.0-beta2.min.js') }}">
    </script>
    <script src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/additem.js') }}"></script>
@endsection
