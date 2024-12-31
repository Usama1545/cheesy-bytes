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
                            <form method="post" action="<?php echo e(URL::to('admin/deals/update')); ?>" name="about" id="about"
                                  enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" class="form-control" id="id" name="id"
                                       value="<?php echo e($getitem->id); ?>">
                                <div class="row">

                                    <div class="form-group col-md-6">
                                        <label class="form-label">Deal Product</label>
                                        <div class="dropdown bootstrap-select show-tick form-control w-100">
                                            <select class="form-control selectpicker w-100" name="product_id"
                                                    data-live-search="true">
                                                <?php $__currentLoopData = helper::getItems(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($item->id); ?>" <?php echo e($item->id === $getitem->product_id ? 'selected' : ''); ?>>
                                                        <?php echo e($item->item_name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>

                                            <div class="dropdown-menu ">
                                                <div class="bs-searchbox"><input type="search" class="form-control"
                                                                                 autocomplete="off" role="combobox"
                                                                                 aria-label="Search"
                                                                                 aria-controls="bs-select-1"
                                                                                 aria-autocomplete="list"></div>
                                                <div class="inner show" role="listbox" id="bs-select-1" tabindex="-1"
                                                     aria-multiselectable="true">
                                                    <ul class="dropdown-menu inner show" role="presentation"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label class="form-label">Listed Products</label>
                                        <?php $selected = explode(',', $getitem->product_ids); ?>
                                        <div class="dropdown bootstrap-select show-tick form-control w-100">
                                            <select class="form-control selectpicker  w-100" multiple name="product_ids[]"
                                                    data-live-search="true">
                                                <?php $__currentLoopData = helper::getItems(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($item->id); ?>"
                                                        <?php echo e(in_array($item->id, $selected) ? 'selected' : ''); ?>>
                                                        <?php echo e($item->item_name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>

                                            <div class="dropdown-menu ">
                                                <div class="bs-searchbox"><input type="search" class="form-control"
                                                                                 autocomplete="off" role="combobox"
                                                                                 aria-label="Search"
                                                                                 aria-controls="bs-select-1"
                                                                                 aria-autocomplete="list"></div>
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
                                        <input type="date" class="form-control" value="<?php echo e($getitem->start_date); ?>" id="start_date" name="start_date"
                                               required="">
                                    </div>
                                    <div class="col-sm-6 form-group" id="end_date">
                                        <label class="form-label">End date
                                            <span class="text-danger"> *</span></label>
                                        <input type="date" class="form-control" id="end_date" value="<?php echo e($getitem->end_date); ?>" name="end_date"
                                               required="">
                                    </div>


                                    <div class="col-sm-6 form-group" id="start_time">
                                        <label class="form-label">Start Time
                                            <span class="text-danger"> *</span></label>
                                        <input type="time" class="form-control" value="<?php echo e($getitem->start_time); ?>" name="start_time" id="start_time"
                                               required="">
                                    </div>

                                    <div class="col-sm-6 form-group" id="end_time">
                                        <label class="form-label">End Time
                                            <span class="text-danger"> *</span></label>
                                        <input type="time" class="form-control" value="<?php echo e($getitem->end_time); ?>" name="end_time" id="end_time"
                                               required="">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label class="form-label">Size
                                            <span class="text-danger"> *</span></label>
                                        <select class="form-control selectpicker w-100" name="size_id"
                                                data-live-search="true">
                                            <?php $__currentLoopData = helper::get_sizes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($item->id); ?>" <?php echo e($item->id === $getitem->size_id ? 'selected' : ''); ?>>
                                                    <?php echo e($item->name.'('.$item->label.')'); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-6 form-group" id="end_time">
                                        <label class="form-label">Min Count
                                            <span class="text-danger"> *</span></label>
                                        <input type="number" class="form-control" value="<?php echo e($getitem->min_count); ?>" name="min_count"
                                               required="">
                                    </div>

                                    <div class="form-group <?php echo e(session()->get('direction') == '2' ? 'text-start' : 'text-end'); ?>">
                                        <a href="<?php echo e(URL::to('admin/deals')); ?>" class="btn btn-danger"><?php echo e(trans('labels.cancel')); ?></a>
                                        <button class="btn btn-primary"
                                            <?php if(env('Environment') == 'sendbox'): ?> type="button" onclick="myFunction()"
                                            <?php else: ?> type="submit" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                                    </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.12.1/ckeditor.js"></script>
    <script type="text/javascript">
        CKEDITOR.replace('allergens');
    </script>
    <script
        src="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/js/bootstrap/bootstrap-select.v1.14.0-beta2.min.js')); ?>">
    </script>
    <script src="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/additem.js')); ?>"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.theme.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/deals/edititem.blade.php ENDPATH**/ ?>