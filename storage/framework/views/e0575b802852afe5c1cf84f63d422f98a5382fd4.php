<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th><?php echo e(trans('labels.role_name')); ?></th>
            <th><?php echo e(trans('labels.system_modules')); ?></th>
            <th><?php echo e(trans('labels.status')); ?></th>
            <th><?php echo e(trans('labels.action')); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $i=1; ?>
        <?php $__currentLoopData = $getroles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr id="dataid<?php echo e($role->id); ?>">
                <td><?php echo $i++; ?></td>
                <td><?php echo e($role->name); ?></td>
                <td>
                    <?php $__currentLoopData = explode(',', $role->titles); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="badge rounded-pill bg-light text-dark"><?php echo e($data); ?></span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </td>
                <td>
                    <?php if($role->is_available == 1): ?>
                        <a class="btn btn-sm btn-success square"
                            <?php if(env('Environment') == 'sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="StatusUpdate('<?php echo e($role->id); ?>','2','<?php echo e(URL::to('admin/roles/status')); ?>')" <?php endif; ?>><i
                                class="fa-sharp fa-solid fa-check"></i></a>
                    <?php else: ?>
                        <a class="btn btn-sm btn-danger square"
                            <?php if(env('Environment') == 'sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="StatusUpdate('<?php echo e($role->id); ?>','1','<?php echo e(URL::to('admin/roles/status')); ?>')" <?php endif; ?>><i
                                class="fa-sharp fa-solid fa-xmark"></i></a>
                    <?php endif; ?>
                </td>
                <td>
                    <a class="btn btn-sm btn-info square" href="<?php echo e(URL::to('admin/roles-' . $role->id)); ?>"><i
                            class="fa-solid fa-pen-to-square"></i></a>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/roles/rolestable.blade.php ENDPATH**/ ?>