<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center gap-4 py-6">
            <div class="flex-shrink-0">
                <svg class="w-12 h-12 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="flex-1">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ $this->getGreeting() }}, {{ $this->getUserName() }}!
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ now()->isoFormat('dddd, D MMMM YYYY') }}
                </p>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
