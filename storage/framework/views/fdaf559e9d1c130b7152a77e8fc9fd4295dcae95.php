
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h3>Custom Pizzas</h3>
            <a href="branches/add" class="btn btn-primary">Add New <i class="fa fa-plus"></i></a>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="table-responsive" id="table-display">
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>State</th>
                                    <th>City</th>
                                    <th>Zip Code</th>
                                    <th><?php echo e(trans('labels.action')); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1; ?>
                                <?php $__currentLoopData = $getitem; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="row1" data-id="<?php echo e($item->id); ?>">
                                        <td><?php echo e($item->name); ?></td>
                                        <td><?php echo e($item->state->name); ?></td>
                                        <td>
                                            <?php echo e($item->city); ?> <br>
                                        </td>
                                        <td>
                                            <?php echo e($item->zip); ?>

                                        </td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-1">
                                                <a class="btn btn-sm btn-info square" tooltip="<?php echo e(trans('labels.edit')); ?>"
                                                   href="<?php echo e(URL::to('admin/branches-' . $item->id)); ?>"> <i class="fa-solid fa-pen-to-square"></i></a>
                                                <a class="btn btn-sm btn-danger square" tooltip="<?php echo e(trans('labels.delete')); ?>"
                                                   <?php if(env('Environment') == 'sendbox'): ?> onclick="myFunction()"
                                                   <?php else: ?> onclick="Delete('<?php echo e($item->id); ?>','<?php echo e(URL::to('admin/custom_pizza/delete')); ?>')" <?php endif; ?>>
                                                    <i class="fa fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.theme.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/branches/index.blade.php ENDPATH**/ ?>