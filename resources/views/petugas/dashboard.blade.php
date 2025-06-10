{{-- resources/views/petugas/dashboard.blade.php --}}
<x-layouts.petugas>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-green-900 leading-tight">
                Dashboard Petugas Lapangan
            </h2>
            <div class="mt-4 sm:mt-0">
                <span class="text-sm text-gray-600">Selamat datang, {{ auth()->user()->name }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12 bg-gradient-to-b from-green-100 via-green-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 sm:gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-green-100">
                    <div class="p-4 sm:p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-gradient-to-r from-green-600 to-green-700 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3 w-0 flex-1">
                                <dl>
                                    <dt class="text-xs sm:text-sm font-medium text-gray-600 truncate">Total</dt>
                                    <dd class="text-lg sm:text-xl font-medium text-green-800">{{ number_format($stats['total_surveys']) }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-green-100">
                    <div class="p-4 sm:p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-gray-600 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm0 2h12v8H4V6z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3 w-0 flex-1">
                                <dl>
                                    <dt class="text-xs sm:text-sm font-medium text-gray-600 truncate">Draft</dt>
                                    <dd class="text-lg sm:text-xl font-medium text-gray-700">{{ number_format($stats['draft_surveys']) }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-green-100">
                    <div class="p-4 sm:p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3 w-0 flex-1">
                                <dl>
                                    <dt class="text-xs sm:text-sm font-medium text-gray-600 truncate">Pending</dt>
                                    <dd class="text-lg sm:text-xl font-medium text-gray-700">{{ number_format($stats['submitted_surveys']) }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-green-100">
                    <div class="p-4 sm:p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-green-600 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3 w-0 flex-1">
                                <dl>
                                    <dt class="text-xs sm:text-sm font-medium text-gray-600 truncate">Verified</dt>
                                    <dd class="text-lg sm:text-xl font-medium text-green-800">{{ number_format($stats['verified_surveys']) }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-green-100">
                    <div class="p-4 sm:p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3 w-0 flex-1">
                                <dl>
                                    <dt class="text-xs sm:text-sm font-medium text-gray-600 truncate">Rejected</dt>
                                    <dd class="text-lg sm:text-xl font-medium text-gray-700">{{ number_format($stats['rejected_surveys']) }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mb-8">
                <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-green-100">
                    <div class="p-6 bg-gradient-to-r from-green-50 to-green-100">
                        <h3 class="text-lg font-medium text-green-800 mb-4">Aksi Cepat</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <a href="{{ route('petugas.surveys.create') }}" 
                               class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-3 px-4 rounded-lg text-center transition duration-150 ease-in-out shadow-md hover:shadow-lg">
                                <svg class="w-6 h-6 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                                </svg>
                                Tambah Survei Baru
                            </a>
                            
                            <a href="{{ route('petugas.surveys.index') }}?status=draft" 
                               class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-4 rounded-lg text-center transition duration-150 ease-in-out shadow-md hover:shadow-lg">
                                <svg class="w-6 h-6 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm0 2h12v8H4V6z"></path>
                                </svg>
                                Lanjutkan Draft
                            </a>
                            
                            <a href="{{ route('petugas.surveys.index') }}" 
                               class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-3 px-4 rounded-lg text-center transition duration-150 ease-in-out shadow-md hover:shadow-lg">
                                <svg class="w-6 h-6 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Lihat Semua Survei
                            </a>
                            
                            <a href="{{ route('petugas.map') }}" 
                               class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg text-center transition duration-150 ease-in-out shadow-md hover:shadow-lg">
                                <svg class="w-6 h-6 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12 1.586l-4 4v12.828l4-4V1.586zM3.707 3.293A1 1 0 002 4v10a1 1 0 00.293.707L6 18.414V5.586L3.707 3.293zM17.707 5.293L14 1.586v12.828l2.293 2.293A1 1 0 0018 16V6a1 1 0 00-.293-.707z" clip-rule="evenodd"></path>
                                </svg>
                                Lihat Peta
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Surveys -->
                <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-green-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-green-800">Survei Terbaru</h3>
                            <a href="{{ route('petugas.surveys.index') }}" class="text-green-600 hover:text-green-700 text-sm font-medium">Lihat Semua</a>
                        </div>
                        <div class="space-y-3">
                            @forelse($recentSurveys as $survey)
                                <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors border border-green-200">
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-green-900 truncate">{{ $survey->nama_kepala_keluarga }}</p>
                                        <p class="text-sm text-gray-600 truncate">{{ $survey->neighborhood->village->name }}</p>
                                        <p class="text-xs text-gray-600">{{ $survey->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="flex items-center space-x-2 ml-4">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $survey->status_badge }}">
                                            {{ $survey->status_text }}
                                        </span>
                                        <a href="{{ route('petugas.surveys.show', $survey) }}" class="text-green-600 hover:text-green-700">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    <p class="text-gray-600 mt-2">Belum ada data survei</p>
                                    <a href="{{ route('petugas.surveys.create') }}" class="mt-2 text-green-600 hover:text-green-700 font-medium">Buat survei pertama</a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Monthly Progress Chart -->
                <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-green-100">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-green-800 mb-4">Progress Bulanan</h3>
                        <div class="relative" style="height: 300px;">
                            <canvas id="monthlyChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Work Area Statistics -->
            @if(count($wilayahStats) > 0)
            <div class="mt-8 bg-white overflow-hidden shadow-lg rounded-lg border border-green-100">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-green-800 mb-4">Statistik Wilayah Kerja</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($wilayahStats as $stat)
                            <div class="p-4 bg-gradient-to-r from-green-50 to-green-100 rounded-lg border border-green-200">
                                <h4 class="font-medium text-green-900">{{ $stat['village'] }}</h4>
                                <p class="text-2xl font-bold text-green-600">{{ $stat['count'] }}</p>
                                <p class="text-sm text-gray-600">survei</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        // Monthly Progress Chart
        const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
        new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($monthlyProgress->pluck('month')->map(function($month) {
                    return date('M', mktime(0, 0, 0, $month, 1));
                })) !!},
                datasets: [{
                    label: 'Survei per Bulan',
                    data: {!! json_encode($monthlyProgress->pluck('total')) !!},
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
    </script>
    @endpush
</x-layouts.petugas>
