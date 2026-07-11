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
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-6 mb-8">

    {{-- Saldo Awal --}}
    <div class="pcard">
        <p class="text-sm text-text-muted">💰 Saldo Awal Bulan</p>

        <h2 class="text-2xl font-bold mt-2">
            Rp {{ number_format($openingBalance,0,',','.') }}
        </h2>

        <p class="text-xs mt-3 text-gray-500">
            Sisa uang dari bulan sebelumnya
        </p>
    </div>

    {{-- Pemasukan --}}
    <div class="pcard">
        <p class="text-sm text-text-muted">
            📈 Pemasukan Bulan Ini
        </p>

        <h2 class="text-2xl font-bold mt-2 text-emerald-500">
            Rp {{ number_format($totalIncomeThisMonth,0,',','.') }}
        </h2>

        <p class="text-xs mt-3 text-gray-500">
            Total uang yang diterima
        </p>
    </div>

    {{-- Pengeluaran --}}
    <div class="pcard">

        <p class="text-sm text-text-muted">
            📉 Pengeluaran Bulan Ini
        </p>

        <h2 class="text-2xl font-bold mt-2 text-red-500">
            Rp {{ number_format($totalExpenseThisMonth,0,',','.') }}
        </h2>

        <p class="text-xs mt-3 text-gray-500">
            Total uang yang digunakan
        </p>

    </div>

    {{-- Saldo Saat Ini --}}
    <div class="pcard">

        <p class="text-sm text-text-muted">
            💵 Saldo Saat Ini
        </p>

        <h2 class="text-2xl font-bold mt-2 text-primary">

            Rp {{ number_format($currentBalance,0,',','.') }}

        </h2>

        <p class="text-xs mt-3 text-gray-500">

            Saldo yang masih tersedia

        </p>

    </div>

    {{-- Progress Task --}}
    <div class="pcard">

        <p class="text-sm text-text-muted">

            ✅ Progress Task

        </p>

        <h2 class="text-2xl font-bold mt-2">

            {{ $taskCompletionRate }}%

        </h2>

        <div class="w-full h-2 bg-gray-200 rounded-full mt-4">

            <div class="bg-primary h-2 rounded-full"
                style="width: {{ $taskCompletionRate }}%">
            </div>

        </div>

        <p class="text-xs mt-2 text-gray-500">

            {{ $tasksDoneThisMonth }} tugas selesai bulan ini

        </p>

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
    <div class="pcard flex flex-col animate-stagger-card opacity-0 min-h-[620px] bg-gradient-to-br from-white to-gray-50/50 dark:from-bg-darkCard dark:to-[#222224] shadow-sm hover:shadow-md transition-shadow border-t border-t-white/40 dark:border-t-white/5">
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
{{-- Laporan Saldo 6 Bulan --}}
<div class="pcard mt-8">

    <div class="mb-5">

        <h2 class="text-xl font-semibold text-text-main dark:text-text-darkMain">
            💰 Laporan Saldo 6 Bulan
        </h2>

        <p class="text-sm text-text-muted mt-1">
            Saldo akhir bulan sebelumnya otomatis menjadi saldo awal bulan berikutnya.
        </p>

    </div>

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead>

                <tr class="border-b">

                    <th class="text-left py-3">Bulan</th>

                    <th class="text-right py-3">Saldo Awal</th>

                    <th class="text-right py-3 text-emerald-500">
                        Pemasukan
                    </th>

                    <th class="text-right py-3 text-red-500">
                        Pengeluaran
                    </th>

                    <th class="text-right py-3 text-primary">
                        Saldo Akhir
                    </th>

                </tr>

            </thead>

            <tbody>

                @foreach($monthlyReport as $report)

                <tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-800/30 transition">

                    <td class="py-4 font-medium">

                        {{ $report['month'] }}

                    </td>

                    <td class="text-right">

                        Rp {{ number_format($report['opening'],0,',','.') }}

                    </td>

                    <td class="text-right text-emerald-500">

                        Rp {{ number_format($report['income'],0,',','.') }}

                    </td>

                    <td class="text-right text-red-500">

                        Rp {{ number_format($report['expense'],0,',','.') }}

                    </td>

                    <td class="text-right font-bold text-primary">

                        Rp {{ number_format($report['closing'],0,',','.') }}

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>
@if(count($categoryData['data']) > 0)

