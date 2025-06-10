{{-- resources/views/petugas/statistics.blade.php --}}
<x-layouts.petugas>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-900 leading-tight">
            Statistik Survei Saya
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12 bg-gradient-to-b from-green-100 via-green-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-green-100">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-gradient-to-r from-green-600 to-green-700 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-600 truncate">Total Survei</dt>
                                    <dd class="text-lg font-medium text-green-800">{{ $stats['monthly_surveys']->sum('total') }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-green-100">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-600 truncate">Sangat Miskin</dt>
                                    <dd class="text-lg font-medium text-gray-700">{{ $stats['poverty_distribution']['Sangat Miskin'] ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-green-100">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-orange-500 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-600 truncate">Miskin</dt>
                                    <dd class="text-lg font-medium text-gray-700">{{ $stats['poverty_distribution']['Miskin'] ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-green-100">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-600 truncate">Rentan Miskin</dt>
                                    <dd class="text-lg font-medium text-gray-700">{{ $stats['poverty_distribution']['Rentan Miskin'] ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Monthly Progress Chart -->
            <div class="bg-white shadow-lg rounded-lg mb-8 border border-green-100">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-green-800 mb-4">Progress Survei Bulanan</h3>
                    <div class="relative" style="height: 400px;">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Poverty Distribution -->
                <div class="bg-white shadow-lg rounded-lg border border-green-100">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-green-800 mb-4">Distribusi Tingkat Kemiskinan</h3>
                        <div class="relative" style="height: 300px;">
                            <canvas id="povertyChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Village Distribution -->
                <div class="bg-white shadow-lg rounded-lg border border-green-100">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-green-800 mb-4">Distribusi per Desa</h3>
                        <div class="relative" style="height: 300px;">
                            <canvas id="villageChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Table -->
            <div class="mt-8 bg-white shadow-lg rounded-lg border border-green-100">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-green-800 mb-4">Detail Statistik per Bulan</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-green-200">
                            <thead class="bg-gradient-to-r from-green-50 to-green-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Bulan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Tahun</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Jumlah Survei</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Rata-rata per Hari</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-green-100">
                                @forelse($stats['monthly_surveys'] as $monthly)
                                    <tr class="hover:bg-green-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-900">
                                            {{ date('F', mktime(0, 0, 0, $monthly->month, 1)) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $monthly->year }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $monthly->total }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ round($monthly->total / date('t', mktime(0, 0, 0, $monthly->month, 1, $monthly->year)), 1) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-600">Belum ada data survei</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Monthly Chart
        const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
        new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($stats['monthly_surveys']->pluck('month')->map(function($month) {
                    return date('M', mktime(0, 0, 0, $month, 1));
                })) !!},
                datasets: [{
                    label: 'Survei per Bulan',
                    data: {!! json_encode($stats['monthly_surveys']->pluck('total')) !!},
                    borderColor: '#16a34a',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#dcfce7'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Poverty Chart
        const povertyCtx = document.getElementById('povertyChart').getContext('2d');
        new Chart(povertyCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($stats['poverty_distribution']->keys()) !!},
                datasets: [{
                    data: {!! json_encode($stats['poverty_distribution']->values()) !!},
                    backgroundColor: ['#EF4444', '#F97316', '#EAB308', '#22C55E'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                }
            }
        });

        // Village Chart
        const villageCtx = document.getElementById('villageChart').getContext('2d');
        new Chart(villageCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($stats['village_distribution']->keys()) !!},
                datasets: [{
                    label: 'Jumlah Survei',
                    data: {!! json_encode($stats['village_distribution']->values()) !!},
                    backgroundColor: '#16a34a',
                    borderColor: '#15803d',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#dcfce7'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
    @endpush
</x-layouts.petugas>
