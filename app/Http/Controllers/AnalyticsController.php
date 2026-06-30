<?php

namespace App\Http\Controllers;

use App\Models\FinanceRecord;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnalyticsController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $now    = now();

        // Build 6-month trend data
        $months     = [];
        $incomes    = [];
        $expenses   = [];
        $tasksDone  = [];

        for ($i = 5; $i >= 0; $i--) {
            $date  = $now->copy()->subMonths($i);
            $label = $date->format('M Y');

            $months[]   = $label;
            $incomes[]  = (float) FinanceRecord::forUser($userId)
                ->income()
                ->whereYear('date', $date->year)
                ->whereMonth('date', $date->month)
                ->sum('amount');

            $expenses[] = (float) FinanceRecord::forUser($userId)
                ->expense()
                ->whereYear('date', $date->year)
                ->whereMonth('date', $date->month)
                ->sum('amount');

            $tasksDone[] = Task::forUser($userId)
                ->where('status', 'done')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        $financeData = [
            'labels' => $months,
            'income' => $incomes,
            'expense' => $expenses,
        ];

        $taskData = [
            'labels' => $months,
            'completed' => $tasksDone,
        ];

        // Expense by category (this month)
        $expenseByCategory = FinanceRecord::forUser($userId)
            ->expense()
            ->thisMonth()
            ->with('category')
            ->get()
            ->groupBy(fn($r) => $r->category?->name ?? 'Lainnya')
            ->map(fn($g) => $g->sum('amount'))
            ->sortDesc();

        $categoryData = [
            'labels' => $expenseByCategory->keys()->toArray(),
            'data' => $expenseByCategory->values()->toArray(),
        ];

        // Task status distribution (Overall)
        $taskStatus = [
            'todo'        => Task::forUser($userId)->where('status', 'todo')->count(),
            'in_progress' => Task::forUser($userId)->where('status', 'in_progress')->count(),
            'done'        => Task::forUser($userId)->where('status', 'done')->count(),
        ];

        // --- KPIs for this month ---
        $totalIncomeThisMonth = (float) FinanceRecord::forUser($userId)
            ->income()
            ->thisMonth()
            ->sum('amount');

        $totalExpenseThisMonth = (float) FinanceRecord::forUser($userId)
            ->expense()
            ->thisMonth()
            ->sum('amount');

        $netIncomeThisMonth = $totalIncomeThisMonth - $totalExpenseThisMonth;

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
            'financeData', 'taskData', 'categoryData', 'taskStatus',
            'totalIncomeThisMonth', 'totalExpenseThisMonth', 'netIncomeThisMonth',
            'tasksDoneThisMonth', 'taskCompletionRate', 'topExpenseCategory'
        ));
    }
}
