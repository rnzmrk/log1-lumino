@extends('components.app')

@section('content')
    {{-- Page title --}}
    <div class="mb-6">
        <h1 class="text-xs font-semibold tracking-[0.25em] text-slate-400 uppercase">
            Dashboard
        </h1>
    </div>
    </section>

    {{-- KPI cards row --}}
    <section class="mb-8">
        <div class="grid gap-4 md:grid-cols-4">
            {{-- Pending Request for Supplies --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">
                        Pending Requests
                    </div>
                    <div class="h-8 w-8 flex items-center justify-center rounded-xl bg-amber-50 text-amber-500">
                        {{-- cart icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                            <path d="M3.75 5.25h2.25L7.5 15.75h11.25" stroke="currentColor" stroke-width="1.5"
                                  stroke-linecap="round" stroke-linejoin="round" />
                            <circle cx="9" cy="18" r="1.25" fill="currentColor" />
                            <circle cx="17" cy="18" r="1.25" fill="currentColor" />
                        </svg>
                    </div>
                </div>
                <div class="text-2xl font-semibold text-slate-900">
                    {{ $stats['pending_requests'] }}
                </div>
                <div class="mt-3 text-xs text-slate-500">
                    Awaiting approval
                </div>
            </div>

            {{-- Purchase Orders Pending --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">
                        Purchase Orders
                    </div>
                    <div class="h-8 w-8 flex items-center justify-center rounded-xl bg-purple-50 text-purple-500">
                        {{-- document icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                            <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>
                <div class="text-2xl font-semibold text-slate-900">
                    {{ $stats['pending_purchase_orders'] }}
                </div>
                <div class="mt-3 text-xs text-slate-500">
                    Pending approval
                </div>
            </div>

            {{-- Inbound Pending --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">
                        Inbound Shipments
                    </div>
                    <div class="h-8 w-8 flex items-center justify-center rounded-xl bg-blue-50 text-blue-500">
                        {{-- inbound icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                            <path d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>
                <div class="text-2xl font-semibold text-slate-900">
                    {{ $stats['inbound_pending'] }}
                </div>
                <div class="mt-3 text-xs text-slate-500">
                    Pending arrival
                </div>
            </div>

            {{-- Low Stock Items --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">
                        Low Stock Items
                    </div>
                    <div class="h-8 w-8 flex items-center justify-center rounded-xl bg-red-50 text-red-500">
                        {{-- warning icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                            <path d="M12 9v4m0 4h.01M3 12a9 9 0 1018 0 9 9 0 00-18 0z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>
                <div class="text-2xl font-semibold text-slate-900">
                    {{ $stats['low_stock_items'] }}
                </div>
                <div class="mt-3 text-xs text-slate-500">
                    From inventory status
                </div>
            </div>
        </div>

        {{-- Second row of cards --}}
        <div class="grid gap-4 md:grid-cols-4 mt-4">
            {{-- Out of Stock Items --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">
                        Out of Stock Items
                    </div>
                    <div class="h-8 w-8 flex items-center justify-center rounded-xl bg-red-50 text-red-500">
                        {{-- warning icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                            <path d="M12 9v4m0 4h.01M3 12a9 9 0 1018 0 9 9 0 00-18 0z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>
                <div class="text-2xl font-semibold text-slate-900">
                    {{ $stats['out_of_stock_items'] }}
                </div>
                <div class="mt-3 text-xs text-slate-500">
                    From inventory status
                </div>
            </div>

            {{-- Vehicle Maintenance --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">
                        Vehicle Maintenance
                    </div>
                    <div class="h-8 w-8 flex items-center justify-center rounded-xl bg-orange-50 text-orange-500">
                        {{-- warning icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                            <path d="M12 9v4m0 4h.01M3 12a9 9 0 1018 0 9 9 0 00-18 0z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>
                <div class="text-2xl font-semibold text-slate-900">
                    {{ $stats['maintenance_pending'] }}
                </div>
                <div class="mt-3 text-xs text-slate-500">
                    Pending maintenance
                </div>
            </div>

            {{-- Outbound Pending --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">
                        Outbound Shipments
                    </div>
                    <div class="h-8 w-8 flex items-center justify-center rounded-xl bg-green-50 text-green-500">
                        {{-- outbound icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                            <path d="M17 16V4m0 0L21 8m-4-4l-4 4m-4 0v12m0 0l4-4m-4 4l-4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>
                <div class="text-2xl font-semibold text-slate-900">
                    0
                </div>
                <div class="mt-3 text-xs text-slate-500">
                    Pending dispatch
                </div>
            </div>

            {{-- Returns Pending --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">
                        Returns Pending
                    </div>
                    <div class="h-8 w-8 flex items-center justify-center rounded-xl bg-yellow-50 text-yellow-500">
                        {{-- return icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                            <path d="M16 15l-4-4 4-4m-4 8H4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>
                <div class="text-2xl font-semibold text-slate-900">
                    0
                </div>
                <div class="mt-3 text-xs text-slate-500">
                    Pending returns
                </div>
            </div>
        </div>
    </section>

    {{-- Charts Section --}}
    <section class="grid gap-4 lg:grid-cols-2 mb-8">
        {{-- Most Out of Stock Items Chart --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-semibold text-slate-900">
                        Most Out of Stock Items
                    </h3>
                    <p class="text-xs text-slate-500">
                        Items frequently out of stock (last 30 days)
                    </p>
                </div>
                <div class="h-8 w-8 flex items-center justify-center rounded-xl bg-red-50 text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                        <path d="M12 9v4m0 4h.01M3 12a9 9 0 1018 0 9 9 0 00-18 0z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
            </div>
            
            <div class="h-80">
                <canvas id="outOfStockChart"></canvas>
            </div>
        </div>

        {{-- Supply Prediction Chart --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-semibold text-slate-900">
                        3-Month Supply Forecast
                    </h3>
                    <p class="text-xs text-slate-500">
                        Predicted needs based on out-of-stock history
                    </p>
                </div>
                <div class="h-8 w-8 flex items-center justify-center rounded-xl bg-blue-50 text-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                        <path d="M3 12h18m-9-9v18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
            </div>
            
            <div class="h-80">
                <canvas id="forecastChart"></canvas>
            </div>
        </div>
    </section>

    {{-- Chart.js Script --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Most Out of Stock Items Chart - Using real data
            const outOfStockCtx = document.getElementById('outOfStockChart').getContext('2d');
            const outOfStockData = @json($chartsData['out_of_stock_items'] ?? []);
            
            const outOfStockChart = new Chart(outOfStockCtx, {
                type: 'bar',
                data: {
                    labels: outOfStockData.map(item => item.name),
                    datasets: [{
                        label: 'Times Out of Stock',
                        data: outOfStockData.map(item => item.count),
                        backgroundColor: [
                            'rgba(239, 68, 68, 0.8)',
                            'rgba(248, 113, 113, 0.8)',
                            'rgba(252, 165, 165, 0.8)',
                            'rgba(254, 202, 202, 0.8)',
                            'rgba(254, 226, 226, 0.8)'
                        ],
                        borderColor: [
                            'rgba(239, 68, 68, 1)',
                            'rgba(248, 113, 113, 1)',
                            'rgba(252, 165, 165, 1)',
                            'rgba(254, 202, 202, 1)',
                            'rgba(254, 226, 226, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y + ' times out of stock';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: true,
                                drawBorder: false,
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                font: {
                                    size: 11
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 11
                                }
                            }
                        }
                    }
                }
            });

            // 3-Month Supply Forecast Chart - Using real data
            const forecastCtx = document.getElementById('forecastChart').getContext('2d');
            const forecastData = @json($chartsData['supply_forecast'] ?? []);
            
            const forecastChart = new Chart(forecastCtx, {
                type: 'line',
                data: forecastData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: {
                                    size: 11
                                },
                                padding: 15
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.parsed.y + ' units';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: true,
                                drawBorder: false,
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                font: {
                                    size: 11
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 11
                                }
                            }
                        }
                    }
                }
            });

            // Auto-refresh data every 30 seconds
            setInterval(function() {
                fetch('/api/dashboard/charts')
                    .then(response => response.json())
                    .then(data => {
                        // Update out of stock chart
                        if (data.out_of_stock_items) {
                            const newOutOfStockData = data.out_of_stock_items;
                            outOfStockChart.data.labels = newOutOfStockData.map(item => item.name);
                            outOfStockChart.data.datasets[0].data = newOutOfStockData.map(item => item.count);
                            outOfStockChart.update();
                        }
                        
                        // Update forecast chart
                        if (data.supply_forecast) {
                            forecastChart.data = data.supply_forecast;
                            forecastChart.update();
                        }
                    })
                    .catch(error => console.error('Error updating charts:', error));
            }, 30000);
        });
    </script>
@endsection
