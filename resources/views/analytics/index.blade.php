@extends('layouts.app')

@section('title', 'Analytics')
@section('page_title', 'Analytics')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
    <div>
        <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-primary to-emerald-500 mb-1">Analytics Overview</h1>
        <p class="text-sm text-text-muted dark:text-text-darkMuted">Wawasan mendalam tentang produktivitas dan keuangan Anda secara <span class="italic font-medium">real-time</span>.</p>
    </div>
</div>

{{-- KPI Cards --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    {{-- Net Income --}}
    <div class="pcard relative overflow-hidden group hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 bg-white/60 dark:bg-bg-darkCard/60 backdrop-blur-lg border border-white/20">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-500/20 rounded-full blur-2xl group-hover:bg-emerald-500/30 transition-all duration-500"></div>
        <div class="mb-2">
            <p class="text-sm text-text-muted dark:text-text-darkMuted font-medium">Net Income (Bulan Ini)</p>
            <h3 class="text-2xl font-bold text-text-main dark:text-text-darkMain mt-1">
                Rp {{ number_format($netIncomeThisMonth, 0, ',', '.') }}
            </h3>
        </div>
        <div class="flex items-center text-sm {{ $netIncomeThisMonth >= 0 ? 'text-emerald-500' : 'text-red-500' }}">
            <i class="fas {{ $netIncomeThisMonth >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} mr-1.5"></i>
            <span>Pemasukan vs Pengeluaran</span>
        </div>
    </div>

    {{-- Task Completion Rate --}}
    <div class="pcard relative overflow-hidden group hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 bg-white/60 dark:bg-bg-darkCard/60 backdrop-blur-lg border border-white/20">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-primary/20 rounded-full blur-2xl group-hover:bg-primary/30 transition-all duration-500"></div>
        <div class="mb-2">
            <p class="text-sm text-text-muted dark:text-text-darkMuted font-medium">Tingkat Penyelesaian (Bulan Ini)</p>
            <div class="flex items-end mt-1 gap-2">
                <h3 class="text-2xl font-bold text-text-main dark:text-text-darkMain">
                    {{ $taskCompletionRate }}%
                </h3>
                <span class="text-sm text-text-muted dark:text-text-darkMuted mb-1">({{ $tasksDoneThisMonth }} diselesaikan)</span>
            </div>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700/50 mt-3 overflow-hidden">
            <div class="bg-gradient-to-r from-primary to-indigo-500 h-2.5 rounded-full transition-all duration-1000 ease-out" style="width: {{ $taskCompletionRate }}%"></div>
        </div>
    </div>

    {{-- Top Expense --}}
    <div class="pcard relative overflow-hidden group hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 bg-white/60 dark:bg-bg-darkCard/60 backdrop-blur-lg border border-white/20">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-red-500/20 rounded-full blur-2xl group-hover:bg-red-500/30 transition-all duration-500"></div>
        <div class="mb-2">
            <p class="text-sm text-text-muted dark:text-text-darkMuted font-medium">Pengeluaran Terbesar</p>
            <h3 class="text-2xl font-bold text-text-main dark:text-text-darkMain mt-1 truncate">
                {{ $topExpenseCategory }}
            </h3>
        </div>
        <div class="flex items-center text-sm text-red-500">
            <i class="fas fa-fire mr-1.5"></i>
            <span>Kategori dominan bulan ini</span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Mixed Chart: Productivity vs Finance --}}
    <div class="pcard flex flex-col animate-stagger-card opacity-0 lg:col-span-2 h-[420px] shadow-sm hover:shadow-md transition-shadow">
        <div class="mb-6 flex justify-between items-start">
            <div>
                <h2 class="text-lg font-semibold text-text-main dark:text-text-darkMain flex items-center gap-2">
                    <i class="fas fa-chart-line text-primary"></i> Korelasi Produktivitas & Keuangan
                </h2>
                <p class="text-sm text-text-muted dark:text-text-darkMuted mt-1">6 Bulan Terakhir (Klik pada area chart untuk detail)</p>
            </div>
            <div class="bg-primary/10 border border-primary/20 text-primary text-xs px-3 py-1 rounded-full font-medium flex items-center gap-1.5 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                Interactive
            </div>
        </div>
        <div class="flex-1 relative w-full h-full pb-2">
            <canvas id="mixedChart"></canvas>
        </div>
    </div>

    {{-- Expense by Category (Doughnut) --}}
    <div class="pcard flex flex-col animate-stagger-card opacity-0 h-[420px] bg-gradient-to-br from-white to-gray-50/50 dark:from-bg-darkCard dark:to-[#222224] shadow-sm hover:shadow-md transition-shadow border-t border-t-white/40 dark:border-t-white/5">
        <div class="mb-4 text-center">
            <h2 class="text-lg font-semibold text-text-main dark:text-text-darkMain">Distribusi Pengeluaran</h2>
            <p class="text-sm text-text-muted dark:text-text-darkMuted">Komposisi Bulan Ini</p>
        </div>
        <div class="flex-1 relative w-full h-full flex justify-center items-center">
            @if(count($categoryData['data']) > 0)
                <canvas id="categoryChart"></canvas>
            @else
                <div class="flex flex-col items-center justify-center text-text-muted dark:text-text-darkMuted text-sm text-center p-6 bg-gray-100/50 dark:bg-gray-800/30 rounded-xl border border-dashed border-gray-300 dark:border-gray-700 w-full h-full">
                    <div class="w-16 h-16 rounded-full bg-gray-200 dark:bg-gray-800 flex items-center justify-center mb-4">
                        <i class="fas fa-chart-pie text-2xl opacity-50"></i>
                    </div>
                    <p class="font-medium">Belum ada data</p>
                    <p class="text-xs mt-1 opacity-75">Tambahkan pengeluaran bulan ini untuk melihat grafik.</p>
                </div>
            @endif
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const isDark = document.documentElement.classList.contains('dark');
    const textColor = isDark ? '#eaeaeb' : '#1a1a18';
    const gridColor = isDark ? 'rgba(255, 255, 255, 0.06)' : 'rgba(0, 0, 0, 0.06)';
    const tooltipBg = isDark ? 'rgba(25, 25, 25, 0.95)' : 'rgba(255, 255, 255, 0.95)';
    const tooltipText = isDark ? '#f3f4f6' : '#1f2937';

    Chart.defaults.color = textColor;
    Chart.defaults.font.family = "'Inter', 'system-ui', 'sans-serif'";

    // Data from Controller
    const financeData = @json($financeData);
    const taskData = @json($taskData);
    const categoryData = @json($categoryData);

    // Common Tooltip options for premium feel
    const premiumTooltip = {
        backgroundColor: tooltipBg,
        titleColor: tooltipText,
        bodyColor: tooltipText,
        titleFont: { size: 14, weight: 'bold', family: "'Inter', sans-serif" },
        bodyFont: { size: 13, family: "'Inter', sans-serif" },
        borderColor: isDark ? 'rgba(255,255,255,0.1)' : 'rgba(0,0,0,0.05)',
        borderWidth: 1,
        padding: 14,
        boxPadding: 8,
        cornerRadius: 8,
        usePointStyle: true,
        callbacks: {
            label: function(context) {
                let label = context.dataset.label || '';
                if (label) {
                    label += ': ';
                }
                if (context.parsed.y !== null) {
                    if (context.dataset.yAxisID === 'y') {
                        // format currency
                        label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(context.parsed.y);
                    } else {
                        label += context.parsed.y + ' Tasks';
                    }
                }
                return label;
            }
        }
    };

    // 1. Mixed Chart (Finance + Tasks)
    const ctxMixed = document.getElementById('mixedChart');
    if (ctxMixed) {
        const mixedChart = new Chart(ctxMixed, {
            type: 'bar',
            data: {
                labels: financeData.labels,
                datasets: [
                    {
                        type: 'line',
                        label: 'Tasks Selesai',
                        data: taskData.completed,
                        borderColor: '#8b5cf6', // violet-500
                        backgroundColor: 'rgba(139, 92, 246, 0.15)',
                        borderWidth: 3,
                        tension: 0.4, // Smooth curves
                        yAxisID: 'y1',
                        pointBackgroundColor: isDark ? '#1e1e20' : '#ffffff',
                        pointBorderColor: '#8b5cf6',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 7,
                        pointHoverBackgroundColor: '#8b5cf6',
                        pointHoverBorderColor: '#ffffff',
                        fill: true,
                        order: 1
                    },
                    {
                        type: 'bar',
                        label: 'Pemasukan',
                        data: financeData.income,
                        backgroundColor: 'rgba(16, 185, 129, 0.85)', // emerald-500
                        hoverBackgroundColor: 'rgba(16, 185, 129, 1)',
                        borderRadius: { topLeft: 6, topRight: 6 },
                        borderSkipped: false,
                        yAxisID: 'y',
                        order: 2,
                        barPercentage: 0.8,
                        categoryPercentage: 0.7
                    },
                    {
                        type: 'bar',
                        label: 'Pengeluaran',
                        data: financeData.expense,
                        backgroundColor: 'rgba(239, 68, 68, 0.85)', // red-500
                        hoverBackgroundColor: 'rgba(239, 68, 68, 1)',
                        borderRadius: { topLeft: 6, topRight: 6 },
                        borderSkipped: false,
                        yAxisID: 'y',
                        order: 3,
                        barPercentage: 0.8,
                        categoryPercentage: 0.7
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'index',
                    intersect: false
                },
                onClick: (e, elements) => {
                    if (elements.length > 0) {
                        const idx = elements[0].index;
                        const month = financeData.labels[idx];
                        const inc = financeData.income[idx];
                        const exp = financeData.expense[idx];
                        const tsks = taskData.completed[idx];
                        
                        // SweetAlert would be better here, but using standard alert or custom logic for now
                        const formatter = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 });
                        const net = inc - exp;
                        const insight = (tsks > 5 && net > 0) ? 'Bulan yang sangat produktif dan profitabel! 🚀' : 
                                      (net < 0) ? 'Pengeluaran melebihi pemasukan bulan ini. ⚠️' : 
                                      'Kinerja yang stabil. Tetap semangat! 💪';

                        alert(`📊 INSIGHT ANALYTICS - ${month}\n\n` +
                              `📈 Pemasukan: ${formatter.format(inc)}\n` +
                              `📉 Pengeluaran: ${formatter.format(exp)}\n` +
                              `💰 Net Profit: ${formatter.format(net)}\n` +
                              `✅ Tasks Selesai: ${tsks} tasks\n\n` +
                              `Kesimpulan: ${insight}`);
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: "'Inter', sans-serif" } }
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        grid: { color: gridColor, borderDash: [4, 4], drawBorder: false },
                        title: { display: true, text: 'Keuangan (Rupiah)', color: textColor, font: {size: 11, weight: '500'} },
                        ticks: {
                            callback: function(value) {
                                return value >= 1000000 ? (value / 1000000) + 'M' : value >= 1000 ? (value / 1000) + 'K' : value;
                            },
                            font: { family: "'Inter', sans-serif" }
                        },
                        border: { display: false }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        grid: { drawOnChartArea: false }, // only draw grid lines for one axis
                        title: { display: true, text: 'Produktivitas (Tasks)', color: textColor, font: {size: 11, weight: '500'} },
                        min: 0,
                        ticks: { font: { family: "'Inter', sans-serif" } },
                        border: { display: false }
                    }
                },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { 
                            usePointStyle: true, 
                            padding: 24,
                            font: { family: "'Inter', sans-serif", size: 12 }
                        }
                    },
                    tooltip: premiumTooltip
                }
            }
        });
    }

    // 2. Category Chart (Doughnut) with custom tooltip and hover effects
    const ctxCategory = document.getElementById('categoryChart');
    if (ctxCategory && categoryData.data.length > 0) {
        new Chart(ctxCategory, {
            type: 'doughnut',
            data: {
                labels: categoryData.labels,
                datasets: [{
                    data: categoryData.data,
                    backgroundColor: [
                        '#3b82f6', // blue
                        '#10b981', // emerald
                        '#f59e0b', // amber
                        '#ef4444', // red
                        '#8b5cf6', // violet
                        '#ec4899', // pink
                        '#06b6d4', // cyan
                        '#64748b'  // slate
                    ],
                    borderWidth: 3,
                    borderColor: isDark ? '#1e1e20' : '#ffffff', // matches card background
                    hoverOffset: 12, // pop-out effect on hover
                    hoverBorderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                layout: {
                    padding: 15
                },
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            usePointStyle: true,
                            boxWidth: 8,
                            padding: 16,
                            font: { family: "'Inter', sans-serif", size: 12 }
                        }
                    },
                    tooltip: {
                        backgroundColor: tooltipBg,
                        titleColor: tooltipText,
                        bodyColor: tooltipText,
                        titleFont: { size: 13, family: "'Inter', sans-serif" },
                        bodyFont: { size: 13, weight: 'bold', family: "'Inter', sans-serif" },
                        borderColor: isDark ? 'rgba(255,255,255,0.1)' : 'rgba(0,0,0,0.05)',
                        borderWidth: 1,
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                let label = ' ';
                                if (context.parsed !== null) {
                                    label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(context.parsed);
                                }
                                
                                // Calculate percentage
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((context.parsed / total) * 100);
                                label += ` (${percentage}%)`;
                                
                                return label;
                            }
                        }
                    }
                }
            }
        });
    }
});
</script>
@endpush
