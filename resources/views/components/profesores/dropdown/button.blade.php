<div class="relative {{ $width ?? 'w-35' }}">
    <button id="dropdown[{{ $id }}]" data-dropdown-button-id="{{ $id }}"
        class="w-full h-11 inline-flex justify-center items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
        <span class="truncate flex-1 text-center">{{ $defaultLabel ?? 'Seleccionar' }}</span>
        <svg class="w-2.5 h-2.5 ml-3 flex-shrink-0" fill="none" viewBox="0 0 10 6">
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
