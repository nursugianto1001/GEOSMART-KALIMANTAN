{{-- resources/views/admin/analytics.blade.php --}}
<x-layouts.admin>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-900 leading-tight">
            Analitik Kemiskinan
        </h2>
    </x-slot>

    <div class="py-6 bg-gradient-to-b from-green-50 to-white min-h-screen">
        <!-- Filter Controls -->
        <div class="bg-white shadow-lg rounded-lg mb-6 border border-green-100">
            <div class="p-6 bg-gradient-to-r from-green-50 to-green-100 rounded-t-lg">
                <h3 class="text-lg font-semibold text-green-800 mb-4">Filter Analitik</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-green-700 mb-2">Periode</label>
                        <select id="periodFilter" class="w-full border-green-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors">
                            <option value="all">Semua Waktu</option>
                            <option value="month">Bulan Ini</option>
                            <option value="quarter">3 Bulan Terakhir</option>
                            <option value="year">Tahun Ini</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-green-700 mb-2">Desa/Kelurahan</label>
                        <select id="villageFilter" class="w-full border-green-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors">
                            <option value="">Semua Desa</option>
                            @foreach(\App\Models\Village::all() as $village)
                                <option value="{{ $village->id }}">{{ $village->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-green-700 mb-2">Kategori Kemiskinan</label>
                        <select id="categoryFilter" class="w-full border-green-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors">
                            <option value="">Semua Kategori</option>
                            <option value="ekonomi">Ekonomi</option>
                            <option value="kesehatan">Kesehatan</option>
                            <option value="sanitasi">Sanitasi</option>
                            <option value="pendidikan">Pendidikan</option>
                            <option value="infrastruktur">Infrastruktur</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button onclick="updateCharts()" class="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-2 px-4 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                            Update Analitik
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Key Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg p-6 shadow-lg border border-green-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-100 text-sm">Sangat Miskin</p>
                        <p class="text-3xl font-bold" id="sangatMiskinCount">{{ $povertyLevels['Sangat Miskin'] ?? 0 }}</p>
                    </div>
                    <div class="bg-red-400 rounded-full p-3 shadow-md">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-lg p-6 shadow-lg border border-green-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm">Miskin</p>
                        <p class="text-3xl font-bold" id="miskinCount">{{ $povertyLevels['Miskin'] ?? 0 }}</p>
                    </div>
                    <div class="bg-orange-400 rounded-full p-3 shadow-md">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white rounded-lg p-6 shadow-lg border border-green-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-100 text-sm">Rentan Miskin</p>
                        <p class="text-3xl font-bold" id="rentanMiskinCount">{{ $povertyLevels['Rentan Miskin'] ?? 0 }}</p>
                    </div>
                    <div class="bg-yellow-400 rounded-full p-3 shadow-md">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg p-6 shadow-lg border border-green-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm">Tidak Miskin</p>
                        <p class="text-3xl font-bold" id="tidakMiskinCount">{{ $povertyLevels['Tidak Miskin'] ?? 0 }}</p>
                    </div>
                    <div class="bg-green-400 rounded-full p-3 shadow-md">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Economic Status Chart -->
            <div class="bg-white shadow-lg rounded-lg border border-green-100">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-green-900 mb-4 pb-4 border-b border-green-200">Status Ekonomi</h3>
                    <div class="relative" style="height: 300px;">
                        <canvas id="economicChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- House Condition Chart -->
            <div class="bg-white shadow-lg rounded-lg border border-green-100">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-green-900 mb-4 pb-4 border-b border-green-200">Kondisi Rumah</h3>
                    <div class="relative" style="height: 300px;">
                        <canvas id="houseChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Education Access Chart -->
            <div class="bg-white shadow-lg rounded-lg border border-green-100">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-green-900 mb-4 pb-4 border-b border-green-200">Akses Pendidikan</h3>
                    <div class="relative" style="height: 300px;">
                        <canvas id="educationChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Health Access Chart -->
            <div class="bg-white shadow-lg rounded-lg border border-green-100">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-green-900 mb-4 pb-4 border-b border-green-200">Akses Kesehatan</h3>
                    <div class="relative" style="height: 300px;">
                        <canvas id="healthChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Statistics -->
        <div class="bg-white shadow-lg rounded-lg border border-green-100">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-green-900 mb-6 pb-4 border-b border-green-200">Statistik Detail</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-4">
                        <h4 class="font-medium text-green-800">Infrastruktur</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-green-700">Akses PDAM</span>
                                <div class="flex items-center">
                                    <div class="w-20 bg-green-200 rounded-full h-2 mr-2">
                                        <div class="bg-green-600 h-2 rounded-full" style="width: 0%" id="pdamBar"></div>
                                    </div>
                                    <span class="text-sm text-green-700" id="pdamPercent">0%</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-green-700">Akses PLN</span>
                                <div class="flex items-center">
                                    <div class="w-20 bg-green-200 rounded-full h-2 mr-2">
                                        <div class="bg-yellow-600 h-2 rounded-full" style="width: 0%" id="plnBar"></div>
                                    </div>
                                    <span class="text-sm text-green-700" id="plnPercent">0%</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-green-700">Lantai Keramik</span>
                                <div class="flex items-center">
                                    <div class="w-20 bg-green-200 rounded-full h-2 mr-2">
                                        <div class="bg-green-600 h-2 rounded-full" style="width: 0%" id="keramikBar"></div>
                                    </div>
                                    <span class="text-sm text-green-700" id="keramikPercent">0%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h4 class="font-medium text-green-800">Kondisi Sosial</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-green-700">Anak Tidak Sekolah</span>
                                <div class="flex items-center">
                                    <div class="w-20 bg-green-200 rounded-full h-2 mr-2">
                                        <div class="bg-red-600 h-2 rounded-full" style="width: 0%" id="tidakSekolahBar"></div>
                                    </div>
                                    <span class="text-sm text-green-700" id="tidakSekolahPercent">0%</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-green-700">Ada Difabel/Lansia</span>
                                <div class="flex items-center">
                                    <div class="w-20 bg-green-200 rounded-full h-2 mr-2">
                                        <div class="bg-orange-600 h-2 rounded-full" style="width: 0%" id="difabelBar"></div>
                                    </div>
                                    <span class="text-sm text-green-700" id="difabelPercent">0%</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-green-700">Sakit Menahun</span>
                                <div class="flex items-center">
                                    <div class="w-20 bg-green-200 rounded-full h-2 mr-2">
                                        <div class="bg-purple-600 h-2 rounded-full" style="width: 0%" id="sakitBar"></div>
                                    </div>
                                    <span class="text-sm text-green-700" id="sakitPercent">0%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h4 class="font-medium text-green-800">Bantuan Pemerintah</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-green-700">PKH</span>
                                <div class="flex items-center">
                                    <div class="w-20 bg-green-200 rounded-full h-2 mr-2">
                                        <div class="bg-indigo-600 h-2 rounded-full" style="width: 0%" id="pkhBar"></div>
                                    </div>
                                    <span class="text-sm text-green-700" id="pkhPercent">0%</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-green-700">BPNT</span>
                                <div class="flex items-center">
                                    <div class="w-20 bg-green-200 rounded-full h-2 mr-2">
                                        <div class="bg-pink-600 h-2 rounded-full" style="width: 0%" id="bpntBar"></div>
                                    </div>
                                    <span class="text-sm text-green-700" id="bpntPercent">0%</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-green-700">BLT</span>
                                <div class="flex items-center">
                                    <div class="w-20 bg-green-200 rounded-full h-2 mr-2">
                                        <div class="bg-teal-600 h-2 rounded-full" style="width: 0%" id="bltBar"></div>
                                    </div>
                                    <span class="text-sm text-green-700" id="bltPercent">0%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let economicChart, houseChart, educationChart, healthChart;

        // Initialize charts
        document.addEventListener('DOMContentLoaded', function() {
            initializeCharts();
            loadDetailedStats();
        });

        function initializeCharts() {
            // Economic Chart
            const economicCtx = document.getElementById('economicChart').getContext('2d');
            economicChart = new Chart(economicCtx, {
                type: 'pie',
                data: {
                    labels: {!! json_encode($familiesByEconomicStatus->pluck('sumber_penghasilan')->map(function($status) {
                        return ucfirst(str_replace('_', ' ', $status));
                    })) !!},
                    datasets: [{
                        data: {!! json_encode($familiesByEconomicStatus->pluck('total')) !!},
                        backgroundColor: ['#16a34a', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // House Chart
            const houseCtx = document.getElementById('houseChart').getContext('2d');
            houseChart = new Chart(houseCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($familiesByHouseCondition->pluck('jenis_bangunan')->map(function($condition) {
                        return ucfirst(str_replace('_', ' ', $condition));
                    })) !!},
                    datasets: [{
                        data: {!! json_encode($familiesByHouseCondition->pluck('total')) !!},
                        backgroundColor: ['#10B981', '#F59E0B', '#EF4444']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // Education Chart
            const educationCtx = document.getElementById('educationChart').getContext('2d');
            educationChart = new Chart(educationCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($familiesByEducationAccess->pluck('akses_sekolah')->map(function($access) {
                        $labels = [
                            'kurang_1km' => '< 1 km',
                            '1_3km' => '1-3 km',
                            'lebih_3km' => '> 3 km'
                        ];
                        return $labels[$access] ?? $access;
                    })) !!},
                    datasets: [{
                        label: 'Jumlah Keluarga',
                        data: {!! json_encode($familiesByEducationAccess->pluck('total')) !!},
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

            // Health Chart
            const healthCtx = document.getElementById('healthChart').getContext('2d');
            healthChart = new Chart(healthCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($familiesByHealthAccess->pluck('akses_kesehatan')->map(function($access) {
                        return strtoupper($access);
                    })) !!},
                    datasets: [{
                        label: 'Jumlah Keluarga',
                        data: {!! json_encode($familiesByHealthAccess->pluck('total')) !!},
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
        }

        function loadDetailedStats() {
            fetch('/admin/analytics/detailed-stats', {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                updateDetailedStats(data);
            })
            .catch(error => console.error('Error loading detailed stats:', error));
        }

        function updateDetailedStats(data) {
            // Update progress bars and percentages
            updateProgressBar('pdam', data.pdam_percentage);
            updateProgressBar('pln', data.pln_percentage);
            updateProgressBar('keramik', data.keramik_percentage);
            updateProgressBar('tidakSekolah', data.tidak_sekolah_percentage);
            updateProgressBar('difabel', data.difabel_percentage);
            updateProgressBar('sakit', data.sakit_percentage);
            updateProgressBar('pkh', data.pkh_percentage);
            updateProgressBar('bpnt', data.bpnt_percentage);
            updateProgressBar('blt', data.blt_percentage);
        }

        function updateProgressBar(id, percentage) {
            const bar = document.getElementById(id + 'Bar');
            const percent = document.getElementById(id + 'Percent');
            
            if (bar && percent) {
                bar.style.width = percentage + '%';
                percent.textContent = percentage + '%';
            }
        }

        function updateCharts() {
            const filters = {
                period: document.getElementById('periodFilter').value,
                village: document.getElementById('villageFilter').value,
                category: document.getElementById('categoryFilter').value
            };

            fetch('/admin/analytics/filtered-data', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                credentials: 'same-origin',
                body: JSON.stringify(filters)
            })
            .then(response => response.json())
            .then(data => {
                // Update charts with filtered data
                updateChartData(economicChart, data.economic);
                updateChartData(houseChart, data.house);
                updateChartData(educationChart, data.education);
                updateChartData(healthChart, data.health);
                updateDetailedStats(data.detailed_stats);
            })
            .catch(error => console.error('Error updating charts:', error));
        }

        function updateChartData(chart, data) {
            chart.data.labels = data.labels;
            chart.data.datasets[0].data = data.data;
            chart.update();
        }
    </script>
    @endpush
</x-layouts.admin>
