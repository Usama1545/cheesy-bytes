<div class="col-xl-4 col-lg-4 col-sm-6 col-xs-auto">
    <div class="card rounded-4 overflow-hidden h-100">
        <div class="card-body pb-0 border-bottom">
            <div class="d-flex align-items-center mb-2 justify-content-between">
                <div class="cat-name py-1 px-2 col-auto text-center">
                    <span><?php echo e($itemdata['category_info']->category_name); ?></span>
                </div>
                <div class="">
                    <div class="d-flex fs-8 align-items-center">
                        <i class="fa-solid fa-star text-warning"></i>
                        <p class="m-0 text-dark fw-500 <?php echo e(session()->get('direction') == '2' ? 'pe-1' : 'ps-1'); ?>">
                            <?php echo e(number_format($itemdata->avg_ratting, 1)); ?></p>
                    </div>
                </div>
            </div>
            <h5 class="item-card-title pb-3 fs-6 d-flex">
                <?php if($itemdata->item_type == 1): ?>
                    <img src="<?php echo e(helper::image_path('veg.svg')); ?>" alt=""
                        class=" <?php echo e(session()->get('direction') == '2' ? 'ms-1' : 'me-1'); ?>">
                <?php else: ?>
                    <img src="<?php echo e(helper::image_path('nonveg.svg')); ?>" alt=""
                        class="<?php echo e(session()->get('direction') == '2' ? 'ms-1' : 'me-1'); ?>">
                <?php endif; ?>
                <div class="d-flex align-items-center gap-1">
                    <a href="<?php echo e(URL::to('item-' . $itemdata->slug)); ?>">
                        <p class="item-card-title mb-0 line-2">
                            <?php echo e($itemdata->item_name); ?>

                        </p>
                    </a>
                    <?php if($itemdata->item_allergens != null): ?>
                        <div type="button"
                            onclick="itemsallergens('<?php echo e($itemdata->id); ?>','<?php echo e(route('get_item_allergens')); ?>')">
                            <div class="btn-info">
                                <i class="fa-solid fa-info"></i>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </h5>
        </div>
        <?php
            if ($itemdata->is_top_deals == 1 && $topdeals != null) {
                if (@$topdeals->offer_type == 1) {
                    if ($itemdata->item_price > @$topdeals->offer_amount) {
                        $price = $itemdata->item_price - @$topdeals->offer_amount;
                    } else {
                        $price = $itemdata->item_price;
                    }
                } else {
                    $price = $itemdata->item_price - $itemdata->item_price * (@$topdeals->offer_amount / 100);
                }
                $original_price = $itemdata->item_price;
                $off = $original_price > 0 ? number_format(100 - ($price * 100) / $original_price, 1) : 0;
            } else {
                $price = $itemdata->item_price;
                $original_price = $itemdata->original_price;
                $off = $itemdata->discount_percentage;
            }
        ?>
        <div class="item-card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex justify-content-between align-items-center gap-2">
                    <span><?php echo e(helper::currency_format($price)); ?></span>
                    <?php if($original_price > $price): ?>
                        <del class="text-muted"><?php echo e(helper::currency_format($original_price)); ?></del>
                    <?php endif; ?>
                </div>
                <?php if($itemdata->is_cart == 1): ?>
                    <div class="item-quantity py-1 px-5">
                        <button type="button" class="btn btn-sm  fw-500"
                            onclick="removefromcart('<?php echo e(URL::to('/cart')); ?>','<?php echo e(trans('messages.remove_cartitem_note')); ?>','<?php echo e(trans('labels.goto_cart')); ?>')">-</button>
                        <input class="fw-500 item-total-qty-<?php echo e($itemdata->slug); ?>" type="text"
                            value="<?php echo e(helper::get_item_cart($itemdata->id)); ?>" disabled />
                        <button class="btn btn-sm fw-500 border-0"
                            onclick="showitem('<?php echo e($itemdata->slug); ?>','<?php echo e(URL::to('/show-item')); ?>')">+</button>
                    </div>
                <?php else: ?>
                    <button
                        class="btn btn-sm btn-secondary fw-500 py-2 px-4 float-end rounded-3 d-flex gap-2 justify-content-center align-items-center addon_modal_<?php echo e($itemdata->slug); ?>"
                        onclick="showitem('<?php echo e($itemdata->slug); ?>','<?php echo e(URL::to('/show-item')); ?>')">
                        <?php echo e(trans('labels.add')); ?>

                        <i class="fa-solid fa-plus addon_modal_icon_<?php echo e($itemdata->slug); ?>"></i>
                        <div class="loader d-none addon_modal_loader_<?php echo e($itemdata->slug); ?>"></div>
                    </button>
                <?php endif; ?>
            </div>
        </div>
        <a href="<?php echo e(URL::to('item-' . $itemdata->slug)); ?>">
            <div class="card-image position-relative">
                <?php if($off > 0): ?>
                    <div class="offer-lable <?php echo e(session()->get('direction') == '2' ? 'rtl' : ''); ?>">
                        <h5><?php echo e($off); ?>% <?php echo e(trans('labels.off')); ?></h5>
                    </div>
                <?php endif; ?>
                <img src="<?php echo e(@helper::image_path($itemdata['item_image']->image_name)); ?>"
                    class="card-img-top border-0 rounded-0 rounded-top-0 position-relative" alt="dishes">
            </div>
        </a>
    </div>
</div>
<?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/web/home1/recommendeditemview.blade.php ENDPATH**/ ?>