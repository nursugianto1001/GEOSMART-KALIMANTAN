{{-- resources/views/admin/users/show.blade.php --}}
<x-layouts.admin>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.users.index') }}" class="text-green-600 hover:text-green-800 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-green-900 leading-tight">
                Detail Petugas Lapangan
            </h2>
        </div>
    </x-slot>

    <div class="py-6 bg-gradient-to-b from-green-50 to-white min-h-screen">
        <div class="grid grid-cols-3 gap-8 lg:gap-6 md:grid-cols-1 md:gap-4">
            <!-- User Profile -->
            <div class="col-span-1 md:col-span-1">
                <div class="bg-white shadow-lg rounded-lg border border-green-100">
                    <div class="p-6">
                        <div class="text-center mb-6">
                            <div class="w-24 h-24 bg-gradient-to-r from-green-600 to-green-700 rounded-full mx-auto flex items-center justify-center mb-4 shadow-lg">
                                <span class="text-3xl font-bold text-white">
                                    {{ substr($user->name, 0, 2) }}
                                </span>
                            </div>
                            <h3 class="text-xl font-semibold text-green-900">{{ $user->name }}</h3>
                            <p class="text-green-700">{{ $user->email }}</p>
                            <div class="mt-3">
                                @if($user->is_active)
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                    Aktif
                                </span>
                                @else
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                                    Nonaktif
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-green-700">NIP</label>
                                <p class="text-green-900 font-medium">{{ $user->nip ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-green-700">Nomor Telepon</label>
                                <p class="text-green-900 font-medium">{{ $user->phone }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-green-700">Dibuat Oleh</label>
                                <p class="text-green-900 font-medium">{{ $user->creator->name ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-green-700">Tanggal Bergabung</label>
                                <p class="text-green-900 font-medium">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <!-- Action Buttons -->
                        <div class="mt-6 pt-6 border-t border-green-200 space-y-3">
                            <a href="{{ route('admin.users.edit', $user) }}" class="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-2 px-4 rounded-lg transition-all duration-200 text-center block shadow-md hover:shadow-lg">
                                Edit Petugas
                            </a>

                            <button onclick="showResetPasswordModal()" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                                Reset Password
                            </button>

                            <!-- ✅ PERBAIKAN: Toggle Status Button -->
                            <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="w-full">
                                @csrf
                                @method('PATCH')
                                @if($user->is_active)
                                <button type="submit"
                                    class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg"
                                    onclick="return confirm('Yakin ingin menonaktifkan petugas ini?')">
                                    Nonaktifkan Petugas
                                </button>
                                @else
                                <button type="submit"
                                    class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-2 px-4 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg"
                                    onclick="return confirm('Yakin ingin mengaktifkan petugas ini?')">
                                    Aktifkan Petugas
                                </button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Survey Statistics -->
            <div class="col-span-2 md:col-span-1">
                <div class="bg-white shadow-lg rounded-lg border border-green-100">
                    <div class="p-6">
                        <h4 class="text-lg font-medium text-green-900 mb-6 pb-4 border-b border-green-200">Statistik Survei</h4>

                        <div class="grid grid-cols-4 gap-4 mb-8 md:grid-cols-2 sm:grid-cols-1">
                            <div class="bg-gradient-to-r from-green-50 to-green-100 p-4 rounded-lg text-center border border-green-200 shadow-sm">
                                <div class="text-3xl font-bold text-green-700">{{ $user->surveys()->count() }}</div>
                                <div class="text-sm text-green-600">Total Survei</div>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg text-center border border-gray-200 shadow-sm">
                                <div class="text-3xl font-bold text-gray-600">{{ $user->surveys()->draft()->count() }}</div>
                                <div class="text-sm text-gray-600">Draft</div>
                            </div>
                            <div class="bg-yellow-50 p-4 rounded-lg text-center border border-yellow-200 shadow-sm">
                                <div class="text-3xl font-bold text-yellow-600">{{ $user->surveys()->submitted()->count() }}</div>
                                <div class="text-sm text-yellow-600">Menunggu Verifikasi</div>
                            </div>
                            <div class="bg-green-50 p-4 rounded-lg text-center border border-green-200 shadow-sm">
                                <div class="text-3xl font-bold text-green-600">{{ $user->surveys()->verified()->count() }}</div>
                                <div class="text-sm text-green-600">Terverifikasi</div>
                            </div>
                        </div>

                        <!-- Recent Surveys -->
                        <h5 class="text-md font-medium text-green-900 mb-4 pb-2 border-b border-green-200">Survei Terbaru</h5>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-green-200">
                                <thead class="bg-gradient-to-r from-green-50 to-green-100">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">
                                            Kepala Keluarga
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">
                                            Alamat
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
                                    @forelse($user->surveys as $survey)
                                    <tr class="hover:bg-green-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-green-900">
                                                {{ $survey->nama_kepala_keluarga }}
                                            </div>
                                            <div class="text-sm text-green-600">
                                                {{ $survey->jumlah_anggota_keluarga }} anggota
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-green-900">{{ Str::limit($survey->alamat_lengkap, 50) }}</div>
                                            <div class="text-sm text-green-600">{{ $survey->neighborhood->village->name }}</div>
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
                                            <a href="{{ route('petugas.surveys.show', $survey) }}" class="text-green-600 hover:text-green-800 bg-green-100 hover:bg-green-200 px-3 py-1 rounded-md transition-all duration-200 shadow-sm hover:shadow-md">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center">
                                            <div class="flex flex-col items-center">
                                                <svg class="w-12 h-12 text-green-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                                </svg>
                                                <p class="text-green-600">Belum ada data survei</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reset Password Modal -->
    <div id="resetPasswordModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50 backdrop-blur-sm">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-2xl rounded-lg bg-white border-green-100">
            <div class="mt-3">
                <div class="flex items-center mb-4">
                    <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-green-900">Reset Password</h3>
                </div>
                <form id="resetPasswordForm" action="{{ route('admin.users.reset-password', $user) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-green-700 mb-2">Password Baru</label>
                        <input type="password" id="password" name="password" required
                            class="w-full border-green-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors">
                    </div>
                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-sm font-medium text-green-700 mb-2">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            class="w-full border-green-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors">
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="hideResetPasswordModal()"
                            class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                            Batal
                        </button>
                        <button type="submit"
                            class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                            Reset Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function showResetPasswordModal() {
            document.getElementById('resetPasswordModal').classList.remove('hidden');
        }

        function hideResetPasswordModal() {
            document.getElementById('resetPasswordModal').classList.add('hidden');
            document.getElementById('resetPasswordForm').reset();
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('resetPasswordModal');
            if (event.target === modal) {
                hideResetPasswordModal();
            }
        });
    </script>
    @endpush
</x-layouts.admin>