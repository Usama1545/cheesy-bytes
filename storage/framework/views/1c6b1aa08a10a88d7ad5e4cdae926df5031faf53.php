<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th><?php echo e(trans('labels.name')); ?></th>
            <th><?php echo e(trans('labels.email')); ?></th>
            <th><?php echo e(trans('labels.mobile')); ?></th>
            <th><?php echo e(trans('labels.referral_code')); ?></th>
            <th><?php echo e(trans('labels.login_with')); ?></th>
            <th><?php echo e(trans('labels.otp_status')); ?></th>
            <th><?php echo e(trans('labels.status')); ?></th>
            <th><?php echo e(trans('labels.action')); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        <?php $__currentLoopData = $getusers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $users): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td> <?php echo e($users->name); ?> </td>
                <td> <?php echo e($users->email); ?> </td>
                <td> <?php echo e($users->mobile); ?> </td>
                <td> <?php echo e($users->referral_code); ?> </td>
                <td>
                    <?php if($users->login_type == 'facebook'): ?>
                        <?php echo e(trans('labels.facebook')); ?>

                    <?php elseif($users->login_type == 'google'): ?>
                        <?php echo e(trans('labels.google')); ?>

                    <?php else: ?>
                        <?php echo e(trans('labels.email')); ?>

                    <?php endif; ?>
                </td>
                <td><?php echo e($users->is_verified == '1' ? trans('labels.verified') : trans('labels.unverified')); ?></td>
                <td>
                    <?php if($users->is_available == 1): ?>
                        <a class="btn btn-sm btn-success square" tooltip="<?php echo e(trans('labels.active')); ?>"
                            <?php if(env('Environment') == 'sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="StatusUpdate('<?php echo e($users->id); ?>','2','<?php echo e(URL::to('admin/users/status')); ?>')" <?php endif; ?>>
                            <i class="fa-sharp fa-solid fa-check"></i></a>
                    <?php else: ?>
                        <a class="btn btn-sm btn-danger square" tooltip="<?php echo e(trans('labels.deactive')); ?>"
                            <?php if(env('Environment') == 'sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="StatusUpdate('<?php echo e($users->id); ?>','1','<?php echo e(URL::to('admin/users/status')); ?>')" <?php endif; ?>>
                            <i class="fa-sharp fa-solid fa-xmark"></i></a>
                    <?php endif; ?>
                </td>
                <td>
                    <div class="d-flex flex-wrap gap-1">
                        <a class="btn btn-sm btn-info square" tooltip="<?php echo e(trans('labels.edit')); ?>"
                            href="<?php echo e(URL::to('admin/users-' . $users->id)); ?>">
                            <i class="fa fa-pen-to-square"></i></a>
                        <a class="btn btn-sm btn-dark square" tooltip="<?php echo e(trans('labels.view')); ?>"
                            href="<?php echo e(URL::to('admin/users/details-' . $users->id)); ?>">
                            <i class="fa-solid fa-eye"></i></a>
                        <a class="btn btn-sm btn-danger square" tooltip="<?php echo e(trans('labels.delete')); ?>"
                            onclick="StatusUpdate('<?php echo e($users->id); ?>','','<?php echo e(URL::to('admin/users/delete')); ?>')">
                            <i class="fa-solid fa-trash"></i></a>
                    </div>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/users/table.blade.php ENDPATH**/ ?>