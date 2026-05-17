<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
class ContactController extends Controller
{
    public function index(){
        $getcontact = Contact::orderByDesc('id')->get();
        return view('admin.contact.contact',compact('getcontact'));
    }
    public function destroy(Request $request){
        $deletedata = Contact::where('id', $request->id)->delete();
        if ($deletedata) {
            return 1;
        } else {
            return 0;
        }
    }
}
