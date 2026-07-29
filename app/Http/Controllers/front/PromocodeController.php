<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Helpers\helper;
use App\Models\Promocode;
use App\Models\Order;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;


class PromocodeController extends Controller
{
   
    public function checkpromocode(Request $request)
    {
        $currentDate = date('Y-m-d');
        $currentTime = Carbon::now()->format('H:i:s');
    
        $validator = Validator::make($request->all(), [
            'offer_code' => 'required',
        ], [
            "offer_code.required" => trans('messages.offercode_required'),
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $checkoffercode = Promocode::where('offer_code', $request->offer_code)
            ->where('is_available', 1)
            ->first();
    
        if (!$checkoffercode) {
            return redirect()->back()->with('error', trans('messages.invalid_promocode'))->withInput();
        }
    
        // Retrieve cart items based on user authentication
        $getcartlist = Auth::user()
            ? Cart::where('user_id', Auth::user()->id)->get()
            : Cart::where('session_id', Session::getId())->get();
        
        // Get item details from cart by joining with items table
        $validCartItems = $getcartlist->map(function ($cartItem) {
            $item = Item::find($cartItem->item_id);
            if ($item) {
                return (object) [
                    'id' => $item->id,
                    'name' => $item->name,
                    'cat_id' => $item->cat_id,
                    'cart_quantity' => $cartItem->qty,
                    'addons_total_price' => $cartItem->addons_total_price, // Assuming the cart stores the actual price
                    'item_price' => $cartItem->item_price, // Assuming the cart stores the actual price
                    'extras_total_price' =>  $cartItem->extras_total_price, 

                ];
            }
            return null;
        })->filter(); // Remove null values if an item is not found
        
        
        // Decode allowed categories and excluded products
        $allowedCategories = explode(',', $checkoffercode->category_ids);
        $excludedProducts = explode(',', $checkoffercode->product_ids);
        
        // Filter only valid cart items
        $validItems = $validCartItems->filter(function ($cartItem) use ($allowedCategories, $excludedProducts) {
            return in_array($cartItem->cat_id, $allowedCategories) && !in_array($cartItem->id, $excludedProducts);
        });

        // Calculate total discountable amount
        $validOrderAmount = $validItems->sum(fn($item) => ($item->item_price + $item->addons_total_price + $item->extras_total_price) * $item->cart_quantity);
        

        if ($validItems->isEmpty()) {
            return redirect()->back()->with('error', 'Not Applicable on this Cart')->withInput();
        }
    
        // Validate promocode date and time
        if (
            !($currentDate >= $checkoffercode->start_date && $currentDate <= $checkoffercode->expire_date) ||
            ($checkoffercode->start_time && $currentTime < $checkoffercode->start_time) ||
            ($checkoffercode->end_time && $currentTime > $checkoffercode->end_time)
        ) {
            return redirect()->back()->with('error', trans('messages.offer_expired'))->withInput();
        }
    
        // Calculate total amount for only eligible items

        if ($validOrderAmount < $checkoffercode->min_amount) {
            return redirect()->back()->with('error', trans('messages.order_amount_greater_then') . ' : ' . helper::currency_format($checkoffercode->min_amount))->withInput();
        }
    
        // Check promocode usage limit
        $checkcount = Order::where('offer_code', $request->offer_code)->count();
    
        if ($checkoffercode->usage_type == 1 && $checkcount >= $checkoffercode->usage_limit) {
            return redirect()->back()->with('error', trans('messages.once_per_user'))->withInput();
        }
    
        // Apply discount only on eligible items
        $offer_amount = $checkoffercode->offer_type == 1
            ? $checkoffercode->offer_amount // Fixed discount
            : ($validOrderAmount * $checkoffercode->offer_amount / 100); // Percentage discount

    
        // Store discount in session
        session()->put('discount_data', [
            "offer_code" => $checkoffercode->offer_code,
            "offer_amount" => $offer_amount,
        ]);
    
        return redirect()->back()->with('success', trans('messages.success'));
    }

    public function removepromocode()
    {
        session()->forget('discount_data');
        return redirect()->back()->with('success', trans('messages.success'));
    }
}
