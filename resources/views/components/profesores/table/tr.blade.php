<tr {{ $attributes->except('class') }}
    class="bg-white {{ $bottom ?? false ? '' : 'bg-white border-b border-gray-200' }} min-h-[52px] h-auto align-middle w-full md:w-auto {{ $attributes->get('class') }}">
    {{ $slot }}
</tr>
