<?php $__env->startSection('page_title'); ?>
    | Location
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="breadcrumb-sec">
        <div class="container">
            <div class="breadcrumb-sec-content">
                <nav class="text-dark breadcrumb-divider" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li
                            class="breadcrumb-item <?php echo e(session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : ''); ?>">
                            <a class="text-dark fw-600" href="<?php echo e(URL::to('/')); ?>"><?php echo e(trans('labels.home')); ?></a>
                        </li>
                        <li class="breadcrumb-item <?php echo e(session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : ''); ?> active"
                            aria-current="page">Restaurant
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="d-flex justify-content-center" style="min-height: 100vh;">
        <div class="container my-3">
            <div class="card col-md-10 mx-auto border-0">
                <h3 class="mx-3">Delivery RESULTS</h3>

                <div class="card-body">
                    <?php if(!$not_available): ?>
                        <div class="card  mx-auto">
                            <div class="card-header d-flex justify-content-between align-items-center"
                                 style="background: #D6B62B">
                                <span class="fw-bold">YOUR DELIVERY STORE</span>
                                <span class="ms-auto fw-bold text-sm" style="font-size: 10px">based on your provided address</span>
                            </div>
                            <div class="card-body">
                                <span style="color: red">Sorry we don’t currently offer delivery to your location but we’ve displayed nearby carryout stores below.</span><br>
                                <a href="<?php echo e(URL::to('/location')); ?>" class="btn btn-primary mt-3">Change Location</a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="card mt-3 mx-auto">
                        <div class="card-header d-flex justify-content-between align-items-center"
                             style="background: #D6B62B">
                            <span
                                class="fw-bold">Stores near: <?php echo e($address->address ? $address->address.'-'.$address->city : ($address->street_address ? $address->street_address.'-'.$address->city : $address->city.'-'.$address->state->name)); ?></span>
                        </div>
                        <div class="card-body">
                            <?php $__currentLoopData = $response; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ship): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="mb-4">
                                    <!-- Branch Name -->
                                    <h5 class="text-primary fw-bold border-bottom pb-2">
                                        <i class="fa-solid fa-building"></i> <?php echo e($ship['name']); ?>

                                    </h5>

                                    <!-- Carriers List -->
                                    <?php $__currentLoopData = $ship['carriers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $carrier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="d-flex align-items-center justify-content-between py-2 px-3 bg-light rounded mb-2">
                                            <div>
                                                <h6 class="mb-1 text-secondary">
                                                    <i class="fa-solid fa-truck"></i> <?php echo e($carrier['name']); ?>

                                                </h6>
                                            </div>
                                            <div>
                                                <a href="<?php echo e($carrier['link']); ?>" target="_blank" class="btn btn-sm btn-primary">
                                                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Visit
                                                </a>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <style>
        .form-control {
            padding: 0.33rem .55rem;
            font-size: 13px;
        }
    </style>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/web/delivery.blade.php ENDPATH**/ ?>