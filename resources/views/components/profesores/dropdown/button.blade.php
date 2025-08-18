@php
    if (!function_exists('setButtonColor')) {
        function setButtonColor($value)
        {
            switch ($value) {
                case 'Presente':
                    return 'bg-blue-700 hover:bg-blue-800 focus:ring-blue-300';
                case 'Ausente':
                    return 'bg-yellow-700 hover:bg-yellow-800 focus:ring-yellow-300';
                case 'Justificado':
                    return 'bg-gray-600 hover:bg-gray-700 focus:ring-gray-300';
                case 'Todos':
                    return 'bg-green-500 hover:bg-green-600 focus:ring-green-400';
                default:
                    return 'bg-gray-400 hover:bg-gray-500 focus:ring-gray-300';
            }
        }
    }
@endphp
<div class="relative w-full">
    <button data-dropdown-button-id="{{ $id }}"
        class="w-full inline-flex justify-center items-center text-white focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 {{ setButtonColor($defaultLabel ?? 'Seleccionar') }}">

        <span class="selectedOptionText truncate flex-1 text-center"
            data-search-item="@if ($searchItem ?? false) true @else false @endif"
            @isset($searchName) data-search-name="{{ $searchName[0] }}" @endisset>
            {{ $defaultLabel ?? 'Seleccionar' }}
        </span>

        <span class="selectedOptionValue hidden"
            data-search-item="@if ($searchItem ?? false) true @else false @endif"
            @isset($searchName) data-search-name="{{ $searchName[1] }}" @endisset>
            {{ $defaultSelectedValue ?? 'null' }}
        </span>

        <svg class="h-[0.8vw] w-[0.8vw] ml-3 flex-shrink-0" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 4 4 4-4" />
        </svg>
    </button>

    <!-- Dropdown menu -->
    <div data-dropdown-id="{{ $id }}"
        class="hidden absolute top-full left-0 mt-2 w-full bg-white divide-y divide-gray-100 rounded-lg shadow-lg border border-gray-200 z-10">
        <ul class="py-2 text-sm text-gray-700">
            {{ $slot }}
        </ul>
    </div>
</div>
