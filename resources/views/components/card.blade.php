{{-- resources/views/components/card.blade.php --}}
@props(['title', 'value', 'icon', 'color'])

<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex items-center">
        <div class="flex-shrink-0 bg-{{ $color }}-100 rounded-lg p-3">
            @if ($icon == 'users')
                <svg class="w-6 h-6 text-{{ $color }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
            @endif
        </div>
        <div class="ml-4">
            <h3 class="text-sm font-medium text-gray-500">{{ $title }}</h3>
            <p class="text-2xl font-semibold text-gray-900">{{ $value }}</p>
        </div>
    </div>
</div>
