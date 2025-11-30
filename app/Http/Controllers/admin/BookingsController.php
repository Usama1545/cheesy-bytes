<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\helper;
use App\Models\Bookings;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class BookingsController extends Controller
{
    public function bookings(Request $request)
    {
        $user = auth()->user();
        if($user->branch_id)
        {
            Bookings::where('branch_id',$user->branch_id)->update([
                'read_at' => now()
            ]);
            $getbookings = Bookings::where('branch_id',$user->branch_id)->orderByDesc('id')->get();
        }
        else {
            $getbookings = Bookings::orderByDesc('id')->get();
        }
        return view('admin.bookings.bookings', compact('getbookings'));
    }
    public function bookingstatus(Request $request)
    {
        $reservationdata = Bookings::where('id', $request->id)->first();
        try {
            if ($request->status == "2") {
                if ($request->table_number == "") {
                    return response()->json(["status" => 0, "message" => trans('messages.table_number_required'), "id" => $request->id], 200);
                }
            }
            $title = '';
            $body = '';
            if ($request->status == 2) {
                $title = trans('labels.booking_accepted');
                $body = 'Your booking request <b>' . $request->id . '</b> has been accepted. Your booked table number is :- <b>' . $request->table_number . '. ';
                $reservationdata->table_number = $request->table_number;
            }
            if ($request->status == 3) {
                $title = trans('labels.booking_rejected');
                $body = 'Your booking request <b>' . $request->id . '</b> has been rejected.';
                $reservationdata->table_number = NULL;
            }
        
            $reservationdata->status = $request->status;
            if ($reservationdata->save()) {
                return response()->json(["status" => 1, "message" => trans('messages.success')], 200);
            } else {
                return response()->json(["status" => 0, "message" => trans('messages.wrong'), "id" => $request->id], 200);
            }
        } catch (\Throwable $th) {
            // throw $th;
            return response()->json(["status" => 0, "message" => $th->getMessage(), "id" => $request->id], 200);
        }
    }
}
