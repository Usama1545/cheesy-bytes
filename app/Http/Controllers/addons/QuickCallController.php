<?php

namespace App\Http\Controllers\addons;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;

class QuickCallController extends Controller
{
    public function quick_call(Request $request)
    {
        try {
            $request->validate([
                'quick_call_name' => 'required',
                'quick_call_mobile' => 'required',
            ]);
    
            $data = Settings::first();
            // Upload Image
            if ($request->hasFile('quick_call_image')) {
                $file = $request->file("quick_call_image");
                $filename = 'quick-call-' . uniqid() . "." . $file->getClientOriginalExtension();
                $file->move(env('ASSETSPATHURL').'admin-assets/images/about', $filename);
                $data->quick_call_image = @$filename;
            }
    
            
            $data->quick_call =  isset($request->quick_call) ? 1 : 2;
            $data->quick_call_name = $request->quick_call_name;
            $data->quick_call_description = $request->quick_call_description;
            $data->quick_call_mobile = $request->quick_call_mobile;
            $data->quick_call_position = $request->quick_call_position;
            $data->save();
            return redirect()->back()->with('success', trans('messages.success'));
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
