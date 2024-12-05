<?php $__env->startSection('page_title'); ?>
    | <?php echo e(trans('labels.help_contact_us')); ?>

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
                            aria-current="page"><?php echo e(trans('labels.help_contact_us')); ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Contact us Section Start Here -->
    <section>
        <div class="contact-us">
            <div class="container">
                <div class="contact-content">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-auto right-side">
                            <form method="POST" class="p-5" action="<?php echo e(route('createcontact')); ?>">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <p class="fs-2 fw-600"><?php echo e(trans('labels.contactus_heading')); ?></p>
                                    <span class="text-muted"><?php echo e(trans('labels.contactus_description')); ?></span>
                                </div>
                                <div class="mb-3 mt-5 form-group">
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" class="form-control" name="fname"
                                                placeholder="<?php echo e(trans('messages.first_name')); ?>" required>
                                        </div>
                                        <div class="col-6">
                                            <input type="text" class="form-control" name="lname"
                                                placeholder="<?php echo e(trans('messages.last_name')); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 form-group">
                                    <input type="email" class="form-control" name="email"
                                        placeholder="<?php echo e(trans('labels.email')); ?>" required>
                                </div>
                                <div class="mb-3 form-group">
                                    <textarea class="form-control" rows="2" name="message" placeholder="<?php echo e(trans('labels.message')); ?>" required></textarea>
                                </div>
                                <div class="col-12 d-inline-block">
                                    <button type="submit"
                                        class="btn px-4 py-2 btn-primary float-end"><?php echo e(trans('labels.save')); ?></button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 col-sm-12 col-auto p-3 left-side">
                            <div class="col-12 my-1">
                                <div class="card border-0  rounded-3 p-3 h-100 ">
                                    <h2 class="fw-bold"><?php echo e(trans('labels.get_in_touch')); ?></h2>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-6 col-sm-6 my-1">
                                <div class="card border-0  rounded-3 p-3 h-100">
                                    <h5><i class="fa-solid fa-location-dot <?php echo e(session()->get('direction') == '2' ? 'ps-2' : 'pe-2'); ?>"></i><?php echo e(trans('labels.address')); ?></h5>
                                    <a href="<?php echo e(@helper::appdata()->address_url); ?>"><?php echo e(@helper::appdata()->address); ?></a>
                                </div>
                            </div>
                            <div class="row mb-4 ">
                                <div class="col-xl-6 col-lg-6 col-sm-6 my-1">
                                    <div class="card border-0  rounded-3 p-3 h-100">
                                        <h5> <i class="fa-solid fa-envelope <?php echo e(session()->get('direction') == '2' ? 'ps-2' : 'pe-2'); ?>"></i><?php echo e(trans('labels.email')); ?></h5>
                                        <a href="mailto:<?php echo e(@helper::appdata()->email); ?>"
                                            class=" text-break"><?php echo e(@helper::appdata()->email); ?></a>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-sm-6 my-1">
                                    <div class="card border-0  rounded-3 p-3 h-100 ">
                                        <h5> <i class="fa-solid fa-phone <?php echo e(session()->get('direction') == '2' ? 'ps-2' : 'pe-2'); ?>"></i><?php echo e(trans('labels.mobile')); ?></h5>
                                        <a href="tel:<?php echo e(@helper::appdata()->mobile); ?>"
                                            class="text-break"><?php echo e(@helper::appdata()->mobile); ?></a>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-6 col-sm-6 my-1">
                                    <div class="card border-0 rounded-3 p-3 h-100 row">
                                        <h5><i class="fa-solid fa-clock <?php echo e(session()->get('direction') == '2' ? 'ps-2' : 'pe-2'); ?>"></i><?php echo e(trans('labels.working_hours')); ?></h5>
                                        <h6 class="text-muted"><?php echo e(ucfirst($timedata->day)); ?>

                                            <span class="cursor-pointer" data-bs-toggle="modal"
                                                data-bs-target="#modal_working_hours">
                                                <i class="fa-solid fa-circle-info fs-6 text-dark"></i>
                                            </span>
                                        </h6>
                                        <?php if($timedata->always_close == 1): ?>
                                            <span
                                                class="badge bg-danger fs-6 col-xl-4 col-12"><?php echo e(trans('labels.closing_time')); ?></span>
                                        <?php else: ?>
                                            <p><?php echo e($timedata->open_time); ?> <b><?php echo e(trans('labels.to')); ?></b>
                                                <?php echo e($timedata->break_start); ?></p>
                                            <p><?php echo e($timedata->break_end); ?> <b><?php echo e(trans('labels.to')); ?></b>
                                                <?php echo e($timedata->close_time); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact us Section End Here -->
    <?php echo $__env->make('web.subscribeform', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/web/contactus.blade.php ENDPATH**/ ?>