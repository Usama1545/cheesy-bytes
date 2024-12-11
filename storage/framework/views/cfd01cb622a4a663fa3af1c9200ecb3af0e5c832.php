<link rel="stylesheet"
    href="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/css/timepicker/jquery.timepicker.min.css')); ?>">
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="<?php echo e(URL::to('admin/time/store')); ?>" method="post">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="col-md-4 mb-lg-0">
                                        <div class="form-group">
                                            <label class="form-label"><?php echo e(trans('labels.time_interval')); ?><span
                                                    class="text-danger"> *
                                                </span></label>
                                            <div class="input-group">
                                                <input type="text"
                                                    class="form-control <?php echo e(session()->get('direction') == 2 ? 'input-group-rtl rounded-end' : ''); ?> numbers_only"
                                                    name="interval_time" placeholder="<?php echo e(trans('labels.time_interval')); ?>"
                                                    aria-describedby="button-addon2"
                                                    value="<?php echo e($settingsdata->interval_time); ?>" required>
                                                <select name="interval_type" class="border border-muted <?php echo e(session()->get('direction') == 2 ? 'rounded-start' : 'rounded-end'); ?>" required>
                                                    <option value="1"
                                                        <?php echo e($settingsdata->interval_type == 1 ? 'selected' : ''); ?>>
                                                        <?php echo e(trans('labels.minute')); ?>

                                                    </option>
                                                    <option value="2"
                                                        <?php echo e($settingsdata->interval_type == 2 ? 'selected' : ''); ?>>
                                                        <?php echo e(trans('labels.hour')); ?>

                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-lg-0">
                                        <div class="form-group">
                                            <label class="form-label"><?php echo e(trans('labels.perslot_booking_limit')); ?>

                                                <span class="text-danger"> * </span></label>
                                            <input type="number" class="form-control" name="slot_limit"
                                                placeholder="<?php echo e(trans('labels.perslot_booking_limit')); ?>"
                                                aria-describedby="button-addon2"
                                                value="<?php echo e($settingsdata->perslot_booking_limit); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="form-label" for=""><?php echo e(trans('labels.date_time')); ?>

                                        </label>
                                        <input id="ordertypedatetime-switch" type="checkbox" class="checkbox-switch"
                                            name="ordertypedatetime" value="1"
                                            <?php echo e($settingsdata->ordertype_date_time == 1 ? 'checked' : ''); ?>>
                                        <label for="ordertypedatetime-switch" class="switch">
                                            <span
                                                class="<?php echo e(session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle'); ?>"><span
                                                    class="switch__circle-inner"></span></span>
                                            <span
                                                class="switch__left <?php echo e(session()->get('direction') == 2 ? 'pe-2' : 'ps-2'); ?>"><?php echo e(trans('labels.off')); ?></span>
                                            <span
                                                class="switch__right <?php echo e(session()->get('direction') == 2 ? 'ps-2' : 'pe-2'); ?>"><?php echo e(trans('labels.on')); ?></span>
                                        </label>
                                    </div>

                                </div>
                                <div class="row mt-2">
                                    <label class="col-md-2 col-form-label"></label>
                                    <label
                                        class="col-md-2 text-center mb-0 d-none d-lg-block d-xl-block d-xxl-block"><?php echo e(trans('labels.opening_time')); ?></label>
                                    <label
                                        class="col-md-2 text-center mb-0 d-none d-lg-block d-xl-block d-xxl-block"><?php echo e(trans('labels.break_start')); ?></label>
                                    <label
                                        class="col-md-2 text-center mb-0 d-none d-lg-block d-xl-block d-xxl-block"><?php echo e(trans('labels.break_end')); ?></label>
                                    <label
                                        class="col-md-2 text-center mb-0 d-none d-lg-block d-xl-block d-xxl-block"><?php echo e(trans('labels.closing_time')); ?></label>
                                    <label
                                        class="col-md-2 text-center mb-0 d-none d-lg-block d-xl-block d-xxl-block"><?php echo e(trans('labels.is_closed')); ?></label>
                                </div>
                                <?php $__currentLoopData = $gettime; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $time): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="row my-2">
                                        <label class="col-md-2 col-form-label"> <strong class="fw-500">
                                                <?php echo e(trans('labels.' . strtolower($time->day))); ?> </strong> </label>
                                        <input type="hidden" name="day[]" value="<?php echo e(strtolower($time->day)); ?>">
                                        <?php if($time->always_close == '2'): ?>
                                            <div class="form-group col-md-2 d-grid align-items-end">
                                                <label
                                                    class="d-lg-none d-xl-none d-xxl-none"><?php echo e(trans('labels.opening_time')); ?></label>
                                                <input type="text"
                                                    class="form-control h-fit-content timepicker <?php echo e($errors->has('open_time.' . $key) ? 'is-invalid' : ''); ?>"
                                                    placeholder="<?php echo e(trans('labels.opening_time')); ?>" name="open_time[]"
                                                    value="<?php echo e($time->open_time); ?>" required>
                                            </div>
                                            <div class="form-group col-md-2 d-grid align-items-end">
                                                <label
                                                    class="d-lg-none d-xl-none d-xxl-none"><?php echo e(trans('labels.break_start')); ?></label>
                                                <input type="text"
                                                    class="form-control h-fit-content timepicker <?php echo e($errors->has('break_start.' . $key) ? 'is-invalid' : ''); ?>"
                                                    placeholder="<?php echo e(trans('labels.break_start')); ?>" name="break_start[]"
                                                    value="<?php echo e($time->break_start); ?>" required>
                                            </div>
                                            <div class="form-group col-md-2 d-grid align-items-end">
                                                <label
                                                    class="d-lg-none d-xl-none d-xxl-none"><?php echo e(trans('labels.break_end')); ?></label>
                                                <input type="text"
                                                    class="form-control h-fit-content timepicker <?php echo e($errors->has('break_end.' . $key) ? 'is-invalid' : ''); ?>"
                                                    placeholder="<?php echo e(trans('labels.break_end')); ?>" name="break_end[]"
                                                    value="<?php echo e($time->break_end); ?>" required>
                                            </div>
                                            <div class="form-group col-md-2 d-grid align-items-end">
                                                <label
                                                    class="d-lg-none d-xl-none d-xxl-none"><?php echo e(trans('labels.closing_time')); ?></label>
                                                <input type="text"
                                                    class="form-control h-fit-content timepicker <?php echo e($errors->has('close_time.' . $key) ? 'is-invalid' : ''); ?>"
                                                    placeholder="<?php echo e(trans('labels.closing_time')); ?>" name="close_time[]"
                                                    value="<?php echo e($time->close_time); ?>" required>
                                            </div>
                                        <?php else: ?>
                                            <div class="form-group col-md-2 d-grid align-items-end">
                                                <label
                                                    class="d-lg-none d-xl-none d-xxl-none"><?php echo e(trans('labels.opening_time')); ?></label>
                                                <input type="text"
                                                    class="form-control h-fit-content <?php echo e($errors->has('open_time.' . $key) ? 'is-invalid' : ''); ?>"
                                                    placeholder="<?php echo e(trans('labels.opening_time')); ?>" name="open_time[]"
                                                    value="closed" readonly="" required>
                                            </div>
                                            <div class="form-group col-md-2 d-grid align-items-end">
                                                <label
                                                    class="d-lg-none d-xl-none d-xxl-none"><?php echo e(trans('labels.break_start')); ?></label>
                                                <input type="text"
                                                    class="form-control h-fit-content <?php echo e($errors->has('break_start.' . $key) ? 'is-invalid' : ''); ?>"
                                                    placeholder="<?php echo e(trans('labels.break_start')); ?>" name="break_start[]"
                                                    value="closed" readonly="" required>
                                            </div>
                                            <div class="form-group col-md-2 d-grid align-items-end">
                                                <label
                                                    class="d-lg-none d-xl-none d-xxl-none"><?php echo e(trans('labels.break_end')); ?></label>
                                                <input type="text"
                                                    class="form-control h-fit-content <?php echo e($errors->has('break_end.' . $key) ? 'is-invalid' : ''); ?>"
                                                    placeholder="<?php echo e(trans('labels.break_end')); ?>" name="break_end[]"
                                                    value="closed" readonly="" required>
                                            </div>
                                            <div class="form-group col-md-2 d-grid align-items-end">
                                                <label
                                                    class="d-lg-none d-xl-none d-xxl-none"><?php echo e(trans('labels.closing_time')); ?></label>
                                                <input type="text"
                                                    class="form-control h-fit-content <?php echo e($errors->has('close_time.' . $key) ? 'is-invalid' : ''); ?>"
                                                    placeholder="<?php echo e(trans('labels.closing_time')); ?>" name="close_time[]"
                                                    value="closed" readonly="" required>
                                            </div>
                                        <?php endif; ?>
                                        <div class="form-group col-md-2">
                                            <label
                                                class="d-lg-none d-xl-none d-xxl-none"><?php echo e(trans('labels.is_closed')); ?></label>
                                            <select
                                                class="form-select h-fit-content <?php echo e($errors->has('always_close.' . $key) ? 'is-invalid' : ''); ?>"
                                                name="always_close[]" required>
                                                <option value="" selected disabled><?php echo e(trans('labels.select')); ?>

                                                </option>
                                                <option value="1" <?php if($time->always_close == '1'): ?> selected <?php endif; ?>>
                                                    <?php echo e(trans('labels.yes')); ?></option>
                                                <option value="2" <?php if($time->always_close == '2'): ?> selected <?php endif; ?>>
                                                    <?php echo e(trans('labels.no')); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <div class="form-group <?php echo e(session()->get('direction') == '2' ? 'text-start' : 'text-end'); ?>">
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
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/js/timepicker/jquery.timepicker.min.js')); ?>"></script>
    <script>
        $(document).ready(function() {
            "use strict";
            $(".timepicker").timepicker();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.theme.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/time.blade.php ENDPATH**/ ?>