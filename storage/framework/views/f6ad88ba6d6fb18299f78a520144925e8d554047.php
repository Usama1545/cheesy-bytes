<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet"
        href="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/css/bootstrap/bootstrap-select.v1.14.0-beta2.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card border-0">
                    <div class="card-body">
                        <div id="privacy-policy-three" class="privacy-policy">
                            <form method="post" action="<?php echo e(URL::to('admin/item/update')); ?>" name="about" id="about"
                                enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" class="form-control" id="id" name="id"
                                    value="<?php echo e($getitem->id); ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cat_id" class="col-form-label"><?php echo e(trans('labels.category')); ?>

                                                <span class="text-danger">*</span> </label>
                                            <select name="cat_id" class="form-select" id="cat_id"
                                                data-url="<?php echo e(URL::to('admin/item/subcategories')); ?>" required>
                                                <option value="" selected><?php echo e(trans('labels.select')); ?></option>
                                                <?php $__currentLoopData = $getcategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($category->id); ?>"
                                                        <?php echo e($getitem->cat_id == $category->id ? 'selected' : ''); ?>

                                                        data-id="<?php echo e($category->id); ?>"><?php echo e($category->category_name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subcat_id"
                                                class="col-form-label"><?php echo e(trans('labels.subcategory')); ?></label>
                                            <select name="subcat_id" class="form-select" id="subcat_id">
                                                <option value="" selected><?php echo e(trans('labels.select')); ?></option>
                                                <?php $__currentLoopData = $getsubcategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcatdata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($subcatdata->id); ?>"
                                                        <?php echo e($getitem->subcat_id == $subcatdata->id ? 'selected' : ''); ?>>
                                                        <?php echo e($subcatdata->subcategory_name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="getitem_name" class="col-form-label"><?php echo e(trans('labels.name')); ?>

                                                <span class="text-danger">*</span> </label>
                                            <input type="text" class="form-control" id="getitem_name" name="item_name"
                                                placeholder="<?php echo e(trans('labels.name')); ?>" value="<?php echo e($getitem->item_name); ?>"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="video_url"
                                                class="col-form-label"><?php echo e(trans('labels.video_url')); ?></label>
                                            <input type="text" class="form-control" id="video_url" name="video_url"
                                                placeholder="<?php echo e(trans('labels.video_url')); ?>"
                                                value="<?php echo e($getitem->video_url); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="getaddons_id"
                                                class="col-form-label"><?php echo e(trans('labels.addons_group')); ?></label>
                                            <?php $selected = explode(',', $getitem->addons_id); ?>
                                            <select name="addongroup_id[]" class="form-control selectpicker" multiple
                                                data-live-search="true" id="getaddons_id">
                                                <?php $__currentLoopData = $getaddongroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addongroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        $availableAddons = collect($getaddon)->where(
                                                            'addongroup_id',
                                                            $addongroup->id,
                                                        );
                                                    ?>
                                                    <?php if($availableAddons->isNotEmpty()): ?>
                                                        <option value="<?php echo e($addongroup->id); ?>"
                                                            <?php echo e(in_array($addongroup->id, $selected) ? 'selected' : ''); ?>>
                                                            <?php echo e($addongroup->name); ?>

                                                        </option>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <input class="form-check-input me-0" type="radio" name="item_type"
                                           id="veg" value="1" checked hidden
                                           <?php if(old('item_type') == 1): ?> checked <?php endif; ?>>
















                                </div>

                                <!-- branch wise price -->

                                <div class="row">
                                    <div class="d-flex justify-content-between align-items-center col-12 mb-3">
                                        <label for="name" class="fw-bold col-form-label">Prices <span
                                                class="text-danger">*</span>
                                        </label>
                                        <button type="button" title="Add Price"
                                                class="btn btn--primary add_additional_crust_option">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                    <?php $__currentLoopData = $getitem['prices']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="row data-amenities align-items-center mb-3 col-12" data-index="edit_<?php echo e($index); ?>">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="size_edit_<?php echo e($index); ?>" class="col-form-label">
                                                        Size <span class="text-danger">*</span>
                                                    </label>
                                                    <select name="prices[edit_<?php echo e($index); ?>][branch_id]" class="form-control selectpicker" required data-live-search="true" id="size_edit_<?php echo e($index); ?>">
                                                        <?php $__currentLoopData = helper::get_branchs(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($branch->id); ?>" <?php echo e($branch->id === $option['branch_id'] ? 'selected' : ''); ?>>
                                                                <?php echo e($branch->name.'-'.$branch->city); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="price_edit_<?php echo e($index); ?>" class="col-form-label">
                                                        Price <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="number"    step="0.01"  name="prices[edit_<?php echo e($index); ?>][price]" class="form-control" value="<?php echo e($option['price']); ?>" placeholder="Price" required id="price_edit_<?php echo e($index); ?>">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-2 d-flex align-items-center">
                                                <button type="button" class="btn btn-outline-danger deleteCrustOption">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                    <!-- Placeholder for Adding New Crust Options -->
                                    <div class="col-12">
                                        <div id="additionalCrustOptions"></div>
                                    </div>
                                </div>

                                <!-- end branch wise price -->

                                <div class="row">
                                    <div class="col-md-12 d-flex flex-wrap justify-content-between align-items-center">
                                        <div class="form-group">
                                            <label class="col-form-label"><?php echo e(trans('labels.item_has_extras')); ?> <span
                                                    class="text-danger">*</span> </label>
                                            <div class="col-md-12">
                                                <div class="form-check-inline">
                                                    <input class="form-check-input me-0 has_extras" type="radio"
                                                        name="has_extras" id="extras_no" value="2" checked
                                                        <?php if($getitem->has_extras == 2): ?> checked <?php endif; ?>>
                                                    <label class="form-check-label"
                                                        for="extras_no"><?php echo e(trans('labels.no')); ?></label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <input class="form-check-input me-0 has_extras" type="radio"
                                                        name="has_extras" id="extras_yes" value="1"
                                                        <?php if($getitem->has_extras == 1): ?> checked <?php endif; ?>>
                                                    <label class="form-check-label"
                                                        for="extras_yes"><?php echo e(trans('labels.yes')); ?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="">
                                            <?php if(count($globalextras) > 0): ?>
                                                <button class="btn btn-primary align-items-end mb-sm-0 mb-2" type="button"
                                                    id="globalextra"
                                                    onclick="global_extras('<?php echo e(URL::to('admin/getextras')); ?>','<?php echo e(trans('labels.name')); ?>','<?php echo e(trans('labels.price')); ?>')">
                                                    <i class="fa-sharp fa-solid fa-plus"></i>
                                                    <?php echo e(trans('labels.add_global_extras')); ?></button>
                                            <?php endif; ?>
                                            <button class="btn btn-secondary px-3 mb-sm-0 mb-2" type="button" id="add_extra"
                                                onclick="more_editextras_fields('<?php echo e(trans('labels.name')); ?>','<?php echo e(trans('labels.price')); ?>')">
                                                <i class="fa-sharp fa-solid fa-plus"></i> </button>
                                        </div>
                                    </div>
                                    <div id="extras">
                                        <?php $__currentLoopData = $getitem['extras']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $extras): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="row mb-md-0 mb-2">
                                                <input type="hidden" class="form-control" name="extras_id[]"
                                                    value="<?php echo e($extras->id); ?>">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?php if($key == 0): ?>
                                                            <label class="col-form-label"><?php echo e(trans('labels.name')); ?>

                                                                <span class="text-danger"> * </span></label>
                                                        <?php endif; ?>
                                                        <input type="text" class="form-control extras_name"
                                                            name="extras_name[]" value="<?php echo e($extras->name); ?>"
                                                            placeholder="<?php echo e(trans('labels.name')); ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?php if($key == 0): ?>
                                                            <label class="col-form-label"><?php echo e(trans('labels.price')); ?>

                                                                <span class="text-danger"> * </span></label>
                                                        <?php endif; ?>
                                                        <div class="d-flex gap-2">
                                                            <input type="text"
                                                                class="form-control numbers_only extras_price"
                                                                name="extras_price[]" value="<?php echo e($extras->price); ?>"
                                                                placeholder="<?php echo e(trans('labels.price')); ?>" required>
                                                            <?php if(count($getitem['extras']) > 1): ?>
                                                                <button class="btn btn-danger px-3" type="button"
                                                                    <?php if(env('Environment') == 'sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="deleteItemExtras('<?php echo e($extras->id); ?>','<?php echo e($getitem->id); ?>','<?php echo e(URL::to('admin/item/deleteextras')); ?>')" <?php endif; ?>>
                                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                                </button>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="hiddenextrascount d-none"><?php echo e($key); ?></span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <div id="global-extras"></div>
                                        <div id="more_editextras_fields"></div>
                                    </div>
                                </div>

                                <hr>
                                <div class="row">
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label for="price"
                                                class="col-form-label"><?php echo e(trans('labels.product_price')); ?>

                                                <span class="text-danger">*</span> </label>
                                            <input type="text" class="form-control numbers_only" name="price"
                                                id="price" placeholder="<?php echo e(trans('labels.product_price')); ?>"
                                                value="<?php echo e($getitem->price); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label for="original_price"
                                                class="col-form-label"><?php echo e(trans('labels.original_price')); ?></label>
                                            <input type="text" class="form-control numbers_only" name="original_price"
                                                id="original_price" placeholder="<?php echo e(trans('labels.original_price')); ?>"
                                                value="<?php echo e($getitem->original_price); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="preparation_time"
                                                        class="col-form-label"><?php echo e(trans('labels.preparation_time')); ?>

                                                        <span class="text-danger">*</span> </label>
                                                    <input type="text" class="form-control" name="preparation_time"
                                                        id="preparation_time" value="<?php echo e($getitem->preparation_time); ?>"
                                                        placeholder="<?php echo e(trans('labels.preparation_time')); ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="tax"
                                                        class="col-form-label"><?php echo e(trans('labels.tax')); ?></label>
                                                    <?php $selected = explode(',', $getitem->tax); ?>
                                                    <select name="tax[]" class="form-control selectpicker" multiple
                                                        data-live-search="true" id="tax">
                                                        <?php $__currentLoopData = $gettax; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($tax->id); ?>"
                                                                <?php echo e(in_array($tax->id, $selected) ? 'selected' : ''); ?>>
                                                                <?php echo e($tax->name); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description"
                                                class="col-form-label"><?php echo e(trans('labels.description')); ?></label>
                                            <textarea class="form-control" rows="5" name="description" id="description"
                                                placeholder="<?php echo e(trans('labels.description')); ?>"><?php echo e($getitem->item_description); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="allergens"
                                                class="col-form-label"><?php echo e(trans('labels.allergens')); ?></label>
                                            <textarea class="form-control" rows="5" name="allergens" id="allergens"
                                                placeholder="<?php echo e(trans('labels.allergens')); ?>"><?php echo e($getitem->item_allergens); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group <?php echo e(session()->get('direction') == '2' ? 'text-start' : 'text-end'); ?>">
                                    <a href="<?php echo e(URL::to('admin/item')); ?>"
                                        class="btn btn-danger"><?php echo e(trans('labels.cancel')); ?></a>
                                    <button class="btn btn-primary"
                                        <?php if(env('Environment') == 'sendbox'): ?> type="button" onclick="myFunction()" <?php else: ?> type="submit" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <button type="button" class="btn btn-primary mb-3 <?php echo e(session()->get('direction') == '2' ? 'float-start' : 'float-end'); ?>" data-bs-toggle="modal"
                    data-bs-target="#AddProduct" data-whatever="@addProduct"><?php echo e(trans('labels.add_image')); ?></button>
            </div>
            <div class="col-12">
                <div class="row">
                    <?php $__currentLoopData = $getitemimages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $itemimage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-lg-2 col-md-4 col-sm-6 my-card dataid<?php echo e($itemimage->id); ?>" id="table-image">
                            <img class="img-fluid rounded edit-item-image"
                                src='<?php echo e(helper::image_path($itemimage->image)); ?>'>
                            <div class="actioncenter justify-content-center">
                                <a href="javascript:void(0)" class="btn btn-sm btn-info square mx-1"
                                    onclick="updateItemImage('<?php echo e($itemimage->id); ?>','<?php echo e(URL::to('admin/item/showimage')); ?>')"><i
                                        class="fa-solid fa-pen-to-square" aria-hidden="true"></i> </a>
                                <?php if(count($getitemimages) > 1): ?>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger square mx-1"
                                        <?php if(env('Environment') == 'sendbox'): ?> type="button" onclick="myFunction()" <?php else: ?> onclick="deleteItemImage('<?php echo e($itemimage->id); ?>','<?php echo e($itemimage->item_id); ?>','<?php echo e(URL::to('admin/item/destroyimage')); ?>')" <?php endif; ?>><i
                                            class="fa fa-trash" aria-hidden="true"></i> </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Images -->
    <div class="modal fade" id="EditImages" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabeledit"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post" name="editimg" class="editimg" id="editimg" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <input type="hidden" id="updateimageurl" value="<?php echo e(URL::to('admin/item/updateimage')); ?>">
                <input type="hidden" id="idd" name="id">
                <input type="hidden" class="form-control" id="old_img" name="old_img">
                <input type="hidden" name="removeimg" id="removeimg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabeledit"><?php echo e(trans('labels.images')); ?></h5>
                        <button type="button" class="btn-close <?php echo e(session()->get('direction') == 2 ? 'close' : ''); ?>"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <span id="emsg"></span>
                    <div class="modal-body">
                        <div class="form-group">
                            <label><?php echo e(trans('labels.images')); ?> <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="image" id="image" accept="image/*">
                        </div>
                        <div class="galleryim"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger"
                            data-bs-dismiss="modal"><?php echo e(trans('labels.close')); ?></button>
                        <button class="btn btn-primary"
                            <?php if(env('Environment') == 'sendbox'): ?> type="button" onclick="myFunction()" <?php else: ?> type="submit" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
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
                <input type="hidden" id="storeimagesurl" value="<?php echo e(URL::to('admin/item/storeimages')); ?>">
                <input type="hidden" name="itemid" id="itemid" value="<?php echo e(request()->route('id')); ?>">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><?php echo e(trans('labels.images')); ?></h5>
                        <button type="button" class="btn-close <?php echo e(session()->get('direction') == 2 ? 'close' : ''); ?>"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <span id="iiemsg"></span>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-form-label"><?php echo e(trans('labels.images')); ?>

                                <span class="text-danger">*</span></label>
                            <input type="file" multiple="true" class="form-control" name="file[]" id="file"
                                accept="image/*" required="">
                        </div>
                        <div class="gallery"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger"
                            data-bs-dismiss="modal"><?php echo e(trans('labels.close')); ?></button>
                        <button class="btn btn-primary"
                            <?php if(env('Environment') == 'sendbox'): ?> type="button" onclick="myFunction()" <?php else: ?> type="submit" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.12.1/ckeditor.js"></script>
    <script type="text/javascript">
        CKEDITOR.replace('allergens');
    </script>
    <script
        src="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/js/bootstrap/bootstrap-select.v1.14.0-beta2.min.js')); ?>">
    </script>
    <script src="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/additem.js')); ?>"></script>
    <script>
        $(document).ready(function () {
            let crustAdded = $('.data-amenities').length;

            $('.add_additional_crust_option').on('click', function () {
                if (crustAdded >= 10) {
                    return false;
                }
                crustAdded++;

                const uniqueIndex = `price_${crustAdded}`; // Unique identifier for each set

                $("#additionalCrustOptions").append(`
                <div class="row data-amenities mb-3" data-index="${uniqueIndex}">
                    <div class="form-group col-12 col-lg-6 col-md-5">
                        <label for="size_${uniqueIndex}" class="col-form-label">Size <span class="text-danger">*</span></label>
                        <select name="prices[${uniqueIndex}][branch_id]" class="form-control selectpicker" required data-live-search="true" id="size_${uniqueIndex}">
                        <?php $__currentLoopData = helper::get_branchs(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($branch->id); ?>">
                                            <?php echo e($branch->name.'-'.$branch->city); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group col-12 col-lg-5 col-md-5">
                        <label for="price_${uniqueIndex}" class="col-form-label">Price <span class="text-danger">*</span></label>
                        <input type="number" name="prices[${uniqueIndex}][price]" class="form-control" placeholder="Price" required id="price_${uniqueIndex}">
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

            $(document).on('click', '.deleteCrustOption', function () {
                $(this).closest('.data-amenities').remove();
                crustAdded--;
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.theme.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/item/edititem.blade.php ENDPATH**/ ?>