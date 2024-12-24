<?php

namespace App\Http\Controllers\admin;

use App\Models\CustomPizza;
use App\Models\CustomPizzaCrust;
use App\Models\CustomPizzaSauce;
use App\Models\CustomPizzaSelectedDipping;
use App\Models\CustomPizzaSelectedTopping;
use App\Models\CustomPizzaSize;
use App\Models\CustomPizzaTopping;
use App\Models\Sides;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\helper;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Item;
use App\Models\Addons;
use App\Models\AddonsGroup;
use App\Models\ItemImages;
use App\Models\Cart;
use App\Models\Extra;
use App\Models\GlobalExtras;
use App\Models\Tax;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Session;

class CustomPizzaController extends Controller
{
    public function index(Request $request)
    {
        $getitem = CustomPizzaSize::with('crusts', 'toppings', 'sauces');
        $getitem = $getitem->orderByDesc('id')->get();
        return view('admin.custom_pizza.item', compact('getitem'));
    }

    public function additem()
    {

        return view('admin.custom_pizza.additem');
    }

    public function edititem($id)
    {
        $getitem = CustomPizzaSize::with('crusts', 'toppings', 'sauces')->find($id);

        return view('admin.custom_pizza.edititem', compact('getitem'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'crust_name' => 'array',
            'crust_name.*' => 'string|nullable',
            'crust_price' => 'array',
            'crust_price.*' => 'numeric|nullable',
            'crust_description' => 'array',
            'crust_description.*' => 'string|nullable',
            'topping_name' => 'array',
            'topping_name.*' => 'string|nullable',
            'topping_price' => 'array',
            'topping_price.*' => 'numeric|nullable',
            'sauce_name' => 'array',
            'sauce_name.*' => 'string|nullable',
            'sauce_price' => 'array',
            'sauce_price.*' => 'numeric|nullable',
        ]);

        // Create the custom pizza (size corresponds to the main pizza)
        $customPizza = new CustomPizzaSize();
        $customPizza->name = $validated['name'];
        $customPizza->price = $validated['price'];
        $customPizza->save();

        // Add crusts
        if ($request->crust_name) {
            foreach ($request->crust_name as $key => $name) {
                if (!empty($name) && !empty($request->crust_price[$key])) {
                    $crust = new CustomPizzaCrust();
                    $crust->size_id = $customPizza->id;
                    $crust->name = $name;
                    $crust->price = $request->crust_price[$key];
                    $crust->description = $request->crust_description[$key] ?? null;
                    $crust->save();
                }
            }
        }

        // Add toppings
        if ($request->topping_name) {
            foreach ($request->topping_name as $key => $name) {
                if (!empty($name) && !empty($request->topping_price[$key])) {
                    $topping = new CustomPizzaTopping();
                    $topping->size_id = $customPizza->id;
                    $topping->name = $name;
                    $topping->price = $request->topping_price[$key];
                    $topping->save();
                }
            }
        }

        // Add sauces
        if ($request->sauce_name) {
            foreach ($request->sauce_name as $key => $name) {
                if (!empty($name) && !empty($request->sauce_price[$key])) {
                    $sauce = new CustomPizzaSauce();
                    $sauce->size_id = $customPizza->id;
                    $sauce->name = $name;
                    $sauce->price = $request->sauce_price[$key];
                    $sauce->save();
                }
            }
        }
        return redirect('admin/custom_pizza')->with('success', 'Custom pizza Size created successfully!');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|numeric',
            'name' => 'required|string',
            'price' => 'required|numeric',
            'crust_name' => 'array',
            'crust_name.*' => 'string|nullable',
            'crust_price' => 'array',
            'crust_price.*' => 'numeric|nullable',
            'crust_description' => 'array',
            'crust_description.*' => 'string|nullable',
            'topping_name' => 'array',
            'topping_name.*' => 'string|nullable',
            'topping_price' => 'array',
            'topping_price.*' => 'numeric|nullable',
            'sauce_name' => 'array',
            'sauce_name.*' => 'string|nullable',
            'sauce_price' => 'array',
            'sauce_price.*' => 'numeric|nullable',
        ]);

        $customPizza = CustomPizzaSize::find($request->id);
        $customPizza->name = $validated['name'];
        $customPizza->price = $validated['price'];
        $customPizza->save();

        $customPizza->crusts()->delete();
        if ($request->crust_name) {
            foreach ($request->crust_name as $key => $name) {
                if (!empty($name) && !empty($request->crust_price[$key])) {
                    $crust = new CustomPizzaCrust();
                    $crust->size_id = $customPizza->id;
                    $crust->name = $name;
                    $crust->price = $request->crust_price[$key];
                    $crust->description = $request->crust_description[$key] ?? null;
                    $crust->save();
                }
            }
        }

        $customPizza->toppings()->delete();
        if ($request->topping_name) {
            foreach ($request->topping_name as $key => $name) {
                if (!empty($name) && !empty($request->topping_price[$key])) {
                    $topping = new CustomPizzaTopping();
                    $topping->size_id = $customPizza->id;
                    $topping->name = $name;
                    $topping->price = $request->topping_price[$key];
                    $topping->save();
                }
            }
        }

        $customPizza->sauces()->delete();
        if ($request->sauce_name) {
            foreach ($request->sauce_name as $key => $name) {
                if (!empty($name) && !empty($request->sauce_price[$key])) {
                    $sauce = new CustomPizzaSauce();
                    $sauce->size_id = $customPizza->id;
                    $sauce->name = $name;
                    $sauce->price = $request->sauce_price[$key];
                    $sauce->save();
                }
            }
        }
        return redirect('admin/custom_pizza')->with('success', 'Custom pizza Size Updated successfully!');

    }

    public function create_pizza(Request $request)
    {
        $sizePrice = $request->size['price'] ?? 0;
        $saucePrice = $request->sauce['price'] ?? 0;
        $crustPrice = $request->crust['price'] ?? 0;
        $totalPrice = $sizePrice + $saucePrice + $crustPrice;


        $pizza = CustomPizza::create([
            'bake' => $request->bake,
            'cut' => $request->cut,
            'seasoning' => $request->seasoning,
            'size_id' => $request->size['id'],
            'sauce_id' => $request->sauce['id'],
            'crust_id' => $request->crust['id'],
        ]);
        foreach ($request->toppings as $topping) {
            $toppingData = CustomPizzaTopping::findOrFail($topping['topping_id']);
            $toppingPrice = $toppingData->price ?? 0;  // Ensure there's a price for the topping
            $totalPrice += $toppingPrice;  // Add topping price to total price

            CustomPizzaSelectedTopping::create([
                'topping_id' => $topping['topping_id'],
                'side' => $topping['side'],
                'quantity' => $topping['quantity'] ?? 'normal',
                'pizza_id' => $pizza->id,
            ]);
        }
        foreach ($request->selectedDippings as $dippingData) {
            $dipping = Sides::where('name', $dippingData['name'])->first();
            $dippingPrice = $dipping->price ?? 0;  // Ensure there's a price for the dipping
            $totalPrice += $dippingPrice;
            if ($dipping) {
                CustomPizzaSelectedDipping::create([
                    'dipping_id' => $dipping->id,
                    'quantity' => $dippingData['quantity'],
                    'pizza_id' => $pizza->id,
                ]);
            }
        }

        $cart = new Cart();
        if (Auth::user()) {
            $cart->user_id = Auth::user()->id;
            $cart->session_id = "";
        } else {
            $cart->user_id = "";
            $cart->session_id = Session::getId();
        }

        $cart->custom_pizza_id = $pizza->id;
        $cart->item_name = $request->size['label'] . ' - ' . $request->crust['name'];
        $cart->item_type = 2;
        $cart->item_image = 'item-6742283c7c0ff.png';
        $cart->item_price = helper::number_format($totalPrice);
        $cart->extras_price =  0;
        $cart->extras_total_price = 0;
        $cart->buynow = 0;


        $cart->qty = $request->quantity;
        $cart->save();

        if (Auth::user()) {
            $total_count = Cart::where('user_id', Auth::user()->id)->count();
        } else {
            $oldsessionid = Session::getId();
            Session::put('oldsessionid', $oldsessionid);
            $total_count = Cart::where('session_id', Session::getId())->where('buynow', 0)->count();
        }
        session()->forget('discount_data');
        return response()->json(['status' => 1, 'message' => trans('messages.success'), 'data' => $total_count, 'total_item_count' => helper::get_item_cart($pizza->id)], 200);


    }
    public function delete(Request $request)
    {
        $category = CustomPizzaSize::where('id', $request->id)->first();
        if($category){
            $category->delete();
            return 1;
        }
        return 0;
    }
}