<div class="mt-6 border-t pt-4">

    @php
        $totalExpense = array_sum($categoryData['data']);
        $colors = [
            '#3B82F6',
            '#10B981',
            '#F59E0B',
            '#EF4444',
            '#8B5CF6',
            '#EC4899',
            '#06B6D4',
            '#84CC16',
            '#F97316',
            '#14B8A6',
            '#6366F1',
            '#A855F7',
            '#22C55E',
            '#EAB308',
            '#DC2626'
        ];
    @endphp

    <h3 class="font-semibold mb-3">
        Rincian Pengeluaran
    </h3>

    @foreach($categoryData['labels'] as $i => $label)

        @php

            $value = $categoryData['data'][$i];

            $percent = $totalExpense > 0
                ? round(($value / $totalExpense) * 100,1)
                : 0;

        @endphp

        <div class="flex items-center justify-between py-2">

            <div class="flex items-center gap-3">

                <span class="w-4 h-4 rounded-full inline-block flex-shrink-0"
                    style="background: {{ $colors[$i % count($colors)] }};"></span>

                <span>{{ $label }}</span>

            </div>

            <div class="text-right">

                <div class="font-semibold">

                    Rp {{ number_format($value,0,',','.') }}

                </div>

                <div class="text-xs text-gray-500">

                    {{ $percent }} %

                </div>

            </div>

        </div>

    @endforeach

</div>

@endif
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
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

                        alert(`📊 LAPORAN BULAN ${month}\n\n💰 Saldo Akhir : ${formatter.format(inc)}\n📉 Pengeluaran : ${formatter.format(exp)}\n✅ Task Selesai : ${tsks}\n\nSaldo bulan ini otomatis menjadi saldo awal bulan berikutnya.`);
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
                plugins: [ChartDataLabels],

                type: 'doughnut',

                data: {
                    labels: categoryData.labels,
                    datasets: [{
                        data: categoryData.data,

                        backgroundColor: categoryData.labels.map((_, index) => {

                            const colors = [
                                '#3B82F6',
                                '#10B981',
                                '#F59E0B',
                                '#EF4444',
                                '#8B5CF6',
                                '#EC4899',
                                '#06B6D4',
                                '#84CC16',
                                '#F97316',
                                '#14B8A6',
                                '#6366F1',
                                '#A855F7',
                                '#22C55E',
                                '#EAB308',
                                '#DC2626'
                            ];

                            return colors[index % colors.length];

                        }),

                        borderWidth: 3,
                        borderColor: isDark ? '#1e1e20' : '#ffffff',

                        hoverOffset: 22,
                        hoverBorderWidth: 4,
                        hoverBorderColor: '#ffffff'
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

                        datalabels: {

                            color: '#ffffff',

                            font: {
                                weight: 'bold',
                                size: 13
                            },

                            formatter: function(value, context) {

                                const total = context.chart.data.datasets[0].data
                                    .reduce((a, b) => Number(a) + Number(b), 0);

                                if (total <= 0) return '';

                                return ((value / total) * 100).toFixed(1) + '%';
                            }

                        },

                        legend: {

                            position: 'right',

                            labels: {
                                color: textColor,
                                usePointStyle: true,
                                padding: 20
                            }

                        },

                        tooltip: {

                            backgroundColor: tooltipBg,
                            titleColor: tooltipText,
                            bodyColor: tooltipText,

                            borderColor: isDark
                                ? 'rgba(255,255,255,.1)'
                                : 'rgba(0,0,0,.05)',

                            borderWidth: 1,
                            padding: 12,
                            cornerRadius: 8,

                            callbacks: {

                                label: function(context) {

                                    const value = context.parsed;

                                    const total = context.dataset.data
                                        .reduce((a, b) => Number(a) + Number(b), 0);

                                    const percentage = total > 0
                                        ? ((value / total) * 100).toFixed(1)
                                        : 0;

                                 return [
                                context.label,
                                new Intl.NumberFormat('id-ID', {
                                    style: 'currency',
                                    currency: 'IDR',
                                    maximumFractionDigits: 0
                                }).format(value),
                                percentage + '%'
];
                        } // label
                    } // callbacks
                } // tooltip
            } // plugins
        } // options
    }); // new Chart
} // if (ctxCategory)

}); // DOMContentLoaded
</script>
@endpush