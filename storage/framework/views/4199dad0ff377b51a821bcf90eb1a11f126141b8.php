<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th></th>
            <th>#</th>
            <th><?php echo e(trans('labels.subcategory')); ?></th>
            <th><?php echo e(trans('labels.category')); ?></th>
            <th><?php echo e(trans('labels.status')); ?></th>
            <th><?php echo e(trans('labels.created_date')); ?> </th>
            <th><?php echo e(trans('labels.updated_date')); ?> </th>
            <th><?php echo e(trans('labels.action')); ?></th>
        </tr>
    </thead>
    <tbody id="tabledetails" data-url="<?php echo e(url('admin/sub-category/reorder_subcategory')); ?>">
        <?php $i = 1; ?>
        <?php $__currentLoopData = $getsubcategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="row1" data-id="<?php echo e($category->id); ?>">
                <td><a tooltip="<?php echo e(trans('labels.move')); ?>"><i class="fa-light fa-up-down-left-right mx-2"></i></a></td>
                <td><?php echo $i++; ?></td>
                <td><?php echo e($category->subcategory_name); ?></td>
                <td><?php echo e(@$category['category_info']->category_name); ?></td>
                <td>
                    <?php if($category->is_available == 1): ?>
                        <a class="btn btn-sm btn-success square" tooltip="<?php echo e(trans('labels.active')); ?>"
                            <?php if(env('Environment') == 'sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="StatusUpdate('<?php echo e($category->id); ?>','2','<?php echo e(URL::to('admin/sub-category/status')); ?>')" <?php endif; ?>><i
                                class="fa-sharp fa-solid fa-check"></i></a>
                    <?php else: ?>
                        <a class="btn btn-sm btn-danger square" tooltip="<?php echo e(trans('labels.deactive')); ?>"
                            <?php if(env('Environment') == 'sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="StatusUpdate('<?php echo e($category->id); ?>','1','<?php echo e(URL::to('admin/sub-category/status')); ?>')" <?php endif; ?>><i
                                class="fa-sharp fa-solid fa-xmark"></i></a>
                    <?php endif; ?>
                </td>
                <td>
                    <?php echo e(helper::date_format($category->created_at)); ?> <br>
                    <?php echo e(helper::time_format($category->created_at)); ?>

                </td>
                <td>
                    <?php echo e(helper::date_format($category->updated_at)); ?> <br>
                    <?php echo e(helper::time_format($category->updated_at)); ?>

                </td>
                <td>
                    <div class="d-flex flex-wrap gap-1">
                        <a class="btn btn-sm btn-info square" tooltip="<?php echo e(trans('labels.edit')); ?>"
                            href="<?php echo e(URL::to('admin/sub-category-' . $category->id)); ?>"><i
                                class="fa-solid fa-pen-to-square"></i></a>
                        <a class="btn btn-sm btn-danger square" tooltip="<?php echo e(trans('labels.delete')); ?>"
                            <?php if(env('Environment') == 'sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="Delete('<?php echo e($category->id); ?>','<?php echo e(URL::to('admin/sub-category/delete')); ?>')" <?php endif; ?>><i
                                class="fa fa-trash"></i></a>
                    </div>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/subcategory/table.blade.php ENDPATH**/ ?>