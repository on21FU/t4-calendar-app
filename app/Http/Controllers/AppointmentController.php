<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function index(){
        $user = Auth::user();
        $data = DB::table('appointments')->where('userId', '=', $user->id)->get();
        return view('listAppointments', compact('data'));
    }
    public function addAppointment(){
        return view('addAppointment');
    }

    public function saveAppointment(Request $request){
        $user = Auth::user();

        $title = $request->titleInput;
        $date = $request->dateInput;
        $startTime = $request->startTimeInput;
        $endTime = $request->endTimeInput;

        DB::table("appointments")->insert([
                    "title" => $title,
                    "date" => $date,
                    "startTime" => $startTime,
                    "endTime" => $endTime,  
                    "userId" => $user->id
                ]);

        return redirect()->route("listAppointments")->with("success", "Appointment created Successfully");;
    }
}
