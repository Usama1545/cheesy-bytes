<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Settings;
use App\Models\Time;
use App\Helpers\helper;

class TimeController extends Controller
{
    public function index(Request $request)
    {
        $branchId = $request->branch_id
            ?? helper::get_branchs()->first()->id;

        $gettime = Time::where('branch_id', $branchId)->get();
        $settingsdata = Settings::first();

        return view('admin.time', compact('gettime', 'settingsdata', 'branchId'));
    }

   public function store(Request $request)
    {
        // ---------- Global Settings ----------
        $settingsdata = Settings::first() ?? new Settings();

        $settingsdata->interval_time = $request->interval_time;
        $settingsdata->interval_type = $request->interval_type;
        $settingsdata->perslot_booking_limit = $request->slot_limit;
        $settingsdata->ordertype_date_time = $request->ordertypedatetime ?? 0;
        $settingsdata->save();

        // ---------- Branch-wise Timing ----------
        $branchId = $request->branch_id;

        $day          = $request->day;
        $open_time    = $request->open_time;
        $break_start  = $request->break_start;
        $break_end    = $request->break_end;
        $close_time   = $request->close_time;
        $always_close = $request->always_close;

        foreach ($day as $key => $currentDay) {

            $input = [
                'branch_id'    => $branchId,
                'day'          => $currentDay,
                'always_close' => $always_close[$key],
            ];

            if ($always_close[$key] == "2") { // Not closed
                if (strtolower($close_time[$key]) === 'closed') {
                    $input['open_time']   = "12:00am";
                    $input['break_start'] = "12:00pm";
                    $input['break_end']   = "01:00pm";
                    $input['close_time']  = "11:30pm";
                } else {
                    $input['open_time']   = $open_time[$key];
                    $input['break_start'] = $break_start[$key];
                    $input['break_end']   = $break_end[$key];
                    $input['close_time']  = $close_time[$key];
                }
            } else { // Closed
                $input['open_time']   = "12:00am";
                $input['break_start'] = "12:00pm";
                $input['break_end']   = "01:00pm";
                $input['close_time']  = "11:30pm";
                $input['always_close'] = "1";
            }
            $input['always_close'] = $always_close[$key];

            Time::updateOrCreate(
                [
                    'branch_id' => $branchId,
                    'day'       => $currentDay,
                ],
                $input
            );
        }

        return redirect()->back()->with('success', trans('messages.success'));
    }

}
