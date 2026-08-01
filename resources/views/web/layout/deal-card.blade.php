@php
    $priceData = \App\Helpers\Helper::calculatePrice($item);
    $price = $priceData['price'];
    $originalPrice = $priceData['original_price'];
    $buttonConfig = \App\Helpers\Helper::getButtonConfig($item);

    // Set classes based on type
    $type = $type ?? ($isMain ? 'main' : 'side');
    $cardClass = "deal-card deal-card-{$type}";
    $priceClass = "price-{$type}";

    // Add extra styling if main
    if ($type === 'main') {
        $cardClass .= ' main-highlight';
    }
@endphp

<div class="{{ $cardClass }}">
    <!-- Image container to handle any image size -->
    <div class="image-container">
        <img src="{{ helper::image_path($item->web_image) }}" alt="{{ $item->product->item_name ?? 'Deal' }}"
            class="deal-image" onerror="this.src='{{ asset('images/placeholder.jpg') }}'" loading="lazy" decoding="async">
    </div>

    <div class="deal-overlay">
        <div>
            <!-- Optional product name -->
            {{-- <div class="product-name h5 mb-1">{{ $item->product->item_name ?? '' }}</div> --}}

            @if ($type === 'side' && ($index ?? 0) >= 1)
                <div class="deal-description">
                    {{ Str::limit($item->product->item_description ?? '', 100) }}
                </div>
            @endif

            @if ($type === 'extra')
                <div class="product-name small fw-bold">
                    {{ Str::limit($item->product->item_name ?? '', 40) }}
                </div>
            @endif
        </div>

        <div>
            @if ($item->deal_type !== 3 && $item->deal_type !== 2 && $item->deal_type !== 0)
                <div class="price-display mb-2">
                    <!-- Clean price display -->
                    <div class="d-flex align-items-baseline flex-wrap">
                        <span class="{{ $priceClass }} me-1">${{ number_format($price, 2) }}</span>
                        <small class="text-light">each</small>
                    </div>

                    @if ($originalPrice > $price)
                        <div class="original-price">
                            <del>${{ number_format($originalPrice, 2) }}</del>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Button -->
            @if ($buttonConfig['type'] === 'link')
                <a href="{{ $buttonConfig['url'] }}" class="deal-button addon_modal_{{ $item->product->slug }}"
                    onclick="event.stopPropagation()">
                    <span>{{ $buttonConfig['text'] }}</span>
                    <i class="fa-solid fa-plus"></i>
                    <div class="loader d-none addon_modal_loader_{{ $item->product->slug }}"></div>
                </a>
            @else
                <button onclick="{{ $buttonConfig['action'] }}"
                    class="deal-button addon_modal_{{ $item->product->slug }}" type="button">
                    <span>{{ $buttonConfig['text'] }}</span>
                    <i class="fa-solid fa-plus"></i>
                    <div class="loader d-none addon_modal_loader_{{ $item->product->slug }}"></div>
                </button>
            @endif
        </div>
    </div>
</div>
