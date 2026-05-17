<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Models\Cart;
use App\Models\Item;
use App\Models\TopDeals;
use App\Models\ProductSizeCrust;
use App\Models\PizzaPrice;
use App\Models\ItemImages;
use App\Models\itemPrice;
use App\Models\DealCategory;
use App\Helpers\helper;


class BogoAutoAddService
{
    /**
     * Auto-add free items after a required item is added
     * 
     * @param Cart $cart The cart item that was just added
     * @return array List of auto-added items
     */
    public static function autoAddFreeItems($cart, $branchId = null)
    {
        Log::info('=== BOGO AutoAdd Service Started ===');
        Log::info('Cart ID: ' . ($cart->id ?? 'null'));
        Log::info('Cart Item ID: ' . ($cart->item_id ?? 'null'));
        Log::info('Cart Deal ID: ' . ($cart->deal_id ?? 'null'));
        Log::info('Cart Deal Category ID: ' . ($cart->deal_category_id ?? 'null'));
        Log::info('Cart Quantity: ' . ($cart->qty ?? 'null'));
        Log::info('Cart Size ID: ' . ($cart->size_id ?? 'null'));
        Log::info('Cart Crust ID: ' . ($cart->crust_id ?? 'null'));
        
        $addedItems = [];
        
        // If no deal or not deal type 3, return
        if (!$cart->deal_id) {
            Log::info('No deal_id found in cart, exiting');
            return $addedItems;
        }
        
        $deal = TopDeals::where('id', $cart->deal_id)->where('deal_type', 3)->first();
        if (!$deal) {
            Log::info('No deal found or deal_type not 3 for deal_id: ' . $cart->deal_id);
            return $addedItems;
        }
        
        Log::info('Deal found: ' . $deal->id . ', Offer Type: ' . $deal->offer_type . ', Amount: ' . $deal->offer_amount);
        
        $branchId = $branchId ?? Session::get('branch_id');
        Log::info('Branch ID: ' . $branchId);
        
        // Get cart query for existing items
        $cartQuery = Cart::query();

        if (!empty($cart->user_id) && $cart->user_id !== 0) {
            $cartQuery->where('user_id', $cart->user_id);
        } else {
            $cartQuery->where('session_id', $cart->session_id);
        }
        
        Log::info('Cart query built - User/Auth type: ' . (Auth::check() ? Auth::user()->type : 'guest'));
        
        // Get all deal categories
        $dealCategories = DealCategory::where('deal_id', $cart->deal_id)
            ->with(['dealItem' => function($q) {
                $q->with('item.category_info');
            }])
            ->get();
        
        Log::info('Total deal categories found: ' . $dealCategories->count());
        
        $requiredCategories = $dealCategories->where('is_free', 0);
        log::info('required category', [
            'categories' => $requiredCategories
        ]);
        $freeCategories = $dealCategories->where('is_free', 1);
        log::info('free category', [
            'categories' => $freeCategories
        ]);
        
        Log::info('Required categories count: ' . $requiredCategories->count());
        Log::info('Free categories count: ' . $freeCategories->count());
        
        if ($requiredCategories->isEmpty() || $freeCategories->isEmpty()) {
            Log::info('Missing required or free categories, exiting');
            return $addedItems;
        }
        
        // Calculate current sets from required items
        $minSets = null;
        foreach ($requiredCategories as $required) {
            $itemIds = $required->dealItem->pluck('item_id');
            Log::info('Required Category ID: ' . $required->id . ', Required Quantity: ' . $required->quantity);
            Log::info('Item IDs in this category: ' . $itemIds->implode(', '));
            
            $cartQty = (clone $cartQuery)
                ->whereIn('item_id', $itemIds)
                ->where('deal_category_id', $required->id)
                ->sum('qty');
            
            Log::info('Current cart quantity for this category: ' . $cartQty);
            
            $sets = intdiv($cartQty, $required->quantity);
            Log::info('Sets calculated: ' . $sets);
            
            if ($minSets === null || $sets < $minSets) {
                $minSets = $sets;
                Log::info('Min sets updated to: ' . $minSets);
            }
        }
        
        Log::info('Final min sets: ' . $minSets);
        
        if ($minSets < 1) {
            Log::info('Min sets < 1, no free items to add');
            return $addedItems;
        }
        
        // Add missing free items
        foreach ($freeCategories as $free) {
            Log::info('Processing free category ID: ' . $free->id . ', Max free per set: ' . $free->quantity);
            
            $existingFreeQty = (clone $cartQuery)
                ->where('deal_id', $cart->deal_id)
                ->where('deal_category_id', $free->id)
                ->sum('qty');
            
            Log::info('Existing free items in cart: ' . $existingFreeQty);
            
            $maxAllowed = $minSets * $free->quantity;
            Log::info('Max allowed free items: ' . $maxAllowed);
            
            $neededToAdd = $maxAllowed - $existingFreeQty;
            Log::info('Needed to add: ' . $neededToAdd);
            
            if ($neededToAdd > 0) {
                // Get available free items for this category
                $availableFreeItems = $free->dealItem->pluck('item_id')->toArray();
                Log::info('Available free item IDs: ' . implode(', ', $availableFreeItems));
                Log::info('Trigger item ID: ' . $cart->item_id);
                
                // Find matching item (same as triggered item if available)
                $selectedItemId = in_array($cart->item_id, $availableFreeItems) 
                    ? $cart->item_id 
                    : ($availableFreeItems[0] ?? null);
                
                Log::info('Selected item ID: ' . ($selectedItemId ?? 'null'));
                
                if ($selectedItemId) {
                    $selectedItem = Item::with('category_info','item_image')->find($selectedItemId);
                    if (!$selectedItem) {
                        Log::error('Selected item not found for ID: ' . $selectedItemId);
                        continue;
                    }
                    
                    $isPizza = optional($selectedItem->category_info)->slug === 'pizza';
                    Log::info('Selected item: ' . $selectedItem->item_name . ', Is Pizza: ' . ($isPizza ? 'yes' : 'no'));
                    
                    // Determine size/crust (only for pizza)
                    $useSizeId = $isPizza ? $cart->size_id : null;
                    $useCrustId = $isPizza ? $cart->crust_id : null;
                    
                    Log::info('Using Size ID: ' . ($useSizeId ?? 'null') . ', Crust ID: ' . ($useCrustId ?? 'null'));
                    
                    // Calculate original price
                    $originalPrice = self::calculateItemPrice($selectedItemId, $branchId, $useSizeId, $useCrustId, $deal);

                    // Remove the separate discount application since it's now inside calculateItemPrice
                    // Just use the returned price directly
                    $finalPrice = $originalPrice;
                    
                    for ($i = 0; $i < $neededToAdd; $i++) {
                        Log::info('Adding free item #' . ($i + 1));
                        // Save free item using the cart object as template
                        $saved = self::saveFreeItemToCart($selectedItem, $finalPrice, $cart, $free->id, $useSizeId, $useCrustId);
                        
                        if ($saved) {
                            Log::info('Free item saved successfully');
                            $addedItems[] = [
                                'name' => $selectedItem->item_name,
                                'price' => $finalPrice,
                                'is_pizza' => $isPizza
                            ];
                        } else {
                            Log::error('Failed to save free item to cart');
                        }
                    }
                } else {
                    Log::warning('No available free items found in category');
                }
            } else {
                Log::info('No free items needed for this category');
            }
        }
        
        Log::info('Total auto-added items: ' . count($addedItems));
        Log::info('=== BOGO AutoAdd Service Finished ===');
        
        return $addedItems;
    }
    
