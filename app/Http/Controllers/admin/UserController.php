<?php
// app/Http/Controllers/Admin/UserController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::petugasLapangan()->with('creator')->withCount('surveys');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Sort
        $allowedSorts = ['name', 'email', 'created_at', 'surveys_count'];
        $sortBy = in_array($request->get('sort'), $allowedSorts) ? $request->get('sort') : 'created_at';
        $sortDirection = in_array($request->get('direction'), ['asc', 'desc']) ? $request->get('direction') : 'desc';

        $query->orderBy($sortBy, $sortDirection);

        $users = $query->paginate(15)->withQueryString(); // ✅ Preserve query parameters

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        // ✅ PERBAIKAN: Hapus pembatasan wilayah kerja - ambil semua villages
        $villages = Village::with('district.regency.province')->orderBy('name')->get();
        return view('admin.users.create', compact('villages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'nip' => ['nullable', 'string', 'max:30', 'unique:users,nip'],
            // ✅ PERBAIKAN: Hapus validasi wilayah_kerja
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        DB::transaction(function () use ($request) {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'nip' => $request->nip,
                'role' => 'petugas_lapangan',
                // ✅ PERBAIKAN: Set wilayah_kerja sebagai null (tidak ada pembatasan)
                'wilayah_kerja' => null,
                'password' => Hash::make($request->password),
                'created_by' => auth()->id(),
                'is_active' => true,
            ]);
        });

        return redirect()->route('admin.users.index')
            ->with('success', 'Petugas lapangan berhasil ditambahkan');
    }

    public function show(User $user)
    {
        $user->load(['surveys' => function ($query) {
            $query->with('neighborhood.village')->latest()->take(10);
        }, 'creator']);

        // Calculate statistics
        $stats = [
            'total_surveys' => $user->surveys()->count(),
            'draft_surveys' => $user->surveys()->draft()->count(),
            'submitted_surveys' => $user->surveys()->submitted()->count(),
            'verified_surveys' => $user->surveys()->verified()->count(),
            'rejected_surveys' => $user->surveys()->where('status_verifikasi', 'rejected')->count(),
        ];

        // Performance metrics
        $performance = [
            'avg_surveys_per_month' => $this->calculateAvgSurveysPerMonth($user),
            'verification_rate' => $this->calculateVerificationRate($user),
            'last_activity' => $user->surveys()->latest()->first()?->created_at,
        ];

        return view('admin.users.show', compact('user', 'stats', 'performance'));
    }

    public function edit(User $user)
    {
        // ✅ PERBAIKAN: Hapus pembatasan wilayah kerja - ambil semua villages
        $villages = Village::with('district.regency.province')->orderBy('name')->get();
        return view('admin.users.edit', compact('user', 'villages'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['required', 'string', 'max:20'],
            'nip' => ['nullable', 'string', 'max:30', 'unique:users,nip,' . $user->id],
            'is_active' => ['nullable', 'boolean'], // ✅ PERBAIKAN: Ubah ke nullable
        ]);

        DB::transaction(function () use ($request, $user) {
            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'nip' => $request->nip,
                'wilayah_kerja' => null,
            ];

            // ✅ PERBAIKAN: Handle is_active dengan benar
            if ($request->has('is_active')) {
                $updateData['is_active'] = $request->boolean('is_active');
            } else {
                // Jika checkbox tidak dicentang, set ke false
                $updateData['is_active'] = false;
            }

            $user->update($updateData);
        });

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'Data petugas berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        if ($user->surveys()->count() > 0) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Tidak dapat menghapus petugas yang memiliki data survei');
        }

        DB::transaction(function () use ($user) {
            $user->delete();
        });

        return redirect()->route('admin.users.index')
            ->with('success', 'Petugas berhasil dihapus');
    }

    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        DB::transaction(function () use ($request, $user) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        });

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'Password berhasil direset');
    }

    public function toggleStatus(User $user)
    {
        try {
            DB::transaction(function () use ($user) {
                $user->update([
                    'is_active' => !$user->is_active
                ]);
            });

            $status = $user->fresh()->is_active ? 'diaktifkan' : 'dinonaktifkan';
            return redirect()->back()->with('success', "Petugas berhasil {$status}");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengubah status petugas');
        }
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => ['required', 'in:activate,deactivate,delete'],
            'user_ids' => ['required', 'array', 'min:1'],
            'user_ids.*' => ['exists:users,id']
        ]);

        $users = User::whereIn('id', $request->user_ids)->petugasLapangan();

        DB::transaction(function () use ($request, $users) {
            switch ($request->action) {
                case 'activate':
                    $users->update(['is_active' => true]);
                    break;
                case 'deactivate':
                    $users->update(['is_active' => false]);
                    break;
                case 'delete':
                    // Check if any user has surveys
                    $usersWithSurveys = $users->withCount('surveys')->having('surveys_count', '>', 0)->count();
                    if ($usersWithSurveys > 0) {
                        throw new \Exception('Tidak dapat menghapus petugas yang memiliki data survei');
                    }
                    $users->delete();
                    break;
            }
        });

        $actionText = [
            'activate' => 'diaktifkan',
            'deactivate' => 'dinonaktifkan',
            'delete' => 'dihapus'
        ];

        return redirect()->back()->with('success', count($request->user_ids) . " petugas berhasil {$actionText[$request->action]}");
    }

    private function calculateAvgSurveysPerMonth(User $user)
    {
        $monthsActive = $user->created_at->diffInMonths(now()) ?: 1;
        $totalSurveys = $user->surveys()->count();

        return round($totalSurveys / $monthsActive, 1);
    }

    private function calculateVerificationRate(User $user)
    {
        $totalSubmitted = $user->surveys()->whereIn('status_verifikasi', ['verified', 'rejected'])->count();
        $verified = $user->surveys()->verified()->count();

        return $totalSubmitted > 0 ? round(($verified / $totalSubmitted) * 100, 1) : 0;
    }
}
