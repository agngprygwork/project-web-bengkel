{{-- resources/views/components/button.blade.php --}}
@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
    'icon' => null,
    'loading' => false,
    'disabled' => false,
    'href' => null,
])

@php
    $variants = [
        'primary' => 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 text-white',
        'secondary' => 'bg-gray-600 hover:bg-gray-700 focus:ring-gray-500 text-white',
        'success' => 'bg-green-600 hover:bg-green-700 focus:ring-green-500 text-white',
        'danger' => 'bg-red-600 hover:bg-red-700 focus:ring-red-500 text-white',
        'warning' => 'bg-yellow-600 hover:bg-yellow-700 focus:ring-yellow-500 text-white',
        'outline' => 'border border-gray-300 bg-white hover:bg-gray-50 focus:ring-blue-500 text-gray-700',
        'ghost' => 'hover:bg-gray-100 focus:ring-gray-500 text-gray-700',
    ];

    $sizes = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base',
        'xl' => 'px-8 py-4 text-lg',
    ];

    $baseClasses =
        'inline-flex items-center justify-center font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transition-all duration-200 ease-in-out';
    $disabledClasses = $disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer';
    $variantClasses = $variants[$variant];
    $sizeClasses = $sizes[$size];
    $classes = "{$baseClasses} {$disabledClasses} {$variantClasses} {$sizeClasses}";
@endphp

@if ($href && !$disabled)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($loading)
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-current" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
        @elseif($icon)
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                {!! $icon !!}
            </svg>
        @endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes, 'disabled' => $disabled]) }}>
        @if ($loading)
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-current" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
        @elseif($icon)
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                {!! $icon !!}
            </svg>
        @endif
        {{ $slot }}
    </button>
@endif

@push('styles')
    <style>
        button:active:not(:disabled) {
            transform: scale(0.98);
        }
    </style>
@endpush
