<?php

namespace App\Http\Controllers\admin;

use App\Models\DealNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TopDeals;
use Illuminate\Support\Facades\Log;

class DealNotificationController extends Controller
{
    public function index()
    {
        $notifications = DealNotification::with('deal')->latest()->paginate(20);

        return view('admin.dealNotification.list', compact('notifications'));
    }

    public function create()
    {
        $deals = TopDeals::with('product:id,item_name')
            ->get()
            ->mapWithKeys(function ($deal) {
                return [
                    $deal->id => $deal->product->item_name ?? 'N/A'
                ];
            });

        return view('admin.dealNotification.create', compact('deals'));
    }

    public function store(Request $request)
    {
        try {
        $data = $request->validate([
            'deal_id' => 'required|exists:top_deals,id',
            'time' => 'required|date_format:H:i',

            'repeat_type' => 'required|in:none,weekly',

            'date' => 'required_if:repeat_type,none|nullable|date',

            'days' => 'required_if:repeat_type,weekly|array',
            'days.*' => 'in:mon,tue,wed,thu,fri,sat,sun',
            'message' => 'nullable|string'
        ]);

        DealNotification::create($data);

        return redirect()
            ->route('admin.deal-notifications.index')
            ->with('success', 'Notification created successfully');
        } catch (\Exception $e) {
            log::info(['error' =>  $e->getMessage()]);
    
        }        
    }

    public function edit($id)
    {
        $notification = DealNotification::findOrFail($id);
        $deals = TopDeals::with('product:id,item_name')
            ->get()
            ->mapWithKeys(function ($deal) {
                return [
                    $deal->id => $deal->product->item_name ?? 'N/A'
                ];
            });

        return view('admin.dealNotification.edit', compact('notification', 'deals'));
    }

    public function update(Request $request, $id)
    {
        $notification = DealNotification::findOrFail($id);

        $data = $request->validate([
            'deal_id' => 'required|exists:top_deals,id',
            'time' => 'required|date_format:H:i',
            'repeat_type' => 'required|in:none,weekly',
            'date' => 'required_if:repeat_type,none|nullable|date',
            'days' => 'required_if:repeat_type,weekly|array',
            'days.*' => 'in:mon,tue,wed,thu,fri,sat,sun',
            'message' => 'nullable|string'
        ]);

        $notification->update($data);

        return redirect()
            ->route('admin.deal-notifications.index')
            ->with('success', 'Notification updated successfully');
    }

    public function destroy(Request $request)
    {
        $delete = DealNotification::where('id', $request->id)->delete();
        if ($delete) {
            return 1;
        } else {
            return 0;
        }
    }

    public function status(Request $request)
    {
        $checksbanner = DealNotification::where('id', $request->id)->update(['is_active' => $request->status]);
        if ($checksbanner) {
            return 1;
        } else {
            return 0;
        }
    }

}