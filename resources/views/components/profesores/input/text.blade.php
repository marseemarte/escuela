@switch($style)
    @case('search')
        <input type="text"
            class="w-full h-full px-[6%] text-sm border border-gray-300 rounded-lg bg-gray-100 focus:ring-blue-500 focus:border-blue-500"
            placeholder="{{ $placeholder ?? 'Buscar...' }}"
            data-search-item="@if ($searchItem ?? false) true @else false @endif"
            @isset($searchName) data-search-name="{{ $searchName }}" @endisset>
    @break

    @default
@endswitch
