<?php $__env->startSection('page_title'); ?>
    | <?php echo e(@$getitemdata->item_name); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="breadcrumb-sec">
        <div class="container">
            <div class="breadcrumb-sec-content">
                <nav class="text-dark breadcrumb-divider" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li
                            class="breadcrumb-item <?php echo e(session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : ''); ?>">
                            <a class="text-dark fw-600" href="<?php echo e(route('home')); ?>"><?php echo e(trans('labels.home')); ?></a>
                        </li>
                        <li class="breadcrumb-item <?php echo e(session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : ''); ?> active"
                            aria-current="page"><?php echo e(trans('item details')); ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="mt-5">
        <div class="container">
            <div class="item-details border-bottom pb-4">
                <div class="row mb-4 justify-content-between">
                    <div class="col-lg-5 col-12 mb-3">
                        <div class="item-img-cover">
                            
                            <div class="card h-100 overflow-hidden rounded-0 border-0 position-relative">
                                <!-- new big-view -->
                                <div class="sp-loading"><img src="https://via.placeholder.com/1100x1220" alt=""
                                        class="rounded-4"><br>LOADING IMAGES</div>
                                <div class="sp-wrap">
                                    <?php $__currentLoopData = $getitemdata['item_images']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $firstimage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a href="<?php echo e(@helper::image_path($firstimage->image_name)); ?>">
                                            <img src="<?php echo e(@helper::image_path($firstimage->image_name)); ?>" alt=""
                                                class="rounded-4"></a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                <!-- new big-view -->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-12">
                        <div class="item-content">
                            <div class="item-heading">
                                <?php
                                    if ($getitemdata->is_top_deals == 1 && $topdeals != null) {
                                        if (@$topdeals->offer_type == 1) {
                                            if ($getitemdata->item_price > @$topdeals->offer_amount) {
                                                $price = $getitemdata->item_price - @$topdeals->offer_amount;
                                            } else {
                                                $price = $getitemdata->item_price;
                                            }
                                        } else {
                                            $price =
                                                $getitemdata->item_price -
                                                $getitemdata->item_price * (@$topdeals->offer_amount / 100);
                                        }
                                        $original_price = $getitemdata->item_price;
                                        $off =
                                            $original_price > 0
                                                ? number_format(100 - ($price * 100) / $original_price, 1)
                                                : 0;
                                    } else {
                                        $price = $getitemdata->item_price;
                                        $original_price = $getitemdata->original_price;
                                        $off = $getitemdata->discount_percentage;
                                    }
                                ?>
                                <?php if($off > 0): ?>
                                    <div class="my-2">
                                        <span class="py-1 px-2 mb-2 offer-badge"><?php echo e($off); ?>%
                                            <?php echo e(trans('labels.off')); ?></span>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <span
                                        class="text-muted fs-7 fw-500"><?php echo e($getitemdata['category_info']->category_name); ?></span>
                                </div>
                                <div class="d-flex text-align-center mt-2">
                                    <img class="col-1 <?php echo e(session()->get('direction') == 2 ? 'ms-1' : 'me-1'); ?>"
                                        <?php if($getitemdata->item_type == 1): ?> src="<?php echo e(helper::image_path('veg.svg')); ?>" <?php else: ?> src="<?php echo e(helper::image_path('nonveg.svg')); ?>" <?php endif; ?>
                                        alt="">
                                    <span class="item-title"><?php echo e($getitemdata->item_name); ?></span>
                                </div>
                            </div>
                            <div class="row my-2 align-items-center">
                                <div class="d-flex flex-wrap justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-2">
                                        <p class="item-price item_price m-0 text-black subtotal_<?php echo e($getitemdata['id']); ?>">
                                            <?php echo e(helper::currency_format($price)); ?></p>
                                        <?php if($original_price > $price): ?>
                                            <del class="item-price item_price fs-7 text-muted">
                                                <?php echo e(helper::currency_format($original_price)); ?></del>
                                        <?php endif; ?>
                                    </div>
                                    <a href="#review-tab">
                                        <div class="d-flex align-items-center">
                                            <p class="fs-8 mb-0"><i
                                                    class="text-warning fa-solid fa-star <?php echo e(session()->get('direction') == '2' ? 'ps-1' : 'pe-1'); ?>"></i><span
                                                    class="text-dark fw-500"><?php echo e(number_format($getitemdata->avg_ratting, 1)); ?></span>
                                            </p>
                                            <span
                                                class="px-2 d-inline-block fs-8 text-muted fw-500">(<?php echo e(count($itemreviewdata)); ?>

                                                <?php echo e(trans('labels.reviews')); ?>)</span>
                                        </div>
                                    </a>
                                </div>

                            </div>

                            <?php if(@Helper::checkaddons('fake_view')): ?>
                                <?php if(Helper::appdata()->product_fake_view == 1): ?>
                                <?php

                                $var = ["{eye}", "{count}"];
                                $newvar   = ["<i class='fa-solid fa-eye'></i>", rand(Helper::appdata()->min_view_count,Helper::appdata()->max_view_count)];

                                $fake_view = str_replace($var, $newvar, Helper::appdata()->fake_view_message);
                                ?>
                                <div class="d-flex gap-1 align-items-center blink_me mb-2">
                                    <p class="fw-600 text-success m-0"><?php echo $fake_view; ?></p>
                                </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            <div class="d-flex pb-2 border-bottom">
                                <div class="col-auto">
                                    <?php if($getitemdata->tax != '' && $getitemdata->tax != 0): ?>
                                        <span class="text-danger float-end"><?php echo e(trans('labels.exclusive_taxes')); ?></span>
                                    <?php else: ?>
                                        <span class="text-danger float-end"><?php echo e(trans('labels.inclusive_taxes')); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php if($getitemdata->is_top_deals == 1 && $topdeals != null): ?>
                                <h5 class="mt-3">⏰ <?php echo e(trans('labels.hurry_up')); ?></h5>
                                <div class="product-detail-countdown d-flex border-bottom gap-2 my-3 pb-3" id="countdown">
                                </div>
                            <?php endif; ?>
                            <?php if(!empty($getitemdata->addons_group) && count($getitemdata->addons_group) > 0): ?>
                                <div class="row align-items-center">
                                    <div class="col-lg-12 col-md-12 col-sm-12 m-auto">
                                        <div class="addon-item-details scroll-addon-details">
                                            <?php $__currentLoopData = $getitemdata['addons_group']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addons_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $availableAddons = collect($getitemdata['addons'])->where(
                                                        'addongroup_id',
                                                        $addons_group->id,
                                                    );
                                                ?>
                                                <?php if($availableAddons->isNotEmpty()): ?>
                                                    <div class="item-addons-list mt-3 border-bottom pb-3"
                                                        id="item_addons_group_<?php echo e($getitemdata['id']); ?>_<?php echo e($addons_group->id); ?>">
                                                        <h5 class="mb-1 fs-6"><?php echo e($addons_group->name); ?></h5>
                                                        <div class="d-flex align-items-center gap-1 pb-1">
                                                            <?php if($addons_group->selection_type == 1): ?>
                                                                <i class="fa-solid fa-triangle-exclamation addon_group_color fs-8"
                                                                    id="addon_required_icon_<?php echo e($addons_group->id); ?>_<?php echo e($getitemdata['id']); ?>"></i>
                                                                <span class="fs-8 fw-600 addon_group_color"
                                                                    id="addon_required_text_<?php echo e($addons_group->id); ?>_<?php echo e($getitemdata['id']); ?>"><?php echo e(trans('labels.required')); ?></span>
                                                                <span class="fs-8">•</span>
                                                            <?php elseif($addons_group->selection_type == 2): ?>
                                                                <span
                                                                    class="fs-8">(<?php echo e(trans('labels.optional')); ?>)</span>
                                                                <span class="fs-8">•</span>
                                                            <?php endif; ?>
                                                            <?php if($addons_group->selection_count == 1): ?>
                                                                <span class="fs-8"><?php echo e(trans('labels.select')); ?>

                                                                    1</span>
                                                            <?php else: ?>
                                                                <span class="fs-8"><?php echo e(trans('labels.min')); ?>

                                                                    <?php echo e($addons_group->min_count); ?> |
                                                                    <?php echo e(trans('labels.max')); ?>

                                                                    <?php echo e($addons_group->max_count); ?>

                                                                </span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <?php $__currentLoopData = $getitemdata['addons']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addons): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if($addons->addongroup_id == $addons_group->id): ?>
                                                                <div
                                                                    class="mx-2 <?php echo e(session()->get('direction') == '2' ? 'd-flex gap-2' : 'form-check'); ?>">
                                                                    <?php
                                                                        if ($addons_group->selection_count == 1) {
                                                                            $type = 'radio';
                                                                        } elseif ($addons_group->selection_count == 2) {
                                                                            $type = 'checkbox';
                                                                        }
                                                                    ?>
                                                                    <input
                                                                        class="form-check-input cursor-pointer addons_chk_<?php echo e($getitemdata['id']); ?> <?php echo e(session()->get('direction') == '2' ? 'ms-0' : ''); ?>"
                                                                        type="<?php echo e($type); ?>"
                                                                        value="<?php echo e($addons->id); ?>"
                                                                        data-addons-id="<?php echo e($addons->id); ?>"
                                                                        data-addons-price="<?php echo e($addons->price); ?>"
                                                                        data-addons-name="<?php echo e($addons->name); ?>"
                                                                        onclick="getaddons('<?php echo e($getitemdata['id']); ?>')"
                                                                        name="addons_id_<?php echo e($addons_group->id); ?>_<?php echo e($getitemdata['id']); ?>"
                                                                        id="addons_<?php echo e($addons_group->id); ?>_<?php echo e($getitemdata['id']); ?>_<?php echo e($addons->id); ?>">
                                                                    <div
                                                                        class="d-flex justify-content-between w-100 <?php echo e(session()->get('direction') == '2' ? 'ps-2' : 'pe-2'); ?>">
                                                                        <label class="form-check-label cursor-pointer fs-7"
                                                                            for="addons_<?php echo e($addons_group->id); ?>_<?php echo e($getitemdata['id']); ?>_<?php echo e($addons->id); ?>"><?php echo e($addons->name); ?></label>
                                                                        <label class="form-check-label cursor-pointer fs-7"
                                                                            for="addons_<?php echo e($addons_group->id); ?>_<?php echo e($getitemdata['id']); ?>_<?php echo e($addons->id); ?>">
                                                                            <?php echo e(helper::currency_format($addons->price)); ?>

                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($addons_group->selection_type == 1): ?>
                                                            <span
                                                                class="addons_error_<?php echo e($addons_group->id); ?>_<?php echo e($getitemdata['id']); ?> text-danger fs-7 ms-2"></span>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <?php if(!empty($getitemdata->extras) && count($getitemdata->extras) > 0): ?>
                                <div class="item-details mt-3">
                                    <h5 class="mb-1 fs-6"><?php echo e(trans('labels.extras')); ?></h5>
                                    <div class="item-addons-list mt-2 border-bottom pb-3 px-2">
                                        <?php $__currentLoopData = $getitemdata->extras; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $extras): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div
                                                class="<?php echo e(session()->get('direction') == '2' ? 'd-flex' : 'form-check'); ?>">
                                                <input
                                                    class="form-check-input cursor-pointer extras_chk_<?php echo e($getitemdata['id']); ?> <?php echo e(session()->get('direction') == '2' ? 'ms-0' : ''); ?>"
                                                    type="checkbox" value="<?php echo e($extras->id); ?>"
                                                    data-extras-id="<?php echo e($extras->id); ?>"
                                                    data-extras-price="<?php echo e($extras->price); ?>"
                                                    data-extras-name="<?php echo e($extras->name); ?>"
                                                    id="extras_<?php echo e($extras->id); ?>_<?php echo e($getitemdata['id']); ?>"
                                                    name="extras_id_<?php echo e($getitemdata['id']); ?>">
                                                <div
                                                    class="d-flex justify-content-between align-items-center w-100 text-black">
                                                    <label class="form-check-label cursor-pointer me-2 fs-7"
                                                        for="extras_<?php echo e($extras->id); ?>_<?php echo e($getitemdata['id']); ?>"><?php echo e($extras->name); ?></label>
                                                    <label class="form-check-label cursor-pointer me-2 fs-7"
                                                        for="extras_<?php echo e($extras->id); ?>_<?php echo e($getitemdata['id']); ?>">
                                                        <?php echo e(helper::currency_format($extras->price)); ?>

                                                    </label>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <input type="hidden" name="addongroup" id="addongroup_<?php echo e($getitemdata['id']); ?>"
                                data-addongroup_val="<?php echo e($getitemdata['addons_group']); ?>">
                            <input type="hidden" name="slug" id="slug_<?php echo e($getitemdata['id']); ?>"
                                value="<?php echo e($getitemdata['slug']); ?>">
                            <input type="hidden" name="item_name" id="item_name_<?php echo e($getitemdata['id']); ?>"
                                value="<?php echo e($getitemdata['item_name']); ?>">
                            <input type="hidden" name="item_type" id="item_type_<?php echo e($getitemdata['id']); ?>"
                                value="<?php echo e($getitemdata['item_type']); ?>">
                            <input type="hidden" name="image_name" id="image_name_<?php echo e($getitemdata['id']); ?>"
                                value="<?php echo e($getitemdata['item_image']->image_name); ?>">
                            <input type="hidden" name="tax" id="item_tax_<?php echo e($getitemdata['id']); ?>"
                                value="<?php echo e($getitemdata['tax']); ?>">
                            <input type="hidden" name="item_price" id="item_price_<?php echo e($getitemdata['id']); ?>"
                                value="<?php echo e($price); ?>">
                            <input type="hidden" name="request_url" id="request_url_<?php echo e($getitemdata['slug']); ?>"
                                value="<?php echo e(request()->segments()[0]); ?>">
                            <input type="hidden" name="login_required" id="login_required_<?php echo e($getitemdata['slug']); ?>"
                                value="<?php echo e(helper::appdata()->login_required); ?>">
                            <input type="hidden" name="checklogin" id="checklogin_<?php echo e($getitemdata['slug']); ?>"
                                value="<?php echo e(Auth::user() && Auth::user()->type == 2); ?>">
                            <input type="hidden" name="customer_login" id="customer_login_<?php echo e($getitemdata['slug']); ?>"
                                value="<?php echo e(App\Models\SystemAddons::where('unique_identifier', 'customer_login')->first()); ?>">
                            <div class="border-bottom border-top py-3">
                                <div class="row g-3 align-items-center">
                                    <div class="col-md-auto col-12">
                                        <div class="d-flex align-items-center gap-2">
                                            <div>
                                                <p class="mb-0"><?php echo e(trans('labels.quantity')); ?> :</p>
                                            </div>
                                            <div class="btn item-quantity">
                                                <button class="btn btn-sm item-quantity-minus"
                                                    onclick="changeqty('<?php echo e($getitemdata['slug']); ?>','minus')">-</button>
                                                <input class="item-quantity-input" type="text" value="1"
                                                    readonly="" id="item_qty_<?php echo e($getitemdata['slug']); ?>">
                                                <button class="btn btn-sm item-quantity-plus"
                                                    onclick="changeqty('<?php echo e($getitemdata['slug']); ?>','plus')">+</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-6">
                                        <button
                                            class="btn btn-secondary w-100 m-0 fs-7 fw-500 rounded-3 d-flex gap-3 justify-content-center align-items-center cart"
                                            onclick="addtocart('<?php echo e(URL::to('addtocart')); ?>','<?php echo e($getitemdata['id']); ?>','0')">
                                            <?php echo e(trans('labels.add_to_cart')); ?>

                                            <div class="loader d-none cart_loader"></div>
                                        </button>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-6">
                                        <?php if(@helper::checkaddons('customer_login')): ?>
                                            <?php if(helper::appdata()->login_required == 1): ?>
                                                <button
                                                    class="btn btn-primary w-100 m-0 fs-7 fw-500 rounded-3 d-flex gap-3 justify-content-center align-items-center quick_order"
                                                    <?php if(helper::appdata()->is_checkout_login_required == 1): ?> onclick="showlogin()" <?php else: ?>  onclick="addtocart('<?php echo e(URL::to('addtocart')); ?>','<?php echo e($getitemdata['id']); ?>','1')" <?php endif; ?>>
                                                    <?php echo e(trans('labels.quick_order')); ?>

                                                    <div class="loader d-none quick_order_loader"></div>
                                                </button>
                                            <?php else: ?>
                                                <button
                                                    class="btn btn-primary w-100 m-0 fs-7 fw-500 rounded-3 d-flex gap-3 justify-content-center align-items-center quick_order"
                                                    onclick="addtocart('<?php echo e(URL::to('addtocart')); ?>','<?php echo e($getitemdata['id']); ?>','1')">
                                                    <?php echo e(trans('labels.quick_order')); ?>

                                                    <div class="loader d-none quick_order_loader"></div>
                                                </button>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <button
                                                class="btn btn-primary w-100 m-0 fs-7 fw-500 rounded-3 d-flex gap-3 justify-content-center align-items-center quick_order"
                                                onclick="addtocart('<?php echo e(URL::to('addtocart')); ?>','<?php echo e($getitemdata['id']); ?>','1')">
                                                <?php echo e(trans('labels.quick_order')); ?>

                                                <div class="loader d-none quick_order_loader"></div>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap justify-content-between mt-3 align-items-center">
                                <div class="col-sm-6">
                                    <div class="wishlist set-fav-<?php echo e($getitemdata->id); ?>">
                                        <?php if($getitemdata->is_favorite == 1): ?>
                                            <a class="text-dark fw-600 fs-7 d-flex gap-1 py-2 align-items-center"
                                                <?php if(Auth::user() && Auth::user()->type == 2): ?> href="javascript:void(0)" onclick="managefavorite('<?php echo e($getitemdata->id); ?>',0,'<?php echo e(URL::to('/managefavorite')); ?>')" <?php else: ?> href="<?php echo e(URL::to('/login')); ?>" <?php endif; ?>>
                                                <i class="fa-solid fa-heart fs-6"></i>
                                                <?php echo e(trans('labels.remove_wishlist')); ?>

                                            </a>
                                        <?php else: ?>
                                            <a class="text-dark fw-600 fs-7 d-flex gap-1 py-2 align-items-center"
                                                <?php if(Auth::user() && Auth::user()->type == 2): ?> href="javascript:void(0)" onclick="managefavorite('<?php echo e($getitemdata->id); ?>',1,'<?php echo e(URL::to('/managefavorite')); ?>')" <?php else: ?> href="<?php echo e(URL::to('/login')); ?>" <?php endif; ?>>
                                                <i class="fa-regular fa-heart fs-6"></i>
                                                <?php echo e(trans('labels.add_wishlist')); ?>

                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="d-flex align-items-center justify-content-end gap-2">
                                        <?php if(helper::appdata()->google_review_url != ''): ?>
                                            <a href="<?php echo e(helper::appdata()->google_review_url); ?>"
                                                class="icon-box" target="_blank"
                                                tooltip="<?php echo e(trans('labels.review')); ?>">
                                                <i class="fa-solid fa-star fs-8"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if(helper::appdata()->mobile != ''): ?>
                                            <a href="callto:<?php echo e(helper::appdata()->mobile); ?>"
                                                tooltip="<?php echo e(trans('labels.call')); ?>" class="icon-box">
                                                <i class="fa-solid fa-phone fs-8"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if(@helper::checkaddons('whatsapp_message')): ?>
                                            <?php if(whatsapp_helper::whatsapp_message_config()->whatsapp_number != ''): ?>
                                                <a href="https://api.whatsapp.com/send?phone=<?php echo e(whatsapp_helper::whatsapp_message_config()->whatsapp_number); ?>'&text=<?php echo e($getitemdata->item_name); ?>"
                                                    target="_blank" tooltip="<?php echo e(trans('labels.whatsapp')); ?>"
                                                    class="icon-box">
                                                    <i class="fa-brands fa-whatsapp fs-8"></i>
                                                </a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if($getitemdata->video_url != ''): ?>
                                            <a href="<?php echo e($getitemdata->video_url); ?>" target="_blank"
                                                tooltip="<?php echo e(trans('labels.video')); ?>" class="icon-box">
                                                <i class="fa-solid fa-video fs-8"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="product-view" id="review-tab">
                    <ul class="nav nav-pills py-3 mb-4 border-bottom border-top" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link <?php echo e(session()->get('direction') == 2 ? 'ms-2 ms-md-3' : 'me-2 me-md-3'); ?> active"
                                aria-current="page" data-bs-toggle="pill" data-bs-target="#pills-description"
                                href="javascript:void(0)" aria-selected="true"
                                role="tab"><?php echo e(trans('labels.description')); ?></a>
                        </li>
                        <?php if(@helper::checkaddons('product_review')): ?>
                            <?php if(@helper::checkaddons('customer_login')): ?>
                                <?php if(helper::appdata()->login_required == 1): ?>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" href="javascript:void(0)" data-bs-toggle="pill"
                                            data-bs-target="#pills-review" aria-selected="false" role="tab"
                                            tabindex="-1"><?php echo e(trans('labels.reviews')); ?></a>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade active show" id="pills-description" role="tabpanel"
                        aria-labelledby="pills-description-tab">
                        <div class="row mt-2">
                            <div class="col-auto">
                                <h4 class="heading mb-3 fw-600 text-dark text-truncate">
                                    <?php echo e(trans('labels.description')); ?>

                                </h4>
                                <div class="item-description">
                                    <p class="text-justify mb-0"><?php echo $getitemdata->item_description; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if(@helper::checkaddons('product_review')): ?>
                        <?php if(@helper::checkaddons('customer_login')): ?>
                            <?php if(helper::appdata()->login_required == 1): ?>
                                <div class="tab-pane fade" id="pills-review" role="tabpanel"
                                    aria-labelledby="pills-review-tab">
                                    <div class="row gx-4 gx-xxl-5 gy-md-0 gy-4">
                                        <div class="col-md-12 col-lg-7 col-xxl-6">
                                            <!-- Customer rating -->
                                            <h4 class="heading mb-3 fw-600 text-dark text-truncate">
                                                <?php echo e(trans('labels.customer_rating')); ?>

                                            </h4>
                                            <div class="card border-0 bg-gray rounded-3 p-4 mb-4 rounded-3">
                                                <div class="row g-4 align-items-center">
                                                    <!-- Rating info -->
                                                    <div class="col-md-4">
                                                        <div class="text-center">
                                                            <!-- Info -->
                                                            <h2 class="mb-0 fw-bold text-dark">
                                                                <i class="fa-solid fa-star text-warning"></i>
                                                                <?php echo e(number_format($getitemdata->avg_ratting, 1)); ?>

                                                            </h2>
                                                            <p class="mb-2 text-muted"><?php echo e(trans('labels.based_on')); ?>

                                                                <?php echo e(count($itemreviewdata)); ?>

                                                                <?php echo e(trans('labels.reviews')); ?>

                                                            </p>
                                                        </div>
                                                    </div>

                                                    <!-- Progress-bar START -->
                                                    <div class="col-md-8">
                                                        <div class="card-body p-0">
                                                            <div class="row gx-3 g-2 align-items-center">
                                                                <!-- 5.0 Progress bar and Rating -->
                                                                <div class="col-2 col-sm-2 text-end">
                                                                    <span class="h6 fw-semibold mb-0 text-dark">5.0</span>
                                                                </div>
                                                                <?php
                                                                    if (count(@$itemreviewdata) != 0) {
                                                                        $five =
                                                                            ($fivestaraverage /
                                                                                count(@$itemreviewdata)) *
                                                                            100;
                                                                    } else {
                                                                        $five = 0;
                                                                    }
                                                                ?>
                                                                <div class="col-2 col-sm-8">
                                                                    <div class="progress progress-sm">
                                                                        <div class="progress-bar" role="progressbar"
                                                                            style="width: <?php echo e($five); ?>%"
                                                                            aria-valuenow="<?php echo e(round($five)); ?>%"
                                                                            aria-valuemin="0" aria-valuemax="100">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- 5.0 Percentage -->
                                                                <div
                                                                    class="col-2 col-sm-2 <?php echo e(session()->get('direction') == 2 ? 'text-start' : 'text-end'); ?>">
                                                                    <span
                                                                        class="h6 fw-semibold mb-0 text-dark"><?php echo e(round($five)); ?>%</span>
                                                                </div>

                                                                <!-- 4.0 Progress bar and Rating -->
                                                                <div class="col-2 col-sm-2 text-end">
                                                                    <span class="h6 fw-semibold mb-0 text-dark">4.0</span>
                                                                </div>
                                                                <?php
                                                                    if (count(@$itemreviewdata) != 0) {
                                                                        $four =
                                                                            ($fourstaraverage /
                                                                                count(@$itemreviewdata)) *
                                                                            100;
                                                                    } else {
                                                                        $four = 0;
                                                                    }
                                                                ?>
                                                                <div class="col-8 col-sm-8">
                                                                    <div class="progress progress-sm">
                                                                        <div class="progress-bar" role="progressbar"
                                                                            style="width: <?php echo e($four); ?>%"
                                                                            aria-valuenow="<?php echo e(round($four)); ?>%"
                                                                            aria-valuemin="0" aria-valuemax="100">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- 4.0 Percentage -->
                                                                <div
                                                                    class="col-2 col-sm-2 <?php echo e(session()->get('direction') == 2 ? 'text-start' : 'text-end'); ?>">
                                                                    <span
                                                                        class="h6 fw-semibold mb-0 text-dark"><?php echo e(round($four)); ?>%</span>
                                                                </div>

                                                                <!-- 3.0 Progress bar and Rating -->
                                                                <div class="col-2 col-sm-2 text-end">
                                                                    <span class="h6 fw-semibold mb-0 text-dark">3.0</span>
                                                                </div>
                                                                <?php
                                                                    if (count(@$itemreviewdata) != 0) {
                                                                        $three =
                                                                            ($threestaraverage /
                                                                                count(@$itemreviewdata)) *
                                                                            100;
                                                                    } else {
                                                                        $three = 0;
                                                                    }
                                                                ?>
                                                                <div class="col-8 col-sm-8">
                                                                    <div class="progress progress-sm">
                                                                        <div class="progress-bar" role="progressbar"
                                                                            style="width: <?php echo e($three); ?>%"
                                                                            aria-valuenow="<?php echo e(round($three)); ?>%"
                                                                            aria-valuemin="0" aria-valuemax="100">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- 3.0 Percentage -->
                                                                <div
                                                                    class="col-2 col-sm-2 <?php echo e(session()->get('direction') == 2 ? 'text-start' : 'text-end'); ?>">
                                                                    <span
                                                                        class="h6 fw-semibold mb-0 text-dark"><?php echo e(round($three)); ?>%</span>
                                                                </div>

                                                                <!-- 2.0 Progress bar and Rating -->
                                                                <div class="col-2 col-sm-2 text-end">
                                                                    <span class="h6 fw-semibold mb-0 text-dark">2.0</span>
                                                                </div>
                                                                <?php
                                                                    if (count(@$itemreviewdata) != 0) {
                                                                        $two =
                                                                            ($twostaraverage /
                                                                                count(@$itemreviewdata)) *
                                                                            100;
                                                                    } else {
                                                                        $two = 0;
                                                                    }
                                                                ?>
                                                                <div class="col-8 col-sm-8">
                                                                    <div class="progress progress-sm">
                                                                        <div class="progress-bar" role="progressbar"
                                                                            style="width: <?php echo e($two); ?>%"
                                                                            aria-valuenow="<?php echo e(round($two)); ?>%"
                                                                            aria-valuemin="0" aria-valuemax="100">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- 2.0 Percentage -->
                                                                <div
                                                                    class="col-2 col-sm-2 <?php echo e(session()->get('direction') == 2 ? 'text-start' : 'text-end'); ?>">
                                                                    <span
                                                                        class="h6 fw-semibold mb-0 text-dark"><?php echo e(round($two)); ?>%</span>
                                                                </div>

                                                                <!-- 1.0 Progress bar and Rating -->
                                                                <div class="col-2 col-sm-2 text-end">
                                                                    <span class="h6 fw-semibold mb-0 text-dark">1.0</span>
                                                                </div>
                                                                <?php
                                                                    if (count(@$itemreviewdata) != 0) {
                                                                        $one =
                                                                            ($onestaraverage /
                                                                                count(@$itemreviewdata)) *
                                                                            100;
                                                                    } else {
                                                                        $one = 0;
                                                                    }
                                                                ?>
                                                                <div class="col-8 col-sm-8">
                                                                    <div class="progress progress-sm">
                                                                        <div class="progress-bar" role="progressbar"
                                                                            style="width: <?php echo e($one); ?>%"
                                                                            aria-valuenow="<?php echo e(round($one)); ?>%"
                                                                            aria-valuemin="0" aria-valuemax="100">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- 1.0 Percentage -->
                                                                <div
                                                                    class="col-2 col-sm-2 <?php echo e(session()->get('direction') == 2 ? 'text-start' : 'text-end'); ?>">
                                                                    <span
                                                                        class="h6 fw-semibold mb-0 text-dark"><?php echo e(round($one)); ?>%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Progress-bar END -->
                                                </div>
                                            </div>
                                            <!-- Customer rating -->
                                            <div class="d-grid justify-items-center mt-4 mb-3">
                                                <?php if(Auth::user() && Auth::user()->type == 2): ?>
                                                    <button class="btn btn-primary fs-7 write-review"
                                                        data-item-id="<?php echo e($getitemdata->id); ?>"
                                                        data-item-name="<?php echo e($getitemdata->item_name); ?>"
                                                        data-item-image="<?php echo e(helper::image_path($getitemdata['item_image']->image_name)); ?>"><?php echo e(trans('labels.write_review')); ?></button>
                                                <?php else: ?>
                                                    <button class="btn btn-primary fs-7"
                                                        onclick="showlogin()"><?php echo e(trans('labels.write_review')); ?></button>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <!-- Customer Review -->
                                        <div class="col-md-12 col-lg-5 col-xxl-6">
                                            <h4 class="heading mb-3 fw-600 text-dark text-truncate">
                                                <?php echo e(trans('labels.customer_review')); ?>

                                            </h4>
                                            <?php if(count($itemreviewdata) > 0): ?>
                                                <?php $__currentLoopData = $itemreviewdata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reviewdata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="py-2">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="d-md-flex align-items-center">
                                                                    <!-- review avatar -->
                                                                    <div
                                                                        class="avatar avatar-lg mb-md-0 mb-2 flex-shrink-0 <?php echo e(session()->get('direction') == 2 ? ' ms-sm-3' : 'me-sm-3'); ?>">
                                                                        <img class="avatar-img rounded-circle w-100 h-100 object-fit-cover"
                                                                            src="<?php echo e($reviewdata->user_info->profile_image); ?>"
                                                                            alt="avatar">
                                                                    </div>
                                                                    <!-- review avatar -->

                                                                    <!-- review-content -->
                                                                    <div class="w-100">
                                                                        <div
                                                                            class="d-flex flex-wrap gap-2 justify-content-between mt-1 mt-md-0 mb-2">
                                                                            <div>
                                                                                <h6 class="mb-0 fw-600">
                                                                                    <?php echo e($reviewdata->user_info->name); ?>

                                                                                </h6>
                                                                                <!-- Info -->
                                                                                <p
                                                                                    class="text-muted fs-8 fw-500 mt-1 mb-0">
                                                                                    <?php echo e(helper::date_format($reviewdata->created_at)); ?>

                                                                                </p>
                                                                            </div>
                                                                            <!-- Review star -->
                                                                            <span class="fw-600 fs-6">
                                                                                <i
                                                                                    class="fas fa-star fa-fw text-warning fs-7"></i>
                                                                                <?php echo e($reviewdata->ratting > 0 ? number_format($reviewdata->ratting, 1) : 0); ?></span>
                                                                        </div>

                                                                        <p class="text-muted fs-7 fw-normal line-2 mb-0 ">
                                                                            <?php echo e($reviewdata->comment); ?>

                                                                        </p>
                                                                    </div>
                                                                    <!-- review-content -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                                <?php echo $__env->make('web.nodata', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <!-- RELATED PRODUCTS Section Start Here -->
    <?php if(count($getrelateditems) > 0): ?>
        <section class="menu py-5 m-0">
            <div class="container">
                <div class="row align-items-center justify-content-between mb-2 px-2">
                    <div class="col-auto menu-heading p-1">
                        <h2 class="text-capitalize fs-2 fw-600">
                            <?php echo e(trans('labels.related_items')); ?></h2>
                    </div>
                    <?php if(isset($county)): ?>
                        <div class="col-auto px-1 pb-2"><a
                                href="<?php echo e(URL::to($county.'/menu/' . $getitemdata['category_info']->slug)); ?>"
                                class="btn btn-outline-primary px-4 py-2"><?php echo e(trans('labels.view_all')); ?></a>
                        </div>
                    <?php else: ?>
                        <div class="col-auto px-1 pb-2"><a
                                href="<?php echo e(URL::to('menu/' . $getitemdata['category_info']->slug)); ?>"
                                class="btn btn-outline-primary px-4 py-2"><?php echo e(trans('labels.view_all')); ?></a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="row g-4">
                    <?php $__currentLoopData = $getrelateditems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $itemdata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo $__env->make('web.home1.itemview', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
    <!-- RELATED PRODUCTS Section End Here -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(url(env('ASSETSPATHURL') . 'web-assets/js/item-image-carousel/main.js')); ?>"></script>
    <script src="<?php echo e(url(env('ASSETSPATHURL') . 'web-assets/js/item-image-carousel/zoom-image.js')); ?>"></script>

    <script src="<?php echo e(url(env('ASSETSPATHURL') . 'web-assets/js/smoothproducts.js')); ?>"></script>
    <script>
        $('.sp-wrap').smoothproducts();
        window.onload = function() {
            getaddons("<?php echo e($getitemdata['id']); ?>"); // Call the function
        };

        var topdeals = "<?php echo e($getitemdata->is_top_deals == 1 ? 1 : 0); ?>";

        $(".write-review").click(function() {
            $("#data-item-name").text($(this).attr('data-item-name'));
            $("#data-item-id").val($(this).attr('data-item-id'));
            $("#reviewModal img").attr('src', $(this).attr('data-item-image'));
            $('#reviewModal').modal('show');
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/web/productdetails.blade.php ENDPATH**/ ?>