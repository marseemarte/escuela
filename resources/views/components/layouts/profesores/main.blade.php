@php
    $mainResponsive = [
        'df' => 'w-[100vw]',
        'sm' => 'sm:w-[100vw]',
        'md' => 'md:w-[73vw]',
        'lg' => 'lg:w-[77vw]',
        'xl' => 'xl:w-[80vw]',
        '2xl' => '2xl:w-[84vw]',
    ];
    $mainResponsive = implode(' ', $mainResponsive);
@endphp

<div class="main p-5 transition-all {{ $mainResponsive }}" id="main">
    {{ $slot }}
</div>
