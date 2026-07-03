<?php

namespace App\Http\Controllers;

use App\Models\FinanceRecord;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class AnalyticsController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $now = now();

        /*
        |--------------------------------------------------------------------------
        | Grafik Keuangan 6 Bulan
        |--------------------------------------------------------------------------
        */

        $months = [];
        $balances = [];
        $expenses = [];
        $tasksDone = [];

        $runningBalance = 0;
        $monthlyReport = [];

        for ($i = 5; $i >= 0; $i--) {

            $date = $now->copy()->subMonths($i);

            $income = (float) FinanceRecord::forUser($userId)
                ->income()
                ->whereYear('date', $date->year)
                ->whereMonth('date', $date->month)
                ->sum('amount');

            $expense = (float) FinanceRecord::forUser($userId)
                ->expense()
                ->whereYear('date', $date->year)
                ->whereMonth('date', $date->month)
                ->sum('amount');

            $opening = $runningBalance;

            $runningBalance += ($income - $expense);

            $closing = $runningBalance;

            $months[] = $date->format('M Y');
            $balances[] = $closing;
            $expenses[] = $expense;

            $monthlyReport[] = [
                'month'     => $date->format('F Y'),
                'opening'   => $opening,
                'income'    => $income,
                'expense'   => $expense,
                'closing'   => $closing,
            ];

            $tasksDone[] = Task::forUser($userId)
                ->where('status', 'done')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        $financeData = [
            'labels' => $months,
            'income' => $balances, // grafik saldo
            'expense' => $expenses,
        ];

        $taskData = [
            'labels' => $months,
            'completed' => $tasksDone,
        ];

        /*
        |--------------------------------------------------------------------------
        | Diagram Pengeluaran Bulan Ini
        |--------------------------------------------------------------------------
        */

        $expenseByCategory = FinanceRecord::forUser($userId)
            ->expense()
            ->thisMonth()
            ->get()
            ->groupBy(function ($item) {
                return $item->description ?: 'Tanpa Deskripsi';
            })
            ->map(function ($items) {
                return $items->sum('amount');
            })
            ->sortDesc();

        $categoryData = [
            'labels' => $expenseByCategory->keys()->values()->toArray(),
            'data' => $expenseByCategory->values()->toArray(),
        ];

        /*
        |--------------------------------------------------------------------------
        | Status Task
        |--------------------------------------------------------------------------
        */

        $taskStatus = [
            'todo' => Task::forUser($userId)->where('status', 'todo')->count(),
            'in_progress' => Task::forUser($userId)->where('status', 'in_progress')->count(),
            'done' => Task::forUser($userId)->where('status', 'done')->count(),
        ];

        /*
        |--------------------------------------------------------------------------
        | Ringkasan Keuangan Bulan Ini
        |--------------------------------------------------------------------------
        */

        $openingBalance = (float) FinanceRecord::forUser($userId)
            ->selectRaw("
                SUM(
                    CASE
                        WHEN type='income' THEN amount
                        WHEN type='expense' THEN -amount
                        ELSE 0
                    END
                ) as balance
            ")
            ->whereDate('date', '<', $now->copy()->startOfMonth())
            ->value('balance');

        $openingBalance = $openingBalance ?? 0;

        $totalIncomeThisMonth = (float) FinanceRecord::forUser($userId)
            ->income()
            ->thisMonth()
            ->sum('amount');

        $totalExpenseThisMonth = (float) FinanceRecord::forUser($userId)
            ->expense()
            ->thisMonth()
            ->sum('amount');

        $currentBalance = $openingBalance + $totalIncomeThisMonth - $totalExpenseThisMonth;

        // Tetap dipakai agar Blade lama tidak error
        $netIncomeThisMonth = $currentBalance;

        /*
        |--------------------------------------------------------------------------
        | Statistik Task
        |--------------------------------------------------------------------------
        */

        $tasksDoneThisMonth = Task::forUser($userId)
            ->where('status', 'done')
            ->whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->count();

        $tasksCreatedThisMonth = Task::forUser($userId)
            ->whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->count();

        $taskCompletionRate = $tasksCreatedThisMonth > 0
            ? round(($tasksDoneThisMonth / $tasksCreatedThisMonth) * 100, 1)
            : 0;

        $topExpenseCategory = $expenseByCategory->keys()->first() ?? 'Tidak ada';

        return view('analytics.index', compact(
            'financeData',
            'taskData',
            'categoryData',
            'taskStatus',

            'openingBalance',
            'totalIncomeThisMonth',
            'totalExpenseThisMonth',
            'currentBalance',

            'monthlyReport',

            'netIncomeThisMonth',

            'tasksDoneThisMonth',
            'taskCompletionRate',
            'topExpenseCategory'
        ));
    }
}