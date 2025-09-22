@props(['title', 'description'])

<div class="flex w-full flex-col text-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $title }}</h1>
    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $description }}</p>
</div>
