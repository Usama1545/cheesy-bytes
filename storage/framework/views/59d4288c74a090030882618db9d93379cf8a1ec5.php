
<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet"
          href="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/css/bootstrap/bootstrap-select.v1.14.0-beta2.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="row mt-3">
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <form action="<?php echo e(URL::to('/admin/pizza_crusts/update')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <input type="hidden" name="id" value="<?php echo e($id); ?>">
                            <div class="d-flex justify-content-between align-items-center col-12 mb-3">
                                <label for="name" class="fw-bold col-form-label">Pizza Size and Crust<span
                                        class="text-danger">*</span></label>
                                <button type="button" title="Add Topping"
                                        class="btn btn--primary add_additional_crust_option">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                            <?php $__currentLoopData = $groupedData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="row data-amenities align-items-center mb-3" data-index="edit_<?php echo e($index); ?>">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="size_edit_<?php echo e($index); ?>" class="col-form-label">
                                                Size <span class="text-danger">*</span>
                                            </label>
                                            <select name="size_crusts[edit_<?php echo e($index); ?>][size]" class="form-control selectpicker" required data-live-search="true" id="size_edit_<?php echo e($index); ?>">
                                                <?php $__currentLoopData = helper::get_sizes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($branch->id); ?>" <?php echo e($branch->id === $option['size_id'] ? 'selected' : ''); ?>>
                                                        <?php echo e($branch->name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="crust_edit_<?php echo e($index); ?>" class="col-form-label">
                                                Crust <span class="text-danger">*</span>
                                            </label>
                                            <select name="size_crusts[edit_<?php echo e($index); ?>][crusts][]" class="form-control selectpicker" multiple required data-live-search="true" id="crust_edit_<?php echo e($index); ?>">
                                                <?php $__currentLoopData = helper::get_crusts(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crust): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($crust->id); ?>" <?php echo e(in_array($crust->id, $option['crust_ids']) ? 'selected' : ''); ?>>
                                                        <?php echo e($crust->name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="price_edit_<?php echo e($index); ?>" class="col-form-label">
                                                Price <span class="text-danger">*</span>
                                            </label>
                                            <input type="number"    step="0.01"  name="size_crusts[edit_<?php echo e($index); ?>][price]" class="form-control" value="<?php echo e($option['price']); ?>" placeholder="Price" required id="price_edit_<?php echo e($index); ?>">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-1 d-flex align-items-center">
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
                            <div
                                class="form-group <?php echo e(session()->get('direction') == '2' ? 'text-start' : 'text-end'); ?>">
                                <a href="<?php echo e(URL::to('admin/sizes')); ?>"
                                   class="btn btn-danger"><?php echo e(trans('labels.cancel')); ?></a>
                                <button class="btn btn-primary "
                                        <?php if(env('Environment') == 'sendbox'): ?> type="button" onclick="myFunction()"
                                        <?php else: ?> type="submit" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                            </div>
                        </div>
                    </form>
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

                const uniqueIndex = `crustOption_${crustAdded}`; // Unique identifier for each set

                $("#additionalCrustOptions").append(`
                <div class="row data-amenities mb-3" data-index="${uniqueIndex}">
                    <div class="form-group col-12 col-lg-4 col-md-4">
                        <label for="size_${uniqueIndex}" class="col-form-label">Size <span class="text-danger">*</span></label>
                        <select name="size_crusts[${uniqueIndex}][size]" class="form-control selectpicker" required data-live-search="true" id="size_${uniqueIndex}">
                        <?php $__currentLoopData = helper::get_sizes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($branch->id); ?>">
                                <?php echo e($branch->name); ?>

                </option>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="form-group col-12 col-lg-4 col-md-4">
                <label for="crust_${uniqueIndex}" class="col-form-label">Crust <span class="text-danger">*</span></label>
                        <select name="size_crusts[${uniqueIndex}][crusts][]" class="form-control selectpicker" multiple required data-live-search="true" id="crust_${uniqueIndex}">
                        <?php $__currentLoopData = helper::get_crusts(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($branch->id); ?>">
                                <?php echo e($branch->name); ?>

                </option>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="form-group col-12 col-lg-3 col-md-3">
                <label for="price_${uniqueIndex}" class="col-form-label">Price <span class="text-danger">*</span></label>
                        <input type="number" name="size_crusts[${uniqueIndex}][price]" class="form-control" placeholder="Price" required id="price_${uniqueIndex}">
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

<?php echo $__env->make('admin.theme.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/pizza-pricing/edit.blade.php ENDPATH**/ ?>