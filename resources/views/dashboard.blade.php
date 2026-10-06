<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <p class="text-gray-900">
                    Halo, <strong>{{ auth()->user()->name }}</strong>! Kamu login sebagai
                    <x-role-badge :role="auth()->user()->role" />
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ($statistik as $label => $nilai)
                    <div class="bg-white shadow-sm rounded-lg p-5">
                        <p class="text-sm text-gray-500">{{ $label }}</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $nilai }}</p>
                    </div>
                @endforeach
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Hak akses tiap role</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-gray-500 border-b">
                                <th class="py-2 pr-4">Fitur</th>
                                <th class="py-2 px-4 text-center">Admin</th>
                                <th class="py-2 px-4 text-center">Editor</th>
                                <th class="py-2 px-4 text-center">User</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach ([
                                ['Belanja & lihat pesanan sendiri', true, true, true],
                                ['Baca artikel', true, true, true],
                                ['Tulis artikel', true, true, false],
                                ['Edit / hapus artikel sendiri', true, true, false],
                                ['Edit / hapus artikel orang lain', true, false, false],
                                ['Kelola user & role', true, false, false],
                                ['Panel Admin (Filament)', true, false, false],
                            ] as [$fitur, $admin, $editor, $user])
                                <tr>
                                    <td class="py-2 pr-4">{{ $fitur }}</td>
                                    @foreach ([$admin, $editor, $user] as $boleh)
                                        <td class="py-2 px-4 text-center {{ $boleh ? 'text-green-600' : 'text-red-400' }}">{{ $boleh ? '✔' : '✘' }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
