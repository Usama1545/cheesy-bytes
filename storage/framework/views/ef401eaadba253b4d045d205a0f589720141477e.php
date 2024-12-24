<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h3>Dipping</h3>
            <a href="topDeals/add" class="btn btn-primary">Add New <i class="fa fa-plus"></i></a>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="table-responsive" id="table-display">
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Offer Type</th>
                                    <th>Offer Amount</th>
                                    <th>Start Date /Time</th>
                                    <th>End Date / Time</th>
                                    <th><?php echo e(trans('labels.action')); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1; ?>
                                <?php $__currentLoopData = $deals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="row1" data-id="<?php echo e($item->id); ?>">
                                        <td><?php echo e($item->product->item_name); ?></td>
                                        <td><?php echo e($item->offer_type === 1 ? 'Flat Price' : "Percentage"); ?></td>
                                        <td><?php echo e($item->offer_amount); ?></td>
                                        <td>
                                            <?php echo e(helper::date_format($item->start_date)); ?> <br>
                                            <?php echo e(helper::time_format($item->start_time)); ?>

                                        </td>
                                        <td>
                                            <?php echo e(helper::date_format($item->end_date)); ?> <br>
                                            <?php echo e(helper::time_format($item->end_time)); ?>

                                        </td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-1">
                                                <a class="btn btn-sm btn-info square"
                                                   tooltip="<?php echo e(trans('labels.edit')); ?>"
                                                   href="<?php echo e(URL::to('admin/topDeals-' . $item->id)); ?>"> <i
                                                        class="fa-solid fa-pen-to-square"></i></a>
                                                <a class="btn btn-sm btn-danger square"
                                                   tooltip="<?php echo e(trans('labels.delete')); ?>"
                                                   onclick="Delete('<?php echo e($item->id); ?>','<?php echo e(URL::to('admin/topDeals/delete')); ?>')">
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
    <script>
        function Delete(id, deleteurl) {
            "use strict";
            swalWithBootstrapButtons.fire({
                icon: 'warning',
                title: are_you_sure,
                showCancelButton: true,
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonText: yes,
                cancelButtonText: no,
                reverseButtons: true,
                showLoaderOnConfirm: true,
                preConfirm: function () {
                    return new Promise(function (resolve, reject) {
                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            url: deleteurl,
                            data: {id: id},
                            method: 'POST',
                            success: function (response) {
                                if (response == 1) {
                                    location.reload();
                                } else {
                                    swal_cancelled()
                                }
                            },
                            error: function (e) {
                                swal_cancelled()
                            }
                        });
                    });
                },
            }).then((result) => {
                if (!result.isConfirmed) {
                    result.dismiss === Swal.DismissReason.cancel
                }
            })
        }

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.theme.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/topDeals/item.blade.php ENDPATH**/ ?>