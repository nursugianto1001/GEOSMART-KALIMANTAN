{{-- resources/views/petugas/surveys/edit.blade.php --}}

@php
use Illuminate\Support\Facades\Storage;
@endphp
<x-layouts.petugas>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('petugas.surveys.index') }}" class="text-gray-600 hover:text-gray-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Data Survei Kemiskinan
            </h2>
            <span class="px-3 py-1 text-sm font-semibold rounded-full 
                @if($survey->status_verifikasi === 'verified') bg-green-100 text-green-800
                @elseif($survey->status_verifikasi === 'submitted') bg-yellow-100 text-yellow-800
                @elseif($survey->status_verifikasi === 'rejected') bg-red-100 text-red-800
                @else bg-gray-100 text-gray-800 @endif">
                {{ $survey->status_text }}
            </span>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-4 sm:p-6">
                    <form method="POST" action="{{ route('petugas.surveys.update', $survey) }}" enctype="multipart/form-data" id="surveyForm">
                        @csrf
                        @method('PUT')

                        <!-- Progress Indicator -->
                        <div class="mb-8">
                            <div class="flex items-center justify-between text-sm text-gray-500 mb-2">
                                <span>Progress Pengisian</span>
                                <span id="progressText">0/7 Bagian</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div id="progressBar" class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                            </div>
                        </div>

                        <!-- 1. Data Identitas Keluarga -->
                        <div class="mb-8 form-section" data-section="1">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3">1</span>
                                Data Identitas Keluarga
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="nama_kepala_keluarga" class="block text-sm font-medium text-gray-700 mb-2">Nama Kepala Keluarga *</label>
                                    <input id="nama_kepala_keluarga" name="nama_kepala_keluarga" type="text"
                                        value="{{ old('nama_kepala_keluarga', $survey->nama_kepala_keluarga) }}" required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nama_kepala_keluarga') border-red-500 @enderror"
                                        placeholder="Masukkan nama kepala keluarga">
                                    @error('nama_kepala_keluarga')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">NIK (Opsional)</label>
                                    <input id="nik" name="nik" type="text" value="{{ old('nik', $survey->nik) }}" maxlength="16"
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nik') border-red-500 @enderror"
                                        placeholder="16 digit NIK">
                                    @error('nik')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="jumlah_anggota_keluarga" class="block text-sm font-medium text-gray-700 mb-2">Jumlah Anggota Keluarga *</label>
                                    <input id="jumlah_anggota_keluarga" name="jumlah_anggota_keluarga" type="number"
                                        value="{{ old('jumlah_anggota_keluarga', $survey->jumlah_anggota_keluarga) }}" min="1" max="20" required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('jumlah_anggota_keluarga') border-red-500 @enderror"
                                        placeholder="Contoh: 4">
                                    @error('jumlah_anggota_keluarga')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="jenis_kelamin_kk" class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin Kepala Keluarga *</label>
                                    <select id="jenis_kelamin_kk" name="jenis_kelamin_kk" required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('jenis_kelamin_kk') border-red-500 @enderror">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L" {{ old('jenis_kelamin_kk', $survey->jenis_kelamin_kk) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('jenis_kelamin_kk', $survey->jenis_kelamin_kk) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin_kk')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label for="status_keluarga" class="block text-sm font-medium text-gray-700 mb-2">Status Keluarga *</label>
                                    <select id="status_keluarga" name="status_keluarga" required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('status_keluarga') border-red-500 @enderror">
                                        <option value="">Pilih Status Keluarga</option>
                                        <option value="tetap" {{ old('status_keluarga', $survey->status_keluarga) == 'tetap' ? 'selected' : '' }}>Tetap</option>
                                        <option value="pendatang" {{ old('status_keluarga', $survey->status_keluarga) == 'pendatang' ? 'selected' : '' }}>Pendatang</option>
                                        <option value="korban_bencana" {{ old('status_keluarga', $survey->status_keluarga) == 'korban_bencana' ? 'selected' : '' }}>Korban Bencana</option>
                                        <option value="lainnya" {{ old('status_keluarga', $survey->status_keluarga) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                    @error('status_keluarga')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- 2. Lokasi & Alamat dengan Dependent Dropdown -->
                        <div class="mb-8 form-section" data-section="2">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3">2</span>
                                Lokasi & Alamat
                            </h3>

                            <div class="grid grid-cols-1 gap-4">
                                <!-- Dependent Dropdown Wilayah -->
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                    <div>
                                        <label for="province_id" class="block text-sm font-medium text-gray-700 mb-2">Provinsi *</label>
                                        <select id="province_id" name="province_id" required
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('province_id') border-red-500 @enderror">
                                            <option value="">Pilih Provinsi</option>
                                            @foreach($provinces as $province)
                                            <option value="{{ $province->id }}" {{ old('province_id', $survey->neighborhood->village->district->regency->province_id) == $province->id ? 'selected' : '' }}>
                                                {{ $province->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('province_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="regency_id" class="block text-sm font-medium text-gray-700 mb-2">Kabupaten/Kota *</label>
                                        <select id="regency_id" name="regency_id" required
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('regency_id') border-red-500 @enderror">
                                            <option value="">Pilih Kabupaten/Kota</option>
                                            @foreach($regencies as $regency)
                                            <option value="{{ $regency->id }}" {{ old('regency_id', $survey->neighborhood->village->district->regency_id) == $regency->id ? 'selected' : '' }}>
                                                {{ $regency->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('regency_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="district_id" class="block text-sm font-medium text-gray-700 mb-2">Kecamatan *</label>
                                        <select id="district_id" name="district_id" required
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('district_id') border-red-500 @enderror">
                                            <option value="">Pilih Kecamatan</option>
                                            @foreach($districts as $district)
                                            <option value="{{ $district->id }}" {{ old('district_id', $survey->neighborhood->village->district_id) == $district->id ? 'selected' : '' }}>
                                                {{ $district->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('district_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="village_id" class="block text-sm font-medium text-gray-700 mb-2">Desa/Kelurahan *</label>
                                        <select id="village_id" name="village_id" required
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('village_id') border-red-500 @enderror">
                                            <option value="">Pilih Desa/Kelurahan</option>
                                            @foreach($villages as $village)
                                            <option value="{{ $village->id }}" {{ old('village_id', $survey->neighborhood->village_id) == $village->id ? 'selected' : '' }}>
                                                {{ $village->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('village_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- RT/RW Input -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="rt" class="block text-sm font-medium text-gray-700 mb-2">RT *</label>
                                        <input id="rt" name="rt" type="text"
                                            value="{{ old('rt', $survey->neighborhood->rt) }}"
                                            required maxlength="3" pattern="[0-9]{1,3}"
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('rt') border-red-500 @enderror"
                                            placeholder="001">
                                        <p class="mt-1 text-xs text-gray-500">Format: 001, 002, 003, dst</p>
                                        @error('rt')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="rw" class="block text-sm font-medium text-gray-700 mb-2">RW *</label>
                                        <input id="rw" name="rw" type="text"
                                            value="{{ old('rw', $survey->neighborhood->rw) }}"
                                            required maxlength="3" pattern="[0-9]{1,3}"
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('rw') border-red-500 @enderror"
                                            placeholder="001">
                                        <p class="mt-1 text-xs text-gray-500">Format: 001, 002, 003, dst</p>
                                        @error('rw')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Preview Alamat Lengkap -->
                                <div id="address-preview" class="p-3 bg-blue-50 border border-blue-200 rounded-md">
                                    <p class="text-sm text-blue-800">
                                        <strong>Alamat Lengkap:</strong> <span id="preview-address">{{ $survey->neighborhood->full_address }}</span>
                                    </p>
                                </div>

                                <div>
                                    <label for="alamat_lengkap" class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap *</label>
                                    <textarea id="alamat_lengkap" name="alamat_lengkap" rows="3" required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('alamat_lengkap') border-red-500 @enderror"
                                        placeholder="Contoh: Jl. Merdeka No. 123, Kampung Suka Maju">{{ old('alamat_lengkap', $survey->alamat_lengkap) }}</textarea>
                                    @error('alamat_lengkap')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- GPS Coordinates -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="latitude" class="block text-sm font-medium text-gray-700 mb-2">Latitude *</label>
                                        <input id="latitude" name="latitude" type="number" step="any"
                                            value="{{ old('latitude', $survey->latitude) }}" required readonly
                                            class="w-full border-gray-300 rounded-md shadow-sm bg-gray-50 @error('latitude') border-red-500 @enderror">
                                        @error('latitude')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="longitude" class="block text-sm font-medium text-gray-700 mb-2">Longitude *</label>
                                        <input id="longitude" name="longitude" type="number" step="any"
                                            value="{{ old('longitude', $survey->longitude) }}" required readonly
                                            class="w-full border-gray-300 rounded-md shadow-sm bg-gray-50 @error('longitude') border-red-500 @enderror">
                                        @error('longitude')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex flex-col sm:flex-row gap-4">
                                    <button type="button" id="getLocation"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-colors flex items-center justify-center">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Update Koordinat GPS
                                    </button>

                                    <div class="flex-1">
                                        <label for="tipe_tempat_tinggal" class="block text-sm font-medium text-gray-700 mb-2">Tipe Tempat Tinggal *</label>
                                        <select id="tipe_tempat_tinggal" name="tipe_tempat_tinggal" required
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('tipe_tempat_tinggal') border-red-500 @enderror">
                                            <option value="">Pilih Tipe</option>
                                            <option value="rumah_pribadi" {{ old('tipe_tempat_tinggal', $survey->tipe_tempat_tinggal) == 'rumah_pribadi' ? 'selected' : '' }}>Rumah Pribadi</option>
                                            <option value="sewa" {{ old('tipe_tempat_tinggal', $survey->tipe_tempat_tinggal) == 'sewa' ? 'selected' : '' }}>Sewa</option>
                                            <option value="menumpang" {{ old('tipe_tempat_tinggal', $survey->tipe_tempat_tinggal) == 'menumpang' ? 'selected' : '' }}>Menumpang</option>
                                        </select>
                                        @error('tipe_tempat_tinggal')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Kondisi Ekonomi -->
                        <div class="mb-8 form-section" data-section="3">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3">3</span>
                                Kondisi Ekonomi
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="sumber_penghasilan" class="block text-sm font-medium text-gray-700 mb-2">Sumber Penghasilan Utama *</label>
                                    <select id="sumber_penghasilan" name="sumber_penghasilan" required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('sumber_penghasilan') border-red-500 @enderror">
                                        <option value="">Pilih Sumber Penghasilan</option>
                                        <option value="bertani" {{ old('sumber_penghasilan', $survey->sumber_penghasilan) == 'bertani' ? 'selected' : '' }}>Bertani</option>
                                        <option value="buruh" {{ old('sumber_penghasilan', $survey->sumber_penghasilan) == 'buruh' ? 'selected' : '' }}>Buruh</option>
                                        <option value="dagang" {{ old('sumber_penghasilan', $survey->sumber_penghasilan) == 'dagang' ? 'selected' : '' }}>Dagang</option>
                                        <option value="tidak_ada" {{ old('sumber_penghasilan', $survey->sumber_penghasilan) == 'tidak_ada' ? 'selected' : '' }}>Tidak Ada</option>
                                        <option value="lainnya" {{ old('sumber_penghasilan', $survey->sumber_penghasilan) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                    @error('sumber_penghasilan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="penghasilan_bulanan" class="block text-sm font-medium text-gray-700 mb-2">Perkiraan Penghasilan Bulanan</label>
                                    <input id="penghasilan_bulanan" name="penghasilan_bulanan" type="number"
                                        value="{{ old('penghasilan_bulanan', $survey->penghasilan_bulanan) }}" min="0"
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('penghasilan_bulanan') border-red-500 @enderror"
                                        placeholder="Contoh: 1500000">
                                    @error('penghasilan_bulanan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="status_kepemilikan" class="block text-sm font-medium text-gray-700 mb-2">Status Kepemilikan Tanah & Rumah *</label>
                                    <select id="status_kepemilikan" name="status_kepemilikan" required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('status_kepemilikan') border-red-500 @enderror">
                                        <option value="">Pilih Status</option>
                                        <option value="milik_sendiri" {{ old('status_kepemilikan', $survey->status_kepemilikan) == 'milik_sendiri' ? 'selected' : '' }}>Milik Sendiri</option>
                                        <option value="sewa" {{ old('status_kepemilikan', $survey->status_kepemilikan) == 'sewa' ? 'selected' : '' }}>Sewa</option>
                                        <option value="tidak_punya" {{ old('status_kepemilikan', $survey->status_kepemilikan) == 'tidak_punya' ? 'selected' : '' }}>Tidak Punya</option>
                                    </select>
                                    @error('status_kepemilikan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Aset Utama yang Dimiliki</label>
                                    <div class="grid grid-cols-2 gap-2">
                                        @php
                                        $asets = ['motor', 'mobil', 'hp', 'tv', 'kulkas', 'mesin_cuci'];
                                        $oldAsets = old('aset_utama', $survey->aset_utama ?? []);
                                        @endphp
                                        @foreach($asets as $aset)
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="aset_utama[]" value="{{ $aset }}"
                                                {{ in_array($aset, $oldAsets) ? 'checked' : '' }}
                                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            <span class="ml-2 text-sm text-gray-700">{{ ucfirst(str_replace('_', ' ', $aset)) }}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                    @error('aset_utama')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- 4. Kondisi Tempat Tinggal -->
                        <div class="mb-8 form-section" data-section="4">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3">4</span>
                                Kondisi Tempat Tinggal
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="jenis_bangunan" class="block text-sm font-medium text-gray-700 mb-2">Jenis Bangunan *</label>
                                    <select id="jenis_bangunan" name="jenis_bangunan" required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('jenis_bangunan') border-red-500 @enderror">
                                        <option value="">Pilih Jenis Bangunan</option>
                                        <option value="permanen" {{ old('jenis_bangunan', $survey->jenis_bangunan) == 'permanen' ? 'selected' : '' }}>Permanen</option>
                                        <option value="semi_permanen" {{ old('jenis_bangunan', $survey->jenis_bangunan) == 'semi_permanen' ? 'selected' : '' }}>Semi Permanen</option>
                                        <option value="tidak_layak" {{ old('jenis_bangunan', $survey->jenis_bangunan) == 'tidak_layak' ? 'selected' : '' }}>Tidak Layak</option>
                                    </select>
                                    @error('jenis_bangunan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="luas_rumah" class="block text-sm font-medium text-gray-700 mb-2">Luas Rumah (m²)</label>
                                    <input id="luas_rumah" name="luas_rumah" type="number"
                                        value="{{ old('luas_rumah', $survey->luas_rumah) }}" min="1"
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('luas_rumah') border-red-500 @enderror"
                                        placeholder="Contoh: 36">
                                    @error('luas_rumah')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="lantai_rumah" class="block text-sm font-medium text-gray-700 mb-2">Lantai Rumah *</label>
                                    <select id="lantai_rumah" name="lantai_rumah" required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('lantai_rumah') border-red-500 @enderror">
                                        <option value="">Pilih Jenis Lantai</option>
                                        <option value="tanah" {{ old('lantai_rumah', $survey->lantai_rumah) == 'tanah' ? 'selected' : '' }}>Tanah</option>
                                        <option value="semen" {{ old('lantai_rumah', $survey->lantai_rumah) == 'semen' ? 'selected' : '' }}>Semen</option>
                                        <option value="keramik" {{ old('lantai_rumah', $survey->lantai_rumah) == 'keramik' ? 'selected' : '' }}>Keramik</option>
                                    </select>
                                    @error('lantai_rumah')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="dinding_rumah" class="block text-sm font-medium text-gray-700 mb-2">Dinding Rumah *</label>
                                    <select id="dinding_rumah" name="dinding_rumah" required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('dinding_rumah') border-red-500 @enderror">
                                        <option value="">Pilih Jenis Dinding</option>
                                        <option value="kayu" {{ old('dinding_rumah', $survey->dinding_rumah) == 'kayu' ? 'selected' : '' }}>Kayu</option>
                                        <option value="tembok" {{ old('dinding_rumah', $survey->dinding_rumah) == 'tembok' ? 'selected' : '' }}>Tembok</option>
                                        <option value="anyaman_bambu" {{ old('dinding_rumah', $survey->dinding_rumah) == 'anyaman_bambu' ? 'selected' : '' }}>Anyaman Bambu</option>
                                        <option value="seng" {{ old('dinding_rumah', $survey->dinding_rumah) == 'seng' ? 'selected' : '' }}>Seng</option>
                                    </select>
                                    @error('dinding_rumah')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="atap_rumah" class="block text-sm font-medium text-gray-700 mb-2">Atap Rumah *</label>
                                    <select id="atap_rumah" name="atap_rumah" required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('atap_rumah') border-red-500 @enderror">
                                        <option value="">Pilih Jenis Atap</option>
                                        <option value="genteng" {{ old('atap_rumah', $survey->atap_rumah) == 'genteng' ? 'selected' : '' }}>Genteng</option>
                                        <option value="seng" {{ old('atap_rumah', $survey->atap_rumah) == 'seng' ? 'selected' : '' }}>Seng</option>
                                        <option value="rumbia" {{ old('atap_rumah', $survey->atap_rumah) == 'rumbia' ? 'selected' : '' }}>Rumbia</option>
                                        <option value="plastik" {{ old('atap_rumah', $survey->atap_rumah) == 'plastik' ? 'selected' : '' }}>Plastik</option>
                                    </select>
                                    @error('atap_rumah')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="sumber_air" class="block text-sm font-medium text-gray-700 mb-2">Sumber Air *</label>
                                    <select id="sumber_air" name="sumber_air" required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('sumber_air') border-red-500 @enderror">
                                        <option value="">Pilih Sumber Air</option>
                                        <option value="sumur" {{ old('sumber_air', $survey->sumber_air) == 'sumur' ? 'selected' : '' }}>Sumur</option>
                                        <option value="pdam" {{ old('sumber_air', $survey->sumber_air) == 'pdam' ? 'selected' : '' }}>PDAM</option>
                                        <option value="sungai" {{ old('sumber_air', $survey->sumber_air) == 'sungai' ? 'selected' : '' }}>Sungai</option>
                                    </select>
                                    @error('sumber_air')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="sumber_listrik" class="block text-sm font-medium text-gray-700 mb-2">Sumber Listrik *</label>
                                    <select id="sumber_listrik" name="sumber_listrik" required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('sumber_listrik') border-red-500 @enderror">
                                        <option value="">Pilih Sumber Listrik</option>
                                        <option value="pln" {{ old('sumber_listrik', $survey->sumber_listrik) == 'pln' ? 'selected' : '' }}>PLN</option>
                                        <option value="genset" {{ old('sumber_listrik', $survey->sumber_listrik) == 'genset' ? 'selected' : '' }}>Genset</option>
                                        <option value="tidak_ada" {{ old('sumber_listrik', $survey->sumber_listrik) == 'tidak_ada' ? 'selected' : '' }}>Tidak Ada</option>
                                    </select>
                                    @error('sumber_listrik')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- 5. Akses Layanan Dasar -->
                        <div class="mb-8 form-section" data-section="5">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3">5</span>
                                Akses Layanan Dasar
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="akses_sekolah" class="block text-sm font-medium text-gray-700 mb-2">Akses ke Sekolah Dasar *</label>
                                    <select id="akses_sekolah" name="akses_sekolah" required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('akses_sekolah') border-red-500 @enderror">
                                        <option value="">Pilih Jarak</option>
                                        <option value="kurang_1km" {{ old('akses_sekolah', $survey->akses_sekolah) == 'kurang_1km' ? 'selected' : '' }}>Kurang dari 1 km</option>
                                        <option value="1_3km" {{ old('akses_sekolah', $survey->akses_sekolah) == '1_3km' ? 'selected' : '' }}>1-3 km</option>
                                        <option value="lebih_3km" {{ old('akses_sekolah', $survey->akses_sekolah) == 'lebih_3km' ? 'selected' : '' }}>Lebih dari 3 km</option>
                                    </select>
                                    @error('akses_sekolah')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="akses_kesehatan" class="block text-sm font-medium text-gray-700 mb-2">Akses ke Fasilitas Kesehatan *</label>
                                    <select id="akses_kesehatan" name="akses_kesehatan" required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('akses_kesehatan') border-red-500 @enderror">
                                        <option value="">Pilih Fasilitas</option>
                                        <option value="puskesmas" {{ old('akses_kesehatan', $survey->akses_kesehatan) == 'puskesmas' ? 'selected' : '' }}>Puskesmas</option>
                                        <option value="rs" {{ old('akses_kesehatan', $survey->akses_kesehatan) == 'rs' ? 'selected' : '' }}>Rumah Sakit</option>
                                        <option value="tidak_ada" {{ old('akses_kesehatan', $survey->akses_kesehatan) == 'tidak_ada' ? 'selected' : '' }}>Tidak Ada</option>
                                    </select>
                                    @error('akses_kesehatan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="akses_jalan" class="block text-sm font-medium text-gray-700 mb-2">Akses ke Jalan Utama *</label>
                                    <select id="akses_jalan" name="akses_jalan" required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('akses_jalan') border-red-500 @enderror">
                                        <option value="">Pilih Kondisi</option>
                                        <option value="bisa_motor_mobil" {{ old('akses_jalan', $survey->akses_jalan) == 'bisa_motor_mobil' ? 'selected' : '' }}>Bisa Motor & Mobil</option>
                                        <option value="tidak_bisa" {{ old('akses_jalan', $survey->akses_jalan) == 'tidak_bisa' ? 'selected' : '' }}>Tidak Bisa Dilalui Kendaraan</option>
                                    </select>
                                    @error('akses_jalan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- 6. Kondisi Sosial & Kesehatan -->
                        <div class="mb-8 form-section" data-section="6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3">6</span>
                                Kondisi Sosial & Kesehatan
                            </h3>

                            <div class="grid grid-cols-1 gap-4">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="flex items-center">
                                        <input id="anak_tidak_sekolah" name="anak_tidak_sekolah" type="checkbox" value="1"
                                            {{ old('anak_tidak_sekolah', $survey->anak_tidak_sekolah) ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <label for="anak_tidak_sekolah" class="ml-2 text-sm text-gray-700">Ada anak yang tidak bersekolah</label>
                                    </div>

                                    <div class="flex items-center">
                                        <input id="ada_difabel_lansia" name="ada_difabel_lansia" type="checkbox" value="1"
                                            {{ old('ada_difabel_lansia', $survey->ada_difabel_lansia) ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <label for="ada_difabel_lansia" class="ml-2 text-sm text-gray-700">Ada anggota difabel/lansia</label>
                                    </div>

                                    <div class="flex items-center">
                                        <input id="ada_sakit_menahun" name="ada_sakit_menahun" type="checkbox" value="1"
                                            {{ old('ada_sakit_menahun', $survey->ada_sakit_menahun) ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <label for="ada_sakit_menahun" class="ml-2 text-sm text-gray-700">Ada anggota sakit menahun</label>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Bantuan Pemerintah yang Diterima</label>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                        @php
                                        $bantuans = ['pkh', 'bpnt', 'blt', 'kip', 'kis'];
                                        $oldBantuans = old('bantuan_pemerintah', $survey->bantuan_pemerintah ?? []);
                                        @endphp
                                        @foreach($bantuans as $bantuan)
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="bantuan_pemerintah[]" value="{{ $bantuan }}"
                                                {{ in_array($bantuan, $oldBantuans) ? 'checked' : '' }}
                                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            <span class="ml-2 text-sm text-gray-700">{{ strtoupper($bantuan) }}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                    @error('bantuan_pemerintah')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- 7. Dokumentasi -->
                        <div class="mb-8 form-section" data-section="7">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3">7</span>
                                Dokumentasi
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="foto_depan_rumah" class="block text-sm font-medium text-gray-700 mb-2">Foto Depan Rumah</label>
                                    @if($survey->foto_depan_rumah)
                                    <div class="mb-2">
                                        <img src="{{ Storage::url($survey->foto_depan_rumah) }}" alt="Foto Depan Rumah" class="w-32 h-32 object-cover rounded-lg border">
                                        <p class="text-xs text-gray-500 mt-1">Foto saat ini</p>
                                    </div>
                                    @endif
                                    <input id="foto_depan_rumah" name="foto_depan_rumah" type="file" accept="image/*"
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('foto_depan_rumah') border-red-500 @enderror">
                                    <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah.</p>
                                    @error('foto_depan_rumah')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="foto_dalam_rumah" class="block text-sm font-medium text-gray-700 mb-2">Foto Dalam Rumah (Opsional)</label>
                                    @if($survey->foto_dalam_rumah)
                                    <div class="mb-2">
                                        <img src="{{ Storage::url($survey->foto_dalam_rumah) }}" alt="Foto Dalam Rumah" class="w-32 h-32 object-cover rounded-lg border">
                                        <p class="text-xs text-gray-500 mt-1">Foto saat ini</p>
                                    </div>
                                    @endif
                                    <input id="foto_dalam_rumah" name="foto_dalam_rumah" type="file" accept="image/*"
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('foto_dalam_rumah') border-red-500 @enderror">
                                    <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah.</p>
                                    @error('foto_dalam_rumah')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label for="catatan_tambahan" class="block text-sm font-medium text-gray-700 mb-2">Catatan Tambahan</label>
                                    <textarea id="catatan_tambahan" name="catatan_tambahan" rows="3"
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('catatan_tambahan') border-red-500 @enderror"
                                        placeholder="Catatan observasi atau informasi tambahan...">{{ old('catatan_tambahan', $survey->catatan_tambahan) }}</textarea>
                                    @error('catatan_tambahan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex flex-col sm:flex-row items-center justify-end space-y-4 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('petugas.surveys.index') }}"
                                class="w-full sm:w-auto bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg transition-colors text-center">
                                Batal
                            </a>

                            @if(in_array($survey->status_verifikasi, ['draft', 'rejected']))
                            <button type="submit" name="draft" value="1"
                                class="w-full sm:w-auto bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-6 rounded-lg transition-colors">
                                Simpan sebagai Draft
                            </button>

                            <button type="submit" name="submit" value="1"
                                class="w-full sm:w-auto bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition-colors">
                                Simpan & Kirim untuk Verifikasi
                            </button>
                            @else
                            <button type="submit"
                                class="w-full sm:w-auto bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition-colors">
                                Simpan Perubahan
                            </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Dependent Dropdown Logic
        document.getElementById('province_id').addEventListener('change', function() {
            const provinceId = this.value;
            const regencySelect = document.getElementById('regency_id');
            const districtSelect = document.getElementById('district_id');
            const villageSelect = document.getElementById('village_id');

            // Reset dependent dropdowns
            regencySelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
            districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
            villageSelect.innerHTML = '<option value="">Pilih Desa/Kelurahan</option>';

            regencySelect.disabled = true;
            districtSelect.disabled = true;
            villageSelect.disabled = true;

            if (provinceId && provinceId !== '' && !isNaN(provinceId)) {
                fetch(`/petugas/api/regencies/${provinceId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(regency => {
                            // ✅ PERBAIKAN: Gunakan variable PHP yang benar
                            const selected = regency.id == {
                                {
                                    old('regency_id', $survey - > neighborhood - > village - > district - > regency_id)
                                }
                            } ? 'selected' : '';
                            regencySelect.innerHTML += `<option value="${regency.id}" ${selected}>${regency.name}</option>`;
                        });
                        regencySelect.disabled = false;

                        // Trigger change untuk load districts
                        if (regencySelect.value) {
                            regencySelect.dispatchEvent(new Event('change'));
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

            updateAddressPreview();
        });

        document.getElementById('regency_id').addEventListener('change', function() {
            const regencyId = this.value;
            const districtSelect = document.getElementById('district_id');
            const villageSelect = document.getElementById('village_id');

            districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
            villageSelect.innerHTML = '<option value="">Pilih Desa/Kelurahan</option>';

            districtSelect.disabled = true;
            villageSelect.disabled = true;

            if (regencyId && regencyId !== '' && !isNaN(regencyId)) {
                fetch(`/petugas/api/districts/${regencyId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(district => {
                            // ✅ PERBAIKAN: Syntax yang benar
                            const selected = district.id == {
                                {
                                    old('district_id', $survey - > neighborhood - > village - > district_id)
                                }
                            } ? 'selected' : '';
                            districtSelect.innerHTML += `<option value="${district.id}" ${selected}>${district.name}</option>`;
                        });
                        districtSelect.disabled = false;

                        // Trigger change untuk load villages
                        if (districtSelect.value) {
                            districtSelect.dispatchEvent(new Event('change'));
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

            updateAddressPreview();
        });

        document.getElementById('district_id').addEventListener('change', function() {
            const districtId = this.value;
            const villageSelect = document.getElementById('village_id');

            villageSelect.innerHTML = '<option value="">Pilih Desa/Kelurahan</option>';
            villageSelect.disabled = true;

            if (districtId && districtId !== '' && !isNaN(districtId)) {
                fetch(`/petugas/api/villages/${districtId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(village => {
                            // ✅ PERBAIKAN: Syntax yang benar
                            const selected = village.id == {
                                {
                                    old('village_id', $survey - > neighborhood - > village_id)
                                }
                            } ? 'selected' : '';
                            villageSelect.innerHTML += `<option value="${village.id}" ${selected}>${village.name}</option>`;
                        });
                        villageSelect.disabled = false;
                    })
                    .catch(error => console.error('Error:', error));
            }

            updateAddressPreview();
        });

        // Initialize dependent dropdowns on page load
        document.addEventListener('DOMContentLoaded', function() {
            const provinceSelect = document.getElementById('province_id');
            if (provinceSelect.value) {
                provinceSelect.dispatchEvent(new Event('change'));
            }
        });

        // Address preview and other functions
        document.getElementById('village_id').addEventListener('change', updateAddressPreview);
        document.getElementById('rt').addEventListener('input', updateAddressPreview);
        document.getElementById('rw').addEventListener('input', updateAddressPreview);

        function updateAddressPreview() {
            const province = document.getElementById('province_id');
            const regency = document.getElementById('regency_id');
            const district = document.getElementById('district_id');
            const village = document.getElementById('village_id');
            const rt = document.getElementById('rt').value;
            const rw = document.getElementById('rw').value;

            const preview = document.getElementById('address-preview');
            const previewText = document.getElementById('preview-address');

            if (province.value && regency.value && district.value && village.value && rt && rw) {
                const addressParts = [
                    `RT ${rt.padStart(3, '0')}/RW ${rw.padStart(3, '0')}`,
                    village.options[village.selectedIndex]?.text,
                    district.options[district.selectedIndex]?.text,
                    regency.options[regency.selectedIndex]?.text,
                    province.options[province.selectedIndex]?.text
                ].filter(part => part && part !== 'Pilih Provinsi' && part !== 'Pilih Kabupaten/Kota' && part !== 'Pilih Kecamatan' && part !== 'Pilih Desa/Kelurahan');

                previewText.textContent = addressParts.join(', ');
                preview.classList.remove('hidden');
            } else {
                preview.classList.add('hidden');
            }
        }

        // Auto-format RT/RW
        document.getElementById('rt').addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            if (value.length > 0) {
                this.value = value.substring(0, 3);
            }
        });

        document.getElementById('rw').addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            if (value.length > 0) {
                this.value = value.substring(0, 3);
            }
        });

        // GPS Location
        document.getElementById('getLocation').addEventListener('click', function() {
            const button = this;
            const originalText = button.innerHTML;

            button.innerHTML = '<svg class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Mengambil Lokasi...';
            button.disabled = true;

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        document.getElementById('latitude').value = position.coords.latitude;
                        document.getElementById('longitude').value = position.coords.longitude;

                        button.innerHTML = originalText;
                        button.disabled = false;

                        alert('Koordinat GPS berhasil diperbarui!');
                    },
                    function(error) {
                        button.innerHTML = originalText;
                        button.disabled = false;

                        let errorMessage = 'Gagal mengambil lokasi: ';
                        switch (error.code) {
                            case error.PERMISSION_DENIED:
                                errorMessage += 'Izin lokasi ditolak';
                                break;
                            case error.POSITION_UNAVAILABLE:
                                errorMessage += 'Lokasi tidak tersedia';
                                break;
                            case error.TIMEOUT:
                                errorMessage += 'Timeout';
                                break;
                            default:
                                errorMessage += 'Error tidak dikenal';
                                break;
                        }
                        alert(errorMessage);
                    }, {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            } else {
                button.innerHTML = originalText;
                button.disabled = false;
                alert('Browser tidak mendukung geolocation');
            }
        });

        // Progress tracking
        function updateProgress() {
            const sections = document.querySelectorAll('.form-section');
            let completedSections = 0;

            sections.forEach(section => {
                const inputs = section.querySelectorAll('input[required], select[required], textarea[required]');
                let sectionComplete = true;

                inputs.forEach(input => {
                    if (!input.value.trim()) {
                        sectionComplete = false;
                    }
                });

                if (sectionComplete) {
                    completedSections++;
                }
            });

            const progressPercent = (completedSections / sections.length) * 100;
            document.getElementById('progressBar').style.width = progressPercent + '%';
            document.getElementById('progressText').textContent = `${completedSections}/${sections.length} Bagian`;
        }

        // Update progress on input change
        document.addEventListener('input', updateProgress);
        document.addEventListener('change', updateProgress);

        // Initial progress check
        updateProgress();

        // Form validation before submit
        document.getElementById('surveyForm').addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('input[required], select[required], textarea[required]');
            let hasError = false;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('border-red-500');
                    hasError = true;
                } else {
                    field.classList.remove('border-red-500');
                }
            });

            if (hasError) {
                e.preventDefault();
                alert('Mohon lengkapi semua field yang wajib diisi');
                return false;
            }

            // Confirm submission
            const submitButton = e.submitter;
            if (submitButton && submitButton.name === 'submit') {
                if (!confirm('Apakah Anda yakin ingin mengirim survei ini untuk verifikasi? Data yang sudah dikirim tidak dapat diubah kecuali ditolak oleh admin.')) {
                    e.preventDefault();
                    return false;
                }
            }
        });

        // Auto-save draft functionality (optional)
        let autoSaveTimeout;

        function autoSaveDraft() {
            clearTimeout(autoSaveTimeout);
            autoSaveTimeout = setTimeout(() => {
                const formData = new FormData(document.getElementById('surveyForm'));
                formData.append('auto_save', '1');

                fetch('{{ route("petugas.surveys.update", $survey) }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log('Auto-save successful');
                        }
                    })
                    .catch(error => {
                        console.error('Auto-save failed:', error);
                    });
            }, 30000); // Auto-save setiap 30 detik
        }

        // Enable auto-save for draft surveys
        @if($survey -> status_verifikasi === 'draft')
        document.addEventListener('input', autoSaveDraft);
        document.addEventListener('change', autoSaveDraft);
        @endif

        // Image preview functionality
        document.getElementById('foto_depan_rumah').addEventListener('change', function(e) {
            previewImage(e.target, 'preview-foto-depan');
        });

        document.getElementById('foto_dalam_rumah').addEventListener('change', function(e) {
            previewImage(e.target, 'preview-foto-dalam');
        });

        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    let preview = document.getElementById(previewId);
                    if (!preview) {
                        preview = document.createElement('img');
                        preview.id = previewId;
                        preview.className = 'mt-2 w-32 h-32 object-cover rounded-lg border';
                        input.parentNode.appendChild(preview);
                    }
                    preview.src = e.target.result;
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 's') {
                e.preventDefault();
                @if(in_array($survey -> status_verifikasi, ['draft', 'rejected']))
                const draftButton = document.querySelector('button[name="draft"]');
                if (draftButton) draftButton.click();
                @else
                const submitButton = document.querySelector('button[type="submit"]');
                if (submitButton) submitButton.click();
                @endif
            }

            if (e.ctrlKey && e.key === 'Enter') {
                e.preventDefault();
                @if(in_array($survey -> status_verifikasi, ['draft', 'rejected']))
                const submitButton = document.querySelector('button[name="submit"]');
                if (submitButton) submitButton.click();
                @endif
            }
        });

        // Warning for unsaved changes
        let formChanged = false;
        document.addEventListener('input', () => formChanged = true);
        document.addEventListener('change', () => formChanged = true);

        window.addEventListener('beforeunload', function(e) {
            if (formChanged && {
                    {
                        $survey - > status_verifikasi === 'draft' ? 'true' : 'false'
                    }
                }) {
                e.preventDefault();
                e.returnValue = 'Anda memiliki perubahan yang belum disimpan. Apakah Anda yakin ingin meninggalkan halaman?';
            }
        });

        // Reset form changed flag on successful submit
        document.getElementById('surveyForm').addEventListener('submit', function() {
            formChanged = false;
        });

        // Enhanced validation messages
        function showValidationError(field, message) {
            // Remove existing error message
            const existingError = field.parentNode.querySelector('.validation-error');
            if (existingError) {
                existingError.remove();
            }

            // Add new error message
            const errorDiv = document.createElement('div');
            errorDiv.className = 'validation-error mt-1 text-sm text-red-600';
            errorDiv.textContent = message;
            field.parentNode.appendChild(errorDiv);

            // Add error styling
            field.classList.add('border-red-500');

            // Remove error after user starts typing
            field.addEventListener('input', function() {
                field.classList.remove('border-red-500');
                if (errorDiv) {
                    errorDiv.remove();
                }
            }, {
                once: true
            });
        }

        // Custom validation for specific fields
        document.getElementById('nik').addEventListener('blur', function() {
            const nik = this.value.trim();
            if (nik && nik.length !== 16) {
                showValidationError(this, 'NIK harus terdiri dari 16 digit');
            }
        });

        document.getElementById('penghasilan_bulanan').addEventListener('blur', function() {
            const value = parseInt(this.value);
            if (value && value < 0) {
                showValidationError(this, 'Penghasilan tidak boleh negatif');
            }
        });

        document.getElementById('luas_rumah').addEventListener('blur', function() {
            const value = parseInt(this.value);
            if (value && (value < 1 || value > 1000)) {
                showValidationError(this, 'Luas rumah harus antara 1-1000 m²');
            }
        });

        // Initialize tooltips and help text
        document.querySelectorAll('[data-tooltip]').forEach(element => {
            element.addEventListener('mouseenter', function() {
                const tooltip = document.createElement('div');
                tooltip.className = 'absolute z-50 px-3 py-2 text-sm text-white bg-gray-900 rounded-lg shadow-lg';
                tooltip.textContent = this.getAttribute('data-tooltip');
                tooltip.style.top = this.offsetTop + this.offsetHeight + 5 + 'px';
                tooltip.style.left = this.offsetLeft + 'px';
                this.parentNode.appendChild(tooltip);

                this.addEventListener('mouseleave', function() {
                    tooltip.remove();
                }, {
                    once: true
                });
            });
        });

        console.log('Edit surveys form initialized successfully');
    </script>
    @endpush
</x-layouts.petugas>