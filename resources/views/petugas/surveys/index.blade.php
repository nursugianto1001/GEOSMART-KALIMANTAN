{{-- resources/views/petugas/surveys/index.blade.php --}}
<x-layouts.petugas>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-green-900 leading-tight">
                Data Survei Kemiskinan
            </h2>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('petugas.surveys.create') }}" 
                   class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-2 px-4 rounded-lg transition-all duration-200 inline-flex items-center shadow-md hover:shadow-lg">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                    </svg>
                    Tambah Survei
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12 bg-gradient-to-b from-green-100 via-green-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Section -->
            <div class="bg-white shadow-lg rounded-lg mb-6 border border-green-100">
                <div class="p-4 sm:p-6 bg-gradient-to-r from-green-50 to-green-100 rounded-t-lg">
                    <h3 class="text-lg font-semibold text-green-800 mb-4">Filter & Pencarian</h3>
                    <form method="GET" action="{{ route('petugas.surveys.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Status</label>
                            <select name="status" class="w-full border-green-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors">
                                <option value="">Semua Status</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        
                        @if($villages->count() > 1)
                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Desa</label>
                            <select name="village_id" class="w-full border-green-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors">
                                <option value="">Semua Desa</option>
                                @foreach($villages as $village)
                                    <option value="{{ $village->id }}" {{ request('village_id') == $village->id ? 'selected' : '' }}>
                                        {{ $village->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        
                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Tanggal Mulai</label>
                            <input type="date" name="date_from" value="{{ request('date_from') }}" 
                                   class="w-full border-green-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Tanggal Akhir</label>
                            <input type="date" name="date_to" value="{{ request('date_to') }}" 
                                   class="w-full border-green-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors">
                        </div>
                        
                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                                <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"></path>
                                </svg>
                                Filter
                            </button>
                        </div>
                    </form>
                    
                    <!-- Search -->
                    <div class="mt-4">
                        <form method="GET" action="{{ route('petugas.surveys.index') }}">
                            @foreach(request()->except(['search', 'page']) as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                            <div class="flex">
                                <input type="text" name="search" value="{{ request('search') }}" 
                                       placeholder="Cari nama kepala keluarga, NIK, atau alamat..." 
                                       class="flex-1 border-green-300 rounded-l-md shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors">
                                <button type="submit" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-4 py-2 rounded-r-md transition-all duration-200 shadow-md">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Statistics Summary -->
            <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
                <div class="bg-white p-4 rounded-lg shadow-lg border border-green-100">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-r from-green-600 to-green-700 rounded-md flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-green-800">{{ $surveys->total() }}</div>
                            <div class="text-sm text-gray-600">Total Survei</div>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-lg border border-green-100">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gray-600 rounded-md flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm0 2h12v8H4V6z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-gray-700">{{ $surveys->where('status_verifikasi', 'draft')->count() }}</div>
                            <div class="text-sm text-gray-600">Draft</div>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-lg border border-green-100">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-gray-700">{{ $surveys->where('status_verifikasi', 'submitted')->count() }}</div>
                            <div class="text-sm text-gray-600">Pending</div>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-lg border border-green-100">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-green-600 rounded-md flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-green-800">{{ $surveys->where('status_verifikasi', 'verified')->count() }}</div>
                            <div class="text-sm text-gray-600">Verified</div>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-lg border border-green-100">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-gray-700">{{ $surveys->where('status_verifikasi', 'rejected')->count() }}</div>
                            <div class="text-sm text-gray-600">Rejected</div>
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
                                <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'nama_kepala_keluarga', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="hover:text-green-800 transition-colors">
                                        Kepala Keluarga
                                        @if(request('sort') === 'nama_kepala_keluarga')
                                            <span class="ml-1 text-green-600">{{ request('direction') === 'asc' ? '↑' : '↓' }}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider hidden sm:table-cell">
                                    Alamat
                                </th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider hidden md:table-cell">
                                    Anggota
                                </th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider hidden lg:table-cell">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="hover:text-green-800 transition-colors">
                                        Tanggal
                                        @if(request('sort') === 'created_at')
                                            <span class="ml-1 text-green-600">{{ request('direction') === 'asc' ? '↑' : '↓' }}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-4 sm:px-6 py-3 text-right text-xs font-medium text-green-700 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-green-100">
                            @forelse($surveys as $survey)
                                <tr class="hover:bg-green-50 transition-colors">
                                    <td class="px-4 sm:px-6 py-4">
                                        <div>
                                            <div class="text-sm font-medium text-green-900">
                                                {{ $survey->nama_kepala_keluarga }}
                                            </div>
                                            <div class="text-sm text-gray-600 sm:hidden">
                                                {{ Str::limit($survey->alamat_lengkap, 30) }}
                                            </div>
                                            <div class="text-sm text-gray-600">
                                                {{ $survey->jenis_kelamin_kk === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                            </div>
                                            @if($survey->poverty_score)
                                                <div class="mt-1">
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                                        @if($survey->poverty_score >= 20) bg-red-100 text-red-800
                                                        @elseif($survey->poverty_score >= 15) bg-orange-100 text-orange-800
                                                        @elseif($survey->poverty_score >= 10) bg-yellow-100 text-yellow-800
                                                        @else bg-green-100 text-green-800 @endif">
                                                        {{ $survey->poverty_level }} ({{ $survey->poverty_score }}/25)
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 hidden sm:table-cell">
                                        <div class="text-sm text-gray-900">{{ Str::limit($survey->alamat_lengkap, 40) }}</div>
                                        <div class="text-sm text-gray-600">{{ $survey->neighborhood->village->name }}</div>
                                        <div class="text-sm text-gray-600">{{ $survey->neighborhood->full_address }}</div>
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-700 hidden md:table-cell">
                                        {{ $survey->jumlah_anggota_keluarga }} orang
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $survey->status_badge }}">
                                            {{ $survey->status_text }}
                                        </span>
                                        @if($survey->status_verifikasi === 'rejected' && $survey->rejection_reason)
                                            <div class="mt-1">
                                                <button onclick="showRejectionReason('{{ addslashes($survey->rejection_reason) }}')" 
                                                        class="text-xs text-red-600 hover:text-red-800 underline transition-colors">
                                                    Lihat alasan
                                                </button>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-600 hidden lg:table-cell">
                                        {{ $survey->created_at->format('d/m/Y') }}
                                        <div class="text-xs text-gray-500">{{ $survey->created_at->format('H:i') }}</div>
                                        @if($survey->updated_at != $survey->created_at)
                                            <div class="text-xs text-green-600">Diupdate: {{ $survey->updated_at->format('d/m/Y H:i') }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-1 sm:space-x-2">
                                            <a href="{{ route('petugas.surveys.show', $survey) }}" 
                                               class="text-green-600 hover:text-green-800 bg-green-100 hover:bg-green-200 px-2 py-1 rounded text-xs transition-all duration-200 shadow-sm hover:shadow-md">
                                                Detail
                                            </a>
                                            
                                            @can('update', $survey)
                                                <a href="{{ route('petugas.surveys.edit', $survey) }}" 
                                                   class="text-yellow-600 hover:text-yellow-800 bg-yellow-100 hover:bg-yellow-200 px-2 py-1 rounded text-xs transition-all duration-200 shadow-sm hover:shadow-md">
                                                    Edit
                                                </a>
                                            @endcan
                                            
                                            @if($survey->status_verifikasi === 'draft')
                                                <form action="{{ route('petugas.surveys.submit', $survey) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="text-green-600 hover:text-green-800 bg-green-100 hover:bg-green-200 px-2 py-1 rounded text-xs transition-all duration-200 shadow-sm hover:shadow-md"
                                                            onclick="return confirm('Kirim survei untuk verifikasi?')">
                                                        Kirim
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            <form action="{{ route('petugas.surveys.duplicate', $survey) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="text-purple-600 hover:text-purple-800 bg-purple-100 hover:bg-purple-200 px-2 py-1 rounded text-xs transition-all duration-200 shadow-sm hover:shadow-md"
                                                        onclick="return confirm('Duplikasi survei ini?')">
                                                    Copy
                                                </button>
                                            </form>
                                            
                                            @can('delete', $survey)
                                                <form action="{{ route('petugas.surveys.destroy', $survey) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="text-red-600 hover:text-red-800 bg-red-100 hover:bg-red-200 px-2 py-1 rounded text-xs transition-all duration-200 shadow-sm hover:shadow-md" 
                                                            onclick="return confirm('Yakin ingin menghapus?')">
                                                        Hapus
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-green-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                            </svg>
                                            <p class="text-gray-600 text-lg">
                                                @if(request()->hasAny(['search', 'status', 'village_id', 'date_from', 'date_to']))
                                                    Tidak ada survei yang sesuai dengan filter
                                                @else
                                                    Belum ada data survei
                                                @endif
                                            </p>
                                            <p class="text-gray-500 text-sm mb-4">
                                                @if(request()->hasAny(['search', 'status', 'village_id', 'date_from', 'date_to']))
                                                    Coba ubah kriteria pencarian
                                                @else
                                                    Mulai dengan membuat survei pertama
                                                @endif
                                            </p>
                                            @if(!request()->hasAny(['search', 'status', 'village_id', 'date_from', 'date_to']))
                                                <a href="{{ route('petugas.surveys.create') }}" 
                                                   class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-2 px-4 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                                                    Tambah Survei
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($surveys->hasPages())
                    <div class="bg-gradient-to-r from-green-50 to-green-100 px-4 py-3 border-t border-green-200 sm:px-6">
                        {{ $surveys->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Rejection Reason Modal -->
    <div id="rejectionModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50 backdrop-blur-sm">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-2xl rounded-lg bg-white border-green-100">
            <div class="mt-3">
                <div class="flex items-center mb-4">
                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-green-900">Alasan Penolakan</h3>
                </div>
                <p id="rejectionText" class="text-gray-700 mb-6 bg-gray-50 p-3 rounded-md border border-gray-200"></p>
                <div class="flex justify-end">
                    <button onclick="hideRejectionModal()" 
                            class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function showRejectionReason(reason) {
            document.getElementById('rejectionText').textContent = reason;
            document.getElementById('rejectionModal').classList.remove('hidden');
        }

        function hideRejectionModal() {
            document.getElementById('rejectionModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('rejectionModal');
            if (event.target === modal) {
                hideRejectionModal();
            }
        });
    </script>
    @endpush
</x-layouts.petugas>
