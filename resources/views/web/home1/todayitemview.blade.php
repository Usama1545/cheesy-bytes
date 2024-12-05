<div class="col-lg-6 col-md-6 col-12">
    <div class="card rounded-4 h-100" style="border-color: var(--bs-primary)">
        <div class="d-flex align-items-center p-2 h-100">
            <div class="card-image card-second d-flex align-items-center col-auto position-relative">
                <a href="{{ URL::to('item-' . $itemdata->slug) }}">
                    <img src="{{ @helper::image_path($itemdata['item_image']->image_name) }}"
                        class="card-img-top border-0 rounded-4" alt="dishes">
                </a>
            </div>
            <div class="card-body py-0 {{ session()->get('direction') == '2' ? 'pe-3 ps-0' : 'ps-3 pe-0' }}">
                @php
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
                @endphp
                <!-- off lable -->
                @if ($off > 0)
                    <div class="offer-lable d-flex mb-1">
                        <h5>{{ $off }}% {{ trans('labels.off') }}</h5>
                    </div>
                @endif
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <div class="fs-8 cat-span text-muted">
                        <span>{{ $itemdata['category_info']->category_name }}</span>
                    </div>
                    {{-- rating --}}
                    <div class="d-flex fs-8 align-items-center">
                        <i class="fa-solid fa-star text-warning"></i>
                        <p class="m-0 text-dark fw-500 {{ session()->get('direction') == '2' ? 'pe-1' : 'ps-1' }}">
                            {{ number_format($itemdata->avg_ratting, 1) }}</p>
                    </div>
                </div>
                <h5 class="fs-6 mb-0 item-card-title d-flex text-h">
                    @if ($itemdata->item_type == 1)
                        <img src="{{ helper::image_path('veg.svg') }}" alt=""
                            class="{{ session()->get('direction') == '2' ? 'ms-1' : 'me-1' }}">
                    @else
                        <img src="{{ helper::image_path('nonveg.svg') }}" alt=""
                            class="{{ session()->get('direction') == '2' ? 'ms-1' : 'me-1' }}">
                    @endif
                    <div class="d-flex gap-1">
                        <a href="{{ URL::to('item-' . $itemdata->slug) }}">
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
                <div class="item-card-footer-2 pt-2">
                    <div class="d-sm-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-between align-items-center gap-2">
                            <p class="fs-6 fw-500">
                                <span>{{ helper::currency_format($price) }}</span>
                                @if ($original_price > $price)
                                    <del class="text-muted">{{ helper::currency_format($original_price) }}</del>
                                @endif
                            </p>
                        </div>
                        <div class="d-sm-flex gap-2 align-items-center mt-lg-0 mt-1 d-none">
                            @if ($itemdata->is_cart == 1)
                                <div class="item-quantity py-1 px-5">
                                    <button type="button" class="btn btn-sm  fw-500"
                                        onclick="removefromcart('{{ URL::to('/cart') }}','{{ trans('messages.remove_cartitem_note') }}','{{ trans('labels.goto_cart') }}')">-</button>
                                    <input class="fw-500 item-total-qty-{{ $itemdata->slug }}" type="text"
                                        value="{{ helper::get_item_cart($itemdata->id) }}" disabled />
                                    <button class="btn btn-sm fw-500 border-0"
                                        onclick="showitem('{{ $itemdata->slug }}','{{ URL::to('/show-item') }}')">+</button>
                                </div>
                            @else
                                <button
                                    class="btn btn-sm btn-secondary fw-500 py-2 px-4 float-end rounded-3 d-flex gap-2 justify-content-center align-items-center addon_modal_{{ $itemdata->slug }}"
                                    onclick="showitem('{{ $itemdata->slug }}','{{ URL::to('/show-item') }}')">
                                    {{ trans('labels.add') }}
                                    <i class="fa-solid fa-plus addon_modal_icon_{{ $itemdata->slug }}"></i>
                                    <div class="loader d-none addon_modal_loader_{{ $itemdata->slug }}"></div>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
