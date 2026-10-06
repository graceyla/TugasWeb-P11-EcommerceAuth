<x-app-layout>
    <x-slot name="title">{{ $post->title }}</x-slot>

    <div class="py-8">
        <article class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('posts.index') }}" class="text-sm text-gray-500 hover:text-gray-800">&larr; Semua artikel</a>

            <div class="bg-white rounded-xl border border-gray-200 p-6 md:p-10 mt-4">
                @unless ($post->is_published)
                    <span class="inline-block text-xs font-semibold bg-amber-100 text-amber-700 px-2 py-0.5 rounded mb-3">DRAFT</span>
                @endunless

                <h1 class="text-3xl font-bold text-gray-900">{{ $post->title }}</h1>
                <p class="text-sm text-gray-400 mt-2">oleh {{ $post->user->name }} &middot; {{ $post->created_at->translatedFormat('d F Y') }}</p>

                <div class="text-gray-700 leading-relaxed mt-8">
                    {!! nl2br(e($post->body)) !!}
                </div>

                {{-- tombol cuma muncul kalau lolos PostPolicy --}}
                @canany(['update', 'delete'], $post)
                    <div class="flex gap-3 mt-10 pt-6 border-t">
                        @can('update', $post)
                            <a href="{{ route('kelola.posts.edit', $post) }}" class="bg-amber-500 text-white text-sm px-4 py-2 rounded-md hover:bg-amber-600">Edit</a>
                        @endcan
                        @can('delete', $post)
                            <form action="{{ route('kelola.posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-600 text-white text-sm px-4 py-2 rounded-md hover:bg-red-700">Hapus</button>
                            </form>
                        @endcan
                    </div>
                @endcanany
            </div>
        </article>
    </div>
</x-app-layout>
