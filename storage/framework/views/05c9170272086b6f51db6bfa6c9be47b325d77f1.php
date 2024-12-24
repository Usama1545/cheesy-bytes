<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th></th>
            <th>#</th>
            <th><?php echo e(trans('labels.rating')); ?></th>
            <th><?php echo e(trans('labels.description')); ?></th>
            <th><?php echo e(trans('labels.created_date')); ?></th>
            <th><?php echo e(trans('labels.updated_date')); ?></th>
            <th><?php echo e(trans('labels.action')); ?></th>
        </tr>
    </thead>
    <tbody id="tabledetails" data-url="<?php echo e(url('admin/store-review/reorder_ratting')); ?>">
        <?php $i = 1; ?>
        <?php $__currentLoopData = $getstorereviewlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $storereview): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="row1" data-id="<?php echo e($storereview->id); ?>">
                <td><a tooltip="<?php echo e(trans('labels.move')); ?>"><i class="fa-light fa-up-down-left-right mx-2"></i></a></td>
                <td><?php echo $i++; ?></td>

                <td> <?php echo e($storereview->ratting); ?> </td>
                <td> <?php echo e($storereview->comment); ?> </td>
                <td>
                    <?php echo e(helper::date_format($storereview->created_at)); ?> <br>
                    <?php echo e(helper::time_format($storereview->created_at)); ?>

                </td>
                <td>
                    <?php echo e(helper::date_format($storereview->updated_at)); ?> <br>
                    <?php echo e(helper::time_format($storereview->updated_at)); ?>

                </td>
                <td>
                    <div class="d-flex flex-wrap gap-1">



                        <a class="btn btn-sm btn-danger square" tooltip="<?php echo e(trans('labels.delete')); ?>"
                            href="javascript:void(0)"
                            <?php if(env('Environment') == 'sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="DeleteData('<?php echo e($storereview->id); ?>','<?php echo e(URL::to('admin/store-review/destroy')); ?>')" <?php endif; ?>>
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </div>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/store_review/table.blade.php ENDPATH**/ ?>