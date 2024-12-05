<?php

namespace App\Http\Controllers\admin;

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

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $getitem = Item::with('category_info', 'subcategory_info', 'item_image')->select('item.*')->join('categories', 'item.cat_id', '=', 'categories.id')->where('categories.is_available', '1')->orderBy('item.reorder_id');
        if ($request->has('search') && $request->search != "") {
            $search = $request->search;
            $getitem = $getitem->where(function ($query) use ($search) {
                $query->where('item.item_name', 'like', '%' . $search . '%');
            });
        }
        if ($request->has('option') && $request->option != "") {
            $getitem = $getitem->where('item.item_type', $request->option == "veg" ? 1 : 2);
        }
        $getitem = $getitem->orderByDesc('item.id')->get();
        return view('admin.item.item', compact('getitem'));
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
        return view('admin.item.additem', compact('getcategory', 'getaddongroup', 'getaddon', 'gettax', 'globalextras'));
    }
    public function edititem($id)
    {
        $getitem = Item::with('extras')->find($id);
        $getitemimages = ItemImages::where('item_id', $id)->orderByDesc('id')->get();
        $getcategory = Category::where('is_available', '1')->orderBy('reorder_id')->get();
        $getsubcategory = Subcategory::where('cat_id', $getitem->cat_id)->where('is_available', '1')->orderBy('reorder_id')->get();
        $getaddongroup = AddonsGroup::where('is_deleted', 2)->where('is_available', 1)->orderBy('reorder_id')->get();
        $getaddon = Addons::select('id', 'addongroup_id', 'name', 'price')->where('is_deleted', 2)->where('is_available', 1)->orderByDesc('id')->get();
        foreach ($getaddongroup as $addons_group) {
            $addons_group->availableAddons = $getaddon->where('addongroup_id', $addons_group->id);
        }
        $gettax = Tax::where('is_available', '1')->orderBy('reorder_id')->get();
        $globalextras = GlobalExtras::where('is_available', 1)->orderBy('reorder_id')->get();
        return view('admin.item.edititem', compact('getitem', 'getcategory', 'getsubcategory', 'getaddongroup', 'getaddon', 'gettax', 'globalextras', 'getitemimages'));
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
            $discount =  0;
        } else {
            $discount =  $request->original_price > 0 ? number_format(100 - ($request->price * 100) / $request->original_price, 1) : 0;
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
            return redirect('admin/item')->with('success', trans('messages.success'));
        } else {
            return redirect()->back()->with('error', trans('messages.wrong'));
        }
    }
    public function storeimages(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'file.*' => 'required'
        ]);
        $error_array = array();
        $success_output = '';
        if ($validation->fails()) {
            foreach ($validation->messages()->getMessages() as $field_name => $messages) {
                $error_array[] = $messages;
            }
        } else {
            if ($request->hasFile('file')) {
                $files = $request->file('file');
                foreach ($files as $file) {
                    $itemimage = new ItemImages;
                    $image = 'item-' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(env('ASSETSPATHURL') . 'admin-assets/images/item', $image);
                    $itemimage->item_id = $request->itemid;
                    $itemimage->image = $image;
                    $itemimage->save();
                }
            }
            $success_output = trans('messages.success');
        }
        $output = array('error'     =>  $error_array, 'success'   =>  $success_output);
        echo json_encode($output);
    }
    public function showimage(Request $request)
    {
        $getitem = ItemImages::where('id', $request->id)->first();
        if ($getitem->image) {
            $getitem->img = url(env('ASSETSPATHURL') . 'admin-assets/images/item/' . $getitem->image);
        }
        return response()->json(['ResponseCode' => 1, 'ResponseText' => trans('messages.success'), 'ResponseData' => $getitem], 200);
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
            return redirect('admin/item')->with('success', trans('messages.success'));
        } else {
            return redirect()->back()->with('error', trans('messages.wrong'));
        }
    }
    public function reorder_item(Request $request)
    {
        $getitem = Item::all();
        foreach ($getitem as $item) {
            foreach ($request->order as $order) {
                $item = Item::where('id', $order['id'])->first();
                $item->reorder_id = $order['position'];
                $item->save();
            }
        }
        return response()->json(['status' => 1, 'msg' => 'Update Successfully!!'], 200);
    }


    public function updateimage(Request $request)
    {
        $validation = Validator::make($request->all(), ['image' => 'image']);
        $error_array = array();
        $success_output = '';
        if ($validation->fails()) {
            foreach ($validation->messages()->getMessages() as $field_name => $messages) {
                $error_array[] = $messages;
            }
        } else {
            $itemimage = ItemImages::find($request->id);
            if ($request->hasFile('image')) {
                if (file_exists(env('ASSETSPATHURL') . 'admin-assets/images/item/' . $itemimage->image)) {
                    unlink(env('ASSETSPATHURL') . 'admin-assets/images/item/' . $itemimage->image);
                }
                $image = 'item-' . uniqid() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(env('ASSETSPATHURL') . 'admin-assets/images/item', $image);
                $itemimage->image = $image;
            }
            $itemimage->save();
            $success_output = trans('messages.success');
        }
        $output = array('error' => $error_array, 'success' => $success_output);
        echo json_encode($output);
    }
    public function getitemslug($item_name, $id)
    {
        $slug = Str::slug($item_name, '-');
        $checkslug = Item::where('slug', $slug);
        if ($id != "") {
            $checkslug = $checkslug->where('id', '!=', $id);
        }
        $checkslug = $checkslug->first();
        if (!empty($checkslug)) {
            $lastid = Item::select('id')->orderByDesc('id')->first();
            $slug .= '-' . $lastid->id;
        }
        return $slug;
    }
    public function status(Request $request)
    {
        $UpdateDetails = Item::where('id', $request->id)->update(['item_status' => $request->status]);
        if ($UpdateDetails) {
            Cart::where('item_id', $request->id)->delete();
            return 1;
        } else {
            return 0;
        }
    }
    public function delete(Request $request)
    {
        $updatedetails = Item::where('id', $request->id)->delete();
        if ($updatedetails) {
            Cart::where('item_id', $request->id)->delete();
            Extra::where('item_id', $request->id)->delete();
            $itemimages = ItemImages::where('item_id', $request->id)->get();
            foreach ($itemimages as $image) {
                if (file_exists(env('ASSETSPATHURL') . 'admin-assets/images/item/' . $image->image)) {
                    unlink(env('ASSETSPATHURL') . 'admin-assets/images/item/' . $image->image);
                }
                $image->delete();
            }
            return 1;
        } else {
            return 0;
        }
    }
    public function destroyimage(Request $request)
    {
        $getitemimages = ItemImages::where('item_id', $request->item_id)->count();
        if ($getitemimages > 1) {
            $itemimage = ItemImages::where('id', $request->id)->first();
            if (file_exists(env('ASSETSPATHURL') . 'admin-assets/images/item/' . $itemimage->image)) {
                unlink(env('ASSETSPATHURL') . 'admin-assets/images/item/' . $itemimage->image);
            }
            $itemimage->delete();
            if ($itemimage) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return 2;
        }
    }
    public function featured(Request $request)
    {
        $updatedata = Item::where('id', $request->id)->update(['is_featured' => $request->status]);
        if ($updatedata) {
            return 1;
        } else {
            return 0;
        }
    }
    public function subcategories(Request $request)
    {
        $data = Subcategory::where('cat_id', $request->id)->orderBy('reorder_id')->where('is_available', 1)->get();
        return response()->json(['status' => 1, 'message' => trans('messages.success'), 'data' => $data], 200);
    }
    public function getextras()
    {
        $globalextras = GlobalExtras::where('is_available', 1)->orderBy('reorder_id')->get();
        return response()->json(['status' => 1, 'msg' => trans('messages.success'), 'responsdata' => $globalextras], 200);
    }
    public function deleteextras(Request $request)
    {
        $checkextracount = Extra::where('item_id', $request->item_id)->count();
        if ($checkextracount > 1) {
            $deletedata = Extra::where('id', $request->id)->delete();
            if ($deletedata) {
                Cart::where('item_id', $request->item_id)->delete();
                return 1;
            } else {
                return 0;
            }
        } else {
            return 2;
        }
    }
}
