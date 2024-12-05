<?php

namespace App\Http\Controllers\admin;

use App\Models\CustomPizzaSize;
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
        $getcategory = Category::where('is_available', '1')->orderBy('reorder_id')->get();
        $getaddongroup = AddonsGroup::where('is_deleted', 2)->where('is_available', 1)->orderBy('reorder_id')->get();
        $getaddon = Addons::select('id', 'addongroup_id', 'name', 'price')->where('is_deleted', 2)->where('is_available', 1)->orderByDesc('id')->get();
        foreach ($getaddongroup as $addons_group) {
            $addons_group->availableAddons = $getaddon->where('addongroup_id', $addons_group->id);
        }
        $gettax = Tax::where('is_available', '1')->orderBy('reorder_id')->get();
        $globalextras = GlobalExtras::where('is_available', 1)->orderBy('reorder_id')->get();
        return view('admin.custom_pizza.additem', compact('getcategory', 'getaddongroup', 'getaddon', 'gettax', 'globalextras'));
    }

    public function edititem($id)
    {
        $getitem = CustomPizzaSize::with('crusts', 'toppings', 'sauces')->find($id);

        return view('admin.custom_pizza.edititem', compact('getitem'));
    }

    public function store(Request $request)
    {
        $item = new Item();
        $item->cat_id = $request->cat_id;
        $item->subcat_id = $request->subcat_id == "" ? "" : $request->subcat_id;
        $item->preparation_time = $request->preparation_time;
        $item->addons_id = $request->addongroup_id != "" ? @implode(",", $request->addongroup_id) : null;
        $item->item_name = $request->item_name;
        $item->slug = $this->getitemslug($request->item_name, '');
        $item->item_type = $request->item_type;
        $item->has_extras = $request->has_extras;
        if ($request->original_price == "") {
            $discount = 0;
        } else {
            $discount = $request->original_price > 0 ? number_format(100 - ($request->price * 100) / $request->original_price, 1) : 0;
        }
        $item->price = helper::number_format($request->price);
        $item->original_price = helper::number_format($request->original_price == null ? 0 : $request->original_price);
        $item->discount_percentage = $discount;
        $item->item_description = $request->description;
        $item->item_allergens = $request->allergens;
        $item->tax = $request->tax != "" ? @implode(",", $request->tax) : '';
        $item->video_url = $request->video_url;
        $item->avg_ratting = 0;
        if ($item->save()) {
            if ($request->has_extras == 1 && $request->extras_name != "") {
                foreach ($request->extras_name as $key => $no) {
                    if (@$no != "" && @$request->extras_price[$key] != "") {
                        $extras = new Extra();
                        $extras->item_id = $item->id;
                        $extras->name = $no;
                        $extras->price = $request->extras_price[$key];
                        $extras->save();
                    }
                }
            }
            foreach ($request->file('image') as $img) {
                $itemimage = new ItemImages;
                $image = 'item-' . uniqid() . '.' . $img->getClientOriginalExtension();
                $img->move(env('ASSETSPATHURL') . 'admin-assets/images/item', $image);
                $itemimage->item_id = $item->id;
                $itemimage->image = $image;
                $itemimage->save();
            }
            return redirect('admin/custom_pizza')->with('success', trans('messages.success'));
        } else {
            return redirect()->back()->with('error', trans('messages.wrong'));
        }
    }

    public function update(Request $request)
    {
        Cart::where('item_id', $request->id)->delete();
        $item = Item::find($request->id);
        $item->cat_id = $request->cat_id;
        $item->subcat_id = $request->subcat_id == "" ? "" : $request->subcat_id;
        $item->preparation_time = $request->preparation_time;
        $item->addons_id = $request->addongroup_id != "" ? @implode(",", $request->addongroup_id) : null;
        $item->item_type = $request->item_type;
        $item->has_extras = $request->has_extras;
        if ($request->original_price == "") {
            $discount =  0;
        } else {
            $discount =  $request->original_price > 0 ? number_format(100 - ($request->price * 100) / $request->original_price, 1) : 0;
        }
        $item->price = helper::number_format($request->price);
        $item->original_price = helper::number_format($request->original_price == null ? 0 : $request->original_price);
        $item->discount_percentage = $discount;
        $item->item_name = $request->item_name;
        $item->slug = $this->getitemslug($request->item_name, $request->id);;
        $item->item_description = $request->description;
        $item->item_allergens = $request->allergens;
        $item->tax = $request->tax != "" ? @implode(",", $request->tax) : '';
        $item->video_url = $request->video_url;
        if ($item->save()) {
            if ($request->has_extras == 1 && $request->extras_name != "") {
                $extras_id = $request->extras_id;
                foreach ($request->extras_name as $key => $no) {
                    if (@$no != "" && @$request->extras_price[$key] != "") {
                        if (@$extras_id[$key] == "") {
                            $extras = new Extra();
                            $extras->item_id = $item->id;
                            $extras->name = $no;
                            $extras->price = $request->extras_price[$key];
                            $extras->save();
                        } else if (@$extras_id[$key] != "") {
                            Extra::where('id', @$extras_id[$key])->update(['name' => $request->extras_name[$key], 'price' => $request->extras_price[$key]]);
                        }
                    }
                }
            }
            if ($request->has_extras == 2) {
                Extra::where('item_id', $item->id)->delete();
            }
            return redirect('admin/custom_pizza')->with('success', trans('messages.success'));
        } else {
            return redirect()->back()->with('error', trans('messages.wrong'));
        }
    }
}
