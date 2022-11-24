<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MonthSelection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MonthSelectionController extends Controller
{
    public function inputSelectedYear(Request $request)
    {
        $user = Auth::user();

        $year = $request->year;

        $monthSelection = DB::table("monthSelection")->where("userId", "=", $user->id)->first();

        DB::table("monthSelection")->where("userId", "=", $user->id)->update([
            "month" => $monthSelection->month,
            "year" => $year,
            "userId" => $user->id
        ]);

        return redirect()->back();

    }
    public function inputSelectedMonth(Request $request)
    {
        $user = Auth::user();

        $month = $request->month;

        $monthSelection = DB::table("monthSelection")->where("userId", "=", $user->id)->first();

        DB::table("monthSelection")->where("userId", "=", $user->id)->update([
            "month" => $month,
            "year" => $monthSelection->year,
            "userId" => $user->id
        ]);

        return redirect()->back();
    }
    public function getLastSelection(){
        $user = Auth::user();
        $lastSelection = DB::table("monthSelection")->where('userId', '=', $user->id)->get();        
        return response($lastSelection);
    }
}