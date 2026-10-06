@props(['product'])

<a href="{{ route('shop.show', $product) }}" class="group bg-white rounded-xl border border-gray-200 overflow-hidden flex flex-col hover:shadow-md transition">
    <div class="h-36 bg-gradient-to-br from-indigo-50 to-sky-100 flex items-center justify-center text-4xl font-bold text-indigo-300 group-hover:text-indigo-400">
        {{ strtoupper(substr($product->name, 0, 1)) }}
    </div>
    <div class="p-4 flex-1 flex flex-col">
        <span class="text-xs text-indigo-600 font-medium">{{ $product->category->name }}</span>
        <h3 class="text-sm font-medium text-gray-800 mt-1 line-clamp-2 flex-1">{{ $product->name }}</h3>
        <p class="font-bold text-gray-900 mt-2">{{ $product->formatted_price }}</p>
        <div class="flex items-center justify-between text-xs text-gray-500 mt-1">
            <span>
                @if ($product->reviews_count)
                    &#9733; {{ number_format($product->reviews_avg_rating, 1) }} ({{ $product->reviews_count }})
                @else
                    Belum ada ulasan
                @endif
            </span>
            <span class="{{ $product->stock ? '' : 'text-red-500 font-medium' }}">
                {{ $product->stock ? 'Stok ' . $product->stock : 'Habis' }}
            </span>
        </div>
    </div>
</a>
