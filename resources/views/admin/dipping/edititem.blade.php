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
                            <form method="post" action="{{ URL::to('admin/custom_pizza/update') }}" name="about" id="about"
                                  enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" class="form-control" id="id" name="id"
                                       value="{{ $getitem->id }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cat_id" class="col-form-label">Size
                                                <span class="text-danger">*</span> </label>
                                            <input name="name" type="number" required class="form-control"
                                                   value="{{ $getitem->name }}" placeholder="size">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subcat_id"
                                                   class="col-form-label">{{ trans('labels.price') }}<span
                                                    class="text-danger">*</span></label>
                                            <input name="price" type="number" class="form-control" required
                                                   value="{{ $getitem->price }}" placeholder="price">


                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label" for="">{{ trans('labels.image') }}
                                        <span class="text-danger">*</span> </label>
                                    <input type="file" class="form-control" name="image" id="image"
                                           accept="image/*">
                                    <img src="{{ helper::image_path($getitem->image) }}" alt=""
                                         class="img-fluid rounded h-50px mt-1">
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

@endsection
