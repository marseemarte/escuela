@switch($style)
    @case('search')
        <input type="text" {{ $attributes->except(['class', 'style', 'placeholder', 'searchName']) }}
            class="w-full h-10 md:h-full px-[6%] text-sm border border-gray-300 rounded-lg bg-gray-100 focus:ring-blue-500 focus:border-blue-500 {{ $attributes->get('class') }}"
            placeholder="{{ $placeholder ?? 'Buscar...' }}"
            @isset($searchName) data-search-name="{{ $searchName }}" @endisset>
    @break

    @default
@endswitch
