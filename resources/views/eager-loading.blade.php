<x-app-layout>
    <x-slot name="title">Demo Eager Loading</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Demo Eager Loading (N+1 Problem)</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <p class="text-gray-600 text-sm">
                Dua cara ambil data yang sama: 10 pesanan terakhir beserta nama pembeli dan nama produknya.
                Bedanya cuma di jumlah query ke database.
            </p>

            <div class="grid md:grid-cols-2 gap-4">
                @foreach ([
                    ['Tanpa eager loading', 'Order::latest()->take(10)->get()', $tanpa, 'border-red-200 bg-red-50', 'text-red-600'],
                    ['Dengan eager loading', "Order::with(['user', 'items.product'])->latest()->take(10)->get()", $dengan, 'border-green-200 bg-green-50', 'text-green-600'],
                ] as [$judul, $kode, $hasil, $kotak, $angka])
                    <div class="rounded-xl border p-5 {{ $kotak }}">
                        <h3 class="font-semibold text-gray-800">{{ $judul }}</h3>
                        <code class="block text-xs bg-white/70 rounded px-2 py-1 mt-2 text-gray-700 overflow-x-auto">{{ $kode }}</code>
                        <p class="mt-4"><span class="text-4xl font-bold {{ $angka }}">{{ $hasil['jumlah'] }}</span> <span class="text-gray-600">query</span></p>
                        <p class="text-sm text-gray-500">{{ $hasil['waktu'] }} ms</p>
                        <details class="mt-3 text-xs">
                            <summary class="cursor-pointer text-gray-600">Lihat query</summary>
                            <ol class="list-decimal ms-5 mt-2 space-y-1 text-gray-600 max-h-48 overflow-y-auto">
                                @foreach ($hasil['query'] as $q)
                                    <li><code>{{ $q }}</code></li>
                                @endforeach
                            </ol>
                        </details>
                    </div>
                @endforeach
            </div>

            <div class="bg-white rounded-xl border border-gray-200 overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500 border-b">
                            <th class="px-5 py-3">Invoice</th>
                            <th class="px-5 py-3">Pembeli</th>
                            <th class="px-5 py-3">Produk</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach ($orders as $order)
                            <tr>
                                <td class="px-5 py-3 whitespace-nowrap">{{ $order->invoice_number }}</td>
                                <td class="px-5 py-3 whitespace-nowrap">{{ $order->user->name }}</td>
                                <td class="px-5 py-3 text-gray-600">{{ $order->items->pluck('product.name')->join(', ') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
