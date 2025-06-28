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
@endphp

<nav class="header bg-[#f3e5e5] shadow-lg w-full {{ $headerResponsive }}">
    <div
        class="sidebar-header bg-[#565668] h-full shadow-lg flex items-center justify-between text-gray-300 p-4 {{ $sidebarHeaderResponsive }}">
        <a href="{{ route('index') }}">Profesores</a>
        <button class="cursor-pointer" id="sidebar-button"><i class="fa-solid fa-bars text-xl"></i></button>
    </div>
</nav>
