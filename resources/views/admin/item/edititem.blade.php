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
                            <form method="post" action="{{ URL::to('admin/item/update') }}" name="about" id="about"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" class="form-control" id="id" name="id"
                                    value="{{ $getitem->id }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cat_id" class="col-form-label">{{ trans('labels.category') }}
                                                <span class="text-danger">*</span> </label>
                                            <select name="cat_id" class="form-select" id="cat_id"
                                                data-url="{{ URL::to('admin/item/subcategories') }}" required>
                                                <option value="" selected>{{ trans('labels.select') }}</option>
                                                @foreach ($getcategory as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ $getitem->cat_id == $category->id ? 'selected' : '' }}
                                                        data-id="{{ $category->id }}">{{ $category->category_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subcat_id"
                                                class="col-form-label">{{ trans('labels.subcategory') }}</label>
                                            <select name="subcat_id" class="form-select" id="subcat_id">
                                                <option value="" selected>{{ trans('labels.select') }}</option>
                                                @foreach ($getsubcategory as $subcatdata)
                                                    <option value="{{ $subcatdata->id }}"
                                                        {{ $getitem->subcat_id == $subcatdata->id ? 'selected' : '' }}>
                                                        {{ $subcatdata->subcategory_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="getitem_name" class="col-form-label">{{ trans('labels.name') }}
                                                <span class="text-danger">*</span> </label>
                                            <input type="text" class="form-control" id="getitem_name" name="item_name"
                                                placeholder="{{ trans('labels.name') }}" value="{{ $getitem->item_name }}"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="video_url"
                                                class="col-form-label">{{ trans('labels.video_url') }}</label>
                                            <input type="text" class="form-control" id="video_url" name="video_url"
                                                placeholder="{{ trans('labels.video_url') }}"
                                                value="{{ $getitem->video_url }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="getaddons_id"
                                                class="col-form-label">{{ trans('labels.addons_group') }}</label>
                                            <?php $selected = explode(',', $getitem->addons_id); ?>
                                            <select name="addongroup_id[]" class="form-control selectpicker" multiple
                                                data-live-search="true" id="getaddons_id">
                                                @foreach ($getaddongroup as $addongroup)
                                                    @php
                                                        $availableAddons = collect($getaddon)->where(
                                                            'addongroup_id',
                                                            $addongroup->id,
                                                        );
                                                    @endphp
                                                    @if ($availableAddons->isNotEmpty())
                                                        <option value="{{ $addongroup->id }}"
                                                            {{ in_array($addongroup->id, $selected) ? 'selected' : '' }}>
                                                            {{ $addongroup->name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="item_type" class="col-form-label">{{ trans('labels.item_type') }}
                                                <span class="text-danger">*</span> </label>
                                            <div class="col-md-12">
                                                <div class="form-check-inline w-100 mb-1">
                                                    <input class="form-check-input me-0" type="radio" name="item_type"
                                                        id="veg" value="1" required
                                                        @if ($getitem->item_type == 1) checked @endif>
                                                    <label class="form-check-label" for="veg">
                                                        <img src="{{ helper::image_path('veg.svg') }}" alt=""
                                                            srcset=""> {{ trans('labels.veg') }}</label>
                                                </div>
                                                <div class="form-check-inline w-100">
                                                    <input class="form-check-input me-0" type="radio" name="item_type"
                                                        id="nonveg" value="2" required
                                                        @if ($getitem->item_type == 2) checked @endif>
                                                    <label class="form-check-label" for="nonveg">
                                                        <img src="{{ helper::image_path('nonveg.svg') }}" alt=""
                                                            srcset=""> {{ trans('labels.nonveg') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 d-flex flex-wrap justify-content-between align-items-center">
                                        <div class="form-group">
                                            <label class="col-form-label">{{ trans('labels.item_has_extras') }} <span
                                                    class="text-danger">*</span> </label>
                                            <div class="col-md-12">
                                                <div class="form-check-inline">
                                                    <input class="form-check-input me-0 has_extras" type="radio"
                                                        name="has_extras" id="extras_no" value="2" checked
                                                        @if ($getitem->has_extras == 2) checked @endif>
                                                    <label class="form-check-label"
                                                        for="extras_no">{{ trans('labels.no') }}</label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <input class="form-check-input me-0 has_extras" type="radio"
                                                        name="has_extras" id="extras_yes" value="1"
                                                        @if ($getitem->has_extras == 1) checked @endif>
                                                    <label class="form-check-label"
                                                        for="extras_yes">{{ trans('labels.yes') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="">
                                            @if (count($globalextras) > 0)
                                                <button class="btn btn-primary align-items-end mb-sm-0 mb-2" type="button"
                                                    id="globalextra"
                                                    onclick="global_extras('{{ URL::to('admin/getextras') }}','{{ trans('labels.name') }}','{{ trans('labels.price') }}')">
                                                    <i class="fa-sharp fa-solid fa-plus"></i>
                                                    {{ trans('labels.add_global_extras') }}</button>
                                            @endif
                                            <button class="btn btn-secondary px-3 mb-sm-0 mb-2" type="button" id="add_extra"
                                                onclick="more_editextras_fields('{{ trans('labels.name') }}','{{ trans('labels.price') }}')">
                                                <i class="fa-sharp fa-solid fa-plus"></i> </button>
                                        </div>
                                    </div>
                                    <div id="extras">
                                        @foreach ($getitem['extras'] as $key => $extras)
                                            <div class="row mb-md-0 mb-2">
                                                <input type="hidden" class="form-control" name="extras_id[]"
                                                    value="{{ $extras->id }}">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        @if ($key == 0)
                                                            <label class="col-form-label">{{ trans('labels.name') }}
                                                                <span class="text-danger"> * </span></label>
                                                        @endif
                                                        <input type="text" class="form-control extras_name"
                                                            name="extras_name[]" value="{{ $extras->name }}"
                                                            placeholder="{{ trans('labels.name') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        @if ($key == 0)
                                                            <label class="col-form-label">{{ trans('labels.price') }}
                                                                <span class="text-danger"> * </span></label>
                                                        @endif
                                                        <div class="d-flex gap-2">
                                                            <input type="text"
                                                                class="form-control numbers_only extras_price"
                                                                name="extras_price[]" value="{{ $extras->price }}"
                                                                placeholder="{{ trans('labels.price') }}" required>
                                                            @if (count($getitem['extras']) > 1)
                                                                <button class="btn btn-danger px-3" type="button"
                                                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="deleteItemExtras('{{ $extras->id }}','{{ $getitem->id }}','{{ URL::to('admin/item/deleteextras') }}')" @endif>
                                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="hiddenextrascount d-none">{{ $key }}</span>
                                        @endforeach
                                        <div id="global-extras"></div>
                                        <div id="more_editextras_fields"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label for="price"
                                                class="col-form-label">{{ trans('labels.product_price') }}
                                                <span class="text-danger">*</span> </label>
                                            <input type="text" class="form-control numbers_only" name="price"
                                                id="price" placeholder="{{ trans('labels.product_price') }}"
                                                value="{{ $getitem->price }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label for="original_price"
                                                class="col-form-label">{{ trans('labels.original_price') }}</label>
                                            <input type="text" class="form-control numbers_only" name="original_price"
                                                id="original_price" placeholder="{{ trans('labels.original_price') }}"
                                                value="{{ $getitem->original_price }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="preparation_time"
                                                        class="col-form-label">{{ trans('labels.preparation_time') }}
                                                        <span class="text-danger">*</span> </label>
                                                    <input type="text" class="form-control" name="preparation_time"
                                                        id="preparation_time" value="{{ $getitem->preparation_time }}"
                                                        placeholder="{{ trans('labels.preparation_time') }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="tax"
                                                        class="col-form-label">{{ trans('labels.tax') }}</label>
                                                    <?php $selected = explode(',', $getitem->tax); ?>
                                                    <select name="tax[]" class="form-control selectpicker" multiple
                                                        data-live-search="true" id="tax">
                                                        @foreach ($gettax as $tax)
                                                            <option value="{{ $tax->id }}"
                                                                {{ in_array($tax->id, $selected) ? 'selected' : '' }}>
                                                                {{ $tax->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description"
                                                class="col-form-label">{{ trans('labels.description') }}</label>
                                            <textarea class="form-control" rows="5" name="description" id="description"
                                                placeholder="{{ trans('labels.description') }}">{{ $getitem->item_description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="allergens"
                                                class="col-form-label">{{ trans('labels.allergens') }}</label>
                                            <textarea class="form-control" rows="5" name="allergens" id="allergens"
                                                placeholder="{{ trans('labels.allergens') }}">{{ $getitem->item_allergens }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                    <a href="{{ URL::to('admin/item') }}"
                                        class="btn btn-danger">{{ trans('labels.cancel') }}</a>
                                    <button class="btn btn-primary"
                                        @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <button type="button" class="btn btn-primary mb-3 {{ session()->get('direction') == '2' ? 'float-start' : 'float-end' }}" data-bs-toggle="modal"
                    data-bs-target="#AddProduct" data-whatever="@addProduct">{{ trans('labels.add_image') }}</button>
            </div>
            <div class="col-12">
                <div class="row">
                    @foreach ($getitemimages as $itemimage)
                        <div class="col-lg-2 col-md-4 col-sm-6 my-card dataid{{ $itemimage->id }}" id="table-image">
                            <img class="img-fluid rounded edit-item-image"
                                src='{{ helper::image_path($itemimage->image) }}'>
                            <div class="actioncenter justify-content-center">
                                <a href="javascript:void(0)" class="btn btn-sm btn-info square mx-1"
                                    onclick="updateItemImage('{{ $itemimage->id }}','{{ URL::to('admin/item/showimage') }}')"><i
                                        class="fa-solid fa-pen-to-square" aria-hidden="true"></i> </a>
                                @if (count($getitemimages) > 1)
                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger square mx-1"
                                        @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else onclick="deleteItemImage('{{ $itemimage->id }}','{{ $itemimage->item_id }}','{{ URL::to('admin/item/destroyimage') }}')" @endif><i
                                            class="fa fa-trash" aria-hidden="true"></i> </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Images -->
    <div class="modal fade" id="EditImages" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabeledit"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post" name="editimg" class="editimg" id="editimg" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="updateimageurl" value="{{ URL::to('admin/item/updateimage') }}">
                <input type="hidden" id="idd" name="id">
                <input type="hidden" class="form-control" id="old_img" name="old_img">
                <input type="hidden" name="removeimg" id="removeimg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabeledit">{{ trans('labels.images') }}</h5>
                        <button type="button" class="btn-close {{ session()->get('direction') == 2 ? 'close' : '' }}"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <span id="emsg"></span>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{ trans('labels.images') }} <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="image" id="image" accept="image/*">
                        </div>
                        <div class="galleryim"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger"
                            data-bs-dismiss="modal">{{ trans('labels.close') }}</button>
                        <button class="btn btn-primary"
                            @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Add Item Image -->
    <div class="modal fade" id="AddProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post" name="addproduct" class="addproduct" id="addproduct" enctype="multipart/form-data">
                <span id="msg"></span>
                <input type="hidden" id="storeimagesurl" value="{{ URL::to('admin/item/storeimages') }}">
                <input type="hidden" name="itemid" id="itemid" value="{{ request()->route('id') }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ trans('labels.images') }}</h5>
                        <button type="button" class="btn-close {{ session()->get('direction') == 2 ? 'close' : '' }}"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <span id="iiemsg"></span>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-form-label">{{ trans('labels.images') }}
                                <span class="text-danger">*</span></label>
                            <input type="file" multiple="true" class="form-control" name="file[]" id="file"
                                accept="image/*" required="">
                        </div>
                        <div class="gallery"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger"
                            data-bs-dismiss="modal">{{ trans('labels.close') }}</button>
                        <button class="btn btn-primary"
                            @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
                    </div>
                </div>
            </form>
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
