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

    $darkenMainResponsive = [
        'df' => 'w-[40vw]',
        'sm' => 'sm:w-[60vw]',
        'md' => 'w-0',
    ];
    $darkenMainResponsive = implode(' ', $darkenMainResponsive);
@endphp
<div class="absolute top-0 h-full backdrop-brightness-50 md:backdrop-brightness-100 z-[2000] md:-z-0 md:hidden {{ $darkenMainResponsive }}"
    id="darkenMain">
</div>
<div class="main p-5 transition-all {{ $mainResponsive }}" id="main">
    {{ $slot }}
</div>
