<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th></th>
            <th>#</th>
            <th><?php echo e(trans('labels.image')); ?></th>
            <th><?php echo e(trans('labels.category')); ?></th>
            <th><?php echo e(trans('labels.item')); ?></th>
            <th><?php echo e(trans('labels.status')); ?></th>
            <th><?php echo e(trans('labels.created_date')); ?></th>
            <th><?php echo e(trans('labels.updated_date')); ?></th>
            <th><?php echo e(trans('labels.action')); ?></th>
        </tr>
    </thead>
    <tbody id="tabledetails" data-url="<?php echo e(url('admin/banner/reorder_banner')); ?>">
        <?php $i = 1; ?>
        <?php $__currentLoopData = $getbanner; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($banner->section == $section): ?>
                <tr class="row1" data-id="<?php echo e($banner->id); ?>">
                    <td><a tooltip="<?php echo e(trans('labels.move')); ?>"><i class="fa-light fa-up-down-left-right mx-2"></i></a>
                    </td>
                    <td><?php echo $i++; ?></td>
                    <td><img src='<?php echo e(helper::image_path($banner->image)); ?>' class='img-fluid rounded h-50px'></td>
                    <td>
                        <?php if($banner->type == '1'): ?>
                            <?php echo e(@$banner['category_info']->category_name); ?>

                        <?php else: ?>
                            --
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($banner->type == '2'): ?>
                            <?php echo e(@$banner['item_info']->item_name); ?>

                        <?php else: ?>
                            --
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($banner->is_available == 1): ?>
                            <a class="btn btn-sm btn-success square" tooltip="<?php echo e(trans('labels.active')); ?>"
                                <?php if(env('Environment') == 'sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="StatusUpdate('<?php echo e($banner->id); ?>','2','<?php echo e(URL::to('admin/banner/status')); ?>')" <?php endif; ?>><i
                                    class="fa-sharp fa-solid fa-check"></i></a>
                        <?php else: ?>
                            <a class="btn btn-sm btn-danger square" tooltip="<?php echo e(trans('labels.deactive')); ?>"
                                <?php if(env('Environment') == 'sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="StatusUpdate('<?php echo e($banner->id); ?>','1','<?php echo e(URL::to('admin/banner/status')); ?>')" <?php endif; ?>><i
                                    class="fa-sharp fa-solid fa-xmark"></i></a>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php echo e(helper::date_format($banner->created_at)); ?> <br>
                        <?php echo e(helper::time_format($banner->created_at)); ?>

                    </td>
                    <td>
                        <?php echo e(helper::date_format($banner->updated_at)); ?> <br>
                        <?php echo e(helper::time_format($banner->updated_at)); ?>

                    </td>
                    <td>
                        <div class="d-flex flex-wrap gap-1">
                            <a class="btn btn-sm btn-info square" tooltip="<?php echo e(trans('labels.edit')); ?>"
                                href="<?php echo e(URL::to('admin/bannersection-' . $banner->section . '-' . $banner->id)); ?>"><i
                                    class="fa-solid fa-pen-to-square"></i></a>
                            <a class="btn btn-sm btn-danger square" tooltip="<?php echo e(trans('labels.delete')); ?>"
                                href="javascript:void(0)"
                                <?php if(env('Environment') == 'sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="DeleteData('<?php echo e($banner->id); ?>','<?php echo e(URL::to('admin/banner/destroy')); ?>')" <?php endif; ?>><i
                                    class="fa fa-trash"></i></a>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/banner/bannertable.blade.php ENDPATH**/ ?>