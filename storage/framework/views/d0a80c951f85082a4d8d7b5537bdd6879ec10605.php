<div class="modal-header justify-content-between align-items-start">
    <div class="">
        <div class="d-flex gap-1">
            <span>
                <img src="<?php echo e($itemdata['item_type_image']); ?>" class="item-type-image" alt="">
            </span>
            <div class="d-grid">
                <p class="modal-title fs-6 fw-600"><?php echo e($itemdata['item_name']); ?></p>
                <div class="d-flex gap-3">
                    <div class="d-flex align-items-center">
                        <?php
                            if ($itemdata['is_top_deals'] == 1 && $topdeals != null) {
                                if (@$topdeals->offer_type == 1) {
                                    if ($itemdata['price'] > @$topdeals->offer_amount) {
                                        $price = $itemdata['price'] - @$topdeals->offer_amount;
                                    } else {
                                        $price = $itemdata['price'];
                                    }
                                } else {
                                    $price = $itemdata['price'] - $itemdata['price'] * (@$topdeals->offer_amount / 100);
                                }
                            } else {
                                $price = $itemdata['price'];
                            }
                        ?>
                        <p class="mb-0 fw-500 fs-7 text-black subtotal_<?php echo e($itemdata['id']); ?>">
                            <?php echo e(helper::currency_format($price)); ?>

                        </p>
                    </div>
                    <div class="d-flex">
                    </div>
                </div>

                <?php if($itemdata['tax'] != '' && $itemdata['tax'] != 0): ?>
                    <span class="text-danger fs-7"><?php echo e(trans('labels.exclusive_taxes')); ?></span>
                <?php else: ?>
                    <span class="text-danger fs-7"><?php echo e(trans('labels.inclusive_taxes')); ?></span>
                <?php endif; ?>

            </div>
        </div>
    </div>
    <button type="button" class="btn-close m-0 <?php echo e(session()->get('direction') == '2' ? 'm-0' : ''); ?>"
        data-bs-dismiss="modal" aria-label="Close"></button>
</div>



