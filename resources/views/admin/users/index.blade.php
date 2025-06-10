{{-- resources/views/admin/users/index.blade.php --}}
<x-layouts.admin>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-green-900 leading-tight">
                Manajemen Petugas Lapangan
            </h2>
            <a href="{{ route('admin.users.create') }}" class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-2 px-4 rounded-lg transition-all duration-200 flex items-center shadow-md hover:shadow-lg">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                </svg>
                Tambah Petugas
            </a>
        </div>
    </x-slot>

    <div class="py-6 bg-gradient-to-b from-green-50 to-white min-h-screen">
        <!-- Filter Section -->
        <div class="bg-white shadow-lg rounded-lg mb-6 border border-green-100">
            <div class="p-6 bg-gradient-to-r from-green-50 to-green-100 rounded-t-lg">
                <h3 class="text-lg font-semibold text-green-800 mb-4">Filter & Pencarian</h3>
                <form method="GET" action="{{ route('admin.users.index') }}" id="filterForm">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Pencarian</label>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari nama atau email..."
                                class="w-full border-green-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Status</label>
                            <select name="status" class="w-full border-green-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors">
                                <option value="">Semua Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                        <div class="flex items-end space-x-2">
                            <button type="submit" class="flex-1 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-2 px-4 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                                Filter
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Statistics Summary -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white p-4 rounded-lg shadow-lg border border-green-100">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-gradient-to-r from-green-600 to-green-700 rounded-md flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-green-800">{{ $users->total() }}</div>
                        <div class="text-sm text-green-600">Total Petugas</div>
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
                        <div class="text-2xl font-bold text-green-800">{{ $users->where('is_active', true)->count() }}</div>
                        <div class="text-sm text-green-600">Aktif</div>
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
                        <div class="text-2xl font-bold text-gray-700">{{ $users->where('is_active', false)->count() }}</div>
                        <div class="text-sm text-green-600">Nonaktif</div>
                    </div>
                </div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-lg border border-green-100">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-gradient-to-r from-green-700 to-green-800 rounded-md flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-green-800">{{ $users->sum('surveys_count') }}</div>
                        <div class="text-sm text-green-600">Total Survei</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden border border-green-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-green-200">
                    <thead class="bg-gradient-to-r from-green-50 to-green-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">
                                Petugas
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">
                                Kontak
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">
                                Wilayah Kerja
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">
                                Survei
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">
                                Bergabung
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-green-700 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-green-100">
                        @forelse($users as $user)
                        <tr class="hover:bg-green-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        <div class="h-12 w-12 rounded-full bg-gradient-to-r from-green-600 to-green-700 flex items-center justify-center shadow-md">
                                            <span class="text-lg font-bold text-white">
                                                {{ substr($user->name, 0, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-green-900">
                                            {{ $user->name }}
                                        </div>
                                        <div class="text-sm text-green-600">
                                            NIP: {{ $user->nip ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-green-900">{{ $user->email }}</div>
                                <div class="text-sm text-green-600">{{ $user->phone }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-green-900">
                                    {{ $user->wilayah_kerja_text }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($user->is_active)
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Aktif
                                </span>
                                @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Nonaktif
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-900">
                                <div class="flex items-center">
                                    <span class="font-medium">{{ $user->surveys_count }}</span>
                                    <span class="ml-1 text-green-600">survei</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">
                                {{ $user->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('admin.users.show', $user) }}" class="text-green-600 hover:text-green-800 bg-green-100 hover:bg-green-200 px-3 py-1 rounded-md transition-all duration-200 shadow-sm hover:shadow-md">
                                        Detail
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="text-yellow-600 hover:text-yellow-800 bg-yellow-100 hover:bg-yellow-200 px-3 py-1 rounded-md transition-all duration-200 shadow-sm hover:shadow-md">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 bg-red-100 hover:bg-red-200 px-3 py-1 rounded-md transition-all duration-200 shadow-sm hover:shadow-md" onclick="return confirm('Yakin ingin menghapus petugas ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-green-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                    <p class="text-green-600 text-lg">Belum ada petugas lapangan</p>
                                    <p class="text-green-500 text-sm">Tambah petugas pertama untuk memulai</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
            <div class="bg-gradient-to-r from-green-50 to-green-100 px-4 py-3 border-t border-green-200 sm:px-6">
                {{ $users->links() }}
            </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
