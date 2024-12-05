<!------ Quick call start ------>
<input type="checkbox" id="quick_call">
<label class="quick-btn <?php echo e(helper::appdata()->quick_call_position == '2' ? 'quick-btn_rtl' : 'quick-btn_ltr'); ?>" id="quick-btn"
    for="quick_call">
    <div class="comment">
        <div class="d-flex gap-2 align-items-center">
            <i class="fa-solid fa-phone fs-5"></i>
            <p class="fw-500 mb-0 fs-6"><?php echo e(trans('labels.how_can_help_you')); ?></p>
        </div>
    </div>
    <i class="fa fa-close close"></i>
</label>

<div class="shadow <?php echo e(helper::appdata()->quick_call_position == '2' ? 'quick_call_rtl' : 'quick_call'); ?>">
    <div class="call_info pb-0">
        <?php if(helper::appdata()->quick_call_image != ""): ?>
        <img src="<?php echo e(helper::image_path(helper::appdata()->quick_call_image)); ?>"
            class="caller_img mx-auto" alt="">
            <?php endif; ?>
        <h6><?php echo e(helper::appdata()->quick_call_name); ?></h6>
        <p class="text-center mb-0 mt-1 fs-8"><?php echo e(helper::appdata()->quick_call_description); ?></p>
    </div>
    <div class="p-3">
        <div class="text-center bg-primary-rgb rounded-3 py-2 w-100">
            <a href="tel:<?php echo e(helper::appdata()->quick_call_mobile); ?>" class="text-dark">
                <i class="fa-solid fa-phone"></i> <?php echo e(helper::appdata()->quick_call_mobile); ?>

            </a>
        </div>
    </div>
</div><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/web/quick_call.blade.php ENDPATH**/ ?>