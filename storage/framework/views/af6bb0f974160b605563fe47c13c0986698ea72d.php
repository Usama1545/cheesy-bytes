<?php $__env->startSection('page_title'); ?>
    | <?php echo e(trans('labels.my_addresses')); ?>

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
                            aria-current="page"><?php echo e(trans('labels.my_addresses')); ?></li>
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
                <div class="col-lg-9 d-flex">
                    <div class="user-content-wrapper">
                        <div class="d-flex flex-wrap gap-2 justify-content-between mb-3 border-bottom pb-3">
                            <p class="col-auto mb-0 title"><?php echo e(trans('labels.my_addresses')); ?></p>
                            <a href="<?php echo e(route('add-address')); ?>"
                                class="col-auto py-2 px-4 text-capitalize btn btn-primary text-white btn btn-sm d-flex align-items-center"><?php echo e(trans('labels.add_new_address')); ?>

                                <i class="fa-solid fa-plus px-2"></i></a>
                        </div>
                        <?php if(count($getaddresses) > 0): ?>
                            <div class="row mb-3">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="rounded-top">
                                            <tr class="bg-light align-middle">
                                                <th class="fs-7 fw-600">#</th>
                                                <th class="fs-7 fw-600"><?php echo e(trans('labels.title')); ?></th>
                                                <th class="fs-7 fw-600"><?php echo e(trans('labels.address')); ?></th>
                                                <th class="fs-7 fw-600"><?php echo e(trans('labels.default')); ?></th>
                                                <th class="fs-7 fw-600"><?php echo e(trans('labels.action')); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody class="rounded-bottom">
                                            <?php $i = 1; ?>
                                            <?php $__currentLoopData = $getaddresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr class="align-middle">
                                                    <td class="fs-7 fw-600"><?php echo $i++; ?></td>
                                                    <td class="fs-7 fw-600"><?php echo e($item->title); ?></td>
                                                    <td class="fs-7"><?php echo e($item->address); ?> </td>
                                                    <td class="fs-7">
                                                        <?php if($item->is_default == 1): ?>
                                                            <a class="btn btn-sm btn-address-status bg-success text-white border-success"
                                                                onclick="StatusUpdate('<?php echo e($item->id); ?>','2','<?php echo e(URL::to('address/status')); ?>')"><i
                                                                    class="fa-sharp fa-solid fa-check"></i></a>
                                                        <?php else: ?>
                                                            <a class="btn btn-sm btn-address-status bg-danger text-white border-danger"
                                                                onclick="StatusUpdate('<?php echo e($item->id); ?>','1','<?php echo e(URL::to('address/status')); ?>')"><i
                                                                    class="fa-sharp fa-solid fa-xmark"></i></a>
                                                        <?php endif; ?>
                                                    </td>

                                                    <td class="fs-7">
                                                        <div class="px-3">
                                                            <a class="text-danger mx-1" href="javascript:void(0)"
                                                                onclick="deleteaddress('<?php echo e($item->id); ?>','<?php echo e(URL::to('/address/delete')); ?> ') "><i
                                                                    class="fa-solid fa-trash-can"></i></a>
                                                            <a class="text-info mx-1"
                                                                href="<?php echo e(URL::to('/address-' . $item->id)); ?>"><i
                                                                    class="fa-solid fa-pen-to-square"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <?php echo e($getaddresses->appends(request()->query())->links()); ?>

                            </div>
                        <?php else: ?>
                            <?php echo $__env->make('web.nodata', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(url(env('ASSETSPATHURL') . 'web-assets/js/custom/address.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/web/address/index.blade.php ENDPATH**/ ?>