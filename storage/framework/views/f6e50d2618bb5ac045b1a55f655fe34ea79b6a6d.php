<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th></th>
            <th>#</th>
            <th><?php echo e(trans('labels.name')); ?></th>
            <th><?php echo e(trans('labels.price')); ?></th>
            <th><?php echo e(trans('labels.status')); ?></th>
            <th><?php echo e(trans('labels.created_date')); ?></th>
            <th><?php echo e(trans('labels.updated_date')); ?></th>
            <th><?php echo e(trans('labels.action')); ?></th>
        </tr>
    </thead>
    <tbody id="tabledetails" data-url="<?php echo e(url('admin/global_extras/reorder_global')); ?>">
        <?php $i=1; ?>
        <?php $__currentLoopData = $globals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $extras): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="row1" id="dataid<?php echo e($extras->id); ?>" data-id="<?php echo e($extras->id); ?>">
                <td><a tooltip="<?php echo e(trans('labels.move')); ?>"><i class="fa-light fa-up-down-left-right mx-2"></i></a></td>
                <td><?php echo $i++ ?></td>
                <td><?php echo e($extras->name); ?></td>
                <td><?php echo e(helper::currency_format($extras->price)); ?></td>
                <td>
                    <?php if($extras->is_available == 1): ?>
                        <a class="btn btn-sm btn-success square hov" tooltip="<?php echo e(trans('labels.active')); ?>"
                            <?php if(env('Environment') == 'sendbox'): ?> onclick="myFunction()" <?php else: ?>  onclick="StatusUpdate('<?php echo e($extras->id); ?>','2','<?php echo e(URL::to('admin/global_extras/status')); ?>')" <?php endif; ?>><i
                                class="fa-sharp fa-solid fa-check"></i></a>
                    <?php else: ?>
                        <a class="btn btn-sm btn-danger square hov" tooltip="<?php echo e(trans('labels.deactive')); ?>"
                            <?php if(env('Environment') == 'sendbox'): ?> onclick="myFunction()" <?php else: ?>  onclick="StatusUpdate('<?php echo e($extras->id); ?>','1','<?php echo e(URL::to('admin/global_extras/status')); ?>')" <?php endif; ?>><i
                                class="fa-sharp fa-solid fa-xmark"></i></a>
                    <?php endif; ?>
                </td>
                <td><?php echo e(helper::date_format($extras->created_at)); ?><br>
                    <?php echo e(helper::time_format($extras->created_at)); ?>

                </td>
                <td><?php echo e(helper::date_format($extras->updated_at)); ?><br>
                    <?php echo e(helper::time_format($extras->updated_at)); ?>

                </td>
                <td>
                    <div class="d-flex flex-wrap gap-1">
                        <a href="<?php echo e(URL::to('admin/global_extras-' . $extras->id)); ?>" tooltip="<?php echo e(trans('labels.edit')); ?>"
                            class="btn btn-info square btn-sm hov">
                            <i class="fa fa-pen-to-square"></i></a>
    
                        <a class="btn btn-sm btn-danger square hov" tooltip="<?php echo e(trans('labels.delete')); ?>"
                            <?php if(env('Environment') == 'sendbox'): ?> onclick="myFunction()" <?php else: ?>  onclick="Delete('<?php echo e($extras->id); ?>','<?php echo e(URL::to('admin/global_extras/delete')); ?>')" <?php endif; ?>><i
                                class="fa fa-trash"></i></a>
                    </div>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/global_extras/global_extrastable.blade.php ENDPATH**/ ?>