<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-auto mb-3">
    <div class="card rounded">
        <a href="{{ URL::to('item-' . $itemdata->slug) }}">
            <div class="p-2 item-type">
                @if ($itemdata->item_type == 1)
                    <img src="{{ helper::image_path('veg.svg') }}" alt=""
                        class="{{ session()->get('direction') == '2' ? 'ms-1' : 'me-1' }}">
                @else
                    <img src="{{ helper::image_path('nonveg.svg') }}" alt="">
                @endif
            </div>
            <div class="card-image card-one position-relative">
                <img src="{{ $itemdata['item_image']->image_url }}" class="card-img-top border-0 rounded-0 rounded-top"
                    alt="dishes">
                @if ($itemdata->available_qty <= 0 && $itemdata->has_variation == 2)
                    <h4 class="rounded-top text-overlay-centered">{{ trans('labels.out_of_stock') }}</h4>
                @endif
            </div>
            <div class="card-body pb-0">
                <div class="pb-2 cat-span">
                    <span>{{ $itemdata['category_info']->category_name }}</span>
                </div>
                <h5 class="item-card-title fs-6">
                    {{ $itemdata->item_name }}
                </h5>

            </div>
        </a>
        <div class="img-overlay-one set-fav-{{ $itemdata->id }} {{ session('direction') == 2 ? 'rtl' : ' ' }}">
            @if (Auth::user() && Auth::user()->type == 2)
                @if ($itemdata->is_favorite == 1)
                    <a class="heart-icon btn  p-1" href="javascript:void(0)"
                        onclick="managefavorite('{{ $itemdata->id }}',0,'{{ URL::to('/managefavorite') }}','{{ request()->url() }}')"
                        title="{{ trans('labels.remove_wishlist') }}">
                        <i class="fa-solid fa-heart text-red fs-5"></i> </a>
                @else
                    <a class="heart-icon btn  p-1" href="javascript:void(0)"
                        onclick="managefavorite('{{ $itemdata->id }}',1,'{{ URL::to('/managefavorite') }}','{{ request()->url() }}')"
                        title="{{ trans('labels.add_wishlist') }}">
                        <i class="fa-regular fa-heart text-red fs-5"></i> </a>
                @endif
            @endif
        </div>
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
        <div class="item-card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex justify-content-between align-items-center gap-2">
                    <span>{{ helper::currency_format($price) }}</span>
                    @if ($original_price > $price)
                        <del class="text-muted">{{ helper::currency_format($original_price) }}</del>
                    @endif
                </div>

                @if ($itemdata->is_cart == 1)
                    <div class="item-quantity">
                        <button type="button" class="btn btn-sm green_color fw-500"
                            onclick="removefromcart('{{ URL::to('/cart') }}','{{ trans('messages.remove_cartitem_note') }}','{{ trans('labels.goto_cart') }}')">-</button>
                        <input class="green_color fw-500 item-total-qty-{{ $itemdata->slug }}" type="text"
                            value="{{ helper::get_item_cart($itemdata->id) }}" disabled />
                        <button class="btn btn-sm green_color fw-500"
                            onclick="showitem('{{ $itemdata->slug }}','{{ URL::to('/show-item') }}')">+</button>
                    </div>
                @else
                    <button class="btn btn-sm border green_color fw-500 px-4 py-1"
                        onclick="showitem('{{ $itemdata->slug }}','{{ URL::to('/show-item') }}')">{{ trans('labels.add') }}</i></a></button>
                @endif

            </div>
        </div>
    </div>
</div>
