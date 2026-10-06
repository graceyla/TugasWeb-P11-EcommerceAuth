<x-app-layout>
    <x-slot name="title">Kelola Artikel</x-slot>

    <x-slot name="header">
        <div class="flex flex-wrap justify-between items-center gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Artikel</h2>
            @can('create', App\Models\Post::class)
                <a href="{{ route('kelola.posts.create') }}" class="bg-indigo-600 text-white text-sm px-4 py-2 rounded-md hover:bg-indigo-700">+ Tulis Artikel</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (auth()->user()->role === 'editor')
                <p class="text-sm text-gray-500 mb-4">Sebagai editor, kamu bisa melihat semua artikel tapi hanya bisa edit/hapus artikel milikmu sendiri.</p>
            @endif

            <div class="bg-white rounded-xl border border-gray-200 overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500 border-b">
                            <th class="px-5 py-3">Judul</th>
                            <th class="px-5 py-3">Penulis</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3">Tanggal</th>
                            <th class="px-5 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($posts as $post)
                            <tr>
                                <td class="px-5 py-3">
                                    <a href="{{ route('posts.show', $post) }}" class="font-medium text-gray-900 hover:text-indigo-600">{{ $post->title }}</a>
                                </td>
                                <td class="px-5 py-3 whitespace-nowrap">
                                    {{ $post->user->name }} <x-role-badge :role="$post->user->role" />
                                </td>
                                <td class="px-5 py-3">
                                    @if ($post->is_published)
                                        <span class="text-green-600">Publish</span>
                                    @else
                                        <span class="text-amber-600">Draft</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3 text-gray-500 whitespace-nowrap">{{ $post->created_at->translatedFormat('d M Y') }}</td>
                                <td class="px-5 py-3">
                                    <div class="flex justify-end gap-2">
                                        @can('update', $post)
                                            <a href="{{ route('kelola.posts.edit', $post) }}" class="bg-amber-500 text-white px-3 py-1.5 rounded-md hover:bg-amber-600">Edit</a>
                                        @endcan
                                        @can('delete', $post)
                                            <form action="{{ route('kelola.posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="bg-red-600 text-white px-3 py-1.5 rounded-md hover:bg-red-700">Hapus</button>
                                            </form>
                                        @endcan
                                        @cannot('update', $post)
                                            <span class="text-xs text-gray-400 py-1.5">bukan milikmu</span>
                                        @endcannot
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-8 text-center text-gray-500">Belum ada artikel.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $posts->links() }}</div>
        </div>
    </div>
</x-app-layout>
