<?php $__env->startSection('page_title'); ?>
    | <?php echo e(trans('labels.my_profile')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="breadcrumb-sec">
        <div class="container">
            <div class="breadcrumb-sec-content">
                <nav class="text-dark breadcrumb-divider" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li
                            class="breadcrumb-item <?php echo e(session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : ''); ?>">
                            <a class="text-dark fw-600" href="<?php echo e(route('home')); ?>"><?php echo e(trans('labels.home')); ?></a>
                        </li>
                        <li class="breadcrumb-item <?php echo e(session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : ''); ?> active"
                            aria-current="page"><?php echo e(trans('labels.my_profile')); ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section>
        <div class="container my-5">
            <div class="row">
                <div class="col-lg-3">
                    <?php echo $__env->make('web.layout.usersidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="col-lg-9">
                    <div class="user-content-wrapper h-100">
                        <p class="title border-bottom pb-3"><?php echo e(trans('labels.my_profile')); ?></p>
                        <form action="<?php echo e(URL::to('/profile/update')); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-3 mb-3">
                                    <div class="avatar-upload mx-auto">
                                        <div
                                            class="avatar-edit <?php echo e(session()->get('direction') == '2' ? 'avatar-edit-rtl' : ''); ?>">
                                            <input type='file' name="profile_image" id="imageupload">
                                            <label for="imageupload">
                                                <i class="fa-solid fa-pencil"></i>
                                            </label>
                                        </div>
                                        <div class="avatar-preview">
                                            <div id="imagepreview">
                                                <img src="<?php echo e(helper::image_path(Auth::user()->profile_image)); ?>"
                                                    alt="" id="imgupload">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group mb-3">
                                        <label for=""
                                            class="form-label mb-2"><?php echo e(trans('labels.full_name')); ?></label>
                                        <input type="text" class="form-control" name="name"
                                            placeholder="<?php echo e(trans('labels.full_name')); ?>" value="<?php echo e(Auth::user()->name); ?>"
                                            required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for=""
                                                    class="form-label mb-2"><?php echo e(trans('labels.email')); ?></label>
                                                <input type="email" class="form-control" name="email"
                                                    placeholder="<?php echo e(trans('labels.email')); ?>"
                                                    value="<?php echo e(Auth::user()->email); ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for=""
                                                    class="form-label mb-2"><?php echo e(trans('labels.mobile')); ?></label>
                                                <input type="text" class="form-control" name="mobile"
                                                    placeholder="<?php echo e(trans('labels.mobile')); ?>"
                                                    value="<?php echo e(Auth::user()->mobile); ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="col-md-12 <?php echo e(session()->get('direction') == '2' ? 'text-start' : 'text-end'); ?>">
                                    <button class="btn btn-primary px-4 py-2"
                                        <?php if(env('Environment') == 'sendbox'): ?> type="button" onclick="myFunction()" <?php else: ?> type="submit" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                                </div>
                            </div>
                        </form>
                        <hr>
                        <p class="title"><?php echo e(trans('labels.alert_settings')); ?></p>
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 fw-bold">
                                            <?php if(@helper::checkaddons('otp')): ?>
                                                <?php echo e(trans('labels.mobile')); ?>

                                            <?php else: ?>
                                                <?php echo e(trans('labels.email')); ?>

                                            <?php endif; ?>
                                        </h6>
                                        <span>
                                            <input type="checkbox" class="checkbox-switch" id="send_email-switch"
                                                data-url="<?php echo e(URL::to('/profile/send-email-status')); ?>" name="send_email"
                                                <?php echo e(Auth::user()->is_mail == 1 ? 'checked' : ''); ?>>
                                            <label for="send_email-switch" class="switch">
                                                <span
                                                    class="switch__circle"><span
                                                        class="switch__circle-inner"></span></span>
                                                <span
                                                    class="<?php echo e(session()->get('direction') == '2' ? 'switch__right pe-2' : 'switch__left ps-2'); ?>"><?php echo e(trans('labels.off')); ?></span>
                                                <span
                                                    class="<?php echo e(session()->get('direction') == '2' ? 'switch__left ps-2' : 'switch__right pe-2'); ?>"><?php echo e(trans('labels.on')); ?></span>
                                            </label>
                                        </span>
                                    </li>
                                    <li class="list-group-item px-0">
                                        <small>
                                            <?php if(@helper::checkaddons('otp')): ?>
                                                <?php echo e(trans('labels.keep_on_recieve_mobile')); ?>

                                            <?php else: ?>
                                                <?php echo e(trans('labels.keep_on_recieve_email')); ?>

                                            <?php endif; ?>
                                        </small>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <hr>
                        <p class="title border-bottom pb-3"><?php echo e(trans('labels.change_password')); ?></p>
                        <form action="<?php echo e(URL::to('/changepassword')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label for="old_password" class="form-label "><?php echo e(trans('labels.old_password')); ?>

                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="password" class="form-control" name="old_password"
                                            placeholder="<?php echo e(trans('labels.old_password')); ?>" id="old_password"
                                            value="<?php echo e(old('old_password')); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label for="new_password" class="form-label "><?php echo e(trans('labels.new_password')); ?>

                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="password" class="form-control" name="new_password"
                                            placeholder="<?php echo e(trans('labels.new_password')); ?>" id="new_password"
                                            value="<?php echo e(old('new_password')); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label for="confirm_password"
                                            class="form-label "><?php echo e(trans('labels.confirm_password')); ?>

                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="password" class="form-control" name="confirm_password"
                                            placeholder="<?php echo e(trans('labels.confirm_password')); ?>" id="confirm_password"
                                            value="<?php echo e(old('confirm_password')); ?>" required>
                                    </div>
                                </div>
                                <div class="col-12 <?php echo e(session()->get('direction') == '2' ? 'text-start' : 'text-end'); ?>">
                                    <button
                                        <?php if(env('Environment') == 'sendbox'): ?> type="button" onclick="myFunction()" <?php else: ?> type="submit" <?php endif; ?>
                                        class="btn btn-primary px-4 py-2"><?php echo e(trans('labels.reset')); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(url(env('ASSETSPATHURL') . 'web-assets/js/custom/profile.js')); ?>"></script>
    <?php if($errors->any()): ?>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <script>
                toastr.error('<?php echo e($error); ?>');
            </script>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/web/profile/profile.blade.php ENDPATH**/ ?>