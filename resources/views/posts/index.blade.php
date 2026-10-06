<x-app-layout>
    <x-slot name="title">Artikel</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Artikel & Info Toko</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
            @forelse ($posts as $post)
                <a href="{{ route('posts.show', $post) }}" class="block bg-white rounded-xl border border-gray-200 p-6 hover:shadow-md transition">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $post->title }}</h3>
                    <p class="text-xs text-gray-400 mt-1">oleh {{ $post->user->name }} &middot; {{ $post->created_at->translatedFormat('d F Y') }}</p>
                    <p class="text-sm text-gray-600 mt-3">{{ Str::limit($post->body, 160) }}</p>
                </a>
            @empty
                <p class="text-gray-500">Belum ada artikel.</p>
            @endforelse

            {{ $posts->links() }}
        </div>
    </div>
</x-app-layout>
