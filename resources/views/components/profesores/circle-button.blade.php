@props([
    'label' => '',
    'color' => 'blue',
    'extraClasses' => '',
])

@php
    $colorClasses = [
        'blue' => 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500',
        'yellow' => 'bg-yellow-500 hover:bg-yellow-600 focus:ring-yellow-400',
        'gray' => 'bg-gray-600 hover:bg-gray-700 focus:ring-gray-400',
    ];
    $selectedColor = $colorClasses[$color] ?? $colorClasses['blue'];
@endphp

<button type="button"
    class="w-8 h-8 flex items-center justify-center rounded-full text-white font-bold focus:ring-2 {{ $selectedColor }} {{ $extraClasses }}"
    {{ $attributes }}>
    {{ $label }}
</button>