    /**
     * Save free item to cart (copies relevant fields from the original cart)
     */
    private static function saveFreeItemToCart($item, $price, $originalCart, $freeCategoryId, $sizeId = null, $crustId = null)
    {
        Log::info('saveFreeItemToCart - Starting');
        Log::info('Item: ' . $item->item_name . ', Price: ' . $price);
        
        $isPizza = optional($item->category_info)->slug === 'pizza';
        Log::info('Is pizza: ' . ($isPizza ? 'yes' : 'no'));
        
        $cart = new Cart();
        
        // Set user/session (same as original)
        $cart->user_id = $originalCart->user_id;
        $cart->session_id = $originalCart->session_id;
        
        // Common fields
        $image = ItemImages::where('item_id', $item->id)->first();
        $cart->item_id = $item->id;
        $cart->item_name = $item->item_name;
        $cart->deal_id = $originalCart->deal_id;
        $cart->deal_category_id = $freeCategoryId;
        $cart->item_price = helper::number_format($price);
        $cart->qty = 1;
        $cart->buynow = 0;
        $cart->tax = $item->tax ?? 0;
        $cart->item_type = $item->item_type;
        $cart->item_image = $item->item_image;
        
        Log::info('Common fields set: item_id=' . $cart->item_id . ', price=' . $cart->item_price);
        
        if ($isPizza && $sizeId && $crustId) {
            Log::info('Setting pizza-specific fields');
            // Pizza-specific fields (copy from original pizza if applicable)
            $cart->size_id = $sizeId;
            $cart->crust_id = $crustId;
            
            // Copy addons from original pizza if they should apply to free item
            $cart->addons_id = $originalCart->addons_id;
            $cart->addons_name = $originalCart->addons_name;
            $cart->addons_price = $originalCart->addons_price;
            $cart->addons_total_price = $originalCart->addons_total_price;
            
            // Copy dippings
            $cart->dipping_quantity = $originalCart->dipping_quantity;
            $cart->dipping_name = $originalCart->dipping_name;
            $cart->dipping_price = $originalCart->dipping_price;
            
            // Copy extras
            $cart->extras_id = $originalCart->extras_id;
            $cart->extras_name = $originalCart->extras_name;
            $cart->extras_price = $originalCart->extras_price;
            $cart->extras_total_price = $originalCart->extras_total_price;
            
            Log::info('Pizza fields copied: size_id=' . $sizeId . ', crust_id=' . $crustId);
        } else {
            Log::info('Setting normal item fields');
            // Normal item fields
            $cart->size_id = null;
            $cart->crust_id = null;
            
            // Copy addons from original item
            $cart->addons_id = $originalCart->addons_id;
            $cart->addons_name = $originalCart->addons_name;
            $cart->addons_price = $originalCart->addons_price;
            $cart->addons_total_price = $originalCart->addons_total_price;
            
            // Copy extras
            $cart->extras_id = $originalCart->extras_id;
            $cart->extras_name = $originalCart->extras_name;
            $cart->extras_price = $originalCart->extras_price;
            $cart->extras_total_price = $originalCart->extras_total_price;
            
            // Pizza-specific fields to null
            $cart->dipping_quantity = null;
            $cart->dipping_name = null;
            $cart->dipping_price = null;
        }
        
        try {
            $result = $cart->save();
            Log::info('Cart save result: ' . ($result ? 'success' : 'failed'));
            if ($result) {
                Log::info('New cart item ID: ' . $cart->id);
            }
            return $result;
        } catch (\Exception $e) {
            Log::error('Exception while saving free item: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return false;
        }
    }
    
    /**
     * Calculate item price (handles both normal items and pizzas)
     */
    /**
     * Calculate item price (handles both normal items and pizzas)
     * For pizzas: First apply discount to base price, then add crust price
     */
    private static function calculateItemPrice($itemId, $branchId, $sizeId = null, $crustId = null, $deal = null)
    {
        Log::info('calculateItemPrice - Item ID: ' . $itemId . ', Branch: ' . $branchId . ', Size: ' . ($sizeId ?? 'null') . ', Crust: ' . ($crustId ?? 'null'));
        
        $item = Item::with('category_info','item_image')->find($itemId);
        if (!$item) {
            Log::error('Item not found for ID: ' . $itemId);
            return 0;
        }
        
        $isPizza = optional($item->category_info)->slug === 'pizza';
        Log::info('Item: ' . $item->item_name . ', Is Pizza: ' . ($isPizza ? 'yes' : 'no'));
        
        if ($isPizza && $sizeId) {
            // Step 1: Get base price from pizza_prices
            $basePrice = PizzaPrice::where('item_id', $itemId)
                ->where('branch_id', $branchId)
                ->where('size_id', $sizeId)
                ->value('price') ?? 0;
            
            Log::info('Pizza base price: ' . $basePrice);
            
            // Step 2: Apply discount to base price first
            $discountedBasePrice = $basePrice;
            if ($deal) {
                if ($deal->offer_type == 1) {
                    // Fixed discount
                    $discountedBasePrice = max(0, $basePrice - min($deal->offer_amount, $basePrice));
                    Log::info('Fixed discount applied to base price: ' . $discountedBasePrice);
                } else {
                    // Percentage discount
                    $discountedBasePrice = $basePrice - ($basePrice * $deal->offer_amount / 100);
                    Log::info('Percentage discount applied to base price: ' . $discountedBasePrice);
                }
            }
            
            // Step 3: Get crust price (if no crust ID provided, get the first available crust for this size)
            $crustPrice = 0;
            if ($crustId) {
                $crustPrice = ProductSizeCrust::where('item_id', $itemId)
                    ->where('size_id', $sizeId)
                    ->where('crust_id', $crustId)
                    ->value('price') ?? 0;
                Log::info('Crust price for selected crust: ' . $crustPrice);
            } else {
                // Get the first available crust price for this size
                $firstCrust = ProductSizeCrust::where('item_id', $itemId)
                    ->where('size_id', $sizeId)
                    ->first();
                
                if ($firstCrust) {
                    $crustPrice = $firstCrust->price ?? 0;
                    Log::info('No crust ID provided, using first available crust (ID: ' . $firstCrust->crust_id . ') price: ' . $crustPrice);
                } else {
                    Log::info('No crust found for this size');
                }
            }
            
            // Step 4: Total = discounted base price + crust price (crust is NOT discounted)
            $total = $discountedBasePrice + $crustPrice;
            Log::info('Total pizza price (discounted base + crust): ' . $total);
            return $total;
        } else {
            // Normal item price - apply discount if deal provided
            $normalPrice = itemPrice::where('item_id', $itemId)
                ->where('branch_id', $branchId)
                ->value('price') ?? $item->price ?? 0;
            
            Log::info('Normal item original price: ' . $normalPrice);
            
            // Apply discount to normal item if deal exists
            $finalPrice = $normalPrice;
            if ($deal) {
                if ($deal->offer_type == 1) {
                    $finalPrice = max(0, $normalPrice - min($deal->offer_amount, $normalPrice));
                    Log::info('Fixed discount applied to normal item: ' . $finalPrice);
                } else {
                    $finalPrice = $normalPrice - ($normalPrice * $deal->offer_amount / 100);
                    Log::info('Percentage discount applied to normal item: ' . $finalPrice);
                }
            }
            
            return $finalPrice;
        }
    }
}