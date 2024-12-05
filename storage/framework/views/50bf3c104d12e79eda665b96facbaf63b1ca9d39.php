<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th></th>
            <th>#</th>
            <th><?php echo e(trans('labels.image')); ?></th>
            <th><?php echo e(trans('labels.title')); ?></th>
            <th><?php echo e(trans('labels.category')); ?></th>
            <th><?php echo e(trans('labels.item')); ?></th>
            <th><?php echo e(trans('labels.description')); ?></th>
            <th><?php echo e(trans('labels.status')); ?></th>
            <th><?php echo e(trans('labels.created_date')); ?></th>
            <th><?php echo e(trans('labels.updated_date')); ?></th>
            <th><?php echo e(trans('labels.action')); ?></th>
        </tr>
    </thead>
    <tbody id="tabledetails" data-url="<?php echo e(url('admin/slider/reorder_slider')); ?>">
        <?php $i = 1; ?>
        <?php $__currentLoopData = $getslider; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="row1" data-id="<?php echo e($slider->id); ?>">
                <td><a tooltip="<?php echo e(trans('labels.move')); ?>"><i class="fa-light fa-up-down-left-right mx-2"></i></a></td>
                <td><?php echo $i++; ?></td>
                <td><img src='<?php echo e(helper::image_path($slider->image)); ?>' class='img-fluid rounded h-50px'></td>
                <td><?php echo e($slider->title); ?></td>
                <td>
                    <?php if($slider->type == '1'): ?>
                        <?php echo e(@$slider['category_info']->category_name); ?>

                    <?php else: ?>
                        --
                    <?php endif; ?>
                </td>
                <td>
                    <?php if($slider->type == '2'): ?>
                        <?php echo e(@$slider['item_info']->item_name); ?>

                    <?php else: ?>
                        --
                    <?php endif; ?>
                </td>
                <td><?php echo e($slider->description); ?></td>
                <td>
                    <?php if($slider->is_available == 1): ?>
                        <a class="btn btn-sm btn-success square" tooltip="<?php echo e(trans('labels.active')); ?>"
                            <?php if(env('Environment') == 'sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="StatusUpdate('<?php echo e($slider->id); ?>','2','<?php echo e(URL::to('admin/slider/status')); ?>')" <?php endif; ?>><i
                                class="fa-sharp fa-solid fa-check"></i></a>
                    <?php else: ?>
                        <a class="btn btn-sm btn-danger square" tooltip="<?php echo e(trans('labels.deactive')); ?>"
                            <?php if(env('Environment') == 'sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="StatusUpdate('<?php echo e($slider->id); ?>','1','<?php echo e(URL::to('admin/slider/status')); ?>')" <?php endif; ?>><i
                                class="fa-sharp fa-solid fa-xmark"></i></a>
                    <?php endif; ?>
                </td>
                <td>
                    <?php echo e(helper::date_format($slider->created_at)); ?> <br>
                    <?php echo e(helper::time_format($slider->created_at)); ?>

                </td>
                <td>
                    <?php echo e(helper::date_format($slider->updated_at)); ?> <br>
                    <?php echo e(helper::time_format($slider->updated_at)); ?>

                </td>
                <td>
                    <div class="d-flex flex-wrap gap-1 ">
                        <a class="btn btn-sm btn-info square" tooltip="<?php echo e(trans('labels.edit')); ?>"
                            href="<?php echo e(URL::to('admin/slider-' . $slider->id)); ?>"><i
                                class="fa-solid fa-pen-to-square"></i></a>
                        <a class="btn btn-sm btn-danger square" tooltip="<?php echo e(trans('labels.delete')); ?>"
                            href="javascript:void(0)"
                            <?php if(env('Environment') == 'sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="DeleteData('<?php echo e($slider->id); ?>','<?php echo e(URL::to('admin/slider/destroy')); ?>')" <?php endif; ?>><i
                                class="fa fa-trash"></i></a>
                    </div>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/slider/slidertable.blade.php ENDPATH**/ ?>