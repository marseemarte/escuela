<table class="w-full text-sm text-left rtl:text-right text-gray-500"
    @if ($searchId ?? false) data-search-id="{{ $searchId }}" @endif>
    {{ $slot }}
</table>
