
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h3>Pizza Sizes and Crusts</h3>
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
                                    <th>SubCategory</th>
                                    <th><?php echo e(trans('labels.action')); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1; ?>
                                <?php $__currentLoopData = $item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="row1" data-id="<?php echo e($item->id); ?>">
                                        <td><?php echo e($item->item_name); ?></td>
                                        <td><?php echo e($item->subcategory_info?->subcategory_name); ?></td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-1">
                                                <a class="btn btn-sm btn-info square" tooltip="<?php echo e(trans('labels.edit')); ?>"
                                                   href="<?php echo e(URL::to('admin/pizza_crusts-' . $item->id)); ?>"> <i class="fa-solid fa-pen-to-square"></i></a>

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

<?php echo $__env->make('admin.theme.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/pizza-pricing/index.blade.php ENDPATH**/ ?>