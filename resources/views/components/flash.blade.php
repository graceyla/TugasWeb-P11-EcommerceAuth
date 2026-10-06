{{-- flash message dari session, dipasang di layout --}}
@foreach (['success' => 'bg-green-50 text-green-800 border-green-200', 'error' => 'bg-red-50 text-red-800 border-red-200'] as $key => $warna)
    @if (session($key))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            <div class="border rounded-lg px-4 py-3 text-sm {{ $warna }}" role="alert">
                {{ session($key) }}
            </div>
        </div>
    @endif
@endforeach
