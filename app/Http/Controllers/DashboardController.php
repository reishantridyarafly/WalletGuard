<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Spending;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $labels = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
        $incomeData = [];
        $spendingData = [];

        foreach ($labels as $day) {
            $dayNumber = date('N', strtotime($day));
            $incomeTotal = Income::where('user_id', auth()->user()->id)
                ->whereRaw("DAYOFWEEK(created_at) = $dayNumber")
                ->sum('income');

            $spendingTotal = Spending::where('user_id', auth()->user()->id)
                ->whereRaw("DAYOFWEEK(created_at) = $dayNumber")
                ->sum('spending');

            $incomeData[] = $incomeTotal;
            $spendingData[] = $spendingTotal;
        }

        $chartData = [
            'labels' => $labels,
            'datasets' => [
                [
                    "label" => "Income",
                    "backgroundColor" => "rgba(114, 124, 245, 0.3)",
                    "borderColor" => "#727cf5",
                    "data" => $incomeData
                ],
                [
                    "label" => "Spending",
                    "backgroundColor" => "transparent",
                    "borderColor" => "#0acf97",
                    "borderDash" => [5, 5],
                    "data" => $spendingData
                ],
            ],
        ];

        $chartDataJSON = json_encode($chartData);

        $totalIncome = Income::where('user_id', auth()->user()->id)->sum('income');
        $totalSpending = Spending::where('user_id', auth()->user()->id)->sum('spending');
        
        return view('dashboard.index', compact('totalIncome', 'totalSpending', 'chartData', 'chartDataJSON'));
    }
}
