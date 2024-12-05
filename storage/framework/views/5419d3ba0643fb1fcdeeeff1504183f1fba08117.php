<div id="quick_call" class="mb-5">
    <form action="<?php echo e(URL::to('admin/quick_call')); ?>" method="post" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div class="card border-0 box-shadow">
            <div class="d-flex align-items-center card-header p-3 bg-secondary">
                <h5 class="col-md-6 text-white">
                    <?php echo e(trans('labels.quick_call')); ?></h5>
                <div class="col-md-6 d-flex justify-content-end align-items-center">
                    <input id="quick_call-switch" type="checkbox" class="checkbox-switch"
                        name="quick_call" value="1"
                        <?php echo e(@$getsettings->quick_call == 1 ? 'checked' : ''); ?>>
                    <label for="quick_call-switch" class="switch">
                        <span class="<?php echo e(session()->get('direction') == '2' ? 'switch__circle-rtl' : 'switch__circle'); ?> switch__circle"><span
                                class="switch__circle-inner"></span></span>
                        <span class="switch__left <?php echo e(session()->get('direction') == '2' ? ' pe-2' : ' ps-2'); ?>"><?php echo e(trans('labels.off')); ?></span>
                        <span class="switch__right <?php echo e(session()->get('direction') == '2' ? ' ps-2' : ' pe-2'); ?>"><?php echo e(trans('labels.on')); ?></span>
                    </label>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <p class="form-label">
                            <?php echo e(trans('labels.quick_call_position')); ?>

                        </p>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input form-check-input-secondary" type="radio"
                                name="quick_call_position" id="quickradio" value="1"
                                <?php echo e(@$getsettings->quick_call_position == '1' ? 'checked' : ''); ?> />
                            <label for="quickradio"
                                class="form-check-label"><?php echo e(trans('labels.left')); ?></label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input form-check-input-secondary" type="radio"
                                name="quick_call_position" id="quickradio1" value="2"
                                <?php echo e(@$getsettings->quick_call_position == '2' ? 'checked' : ''); ?> />
                            <label for="quickradio1"
                                class="form-check-label"><?php echo e(trans('labels.right')); ?></label>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label fs-7 fw-500" for="quick_call_name"><?php echo e(trans('labels.name')); ?></label>
                        <span class="text-danger">*</span>
                        <input type="text" class="form-control" name="quick_call_name" placeholder="<?php echo e(trans('labels.name')); ?>" value="<?php echo e(@$getsettings->quick_call_name); ?>" required>
                        <?php $__errorArgs = ['quick_call_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-danger"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label fs-7 fw-500" for="quick_call_description"><?php echo e(trans('labels.description')); ?></label>
                        <input type="text" class="form-control" name="quick_call_description" value="<?php echo e(@$getsettings->quick_call_description); ?>" placeholder="<?php echo e(trans('labels.description')); ?>">
                        <?php $__errorArgs = ['quick_call_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-danger"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label fs-7 fw-500" for="quick_call_mobile"><?php echo e(trans('labels.mobile')); ?></label>
                        <span class="text-danger">*</span>
                        <input type="text" class="form-control" name="quick_call_mobile" placeholder="<?php echo e(trans('labels.mobile')); ?>" value="<?php echo e(@$getsettings->quick_call_mobile); ?>" required>
                        <?php $__errorArgs = ['quick_call_mobile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-danger"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label fs-7 fw-500" for="quick_call_image"><?php echo e(trans('labels.image')); ?></label>
                        <input type="file" class="form-control" name="quick_call_image" placeholder="<?php echo e(trans('labels.image')); ?>">
                        <img src='<?php echo e(helper::image_path(@$getsettings->quick_call_image)); ?>' class='img-fluid rounded h-50px mt-1'>
                        <?php $__errorArgs = ['quick_call_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-danger"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group mt-3 <?php echo e(session()->get('direction') == '2' ? 'text-start' : 'text-end'); ?>">
                        <button class="btn btn-primary px-4 " id="quick_call_update_btn" <?php if(env('Environment') == 'sendbox'): ?> type="button" onclick="myFunction()" <?php else: ?> type="submit" name="quick_call_update" value="1" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/quick_call/index.blade.php ENDPATH**/ ?>