@php
    $mainResponsive = [
        'df' => 'w-[100%] min-h-[91vh]',
        'sm' => 'sm:w-[100%] sm:min-h-[90vh]',
        'md' => 'md:w-[73%] md:min-h-[90vh]',
        'lg' => 'lg:w-[77%] lg:min-h-[91vh]',
        'xl' => 'xl:w-[80%] xl:min-h-[92vh]',
        '2xl' => '2xl:w-[84%] 2xl:min-h-[93vh]',
    ];
    $mainResponsive = implode(' ', $mainResponsive);

    $darkenMainResponsive = [
        'df' => 'w-[40%]',
        'sm' => 'sm:w-[60%]',
        'md' => 'w-0',
    ];
    $darkenMainResponsive = implode(' ', $darkenMainResponsive);
@endphp
<div class="absolute top-0 h-full backdrop-brightness-50 md:backdrop-brightness-100 z-[2000] md:-z-0 md:hidden {{ $darkenMainResponsive }}"
    id="darkenMain">
</div>
<div class="main box-border md:transition-all bg-[#eeeded] p-2 md:p-7 {{ $mainResponsive }}" id="main">
    {{ $slot }}
</div>
