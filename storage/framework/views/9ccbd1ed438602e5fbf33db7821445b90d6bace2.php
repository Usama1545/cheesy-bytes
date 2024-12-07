<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="accordion accordion-flush sort_menu" id="accordionExample"
                            data-url="<?php echo e(url('admin/payment/reorder_payment')); ?>">
                            <?php
                                $i = 1;
                            ?>
                            <?php $__currentLoopData = $getpayment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $pmdata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    // Check if the current $pmdata is a system addon and activated
                                    if ($pmdata->payment_type == '1' || $pmdata->payment_type == '2') {
                                        $systemAddonActivated = true;
                                    } else {
                                        $systemAddonActivated = false;
                                    }
                                    $addon = App\Models\SystemAddons::where(
                                        'unique_identifier',
                                        $pmdata->unique_identifier,
                                    )->first();
                                    if ($addon != null && $addon->activated == 1) {
                                        $systemAddonActivated = true;
                                    }
                                ?>
                                <?php if($systemAddonActivated): ?>
                                    <form action="<?php echo e(URL::to('admin/payment/update')); ?>" method="POST" class="payments"
                                        data-id="<?php echo e($pmdata->id); ?>" enctype="multipart/form-data">
                                        <?php echo csrf_field(); ?>
                                        <?php
                                            $transaction_type = $pmdata->payment_type;
                                            $image_tag_name = $transaction_type . '_image';
                                        ?>
                                        <input type="hidden" name="payment_id" value="<?php echo e($pmdata->payment_type); ?>">
                                        <div class="payment-accordian card rounded border mb-3 handle">
                                            <h6 class="card-header text-white d-flex align-items-center rounded border-0 justify-content-between"
                                                id="heading<?php echo e($transaction_type); ?>">
                                                <div>
                                                    <img src="<?php echo e(helper::image_path($pmdata->image)); ?>" alt=""
                                                        class="img-fluid rounded mx-2" height="30" width="30">
                                                    <b><?php echo e($pmdata->payment_name); ?></b>

                                                    <?php if(in_array($transaction_type, ['3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14'])): ?>
                                                        <?php if(env('Environment') == 'sendbox'): ?>
                                                            <span
                                                                class="badge badge bg-danger ms-2"><?php echo e(trans('labels.addon')); ?></span>
                                                        <?php endif; ?>
                                                    <?php endif; ?>

                                                </div>
                                                <a class="cursor-pointer" tooltip="<?php echo e(trans('labels.move')); ?>">
                                                    <i class="fa-light fa-up-down-left-right text-white"></i></a>
                                            </h6>

                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        <label class="form-label">
                                                            <?php echo e(trans('labels.payment_name')); ?> <span class="text-danger">
                                                                *</span> </label>
                                                        <input type="text" class="form-control" name="name"
                                                            placeholder="<?php echo e(trans('labels.payment_name')); ?>"
                                                            value="<?php echo e($pmdata->payment_name); ?>" required>
                                                    </div>
                                                    <?php if(in_array($transaction_type, ['3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14'])): ?>
                                                        <div class="col-md-6">
                                                            <p class="form-label"><?php echo e(trans('labels.environment')); ?>

                                                                <span class="text-danger"> *</span>
                                                            </p>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="environment[<?php echo e($transaction_type); ?>]"
                                                                    id="<?php echo e($transaction_type); ?>_<?php echo e($key); ?>_environment"
                                                                    value="1" required
                                                                    <?php echo e($pmdata->environment == 1 ? 'checked' : ''); ?>>
                                                                <label class="form-check-label"
                                                                    for="<?php echo e($transaction_type); ?>_<?php echo e($key); ?>_environment">
                                                                    <?php echo e(trans('labels.sandbox')); ?> </label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="environment[<?php echo e($transaction_type); ?>]"
                                                                    id="<?php echo e($transaction_type); ?>_<?php echo e($i); ?>_environment"
                                                                    value="2" required
                                                                    <?php echo e($pmdata->environment == 2 ? 'checked' : ''); ?>>
                                                                <label class="form-check-label"
                                                                    for="<?php echo e($transaction_type); ?>_<?php echo e($i); ?>_environment">
                                                                    <?php echo e(trans('labels.production')); ?> </label>
                                                            </div>
                                                        </div>
                                                        <?php if($transaction_type == 7 || $transaction_type == 8 || $transaction_type == 13 || $transaction_type == 14): ?>
                                                            <div class="col-md-12">
                                                                <input type="hidden"
                                                                    id="<?php echo e($transaction_type); ?>_publickey"
                                                                    class="form-control"
                                                                    name="public_key[<?php echo e($transaction_type); ?>]"
                                                                    placeholder="<?php echo e(trans('labels.client_id')); ?>"
                                                                    value="<?php echo e($pmdata->public_key); ?>">
                                                            </div>
                                                        <?php elseif($transaction_type == 9): ?>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="<?php echo e($transaction_type); ?>_publickey"
                                                                        class="form-label"> <?php echo e(trans('labels.client_id')); ?>

                                                                    </label>
                                                                    <input type="text" required
                                                                        id="<?php echo e($transaction_type); ?>_publickey"
                                                                        class="form-control"
                                                                        name="public_key[<?php echo e($transaction_type); ?>]"
                                                                        placeholder="<?php echo e(trans('labels.client_id')); ?>"
                                                                        value="<?php echo e($pmdata->public_key); ?>">
                                                                </div>
                                                            </div>
                                                        <?php elseif($transaction_type == 11): ?>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="<?php echo e($transaction_type); ?>_publickey"
                                                                        class="form-label">
                                                                        <?php echo e(trans('labels.profile_key')); ?>

                                                                    </label>
                                                                    <input type="text" required
                                                                        id="<?php echo e($transaction_type); ?>_publickey"
                                                                        class="form-control"
                                                                        name="public_key[<?php echo e($transaction_type); ?>]"
                                                                        placeholder="<?php echo e(trans('labels.profile_key')); ?>"
                                                                        value="<?php echo e($pmdata->public_key); ?>">
                                                                </div>
                                                            </div>
                                                        <?php else: ?>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="<?php echo e($transaction_type); ?>_publickey"
                                                                        class="form-label">
                                                                        <?php echo e(trans('labels.public_key')); ?>

                                                                        <span class="text-danger"> *</span>
                                                                    </label>
                                                                    <input type="text" required
                                                                        id="<?php echo e($transaction_type); ?>_publickey"
                                                                        class="form-control"
                                                                        name="public_key[<?php echo e($transaction_type); ?>]"
                                                                        placeholder="<?php echo e(trans('labels.public_key')); ?>"
                                                                        value="<?php echo e($pmdata->public_key); ?>">
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="<?php echo e($transaction_type); ?>_secretkey"
                                                                    class="form-label">
                                                                    <?php echo e(trans('labels.secret_key')); ?>

                                                                    <span class="text-danger">*</span></label>
                                                                <input type="text"
                                                                    id="<?php echo e($transaction_type); ?>_secretkey"
                                                                    class="form-control"
                                                                    name="secret_key[<?php echo e($transaction_type); ?>]"
                                                                    placeholder="<?php echo e(trans('labels.secret_key')); ?>"
                                                                    <?php if(env('Environment') == 'sendbox'): ?> value="*********" <?php else: ?>  value="<?php echo e($pmdata->secret_key); ?>" <?php endif; ?>
                                                                    required>
                                                            </div>
                                                        </div>

                                                        <?php if($transaction_type == '5'): ?>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="encryption_key"
                                                                        class="form-label"><?php echo e(trans('labels.encryption_key')); ?>

                                                                        <span class="text-danger"> *</span>
                                                                    </label>
                                                                    <input type="text" id="encryptionkey"
                                                                        class="form-control" name="encryption_key"
                                                                        placeholder="<?php echo e(trans('labels.encryption_key')); ?>"
                                                                        <?php if(env('Environment') == 'sendbox'): ?> value="*********" <?php else: ?> value="<?php echo e($pmdata->encryption_key); ?>" <?php endif; ?>
                                                                        required>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php if($transaction_type == 11): ?>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="base_url_by_region"
                                                                        class="form-label"><?php echo e(trans('labels.base_url_by_region')); ?>

                                                                    </label>
                                                                    <input type="text" required id="base_url_by_region"
                                                                        class="form-control" name="base_url_by_region"
                                                                        placeholder="<?php echo e(trans('labels.base_url_by_region')); ?>"
                                                                        value="<?php echo e($pmdata->base_url_by_region); ?>">
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="<?php echo e($transaction_type); ?>currency"
                                                                    class="form-label">
                                                                    <?php echo e(trans('labels.currency')); ?>

                                                                    <span class="text-danger"> *</span>
                                                                </label>
                                                                <input type="text"
                                                                    id="<?php echo e($transaction_type); ?>currency"
                                                                    class="form-control"
                                                                    name="currency[<?php echo e($transaction_type); ?>]"
                                                                    placeholder="<?php echo e(trans('labels.currency')); ?>"
                                                                    value="<?php echo e($pmdata->currency); ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="image" class="form-label">
                                                                    <?php echo e(trans('labels.image')); ?>

                                                                    <span class="text-danger"> *</span>
                                                                </label>
                                                                <input type="file" class="form-control"
                                                                    name="image">

                                                                <img src="<?php echo e(helper::image_path($pmdata->image)); ?>"
                                                                    alt="" class="img-fluid rounded h-50px mt-1">
                                                            </div>
                                                        </div>
                                                    <?php elseif($transaction_type == 1 || $transaction_type == 2): ?>
                                                        <div class="col-md-6">
                                                            <label for="image" class="form-label">
                                                                <?php echo e(trans('labels.image')); ?>

                                                                <span class="text-danger"> *</span></label>
                                                            <input type="file" class="form-control" name="image">

                                                            <img src="<?php echo e(helper::image_path($pmdata->image)); ?>"
                                                                alt="" class="img-fluid rounded h-50px mt-1">
                                                        </div>
                                                    <?php endif; ?>

                                                    <div
                                                        class="form-group d-flex justify-content-between align-items-center">
                                                        <input id="checkbox-switch-<?php echo e($transaction_type); ?>"
                                                            type="checkbox" class="checkbox-switch"
                                                            name="is_available[<?php echo e($transaction_type); ?>]" value="1"
                                                            <?php echo e($pmdata->is_available == 1 ? 'checked' : ''); ?>>
                                                        <label for="checkbox-switch-<?php echo e($transaction_type); ?>"
                                                            class="switch">
                                                            <span
                                                                class="<?php echo e(session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle'); ?>"><span
                                                                    class="switch__circle-inner"></span></span>
                                                            <span
                                                                class="switch__left <?php echo e(session()->get('direction') == 2 ? 'pe-2' : 'ps-2'); ?>"><?php echo e(trans('labels.off')); ?></span>
                                                            <span
                                                                class="switch__right <?php echo e(session()->get('direction') == 2 ? 'ps-2' : 'pe-2'); ?>"><?php echo e(trans('labels.on')); ?></span>
                                                        </label>
                                                        <button class="btn btn-primary"
                                                            <?php if(env('Environment') == 'sendbox'): ?> type="button" onclick="myFunction()"
                                                    <?php else: ?> type="submit" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/payment.js')); ?>"></script>
    <script>
        $(document).ready(function() {

            $('.sort_menu').sortable({
                handle: '.handle',
                cursor: 'move',
                placeholder: 'highlight',
                axis: "y",
                header: "> div > h6",
                update: function(e, ui) {
                    var sortData = $('.sort_menu').sortable('toArray', {
                        attribute: 'data-id'
                    })
                    updateToDatabase(sortData.join(','))
                }
            })

            function updateToDatabase(idString) {

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    dataType: "json",
                    url: $('#accordionExample').attr('data-url'),
                    data: {
                        ids: idString,
                    },
                    success: function(response) {
                        if (response.status == 1) {
                            toastr.success(response.msg);
                        } else {
                            toastr.error('Something went wrong!');
                        }
                    }
                });
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.theme.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/payment/payment.blade.php ENDPATH**/ ?>