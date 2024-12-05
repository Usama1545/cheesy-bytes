<?php $__env->startSection('page_title'); ?>
    | <?php echo e(trans('labels.my_wallet')); ?>

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
                            aria-current="page"><?php echo e(trans('labels.my_wallet')); ?></li>
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
                        <div
                            class="d-flex flex-wrap gap-2 align-items-center justify-content-between mb-3 border-bottom pb-3">
                            <div class="col-auto">
                                <p class="title mb-0"><?php echo e(trans('labels.my_wallet')); ?> :- <small
                                        class="green_color"><?php echo e(helper::currency_format(Auth::user()->wallet)); ?></small></p>
                            </div>
                            <div class="col-auto"><a href="<?php echo e(route('add-money')); ?>"
                                    class="btn btn-sm text-white bg-primary px-4 py-2"><i
                                        class="fa-solid fa-plus px-1"></i><?php echo e(trans('labels.add_money')); ?></a></div>
                        </div>
                        <div class="border-bottom">
                            <ul class="mb-3">
                                <li><i
                                        class="fa-regular fa-circle-check mx-2 text-success"></i><?php echo e(trans('labels.fast_payment')); ?>

                                </li>
                                <li><i
                                        class="fa-regular fa-circle-check mx-2 text-success"></i><?php echo e(trans('labels.secure_payment')); ?>

                                </li>
                                <li><i
                                        class="fa-regular fa-circle-check mx-2 text-success"></i><?php echo e(trans('labels.no_document_required')); ?>

                                </li>
                                <li><i
                                        class="fa-regular fa-circle-check mx-2 text-success"></i><?php echo e(trans('labels.wallet_note')); ?>

                                </li>
                            </ul>
                        </div>
                        <?php if(count($gettransactions) > 0): ?>
                            <div class="row mb-3">
                                <div class="table-responsive wallet-history">
                                    <table class="table table-hover">
                                        <thead class="rounded-top">
                                            <tr class="bg-light text-center align-middle">
                                                <th class="fs-7 fw-600"><?php echo e(trans('labels.date')); ?></th>
                                                <th class="fs-7 fw-600"><?php echo e(trans('labels.amount')); ?></th>
                                                <th class="fs-7 fw-600"><?php echo e(trans('labels.description')); ?></th>
                                                <th class="fs-7 fw-600"><?php echo e(trans('labels.status')); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody class="rounded-bottom">
                                            <?php $__currentLoopData = $gettransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tdata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr class="text-center align-middle">
                                                    <td class="fs-7"><?php echo e(helper::date_format($tdata->created_at)); ?></td>
                                                    <td
                                                    class="fs-7 <?php echo e(in_array($tdata->transaction_type, [101, 102, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]) == true ? 'text-success' : 'text-danger'); ?>">
                                                    <?php echo e(helper::currency_format($tdata->amount)); ?></td>
                                                    <td class="fs-7 w-410">

                                                        <?php if(in_array($tdata->transaction_type, [101, 102, 103])): ?>
                                                            <?php if($tdata->transaction_type == 101): ?>
                                                                <?php echo e(trans('labels.referral_earning')); ?>

                                                                [<?php echo e($tdata->username); ?>]
                                                            <?php elseif($tdata->transaction_type == 102): ?>
                                                                <?php echo e(trans('labels.wallet_recharge')); ?>

                                                                <?php echo e(trans('labels.added_by_admin')); ?>

                                                            <?php elseif($tdata->transaction_type == 103): ?>
                                                                <?php echo e(trans('labels.deducted_by_admin')); ?>

                                                            <?php endif; ?>
                                                        <?php elseif(in_array($tdata->transaction_type, [3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14])): ?>
                                                            <?php echo e(trans('labels.wallet_recharge')); ?>

                                                            <?php echo e(helper::getpayment($tdata->transaction_type)); ?>

                                                            <?php echo e($tdata->transaction_id); ?>

                                                        <?php elseif($tdata->transaction_type == 2): ?>
                                                            <?php echo e(trans('labels.order_cancelled')); ?>

                                                        <?php elseif($tdata->transaction_type == 1): ?>
                                                            <?php echo e(trans('labels.order_placed')); ?>

                                                        <?php else: ?>
                                                            -
                                                        <?php endif; ?>
                                                        <?php if(in_array($tdata->transaction_type, [1, 2])): ?>
                                                            [<?php echo e($tdata->order_number); ?>]
                                                        <?php endif; ?>
                                                    </td>

                                                    <td>
                                                        <?php if(in_array($tdata->transaction_type, [101, 102, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14])): ?>
                                                            <div class="badge bg-debit custom-badge rounded-0 bg-completed rounded-1">
                                                                <span class="fw-400"><?php echo e(trans('labels.credit')); ?></span>
                                                            </div>
                                                        <?php else: ?>
                                                            <div class="badge bg-debit custom-badge bg-cancelled rounded-0 rounded-1">
                                                                <span class="fw-400"><?php echo e(trans('labels.debit')); ?></span>
                                                            </div>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <?php echo e($gettransactions->links()); ?>

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

<?php echo $__env->make('web.layout.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/web/wallet/index.blade.php ENDPATH**/ ?>