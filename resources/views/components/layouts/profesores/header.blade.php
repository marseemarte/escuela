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
        'df' => 'w-[60%] absolute',
        'sm' => 'sm:w-[40%]',
        'md' => 'md:w-[27%] md:static',
        'lg' => 'lg:w-[23%]',
        'xl' => 'xl:w-[20%]',
        '2xl' => '2xl:w-[16%]',
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

<nav class="sticky top-0 flex bg-[#fcf8f8] w-full transition-all {{ $headerResponsive }}">
    <div class="bg-[#565668] flex items-center h-full justify-between text-gray-300 p-4  {{ $sidebarHeaderResponsive }}"
        id="sidebarHeader">

        <a href="{{ route('index') }}" class="text-2xl">Profesores</a>
        <button class="cursor-pointer" id="sidebar-button">
            <i class="fa-solid fa-bars hover:bg-[#6c6c81] rounded-xl {{ $sidebarHeaderCloseButtonResponsive }}"></i>
        </button>
    </div>
    <div class="h-full flex items-center text-[19px] text-gray-900 p-4">
        <h2>{{ $titulo }}</h2>
    </div>

    <div class="flex-1 h-full "></div>
</nav>
