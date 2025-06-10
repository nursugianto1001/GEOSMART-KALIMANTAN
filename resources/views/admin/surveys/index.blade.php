{{-- resources/views/admin/surveys/index.blade.php --}}
<x-layouts.admin>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-900 leading-tight">
            Verifikasi Survei Kemiskinan
        </h2>
    </x-slot>

    <div class="py-6 bg-gradient-to-b from-green-50 to-white min-h-screen">
        <!-- Filter Section -->
        <div class="bg-white shadow-lg rounded-lg mb-6 border border-green-100">
            <div class="p-6 bg-gradient-to-r from-green-50 to-green-100 rounded-t-lg">
                <h3 class="text-lg font-semibold text-green-800 mb-4">Filter & Pencarian</h3>
                <form method="GET" action="{{ route('admin.surveys.index') }}" id="filterForm">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Status</label>
                            <select name="status" class="w-full border-green-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors">
                                <option value="">Semua Status</option>
                                <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Surveyor</label>
                            <select name="surveyor" class="w-full border-green-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors">
                                <option value="">Semua Surveyor</option>
                                @foreach(\App\Models\User::petugasLapangan()->get() as $petugas)
                                <option value="{{ $petugas->id }}" {{ request('surveyor') == $petugas->id ? 'selected' : '' }}>
                                    {{ $petugas->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Tanggal Mulai</label>
                            <input type="date" name="start_date" value="{{ request('start_date') }}"
                                class="w-full border-green-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Tanggal Akhir</label>
                            <input type="date" name="end_date" value="{{ request('end_date') }}"
                                class="w-full border-green-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors">
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end space-x-2">
                        <a href="{{ route('admin.surveys.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                            Reset
                        </a>
                        <button type="submit" class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-2 px-4 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                            Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary Cards - Disesuaikan dengan ukuran report -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-lg p-6 border border-green-100">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-gradient-to-r from-green-600 to-green-700 rounded-lg flex items-center justify-center shadow-md">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-green-600 truncate">Total Survei</dt>
                            <dd class="text-lg font-medium text-green-900">{{ number_format($surveys->total()) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6 border border-green-100">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-500 rounded-lg flex items-center justify-center shadow-md">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-green-600 truncate">Pending</dt>
                            <dd class="text-lg font-medium text-green-900">{{ number_format($surveys->where('status_verifikasi', 'submitted')->count()) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6 border border-green-100">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-green-600 rounded-lg flex items-center justify-center shadow-md">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-green-600 truncate">Verified</dt>
                            <dd class="text-lg font-medium text-green-900">{{ number_format($surveys->where('status_verifikasi', 'verified')->count()) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6 border border-green-100">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-500 rounded-lg flex items-center justify-center shadow-md">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-green-600 truncate">Rejected</dt>
                            <dd class="text-lg font-medium text-green-900">{{ number_format($surveys->where('status_verifikasi', 'rejected')->count()) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Surveys Table -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden border border-green-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-green-200">
                    <thead class="bg-gradient-to-r from-green-50 to-green-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">
                                Kepala Keluarga
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">
                                Lokasi
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">
                                Surveyor
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">
                                Kategori Kemiskinan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-green-700 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-green-100">
                        @forelse($surveys as $survey)
                        <tr class="hover:bg-green-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-medium text-green-900">
                                        {{ $survey->nama_kepala_keluarga }}
                                    </div>
                                    <div class="text-sm text-green-600">
                                        {{ $survey->jumlah_anggota_keluarga }} anggota
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-green-900">{{ Str::limit($survey->alamat_lengkap, 40) }}</div>
                                <div class="text-sm text-green-600">{{ $survey->neighborhood->village->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-900">
                                {{ $survey->surveyor->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        @if($survey->poverty_score >= 20) bg-red-100 text-red-800
                                        @elseif($survey->poverty_score >= 15) bg-orange-100 text-orange-800
                                        @elseif($survey->poverty_score >= 10) bg-yellow-100 text-yellow-800
                                        @else bg-green-100 text-green-800 @endif">
                                    {{ $survey->poverty_level }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $survey->status_badge }}">
                                    {{ $survey->status_text }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">
                                {{ $survey->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('admin.surveys.show', $survey) }}"
                                        class="text-green-600 hover:text-green-800 bg-green-100 hover:bg-green-200 px-3 py-1 rounded-md transition-all duration-200 shadow-sm hover:shadow-md">
                                        Detail
                                    </a>
                                    @if($survey->status_verifikasi === 'submitted')
                                    <form action="{{ route('admin.surveys.verify', $survey) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="text-green-600 hover:text-green-800 bg-green-100 hover:bg-green-200 px-3 py-1 rounded-md transition-all duration-200 shadow-sm hover:shadow-md"
                                            onclick="return confirm('Verifikasi survei ini?')">
                                            Verifikasi
                                        </button>
                                    </form>
                                    <button onclick="showRejectModal({{ $survey->id }})"
                                        class="text-red-600 hover:text-red-800 bg-red-100 hover:bg-red-200 px-3 py-1 rounded-md transition-all duration-200 shadow-sm hover:shadow-md">
                                        Tolak
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-green-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    <p class="text-green-600 text-lg">Tidak ada survei yang menunggu verifikasi</p>
                                    <p class="text-green-500 text-sm">Semua survei sudah diverifikasi</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($surveys->hasPages())
            <div class="bg-gradient-to-r from-green-50 to-green-100 px-6 py-4 border-t border-green-200">
                <div class="flex flex-col sm:flex-row justify-between items-center">
                    <!-- Pagination Info -->
                    <div class="text-sm text-green-700 mb-4 sm:mb-0">
                        <span class="font-medium">Menampilkan</span>
                        <span class="font-semibold text-green-900">{{ $surveys->firstItem() }}</span>
                        <span>sampai</span>
                        <span class="font-semibold text-green-900">{{ $surveys->lastItem() }}</span>
                        <span>dari</span>
                        <span class="font-semibold text-green-900">{{ $surveys->total() }}</span>
                        <span>hasil</span>
                    </div>
                    
                    <!-- Custom Pagination Links -->
                    <div class="flex items-center space-x-2">
                        {{-- Previous Page Link --}}
                        @if ($surveys->onFirstPage())
                        <span class="px-4 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-200 rounded-lg cursor-not-allowed">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Previous
                        </span>
                        @else
                        <a href="{{ $surveys->appends(request()->query())->previousPageUrl() }}"
                            class="px-4 py-2 text-sm font-medium text-green-700 bg-white border border-green-300 rounded-lg hover:bg-green-50 hover:text-green-800 transition-all duration-200 shadow-sm hover:shadow-md">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Previous
                        </a>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($surveys->appends(request()->query())->getUrlRange(1, $surveys->lastPage()) as $page => $url)
                        @if ($page == $surveys->currentPage())
                        <span class="px-4 py-2 text-sm font-bold text-white bg-gradient-to-r from-green-600 to-green-700 border border-green-600 rounded-lg shadow-md">
                            {{ $page }}
                        </span>
                        @else
                        <a href="{{ $url }}"
                            class="px-4 py-2 text-sm font-medium text-green-700 bg-white border border-green-300 rounded-lg hover:bg-green-50 hover:text-green-800 transition-all duration-200 shadow-sm hover:shadow-md">
                            {{ $page }}
                        </a>
                        @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($surveys->hasMorePages())
                        <a href="{{ $surveys->appends(request()->query())->nextPageUrl() }}"
                            class="px-4 py-2 text-sm font-medium text-green-700 bg-white border border-green-300 rounded-lg hover:bg-green-50 hover:text-green-800 transition-all duration-200 shadow-sm hover:shadow-md">
                            Next
                            <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                        @else
                        <span class="px-4 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-200 rounded-lg cursor-not-allowed">
                            Next
                            <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50 backdrop-blur-sm">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-2xl rounded-lg bg-white border-green-100">
            <div class="mt-3">
                <div class="flex items-center mb-4">
                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-green-900">Tolak Survei</h3>
                </div>
                <form id="rejectForm" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="rejection_reason" class="block text-sm font-medium text-green-700 mb-2">Alasan Penolakan</label>
                        <textarea id="rejection_reason" name="rejection_reason" rows="4" required
                            class="w-full border-green-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500 transition-colors"
                            placeholder="Jelaskan alasan penolakan survei ini..."></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="hideRejectModal()"
                            class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                            Batal
                        </button>
                        <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                            Tolak Survei
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function showRejectModal(surveyId) {
            document.getElementById('rejectModal').classList.remove('hidden');
            document.getElementById('rejectForm').action = `/admin/surveys/${surveyId}/reject`;
        }

        function hideRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
            document.getElementById('rejectForm').reset();
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('rejectModal');
            if (event.target === modal) {
                hideRejectModal();
            }
        });
    </script>
    @endpush
</x-layouts.admin>
