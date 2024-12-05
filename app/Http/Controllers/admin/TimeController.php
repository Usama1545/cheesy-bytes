<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Settings;
use App\Models\Time;

class TimeController extends Controller
{
    public function index()
    {
        $gettime = Time::all();
        $settingsdata = Settings::first();
        return view('admin.time', compact('gettime', 'settingsdata'));
    }
    public function store(Request $request)
    {
        $settingsdata = Settings::first();
        if (empty($settingsdata)) {
            $settingsdata = new Settings();
        }
        $settingsdata->interval_time = $request->interval_time;
        $settingsdata->interval_type = $request->interval_type;
        $settingsdata->perslot_booking_limit = $request->slot_limit;
        $settingsdata->ordertype_date_time = $request->ordertypedatetime;
        $settingsdata->save();

        $day = $request->day;
        $open_time = $request->open_time;
        $break_start = $request->break_start;
        $break_end = $request->break_end;
        $close_time = $request->close_time;
        $always_close = $request->always_close;
        foreach ($day as $key => $no) {
            $input['day'] = $no;
            if ($always_close[$key] == "2") {
                if (strtolower($close_time[$key]) == "closed") {
                    $input['open_time'] = "12:00am";
                    $input['break_start'] = "12:00pm";
                    $input['break_end'] = "01:00pm";
                    $input['close_time'] = "11:30pm";
                } else {
                    $input['open_time'] = $open_time[$key];
                    $input['break_start'] = $break_start[$key];
                    $input['break_end'] = $break_end[$key];
                    $input['close_time'] = $close_time[$key];
                }
            } else {
                $input['open_time'] = "12:00am";
                $input['break_start'] = "12:00pm";
                $input['break_end'] = "01:00pm";
                $input['close_time'] = "11:30pm";
            }
            $input['always_close'] = $always_close[$key];
            Time::where('day', $no)->update($input);
        }
        return redirect()->back()->with('success', trans('messages.success'));
    }
}
