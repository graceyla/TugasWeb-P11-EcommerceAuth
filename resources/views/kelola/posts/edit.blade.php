<x-app-layout>
    <x-slot name="title">Edit Artikel</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Artikel</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <form action="{{ route('kelola.posts.update', $post) }}" method="POST" class="bg-white rounded-xl border border-gray-200 p-6">
                @csrf
                @method('PUT')

                @include('kelola.posts._form')

                <div class="flex gap-3 mt-6">
                    <x-primary-button>Update</x-primary-button>
                    <a href="{{ route('kelola.posts.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-xs font-semibold uppercase tracking-widest text-gray-700 hover:bg-gray-50">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
