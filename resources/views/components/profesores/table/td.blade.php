<td {{ $attributes->except('class') }} class="whitespace-nowrap px-2 py-3 md:table-cell {{ $attributes->get('class') }}">
    {{ $slot }}
</td>
