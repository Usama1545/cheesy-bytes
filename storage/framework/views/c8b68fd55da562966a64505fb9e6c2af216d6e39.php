<!doctype html>
<html lang="en" dir="<?php echo e(session('direction') == 2 ? 'rtl' : 'ltr'); ?>">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title> <?php echo e(@helper::appdata()->title); ?> | <?php echo e(trans('labels.signup')); ?> </title>
    <link rel="icon" href="<?php echo e(helper::image_path(@helper::appdata()->favicon)); ?>"><!-- Favicon -->
    <link rel="stylesheet" href="<?php echo e(url(env('ASSETSPATHURL') . 'web-assets/css/bootstrap.min.css')); ?>">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo e(url(env('ASSETSPATHURL') . 'web-assets/css/font_awesome/all.css')); ?>">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="<?php echo e(url(env('ASSETSPATHURL') . 'web-assets/css/style.css')); ?>"><!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo e(url(env('ASSETSPATHURL') . 'web-assets/css/responsive.css')); ?>">
    <!-- Media Query Resposive CSS -->
    <!-- COMMON-CSS -->
    <link rel="stylesheet" href="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/css/toastr/toastr.min.css')); ?>">
    <!-- Toastr CSS -->
    <style>
        :root {
            --bs-primary: <?php echo e(helper::appdata()->web_primary_color != null ? helper::appdata()->web_primary_color : '#F82647'); ?>;
            --bs-secondary: <?php echo e(helper::appdata()->web_secondary_color != null ? helper::appdata()->web_secondary_color : '#FFC344'); ?>;
        }
    </style>
</head>

