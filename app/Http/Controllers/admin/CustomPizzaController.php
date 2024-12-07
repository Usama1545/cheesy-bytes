<?php

namespace App\Http\Controllers\admin;

use App\Models\CustomPizzaCrust;
use App\Models\CustomPizzaSauce;
use App\Models\CustomPizzaSize;
use App\Models\CustomPizzaTopping;
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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
}
