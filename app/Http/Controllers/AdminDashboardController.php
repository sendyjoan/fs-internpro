<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index (){
        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now();

        $logs = DB::table('logs')
            ->select(DB::raw('DATE(created_at) as date'), 'level', DB::raw('count(*) as count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(created_at)'), 'level')
            ->get()
            ->groupBy('date');

        $levels = DB::table('logs')
            ->select('level')
            ->distinct()
            ->pluck('level');

        $dates = [];
        for ($i = 0; $i < 30; $i++) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $dateLogs = $logs->has($date) ? $logs->get($date)->groupBy('level')->map->sum('count') : [];
            foreach ($levels as $level) {
                $dates[$date][$level] = $dateLogs[$level] ?? 0;
            }
        }

        $data['logs'] = array_reverse($dates);

        $logs = DB::table('logs')
            ->select('level', 'message', DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as date'), 'created_at')
            ->orderBy('created_at', 'desc');

        $data['latest_logs'] = $logs->get()->toArray();
        // dd($data);
        return view('modules.dashboard.admin-dashboard', compact('data'));
    }
}
