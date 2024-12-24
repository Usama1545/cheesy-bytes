<?php
$ran = ['gradient-1', 'gradient-2', 'gradient-3', 'gradient-4', 'gradient-5', 'gradient-6', 'gradient-7', 'gradient-8', 'gradient-9'];
?>
<table class="table">
    <thead>
        <tr>
            <th><?php echo e(trans('labels.image')); ?></th>
            <th><?php echo e(trans('labels.item_name')); ?></th>
            <th><?php echo e(trans('labels.category')); ?></th>
            <th><?php echo e(trans('labels.orders')); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        <?php $__currentLoopData = $topitems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($item->item_order_counter > 0): ?>
                <tr>
                    <td><img src="<?php echo e(helper::image_path($item['item_image']->image_name)); ?>" class="rounded h-50px" alt=""></td>
                    <td><a href="<?php echo e(URL::to('admin/item-'.$item->id)); ?>"><?php echo e($item->item_name); ?></a></td>
                    <td><?php echo e(@$item['category_info']->category_name); ?></td>
                    <td>
                        <?php
                            $per = ($item->item_order_counter * 100) / count(@$getorderdetailscount);
                        ?>
                        <?php echo e(number_format($per,2)); ?>%
                        <div class="progress h-10-px">
                            <div class="progress-bar <?php echo e($ran[array_rand($ran, 1)]); ?>"
                                style="width: <?php echo e($per); ?>%;" role="progressbar"><span
                                    class="sr-only"><?php echo e($per); ?>% <?php echo e(trans('labels.orders')); ?></span>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/dashboard/topproducttable.blade.php ENDPATH**/ ?>