@props(['role'])

@php
    $warna = match ($role) {
        'admin' => 'bg-red-100 text-red-700',
        'editor' => 'bg-amber-100 text-amber-700',
        default => 'bg-gray-100 text-gray-600',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-block text-xs font-semibold uppercase tracking-wide px-2 py-0.5 rounded {$warna}"]) }}>
    {{ $role }}
</span>
