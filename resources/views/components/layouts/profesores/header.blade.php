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

<nav class="flex bg-[#fcf8f8] w-full transition-all shadow-lg {{ $headerResponsive }}">
    <div class="bg-[#565668] flex items-center h-full justify-between text-gray-300 p-4 {{ $sidebarHeaderResponsive }}"
        id="sidebarHeader">

        <a href="{{ route('index') }}" class="text-2xl">Profesores</a>
        <button class="cursor-pointer" id="sidebar-button">
            <i class="fa-solid fa-bars hover:bg-[#6c6c81] rounded-xl {{ $sidebarHeaderCloseButtonResponsive }}"></i>
        </button>
    </div>
    @if ($titulo !== 'Indefinido')
        <div class="h-full flex items-center text-[19px] text-gray-900 p-4">
            <h2>{{ $titulo }}</h2>
        </div>
    @else
        <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500">
            <li class="me-2">
                <button
                    class="inline-block p-4 text-blue-600 bg-gray-100 rounded-t-lg active dark:bg-gray-800 dark:text-blue-500">Asistencias</button>
            </li>
            <li class="me-2">
                <button class="inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50">Asistencias
                    Totales</button>
            </li>
        </ul>
    @endif

</nav>
