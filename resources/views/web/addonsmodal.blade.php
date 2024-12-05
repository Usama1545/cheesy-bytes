<div class="modal-header justify-content-between align-items-start">
    <div class="">
        <div class="d-flex gap-1">
            <span>
                <img src="{{ $itemdata['item_type_image'] }}" class="item-type-image" alt="">
            </span>
            <div class="d-grid">
                <p class="modal-title fs-6 fw-600">{{ $itemdata['item_name'] }}</p>
                <div class="d-flex gap-3">
                    <div class="d-flex align-items-center">
                        @php
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
                        @endphp
                        <p class="mb-0 fw-500 fs-7 text-black subtotal_{{ $itemdata['id'] }}">
                            {{ helper::currency_format($price) }}
                        </p>
                    </div>
                    <div class="d-flex">
                    </div>
                </div>

                @if ($itemdata['tax'] != '' && $itemdata['tax'] != 0)
                    <span class="text-danger fs-7">{{ trans('labels.exclusive_taxes') }}</span>
                @else
                    <span class="text-danger fs-7">{{ trans('labels.inclusive_taxes') }}</span>
                @endif

            </div>
        </div>
    </div>
    <button type="button" class="btn-close m-0 {{ session()->get('direction') == '2' ? 'm-0' : '' }}"
        data-bs-dismiss="modal" aria-label="Close"></button>
</div>



