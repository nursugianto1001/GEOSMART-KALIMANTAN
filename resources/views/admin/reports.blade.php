{{-- resources/views/admin/reports.blade.php --}}
<x-layouts.admin>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-green-900 leading-tight">
                Laporan Kemiskinan
            </h2>
            <div class="flex space-x-2">
                <!-- Export PDF Form -->
                <form method="POST" action="{{ route('admin.reports.export') }}" class="inline" id="exportPdfForm">
                    @csrf
                    <input type="hidden" name="format" value="pdf">
                    <input type="hidden" name="village_id" value="{{ request('village_id') }}">
                    <input type="hidden" name="status" value="{{ request('status') }}">
                    <input type="hidden" name="date_from" value="{{ request('date_from') }}">
                    <input type="hidden" name="date_to" value="{{ request('date_to') }}">

                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition-all duration-200 flex items-center shadow-md hover:shadow-lg">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        Export PDF
                    </button>
                </form>

                <!-- Export Excel Form -->
                <form method="POST" action="{{ route('admin.reports.export') }}" class="inline" id="exportExcelForm">
                    @csrf
                    <input type="hidden" name="format" value="excel">
                    <input type="hidden" name="village_id" value="{{ request('village_id') }}">
                    <input type="hidden" name="status" value="{{ request('status') }}">
                    <input type="hidden" name="date_from" value="{{ request('date_from') }}">
                    <input type="hidden" name="date_to" value="{{ request('date_to') }}">

                    <button type="submit" class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-2 px-4 rounded-lg transition-all duration-200 flex items-center shadow-md hover:shadow-lg">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Export Excel
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-6 bg-gradient-to-b from-green-50 to-white min-h-screen">
        <!-- Filter Section -->
        <div class="bg-white shadow-lg rounded-lg mb-6 border border-green-100">
            <div class="p-6 bg-gradient-to-r from-green-50 to-green-100 rounded-t-lg">
                <h3 class="text-lg font-semibold text-green-800 mb-4">Filter Laporan</h3>
                <form method="GET" action="{{ route('admin.reports') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-green-700 mb-2">Desa/Kelurahan</label>
                        <select name="village_id" class="w-full border-green-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors">
                            <option value="">Semua Desa</option>
                            @foreach($villages as $village)
                            <option value="{{ $village->id }}" {{ request('village_id') == $village->id ? 'selected' : '' }}>
                                {{ $village->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-green-700 mb-2">Status Verifikasi</label>
                        <select name="status" class="w-full border-green-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors">
                            <option value="">Semua Status</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                            <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-green-700 mb-2">Tanggal Mulai</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full border-green-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-green-700 mb-2">Tanggal Akhir</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full border-green-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-2 px-4 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                            Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary Cards -->
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
                            <dt class="text-sm font-medium text-green-600 truncate">Total Keluarga</dt>
                            <dd class="text-lg font-medium text-green-900">{{ number_format($families->total()) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6 border border-green-100">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-500 rounded-lg flex items-center justify-center shadow-md">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-green-600 truncate">Sangat Miskin</dt>
                            <dd class="text-lg font-medium text-green-900">{{ number_format($families->where('poverty_level', 'Sangat Miskin')->count()) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6 border border-green-100">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center shadow-md">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-green-600 truncate">Miskin</dt>
                            <dd class="text-lg font-medium text-green-900">{{ number_format($families->where('poverty_level', 'Miskin')->count()) }}</dd>
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
                            <dt class="text-sm font-medium text-green-600 truncate">Rentan Miskin</dt>
                            <dd class="text-lg font-medium text-green-900">{{ number_format($families->where('poverty_level', 'Rentan Miskin')->count()) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden border border-green-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-green-200">
                    <thead class="bg-gradient-to-r from-green-50 to-green-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">
                                No
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">
                                Kepala Keluarga
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">
                                Alamat
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
                        @forelse($families as $index => $family)
                        <tr class="hover:bg-green-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-900">
                                {{ $families->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-medium text-green-900">{{ $family->nama_kepala_keluarga }}</div>
                                    <div class="text-sm text-green-600">{{ $family->jumlah_anggota_keluarga }} anggota</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-green-900">{{ $family->alamat_lengkap }}</div>
                                <div class="text-sm text-green-600">{{ $family->neighborhood->village->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-900">
                                {{ $family->surveyor->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        @if($family->poverty_score >= 20) bg-red-100 text-red-800
                                        @elseif($family->poverty_score >= 15) bg-orange-100 text-orange-800
                                        @elseif($family->poverty_score >= 10) bg-yellow-100 text-yellow-800
                                        @else bg-green-100 text-green-800 @endif">
                                    {{ $family->poverty_level }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $family->status_badge }}">
                                    {{ $family->status_text }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">
                                {{ $family->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.surveys.show', $family) }}" class="text-green-600 hover:text-green-800 bg-green-100 hover:bg-green-200 px-3 py-1 rounded-md transition-all duration-200 shadow-sm hover:shadow-md">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-green-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p class="text-green-600 text-lg">Tidak ada data yang sesuai dengan filter</p>
                                    <p class="text-green-500 text-sm">Coba ubah kriteria pencarian</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($families->hasPages())
            <div class="bg-gradient-to-r from-green-50 to-green-100 px-6 py-4 border-t border-green-200">
                <div class="flex flex-col sm:flex-row justify-between items-center">
                    <!-- Pagination Info -->
                    <div class="text-sm text-green-700 mb-4 sm:mb-0">
                        <span class="font-medium">Menampilkan</span>
                        <span class="font-semibold text-green-900">{{ $families->firstItem() }}</span>
                        <span>sampai</span>
                        <span class="font-semibold text-green-900">{{ $families->lastItem() }}</span>
                        <span>dari</span>
                        <span class="font-semibold text-green-900">{{ $families->total() }}</span>
                        <span>hasil</span>
                    </div>

                    <!-- Custom Pagination Links -->
                    <div class="flex items-center space-x-2">
                        {{-- Previous Page Link --}}
                        @if ($families->onFirstPage())
                        <span class="px-4 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-200 rounded-lg cursor-not-allowed">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Previous
                        </span>
                        @else
                        <a href="{{ $families->appends(request()->query())->previousPageUrl() }}"
                            class="px-4 py-2 text-sm font-medium text-green-700 bg-white border border-green-300 rounded-lg hover:bg-green-50 hover:text-green-800 transition-all duration-200 shadow-sm hover:shadow-md">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Previous
                        </a>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($families->appends(request()->query())->getUrlRange(1, $families->lastPage()) as $page => $url)
                        @if ($page == $families->currentPage())
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
                        @if ($families->hasMorePages())
                        <a href="{{ $families->appends(request()->query())->nextPageUrl() }}"
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

    @push('scripts')
    <script>
        function exportPDF() {
            submitExportForm('pdf');
        }

        function exportExcel() {
            submitExportForm('excel');
        }

        function submitExportForm(format) {
            // Create form data
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('format', format);
            formData.append('village_id', '{{ request("village_id") }}');
            formData.append('status', '{{ request("status") }}');
            formData.append('date_from', '{{ request("date_from") }}');
            formData.append('date_to', '{{ request("date_to") }}');

            // Submit form
            fetch('{{ route("admin.reports.export") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.blob())
                .then(blob => {
                    // Create download link
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.style.display = 'none';
                    a.href = url;
                    a.download = `laporan_kemiskinan.${format === 'pdf' ? 'pdf' : 'xlsx'}`;
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    document.body.removeChild(a);
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengexport data');
                });
        }
    </script>
    @endpush
</x-layouts.admin>