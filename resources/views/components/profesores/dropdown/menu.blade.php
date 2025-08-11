<li>
    <button class="block px-4 py-2 hover:bg-gray-100 w-full cursor-pointer"
        data-option-id="{{ $id ?? '0' }}">{{ $content ?? 'null' }}</button>
    <span class="optionValue hidden" data-option-value-id="{{ $id ?? '0' }}">{{ $value ?? 'null' }}</span>
</li>
