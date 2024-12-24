<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="form-validation roles-form">
                            <form action="<?php echo e(URL::to('admin/roles/store')); ?>" method="post">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-form-label" for=""><?php echo e(trans('labels.role_name')); ?>

                                                <span class="text-danger">*</span> </label>
                                            <input type="text" class="form-control" name="name"
                                                placeholder="<?php echo e(trans('labels.role_name')); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-form-label"
                                                for=""><?php echo e(trans('labels.system_modules')); ?>

                                                <span class="text-danger">*</span> </label>
                                            <div class="row mb-0">
                                                <div class="col-lg-3 col-md-6 py-2">
                                                    <label class="cursor-pointer" for="checkbox0">
                                                        <input type="checkbox" class="me-2" id="checkbox0"
                                                            name="modules[]" value="0"
                                                            <?php echo e(!empty(old('modules')) && in_array(0, old('modules')) ? 'checked' : ''); ?>>
                                                        <?php echo e(trans('labels.dashboard')); ?>

                                                        <input type="hidden" name="title[]"
                                                            value="<?php echo e(trans('labels.dashboard')); ?>">
                                                    </label>
                                                </div>
                                                <div class="col-lg-3 col-md-6 py-2">
                                                    <label class="cursor-pointer" for="checkbox1">
                                                        <input type="checkbox" class="me-2" id="checkbox1"
                                                            name="modules[]" value="1"
                                                            <?php echo e(!empty(old('modules')) && in_array(1, old('modules')) ? 'checked' : ''); ?>>
                                                        <?php echo e(trans('labels.orders')); ?>

                                                        <input type="hidden" name="title[]"
                                                            value="<?php echo e(trans('labels.orders')); ?>">
                                                    </label>
                                                </div>
                                                <div class="col-lg-3 col-md-6 py-2">
                                                    <label class="cursor-pointer" for="checkbox2">
                                                        <input type="checkbox" class="me-2" id="checkbox2"
                                                            name="modules[]" value="2"
                                                            <?php echo e(!empty(old('modules')) && in_array(2, old('modules')) ? 'checked' : ''); ?>>
                                                        <?php echo e(trans('labels.report')); ?>

                                                        <input type="hidden" name="title[]"
                                                            value="<?php echo e(trans('labels.report')); ?>">
                                                    </label>
                                                </div>
                                                <div class="col-lg-3 col-md-6 py-2">
                                                    <label class="cursor-pointer" for="checkbox3">
                                                        <input type="checkbox" class="me-2" id="checkbox3"
                                                            name="modules[]" value="3"
                                                            <?php echo e(!empty(old('modules')) && in_array(3, old('modules')) ? 'checked' : ''); ?>>
                                                        <?php echo e(trans('labels.sliders')); ?>

                                                        <input type="hidden" name="title[]"
                                                            value="<?php echo e(trans('labels.sliders')); ?>">
                                                    </label>
                                                </div>
                                                <div class="col-lg-3 col-md-6 py-2">
                                                    <label class="cursor-pointer" for="checkbox4">
                                                        <input type="checkbox" class="me-2" id="checkbox4"
                                                            name="modules[]" value="4"
                                                            <?php echo e(!empty(old('modules')) && in_array(4, old('modules')) ? 'checked' : ''); ?>>
                                                        <?php echo e(trans('labels.banners')); ?>

                                                        <input type="hidden" name="title[]"
                                                            value="<?php echo e(trans('labels.banners')); ?>">
                                                    </label>
                                                </div>
                                                <div class="col-lg-3 col-md-6 py-2">
                                                    <label class="cursor-pointer" for="checkbox5">
                                                        <input type="checkbox" class="me-2" id="checkbox5"
                                                            name="modules[]" value="5"
                                                            <?php echo e(!empty(old('modules')) && in_array(5, old('modules')) ? 'checked' : ''); ?>>
                                                        <?php echo e(trans('labels.promocodes')); ?>

                                                        <input type="hidden" name="title[]"
                                                            value="<?php echo e(trans('labels.promocodes')); ?>">
                                                    </label>
                                                </div>
                                                <div class="col-lg-3 col-md-6 py-2">
                                                    <label class="cursor-pointer" for="checkbox6">
                                                        <input type="checkbox" class="me-2" id="checkbox6"
                                                            name="modules[]" value="6"
                                                            <?php echo e(!empty(old('modules')) && in_array(6, old('modules')) ? 'checked' : ''); ?>>
                                                        <?php echo e(trans('labels.notification')); ?>

                                                        <input type="hidden" name="title[]"
                                                            value="<?php echo e(trans('labels.notification')); ?>">
                                                    </label>
                                                </div>
                                                <div class="col-lg-3 col-md-6 py-2">
                                                    <label class="cursor-pointer" for="checkbox7">
                                                        <input type="checkbox" class="me-2" id="checkbox7"
                                                            name="modules[]" value="7"
                                                            <?php echo e(!empty(old('modules')) && in_array(7, old('modules')) ? 'checked' : ''); ?>>
                                                        <?php echo e(trans('labels.categories')); ?>

                                                        <input type="hidden" name="title[]"
                                                            value="<?php echo e(trans('labels.categories')); ?>">
                                                    </label>
                                                </div>
                                                <div class="col-lg-3 col-md-6 py-2">
                                                    <label class="cursor-pointer" for="checkbox8">
                                                        <input type="checkbox" class="me-2" id="checkbox8"
                                                            name="modules[]" value="8"
                                                            <?php echo e(!empty(old('modules')) && in_array(8, old('modules')) ? 'checked' : ''); ?>>
                                                        <?php echo e(trans('labels.subcategories')); ?>

                                                        <input type="hidden" name="title[]"
                                                            value="<?php echo e(trans('labels.subcategories')); ?>">
                                                    </label>
                                                </div>
                                                <div class="col-lg-3 col-md-6 py-2">
                                                    <label class="cursor-pointer" for="checkbox9">
                                                        <input type="checkbox" class="me-2" id="checkbox9"
                                                            name="modules[]" value="9"
                                                            <?php echo e(!empty(old('modules')) && in_array(9, old('modules')) ? 'checked' : ''); ?>>
                                                        <?php echo e(trans('labels.addons_group')); ?>

                                                        <input type="hidden" name="title[]"
                                                            value="<?php echo e(trans('labels.addons_group')); ?>">
                                                    </label>
                                                </div>
                                                <div class="col-lg-3 col-md-6 py-2">
                                                    <label class="cursor-pointer" for="checkbox10">
                                                        <input type="checkbox" class="me-2" id="checkbox10"
                                                            name="modules[]" value="10"
                                                            <?php echo e(!empty(old('modules')) && in_array(10, old('modules')) ? 'checked' : ''); ?>>
                                                        <?php echo e(trans('labels.items')); ?>

                                                        <input type="hidden" name="title[]"
                                                            value="<?php echo e(trans('labels.items')); ?>">
                                                    </label>
                                                </div>
                                                <div class="col-lg-3 col-md-6 py-2">
                                                    <label class="cursor-pointer" for="checkbox11">
                                                        <input type="checkbox" class="me-2" id="checkbox11"
                                                            name="modules[]" value="11"
                                                            <?php echo e(!empty(old('modules')) && in_array(11, old('modules')) ? 'checked' : ''); ?>>
                                                        <?php echo e(trans('labels.shippingarea')); ?>

                                                        <input type="hidden" name="title[]"
                                                            value="<?php echo e(trans('labels.shippingarea')); ?>">
                                                    </label>
                                                </div>
                                                <div class="col-lg-3 col-md-6 py-2">
                                                    <label class="cursor-pointer" for="checkbox12">
                                                        <input type="checkbox" class="me-2" id="checkbox12"
                                                            name="modules[]" value="12"
                                                            <?php echo e(!empty(old('modules')) && in_array(12, old('modules')) ? 'checked' : ''); ?>>
                                                        <?php echo e(trans('labels.working_hours')); ?>

                                                        <input type="hidden" name="title[]"
                                                            value="<?php echo e(trans('labels.working_hours')); ?>">
                                                    </label>
                                                </div>
                                                <div class="col-lg-3 col-md-6 py-2">
                                                    <label class="cursor-pointer" for="checkbox13">
                                                        <input type="checkbox" class="me-2" id="checkbox13"
                                                            name="modules[]" value="13"
                                                            <?php echo e(!empty(old('modules')) && in_array(13, old('modules')) ? 'checked' : ''); ?>>
                                                        <?php echo e(trans('labels.payment_methods')); ?>

                                                        <input type="hidden" name="title[]"
                                                            value="<?php echo e(trans('labels.payment_methods')); ?>">
                                                    </label>
                                                </div>
                                                <div class="col-lg-3 col-md-6 py-2">
                                                    <label class="cursor-pointer" for="checkbox14">
                                                        <input type="checkbox" class="me-2" id="checkbox14"
                                                            name="modules[]" value="14"
                                                            <?php echo e(!empty(old('modules')) && in_array(14, old('modules')) ? 'checked' : ''); ?>>
                                                        <?php echo e(trans('labels.store_reviews')); ?>

                                                        <input type="hidden" name="title[]"
                                                            value="<?php echo e(trans('labels.store_reviews')); ?>">
                                                    </label>
                                                </div>
                                                <div class="col-lg-3 col-md-6 py-2">
                                                    <label class="cursor-pointer" for="checkbox15">
                                                        <input type="checkbox" class="me-2" id="checkbox15"
                                                            name="modules[]" value="15"
                                                            <?php echo e(!empty(old('modules')) && in_array(15, old('modules')) ? 'checked' : ''); ?>>
                                                        <?php echo e(trans('labels.bookings')); ?>

                                                        <input type="hidden" name="title[]"
                                                            value="<?php echo e(trans('labels.bookings')); ?>">
                                                    </label>
                                                </div>
                                                <div class="col-lg-3 col-md-6 py-2">
                                                    <label class="cursor-pointer" for="checkbox16">
                                                        <input type="checkbox" class="me-2" id="checkbox16"
                                                            name="modules[]" value="16"
                                                            <?php echo e(!empty(old('modules')) && in_array(16, old('modules')) ? 'checked' : ''); ?>>
                                                        <?php echo e(trans('labels.inquiries')); ?>

                                                        <input type="hidden" name="title[]"
                                                            value="<?php echo e(trans('labels.inquiries')); ?>">
                                                    </label>
                                                </div>
                                                <div class="col-lg-3 col-md-6 py-2">
                                                    <label class="cursor-pointer" for="checkbox17">
                                                        <input type="checkbox" class="me-2" id="checkbox17"
                                                            name="modules[]" value="17"
                                                            <?php echo e(!empty(old('modules')) && in_array(17, old('modules')) ? 'checked' : ''); ?>>
                                                        <?php echo e(trans('labels.customers')); ?>

                                                        <input type="hidden" name="title[]"
                                                            value="<?php echo e(trans('labels.customers')); ?>">
                                                    </label>
                                                </div>
                                                <div class="col-lg-3 col-md-6 py-2">
                                                    <label class="cursor-pointer" for="checkbox18">
                                                        <input type="checkbox" class="me-2" id="checkbox18"
                                                            name="modules[]" value="18"
                                                            <?php echo e(!empty(old('modules')) && in_array(18, old('modules')) ? 'checked' : ''); ?>>
                                                        <?php echo e(trans('labels.drivers')); ?>

                                                        <input type="hidden" name="title[]"
                                                            value="<?php echo e(trans('labels.drivers')); ?>">
                                                    </label>
                                                </div>
                                                <div class="col-lg-3 col-md-6 py-2">
                                                    <label class="cursor-pointer" for="checkbox19">
                                                        <input type="checkbox" class="me-2" id="checkbox19"
                                                            name="modules[]" value="19"
                                                            <?php echo e(!empty(old('modules')) && in_array(19, old('modules')) ? 'checked' : ''); ?>>
                                                        <?php echo e(trans('labels.employee_role')); ?>

                                                        <input type="hidden" name="title[]"
                                                            value="<?php echo e(trans('labels.employee_role')); ?>">
                                                    </label>
                                                </div>
                                                <div class="col-lg-3 col-md-6 py-2">
                                                    <label class="cursor-pointer" for="checkbox20">
                                                        <input type="checkbox" class="me-2" id="checkbox20"
                                                            name="modules[]" value="20"
                                                            <?php echo e(!empty(old('modules')) && in_array(20, old('modules')) ? 'checked' : ''); ?>>
                                                        <?php echo e(trans('labels.employee')); ?>

                                                        <input type="hidden" name="title[]"
                                                            value="<?php echo e(trans('labels.employee')); ?>">
                                                    </label>
                                                </div>
                                                <div class="col-lg-3 col-md-6 py-2">
                                                    <label class="cursor-pointer" for="checkbox21">
                                                        <input type="checkbox" class="me-2" id="checkbox21"
                                                            name="modules[]" value="21"
                                                            <?php echo e(!empty(old('modules')) && in_array(21, old('modules')) ? 'checked' : ''); ?>>
                                                        <?php echo e(trans('labels.pages')); ?>

                                                        <input type="hidden" name="title[]"
                                                            value="<?php echo e(trans('labels.pages')); ?>">
                                                    </label>
                                                </div>
                                                <div class="col-lg-3 col-md-6 py-2">
                                                    <label class="cursor-pointer" for="checkbox22">
                                                        <input type="checkbox" class="me-2" id="checkbox22"
                                                            name="modules[]" value="22"
                                                            <?php echo e(!empty(old('modules')) && in_array(22, old('modules')) ? 'checked' : ''); ?>>
                                                        <?php echo e(trans('labels.general_settings')); ?>

                                                        <input type="hidden" name="title[]"
                                                            value="<?php echo e(trans('labels.general_settings')); ?>">
                                                    </label>
                                                </div>
                                                <div class="col-lg-3 col-md-6 py-2">
                                                    <label class="cursor-pointer" for="checkbox23">
                                                        <input type="checkbox" class="me-2" id="checkbox23"
                                                            name="modules[]" value="23"
                                                            <?php echo e(!empty(old('modules')) && in_array(23, old('modules')) ? 'checked' : ''); ?>>
                                                        <?php echo e(trans('labels.addons_manager')); ?>

                                                        <input type="hidden" name="title[]"
                                                            value="<?php echo e(trans('labels.addons_manager')); ?>">
                                                    </label>
                                                </div>
                                                <div class="col-lg-3 col-md-6 py-2">
                                                    <label class="cursor-pointer" for="checkbox24">
                                                        <input type="checkbox" class="me-2" id="checkbox24"
                                                            name="modules[]" value="24"
                                                            <?php echo e(!empty(old('modules')) && in_array(24, old('modules')) ? 'checked' : ''); ?>>
                                                        <?php echo e(trans('labels.clear_cache')); ?>

                                                        <input type="hidden" name="title[]"
                                                            value="<?php echo e(trans('labels.clear_cache')); ?>">
                                                    </label>
                                                </div>
                                                <?php if(@helper::checkaddons('pos')): ?>
                                                    <div class="col-lg-3 col-md-6 py-2">
                                                        <label class="cursor-pointer" for="checkbox25">
                                                            <input type="checkbox" class="me-2" id="checkbox25"
                                                                name="modules[]" value="25"
                                                                <?php echo e(!empty(old('modules')) && in_array(25, old('modules')) ? 'checked' : ''); ?>>
                                                            <?php echo e(trans('labels.pos')); ?>

                                                        </label>
                                                    </div>
                                                <?php endif; ?>
                                                <input type="hidden" name="title[]" value="<?php echo e(trans('labels.pos')); ?>">
                                                <?php if(@helper::checkaddons('otp')): ?>
                                                    <div class="col-lg-3 col-md-6 py-2">
                                                        <label class="cursor-pointer" for="checkbox26">
                                                            <input type="checkbox" class="me-2" id="checkbox26"
                                                                name="modules[]" value="26"
                                                                <?php echo e(!empty(old('modules')) && in_array(26, old('modules')) ? 'checked' : ''); ?>>
                                                            <?php echo e(trans('labels.otp_configuration')); ?>

                                                        </label>
                                                    </div>
                                                <?php endif; ?>
                                                <input type="hidden" name="title[]"
                                                    value="<?php echo e(trans('labels.otp_configuration')); ?>">
                                                <?php if(@helper::checkaddons('language')): ?>
                                                    <div class="col-lg-3 col-md-6 py-2">
                                                        <label class="cursor-pointer" for="checkbox27">
                                                            <input type="checkbox" class="me-2" id="checkbox27"
                                                                name="modules[]" value="27"
                                                                <?php echo e(!empty(old('modules')) && in_array(27, old('modules')) ? 'checked' : ''); ?>>
                                                            <?php echo e(trans('labels.language')); ?>

                                                        </label>
                                                    </div>
                                                <?php endif; ?>
                                                <input type="hidden" name="title[]"
                                                    value="<?php echo e(trans('labels.language')); ?>">
                                                <?php if(@helper::checkaddons('whatsapp_message')): ?>
                                                    <div class="col-lg-3 col-md-6 py-2">
                                                        <label class="cursor-pointer" for="checkbox28">
                                                            <input type="checkbox" class="me-2" id="checkbox28"
                                                                name="modules[]" value="28"
                                                                <?php echo e(!empty(old('modules')) && in_array(28, old('modules')) ? 'checked' : ''); ?>>
                                                            <?php echo e(trans('labels.whatsapp_settings')); ?>

                                                        </label>
                                                    </div>
                                                <?php endif; ?>
                                                <input type="hidden" name="title[]"
                                                    value="<?php echo e(trans('labels.whatsapp_settings')); ?>">
                                                <?php if(@helper::checkaddons('product_review')): ?>
                                                    <div class="col-lg-3 col-md-6 py-2">
                                                        <label class="cursor-pointer" for="checkbox29">
                                                            <input type="checkbox" class="me-2" id="checkbox29"
                                                                name="modules[]" value="29"
                                                                <?php echo e(!empty(old('modules')) && in_array(29, old('modules')) ? 'checked' : ''); ?>>
                                                            <?php echo e(trans('labels.product_reviews')); ?>

                                                        </label>
                                                    </div>
                                                <?php endif; ?>
                                                <input type="hidden" name="title[]"
                                                    value="<?php echo e(trans('labels.product_reviews')); ?>">
                                                <div class="col-lg-3 col-md-6 py-2">
                                                    <label class="cursor-pointer" for="checkbox30">
                                                        <input type="checkbox" class="me-2" id="checkbox30"
                                                            name="modules[]" value="30"
                                                            <?php echo e(!empty(old('modules')) && in_array(30, old('modules')) ? 'checked' : ''); ?>>
                                                        <?php echo e(trans('labels.tax')); ?>

                                                        <input type="hidden" name="title[]"
                                                            value="<?php echo e(trans('labels.tax')); ?>">
                                                    </label>
                                                </div>
                                                <div class="col-lg-3 col-md-6 py-2">
                                                    <label class="cursor-pointer" for="checkbox31">
                                                        <input type="checkbox" class="me-2" id="checkbox31"
                                                            name="modules[]" value="31"
                                                            <?php echo e(!empty(old('modules')) && in_array(31, old('modules')) ? 'checked' : ''); ?>>
                                                        <?php echo e(trans('labels.global_extras')); ?>

                                                        <input type="hidden" name="title[]"
                                                            value="<?php echo e(trans('labels.global_extras')); ?>">
                                                    </label>
                                                </div>
                                                <?php if(@helper::checkaddons('custom_status')): ?>
                                                    <div class="col-lg-3 col-md-6 py-2">
                                                        <label class="cursor-pointer" for="checkbox32">
                                                            <input type="checkbox" class="me-2" id="checkbox32"
                                                                name="modules[]" value="32"
                                                                <?php echo e(!empty(old('modules')) && in_array(32, old('modules')) ? 'checked' : ''); ?>>
                                                            <?php echo e(trans('labels.custom_status')); ?>

                                                        </label>
                                                    </div>
                                                <?php endif; ?>
                                                <input type="hidden" name="title[]"
                                                    value="<?php echo e(trans('labels.custom_status')); ?>">
                                                <?php if(@helper::checkaddons('top_deals')): ?>
                                                    <div class="col-lg-3 col-md-6 py-2">
                                                        <label class="cursor-pointer" for="checkbox33">
                                                            <input type="checkbox" class="me-2" id="checkbox33"
                                                                name="modules[]" value="33"
                                                                <?php echo e(!empty(old('modules')) && in_array(33, old('modules')) ? 'checked' : ''); ?>>
                                                            <?php echo e(trans('labels.top_deals')); ?>

                                                        </label>
                                                    </div>
                                                <?php endif; ?>
                                                <input type="hidden" name="title[]"
                                                    value="<?php echo e(trans('labels.top_deals')); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group <?php echo e(session()->get('direction') == '2' ? 'text-start' : 'text-end'); ?>">
                                    <a href="<?php echo e(URL::to('admin/roles')); ?>"
                                        class="btn btn-danger"><?php echo e(trans('labels.cancel')); ?></a>
                                    <button class="btn btn-primary"
                                        <?php if(env('Environment') == 'sendbox'): ?> type="button" onclick="myFunction()" <?php else: ?> type="submit" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.theme.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/roles/add.blade.php ENDPATH**/ ?>