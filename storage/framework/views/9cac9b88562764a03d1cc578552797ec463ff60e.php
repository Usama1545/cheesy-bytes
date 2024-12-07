<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th><?php echo e(trans('labels.date')); ?></th>
            <th><?php echo e(trans('labels.description')); ?></th>
            <th><?php echo e(trans('labels.amount')); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        <?php $__currentLoopData = $gettransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tdata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo e(helper::date_format($tdata->created_at)); ?></td>
                <td>
                    <?php if(in_array($tdata->transaction_type, [101, 102, 103])): ?>
                        <?php echo e(trans('labels.wallet_recharge')); ?>

                        [
                            <?php if($tdata->transaction_type == 102): ?>
                                <?php echo e(trans('labels.added_by_admin')); ?>

                            <?php elseif($tdata->transaction_type == 103): ?>
                                <?php echo e(trans('labels.deducted_by_admin')); ?>

                            <?php endif; ?>
                        ]
                    <?php elseif(in_array($tdata->transaction_type, [3, 4, 5, 6 , 7, 8, 9, 10, 11, 12, 13, 14])): ?>
                        <?php echo e(helper::getpayment($tdata->transaction_type)); ?>

                        <?php echo e($tdata->transaction_id); ?>

                    <?php elseif($tdata->transaction_type == 2): ?>
                        <?php echo e(trans('labels.order_cancelled')); ?>

                    <?php elseif($tdata->transaction_type == 1): ?>
                        <?php echo e(trans('labels.order_placed')); ?>

                    <?php elseif($tdata->transaction_type == 101): ?>
                        <?php echo e(trans('labels.referral_earning')); ?>

                        [<?php echo e($tdata->username); ?>]
                    <?php else: ?>
                        -
                    <?php endif; ?>
                    <?php if(in_array($tdata->transaction_type, [1, 2])): ?>
                        [<?php echo e($tdata->order_number); ?>]
                    <?php endif; ?>
                </td>
                <td
                    class="<?php echo e(in_array($tdata->transaction_type, [102, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]) == true ? 'text-success' : 'text-danger'); ?>">
                    <?php echo e(helper::currency_format($tdata->amount)); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/users/transactiontable.blade.php ENDPATH**/ ?>