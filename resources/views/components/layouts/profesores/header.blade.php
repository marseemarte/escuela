@php
    $headerResponsive = [
        'df' => 'h-[9vh]',
        'sm' => 'sm:h-[10vh]',
        'md' => 'md:h-[10vh]',
        'lg' => 'lg:h-[9vh]',
        'xl' => 'xl:h-[8vh]',
        '2xl' => '2xl:h-[7vh]',
    ];
    $headerResponsive = implode(' ', $headerResponsive);

    $sidebarHeaderResponsive = [
        'df' => 'w-[50vw]',
        'sm' => 'sm:w-[33vw]',
        'md' => 'md:w-[27vw]',
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
@endphp

<nav class="header bg-[#f3e5e5] shadow-lg w-full {{ $headerResponsive }}">
    <div class="sidebar-header bg-[#565668] h-full shadow-lg flex items-center justify-between text-gray-300 p-4 transition-all duration-150 {{ $sidebarHeaderResponsive }}"
        id="sidebarHeader">

        <a href="{{ route('index') }}">Profesores</a>
        <button class="cursor-pointer" id="sidebar-button">
            <i
                class="fa-solid fa-bars transition hover:bg-[#6c6c81] rounded-xl {{ $sidebarHeaderCloseButtonResponsive }}"></i>
        </button>
    </div>
</nav>
