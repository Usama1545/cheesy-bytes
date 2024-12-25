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
                            <form method="post" action="<?php echo e(URL::to('admin/custom_pizza/update')); ?>" name="about" id="about"
                                  enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" class="form-control" id="id" name="id"
                                       value="<?php echo e($getitem->id); ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cat_id" class="col-form-label">Size
                                                <span class="text-danger">*</span> </label>
                                            <input name="name" type="number" required class="form-control"
                                                   value="<?php echo e($getitem->name); ?>" placeholder="size">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subcat_id"
                                                   class="col-form-label"><?php echo e(trans('labels.price')); ?><span
                                                    class="text-danger">*</span></label>
                                            <input name="price" type="number" class="form-control" required
                                                   value="<?php echo e($getitem->price); ?>" placeholder="price">


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
                                    <?php $__currentLoopData = $getitem->crusts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="row data-amenities align-items-center mb-3">
                                            <div class="form-group col-12 col-lg-5 col-md-5">
                                                <label for="name" class="col-form-label">Name <span class="text-danger">*</span></label>
                                                <input type="text" name="crust_name[]" class="form-control" placeholder="Name"
                                                       required value="<?php echo e($option->name); ?>">
                                            </div>
                                            <div class="form-group col-12 col-lg-5 col-md-5">
                                                <label for="price" class="col-form-label">Price <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" name="crust_price[]" class="form-control"
                                                       placeholder="Price" required value="<?php echo e($option->price); ?>">
                                            </div>
                                            <div class="col-12 col-lg-2 d-flex align-items-center">
                                                <button type="button" class="btn btn-outline-danger deleteCrustOption">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                            <div class="form-group col-12 col-lg-12 col-md-12">
                                                <label for="description" class="col-form-label">Description <span
                                                        class="text-danger">*</span></label>
                                                <textarea name="crust_description[]" class="form-control"
                                                          placeholder="Description"
                                                          required><?php echo e($option->description); ?></textarea>
                                            </div>

                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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
                                    <?php $__currentLoopData = $getitem->toppings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="row data-toppings align-items-center mb-3">
                                            <div class="form-group col-12 col-lg-5 col-md-5">
                                                <label for="name" class="col-form-label">Name <span class="text-danger">*</span></label>
                                                <input type="text" name="topping_name[]" class="form-control" placeholder="Name"
                                                       required value="<?php echo e($option->name); ?>">
                                            </div>
                                            <div class="form-group col-12 col-lg-5 col-md-5">
                                                <label for="price" class="col-form-label">Price <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" name="topping_price[]" class="form-control"
                                                       placeholder="Price" required value="<?php echo e($option->price); ?>">
                                            </div>
                                            <div class="col-12 col-lg-2 d-flex align-items-center">
                                                <button type="button" title="Add Topping"
                                                        class="btn btn-outline-danger deleteToppingOption">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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
                                    <?php $__currentLoopData = $getitem->sauces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="row data-sauces align-items-center mb-3">
                                            <div class="form-group col-12 col-lg-5 col-md-5">
                                                <label for="name" class="col-form-label">Name <span class="text-danger">*</span></label>
                                                <input type="text" name="sauce_name[]" class="form-control" placeholder="Name"
                                                       required value="<?php echo e($option->name); ?>">
                                            </div>
                                            <div class="form-group col-12 col-lg-5 col-md-5">
                                                <label for="price" class="col-form-label">Price <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" name="sauce_price[]" class="form-control"
                                                       placeholder="Price" required value="<?php echo e($option->price); ?>">
                                            </div>
                                            <div class="col-12 col-lg-2 d-flex align-items-center">
                                                <button type="button" class="btn btn-outline-danger deleteSauceOption">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <!-- Placeholder for Adding New Crust Options -->
                                    <div class="col-12">
                                        <div id="additionalSauceOptions"></div>
                                    </div>

                                    <!-- Button to Add New Crust Option -->

                                </div>


                                <div
                                    class="form-group <?php echo e(session()->get('direction') == '2' ? 'text-start' : 'text-end'); ?>">
                                    <a href="<?php echo e(URL::to('admin/item')); ?>"
                                       class="btn btn-danger"><?php echo e(trans('labels.cancel')); ?></a>
                                    <button class="btn btn-primary"
                                            <?php if(env('Environment') == 'sendbox'): ?> type="button" onclick="myFunction()"
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

                $("#additionalCrustOptions").append(`
            <div class="row data-amenities mb-3">
                <div class="form-group col-12 col-lg-5 col-md-5">
                    <label for="name" class="col-form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" name="crust_name[]" class="form-control" placeholder="Name" required>
                </div><div class="form-group col-12 col-lg-5 col-md-5">
                    <label for="price" class="col-form-label">Price <span class="text-danger">*</span></label>
                    <input type="number" name="crust_price[]" class="form-control" placeholder="Price" required>
                </div>


                <div class="col-12 col-lg-2 d-flex align-items-center">
                    <button type="button" class="btn btn-outline-danger deleteCrustOption">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
<div class="form-group col-12 col-lg-12 col-md-12">
                    <label for="description" class="col-form-label">Description <span class="text-danger">*</span></label>
                    <textarea name="crust_description[]" class="form-control" placeholder="Description" required></textarea>
                </div>
            </div>
        `);
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
                <div class="form-group col-12 col-lg-5 col-md-5">
                    <label for="name" class="col-form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" name="topping_name[]" class="form-control" placeholder="Name" required>
                </div><div class="form-group col-12 col-lg-5 col-md-5">
                    <label for="price" class="col-form-label">Price <span class="text-danger">*</span></label>
                    <input type="number" name="topping_price[]" class="form-control" placeholder="Price" required>
                </div>


                <div class="col-12 col-lg-2 d-flex align-items-center">
                    <button type="button" class="btn btn-outline-danger deleteToppingOption">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
        `);
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
                <div class="form-group col-12 col-lg-5 col-md-5">
                    <label for="name" class="col-form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" name="sauce_name[]" class="form-control" placeholder="Name" required>
                </div><div class="form-group col-12 col-lg-5 col-md-5">
                    <label for="price" class="col-form-label">Price <span class="text-danger">*</span></label>
                    <input type="number" name="sauce_price[]" class="form-control" placeholder="Price" required>
                </div>


                <div class="col-12 col-lg-2 d-flex align-items-center">
                    <button type="button" class="btn btn-outline-danger deleteSauceOption">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
        `);
            });

            $(document).on('click', '.deleteSauceOption', function () {
                $(this).closest('.data-sauces').remove();
            });
        });

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.theme.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/custom_pizza/edititem.blade.php ENDPATH**/ ?>