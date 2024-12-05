<!DOCTYPE html>
<html lang="en" dir="<?php echo e(session('direction') == 2 ? 'rtl' : 'ltr'); ?>">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?php echo e(@helper::appdata()->title); ?></title>
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(helper::image_path(@helper::appdata()->favicon)); ?>">
    <!-- Favicon icon -->
    <link rel="stylesheet"
        href="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/css/bootstrap/bootstrap.min.css')); ?>">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/css/fontawesome/all.min.css')); ?>">
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/css/toastr/toastr.min.css')); ?>">
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/css/style.css')); ?>">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/css/responsive.css')); ?>">
    <!-- Responsive CSS -->
    <style>
        :root {
            --bs-primary: <?php echo e(@helper::appdata()->admin_primary_color != null ? @helper::appdata()->admin_primary_color : '#01112B'); ?>;
            --bs-secondary: <?php echo e(@helper::appdata()->admin_secondary_color != null ? @helper::appdata()->admin_secondary_color : '#0a98af'); ?>;
        }
    </style>
</head>

<body>
    <?php echo $__env->make('admin.theme.preloader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    <div class="row align-items-center g-0 w-100 h-100vh position-relative login-admin">
        <div class="col-xl-4 col-lg-5 col-md-6 overflow-hidden overflow-hidden" style="background-color: #D6B62B">
            <div class="login-right-content login-forgot-padding d-flex flex-column">
                <div class="w-100">
                    <div class="img-logo mb-4">
                        <img src="<?php echo e(helper::image_path(@helper::appdata()->logo)); ?>" class="" alt="">
                    </div>
                    <div class="text-primary d-flex justify-content-between">
                        <div>
                            <h2 class="fw-500 text-white title-text mb-2">Sign In</h2>
                            <p class="text-white fs-7">Please Login to continue to your account</p>
                        </div>
                        <!-- language -->
                        <div class="lag-btn dropdown border-0 shadow-none login-lang">
                            <button class="btn px-2 py-1 border-white" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="fa-solid fa-globe fs-6 text-white"></i>
                            </button>
                            <ul class="dropdown-menu drop-menu shadow border-0 drop-menu">
                                <?php $__currentLoopData = helper::language(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <a class="dropdown-item d-flex text-start d-flex"
                                            href="<?php echo e(URL::to('/language-' . $lang->code)); ?>">
                                            <img src="<?php echo e(helper::image_path($lang->image)); ?>" alt=""
                                                class="img-fluid mx-1 rounded-5 language-width">
                                            <?php echo e($lang->name); ?>

                                        </a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>

                    </div>

                    <form class="my-3" method="POST" action="<?php echo e(URL::to('/admin/check-login')); ?>" id="login-form">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label for="email" class="form-label fs-7 text-white">Email<span class="text-danger">
                                *
                            </span></label>
                            <input id="email" type="email"
                                class="form-control py-2 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email"
                                required="" autocomplete="email" autofocus placeholder="<?php echo e(trans('labels.email')); ?>">
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="form-group">

                            <label for="password" class="form-label fs-7 text-white">Password<span class="text-danger">
                                * </span></label>
                            <div class="form-control d-flex align-items-center gap-3">
                                <input id="password" type="password"
                                    class="form-control border-0 p-0 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    name="password" required autocomplete="current-password"
                                    placeholder="<?php echo e(trans('labels.password')); ?>">
                                <span>
                                    <a href="#"><i class="fa-light fa-eye-slash" id="eye"></i></a>
                                </span>
                            </div>
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="d-flex flex-wrap">
                            <div class="form-group mb-2 col-sm-6 col-12 d-flex align-items-center">
                                <input class="form-check-input secondary mt-0" type="checkbox" value="" name="check_terms"
                                    id="check_terms" checked="" required="">
                                <label class="form-check-label cursor-pointer mx-1" for="check_terms">
                                    <span class="fs-7 text-white">
                                        Remember me
                                    </span>
                                </label>
                            </div>

                            <div class="mb-2 col-sm-6 col-12 text-sm-end">
                                <a href="<?php echo e(URL::to('admin/forgot-password')); ?>" class="text-white fs-7 fw-500">
                                    <i
                                        class="fa-solid fa-lock-keyhole fs-7 <?php echo e(session()->get('direction') == 2 ? 'ms-1' : 'me-1'); ?>"></i><?php echo e(trans('labels.forgot_password_q')); ?>

                                </a>
                            </div>
                        </div>

                        <button class="btn btn-secondary w-100 py-2 my-3" type="submit"><?php echo e(trans('labels.signin')); ?></button>

                        <?php if(env('Environment') == 'sendbox'): ?>
                        <hr>
                        <p class="text-center text-danger">Explore with <b class="text-white">FREE</b> addons</p>

                        <div class="d-flex">
                            <button class="btn btn-secondary w-100 mt-2 mb-3 padding mx-2" id="admin_free_addon_login">Admin login</button>
                        </div>

                        <p class="text-center text-danger">Explore with <b class="text-white">ALL</b> addons</p>

                        <div class="d-flex">
                            <button class="btn btn-secondary w-100 mt-2 mb-3 padding mx-2" id="all-addon">Admin login</button>
                        </div>

                        <p class="text-center text-danger"><b class="text-white">Demo Themes</b></p>

                        <div class="d-flex">
                            <a href="http://localhost/single-restaurant/?theme_id=1" target="_blank" class="btn btn-secondary w-100 mt-2 mb-3 padding mx-2">Theme - 1 (Included)</a>
                            <a href="http://localhost/single-restaurant/?theme_id=2" target="_blank" class="btn btn-secondary w-100 mt-2 mb-3 padding mx-2">Theme - 2 (Addon)</a>
                            <a href="http://localhost/single-restaurant/?theme_id=3" target="_blank" class="btn btn-secondary w-100 mt-2 mb-3 padding mx-2">Theme - 3 (Addon)</a>
                        </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-8 col-lg-7 col-md-6 d-md-block d-none">

            <div class="image-1">
                <img src="<?php echo e(helper::image_path(@helper::appdata()->auth_bg_image)); ?>"
                    alt="" class="object h-100vh">
            </div>
        </div>
    </div>



    <script src="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/js/jquery/jquery.min.js')); ?>"></script><!-- jQuery JS -->
    <script src="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/js/bootstrap/bootstrap.bundle.min.js')); ?>"></script><!-- Bootstrap JS -->
    <script src="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/js/toastr/toastr.min.js')); ?>"></script><!-- Toastr JS -->
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        <?php if(Session::has('success')): ?>
            toastr.success("<?php echo e(session('success')); ?>");
        <?php endif; ?>
        <?php if(Session::has('error')): ?>
            toastr.error("<?php echo e(session('error')); ?>");
        <?php endif; ?>
        $(window).on("load", function() {
            "use strict";
            $('#preloader').fadeOut('slow')
        });
    </script>
    <script>
        function AdminFill(email, password) {
            $('#email').val(email);
            $('#password').val(password);
        }

        $(document).on("click", "#admin_free_addon_login", function() {
            $("#admin_free_addon_login").attr("disabled", true);

            $("#email").val('admin@gmail.com');
            $("#password").val('123456');
            SessionSave('free-addon');
        });

        $(document).on("click", "#all-addon", function() {
            $("#all-addon").attr("disabled", true);

            $("#email").val('admin@gmail.com');
            $("#password").val('123456');
            SessionSave('all-addon');
        });

        function SessionSave(addon = null) {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                dataType: "json",
                url: "<?php echo e(URL::to('add-on/session/save')); ?>",
                data: {
                    'demo_type': addon,
                },
                success: function(response) {
                    $('#login-form').submit();
                }
            });
        }
    </script>
</body>

</html>
<?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/auth/login.blade.php ENDPATH**/ ?>