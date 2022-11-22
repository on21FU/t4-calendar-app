<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Month;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AppointmentController extends Controller
{
    public function index(){
        $monthsData = Month::all();
        $user = Auth::user();
        $appointmentData = DB::table('appointments')->where('userId', '=', $user->id)->get();
        $allData = array($monthsData, $appointmentData);
        
        return view('listAppointments', compact('allData'));
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

        return redirect()->route("listAppointments");
    }
    public function editAppointment($id){
        $data = Appointment::where('id', '=', $id)->first();
        return view('editAppointment', compact('data'));
    }
    public function updateAppointment(Request $request){
        $id = $request->id;
        $title = $request->titleInput;
        $date = $request->dateInput;
        $startTime = $request->startTimeInput;
        $endTime = $request->endTimeInput;

        DB::table("appointments")->where('id', '=', $id)->update([
            'title'=>$title,
            'date'=>$date,
            'startTime'=>$startTime,
            'endTime'=>$endTime
        ]);
        return redirect()->route("listAppointments");
    }
    public function deleteAppointment($id){
        Appointment::where('id', '=', $id)->delete();
        return redirect()->route("listAppointments");
    }
    public function getAppointmentsByDate(Request $request){
        $appointments = Appointment::where('date', '=', $request->date)->get();
        return response($appointments);
    }
    public function loadInputData(Request $request){
        $selectedYear = $request->selectYear;
        $selectedMonth = $request->selectMonth;
        $selectedInput [] = array($selectedMonth, $selectedYear);
        return redirect()->route("listAppointments", compact('selectedInput'));
    }

}
