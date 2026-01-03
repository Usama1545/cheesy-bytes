<?php
use App\Helpers\helper;

$helper = new App\Helpers\helper();
$itemData = $helper->getTopHomeDeals();
$count = count($itemData);

$mainItem = $itemData->first();
$sideItems = $itemData->slice(1, 2); // Only 2 side items
$extraItems = $itemData->slice(3); // Items 4+
?>

<div class="container container-model py-5">
    <!-- TOP SECTION: Main + Side deals -->
    <div class="deals-wrapper">
        @if ($mainItem)
            <!-- Main Deal (Left) -->
            <div class="main-deal-container">
                @include('web.layout.deal-card', [
                    'item' => $mainItem,
                    'isMain' => true,
                    'type' => 'main',
                ])
            </div>
        @endif

        @if (count($sideItems) > 0)
            <!-- Side Deals (Right, max 2) -->
            <div class="side-deals-container">
                @foreach ($sideItems as $index => $item)
                    @include('web.layout.deal-card', [
                        'item' => $item,
                        'index' => $index,
                        'isMain' => false,
                        'type' => 'side',
                    ])
                @endforeach
            </div>
        @endif
    </div>

    <!-- BOTTOM SECTION: Extra deals (3+) -->
    @if (count($extraItems) > 0)
        <div class="extra-deals-grid">
            @foreach ($extraItems as $item)
                @include('web.layout.deal-card', [
                    'item' => $item,
                    'isMain' => false,
                    'type' => 'extra',
                ])
            @endforeach
        </div>
    @endif
</div>

<style>
    .container-model {
        max-width: 1200px;
        margin: 0 auto;
        background-color: transparent;
    }

    /* TOP SECTION LAYOUT */
    .deals-wrapper {
        display: flex;
        gap: 15px;
        width: 100%;
        margin-bottom: 20px;
        align-items: stretch;
        /* Make sure all items stretch to same height */
    }

    .main-deal-container {
        flex: 1;
        min-width: 0;
    }

    .side-deals-container {
        flex: 0 0 400px;
        /* Fixed width for side column */
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    /* BOTTOM GRID LAYOUT */
    .extra-deals-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        width: 100%;
    }

    /* UNIFORM ASPECT RATIO FOR ALL IMAGES - THIS IS CRITICAL */
    .deal-card {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        background: #f8f9fa;
        aspect-ratio: 4 / 3;
    }

    /* Image wrapper fills card */
    .image-container {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
    }

    .deal-image {
        max-width: 100%;
        max-height: 100%;
        width: auto;
        height: auto;
        object-fit: contain;
        display: block;
    }

    /* Overlay */
    .deal-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        padding: 20px;
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        background: linear-gradient(to bottom,
                transparent 0%,
                transparent 50%,
                rgba(0, 0, 0, 0.6) 80%,
                rgba(0, 0, 0, 0.8) 100%);
        pointer-events: none;
        position: absolute;
        inset: 0;
        z-index: 2;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        pointer-events: none;
        /* Allow clicking through overlay */
    }

    /* Make button clickable */
    .deal-overlay>div:last-child {
        pointer-events: auto;
    }

    .deal-button {
        background: #dc3545 !important;
        border: none;
        color: white;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s ease;
        width: fit-content;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .deal-button:hover {
        background: #c82333 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    /* Price display - adjust for position */
    .price-main {
        font-size: 2.2rem;
        font-weight: 700;
    }

    .price-side {
        font-size: 1.6rem;
        font-weight: 700;
    }

    .price-extra {
        font-size: 1.4rem;
        font-weight: 600;
    }

    .original-price {
        font-size: 0.9rem;
        opacity: 0.8;
        margin-top: 2px;
    }

    /* Deal description */
    .deal-description {
        font-size: 13px;
        line-height: 1.3;
        color: rgba(255, 255, 255, 0.9);
        margin-top: 5px;
    }

    /* RESPONSIVE BREAKPOINTS */
    @media (min-width: 1200px) {
        .side-deals-container {
            flex: 0 0 400px;
        }

        .main-deal-container .deal-card {
            aspect-ratio: 4 / 3;
            /* Same as all others */
        }
    }

    @media (min-width: 992px) and (max-width: 1199px) {
        .side-deals-container {
            flex: 0 0 350px;
        }

        .extra-deals-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    /* Tablet */
    @media (min-width: 768px) and (max-width: 991px) {
        .deals-wrapper {
            flex-direction: column;
        }

        .side-deals-container {
            flex: none;
            width: 100%;
            flex-direction: row;
        }

        .side-deals-container .deal-card {
            flex: 1;
        }

        .extra-deals-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* Mobile */
    @media (max-width: 767px) {
        .deals-wrapper {
            flex-direction: column;
            gap: 15px;
        }

        .side-deals-container {
            flex: none;
            width: 100%;
        }

        .extra-deals-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        /* All cards same on mobile */
        .deal-card {
            aspect-ratio: 4 / 3;
        }

        .price-main,
        .price-side,
        .price-extra {
            font-size: 1.8rem;
            /* Uniform size on mobile */
        }
    }
</style>
