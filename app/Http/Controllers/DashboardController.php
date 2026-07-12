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

        // Economy news (static latest updates)
        $economyNews = collect([
            [
                'title' => 'Bank Indonesia pertahankan suku bunga hingga 6,00%',
                'summary' => 'BI menegaskan stabilitas makroekonomi tetap terjaga meski tekanan global meningkat.',
                'source' => 'Detik Finance',
                'date' => '12 Juli 2026',
                'url' => 'https://www.detik.com/finance'
            ],
            [
                'title' => 'Inflasi terkendali, daya beli konsumen membaik di kuartal kedua',
                'summary' => 'Pertumbuhan konsumsi rumah tangga menjadi pendorong utama pemulihan ekonomi nasional.',
                'source' => 'Kontan',
                'date' => '11 Juli 2026',
                'url' => 'https://www.kontan.co.id/'
            ],
            [
                'title' => 'Investasi asing masuk ke sektor energi hijau',
                'summary' => 'Dana segar mengalir ke proyek transisi energi seiring target net-zero Indonesia.',
                'source' => 'Bisnis Indonesia',
                'date' => '10 Juli 2026',
                'url' => 'https://www.bisnis.com/'
            ],
            [
                'title' => 'Pelonggaran pajak UMKM diharapkan dorong pertumbuhan usaha kecil',
                'summary' => 'Kebijakan fiskal baru ditargetkan untuk memperkuat daya saing usaha mikro dan kecil.',
                'source' => 'Investor Daily',
                'date' => '9 Juli 2026',
                'url' => 'https://www.investor.id/'
            ],
        ]);

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
            'economyNews', 'recentTasks', 'recentFinance'
        ));
    }
}
