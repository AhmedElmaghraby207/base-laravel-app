<?php

namespace App\Http\Controllers\Dashboard;

use App\Branch;
use App\Faq;
use App\Message;
use App\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends BaseController
{

    function __construct(Request $request)
    {
        parent::__construct();
    }

    public function dashboard(Request $request)
    {
        $patients_count = Patient::all()->count();

        $latest_patients = Patient::query()->orderBy('created_at', 'desc')->take(5)->get();

        $patients_per_day = DB::table('patients')
            ->select(DB::raw('DATE(created_at) as day'), DB::raw('count(*) as patients'))
            ->groupBy('day')
            ->take(10)
            ->get();

        $patients_per_week = DB::table('patients')
            ->select(DB::raw('WEEK(created_at) as week'), DB::raw('count(*) as patients'))
            ->groupBy('week')
            ->take(10)
            ->get();

        $patients_per_month = DB::table('patients')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as patients'))
            ->groupBy('month')
            ->take(10)
            ->get();

        $patients_per_year = DB::table('patients')
            ->select(DB::raw('YEAR(created_at) as year'), DB::raw('count(*) as patients'))
            ->groupBy('year')
            ->take(10)
            ->get();

        return view('dashboard.dashboard')->with([
            'patients_count' => $patients_count,

            'latest_patients' => $latest_patients,
            'patients_per_day' => $patients_per_day,
            'patients_per_week' => $patients_per_week,
            'patients_per_month' => $patients_per_month,
            'patients_per_year' => $patients_per_year,

        ]);
    }

    public function emailTempView(Request $request)
    {
        $p = Patient::all()->first();
        return view('emails.patient.reset-password')
            ->with([
                'patient' => $p,
                'token' => $p->token,
                'senderName' => '',
                'logo' => ['width' => 70, 'height' => 70],
            ]);
    }

}
