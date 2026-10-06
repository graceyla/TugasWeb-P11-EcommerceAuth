<x-app-layout>
    <x-slot name="title">Akses Ditolak</x-slot>

    <div class="py-20">
        <div class="max-w-lg mx-auto px-4 text-center">
            <p class="text-7xl font-bold text-red-500">403</p>
            <h1 class="text-2xl font-semibold text-gray-900 mt-4">Akses Ditolak</h1>
            <p class="text-gray-600 mt-2">{{ $exception->getMessage() ?: 'Kamu tidak punya izin untuk membuka halaman ini.' }}</p>
            @auth
                <p class="text-sm text-gray-500 mt-4">Kamu login sebagai <strong>{{ auth()->user()->name }}</strong> <x-role-badge :role="auth()->user()->role" /></p>
            @endauth
            <a href="{{ route('shop.index') }}" class="inline-block mt-6 text-indigo-600 underline">Kembali ke beranda</a>
        </div>
    </div>
</x-app-layout>
