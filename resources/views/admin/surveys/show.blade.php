{{-- resources/views/admin/surveys/show.blade.php --}}
<x-layouts.admin>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.surveys.index') }}" class="text-gray-600 hover:text-gray-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Survei Kemiskinan
            </h2>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Survey Details -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900">{{ $survey->nama_kepala_keluarga }}</h3>
                            <p class="text-gray-600">{{ $survey->neighborhood->full_address }}</p>
                        </div>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $survey->status_badge }}">
                            {{ $survey->status_text }}
                        </span>
                    </div>

                    <!-- Survey Data Sections -->
                    <div class="space-y-8">
                        <!-- 1. Data Identitas -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-900 mb-4">1. Data Identitas Keluarga</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">NIK</label>
                                    <p class="text-gray-900">{{ $survey->nik ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Jumlah Anggota Keluarga</label>
                                    <p class="text-gray-900">{{ $survey->jumlah_anggota_keluarga }} orang</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Jenis Kelamin KK</label>
                                    <p class="text-gray-900">{{ $survey->jenis_kelamin_kk === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status Keluarga</label>
                                    <p class="text-gray-900">{{ ucfirst(str_replace('_', ' ', $survey->status_keluarga)) }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Lokasi & Alamat -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-900 mb-4">2. Lokasi & Alamat</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                                    <p class="text-gray-900">{{ $survey->alamat_lengkap }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Koordinat GPS</label>
                                    <p class="text-gray-900">{{ $survey->latitude }}, {{ $survey->longitude }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tipe Tempat Tinggal</label>
                                    <p class="text-gray-900">{{ ucfirst(str_replace('_', ' ', $survey->tipe_tempat_tinggal)) }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Kondisi Ekonomi -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-900 mb-4">3. Kondisi Ekonomi</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Sumber Penghasilan</label>
                                    <p class="text-gray-900">{{ ucfirst(str_replace('_', ' ', $survey->sumber_penghasilan)) }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Penghasilan Bulanan</label>
                                    <p class="text-gray-900">{{ $survey->penghasilan_bulanan ? 'Rp ' . number_format($survey->penghasilan_bulanan, 0, ',', '.') : '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status Kepemilikan</label>
                                    <p class="text-gray-900">{{ ucfirst(str_replace('_', ' ', $survey->status_kepemilikan)) }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Aset Utama</label>
                                    <p class="text-gray-900">{{ $survey->aset_utama ? implode(', ', $survey->aset_utama) : '-' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Kondisi Tempat Tinggal -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-900 mb-4">4. Kondisi Tempat Tinggal</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Jenis Bangunan</label>
                                    <p class="text-gray-900">{{ ucfirst(str_replace('_', ' ', $survey->jenis_bangunan)) }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Luas Rumah</label>
                                    <p class="text-gray-900">{{ $survey->luas_rumah ? $survey->luas_rumah . ' m²' : '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Lantai Rumah</label>
                                    <p class="text-gray-900">{{ ucfirst($survey->lantai_rumah) }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Dinding Rumah</label>
                                    <p class="text-gray-900">{{ ucfirst(str_replace('_', ' ', $survey->dinding_rumah)) }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Atap Rumah</label>
                                    <p class="text-gray-900">{{ ucfirst($survey->atap_rumah) }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Sumber Air</label>
                                    <p class="text-gray-900">{{ strtoupper($survey->sumber_air) }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Sumber Listrik</label>
                                    <p class="text-gray-900">{{ strtoupper(str_replace('_', ' ', $survey->sumber_listrik)) }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Akses Layanan Dasar -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-900 mb-4">5. Akses Layanan Dasar</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Akses Sekolah</label>
                                    <p class="text-gray-900">{{ str_replace('_', ' ', $survey->akses_sekolah) }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Akses Kesehatan</label>
                                    <p class="text-gray-900">{{ strtoupper(str_replace('_', ' ', $survey->akses_kesehatan)) }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Akses Jalan</label>
                                    <p class="text-gray-900">{{ str_replace('_', ' ', $survey->akses_jalan) }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- 6. Kondisi Sosial & Kesehatan -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-900 mb-4">6. Kondisi Sosial & Kesehatan</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Anak Tidak Sekolah</label>
                                    <p class="text-gray-900">{{ $survey->anak_tidak_sekolah ? 'Ya' : 'Tidak' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Ada Difabel/Lansia</label>
                                    <p class="text-gray-900">{{ $survey->ada_difabel_lansia ? 'Ya' : 'Tidak' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Sakit Menahun</label>
                                    <p class="text-gray-900">{{ $survey->ada_sakit_menahun ? 'Ya' : 'Tidak' }}</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700">Bantuan Pemerintah</label>
                                <p class="text-gray-900">{{ $survey->bantuan_pemerintah ? implode(', ', array_map('strtoupper', $survey->bantuan_pemerintah)) : 'Tidak ada' }}</p>
                            </div>
                        </div>

                        <!-- 7. Dokumentasi -->
                        @if($survey->foto_depan_rumah || $survey->foto_dalam_rumah)
                        <div>
                            <h4 class="text-lg font-medium text-gray-900 mb-4">7. Dokumentasi</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if($survey->foto_depan_rumah)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Foto Depan Rumah</label>
                                    <img src="{{ Storage::url($survey->foto_depan_rumah) }}" alt="Foto Depan Rumah" class="w-full h-48 object-cover rounded-lg">
                                </div>
                                @endif
                                @if($survey->foto_dalam_rumah)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Foto Dalam Rumah</label>
                                    <img src="{{ Storage::url($survey->foto_dalam_rumah) }}" alt="Foto Dalam Rumah" class="w-full h-48 object-cover rounded-lg">
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif

                        @if($survey->catatan_tambahan)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Catatan Tambahan</label>
                            <p class="text-gray-900 mt-1">{{ $survey->catatan_tambahan }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Poverty Assessment -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="p-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Penilaian Kemiskinan</h4>
                    
                    <div class="text-center mb-6">
                        <div class="text-4xl font-bold 
                            @if($survey->poverty_score >= 20) text-red-600
                            @elseif($survey->poverty_score >= 15) text-orange-600
                            @elseif($survey->poverty_score >= 10) text-yellow-600
                            @else text-green-600 @endif">
                            {{ $survey->poverty_score }}/25
                        </div>
                        <div class="text-sm text-gray-500">Skor Kemiskinan</div>
                        <div class="mt-2">
                            <span class="px-3 py-1 text-sm font-semibold rounded-full 
                                @if($survey->poverty_score >= 20) bg-red-100 text-red-800
                                @elseif($survey->poverty_score >= 15) bg-orange-100 text-orange-800
                                @elseif($survey->poverty_score >= 10) bg-yellow-100 text-yellow-800
                                @else bg-green-100 text-green-800 @endif">
                                {{ $survey->poverty_level }}
                            </span>
                        </div>
                    </div>

                    <!-- Category Scores -->
                    @if($survey->categories->count() > 0)
                    <div class="space-y-3">
                        @foreach($survey->categories as $category)
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-700">{{ ucfirst($category->kategori) }}</span>
                            <div class="flex items-center">
                                <div class="w-20 bg-gray-200 rounded-full h-2 mr-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($category->skor / 5) * 100 }}%"></div>
                                </div>
                                <span class="text-sm text-gray-600">{{ $category->skor }}/5</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            <!-- Survey Info -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="p-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Informasi Survei</h4>
                    
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Surveyor</label>
                            <p class="text-gray-900">{{ $survey->surveyor->name }}</p>
                            <p class="text-sm text-gray-500">{{ $survey->surveyor->email }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Survei</label>
                            <p class="text-gray-900">{{ $survey->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        
                        @if($survey->verified_by)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Diverifikasi Oleh</label>
                            <p class="text-gray-900">{{ $survey->verifier->name }}</p>
                            <p class="text-sm text-gray-500">{{ $survey->verified_at->format('d/m/Y H:i') }}</p>
                        </div>
                        @endif

                        @if($survey->rejection_reason)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Alasan Penolakan</label>
                            <p class="text-red-600 text-sm">{{ $survey->rejection_reason }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Actions -->
            @if($survey->status_verifikasi === 'submitted')
            <div class="bg-white shadow rounded-lg">
                <div class="p-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Aksi Verifikasi</h4>
                    
                    <div class="space-y-3">
                        <form action="{{ route('admin.surveys.verify', $survey) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition-colors" onclick="return confirm('Verifikasi survei ini?')">
                                ✓ Verifikasi Survei
                            </button>
                        </form>
                        
                        <button onclick="showRejectModal({{ $survey->id }})" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                            ✗ Tolak Survei
                        </button>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Tolak Survei</h3>
                <form id="rejectForm" action="{{ route('admin.surveys.reject', $survey) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan</label>
                        <textarea id="rejection_reason" name="rejection_reason" rows="4" required 
                                  class="w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500" 
                                  placeholder="Jelaskan alasan penolakan survei ini..."></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="hideRejectModal()" 
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg transition-colors">
                            Batal
                        </button>
                        <button type="submit" 
                                class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
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
        }

        function hideRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
            document.getElementById('rejectForm').reset();
        }
    </script>
    @endpush
</x-layouts.admin>
