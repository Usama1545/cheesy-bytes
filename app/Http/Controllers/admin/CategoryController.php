<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Item;
use App\Models\Cart;
use App\Models\Extra;
use App\Models\ItemImages;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $getcategory = Category::orderBy('reorder_id')->get();
        return view('admin.category.category', compact('getcategory'));
    }
    public function add()
    {
        return view('admin.category.add');
    }
    public function store(Request $request)
    {
        $image = 'category-' . uniqid() . '.' . $request->image->getClientOriginalExtension();
        $request->image->move(env('ASSETSPATHURL') . 'admin-assets/images/category', $image);
        $category = new Category;
        $category->image = $image;
        $category->category_name = $request->category_name;
        $category->slug = $this->getcategoryslug($request->category_name, '');
        $category->save();
        return redirect('admin/category')->with('success', trans('messages.success'));
    }
    public function show(Request $request)
    {
        $catdata = Category::where('id', $request->id)->first();
        return view('admin.category.edit', compact('catdata'));
    }
    public function update(Request $request)
    {
        $category = Category::find($request->id);
        if ($request->file('image') != "") {
            if (file_exists(env('ASSETSPATHURL') . 'admin-assets/images/category/' . $category->image)) {
                unlink(env('ASSETSPATHURL') . 'admin-assets/images/category/' . $category->image);
            }
            $image = 'category-' . uniqid() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(env('ASSETSPATHURL') . 'admin-assets/images/category', $image);
            $category->image = $image;
            $category->save();
        }
        $category->category_name = $request->category_name;
        $category->slug = $this->getcategoryslug($request->category_name, $request->id);
        $category->save();
        return redirect('admin/category')->with('success', trans('messages.success'));
    }
    public function status(Request $request)
    {
        $category = Category::where('id', $request->id)->update(array('is_available' => $request->status));
        if ($category) {
            $item = Item::where('cat_id', $request->id)->update(array('item_status' => $request->status));
            $items = Item::where('cat_id', $request->id)->get();
            foreach ($items as $value) {
                $UpdateCart = Cart::where('item_id', $value['id'])->delete();
            }
            return 1;
        } else {
            return 0;
        }
    }
    public function delete(Request $request)
    {
        $category = Category::where('id', $request->id)->first();
        $updatecategory = Category::where('id', $request->id)->delete();
        if ($updatecategory) {
            $items = Item::where('cat_id', $request->id)->get();
            foreach ($items as $value) {
                Cart::where('item_id', $value['id'])->delete();
                Extra::where('item_id', $value['id'])->delete();
                $itemimages = ItemImages::where('item_id', $value['id'])->get();
                foreach ($itemimages as $image) {
                    if (file_exists(env('ASSETSPATHURL') . 'admin-assets/images/item/' . $image->image)) {
                        unlink(env('ASSETSPATHURL') . 'admin-assets/images/item/' . $image->image);
                    }
                    $image->delete();
                }
            }
            Item::where('cat_id', $category->id)->delete();
            Subcategory::where('cat_id', $category->id)->delete();
            if (file_exists(env('ASSETSPATHURL') . 'admin-assets/images/category/' . $category->image)) {
                unlink(env('ASSETSPATHURL') . 'admin-assets/images/category/' . $category->image);
            }
            return 1;
        } else {
            return 0;
        }
    }
    public function getcategoryslug($category_name, $id)
    {
        $slug = Str::slug($category_name, '-');
        $checkslug = Category::where('slug', $slug);
        if ($id != "") {
            $checkslug = $checkslug->where('id', '!=', $id);
        }
        $checkslug = $checkslug->first();
        if (!empty($checkslug)) {
            $lastid = Category::select('id')->orderByDesc('id')->first();
            $slug .= '-' . $lastid->id;
        }
        return $slug;
    }

    public function reorder_category(Request $request)
    {
        $getcategory = Category::all();
        foreach ($getcategory as $category) {
            foreach ($request->order as $order) {
                $category = Category::where('id', $order['id'])->first();
                $category->reorder_id = $order['position'];
                $category->save();
            }
        }
        return response()->json(['status' => 1, 'msg' => 'Update Successfully!!'], 200);
    }

    // subcategory 

    public function subcategory_index(Request $request)
    {
        $getsubcategory = Subcategory::with('category_info')->orderBy('reorder_id')->get();
        return view('admin.subcategory.index', compact('getsubcategory'));
    }
    public function subcategory_add(Request $request)
    {
        $getcategory = Category::where('is_available', 1)->orderBy('reorder_id')->get();
        return view('admin.subcategory.add', compact('getcategory'));
    }
    public function subcategory_store(Request $request)
    {
        $subcategory = new Subcategory;
        $subcategory->subcategory_name = $request->name;
        $subcategory->cat_id = $request->category;
        $subcategory->slug = $this->getsubcategoryslug($request->name, '');
        $subcategory->save();
        return redirect('admin/sub-category')->with('success', trans('messages.success'));
    }
    public function subcategory_status(Request $request)
    {
        $subcategory = Subcategory::where('id', $request->id)->update(['is_available' => $request->status]);
        if ($subcategory) {
            $item = Item::where('subcat_id', $request->id)->update(['item_status' => $request->status]);
            $items = Item::where('subcat_id', $request->id)->get();
            foreach ($items as $value) {
                $UpdateCart = Cart::where('item_id', $value['id'])->delete();
            }
            return 1;
        } else {
            return 0;
        }
    }
    public function subcategory_delete(Request $request)
    {
        $subcategory = Subcategory::where('id', $request->id)->delete();
        if ($subcategory) {
            $items = Item::where('subcat_id', $request->id)->get();
            foreach ($items as $value) {
                Cart::where('item_id', $value['id'])->delete();
                Extra::where('item_id', $value['id'])->delete();
                $itemimages = ItemImages::where('item_id', $value['id'])->get();
                foreach ($itemimages as $image) {
                    if (file_exists(env('ASSETSPATHURL') . 'admin-assets/images/item/' . $image->image)) {
                        unlink(env('ASSETSPATHURL') . 'admin-assets/images/item/' . $image->image);
                    }
                    $image->delete();
                }
            }
            Item::where('subcat_id', $request->id)->delete();
            return 1;
        } else {
            return 0;
        }
    }
    public function subcategory_show(Request $request)
    {
        $subcatdata = Subcategory::where('id', $request->id)->first();
        $getcategory = Category::where('is_available', 1)->orderBy('reorder_id')->get();
        return view('admin.subcategory.edit', compact('subcatdata', 'getcategory'));
    }
    public function subcategory_update(Request $request)
    {
        $subcategory = Subcategory::find($request->id);
        $subcategory->subcategory_name = $request->name;
        $subcategory->cat_id = $request->category;
        $subcategory->slug = $this->getsubcategoryslug($request->name, $request->id);
        $subcategory->save();
        return redirect('admin/sub-category')->with('success', trans('messages.success'));
    }
    public function getsubcategoryslug($subcategory_name, $id)
    {
        $slug = Str::slug($subcategory_name, '-');
        $checkslug = Subcategory::where('slug', $slug);
        if ($id != "") {
            $checkslug = $checkslug->where('id', '!=', $id);
        }
        $checkslug = $checkslug->first();
        if (!empty($checkslug)) {
            $lastid = Subcategory::select('id')->orderByDesc('id')->first();
            $slug .= '-' . $lastid->id;
        }
        return $slug;
    }
    public function reorder_subcategory(Request $request)
    {
        $getsubcategory = Subcategory::all();
        foreach ($getsubcategory as $subcategory) {
            foreach ($request->order as $order) {
                $subcategory = Subcategory::where('id', $order['id'])->first();
                $subcategory->reorder_id = $order['position'];
                $subcategory->save();
            }
        }
        return response()->json(['status' => 1, 'msg' => 'Update Successfully!!'], 200);
    }
}
