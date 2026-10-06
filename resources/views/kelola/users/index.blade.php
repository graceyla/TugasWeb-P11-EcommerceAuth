<x-app-layout>
    <x-slot name="title">Kelola User</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola User</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex gap-2 mb-4 text-sm">
                @foreach (['' => 'Semua', 'admin' => 'Admin', 'editor' => 'Editor', 'user' => 'User'] as $value => $label)
                    <a href="{{ route('kelola.users.index', $value ? ['role' => $value] : []) }}"
                        class="px-3 py-1.5 rounded-md border {{ ($role ?? '') === $value ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-600 border-gray-300 hover:bg-gray-50' }}">{{ $label }}</a>
                @endforeach
            </div>

            <div class="bg-white rounded-xl border border-gray-200 overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500 border-b">
                            <th class="px-5 py-3">Nama</th>
                            <th class="px-5 py-3">Email</th>
                            <th class="px-5 py-3">Pesanan</th>
                            <th class="px-5 py-3">Role</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach ($users as $user)
                            <tr>
                                <td class="px-5 py-3 font-medium text-gray-900">{{ $user->name }}</td>
                                <td class="px-5 py-3 text-gray-600">{{ $user->email }}</td>
                                <td class="px-5 py-3 text-gray-600">{{ $user->orders_count }}</td>
                                <td class="px-5 py-3">
                                    @if ($user->is(auth()->user()))
                                        <x-role-badge :role="$user->role" /> <span class="text-xs text-gray-400">(kamu)</span>
                                    @else
                                        <form action="{{ route('kelola.users.role', $user) }}" method="POST" class="flex gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="role" class="text-sm rounded-md border-gray-300 py-1 focus:border-indigo-500 focus:ring-indigo-500">
                                                @foreach (['admin', 'editor', 'user'] as $r)
                                                    <option value="{{ $r }}" @selected($user->role === $r)>{{ $r }}</option>
                                                @endforeach
                                            </select>
                                            <button class="text-sm bg-gray-800 text-white px-3 rounded-md hover:bg-gray-700">Simpan</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $users->links() }}</div>
        </div>
    </div>
</x-app-layout>