<div class="modal-body py-0">
    <div class="row align-items-center">
        
        <div class="item-details">
            <?php $__currentLoopData = $itemdata['addons_group']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addons_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $availableAddons = collect($itemdata['addons'])->where('addongroup_id', $addons_group->id);
                ?>
                <?php if($availableAddons->isNotEmpty()): ?>
                    <div class="item-addons-list mt-3 border-bottom pb-3"
                        id="item_addons_group_<?php echo e($itemdata['id']); ?>_<?php echo e($addons_group->id); ?>">
                        <h5 class="mb-1 fs-6"><?php echo e($addons_group->name); ?></h5>
                        <div class="d-flex align-items-center gap-1">
                            <?php if($addons_group->selection_type == 1): ?>
                                <i class="fa-solid fa-triangle-exclamation addon_group_color fs-8"
                                    id="addon_required_icon_<?php echo e($addons_group->id); ?>_<?php echo e($itemdata['id']); ?>"></i>
                                <span class="fs-8 fw-600 addon_group_color"
                                    id="addon_required_text_<?php echo e($addons_group->id); ?>_<?php echo e($itemdata['id']); ?>"><?php echo e(trans('labels.required')); ?></span>
                                <span class="fs-8">•</span>
                            <?php elseif($addons_group->selection_type == 2): ?>
                                <span class="fs-8">(<?php echo e(trans('labels.optional')); ?>)</span>
                                <span class="fs-8">•</span>
                            <?php endif; ?>
                            <?php if($addons_group->selection_count == 1): ?>
                                <span class="fs-8"><?php echo e(trans('labels.select')); ?> 1</span>
                            <?php else: ?>
                                <span class="fs-8"><?php echo e(trans('labels.min')); ?>

                                    <?php echo e($addons_group->min_count); ?> |
                                    <?php echo e(trans('labels.max')); ?>

                                    <?php echo e($addons_group->max_count); ?>

                                </span>
                            <?php endif; ?>
                        </div>
                        <?php $__currentLoopData = $itemdata['addons']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addons): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($addons->addongroup_id == $addons_group->id): ?>
                                <div
                                    class="<?php echo e(session()->get('direction') == '2' ? 'd-flex gap-2 me-2' : 'form-check'); ?>">
                                    <?php
                                        if ($addons_group->selection_count == 1) {
                                            $type = 'radio';
                                        } elseif ($addons_group->selection_count == 2) {
                                            $type = 'checkbox';
                                        }
                                    ?>
                                    <input
                                        class="form-check-input cursor-pointer addons_chk_<?php echo e($itemdata['id']); ?> <?php echo e(session()->get('direction') == '2' ? 'ms-0' : ''); ?>"
                                        type="<?php echo e($type); ?>" value="<?php echo e($addons->id); ?>"
                                        data-addons-id="<?php echo e($addons->id); ?>" data-addons-price="<?php echo e($addons->price); ?>"
                                        data-addons-name="<?php echo e($addons->name); ?>"
                                        onclick="getaddons('<?php echo e($itemdata['id']); ?>')"
                                        id="addons_<?php echo e($addons->id); ?>_<?php echo e($addons_group->id); ?>_<?php echo e($itemdata['id']); ?>"
                                        name="addons_id_<?php echo e($addons_group->id); ?>_<?php echo e($itemdata['id']); ?>">
                                    <div class="d-flex justify-content-between w-100">
                                        <label class="form-check-label cursor-pointer fs-7"
                                            for="addons_<?php echo e($addons->id); ?>_<?php echo e($addons_group->id); ?>_<?php echo e($itemdata['id']); ?>"><?php echo e($addons->name); ?></label>
                                        <label class="form-check-label cursor-pointer fs-7"
                                            for="addons_<?php echo e($addons->id); ?>_<?php echo e($addons_group->id); ?>_<?php echo e($itemdata['id']); ?>">

                                            <?php echo e(helper::currency_format($addons->price)); ?>

                                        </label>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if($addons_group->selection_type == 1): ?>
                            <span
                                class="addons_error_<?php echo e($addons_group->id); ?>_<?php echo e($itemdata['id']); ?> text-danger fs-7 ms-2"></span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <input type="hidden" name="addongroup" id="addongroup_<?php echo e($itemdata['id']); ?>"
                data-addongroup_val="<?php echo e($itemdata['addons_group']); ?>">
            <input type="hidden" name="slug" id="slug_<?php echo e($itemdata['id']); ?>" value="<?php echo e($itemdata['slug']); ?>">
            <input type="hidden" name="item_name" id="item_name_<?php echo e($itemdata['id']); ?>"
                value="<?php echo e($itemdata['item_name']); ?>">
            <input type="hidden" name="item_type" id="item_type_<?php echo e($itemdata['id']); ?>"
                value="<?php echo e($itemdata['item_type']); ?>">
            <input type="hidden" name="image_name" id="image_name_<?php echo e($itemdata['id']); ?>"
                value="<?php echo e($itemdata['image_name']); ?>">
            <input type="hidden" name="tax" id="item_tax_<?php echo e($itemdata['id']); ?>" value="<?php echo e($itemdata['tax']); ?>">
            <input type="hidden" name="item_price" id="item_price_<?php echo e($itemdata['id']); ?>" value="<?php echo e($price); ?>">
            <input type="hidden" name="login_required" id="login_required_<?php echo e($itemdata['slug']); ?>"
                value="<?php echo e(helper::appdata()->login_required); ?>">
            <input type="hidden" name="checklogin" id="checklogin_<?php echo e($itemdata['slug']); ?>"
                value="<?php echo e(Auth::user() && Auth::user()->type == 2); ?>">
            <input type="hidden" name="customer_login" id="customer_login_<?php echo e($itemdata['slug']); ?>"
                value="<?php echo e(App\Models\SystemAddons::where('unique_identifier', 'customer_login')->first()); ?>">
        </div>
        
        <?php if(!empty($itemdata['extras']) && count($itemdata['extras']) > 0): ?>
            <div class="item-details">
                <div class="item-addons-list mt-3 border-bottom pb-3">
                    <h5 class="mb-1 fs-6"><?php echo e(trans('labels.extras')); ?></h5>
                    <?php $__currentLoopData = $itemdata['extras']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $extras): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="<?php echo e(session()->get('direction') == '2' ? 'd-flex gap-2 me-2' : 'form-check'); ?>">
                            <input
                                class="form-check-input cursor-pointer extras_chk_<?php echo e($itemdata['id']); ?> <?php echo e(session()->get('direction') == '2' ? 'ms-0' : ''); ?>"
                                type="checkbox" value="<?php echo e($extras->id); ?>" data-extras-id="<?php echo e($extras->id); ?>"
                                data-extras-price="<?php echo e($extras->price); ?>" data-extras-name="<?php echo e($extras->name); ?>"
                                id="extras_<?php echo e($extras->id); ?>_<?php echo e($itemdata['id']); ?>"
                                name="extras_id_<?php echo e($itemdata['id']); ?>">
                            <div class="d-flex justify-content-between w-100 ">
                                <label class="form-check-label cursor-pointer fs-7"
                                    for="extras_<?php echo e($extras->id); ?>_<?php echo e($itemdata['id']); ?>"><?php echo e($extras->name); ?></label>
                                <label class="form-check-label cursor-pointer fs-7"
                                    for="extras_<?php echo e($extras->id); ?>_<?php echo e($itemdata['id']); ?>">

                                    <?php echo e(helper::currency_format($extras->price)); ?>

                                </label>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
        <?php endif; ?>
        <input type="hidden" name="addongroup" id="addongroup_<?php echo e($itemdata['id']); ?>"
            data-addongroup_val="<?php echo e($itemdata['addons_group']); ?>">
        <input type="hidden" name="slug" id="slug_<?php echo e($itemdata['id']); ?>" value="<?php echo e($itemdata['slug']); ?>">
        <input type="hidden" name="item_name" id="item_name_<?php echo e($itemdata['id']); ?>"
            value="<?php echo e($itemdata['item_name']); ?>">
        <input type="hidden" name="item_type" id="item_type_<?php echo e($itemdata['id']); ?>"
            value="<?php echo e($itemdata['item_type']); ?>">
        <input type="hidden" name="image_name" id="image_name_<?php echo e($itemdata['id']); ?>"
            value="<?php echo e($itemdata['image_name']); ?>">
        <input type="hidden" name="tax" id="item_tax_<?php echo e($itemdata['id']); ?>" value="<?php echo e($itemdata['tax']); ?>">
        <input type="hidden" name="item_price" id="item_price_<?php echo e($itemdata['id']); ?>" value="<?php echo e($price); ?>">
        <input type="hidden" name="login_required" id="login_required_<?php echo e($itemdata['slug']); ?>"
            value="<?php echo e(helper::appdata()->login_required); ?>">
        <input type="hidden" name="checklogin" id="checklogin_<?php echo e($itemdata['slug']); ?>"
            value="<?php echo e(Auth::user() && Auth::user()->type == 2); ?>">
        <input type="hidden" name="customer_login" id="customer_login_<?php echo e($itemdata['slug']); ?>"
            value="<?php echo e(App\Models\SystemAddons::where('unique_identifier', 'customer_login')->first()); ?>">
    </div>
