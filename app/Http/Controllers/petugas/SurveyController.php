<?php
// app/Http/Controllers/Petugas/SurveyController.php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\PoorFamily;
use App\Models\Neighborhood;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use App\Models\PovertyCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use App\Models\PublicFacility;
use App\Models\MainRoad;

class SurveyController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();

        $stats = [
            'total_surveys' => $user->surveys()->count(),
            'draft_surveys' => $user->surveys()->draft()->count(),
            'submitted_surveys' => $user->surveys()->submitted()->count(),
            'verified_surveys' => $user->surveys()->verified()->count(),
            'rejected_surveys' => $user->surveys()->where('status_verifikasi', 'rejected')->count(),
        ];

        $recentSurveys = $user->surveys()
            ->with('neighborhood.village')
            ->latest()
            ->take(10)
            ->get();

        $monthlyProgress = $user->surveys()
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->where('created_at', '>=', Carbon::now()->startOfYear())
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $wilayahStats = [];
        if ($user->wilayah_kerja) {
            foreach ($user->wilayah_kerja as $villageId) {
                $village = Village::find($villageId);
                if ($village) {
                    $surveyCount = $user->surveys()
                        ->whereHas('neighborhood', function ($q) use ($villageId) {
                            $q->where('village_id', $villageId);
                        })
                        ->count();

                    $wilayahStats[] = [
                        'village' => $village->name,
                        'count' => $surveyCount
                    ];
                }
            }
        }

        return view('petugas.dashboard', compact('stats', 'recentSurveys', 'monthlyProgress', 'wilayahStats'));
    }

    public function index(Request $request)
    {
        $query = auth()->user()->surveys()->with(['neighborhood.village', 'verifier']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_kepala_keluarga', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('alamat_lengkap', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status_verifikasi', $request->status);
        }

        if ($request->filled('village_id')) {
            $query->whereHas('neighborhood', function ($q) use ($request) {
                $q->where('village_id', $request->village_id);
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        $surveys = $query->paginate(15);

        $villages = collect();
        if (auth()->user()->wilayah_kerja) {
            $villages = Village::whereIn('id', auth()->user()->wilayah_kerja)->get();
        }

        return view('petugas.surveys.index', compact('surveys', 'villages'));
    }

    public function create()
    {
        // ✅ PERBAIKAN: Hapus filter wilayah kerja - ambil semua provinces
        $provinces = Province::orderBy('name')->get();

        return view('petugas.surveys.create', compact('provinces'));
    }

    public function getRegencies(Request $request, $province)
    {
        try {
            if (!$province || !is_numeric($province)) {
                return response()->json([
                    'error' => 'Invalid province parameter',
                    'received' => $province
                ], 400);
            }

            $regencies = Regency::where('province_id', $province)
                ->orderBy('name')
                ->get(['id', 'name']);

            // ✅ PERBAIKAN: Hapus filter wilayah kerja
            // if (auth()->user()->wilayah_kerja) {
            //     // Filter logic removed
            // }

            return response()->json($regencies->values());
        } catch (\Exception $e) {
            \Log::error('Error in getRegencies: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load regencies'], 500);
        }
    }

    public function getDistricts(Request $request, $regencyId)
    {
        try {
            $districts = District::where('regency_id', $regencyId)
                ->orderBy('name')
                ->get(['id', 'name']);

            // ✅ PERBAIKAN: Hapus filter wilayah kerja
            // if (auth()->user()->wilayah_kerja) {
            //     // Filter logic removed
            // }

            return response()->json($districts->values());
        } catch (\Exception $e) {
            \Log::error('Error in getDistricts: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load districts'], 500);
        }
    }

    public function getVillages(Request $request, $districtId)
    {
        try {
            $villages = Village::where('district_id', $districtId)
                ->orderBy('name')
                ->get(['id', 'name']);

            // ✅ PERBAIKAN: Hapus filter wilayah kerja
            // if (auth()->user()->wilayah_kerja) {
            //     $villages = $villages->whereIn('id', auth()->user()->wilayah_kerja);
            // }

            return response()->json($villages->values());
        } catch (\Exception $e) {
            \Log::error('Error in getVillages: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load villages'], 500);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kepala_keluarga' => 'required|string|max:255',
            'nik' => 'nullable|string|max:16|unique:poor_families,nik',
            'jumlah_anggota_keluarga' => 'required|integer|min:1|max:20',
            'jenis_kelamin_kk' => 'required|in:L,P',
            'status_keluarga' => 'required|in:tetap,pendatang,korban_bencana,lainnya',

            // ✅ Dependent dropdown validation
            'province_id' => 'required|exists:provinces,id',
            'regency_id' => 'required|exists:regencies,id',
            'district_id' => 'required|exists:districts,id',
            'village_id' => 'required|exists:villages,id',
            'rt' => 'required|string|max:10|regex:/^[0-9]{1,3}$/',
            'rw' => 'required|string|max:10|regex:/^[0-9]{1,3}$/',

            'alamat_lengkap' => 'required|string|max:500',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'tipe_tempat_tinggal' => 'required|in:rumah_pribadi,sewa,menumpang',
            'sumber_penghasilan' => 'required|in:bertani,buruh,dagang,tidak_ada,lainnya',
            'penghasilan_bulanan' => 'nullable|numeric|min:0',
            'status_kepemilikan' => 'required|in:milik_sendiri,sewa,tidak_punya',
            'aset_utama' => 'nullable|array',
            'jenis_bangunan' => 'required|in:permanen,semi_permanen,tidak_layak',
            'luas_rumah' => 'nullable|integer|min:1',
            'lantai_rumah' => 'required|in:tanah,semen,keramik',
            'dinding_rumah' => 'required|in:kayu,tembok,anyaman_bambu,seng',
            'atap_rumah' => 'required|in:genteng,seng,rumbia,plastik',
            'sumber_air' => 'required|in:sumur,pdam,sungai',
            'sumber_listrik' => 'required|in:pln,genset,tidak_ada',
            'akses_sekolah' => 'required|in:kurang_1km,1_3km,lebih_3km',
            'akses_kesehatan' => 'required|in:puskesmas,rs,tidak_ada',
            'akses_jalan' => 'required|in:bisa_motor_mobil,tidak_bisa',
            'anak_tidak_sekolah' => 'boolean',
            'ada_difabel_lansia' => 'boolean',
            'ada_sakit_menahun' => 'boolean',
            'bantuan_pemerintah' => 'nullable|array',
            'foto_depan_rumah' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'foto_dalam_rumah' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'catatan_tambahan' => 'nullable|string|max:1000',
        ]);

        // ✅ Validasi hierarki wilayah
        $this->validateLocationHierarchy($validated);

        // ✅ Validasi wilayah kerja petugas
        if (auth()->user()->wilayah_kerja && !in_array($validated['village_id'], auth()->user()->wilayah_kerja)) {
            return back()->withErrors([
                'village_id' => 'Anda tidak memiliki akses untuk survei di desa ini'
            ])->withInput();
        }

        $status = $request->input('submit') ? 'submitted' : 'draft';

        DB::transaction(function () use ($validated, $request, $status) {
            // ✅ Find or Create Neighborhood dengan auto-formatting
            $neighborhood = Neighborhood::findOrCreateByInput(
                $validated['rt'],
                $validated['rw'],
                $validated['village_id']
            );

            // Handle file uploads
            if ($request->hasFile('foto_depan_rumah')) {
                $validated['foto_depan_rumah'] = $request->file('foto_depan_rumah')
                    ->store('photos/front', 'public');
            }

            if ($request->hasFile('foto_dalam_rumah')) {
                $validated['foto_dalam_rumah'] = $request->file('foto_dalam_rumah')
                    ->store('photos/inside', 'public');
            }

            // ✅ Set data yang diperlukan
            $validated['neighborhood_id'] = $neighborhood->id;
            $validated['surveyor_id'] = auth()->id();
            $validated['status_verifikasi'] = $status;

            // ✅ Remove fields yang tidak perlu disimpan di poor_families table
            unset($validated['province_id'], $validated['regency_id'], $validated['district_id'], $validated['village_id'], $validated['rt'], $validated['rw']);

            $poorFamily = PoorFamily::create($validated);
            $this->calculatePovertyCategories($poorFamily);
        });

        $message = $status === 'submitted'
            ? 'Data berhasil disimpan dan dikirim untuk verifikasi'
            : 'Data berhasil disimpan sebagai draft';

        return redirect()->route('petugas.surveys.index')->with('success', $message);
    }

    public function show(PoorFamily $survey)
    {

        $survey->load(['neighborhood.village.district', 'surveyor', 'verifier', 'categories']);

        return view('petugas.surveys.show', compact('survey'));
    }

    public function edit(PoorFamily $survey)
    {
        Gate::authorize('update', $survey);

        // ✅ Load data untuk edit dengan hierarki lengkap
        $survey->load('neighborhood.village.district.regency.province');

        $provinces = Province::orderBy('name')->get();

        // ✅ Load data existing berdasarkan survey
        $regencies = Regency::where('province_id', $survey->neighborhood->village->district->regency->province_id)
            ->orderBy('name')
            ->get();

        $districts = District::where('regency_id', $survey->neighborhood->village->district->regency_id)
            ->orderBy('name')
            ->get();

        $villages = Village::where('district_id', $survey->neighborhood->village->district_id)
            ->orderBy('name')
            ->get();

        // ✅ Filter berdasarkan wilayah kerja
        if (auth()->user()->wilayah_kerja) {
            $villages = $villages->whereIn('id', auth()->user()->wilayah_kerja);
        }

        return view('petugas.surveys.edit', compact('survey', 'provinces', 'regencies', 'districts', 'villages'));
    }

    // ✅ Helper method untuk validasi hierarki
    private function validateLocationHierarchy($validated)
    {
        // Cek apakah regency belongs to province
        $regency = Regency::where('id', $validated['regency_id'])
            ->where('province_id', $validated['province_id'])
            ->first();

        if (!$regency) {
            throw new \Exception('Kabupaten/Kota tidak sesuai dengan Provinsi yang dipilih');
        }

        // Cek apakah district belongs to regency
        $district = District::where('id', $validated['district_id'])
            ->where('regency_id', $validated['regency_id'])
            ->first();

        if (!$district) {
            throw new \Exception('Kecamatan tidak sesuai dengan Kabupaten/Kota yang dipilih');
        }

        // Cek apakah village belongs to district
        $village = Village::where('id', $validated['village_id'])
            ->where('district_id', $validated['district_id'])
            ->first();

        if (!$village) {
            throw new \Exception('Desa/Kelurahan tidak sesuai dengan Kecamatan yang dipilih');
        }
    }

    public function update(Request $request, PoorFamily $survey)
    {
        // ✅ Gunakan Gate::authorize instead of $this->authorize
        Gate::authorize('update', $survey);

        $validated = $request->validate([
            'nama_kepala_keluarga' => 'required|string|max:255',
            'nik' => 'nullable|string|max:16|unique:poor_families,nik,' . $survey->id,
            'jumlah_anggota_keluarga' => 'required|integer|min:1|max:20',
            'jenis_kelamin_kk' => 'required|in:L,P',
            'status_keluarga' => 'required|in:tetap,pendatang,korban_bencana,lainnya',

            // ✅ Form input RT/RW manual untuk update
            'village_id' => 'required|exists:villages,id',
            'rt' => 'required|string|max:3|regex:/^[0-9]{1,3}$/',
            'rw' => 'required|string|max:3|regex:/^[0-9]{1,3}$/',

            'alamat_lengkap' => 'required|string|max:500',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'tipe_tempat_tinggal' => 'required|in:rumah_pribadi,sewa,menumpang',
            'sumber_penghasilan' => 'required|in:bertani,buruh,dagang,tidak_ada,lainnya',
            'penghasilan_bulanan' => 'nullable|numeric|min:0',
            'status_kepemilikan' => 'required|in:milik_sendiri,sewa,tidak_punya',
            'aset_utama' => 'nullable|array',
            'jenis_bangunan' => 'required|in:permanen,semi_permanen,tidak_layak',
            'luas_rumah' => 'nullable|integer|min:1',
            'lantai_rumah' => 'required|in:tanah,semen,keramik',
            'dinding_rumah' => 'required|in:kayu,tembok,anyaman_bambu,seng',
            'atap_rumah' => 'required|in:genteng,seng,rumbia,plastik',
            'sumber_air' => 'required|in:sumur,pdam,sungai',
            'sumber_listrik' => 'required|in:pln,genset,tidak_ada',
            'akses_sekolah' => 'required|in:kurang_1km,1_3km,lebih_3km',
            'akses_kesehatan' => 'required|in:puskesmas,rs,tidak_ada',
            'akses_jalan' => 'required|in:bisa_motor_mobil,tidak_bisa',
            'anak_tidak_sekolah' => 'boolean',
            'ada_difabel_lansia' => 'boolean',
            'ada_sakit_menahun' => 'boolean',
            'bantuan_pemerintah' => 'nullable|array',
            'foto_depan_rumah' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_dalam_rumah' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'catatan_tambahan' => 'nullable|string|max:1000',
        ]);

        // ✅ Enhanced validation untuk RT/RW
        if (!Neighborhood::validateRtRw($validated['rt'], $validated['rw'])) {
            return back()->withErrors([
                'rt' => 'Format RT tidak valid (harus 001-999)',
                'rw' => 'Format RW tidak valid (harus 001-999)'
            ])->withInput();
        }

        $newStatus = $survey->status_verifikasi;

        if (in_array($survey->status_verifikasi, ['draft', 'rejected'])) {
            if ($request->has('submit') && $request->input('submit')) {
                $newStatus = 'submitted';
            } else {
                $newStatus = 'draft';
            }
        }

        DB::transaction(function () use ($validated, $request, $survey, $newStatus) {
            // ✅ Handle RT/RW update dengan auto-create
            $neighborhood = Neighborhood::findOrCreateByInput(
                $validated['rt'],
                $validated['rw'],
                $validated['village_id']
            );

            // Handle file uploads
            if ($request->hasFile('foto_depan_rumah')) {
                if ($survey->foto_depan_rumah) {
                    Storage::disk('public')->delete($survey->foto_depan_rumah);
                }
                $validated['foto_depan_rumah'] = $request->file('foto_depan_rumah')
                    ->store('photos/front', 'public');
            }

            if ($request->hasFile('foto_dalam_rumah')) {
                if ($survey->foto_dalam_rumah) {
                    Storage::disk('public')->delete($survey->foto_dalam_rumah);
                }
                $validated['foto_dalam_rumah'] = $request->file('foto_dalam_rumah')
                    ->store('photos/inside', 'public');
            }

            $validated['neighborhood_id'] = $neighborhood->id;
            $validated['status_verifikasi'] = $newStatus;

            if ($newStatus === 'submitted') {
                $validated['verified_by'] = null;
                $validated['verified_at'] = null;
                $validated['rejection_reason'] = null;
            }

            // ✅ Remove fields yang tidak perlu
            unset($validated['rt'], $validated['rw'], $validated['village_id']);

            $survey->update($validated);
            $this->calculatePovertyCategories($survey);
        });

        $message = $newStatus === 'submitted'
            ? 'Data berhasil diperbarui dan dikirim untuk verifikasi'
            : 'Data berhasil diperbarui';

        return redirect()->route('petugas.surveys.index')->with('success', $message);
    }

    public function destroy(PoorFamily $survey)
    {
        // ✅ Gunakan Gate::authorize instead of $this->authorize
        Gate::authorize('delete', $survey);

        DB::transaction(function () use ($survey) {
            if ($survey->foto_depan_rumah) {
                Storage::disk('public')->delete($survey->foto_depan_rumah);
            }
            if ($survey->foto_dalam_rumah) {
                Storage::disk('public')->delete($survey->foto_dalam_rumah);
            }

            $survey->categories()->delete();
            $survey->delete();
        });

        return redirect()->route('petugas.surveys.index')
            ->with('success', 'Data survei berhasil dihapus');
    }

    public function map()
    {
        $user = auth()->user();

        // ✅ Ambil data survei dengan relasi lengkap
        $surveys = $user->surveys()
            ->with([
                'neighborhood.village.district.regency.province',
                'surveyor',
                'verifier',
                'categories'
            ])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        // ✅ Data wilayah kerja (jika masih diperlukan untuk display)
        $workAreaVillages = collect();
        if ($user->wilayah_kerja) {
            $workAreaVillages = Village::whereIn('id', $user->wilayah_kerja)
                ->with('district.regency.province')
                ->get();
        }

        // ✅ Tambahkan data fasilitas umum dan jalan utama untuk petugas
        $publicFacilities = PublicFacility::with('village.district.regency.province')
            ->whereHas('village', function ($query) use ($user) {
                if ($user->wilayah_kerja) {
                    $query->whereIn('id', $user->wilayah_kerja);
                }
            })
            ->get();

        $mainRoads = MainRoad::with('village.district.regency.province')
            ->whereHas('village', function ($query) use ($user) {
                if ($user->wilayah_kerja) {
                    $query->whereIn('id', $user->wilayah_kerja);
                }
            })
            ->get();

        // ✅ Statistik untuk petugas
        $statistics = [
            'total_surveys' => $surveys->count(),
            'draft_surveys' => $surveys->where('status_verifikasi', 'draft')->count(),
            'submitted_surveys' => $surveys->where('status_verifikasi', 'submitted')->count(),
            'verified_surveys' => $surveys->where('status_verifikasi', 'verified')->count(),
            'rejected_surveys' => $surveys->where('status_verifikasi', 'rejected')->count(),
            'sangat_miskin' => $surveys->where('poverty_level', 'Sangat Miskin')->count(),
            'miskin' => $surveys->where('poverty_level', 'Miskin')->count(),
            'rentan_miskin' => $surveys->where('poverty_level', 'Rentan Miskin')->count(),
            'tidak_miskin' => $surveys->where('poverty_level', 'Tidak Miskin')->count(),
        ];

        return view('petugas.surveys.map', compact(
            'surveys',
            'workAreaVillages',
            'publicFacilities',
            'mainRoads',
            'statistics'
        ));
    }

    public function submitForVerification(PoorFamily $survey)
    {
        // ✅ Gunakan Gate::authorize instead of $this->authorize
        Gate::authorize('update', $survey);

        if ($survey->status_verifikasi === 'draft') {
            $survey->update([
                'status_verifikasi' => 'submitted',
                'verified_by' => null,
                'verified_at' => null,
                'rejection_reason' => null
            ]);

            return redirect()->back()->with('success', 'Survei berhasil dikirim untuk verifikasi');
        }

        return redirect()->back()->with('error', 'Survei tidak dapat dikirim');
    }

    public function duplicate(PoorFamily $survey)
    {
        // ✅ Gunakan Gate::authorize instead of $this->authorize
        Gate::authorize('view', $survey);

        $newSurvey = null;

        DB::transaction(function () use ($survey, &$newSurvey) {
            $newSurvey = $survey->replicate();
            $newSurvey->status_verifikasi = 'draft';
            $newSurvey->verified_by = null;
            $newSurvey->verified_at = null;
            $newSurvey->rejection_reason = null;
            $newSurvey->foto_depan_rumah = null;
            $newSurvey->foto_dalam_rumah = null;
            $newSurvey->save();

            foreach ($survey->categories as $category) {
                $newCategory = $category->replicate();
                $newCategory->poor_family_id = $newSurvey->id;
                $newCategory->save();
            }
        });

        return redirect()->route('petugas.surveys.edit', $newSurvey)
            ->with('success', 'Survei berhasil diduplikasi');
    }

    public function statistics()
    {
        $user = auth()->user();

        $stats = [
            'monthly_surveys' => $user->surveys()
                ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, COUNT(*) as total')
                ->where('created_at', '>=', Carbon::now()->subMonths(12))
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->get(),

            'poverty_distribution' => $user->surveys()
                ->verified()
                ->get()
                ->groupBy('poverty_level')
                ->map->count(),

            'village_distribution' => $user->surveys()
                ->with('neighborhood.village')
                ->get()
                ->groupBy('neighborhood.village.name')
                ->map->count(),
        ];

        return view('petugas.statistics', compact('stats'));
    }

    // ✅ Private methods tetap sama
    private function calculatePovertyCategories(PoorFamily $family)
    {
        $family->categories()->delete();

        $categories = [
            'ekonomi' => $this->calculateEconomicScore($family),
            'kesehatan' => $this->calculateHealthScore($family),
            'sanitasi' => $this->calculateSanitationScore($family),
            'pendidikan' => $this->calculateEducationScore($family),
            'infrastruktur' => $this->calculateInfrastructureScore($family),
        ];

        foreach ($categories as $kategori => $skor) {
            $family->categories()->create([
                'kategori' => $kategori,
                'skor' => $skor,
                'keterangan' => $this->getCategoryDescription($kategori, $skor)
            ]);
        }
    }

    private function calculateEconomicScore(PoorFamily $family): int
    {
        $score = 1;

        if ($family->sumber_penghasilan === 'tidak_ada') $score = 5;
        elseif ($family->sumber_penghasilan === 'buruh') $score = 4;
        elseif ($family->sumber_penghasilan === 'bertani') $score = 3;
        elseif ($family->sumber_penghasilan === 'dagang') $score = 2;

        if ($family->penghasilan_bulanan) {
            if ($family->penghasilan_bulanan < 500000) $score = min($score + 2, 5);
            elseif ($family->penghasilan_bulanan < 1000000) $score = min($score + 1, 5);
        }

        if ($family->status_kepemilikan === 'tidak_punya') $score = min($score + 1, 5);

        if (!$family->aset_utama || in_array('tidak_ada', $family->aset_utama)) {
            $score = min($score + 1, 5);
        }

        return $score;
    }

    private function calculateHealthScore(PoorFamily $family): int
    {
        $score = 1;

        if ($family->akses_kesehatan === 'tidak_ada') $score = 5;
        elseif ($family->akses_kesehatan === 'rs') $score = 2;
        elseif ($family->akses_kesehatan === 'puskesmas') $score = 3;

        if ($family->ada_sakit_menahun) $score = min($score + 1, 5);
        if ($family->ada_difabel_lansia) $score = min($score + 1, 5);

        return $score;
    }

    private function calculateSanitationScore(PoorFamily $family): int
    {
        $score = 1;

        if ($family->sumber_air === 'sungai') $score = 4;
        elseif ($family->sumber_air === 'sumur') $score = 2;

        if ($family->lantai_rumah === 'tanah') $score = min($score + 2, 5);

        if ($family->jenis_bangunan === 'tidak_layak') $score = min($score + 2, 5);

        return $score;
    }

    private function calculateEducationScore(PoorFamily $family): int
    {
        $score = 1;

        if ($family->anak_tidak_sekolah) $score = 5;

        if ($family->akses_sekolah === 'lebih_3km') $score = min($score + 2, 5);
        elseif ($family->akses_sekolah === '1_3km') $score = min($score + 1, 5);

        return $score;
    }

    private function calculateInfrastructureScore(PoorFamily $family): int
    {
        $score = 1;

        if ($family->sumber_listrik === 'tidak_ada') $score = 5;
        elseif ($family->sumber_listrik === 'genset') $score = 3;

        if ($family->akses_jalan === 'tidak_bisa') $score = min($score + 2, 5);

        if ($family->jenis_bangunan === 'tidak_layak') $score = min($score + 1, 5);

        return $score;
    }

    private function getCategoryDescription(string $kategori, int $skor): string
    {
        $descriptions = [
            'ekonomi' => [
                1 => 'Kondisi ekonomi sangat baik',
                2 => 'Kondisi ekonomi baik',
                3 => 'Kondisi ekonomi sedang',
                4 => 'Kondisi ekonomi kurang',
                5 => 'Kondisi ekonomi sangat kurang'
            ],
            'kesehatan' => [
                1 => 'Akses kesehatan sangat baik',
                2 => 'Akses kesehatan baik',
                3 => 'Akses kesehatan sedang',
                4 => 'Akses kesehatan kurang',
                5 => 'Akses kesehatan sangat kurang'
            ],
            'sanitasi' => [
                1 => 'Sanitasi sangat baik',
                2 => 'Sanitasi baik',
                3 => 'Sanitasi sedang',
                4 => 'Sanitasi kurang',
                5 => 'Sanitasi sangat kurang'
            ],
            'pendidikan' => [
                1 => 'Akses pendidikan sangat baik',
                2 => 'Akses pendidikan baik',
                3 => 'Akses pendidikan sedang',
                4 => 'Akses pendidikan kurang',
                5 => 'Akses pendidikan sangat kurang'
            ],
            'infrastruktur' => [
                1 => 'Infrastruktur sangat baik',
                2 => 'Infrastruktur baik',
                3 => 'Infrastruktur sedang',
                4 => 'Infrastruktur kurang',
                5 => 'Infrastruktur sangat kurang'
            ]
        ];

        return $descriptions[$kategori][$skor] ?? 'Tidak ada keterangan';
    }
}