<body>
<main >
    <div class="img-fluid">
        <!-- Sticky Background Image -->
        <div class=" d-flex justify-content-center align-items-center">
            <div class="auth_form_inner box-login col-12 " >
                <div class="d-lg-flex">
                    <div class="col-lg-4 col-12 px-sm-5 py-4 my-3 px-4">
                        <!-- Authentication Form Body -->
                        <form action="<?php echo e(route('adduser')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <!-- Authentication Form Inner Content -->
                            <a href="<?php echo e(route('home')); ?>">
                                <img src="<?php echo e(helper::image_path(@helper::appdata()->logo)); ?>" alt=""
                                     class="login-form-logo"></a>
                            <h5 class="bottom-line py-2 mt-3 mb-0 fw-bold w-auto text-white"><?php echo e(trans('labels.signup')); ?></h5>
                            <h6 class="fs-7 text-white"><?php echo e(trans('labels.signup_note')); ?></h6>
                            <div class="form-body mt-4">
                                <div class="form-group mb-md-3 mb-2">
                                    <label class="form-label fs-7 mb-1 text-white"
                                           for="name"><?php echo e(trans('labels.full_name')); ?>

                                        <span class="text-danger">*</span>
                                    </label>
                                    <?php if(session()->has('social_login')): ?>
                                        <input type="text" class="form-control rounded mb-1" name="name"
                                               value="<?php echo e(session()->get('social_login')['name']); ?>" id="name"
                                               placeholder="<?php echo e(trans('labels.full_name')); ?>" required>
                                    <?php else: ?>
                                        <input type="text" class="form-control rounded mb-1" name="name"
                                               value="<?php echo e(old('name')); ?>" id="name"
                                               placeholder="<?php echo e(trans('labels.full_name')); ?>" required>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group mb-md-3 mb-2">
                                    <label class="form-label fs-7 mb-1 text-white" for="email"><?php echo e(trans('labels.email')); ?>

                                        <span class="text-danger">*</span>
                                    </label>
                                    <?php if(session()->has('social_login')): ?>
                                        <input type="email" class="form-control rounded mb-1" name="email"
                                               value="<?php echo e(session()->get('social_login')['email']); ?>" id="email"
                                               placeholder="<?php echo e(trans('labels.email')); ?>" required>
                                    <?php else: ?>
                                        <input type="email" class="form-control rounded mb-1" name="email"
                                               value="<?php echo e(old('email')); ?>" id="email"
                                               placeholder="<?php echo e(trans('labels.email')); ?>" required>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <div class="row g-2 mb-md-3 mb-3">
                                        <div class="col-md">
                                            <label class="form-label fs-7 mb-1 text-white"
                                                   for="mobile"><?php echo e(trans('labels.mobile')); ?>

                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="tel" id="mobile" name="mobile"
                                                   class="form-control numbers_only rounded"
                                                   placeholder="<?php echo e(trans('labels.mobile')); ?>"
                                                   value="<?php echo e(old('mobile')); ?>" required>
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label fs-7 mb-1 text-white"
                                                   for="referral_code"><?php echo e(trans('labels.referral_code')); ?> </label>
                                            <input type="text" class="form-control rounded" id="referral_code"
                                                   name="referral_code"
                                                   placeholder="<?php echo e(trans('labels.referral_code_o')); ?>"
                                                   <?php if(isset($_GET['referral'])): ?> value="<?php echo e($_GET['referral']); ?>" <?php endif; ?>>
                                        </div>
                                    </div>
                                </div>
                                <?php if(!session()->has('social_login')): ?>
                                    <?php if(@helper::checkaddons('otp')): ?>
                                    <?php else: ?>
                                        <div class="form-group mb-md-3 mb-2">
                                            <div class="row g-2">
                                                <div class="col-md">
                                                    <label class="form-label fs-7 mb-1 text-white"
                                                           for="password"><?php echo e(trans('labels.password')); ?>

                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="password" class="form-control rounded mb-1"
                                                           id="password" name="password"
                                                           placeholder="<?php echo e(trans('labels.password')); ?>"
                                                           value="<?php echo e(old('password')); ?>" required>
                                                </div>
                                                <div class="col-md">
                                                    <label class="form-label fs-7 mb-1 text-white"
                                                           for="confirm_password"><?php echo e(trans('labels.confirm_password')); ?>

                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="password" class="form-control rounded mb-1"
                                                           id="confirm_password" name="password_confirmation"
                                                           placeholder="<?php echo e(trans('labels.confirm_password')); ?>"
                                                           value="<?php echo e(old('password_confirmation')); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <div class="form-group">
                                    <input type="checkbox" name="checkbox" id="checkbox" value="1"
                                           required class="form-check-input me-1"
                                        <?php echo e(old('checkbox') == 1 ? 'checked' : ''); ?>>
                                    <label for="checkbox" class="form-check-label m-auto fs-7 text-white">
                                        <?php echo e(trans('labels.i_accepts_the')); ?> <a
                                            href="<?php echo e(URL::to('terms-conditions')); ?>"
                                            class="text-primary text-decoration-none fw-medium"><?php echo e(trans('labels.terms_conditions')); ?></a></label>
                                </div>
                                <div class="form-group mt-2">
                                    <button type="submit"
                                            class="btn btn-primary w-100"><?php echo e(trans('labels.signup')); ?></button>
                                </div>
                            </div>
                            <div class="form-group text-center mt-3">
                                <p class="mb-0 fs-7 text-white">
                                    <?php echo e(trans('labels.already_account')); ?>

                                    <a href="<?php echo e('login'); ?>"
                                       class="text-primary fw-medium text-decoration-none"><?php echo e(trans('labels.signin')); ?></a>
                                </p>
                            </div>
                        </form>
                    </div>
                    <div class="image col-8 d-none d-md-block" >
                        <img src="<?php echo e(helper::image_path(helper::appdata()->auth_bg_image)); ?>" class="w-100" style="border-radius: 0px">
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="<?php echo e(url(env('ASSETSPATHURL') . 'web-assets/js/jquery/jquery-3.6.0.js')); ?>"></script><!-- jQuery JS -->
<script src="<?php echo e(url(env('ASSETSPATHURL') . 'web-assets/js/bootstrap/bootstrap.bundle.min.js')); ?>"></script><!-- Bootstrap JS -->
<!-- COMMON-JS -->
<script src="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/js/toastr/toastr.min.js')); ?>"></script><!-- Toastr JS -->
<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
    }
    <?php if(Session::has('success')): ?>
    toastr.success("<?php echo e(session('success')); ?>");
    <?php endif; ?>
    <?php if(Session::has('error')): ?>
    toastr.error("<?php echo e(session('error')); ?>");
    <?php endif; ?>

    $('.numbers_only').on('keyup', function() {
        "use strict";
        var val = $(this).val();
        if (isNaN(val)) {
            val = val.replace(/[^0-9\.]/g, '');
            if (val.split('.').length > 2) {
                val = val.replace(/\.+$/, "");
            }
        }
        $(this).val(val);
    });
</script>
<?php if($errors->any()): ?>
    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <script>
            toastr.error('<?php echo e($error); ?>');
        </script>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<!-- IF VERSION 2  -->
<?php if(helper::appdata()->recaptcha_version == 'v2'): ?>
    <script src='https://www.google.com/recaptcha/api.js'></script>
<?php endif; ?>
<!-- IF VERSION 3  -->
<?php if(helper::appdata()->recaptcha_version == 'v3'): ?>
    <?php echo RecaptchaV3::initJs(); ?>

<?php endif; ?>
</body>

</html>
<?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/web/auth/register.blade.php ENDPATH**/ ?>