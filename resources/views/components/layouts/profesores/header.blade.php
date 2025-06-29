@php
    $headerResponsive = [
        'df' => 'h-[9vh] relative',
        'sm' => 'sm:h-[10vh]',
        'md' => 'md:h-[10vh] md:static',
        'lg' => 'lg:h-[9vh]',
        'xl' => 'xl:h-[8vh]',
        '2xl' => '2xl:h-[7vh]',
    ];
    $headerResponsive = implode(' ', $headerResponsive);

    $sidebarHeaderResponsive = [
        'df' => 'w-[60vw] absolute',
        'sm' => 'sm:w-[40vw]',
        'md' => 'md:w-[27vw] md:static',
        'lg' => 'lg:w-[23vw]',
        'xl' => 'xl:w-[20vw]',
        '2xl' => '2xl:w-[16vw]',
    ];
    $sidebarHeaderResponsive = implode(' ', $sidebarHeaderResponsive);

    $sidebarHeaderCloseButtonResponsive = [
        'df' => 'text-2xl py-1.5 px-2',
        'sm' => 'sm:text-2xl sm:py-2 sm:px-2.5',
        'md' => 'md:text-2xl md:py-2 md:px-2.5',
        'lg' => 'lg:text-xl lg:py-2 lg:px-2.5',
        'xl' => 'xl:text-xl xl:py-2 xl:px-2.5',
        '2xl' => '2xl:text-xl 2xl:py-2 2xl:px-2.5',
    ];
    $sidebarHeaderCloseButtonResponsive = implode(' ', $sidebarHeaderCloseButtonResponsive);

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

<nav class="flex bg-[#f3e5e5] shadow-lg w-full transition-all {{ $headerResponsive }}">
    <div class="bg-[#565668] shadow-lg flex items-center h-full justify-between text-gray-300 p-4 {{ $sidebarHeaderResponsive }}"
        id="sidebarHeader">

        <a href="{{ route('index') }}">Profesores</a>
        <button class="cursor-pointer" id="sidebar-button">
            <i class="fa-solid fa-bars hover:bg-[#6c6c81] rounded-xl {{ $sidebarHeaderCloseButtonResponsive }}"></i>
        </button>
    </div>
    <div class="h-full flex items-center p-4">
        <h2>Inicio</h2>
    </div>
</nav>
