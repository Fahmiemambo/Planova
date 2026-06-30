<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\FinanceRecord;
use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $now    = now();

        // Tasks summary
        $taskStats = [
            'todo'        => Task::forUser($userId)->where('status', 'todo')->count(),
            'in_progress' => Task::forUser($userId)->where('status', 'in_progress')->count(),
            'done'        => Task::forUser($userId)->where('status', 'done')->count(),
            'overdue'     => Task::forUser($userId)
                                 ->where('status', '!=', 'done')
                                 ->whereNotNull('due_date')
                                 ->whereDate('due_date', '<', $now->toDateString())
                                 ->count(),
        ];
        $taskStats['total'] = $taskStats['todo'] + $taskStats['in_progress'] + $taskStats['done'];

        // Finance summary (this month)
        $totalIncome  = FinanceRecord::forUser($userId)->income()->thisMonth()->sum('amount');
        $totalExpense = FinanceRecord::forUser($userId)->expense()->thisMonth()->sum('amount');
        $netBalance   = $totalIncome - $totalExpense;

        // Budgets (current month)
        $budgets = Budget::where('user_id', $userId)
            ->where('period', 'monthly')
            ->where('period_year', $now->year)
            ->where('period_month', $now->month)
            ->with('category')
            ->get();

        // Recent tasks (5 most recent)
        $recentTasks = Task::forUser($userId)
            ->where('status', '!=', 'done')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Recent transactions (5 most recent)
        $recentFinance = FinanceRecord::forUser($userId)
            ->with('category')
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'taskStats', 'totalIncome', 'totalExpense', 'netBalance',
            'budgets', 'recentTasks', 'recentFinance'
        ));
    }
}
