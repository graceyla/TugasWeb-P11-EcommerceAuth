<x-app-layout>
    <x-slot name="title">Belanja</x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-end justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Semua Produk</h1>
                    <p class="text-sm text-gray-500">{{ $products->total() }} produk ditemukan</p>
                </div>

                <form method="GET" action="{{ route('shop.index') }}" class="flex gap-2 w-full sm:w-auto">
                    @if ($kategoriAktif)
                        <input type="hidden" name="kategori" value="{{ $kategoriAktif }}">
                    @endif
                    <input type="text" name="q" value="{{ $keyword }}" placeholder="Cari produk..."
                        class="flex-1 sm:w-72 rounded-md border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <button class="bg-gray-800 text-white px-4 rounded-md text-sm hover:bg-gray-700">Cari</button>
                </form>
            </div>

            <div class="grid lg:grid-cols-[220px_1fr] gap-6">
                <aside class="bg-white rounded-xl border border-gray-200 p-4 h-fit">
                    <h2 class="font-semibold text-gray-800 mb-3">Kategori</h2>
                    <ul class="space-y-1 text-sm">
                        <li>
                            <a href="{{ route('shop.index', ['q' => $keyword]) }}"
                                class="flex justify-between px-2 py-1.5 rounded {{ $kategoriAktif ? 'text-gray-600 hover:bg-gray-50' : 'bg-indigo-50 text-indigo-700 font-medium' }}">
                                Semua
                            </a>
                        </li>
                        @foreach ($categories as $c)
                            <li>
                                <a href="{{ route('shop.index', ['kategori' => $c->slug, 'q' => $keyword]) }}"
                                    class="flex justify-between px-2 py-1.5 rounded {{ $kategoriAktif === $c->slug ? 'bg-indigo-50 text-indigo-700 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                                    <span>{{ $c->name }}</span>
                                    <span class="text-gray-400">{{ $c->products_count }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </aside>

                <div>
                    @if ($products->isEmpty())
                        <div class="bg-white rounded-xl border border-gray-200 p-10 text-center text-gray-500">
                            Produk tidak ditemukan.
                        </div>
                    @else
                        <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
                            @foreach ($products as $product)
                                <x-product-card :product="$product" />
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $products->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
