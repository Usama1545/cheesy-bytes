<div class="col-lg-6 col-md-6 col-12">
    <div class="card rounded-4 h-100" style="border-color: var(--bs-primary)">
        <div class="d-flex align-items-center p-2 h-100">
            <div class="card-image card-second d-flex align-items-center col-auto position-relative">

                <img src="{{ @helper::image_path($itemdata->product['item_image']->image_name) }}"
                     class="card-img-top border-0 rounded-4" alt="dishes" loading="lazy" decoding="async">

            </div>
            <div class="card-body py-0 {{ session()->get('direction') == '2' ? 'pe-3 ps-0' : 'ps-3 pe-0' }}">

                @php
                    if($itemdata->deal_type !== 3 && $itemdata->deal_type !== 1)
                    {
                        if(@$itemdata->offer_type !== 1)
                        {
                                if (@$itemdata->offer_type == 1) {
                                    if ($itemdata->dealPrice > @$itemdata->offer_amount) {
                                        $price = $itemdata->dealPrice - @$itemdata->offer_amount;
                                    } else {
                                        $price = $itemdata->dealPrice;
                                    }
                                } else {
                                    $price = $itemdata->dealPrice - $itemdata->dealPrice * (@$itemdata->offer_amount / 100);
                                }
                                $original_price = $itemdata->dealPrice;
                                $off = $original_price > 0 ? number_format(100 - ($price * 100) / $original_price, 1) : 0;
                        }
                        else if(@$itemdata->offer_type !== 1 && @$itemdata->deal_type == 1){
                            $price = $itemdata->product->original_price - $itemdata->dealPrice;
                            $off= 0;
                            $original_price =  $itemdata->product->original_price ?? $itemdata->offer_amount;
                        } else{
                            $price = $itemdata->dealPrice - $itemdata->offer_amount;
                            $original_price =  $itemdata->dealPrice;
                            $off = $original_price > 0 ? number_format(100 - ($price * 100) / $original_price, 1) : 0;
                        }
                    } else {
                        $price = $itemdata->dealPrice;
                        $off= 0;
                        $original_price =  $itemdata->product->original_price;
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
                        <!--<span>{{ $itemdata->product['category_info']->category_name }}</span>-->
                    </div>
                    {{-- rating --}}
                    <!--<div class="d-flex fs-8 align-items-center">-->
                    <!--    <i class="fa-solid fa-star text-warning"></i>-->
                    <!--    <p class="m-0 text-dark fw-500 {{ session()->get('direction') == '2' ? 'pe-1' : 'ps-1' }}">-->
                    <!--        {{ number_format($itemdata->product->avg_ratting, 1) }}</p>-->
                    <!--</div>-->
                </div>
                <h5 class="fs-6 mb-0 item-card-title d-flex text-h">
                    <div class="d-flex gap-1">
                        @if($itemdata->deal_type == 1 || $itemdata->deal_type == 3 || $itemdata->deal_type == 4)

                            <a class="cursor-pointer" >
                                @else
                                    <a class="cursor-pointer"
                                       onclick="showdealitem('{{ $itemdata->product->slug }}','{{ $itemdata->deal_id }}','{{ URL::to('/show-deal-item') }}')">

                                        @endif
                                        <p class="item-card-title mb-0 line-2 fs-7">
                                            {{ $itemdata->product->item_name }}
                                        </p>
                                    </a>
                                    @if ($itemdata->product->item_allergens != null)
                                        <div type="button"
                                             onclick="itemsallergens('{{ $itemdata->product->id }}','{{ route('get_item_allergens') }}')">
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
                                @if($itemdata->deal_type !== 3)
                                    <span>{{ helper::currency_format($price) }}</span>
                                    @if ($original_price > $price)
                                        <del class="text-muted">{{ helper::currency_format($original_price) }}</del>
                                    @endif
                                @endif
                            </p>
                        </div>
                        <div class="d-sm-flex gap-2 align-items-center mt-lg-0 mt-1">
                            @if ($itemdata->is_cart == 1 && $itemdata->deal_type !== 3 && $itemdata->deal_type !== 4 && $itemdata->deal_type !== 1)
                                <div class="item-quantity py-1 px-5">
                                    <button type="button" class="btn btn-sm  fw-500"
                                            onclick="removefromcart('{{ helper::branch_route('cart') }}','{{ trans('messages.remove_cartitem_note') }}','{{ trans('labels.goto_cart') }}')">
                                        -
                                    </button>
                                    <input class="fw-500 item-total-qty-{{ $itemdata->product->slug }}" type="text"
                                           value="{{ helper::get_item_cart($itemdata->product->id) }}" disabled/>

                                    <button class="btn btn-sm fw-500 border-0"
                                            onclick="showdealitem('{{ $itemdata->product->slug }}','{{ $itemdata->deal_id }}','{{ URL::to('/show-deal-item') }}')">
                                        +
                                    </button>
                                </div>
                            @else
                                @if($itemdata->deal_type == 1 || $itemdata->deal_type == 3 || $itemdata->deal_type == 4)
                                    <a
                                        class="btn btn-sm deal-button btn-secondary fw-500 py-2 px-3 float-start rounded-3 d-flex gap-1 justify-content-center align-items-center addon_modal_{{ $itemdata->product->slug }}"
                                        href="{{ helper::branch_route('bogoDealDetails', ['id' => $itemdata->deal_id]) }}"
                                    >
                                        Select
                                        <i class="fa-solid fa-plus addon_modal_icon_{{ $itemdata->product->slug }}"></i>
                                        <div class="loader d-none addon_modal_loader_{{ $itemdata->product->slug }}"></div>
                                    </a>
                                @else
                                    <button
                                        class="btn btn-sm btn-secondary fw-500 py-2 px-4 float-end rounded-3 d-flex gap-2 justify-content-center align-items-center addon_modal_{{ $itemdata->product->slug }}"
                                        onclick="showdealitem('{{ $itemdata->product->slug }}','{{ $itemdata->deal_id }}','{{ URL::to('/show-deal-item') }}')">
                                        {{ trans('labels.add') }}
                                        <i class="fa-solid fa-plus addon_modal_icon_{{ $itemdata->product->slug }}"></i>
                                        <div
                                            class="loader d-none addon_modal_loader_{{ $itemdata->product->slug }}"></div>
                                    </button>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
