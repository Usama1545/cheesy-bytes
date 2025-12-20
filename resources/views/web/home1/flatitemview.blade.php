<div class="col-xl-4 col-lg-4 col-sm-6 col-xs-auto">
    <div class="card rounded-4 overflow-hidden h-100">
        @php
            use App\Helpers\helper;
            $categoryName = strtolower($itemdata['category_info']->category_name);
            $isPizza = $categoryName === 'pizza';
            $dealId = $deal['deal_id'];
            $originalPrice = $itemdata->original_price ?? $itemdata->item_price;
            $dealPrice = $itemdata->deal_discount ?? $originalPrice;
            $discount = $itemdata->deal_price ?? 0;
            $off = $originalPrice > 0 ? number_format(100 - ($dealPrice * 100) / $originalPrice, 1) : 0;

            $isInCart = $itemdata->is_cart == 1;
            $cartQty = $isInCart ? helper::getCartItemQty($itemdata->id) : 0;
        @endphp

        @if ($isPizza)
            <a data-bs-toggle="modal" data-bs-target="#PizzaModal" class="btn btn-sm fw-500 border-0 cursor-pointer"
                data-product-id="{{ $itemdata->id }}" data-size-id="{{ $deal['size_id'] }}"
                data-deal-id="{{ $dealId }}" data-original-price="{{ $originalPrice }}"
                data-deal-price="{{ $dealPrice }}">
                <div class="card-image">
                    <img src="{{ @helper::image_path($itemdata['item_image']->image_name) }}"
                        class="card-img-top border-0 rounded-0 rounded-top position-relative" alt="dishes">
                </div>
            </a>
        @else
            <a
                href="{{ helper::branch_route('itemdetails', ['slug' => $itemdata->slug, 'deal_id' => $dealId, 'deal_price' => $dealPrice]) }}">
                <div class="card-image">
                    <img src="{{ @helper::image_path($itemdata['item_image']->image_name) }}"
                        class="card-img-top border-0 rounded-0 rounded-top position-relative" alt="dishes">
                </div>
            </a>
        @endif

        <div class="card-body pb-0 border-bottom">
            <div class="d-flex align-items-center mb-2 justify-content-between">
                <div class="cat-name py-1 px-2 col-auto text-center">
                    <span>{{ $itemdata['category_info']->category_name }}</span>
                </div>
                <div>
                    <div class="d-flex fs-8 align-items-center">
                        <i class="fa-solid fa-star text-warning"></i>
                        <p class="m-0 text-dark fw-500 {{ session()->get('direction') == '2' ? 'pe-1' : 'ps-1' }}">
                            {{ number_format($itemdata->avg_ratting, 1) }}</p>
                    </div>
                </div>
            </div>

            <h5 class="item-card-title pb-3 fs-6 d-flex">
                <div class="d-flex align-items-center gap-1">
                    @if ($isPizza)
                        <a data-bs-toggle="modal" data-bs-target="#PizzaModal"
                            class="btn btn-sm fw-500 border-0 cursor-pointer" data-product-id="{{ $itemdata->id }}"
                            data-size-id="{{ $deal['size_id'] }}" data-deal-id="{{ $dealId }}"
                            data-original-price="{{ $originalPrice }}" data-deal-price="{{ $dealPrice }}">
                        @else
                            <a
                                href="{{ helper::branch_route('itemdetails', ['slug' => $itemdata->slug, 'deal_id' => $dealId, 'deal_price' => $dealPrice]) }}">
                    @endif
                    <p class="item-card-title mb-0 line-2 fs-7">
                        {{ $itemdata->item_name }}
                    </p>
                    </a>
                    @if ($itemdata->item_allergens != null)
                        <div type="button"
                            onclick="itemsallergens('{{ $itemdata->id }}','{{ route('get_item_allergens') }}')">
                            <div class="btn-info">
                                <i class="fa-solid fa-info"></i>
                            </div>
                        </div>
                    @endif
                </div>
            </h5>
        </div>

        @if ($off > 0)
            <div class="offer-lable {{ session()->get('direction') == '2' ? 'rtl' : '' }}">
                <h5>{{ $off }}% {{ trans('labels.off') }}</h5>
            </div>
        @endif

        <div class="item-card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex justify-content-between align-items-center gap-2">
                    <span class="text-primary fw-bold">{{ helper::currency_format($dealPrice) }}</span>
                    @if ($originalPrice > $dealPrice)
                        <del class="text-muted">{{ helper::currency_format($originalPrice) }}</del>
                    @endif
                </div>

                @if ($isInCart)
                    <div class="item-quantity py-1 px-5">
                        <button type="button" class="btn btn-sm fw-500"
                            onclick="removefromcart('{{ helper::branch_route('cart') }}','{{ trans('messages.remove_cartitem_note') }}','{{ trans('labels.goto_cart') }}')">
                            -
                        </button>
                        <input class="fw-500 item-total-qty-{{ $itemdata->slug }}" type="text"
                            value="{{ helper::get_item_cart($itemdata->id) }}" disabled />
                        @if ($isPizza)
                            <a data-bs-toggle="modal" data-bs-target="#PizzaModal" class="btn btn-sm fw-500 border-0"
                                data-size-id="{{ $deal['size_id'] }}" data-deal-id="{{ $dealId }}"
                                data-product-id="{{ $itemdata->id }}">+</a>
                        @else
                            <button class="btn btn-sm fw-500 border-0"
                                onclick="showBogoDealItem('{{ $itemdata->slug }}','{{ $dealId }}','{{ $categoryId }}','{{ URL::to('/show-bogo-deal-item') }}')">
                                +
                            </button>
                        @endif
                    </div>
                @else
                    @if ($isPizza)
                        <button
                            class="btn btn-sm btn-secondary fw-500 py-2 px-4 float-end rounded-3 d-flex gap-2 justify-content-center align-items-center addon_modal_{{ $itemdata->slug }}"
                            data-bs-toggle="modal" data-bs-target="#PizzaModal" data-size-id="{{ $deal['size_id'] }}"
                            data-deal-id="{{ $dealId }}" data-product-id="{{ $itemdata->id }}">
                            {{ trans('labels.add') }}
                            <i class="fa-solid fa-plus addon_modal_icon_{{ $itemdata->slug }}"></i>
                            <div class="loader d-none addon_modal_loader_{{ $itemdata->slug }}"></div>
                        </button>
                    @else
                        <button
                            class="btn btn-sm btn-secondary fw-500 py-2 px-4 float-end rounded-3 d-flex gap-2 justify-content-center align-items-center addon_modal_{{ $itemdata->slug }}"
                            onclick="showBogoDealItem('{{ $itemdata->slug }}','{{ $dealId }}','{{ URL::to('/show-bogo-deal-item') }}')">
                            {{ trans('labels.add') }}
                            <i class="fa-solid fa-plus addon_modal_icon_{{ $itemdata->slug }}"></i>
                            <div class="loader d-none addon_modal_loader_{{ $itemdata->slug }}"></div>
                        </button>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
