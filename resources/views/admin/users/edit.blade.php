{{-- resources/views/admin/users/edit.blade.php --}}
<x-layouts.admin>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.users.show', $user) }}" class="text-green-600 hover:text-green-800 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-green-900 leading-tight">
                Edit Petugas Lapangan
            </h2>
        </div>
    </x-slot>

    <div class="py-6 bg-gradient-to-b from-green-50 to-white min-h-screen">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white shadow-lg rounded-lg border border-green-100">
                <div class="px-6 py-4 border-b border-green-200 bg-gradient-to-r from-green-50 to-green-100">
                    <h3 class="text-lg font-medium text-green-900">Edit Informasi Petugas</h3>
                    <p class="text-sm text-green-700">Update data petugas lapangan</p>
                </div>

                <form method="POST" action="{{ route('admin.users.update', $user) }}" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Personal Information -->
                    <div>
                        <h4 class="text-md font-medium text-green-800 mb-4 flex items-center">
                            <span class="bg-gradient-to-r from-green-600 to-green-700 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3 shadow-md">1</span>
                            Informasi Pribadi
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-green-700 mb-2">Nama Lengkap</label>
                                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required
                                    class="w-full border-green-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors @error('name') border-red-500 @enderror">
                                @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="nip" class="block text-sm font-medium text-green-700 mb-2">NIP (Opsional)</label>
                                <input id="nip" name="nip" type="text" value="{{ old('nip', $user->nip) }}"
                                    class="w-full border-green-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors @error('nip') border-red-500 @enderror">
                                @error('nip')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-green-700 mb-2">Email</label>
                                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                                    class="w-full border-green-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors @error('email') border-red-500 @enderror">
                                @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-green-700 mb-2">Nomor Telepon</label>
                                <input id="phone" name="phone" type="text" value="{{ old('phone', $user->phone) }}" required
                                    class="w-full border-green-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors @error('phone') border-red-500 @enderror">
                                @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-md font-medium text-green-800 mb-4 flex items-center">
                            <span class="bg-gradient-to-r from-green-600 to-green-700 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3 shadow-md">2</span>
                            Status Akun
                        </h4>
                        <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                            <div class="flex items-center">
                                <!-- ✅ PERBAIKAN: Tambahkan hidden input untuk handle unchecked state -->
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox"
                                    id="is_active"
                                    name="is_active"
                                    value="1"
                                    {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                                    class="rounded border-green-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                <label for="is_active" class="ml-2 block text-sm text-green-900 font-medium">
                                    Akun Aktif
                                </label>
                            </div>
                            <p class="mt-2 text-sm text-green-700">
                                Centang untuk mengaktifkan akun petugas. Petugas yang tidak aktif tidak dapat login ke sistem.
                            </p>

                            <!-- Status indicator -->
                            <div class="mt-3">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    Status saat ini: {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-green-200">
                        <a href="{{ route('admin.users.show', $user) }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                            Batal
                        </a>
                        <button type="submit"
                            class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-2 px-6 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                            Update Petugas
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.admin>