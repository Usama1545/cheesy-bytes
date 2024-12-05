<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Bookings;
use App\Models\User;
use App\Helpers\helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class BookingsController extends Controller
{
    public function store(Request $request)
    {
        try {
            $booking_number = substr(str_shuffle(str_repeat("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ", 10)), 0, 10);
            $date = helper::date_format($request->date);
            $time = helper::time_format($request->time);
            // to - Admin
            $emaildata = helper::emailconfigration();
            Config::set('mail', $emaildata);
            $getadmindata = User::select('id', 'name', 'email')->where('type', 1)->first();
            $data = ['name' => $getadmindata->name, 'adminemail' => $getadmindata->email, 'booking_number' => $booking_number, 'logo' => helper::image_path(helper::appdata()->logo), 'url' => url('/admin/bookings'), 'fullname' => $request->name, 'email' => $request->email, 'mobile' => $request->mobile, 'guests' => $request->guests, 'reservation_type' => $request->reservation_type, 'date' => $date, 'time' => $time, 'special_request' => $request->special_request,];
            Mail::send('email.reservation', $data, function ($message) use ($data) {
                $message->to($data['adminemail'])->subject(trans('labels.new_booking'));
            });
            // to - User
            $data = ['name' => $request->name, 'email' => $request->email, 'booking_number' => $booking_number, 'logo' => helper::image_path(helper::appdata()->logo), 'url' => url('/admin/bookings'), 'fullname' => $request->name, 'mobile' => $request->mobile, 'guests' => $request->guests, 'reservation_type' => $request->reservation_type, 'date' => $date, 'time' => $time, 'special_request' => $request->special_request,];
            Mail::send('email.reservation', $data, function ($message) use ($data) {
                $message->to($data['email'])->subject(trans('labels.new_booking'));
            });
            $booking = new Bookings();
            $booking->booking_number = $booking_number;
            $booking->date = $date;
            $booking->time = $time;
            $booking->guests = $request->guests;
            $booking->reservation_type = $request->reservation_type;
            $booking->name = $request->name;
            $booking->email = $request->email;
            $booking->mobile = $request->mobile;
            $booking->special_request = $request->special_request;
            $booking->status = 1;
            $booking->save();
            return redirect()->back()->with('success', trans('messages.success'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', trans('messages.wrong'));
        }
    }
}
