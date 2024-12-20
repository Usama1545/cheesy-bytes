<div class="col-lg-6 col-md-6 col-12">
    <div class="card rounded-4 h-100" style="border-color: var(--bs-primary)">
        <div class="d-flex align-items-center p-2 h-100">
            <div class="card-image card-second d-flex align-items-center col-auto position-relative">
                <a href="<?php echo e(URL::to('item-' . $itemdata->product->slug)); ?>">
                    <img src="<?php echo e(@helper::image_path($itemdata->product['item_image']->image_name)); ?>"
                        class="card-img-top border-0 rounded-4" alt="dishes">
                </a>
            </div>
            <div class="card-body py-0 <?php echo e(session()->get('direction') == '2' ? 'pe-3 ps-0' : 'ps-3 pe-0'); ?>">

                <?php

                        if (@$itemdata->offer_type == 1) {
                            if ($itemdata->product->price > @$itemdata->offer_amount) {
                                $price = $itemdata->product->price - @$itemdata->offer_amount;
                            } else {
                                $price = $itemdata->product->price;
                            }
                        } else {
                            $price = $itemdata->product->price - $itemdata->product->price * (@$itemdata->offer_amount / 100);
                        }
                        $original_price = $itemdata->product->price;
                        $off = $original_price > 0 ? number_format(100 - ($price * 100) / $original_price, 1) : 0;

                ?>
                <!-- off lable -->
                <?php if($off > 0): ?>
                    <div class="offer-lable d-flex mb-1">
                        <h5><?php echo e($off); ?>% <?php echo e(trans('labels.off')); ?></h5>
                    </div>
                <?php endif; ?>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <div class="fs-8 cat-span text-muted">
                        <span><?php echo e($itemdata->product['category_info']->category_name); ?></span>
                    </div>
                    
                    <div class="d-flex fs-8 align-items-center">
                        <i class="fa-solid fa-star text-warning"></i>
                        <p class="m-0 text-dark fw-500 <?php echo e(session()->get('direction') == '2' ? 'pe-1' : 'ps-1'); ?>">
                            <?php echo e(number_format($itemdata->product->avg_ratting, 1)); ?></p>
                    </div>
                </div>
                <h5 class="fs-6 mb-0 item-card-title d-flex text-h">
                    <div class="d-flex gap-1">
                        <a href="<?php echo e(URL::to('item-' . $itemdata->product->slug)); ?>">
                            <p class="item-card-title mb-0 line-2 fs-7">
                                <?php echo e($itemdata->product->item_name); ?>

                            </p>
                        </a>
                        <?php if($itemdata->product->item_allergens != null): ?>
                            <div type="button"
                                onclick="itemsallergens('<?php echo e($itemdata->product->id); ?>','<?php echo e(route('get_item_allergens')); ?>')">
                                <div class="btn-info">
                                    <i class="fa-solid fa-info"></i>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </h5>
                <div class="item-card-footer-2 pt-2">
                    <div class="d-sm-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-between align-items-center gap-2">
                            <p class="fs-6 fw-500">
                                <span><?php echo e(helper::currency_format($price)); ?></span>
                                <?php if($original_price > $price): ?>
                                    <del class="text-muted"><?php echo e(helper::currency_format($original_price)); ?></del>
                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="d-sm-flex gap-2 align-items-center mt-lg-0 mt-1 d-none">
                            <?php if($itemdata->is_cart == 1): ?>
                                <div class="item-quantity py-1 px-5">
                                    <button type="button" class="btn btn-sm  fw-500"
                                        onclick="removefromcart('<?php echo e(URL::to('/cart')); ?>','<?php echo e(trans('messages.remove_cartitem_note')); ?>','<?php echo e(trans('labels.goto_cart')); ?>')">-</button>
                                    <input class="fw-500 item-total-qty-<?php echo e($itemdata->product->slug); ?>" type="text"
                                        value="<?php echo e(helper::get_item_cart($itemdata->product->id)); ?>" disabled />
                                    <button class="btn btn-sm fw-500 border-0"
                                        onclick="showitem('<?php echo e($itemdata->product->slug); ?>','<?php echo e(URL::to('/show-item')); ?>')">+</button>
                                </div>
                            <?php else: ?>
                                <button
                                    class="btn btn-sm btn-secondary fw-500 py-2 px-4 float-end rounded-3 d-flex gap-2 justify-content-center align-items-center addon_modal_<?php echo e($itemdata->product->slug); ?>"
                                    onclick="showitem('<?php echo e($itemdata->product->slug); ?>','<?php echo e(URL::to('/show-deal-item')); ?>')">
                                    <?php echo e(trans('labels.add')); ?>

                                    <i class="fa-solid fa-plus addon_modal_icon_<?php echo e($itemdata->product->slug); ?>"></i>
                                    <div class="loader d-none addon_modal_loader_<?php echo e($itemdata->product->slug); ?>"></div>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/web/home1/todayitemview.blade.php ENDPATH**/ ?>