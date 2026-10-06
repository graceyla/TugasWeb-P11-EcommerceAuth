<x-app-layout>
    <x-slot name="title">Pesanan Saya</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pesanan Saya</h2>
    </x-slot>

    @php
        $warnaStatus = [
            'pending' => 'bg-gray-100 text-gray-700',
            'paid' => 'bg-blue-100 text-blue-700',
            'shipped' => 'bg-amber-100 text-amber-700',
            'completed' => 'bg-green-100 text-green-700',
            'cancelled' => 'bg-red-100 text-red-700',
        ];
    @endphp

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
            @forelse ($orders as $order)
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <div class="flex flex-wrap justify-between gap-2 border-b pb-3 mb-3">
                        <div>
                            <p class="font-semibold text-gray-900">{{ $order->invoice_number }}</p>
                            <p class="text-xs text-gray-400">{{ $order->created_at->translatedFormat('d F Y, H:i') }}</p>
                        </div>
                        <span class="h-fit text-xs font-semibold uppercase px-2 py-1 rounded {{ $warnaStatus[$order->status] }}">{{ $order->status }}</span>
                    </div>

                    <ul class="text-sm space-y-1">
                        @foreach ($order->items as $item)
                            <li class="flex justify-between gap-4">
                                <span class="text-gray-700">{{ $item->quantity }}x {{ $item->product->name }}</span>
                                <span class="text-gray-500 whitespace-nowrap">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <div class="flex flex-wrap justify-between gap-2 border-t mt-3 pt-3 text-sm">
                        <span class="text-gray-500">
                            @if ($order->address)
                                Dikirim ke: {{ $order->address->label }}, {{ $order->address->city }}
                            @endif
                        </span>
                        <span class="font-bold text-gray-900">Total {{ $order->formatted_total }}</span>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl border border-gray-200 p-10 text-center text-gray-500">
                    Kamu belum punya pesanan.
                </div>
            @endforelse

            {{ $orders->links() }}
        </div>
    </div>
</x-app-layout>
