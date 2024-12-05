<div id="review_settings">
    <div class="row mb-3">
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <form action="<?php echo e(URL::to('admin/review-settings/update')); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="card-header p-3 bg-secondary rounded-top">
                        <div class="d-flex align-items-center">
                            <h5 class="text-white col-md-6">
                                <?php echo e(trans('labels.review_settings')); ?></h5>
                            <div class="col-md-6 d-flex justify-content-end align-items-center">
                                <input id="review_approved_status-switch" type="checkbox" class="checkbox-switch"
                                    name="review_approved_status" value="1"
                                    <?php echo e($getsettings->review_approved_status == 1 ? 'checked' : ''); ?>>
                                <label for="review_approved_status-switch" class="switch">
                                    <span class="switch__circle switch__circle"><span
                                            class="switch__circle-inner"></span></span>
                                    <span class="switch__left ps-2"><?php echo e(trans('labels.off')); ?></span>
                                    <span class="switch__right pe-2"><?php echo e(trans('labels.on')); ?></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3 ms-sm-4">
                            <div class="col-lg-2 col-sm-6">
                                <label class="col-form-label fs-6 fw-500" for=""><?php echo e(trans('labels.auto_approved')); ?>

                                    :</label>
                            </div>
                            <?php $approved_status = explode(',',$getsettings->review_auto_approved); ?>
                            <div class="col-lg-2 col-6 py-2">
                                <label class="cursor-pointer fs-5" for="checkbox5">
                                    <input type="checkbox" class="me-2 checkbox-width" id="checkbox5"
                                        name="review_auto_approved[]" value="5"
                                        <?php echo e(in_array('5', $approved_status) == true ? 'checked' : ''); ?>

                                        <?php echo e($getsettings->review_approved_status != 1 ? 'disabled' : ''); ?>>5.0
                                </label>
                            </div>
                            <div class="col-lg-2 col-6 py-2">
                                <label class="cursor-pointer fs-5" for="checkbox4">
                                    <input type="checkbox" class="me-2 checkbox-width" id="checkbox4"
                                        name="review_auto_approved[]" value="4"
                                        <?php echo e(in_array('4', $approved_status) == true ? 'checked' : ''); ?>

                                        <?php echo e($getsettings->review_approved_status != 1 ? 'disabled' : ''); ?>>4.0
                                </label>
                            </div>
                            <div class="col-lg-2 col-6 py-2">
                                <label class="cursor-pointer fs-5" for="checkbox3">
                                    <input type="checkbox" class="me-2 checkbox-width" id="checkbox3"
                                        name="review_auto_approved[]" value="3"
                                        <?php echo e(in_array('3', $approved_status) == true ? 'checked' : ''); ?>

                                        <?php echo e($getsettings->review_approved_status != 1 ? 'disabled' : ''); ?>>3.0
                                </label>
                            </div>
                            <div class="col-lg-2 col-6 py-2">
                                <label class="cursor-pointer fs-5" for="checkbox2">
                                    <input type="checkbox" class="me-2 checkbox-width" id="checkbox2"
                                        name="review_auto_approved[]" value="2"
                                        <?php echo e(in_array('2', $approved_status) == true ? 'checked' : ''); ?>

                                        <?php echo e($getsettings->review_approved_status != 1 ? 'disabled' : ''); ?>>2.0
                                </label>
                            </div>
                            <div class="col-lg-2 col-6 py-2">
                                <label class="cursor-pointer fs-5" for="checkbox1">
                                    <input type="checkbox" class="me-2 checkbox-width" id="checkbox1"
                                        name="review_auto_approved[]" value="1"
                                        <?php echo e(in_array('1', $approved_status) == true ? 'checked' : ''); ?>

                                        <?php echo e($getsettings->review_approved_status != 1 ? 'disabled' : ''); ?>>1.0
                                </label>
                            </div>
                            <?php $__errorArgs = ['review_auto_approved'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger"><?php echo e($message); ?></span><br>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="row">
                            <div
                                class="form-group <?php echo e(session()->get('direction') == '2' ? 'text-start' : 'text-end'); ?>">
                                <button class="btn btn-primary" id="review_setting_update_btn"
                                    <?php echo e($getsettings->review_approved_status != 1 ? 'disabled' : ''); ?>

                                    <?php if(env('Environment') == 'sendbox'): ?> type="button" onclick="myFunction()" <?php else: ?> type="submit" name="review_setting_update" value="1" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/reviews/review_setting.blade.php ENDPATH**/ ?>