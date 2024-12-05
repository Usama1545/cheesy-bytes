<?php

namespace App\Http\Controllers\addons;

use App\Http\Controllers\Controller;
use App\Models\Blogs;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Helpers\helper;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        if (@helper::checkaddons('blog')) {
            $getblogs = Blogs::orderBy('reorder_id')->get();
            return view('admin.blogs.index', compact('getblogs'));
        } else {
            abort(404);
        }
    }
    public function add()
    {
        if (@helper::checkaddons('blog')) {
            return view('admin.blogs.add');
        } else {
            abort(404);
        }
    }
    public function store(Request $request)
    {
        $image = 'blog-' . uniqid() . '.' . $request->image->getClientOriginalExtension();
        $request->image->move(env('ASSETSPATHURL') . 'admin-assets/images/about/', $image);
        $blog = new Blogs;
        $blog->image = $image;
        $blog->title = $request->title;
        $blog->slug = $this->getblogslug($request->title, '');
        $blog->description = $request->description;
        $blog->save();
        return redirect('admin/blogs')->with('success', trans('messages.success'));
    }
    public function show(Request $request)
    {
        if (@helper::checkaddons('product_blogreview')) {
            $blogdata = Blogs::find($request->id);
            return view('admin.blogs.edit', compact('blogdata'));
        } else {
            abort(404);
        }
    }
    public function update(Request $request)
    {
        $blog = Blogs::find($request->id);
        if ($request->file('image') != "") {
            if (file_exists(storage_path() . "/app/public/admin-assets/images/about/" . $blog->image)) {
                unlink(storage_path() . "/app/public/admin-assets/images/about/" . $blog->image);
            }
            $image = 'blog-' . uniqid() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(env('ASSETSPATHURL') . 'admin-assets/images/about/', $image);
            $blog->image = $image;
            $blog->save();
        }
        $blog->title = $request->title;
        $blog->slug = $this->getblogslug($request->title, $request->id);
        $blog->description = $request->description;
        $blog->save();
        return redirect('admin/blogs')->with('success', trans('messages.success'));
    }
    public function delete(Request $request)
    {
        $blog = Blogs::find($request->id);
        if (file_exists(storage_path() . "/app/public/admin-assets/images/about/" . $blog->image)) {
            unlink(storage_path() . "/app/public/admin-assets/images/about/" . $blog->image);
        }
        if ($blog->delete()) {
            return 1;
        } else {
            return 0;
        }
    }
    public function getblogslug($title, $id)
    {
        $slug = Str::slug($title, '-');
        $checkslug = Blogs::where('slug', $slug);
        if ($id != "") {
            $checkslug = $checkslug->where('id', '!=', $id);
        }
        $checkslug = $checkslug->first();
        if (!empty($checkslug)) {
            $slug .= '-' . Blogs::select('id')->orderByDesc('id')->first()->id;
        }
        return $slug;
    }
    public function reorder_blog(Request $request)
    {
        $getblogs = Blogs::all();
        foreach ($getblogs as $blog) {
            foreach ($request->order as $order) {
                $blog = Blogs::where('id', $order['id'])->first();
                $blog->reorder_id = $order['position'];
                $blog->save();
            }
        }
        return response()->json(['status' => 1, 'msg' => 'Update Successfully!!'], 200);
    }

    //front
    public function blogs(Request $request)
    {
        if (@helper::checkaddons('blog')) {
            $getblogs = Blogs::orderBy('reorder_id')->get();
            return view('web.blogs.blogs', compact('getblogs'));
        } else {
            abort(404);
        }
    }
    public function showblog(Request $request)
    {
        if (@helper::checkaddons('blog')) {
            $getblogdata = Blogs::where('slug', $request->slug)->first();
            $recentblogs = Blogs::orderBy('reorder_id')->take('3')->get();
            return view('web.blogs.blogdetails', compact('getblogdata', 'recentblogs'));
        } else {
            abort(404);
        }
    }
}
