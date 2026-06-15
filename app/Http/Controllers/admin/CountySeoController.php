<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\CountySeo;
class CountySeoController extends Controller
{
    public function index(Request $request)
    {
        $query = CountySeo::with(['branch', 'category'])
            ->orderByDesc('id');

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        $getcontact = $query->get();
        // dd($getcontact);

        return view('admin.countySeo.index', compact('getcontact'));
    }
    public function edit($id)
    {
        $seo = CountySeo::with(['branch', 'category'])->findOrFail($id);

        return view('admin.countySeo.edit', compact('seo'));
    }

    public function update($id, Request $request)
    {
        $seo = CountySeo::with(['branch', 'category'])->findOrFail($id);
        $seo->update([
            'content' => $request->message,
        ]);

        return redirect('admin/county-seo')->with('success', 'Updated successfully!');
    }

    public function generate()
    {
        $categories = Category::where('is_available', 1)->get();

        $created = 0;

        foreach ($categories as $category) {

            $branchIds = explode(',', $category->branch_ids);

            foreach ($branchIds as $branchId) {

                $exists = CountySeo::where('branch_id', $branchId)
                    ->where('category_id', $category->id)
                    ->exists();

                if (!$exists) {

                    CountySeo::create([
                        'branch_id' => $branchId,
                        'category_id' => $category->id,
                        'content' => '',
                    ]);

                    $created++;
                }
            }
        }

        return redirect()
            ->back()
            ->with('success', "{$created} missing SEO records generated successfully.");
    }
}