<div class="modal-body py-0">
    <div class="row align-items-center">
        {{-- Item Addon --}}
        <div class="item-details">
            @foreach ($itemdata['addons_group'] as $addons_group)
                @php
                    $availableAddons = collect($itemdata['addons'])->where('addongroup_id', $addons_group->id);
                @endphp
                @if ($availableAddons->isNotEmpty())
                    <div class="item-addons-list mt-3 border-bottom pb-3"
                        id="item_addons_group_{{ $itemdata['id'] }}_{{ $addons_group->id }}">
                        <h5 class="mb-1 fs-6">{{ $addons_group->name }}</h5>
                        <div class="d-flex align-items-center gap-1">
                            @if ($addons_group->selection_type == 1)
                                <i class="fa-solid fa-triangle-exclamation addon_group_color fs-8"
                                    id="addon_required_icon_{{ $addons_group->id }}_{{ $itemdata['id'] }}"></i>
                                <span class="fs-8 fw-600 addon_group_color"
                                    id="addon_required_text_{{ $addons_group->id }}_{{ $itemdata['id'] }}">{{ trans('labels.required') }}</span>
                                <span class="fs-8">•</span>
                            @elseif ($addons_group->selection_type == 2)
                                <span class="fs-8">({{ trans('labels.optional') }})</span>
                                <span class="fs-8">•</span>
                            @endif
                            @if ($addons_group->selection_count == 1)
                                <span class="fs-8">{{ trans('labels.select') }} 1</span>
                            @else
                                <span class="fs-8">{{ trans('labels.min') }}
                                    {{ $addons_group->min_count }} |
                                    {{ trans('labels.max') }}
                                    {{ $addons_group->max_count }}
                                </span>
                            @endif
                        </div>
                        @foreach ($itemdata['addons'] as $addons)
                            @if ($addons->addongroup_id == $addons_group->id)
                                <div
                                    class="{{ session()->get('direction') == '2' ? 'd-flex gap-2 me-2' : 'form-check' }}">
                                    @php
                                        if ($addons_group->selection_count == 1) {
                                            $type = 'radio';
                                        } elseif ($addons_group->selection_count == 2) {
                                            $type = 'checkbox';
                                        }
                                    @endphp
                                    <input
                                        class="form-check-input cursor-pointer addons_chk_{{ $itemdata['id'] }} {{ session()->get('direction') == '2' ? 'ms-0' : '' }}"
                                        type="{{ $type }}" value="{{ $addons->id }}"
                                        data-addons-id="{{ $addons->id }}" data-addons-price="{{ $addons->price }}"
                                        data-addons-name="{{ $addons->name }}"
                                        onclick="getaddons('{{ $itemdata['id'] }}')"
                                        id="addons_{{ $addons->id }}_{{ $addons_group->id }}_{{ $itemdata['id'] }}"
                                        name="addons_id_{{ $addons_group->id }}_{{ $itemdata['id'] }}">
                                    <div class="d-flex justify-content-between w-100">
                                        <label class="form-check-label cursor-pointer fs-7"
                                            for="addons_{{ $addons->id }}_{{ $addons_group->id }}_{{ $itemdata['id'] }}">{{ $addons->name }}</label>
                                        <label class="form-check-label cursor-pointer fs-7"
                                            for="addons_{{ $addons->id }}_{{ $addons_group->id }}_{{ $itemdata['id'] }}">

                                            {{ helper::currency_format($addons->price) }}
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @if ($addons_group->selection_type == 1)
                            <span
                                class="addons_error_{{ $addons_group->id }}_{{ $itemdata['id'] }} text-danger fs-7 ms-2"></span>
                        @endif
                    </div>
                @endif
            @endforeach
            <input type="hidden" name="addongroup" id="addongroup_{{ $itemdata['id'] }}"
                data-addongroup_val="{{ $itemdata['addons_group'] }}">
            <input type="hidden" name="slug" id="slug_{{ $itemdata['id'] }}" value="{{ $itemdata['slug'] }}">
            <input type="hidden" name="item_name" id="item_name_{{ $itemdata['id'] }}"
                value="{{ $itemdata['item_name'] }}">
            <input type="hidden" name="item_type" id="item_type_{{ $itemdata['id'] }}"
                value="{{ $itemdata['item_type'] }}">
            <input type="hidden" name="image_name" id="image_name_{{ $itemdata['id'] }}"
                value="{{ $itemdata['image_name'] }}">
            <input type="hidden" name="tax" id="item_tax_{{ $itemdata['id'] }}" value="{{ $itemdata['tax'] }}">
            <input type="hidden" name="item_price" id="item_price_{{ $itemdata['id'] }}" value="{{ $price }}">
            <input type="hidden" name="login_required" id="login_required_{{ $itemdata['slug'] }}"
                value="{{ helper::appdata()->login_required }}">
            <input type="hidden" name="checklogin" id="checklogin_{{ $itemdata['slug'] }}"
                value="{{ Auth::user() && Auth::user()->type == 2 }}">
            <input type="hidden" name="customer_login" id="customer_login_{{ $itemdata['slug'] }}"
                value="{{ App\Models\SystemAddons::where('unique_identifier', 'customer_login')->first() }}">
        </div>
        {{-- Item Extra --}}
        @if (!empty($itemdata['extras']) && count($itemdata['extras']) > 0)
            <div class="item-details">
                <div class="item-addons-list mt-3 border-bottom pb-3">
                    <h5 class="mb-1 fs-6">{{ trans('labels.extras') }}</h5>
                    @foreach ($itemdata['extras'] as $extras)
                        <div class="{{ session()->get('direction') == '2' ? 'd-flex gap-2 me-2' : 'form-check' }}">
                            <input
                                class="form-check-input cursor-pointer extras_chk_{{ $itemdata['id'] }} {{ session()->get('direction') == '2' ? 'ms-0' : '' }}"
                                type="checkbox" value="{{ $extras->id }}" data-extras-id="{{ $extras->id }}"
                                data-extras-price="{{ $extras->price }}" data-extras-name="{{ $extras->name }}"
                                id="extras_{{ $extras->id }}_{{ $itemdata['id'] }}"
                                name="extras_id_{{ $itemdata['id'] }}">
                            <div class="d-flex justify-content-between w-100 ">
                                <label class="form-check-label cursor-pointer fs-7"
                                    for="extras_{{ $extras->id }}_{{ $itemdata['id'] }}">{{ $extras->name }}</label>
                                <label class="form-check-label cursor-pointer fs-7"
                                    for="extras_{{ $extras->id }}_{{ $itemdata['id'] }}">

                                    {{ helper::currency_format($extras->price) }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
        @endif
        <input type="hidden" name="addongroup" id="addongroup_{{ $itemdata['id'] }}"
            data-addongroup_val="{{ $itemdata['addons_group'] }}">
        <input type="hidden" name="slug" id="slug_{{ $itemdata['id'] }}" value="{{ $itemdata['slug'] }}">
        <input type="hidden" name="item_name" id="item_name_{{ $itemdata['id'] }}"
            value="{{ $itemdata['item_name'] }}">
        <input type="hidden" name="item_type" id="item_type_{{ $itemdata['id'] }}"
            value="{{ $itemdata['item_type'] }}">
        <input type="hidden" name="image_name" id="image_name_{{ $itemdata['id'] }}"
            value="{{ $itemdata['image_name'] }}">
        <input type="hidden" name="tax" id="item_tax_{{ $itemdata['id'] }}" value="{{ $itemdata['tax'] }}">
        <input type="hidden" name="item_price" id="item_price_{{ $itemdata['id'] }}" value="{{ $price }}">
        <input type="hidden" name="login_required" id="login_required_{{ $itemdata['slug'] }}"
            value="{{ helper::appdata()->login_required }}">
        <input type="hidden" name="checklogin" id="checklogin_{{ $itemdata['slug'] }}"
            value="{{ Auth::user() && Auth::user()->type == 2 }}">
        <input type="hidden" name="customer_login" id="customer_login_{{ $itemdata['slug'] }}"
            value="{{ App\Models\SystemAddons::where('unique_identifier', 'customer_login')->first() }}">
    </div>
</div>
</div>
<div class="modal-footer d-block py-0 item-details border-0">
    <div class="w-100 m-0 py-2 border-bottom border-top">
        <div class="row align-items-center justify-content-between g-2">
            <div class="col-sm-2">
                <div class="item-quantity py-2 w-100">
                    <button class="btn btn-sm fw-500 p-0 fs-6"
                        onclick="changeqty('{{ $itemdata['slug'] }}','minus')">-</button>
                    <input type="text" class="p-0" name="number" value="1"
                        id="item_qty_{{ $itemdata['slug'] }}" readonly="">
                    <button class="btn btn-sm fw-500 p-0 fs-6"
                        onclick="changeqty('{{ $itemdata['slug'] }}','plus')">+</button>
                </div>
            </div>
            <div class="col-sm-5">
                <button
                    class="btn btn-secondary w-100 m-0 fs-7 fw-500 rounded-3 d-flex gap-3 justify-content-center align-items-center addon_modal_cart"
                    onclick="addtocart('{{ URL::to('addtocart') }}','{{ $itemdata['id'] }}','0')">
                    {{ trans('labels.add_to_cart') }}
                    <div class="loader d-none addon_modal_cart_loader"></div>
                </button>
            </div>
            <div class="col-sm-5">
                <button
                    class="btn btn-primary w-100 m-0 fs-7 fw-500 rounded-3 d-flex gap-3 justify-content-center align-items-center addon_modal_quick_order"
                    onclick="addtocart('{{ URL::to('addtocart') }}','{{ $itemdata['id'] }}','1')">
                    {{ trans('labels.quick_order') }}
                    <div class="loader d-none addon_modal_quick_order_loader"></div>
                </button>
            </div>
        </div>
    </div>
    <div class="d-flex flex-wrap justify-content-between align-items-center">
        <div class="col-sm-6 set-fav-{{ $itemdata['id'] }}">
            @if ($itemdata['is_favorite'] == '1')
                <a class="text-dark fw-500 d-flex fs-6 gap-1 py-2 align-items-center"
                    @if (Auth::user() && Auth::user()->type == 2) href="javascript:void(0)" onclick="managefavorite('{{ $itemdata['id'] }}',0,'{{ URL::to('/managefavorite') }}')" @else href="{{ URL::to('/login') }}" @endif>
                    <i class="fa-solid fa-heart fs-6"></i>
                    {{ trans('labels.remove_wishlist') }}
                </a>
            @else
                <a class="text-dark fw-500 d-flex fs-6 gap-1 py-2 align-items-center"
                    @if (Auth::user() && Auth::user()->type == 2) href="javascript:void(0)" onclick="managefavorite('{{ $itemdata['id'] }}',1,'{{ URL::to('/managefavorite') }}')" @else href="{{ URL::to('/login') }}" @endif>
                    <i class="fa-regular fa-heart fs-6"></i>
                    {{ trans('labels.add_wishlist') }}
                </a>
            @endif
        </div>
        <div class="col-sm-6">
            <div class="d-flex align-items-center justify-content-end gap-2">
                @if (helper::appdata()->google_review_url != '')
                    <a href="{{ helper::appdata()->google_review_url }}" class="icon-box" target="_blank"
                        tooltip="{{ trans('labels.review') }}">
                        <i class="fa-solid fa-star fs-9"></i>
                    </a>
                @endif
                @if (helper::appdata()->mobile != '')
                    <a href="callto:{{ helper::appdata()->mobile }}" tooltip="{{ trans('labels.call') }}"
                        class="icon-box">
                        <i class="fa-solid fa-phone fs-9"></i>
                    </a>
                @endif
                @if (@helper::checkaddons('whatsapp_message'))
                    @if (whatsapp_helper::whatsapp_message_config()->whatsapp_number != '')
                        <a href="https://api.whatsapp.com/send?phone={{ whatsapp_helper::whatsapp_message_config()->whatsapp_number }}'&text={{ $itemdata['item_name'] }}"
                            target="_blank" tooltip="{{ trans('labels.whatsapp') }}" class="icon-box">
                            <i class="fa-brands fa-whatsapp fs-9"></i>
                        </a>
                    @endif
                @endif
                @if ($itemdata['video_url'] != '')
                    <a href="{{ $itemdata['video_url'] }}" target="_blank" tooltip="{{ trans('labels.video') }}"
                        class="icon-box">
                        <i class="fa-solid fa-video fs-9"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
