<?php

namespace App\Http\Controllers;

use App\Models\Month;
use Illuminate\Http\Request;

class monthController extends Controller
{
        public function index(){

            $monthsData = Month::all();
            return view('calendar', compact('monthsData'));
        }
        public function loadThings(Request $request){
            $month = $request->selectMonth;
            $year = $request->selectYear;
            $data = array($month, $year);
            return view('calendar', ["selectedDate"=> $data]);
        }
}
