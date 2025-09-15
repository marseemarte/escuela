<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.auth-head', ['title' => $title ?? null])
</head>

<body class="min-h-screen bg-white antialiased dark:bg-gradient-to-b dark:from-neutral-950 dark:to-neutral-900">
    <div class="bg-background flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
        <div class="flex w-full max-w-sm flex-col gap-6">
            <a href="{{ route('home') }}" class="flex flex-col items-center gap-4 font-medium" wire:navigate>
                <div
                    class="flex h-16 w-16 items-center justify-center rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 shadow-lg">
                    <x-app-logo-icon class="size-10 fill-current text-white" />
                </div>
                <h1 class="text-xl font-semibold text-gray-900 dark:text-white">{{ config('app.name', 'Escuela') }}</h1>
                <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
            </a>
            <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-xl p-6">
                {{ $slot }}
            </div>
        </div>
    </div>
    @fluxScripts
</body>

</html>
