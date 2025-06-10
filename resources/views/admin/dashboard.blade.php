{{-- resources/views/admin/dashboard.blade.php --}}
<x-layouts.admin>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-900 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-green-100">
            <div class="p-6 bg-gradient-to-r from-green-50 to-green-100">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-gradient-to-r from-green-600 to-green-700 rounded-lg flex items-center justify-center shadow-md">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-green-700 truncate">Total Keluarga Miskin</dt>
                            <dd class="text-2xl font-bold text-green-900">{{ number_format($stats['total_families']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-green-100">
            <div class="p-6 bg-gradient-to-r from-green-50 to-green-100">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-lg flex items-center justify-center shadow-md">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-green-700 truncate">Terverifikasi</dt>
                            <dd class="text-2xl font-bold text-green-900">{{ number_format($stats['verified_families']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-green-100">
            <div class="p-6 bg-gradient-to-r from-green-50 to-green-100">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-yellow-500 rounded-lg flex items-center justify-center shadow-md">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-green-700 truncate">Menunggu Verifikasi</dt>
                            <dd class="text-2xl font-bold text-green-900">{{ number_format($stats['pending_families']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-green-100">
            <div class="p-6 bg-gradient-to-r from-green-50 to-green-100">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-gradient-to-r from-green-700 to-green-800 rounded-lg flex items-center justify-center shadow-md">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-green-700 truncate">Petugas Aktif</dt>
                            <dd class="text-2xl font-bold text-green-900">{{ number_format($stats['total_petugas']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Recent Surveys -->
        <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-green-100">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4 pb-4 border-b border-green-200">
                    <h3 class="text-lg font-semibold text-green-900">Survei Terbaru</h3>
                    <a href="{{ route('admin.surveys.index') }}" class="text-green-600 hover:text-green-800 text-sm font-medium transition-colors">Lihat Semua</a>
                </div>
                <div class="space-y-4">
                    @forelse($recentSurveys as $survey)
                        <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors border border-green-200">
                            <div class="flex-1">
                                <h4 class="font-medium text-green-900">{{ $survey->nama_kepala_keluarga }}</h4>
                                <p class="text-sm text-green-700">{{ $survey->neighborhood->village->name }}</p>
                                <p class="text-xs text-green-600">{{ $survey->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $survey->status_badge }}">
                                    {{ $survey->status_text }}
                                </span>
                                @if($survey->status_verifikasi === 'submitted')
                                    <a href="{{ route('admin.surveys.index') }}" class="text-green-600 hover:text-green-800 transition-colors">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <p class="text-green-600 mt-2">Belum ada data survei</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Survey Status Chart -->
        <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-green-100">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-green-900 mb-4 pb-4 border-b border-green-200">Status Survei</h3>
                <div class="relative" style="height: 300px;">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Survey by Village Chart -->
    <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-green-100">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-green-900 mb-4 pb-4 border-b border-green-200">Survei per Desa/Kelurahan</h3>
            <div class="relative" style="height: 400px;">
                <canvas id="villageChart"></canvas>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Status Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        const statusChart = new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($surveysByStatus->pluck('status_verifikasi')->map(function($status) {
                    $texts = [
                        'draft' => 'Draft',
                        'submitted' => 'Menunggu Verifikasi',
                        'verified' => 'Terverifikasi',
                        'rejected' => 'Ditolak'
                    ];
                    return $texts[$status] ?? $status;
                })) !!},
                datasets: [{
                    data: {!! json_encode($surveysByStatus->pluck('total')) !!},
                    backgroundColor: [
                        '#6B7280', // draft - gray
                        '#F59E0B', // submitted - yellow
                        '#16a34a', // verified - green-600
                        '#EF4444'  // rejected - red
                    ],
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
        const villageChart = new Chart(villageCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($surveysByVillage->keys()) !!},
                datasets: [{
                    label: 'Jumlah Survei',
                    data: {!! json_encode($surveysByVillage->values()) !!},
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
</x-layouts.admin>
