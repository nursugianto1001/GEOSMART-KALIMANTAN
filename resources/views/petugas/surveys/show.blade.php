{{-- resources/views/petugas/surveys/show.blade.php --}}
<x-layouts.petugas>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('petugas.surveys.index') }}" class="text-green-600 hover:text-green-800 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-green-900 leading-tight">
                Detail Survei Kemiskinan
            </h2>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12 bg-gradient-to-b from-green-100 via-green-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-3">
                    <div class="bg-white shadow-lg rounded-lg border border-green-100">
                        <div class="p-4 sm:p-6">
                            <!-- Header -->
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 pb-6 border-b border-green-200">
                                <div>
                                    <h3 class="text-xl font-semibold text-green-900">{{ $survey->nama_kepala_keluarga }}</h3>
                                    <p class="text-gray-600">{{ $survey->neighborhood->full_address }}</p>
                                    <p class="text-sm text-gray-500">
                                        Survei dibuat: {{ $survey->created_at->format('d/m/Y H:i') }}
                                        @if($survey->updated_at != $survey->created_at)
                                            | Diupdate: {{ $survey->updated_at->format('d/m/Y H:i') }}
                                        @endif
                                    </p>
                                </div>
                                <div class="mt-4 sm:mt-0">
                                    <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $survey->status_badge }}">
                                        {{ $survey->status_text }}
                                    </span>
                                </div>
                            </div>

                            <!-- Survey Data -->
                            <div class="space-y-8">
                                <!-- 1. Data Identitas -->
                                <div>
                                    <h4 class="text-lg font-medium text-green-800 mb-4 flex items-center bg-gradient-to-r from-green-50 to-green-100 p-4 rounded-lg border border-green-200">
                                        <span class="bg-gradient-to-r from-green-600 to-green-700 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3 shadow-md">1</span>
                                        Data Identitas Keluarga
                                    </h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-green-50 p-4 rounded-lg border border-green-200">
                                        <div>
                                            <label class="block text-sm font-medium text-green-700">NIK</label>
                                            <p class="text-green-900 font-medium">{{ $survey->nik ?? '-' }}</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-green-700">Jumlah Anggota Keluarga</label>
                                            <p class="text-green-900 font-medium">{{ $survey->jumlah_anggota_keluarga }} orang</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-green-700">Jenis Kelamin KK</label>
                                            <p class="text-green-900 font-medium">{{ $survey->jenis_kelamin_kk === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-green-700">Status Keluarga</label>
                                            <p class="text-green-900 font-medium">{{ ucfirst(str_replace('_', ' ', $survey->status_keluarga)) }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- 2. Lokasi & Alamat -->
                                <div>
                                    <h4 class="text-lg font-medium text-green-800 mb-4 flex items-center bg-gradient-to-r from-green-50 to-green-100 p-4 rounded-lg border border-green-200">
                                        <span class="bg-gradient-to-r from-green-600 to-green-700 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3 shadow-md">2</span>
                                        Lokasi & Alamat
                                    </h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-green-50 p-4 rounded-lg border border-green-200">
                                        <div class="sm:col-span-2">
                                            <label class="block text-sm font-medium text-green-700">Alamat Lengkap</label>
                                            <p class="text-green-900 font-medium">{{ $survey->alamat_lengkap }}</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-green-700">Koordinat GPS</label>
                                            <p class="text-green-900 font-medium">{{ $survey->latitude }}, {{ $survey->longitude }}</p>
                                            <a href="https://maps.google.com/?q={{ $survey->latitude }},{{ $survey->longitude }}" 
                                               target="_blank" class="text-green-600 hover:text-green-800 text-sm inline-flex items-center mt-1 transition-colors">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                                </svg>
                                                Lihat di Google Maps
                                            </a>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-green-700">Tipe Tempat Tinggal</label>
                                            <p class="text-green-900 font-medium">{{ ucfirst(str_replace('_', ' ', $survey->tipe_tempat_tinggal)) }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- 3. Kondisi Ekonomi -->
                                <div>
                                    <h4 class="text-lg font-medium text-green-800 mb-4 flex items-center bg-gradient-to-r from-green-50 to-green-100 p-4 rounded-lg border border-green-200">
                                        <span class="bg-gradient-to-r from-green-600 to-green-700 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3 shadow-md">3</span>
                                        Kondisi Ekonomi
                                    </h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-green-50 p-4 rounded-lg border border-green-200">
                                        <div>
                                            <label class="block text-sm font-medium text-green-700">Sumber Penghasilan</label>
                                            <p class="text-green-900 font-medium">{{ ucfirst(str_replace('_', ' ', $survey->sumber_penghasilan)) }}</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-green-700">Penghasilan Bulanan</label>
                                            <p class="text-green-900 font-medium">
                                                @if($survey->penghasilan_bulanan)
                                                    Rp {{ number_format($survey->penghasilan_bulanan, 0, ',', '.') }}
                                                @else
                                                    Tidak diketahui
                                                @endif
                                            </p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-green-700">Status Kepemilikan</label>
                                            <p class="text-green-900 font-medium">{{ ucfirst(str_replace('_', ' ', $survey->status_kepemilikan)) }}</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-green-700">Aset Utama</label>
                                            <p class="text-green-900 font-medium">
                                                @if($survey->aset_utama && !in_array('tidak_ada', $survey->aset_utama))
                                                    {{ implode(', ', array_map(function($asset) {
                                                        return ucfirst(str_replace('_', ' ', $asset));
                                                    }, $survey->aset_utama)) }}
                                                @else
                                                    Tidak ada
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- 4. Kondisi Tempat Tinggal -->
                                <div>
                                    <h4 class="text-lg font-medium text-green-800 mb-4 flex items-center bg-gradient-to-r from-green-50 to-green-100 p-4 rounded-lg border border-green-200">
                                        <span class="bg-gradient-to-r from-green-600 to-green-700 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3 shadow-md">4</span>
                                        Kondisi Tempat Tinggal
                                    </h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-green-50 p-4 rounded-lg border border-green-200">
                                        <div>
                                            <label class="block text-sm font-medium text-green-700">Jenis Bangunan</label>
                                            <p class="text-green-900 font-medium">{{ ucfirst(str_replace('_', ' ', $survey->jenis_bangunan)) }}</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-green-700">Luas Rumah</label>
                                            <p class="text-green-900 font-medium">{{ $survey->luas_rumah ? $survey->luas_rumah . ' m²' : 'Tidak diketahui' }}</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-green-700">Lantai Rumah</label>
                                            <p class="text-green-900 font-medium">{{ ucfirst($survey->lantai_rumah) }}</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-green-700">Dinding Rumah</label>
                                            <p class="text-green-900 font-medium">{{ ucfirst(str_replace('_', ' ', $survey->dinding_rumah)) }}</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-green-700">Atap Rumah</label>
                                            <p class="text-green-900 font-medium">{{ ucfirst($survey->atap_rumah) }}</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-green-700">Sumber Air</label>
                                            <p class="text-green-900 font-medium">{{ strtoupper($survey->sumber_air) }}</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-green-700">Sumber Listrik</label>
                                            <p class="text-green-900 font-medium">{{ strtoupper(str_replace('_', ' ', $survey->sumber_listrik)) }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- 5. Akses Layanan Dasar -->
                                <div>
                                    <h4 class="text-lg font-medium text-green-800 mb-4 flex items-center bg-gradient-to-r from-green-50 to-green-100 p-4 rounded-lg border border-green-200">
                                        <span class="bg-gradient-to-r from-green-600 to-green-700 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3 shadow-md">5</span>
                                        Akses Layanan Dasar
                                    </h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 bg-green-50 p-4 rounded-lg border border-green-200">
                                        <div>
                                            <label class="block text-sm font-medium text-green-700">Akses Sekolah</label>
                                            <p class="text-green-900 font-medium">{{ str_replace('_', ' ', $survey->akses_sekolah) }}</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-green-700">Akses Kesehatan</label>
                                            <p class="text-green-900 font-medium">{{ strtoupper(str_replace('_', ' ', $survey->akses_kesehatan)) }}</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-green-700">Akses Jalan</label>
                                            <p class="text-green-900 font-medium">{{ str_replace('_', ' ', $survey->akses_jalan) }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- 6. Kondisi Sosial & Kesehatan -->
                                <div>
                                    <h4 class="text-lg font-medium text-green-800 mb-4 flex items-center bg-gradient-to-r from-green-50 to-green-100 p-4 rounded-lg border border-green-200">
                                        <span class="bg-gradient-to-r from-green-600 to-green-700 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3 shadow-md">6</span>
                                        Kondisi Sosial & Kesehatan
                                    </h4>
                                    <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                                            <div class="flex items-center">
                                                <div class="w-4 h-4 mr-2 rounded {{ $survey->anak_tidak_sekolah ? 'bg-red-500' : 'bg-green-500' }}"></div>
                                                <span class="text-sm text-green-700">Anak tidak sekolah: {{ $survey->anak_tidak_sekolah ? 'Ya' : 'Tidak' }}</span>
                                            </div>
                                            <div class="flex items-center">
                                                <div class="w-4 h-4 mr-2 rounded {{ $survey->ada_difabel_lansia ? 'bg-red-500' : 'bg-green-500' }}"></div>
                                                <span class="text-sm text-green-700">Ada difabel/lansia: {{ $survey->ada_difabel_lansia ? 'Ya' : 'Tidak' }}</span>
                                            </div>
                                            <div class="flex items-center">
                                                <div class="w-4 h-4 mr-2 rounded {{ $survey->ada_sakit_menahun ? 'bg-red-500' : 'bg-green-500' }}"></div>
                                                <span class="text-sm text-green-700">Sakit menahun: {{ $survey->ada_sakit_menahun ? 'Ya' : 'Tidak' }}</span>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-green-700">Bantuan Pemerintah</label>
                                            <p class="text-green-900 font-medium">
                                                @if($survey->bantuan_pemerintah && !in_array('tidak_ada', $survey->bantuan_pemerintah))
                                                    {{ implode(', ', array_map('strtoupper', $survey->bantuan_pemerintah)) }}
                                                @else
                                                    Tidak ada
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- 7. Dokumentasi -->
                                @if($survey->foto_depan_rumah || $survey->foto_dalam_rumah)
                                <div>
                                    <h4 class="text-lg font-medium text-green-800 mb-4 flex items-center bg-gradient-to-r from-green-50 to-green-100 p-4 rounded-lg border border-green-200">
                                        <span class="bg-gradient-to-r from-green-600 to-green-700 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3 shadow-md">7</span>
                                        Dokumentasi
                                    </h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        @if($survey->foto_depan_rumah)
                                        <div>
                                            <label class="block text-sm font-medium text-green-700 mb-2">Foto Depan Rumah</label>
                                            <img src="{{ Storage::url($survey->foto_depan_rumah) }}" 
                                                 alt="Foto Depan Rumah" 
                                                 class="w-full h-48 object-cover rounded-lg border border-green-300 cursor-pointer hover:opacity-90 transition-opacity shadow-md"
                                                 onclick="openImageModal('{{ Storage::url($survey->foto_depan_rumah) }}', 'Foto Depan Rumah')">
                                        </div>
                                        @endif
                                        @if($survey->foto_dalam_rumah)
                                        <div>
                                            <label class="block text-sm font-medium text-green-700 mb-2">Foto Dalam Rumah</label>
                                            <img src="{{ Storage::url($survey->foto_dalam_rumah) }}" 
                                                 alt="Foto Dalam Rumah" 
                                                 class="w-full h-48 object-cover rounded-lg border border-green-300 cursor-pointer hover:opacity-90 transition-opacity shadow-md"
                                                 onclick="openImageModal('{{ Storage::url($survey->foto_dalam_rumah) }}', 'Foto Dalam Rumah')">
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endif

                                @if($survey->catatan_tambahan)
                                <div>
                                    <label class="block text-sm font-medium text-green-700">Catatan Tambahan</label>
                                    <p class="text-green-900 mt-1 p-3 bg-green-50 rounded-lg border border-green-200">{{ $survey->catatan_tambahan }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Poverty Assessment -->
                    <div class="bg-white shadow-lg rounded-lg mb-6 border border-green-100">
                        <div class="p-4 sm:p-6">
                            <h4 class="text-lg font-medium text-green-800 mb-4">Penilaian Kemiskinan</h4>
                            
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
                                    <span class="text-sm font-medium text-green-700">{{ ucfirst($category->kategori) }}</span>
                                    <div class="flex items-center">
                                        <div class="w-16 bg-green-200 rounded-full h-2 mr-2">
                                            <div class="bg-green-600 h-2 rounded-full" style="width: {{ ($category->skor / 5) * 100 }}%"></div>
                                        </div>
                                        <span class="text-sm text-green-600">{{ $category->skor }}/5</span>
                                    </div>
                                </div>
                                @if($category->keterangan)
                                    <p class="text-xs text-gray-500 ml-4">{{ $category->keterangan }}</p>
                                @endif
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Survey Info -->
                    <div class="bg-white shadow-lg rounded-lg mb-6 border border-green-100">
                        <div class="p-4 sm:p-6">
                            <h4 class="text-lg font-medium text-green-800 mb-4">Informasi Survei</h4>
                            
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-green-700">Surveyor</label>
                                    <p class="text-green-900 font-medium">{{ $survey->surveyor->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $survey->surveyor->email }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-green-700">Tanggal Survei</label>
                                    <p class="text-green-900 font-medium">{{ $survey->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                
                                @if($survey->updated_at != $survey->created_at)
                                <div>
                                    <label class="block text-sm font-medium text-green-700">Terakhir Diupdate</label>
                                    <p class="text-green-900 font-medium">{{ $survey->updated_at->format('d/m/Y H:i') }}</p>
                                </div>
                                @endif
                                
                                @if($survey->verified_by)
                                <div>
                                    <label class="block text-sm font-medium text-green-700">Diverifikasi Oleh</label>
                                    <p class="text-green-900 font-medium">{{ $survey->verifier->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $survey->verified_at->format('d/m/Y H:i') }}</p>
                                </div>
                                @endif

                                @if($survey->rejection_reason)
                                <div>
                                    <label class="block text-sm font-medium text-green-700">Alasan Penolakan</label>
                                    <p class="text-red-600 text-sm bg-red-50 p-2 rounded border border-red-200">{{ $survey->rejection_reason }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="bg-white shadow-lg rounded-lg border border-green-100">
                        <div class="p-4 sm:p-6">
                            <h4 class="text-lg font-medium text-green-800 mb-4">Aksi</h4>
                            
                            <div class="space-y-3">
                                @if($survey->status_verifikasi === 'draft')
                                    <form action="{{ route('petugas.surveys.submit', $survey) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                                class="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-2 px-4 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg"
                                                onclick="return confirm('Kirim survei untuk verifikasi?')">
                                            Kirim untuk Verifikasi
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('petugas.surveys.duplicate', $survey) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                                        Duplikasi Survei
                                    </button>
                                </form>

                                @can('delete', $survey)
                                    <form action="{{ route('petugas.surveys.destroy', $survey) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg"
                                                onclick="return confirm('Yakin ingin menghapus survei ini?')">
                                            Hapus Survei
                                        </button>
                                    </form>
                                @endcan

                                <a href="{{ route('petugas.surveys.index') }}" 
                                   class="w-full bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition-all duration-200 text-center block shadow-md hover:shadow-lg">
                                    Kembali ke Daftar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden backdrop-blur-sm">
        <div class="max-w-4xl max-h-full p-4">
            <div class="relative">
                <img id="modalImage" src="" alt="" class="max-w-full max-h-full object-contain rounded-lg shadow-2xl">
                <button onclick="closeImageModal()" 
                        class="absolute top-4 right-4 text-white bg-black bg-opacity-50 rounded-full p-2 hover:bg-opacity-75 transition-all duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <div id="modalTitle" class="absolute bottom-4 left-4 text-white bg-black bg-opacity-50 px-3 py-1 rounded"></div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function openImageModal(src, title) {
            document.getElementById('modalImage').src = src;
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
    @endpush
</x-layouts.petugas>
