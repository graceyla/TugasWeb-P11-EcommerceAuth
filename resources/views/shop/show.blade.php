<x-app-layout>
    <x-slot name="title">{{ $product->name }}</x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <a href="{{ route('shop.index') }}" class="text-sm text-gray-500 hover:text-gray-800">&larr; Kembali belanja</a>

            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden grid md:grid-cols-2">
                <div class="bg-gradient-to-br from-indigo-50 to-sky-100 min-h-64 flex items-center justify-center text-8xl font-bold text-indigo-300">
                    {{ strtoupper(substr($product->name, 0, 1)) }}
                </div>
                <div class="p-6 md:p-8">
                    <a href="{{ route('shop.index', ['kategori' => $product->category->slug]) }}" class="text-sm text-indigo-600 font-medium">{{ $product->category->name }}</a>
                    <h1 class="text-2xl font-bold text-gray-900 mt-1">{{ $product->name }}</h1>

                    <div class="text-sm text-gray-500 mt-2">
                        @if ($product->reviews->isNotEmpty())
                            &#9733; {{ number_format($product->reviews->avg('rating'), 1) }} &middot; {{ $product->reviews->count() }} ulasan
                        @else
                            Belum ada ulasan
                        @endif
                    </div>

                    <p class="text-3xl font-bold text-gray-900 mt-4">{{ $product->formatted_price }}</p>
                    <p class="text-sm mt-1 {{ $product->stock ? 'text-gray-600' : 'text-red-500 font-medium' }}">
                        {{ $product->stock ? 'Stok tersedia: ' . $product->stock : 'Stok habis' }}
                    </p>

                    <p class="text-gray-700 leading-relaxed mt-6">{{ $product->description }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="font-semibold text-gray-800 mb-4">Ulasan Pembeli</h2>
                @forelse ($product->reviews as $review)
                    <div class="py-3 border-b last:border-0">
                        <div class="flex justify-between text-sm">
                            <span class="font-medium text-gray-800">{{ $review->user->name }}</span>
                            <span class="text-amber-500">{{ str_repeat('★', $review->rating) }}<span class="text-gray-300">{{ str_repeat('★', 5 - $review->rating) }}</span></span>
                        </div>
                        <p class="text-sm text-gray-600 mt-1">{{ $review->comment }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $review->created_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Belum ada ulasan untuk produk ini.</p>
                @endforelse
            </div>

            @if ($terkait->isNotEmpty())
                <div>
                    <h2 class="font-semibold text-gray-800 mb-3">Produk Terkait</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach ($terkait as $p)
                            <x-product-card :product="$p" />
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
