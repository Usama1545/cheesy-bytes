<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th></th>
            <th>#</th>
            <th><?php echo e(trans('labels.name')); ?></th>
            <th><?php echo e(trans('labels.selection_type')); ?></th>
            <th><?php echo e(trans('labels.selection_count')); ?></th>
            <th><?php echo e(trans('labels.status')); ?></th>
            <th><?php echo e(trans('labels.created_date')); ?></th>
            <th><?php echo e(trans('labels.updated_date')); ?></th>
            <th><?php echo e(trans('labels.action')); ?></th>
        </tr>
    </thead>
    <tbody id="tabledetails" data-url="<?php echo e(url('admin/addongroup/reorder_addongroup')); ?>">
        <?php $i = 1 ?>
        <?php $__currentLoopData = $getaddongroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addongroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="row1" data-id="<?php echo e($addongroup->id); ?>">
                <td><a tooltip="<?php echo e(trans('labels.move')); ?>"><i class="fa-light fa-up-down-left-right mx-2"></i></a></td>
                <td><?php echo $i++ ?></td>
                <td><a href="<?php echo e(URL::to('admin/addongroup-' . $addongroup->id)); ?>"><?php echo e($addongroup->name); ?></a></td>
                <td>
                    <?php if($addongroup->selection_type == 1): ?>
                        <?php echo e(trans('labels.required')); ?>

                    <?php elseif($addongroup->selection_type == 2): ?>
                        <?php echo e(trans('labels.optional')); ?>

                    <?php endif; ?>
                </td>
                <td>
                    <?php if($addongroup->selection_count == 1): ?>
                        <?php echo e(trans('labels.single')); ?>

                    <?php elseif($addongroup->selection_count == 2): ?>
                        <?php echo e(trans('labels.multiple')); ?>

                        (<?php echo e($addongroup->min_count); ?>)
                    <?php endif; ?>
                </td>
                <td>
                    <?php if($addongroup->is_available == 1): ?>
                        <a class="btn btn-sm btn-success square" tooltip="<?php echo e(trans('labels.active')); ?>"
                            <?php if(env('Environment') == 'sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="StatusUpdate('<?php echo e($addongroup->id); ?>','2','<?php echo e(URL::to('admin/addongroup/status')); ?>')" <?php endif; ?>><i
                                class="fa-sharp fa-solid fa-check"></i></a>
                    <?php else: ?>
                        <a class="btn btn-sm btn-danger square" tooltip="<?php echo e(trans('labels.deactive')); ?>"
                            <?php if(env('Environment') == 'sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="StatusUpdate('<?php echo e($addongroup->id); ?>','1','<?php echo e(URL::to('admin/addongroup/status')); ?>')" <?php endif; ?>><i
                                class="fa-sharp fa-solid fa-xmark"></i></a>
                    <?php endif; ?>
                </td>
                <td>
                    <?php echo e(helper::date_format($addongroup->created_at)); ?> <br>
                    <?php echo e(helper::time_format($addongroup->created_at)); ?>

                </td>
                <td>
                    <?php echo e(helper::date_format($addongroup->updated_at)); ?> <br>
                    <?php echo e(helper::time_format($addongroup->updated_at)); ?>

                </td>
                <td class="branch-only">
                    <div class="d-flex flex-wrap gap-1">
                        <a class="btn btn-sm btn-info square" tooltip="<?php echo e(trans('labels.edit')); ?>"
                            href="<?php echo e(URL::to('admin/addongroup-' . $addongroup->id)); ?>"><i
                                class="fa-solid fa-pen-to-square"></i></a>
                        <a class="btn btn-sm btn-danger square" tooltip="<?php echo e(trans('labels.delete')); ?>"
                            <?php if(env('Environment') == 'sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="Delete('<?php echo e($addongroup->id); ?>','<?php echo e(URL::to('admin/addongroup/delete')); ?>')" <?php endif; ?>><i
                                class="fa fa-trash"></i></a>
                    </div>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/addons-group/addons_grouptable.blade.php ENDPATH**/ ?>