</div>
</div>
<div class="modal-footer d-block py-0 item-details border-0">
    <div class="w-100 m-0 py-2 border-bottom border-top">
        <div class="row align-items-center justify-content-between g-2">
            <div class="col-sm-2">
                <div class="item-quantity py-2 w-100">
                    <button class="btn btn-sm fw-500 p-0 fs-6"
                        onclick="changeqty('<?php echo e($itemdata['slug']); ?>','minus')">-</button>
                    <input type="text" class="p-0" name="number" value="1"
                        id="item_qty_<?php echo e($itemdata['slug']); ?>" readonly="">
                    <button class="btn btn-sm fw-500 p-0 fs-6"
                        onclick="changeqty('<?php echo e($itemdata['slug']); ?>','plus')">+</button>
                </div>
            </div>
            <div class="col-sm-5">
                <button
                    class="btn btn-secondary w-100 m-0 fs-7 fw-500 rounded-3 d-flex gap-3 justify-content-center align-items-center addon_modal_cart"
                    onclick="addtocart('<?php echo e(URL::to('addtocart')); ?>','<?php echo e($itemdata['id']); ?>','0')">
                    <?php echo e(trans('labels.add_to_cart')); ?>

                    <div class="loader d-none addon_modal_cart_loader"></div>
                </button>
            </div>
            <div class="col-sm-5">
                <button
                    class="btn btn-primary w-100 m-0 fs-7 fw-500 rounded-3 d-flex gap-3 justify-content-center align-items-center addon_modal_quick_order"
                    onclick="addtocart('<?php echo e(URL::to('addtocart')); ?>','<?php echo e($itemdata['id']); ?>','1')">
                    <?php echo e(trans('labels.quick_order')); ?>

                    <div class="loader d-none addon_modal_quick_order_loader"></div>
                </button>
            </div>
        </div>
    </div>
    <div class="d-flex flex-wrap justify-content-between align-items-center">
        <div class="col-sm-6 set-fav-<?php echo e($itemdata['id']); ?>">
            <?php if($itemdata['is_favorite'] == '1'): ?>
                <a class="text-dark fw-500 d-flex fs-6 gap-1 py-2 align-items-center"
                    <?php if(Auth::user() && Auth::user()->type == 2): ?> href="javascript:void(0)" onclick="managefavorite('<?php echo e($itemdata['id']); ?>',0,'<?php echo e(URL::to('/managefavorite')); ?>')" <?php else: ?> href="<?php echo e(URL::to('/login')); ?>" <?php endif; ?>>
                    <i class="fa-solid fa-heart fs-6"></i>
                    <?php echo e(trans('labels.remove_wishlist')); ?>

                </a>
            <?php else: ?>
                <a class="text-dark fw-500 d-flex fs-6 gap-1 py-2 align-items-center"
                    <?php if(Auth::user() && Auth::user()->type == 2): ?> href="javascript:void(0)" onclick="managefavorite('<?php echo e($itemdata['id']); ?>',1,'<?php echo e(URL::to('/managefavorite')); ?>')" <?php else: ?> href="<?php echo e(URL::to('/login')); ?>" <?php endif; ?>>
                    <i class="fa-regular fa-heart fs-6"></i>
                    <?php echo e(trans('labels.add_wishlist')); ?>

                </a>
            <?php endif; ?>
        </div>
        <div class="col-sm-6">
            <div class="d-flex align-items-center justify-content-end gap-2">
                <?php if(helper::appdata()->google_review_url != ''): ?>
                    <a href="<?php echo e(helper::appdata()->google_review_url); ?>" class="icon-box" target="_blank"
                        tooltip="<?php echo e(trans('labels.review')); ?>">
                        <i class="fa-solid fa-star fs-9"></i>
                    </a>
                <?php endif; ?>
                <?php if(helper::appdata()->mobile != ''): ?>
                    <a href="callto:<?php echo e(helper::appdata()->mobile); ?>" tooltip="<?php echo e(trans('labels.call')); ?>"
                        class="icon-box">
                        <i class="fa-solid fa-phone fs-9"></i>
                    </a>
                <?php endif; ?>
                <?php if(@helper::checkaddons('whatsapp_message')): ?>
                    <?php if(whatsapp_helper::whatsapp_message_config()->whatsapp_number != ''): ?>
                        <a href="https://api.whatsapp.com/send?phone=<?php echo e(whatsapp_helper::whatsapp_message_config()->whatsapp_number); ?>'&text=<?php echo e($itemdata['item_name']); ?>"
                            target="_blank" tooltip="<?php echo e(trans('labels.whatsapp')); ?>" class="icon-box">
                            <i class="fa-brands fa-whatsapp fs-9"></i>
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if($itemdata['video_url'] != ''): ?>
                    <a href="<?php echo e($itemdata['video_url']); ?>" target="_blank" tooltip="<?php echo e(trans('labels.video')); ?>"
                        class="icon-box">
                        <i class="fa-solid fa-video fs-9"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/web/addonsmodal.blade.php ENDPATH**/ ?>