<table class="table table-striped table-bordered py-3 zero-configuration w-100">
    <thead>
        <tr class="text-uppercase fw-500">
            <th></th>
            <th>#</th>
            <th><?php echo e(trans('labels.area_name')); ?></th>
            <th><?php echo e(trans('labels.delivery_charge')); ?></th>
            <th><?php echo e(trans('labels.created_date')); ?></th>
            <th><?php echo e(trans('labels.updated_date')); ?></th>
            <th><?php echo e(trans('labels.action')); ?></th>
        </tr>
    </thead>
    <tbody id="tabledetails" data-url="<?php echo e(url('admin/shippingarea/reorder_shippingarea')); ?>">
        <?php $i=1; ?>
        <?php $__currentLoopData = $shippingarealist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shippingarea): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="row1" data-id="<?php echo e($shippingarea->id); ?>">
                <td><a tooltip="<?php echo e(trans('labels.move')); ?>"><i class="fa-light fa-up-down-left-right mx-2"></i></a></td>
                <td><?php echo $i++ ?></td>
                <td><?php echo e($shippingarea->name); ?></td>
                <td><?php echo e(helper::currency_format($shippingarea->delivery_charge, $shippingarea->vendor_id)); ?>

                </td>
                <td><?php echo e(helper::date_format($shippingarea->created_at)); ?><br>
                    <?php echo e(helper::time_format($shippingarea->created_at)); ?>

                </td>
                <td><?php echo e(helper::date_format($shippingarea->updated_at)); ?><br>
                    <?php echo e(helper::time_format($shippingarea->updated_at)); ?>

                </td>
                <td>
                    <div class="d-flex flex-wrap gap-1">
                        <a href="<?php echo e(URL::to('admin/shippingarea-' . $shippingarea->id)); ?>"
                            tooltip="<?php echo e(trans('labels.edit')); ?>" class="btn btn-info square">
                            <i class="fa-solid fa-pen-to-square"></i></a>
    
                        <a href="javascript:void(0)" tooltip="<?php echo e(trans('labels.delete')); ?>"
                            <?php if(env('Environment') == 'sendbox'): ?> onclick="myFunction()" 
                            <?php else: ?> onclick="Delete('<?php echo e($shippingarea->id); ?>','<?php echo e(URL::to('/admin/shippingarea/delete')); ?>')" <?php endif; ?>
                            class="btn btn-danger square"> <i class="fa-solid fa-trash"></i></a>
                    </div>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/shippingarea/shippingareatable.blade.php ENDPATH**/ ?>