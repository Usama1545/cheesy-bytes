<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet"
          href="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/css/bootstrap/bootstrap-select.v1.14.0-beta2.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div id="privacy-policy-three" class="privacy-policy">
                            <form method="post" action="<?php echo e(URL::to('admin/item/store')); ?>" name="about" id="about"
                                  enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cat_id" class="col-form-label"><?php echo e(trans('labels.category')); ?>

                                                <span class="text-danger">*</span> </label>
                                            <select name="cat_id" class="form-select" id="cat_id" required
                                                    data-url="<?php echo e(URL::to('admin/item/subcategories')); ?>">
                                                <option value="" selected><?php echo e(trans('labels.select')); ?>

                                                </option>
                                                <?php $__currentLoopData = $getcategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($category->id); ?>"
                                                            <?php echo e(old('cat_id') == $category->id ? 'selected' : ''); ?>

                                                            data-id="<?php echo e($category->id); ?>"><?php echo e($category->category_name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <span class="emsg text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subcat_id"
                                                   class="col-form-label"><?php echo e(trans('labels.subcategory')); ?></label>
                                            <select name="subcat_id" class="form-select" id="subcat_id">
                                                <option value="" selected><?php echo e(trans('labels.select')); ?>

                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label"><?php echo e(trans('labels.name')); ?>

                                                <span class="text-danger">*</span> </label>
                                            <input type="text" class="form-control" name="item_name"
                                                   value="<?php echo e(old('item_name')); ?>"
                                                   placeholder="<?php echo e(trans('labels.name')); ?>"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label"><?php echo e(trans('labels.addons_group')); ?></label>
                                            <select class="form-control selectpicker" name="addongroup_id[]" multiple
                                                    data-live-search="true">
                                                <?php $__currentLoopData = $getaddongroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $addongroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        $availableAddons = collect($getaddon)->where(
                                                            'addongroup_id',
                                                            $addongroup->id,
                                                        );
                                                    ?>
                                                    <?php if($availableAddons->isNotEmpty()): ?>
                                                        <option value="<?php echo e($addongroup->id); ?>"
                                                            <?php echo e(!empty(old('addongroup_id')) && in_array($addongroup->id, old('addongroup_id')) ? 'selected' : ''); ?>>
                                                            <?php echo e($addongroup->name); ?>

                                                        </option>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-form-label"><?php echo e(trans('labels.video_url')); ?></label>
                                            <input type="text" class="form-control" name="video_url"
                                                   value="<?php echo e(old('video_url')); ?>"
                                                   placeholder="<?php echo e(trans('labels.video_url')); ?>">
                                        </div>
                                    </div>
                                </div>


                                <input class="form-check-input me-0" type="radio" name="item_type"
                                       id="veg" value="1" checked hidden
                                       <?php if(old('item_type') == 1): ?> checked <?php endif; ?>>
                                <div class="row">
                                    <div class="col-md-12 d-flex flex-wrap justify-content-between align-items-center">
                                        <div class="form-group">
                                            <label class="col-form-label"><?php echo e(trans('labels.item_has_extras')); ?></label>
                                            <div class="col-md-12">
                                                <div class="form-check-inline">
                                                    <input class="form-check-input me-0 has_extras" type="radio"
                                                           name="has_extras" id="extras_no" value="2" checked
                                                           <?php if(old('has_extras') == 2): ?> checked <?php endif; ?>>
                                                    <label class="form-check-label"
                                                           for="extras_no"><?php echo e(trans('labels.no')); ?></label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <input class="form-check-input me-0 has_extras" type="radio"
                                                           name="has_extras" id="extras_yes" value="1"
                                                           <?php if(old('has_extras') == 1): ?> checked <?php endif; ?>>
                                                    <label class="form-check-label"
                                                           for="extras_yes"><?php echo e(trans('labels.yes')); ?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="">
                                            <?php if(count($globalextras) > 0): ?>
                                                <button class="btn btn-primary align-items-end  mb-sm-0 mb-2"
                                                        type="button"
                                                        id="globalextra"
                                                        onclick="global_extras('<?php echo e(URL::to('admin/getextras')); ?>','<?php echo e(trans('labels.name')); ?>','<?php echo e(trans('labels.price')); ?>')">
                                                    <i class="fa-sharp fa-solid fa-plus"></i>
                                                    <?php echo e(trans('labels.add_global_extras')); ?></button>
                                            <?php endif; ?>
                                            <button class="btn btn-secondary px-3 mb-sm-0 mb-2" type="button"
                                                    id="add_extra"
                                                    onclick="extras_fields('<?php echo e(trans('labels.name')); ?>','<?php echo e(trans('labels.price')); ?>')">
                                                <i class="fa-sharp fa-solid fa-plus"></i></button>
                                        </div>
                                    </div>
                                    <div id="extras">
                                        <?php if(!empty($globalextras) && $globalextras->count() > 0): ?>
                                            <div id="global-extras"></div>
                                        <?php endif; ?>
                                        <div id="more_extras_fields" class="row"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label for="price"
                                                   class="col-form-label"><?php echo e(trans('labels.product_price')); ?> <span
                                                    class="text-danger">*</span> </label>
                                            <input type="text" class="form-control numbers_only" name="price"
                                                   id="price" value="<?php echo e(old('price')); ?>"
                                                   placeholder="<?php echo e(trans('labels.product_price')); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label for="original_price"
                                                   class="col-form-label"><?php echo e(trans('labels.original_price')); ?></label>
                                            <input type="text" class="form-control numbers_only" name="original_price"
                                                   id="original_price" value="0"
                                                   placeholder="<?php echo e(trans('labels.original_price')); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-form-label"><?php echo e(trans('labels.image')); ?>

                                                <span class="text-danger">*</span> </label>
                                            <input type="file" class="form-control" name="image[]" id="image"
                                                   accept="image/*" multiple required>
                                        </div>
                                        <div class="gallery"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-form-label"><?php echo e(trans('labels.preparation_time')); ?>

                                                <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="preparation_time"
                                                   placeholder="<?php echo e(trans('labels.preparation_time')); ?>"
                                                   value="<?php echo e(old('preparation_time')); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tax"
                                                   class="col-form-label"><?php echo e(trans('labels.tax')); ?></label>
                                            <select class="form-control selectpicker" name="tax[]" multiple
                                                    data-live-search="true">
                                                <?php $__currentLoopData = $gettax; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($tax->id); ?>"
                                                        <?php echo e(!empty(old('tax')) && in_array($tax->id, old('tax')) ? 'selected' : ''); ?>>
                                                        <?php echo e($tax->name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description"
                                                   class="col-form-label"><?php echo e(trans('labels.description')); ?></label>
                                            <textarea class="form-control" rows="5" name="description" id="description"
                                                      placeholder="<?php echo e(trans('labels.description')); ?>"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="allergens"
                                                   class="col-form-label"><?php echo e(trans('labels.allergens')); ?></label>
                                            <textarea class="form-control" rows="5" name="allergens" id="allergens"
                                                      placeholder="<?php echo e(trans('labels.allergens')); ?>"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="form-group <?php echo e(session()->get('direction') == '2' ? 'text-start' : 'text-end'); ?>">
                                    <a href="<?php echo e(URL::to('admin/item')); ?>"
                                       class="btn btn-danger"><?php echo e(trans('labels.cancel')); ?></a>
                                    <button class="btn btn-primary"
                                            <?php if(env('Environment') == 'sendbox'): ?> type="button"
                                            onclick="myFunction()"
                                            <?php else: ?> type="submit" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script>
        var placehodername = "<?php echo e(trans('labels.name')); ?>";
        var placeholderprice = "<?php echo e(trans('labels.price')); ?>";
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.12.1/ckeditor.js"></script>
    <script type="text/javascript">
        CKEDITOR.replace('allergens');
    </script>
    <script
        src="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/js/bootstrap/bootstrap-select.v1.14.0-beta2.min.js')); ?>">
    </script>
    <script src="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/additem.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.theme.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/item/additem.blade.php ENDPATH**/ ?>