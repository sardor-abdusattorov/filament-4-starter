<div
    x-data="{
        open: @entangle('isOpen'),
        currentTheme: '{{ $theme }}',
        applyTheme(theme) {
            this.currentTheme = theme;
            const html = document.documentElement;
            if (theme === 'dark') {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else if (theme === 'light') {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                localStorage.removeItem('theme');
                if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    html.classList.add('dark');
                } else {
                    html.classList.remove('dark');
                }
            }
        }
    }"
>
    {{-- Toggle Button --}}
    <button
        @click="open = !open"
        type="button"
        class="flex items-center justify-center w-8 h-8 rounded-lg text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:text-gray-500 dark:hover:text-gray-400 dark:hover:bg-gray-800 transition"
        title="{{ __('app.ui_switcher.title') }}"
    >
        <x-filament::icon icon="heroicon-o-paint-brush" class="w-5 h-5" />
    </button>

    {{-- Panel --}}
    <div
        x-show="open"
        x-cloak
        x-transition:enter="ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50"
        @keydown.escape.window="open = false"
    >
        <div class="fixed inset-0 bg-black/50" @click="open = false"></div>

        <div
            x-show="open"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="fixed inset-y-0 right-0 w-full max-w-sm bg-white dark:bg-gray-900 shadow-xl overflow-y-auto"
        >
            {{-- Header --}}
            <div class="sticky top-0 flex items-center justify-between px-4 py-3 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
                <h2 class="font-semibold text-gray-900 dark:text-white">{{ __('app.ui_switcher.settings') }}</h2>
                <button @click="open = false" class="p-1.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                    <x-filament::icon icon="heroicon-o-x-mark" class="w-5 h-5" />
                </button>
            </div>

            {{-- Content --}}
            <div class="p-5 space-y-6">
                {{-- Theme --}}
                <div>
                    <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">{{ __('app.ui_switcher.mode') }}</label>
                    <div class="mt-2 flex gap-1 p-1 bg-gray-100 dark:bg-gray-800 rounded-lg">
                        @foreach(['light' => 'heroicon-o-sun', 'dark' => 'heroicon-o-moon', 'system' => 'heroicon-o-computer-desktop'] as $mode => $icon)
                            <button
                                x-on:click="applyTheme('{{ $mode }}'); $wire.setTheme('{{ $mode }}')"
                                type="button"
                                :class="currentTheme === '{{ $mode }}' ? 'bg-white dark:bg-gray-700 shadow-sm' : ''"
                                class="flex-1 flex items-center justify-center p-2 rounded-md transition"
                            >
                                <x-filament::icon :icon="$icon" x-bind:class="currentTheme === '{{ $mode }}' ? 'text-primary-500' : 'text-gray-400'" class="w-5 h-5" />
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Layout --}}
                <div>
                    <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">{{ __('app.ui_switcher.layout') }}</label>
                    <div class="mt-2 grid grid-cols-2 gap-3">
                        @php
                            $layouts = [
                                'sidebar' => __('app.ui_switcher.layouts.sidebar'),
                                'sidebar_collapsible' => __('app.ui_switcher.layouts.sidebar_collapsible'),
                                'sidebar_hidden' => __('app.ui_switcher.layouts.sidebar_hidden'),
                                'topbar' => __('app.ui_switcher.layouts.topbar'),
                            ];
                        @endphp
                        @foreach($layouts as $key => $label)
                            <button
                                wire:click="setLayout('{{ $key }}')"
                                type="button"
                                @class([
                                    'flex flex-col items-center p-3 border-2 rounded-lg transition',
                                    'border-primary-500 bg-primary-50 dark:bg-primary-950' => $layout === $key,
                                    'border-gray-200 dark:border-gray-700' => $layout !== $key,
                                ])
                            >
                                @if($key === 'sidebar')
                                    <div class="flex w-12 h-8 border border-gray-300 dark:border-gray-600 rounded overflow-hidden">
                                        <div class="w-3 bg-gray-400 dark:bg-gray-500"></div>
                                        <div class="flex-1 bg-gray-100 dark:bg-gray-800"></div>
                                    </div>
                                @elseif($key === 'sidebar_collapsible')
                                    <div class="flex w-12 h-8 border border-gray-300 dark:border-gray-600 rounded overflow-hidden">
                                        <div class="w-2 bg-gray-400 dark:bg-gray-500 flex items-center justify-center">
                                            <div class="w-1 h-1 bg-gray-200 rounded-full"></div>
                                        </div>
                                        <div class="flex-1 bg-gray-100 dark:bg-gray-800"></div>
                                    </div>
                                @elseif($key === 'sidebar_hidden')
                                    <div class="flex w-12 h-8 border border-gray-300 dark:border-gray-600 rounded overflow-hidden">
                                        <div class="w-1 bg-gray-400 dark:bg-gray-500"></div>
                                        <div class="flex-1 bg-gray-100 dark:bg-gray-800"></div>
                                    </div>
                                @else
                                    <div class="flex flex-col w-12 h-8 border border-gray-300 dark:border-gray-600 rounded overflow-hidden">
                                        <div class="h-2 bg-gray-400 dark:bg-gray-500"></div>
                                        <div class="flex-1 bg-gray-100 dark:bg-gray-800"></div>
                                    </div>
                                @endif
                                <span class="mt-1.5 text-xs text-gray-600 dark:text-gray-400">{{ $label }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Color --}}
                <div>
                    <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">{{ __('app.ui_switcher.color') }}</label>
                    <div class="mt-2 flex flex-wrap gap-2">
                        @php
                            $hex = ['slate'=>'#64748b','gray'=>'#6b7280','zinc'=>'#71717a','neutral'=>'#737373','stone'=>'#78716c','red'=>'#ef4444','orange'=>'#f97316','amber'=>'#f59e0b','yellow'=>'#eab308','lime'=>'#84cc16','green'=>'#22c55e','emerald'=>'#10b981','teal'=>'#14b8a6','cyan'=>'#06b6d4','sky'=>'#0ea5e9','blue'=>'#3b82f6','indigo'=>'#6366f1','violet'=>'#8b5cf6','purple'=>'#a855f7','fuchsia'=>'#d946ef','pink'=>'#ec4899','rose'=>'#f43f5e'];
                        @endphp
                        @foreach($colors as $color)
                            <button
                                wire:click="setPrimaryColor('{{ $color }}')"
                                type="button"
                                class="relative w-8 h-8 rounded-full hover:scale-110 transition-transform"
                                style="background-color: {{ $hex[$color] ?? '#3b82f6' }}"
                                title="{{ ucfirst($color) }}"
                            >
                                @if($primaryColor === $color)
                                    <x-filament::icon icon="heroicon-s-check" class="absolute inset-0 m-auto w-4 h-4 text-white" />
                                @endif
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Font --}}
                <div>
                    <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">{{ __('app.ui_switcher.font') }}</label>
                    <div class="mt-2 grid grid-cols-2 gap-2">
                        @foreach($fonts as $font)
                            <button
                                wire:click="setFontFamily('{{ $font }}')"
                                type="button"
                                @class([
                                    'flex flex-col items-center p-3 border-2 rounded-lg transition',
                                    'border-primary-500 bg-primary-50 dark:bg-primary-950' => $fontFamily === $font,
                                    'border-gray-200 dark:border-gray-700' => $fontFamily !== $font,
                                ])
                                style="font-family: '{{ $font }}', sans-serif"
                            >
                                <span class="text-2xl font-medium text-gray-700 dark:text-gray-300">Aa</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $font }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Font Size --}}
                <div>
                    <div class="flex items-center justify-between">
                        <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">{{ __('app.ui_switcher.size') }}</label>
                        <span class="text-xs font-medium text-gray-700 dark:text-gray-300">{{ $fontSize }}px</span>
                    </div>
                    <input
                        type="range"
                        min="{{ config('ui-switcher.font_size.min', 12) }}"
                        max="{{ config('ui-switcher.font_size.max', 20) }}"
                        wire:model.live.debounce.300ms="fontSize"
                        class="mt-2 w-full h-1.5 bg-gray-200 rounded-lg cursor-pointer dark:bg-gray-700 accent-primary-500"
                    />
                </div>

                {{-- Reset --}}
                <button
                    wire:click="resetSettings"
                    type="button"
                    class="w-full py-2 text-sm text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition"
                >
                    {{ __('app.ui_switcher.reset') }}
                </button>
            </div>
        </div>
    </div>
</div>

@script
<script>
    // Set cookie helper attached to window for accessibility in event handlers
    window.setUiSwitcherCookie = function(name, value, days = 365) {
        const expires = new Date(Date.now() + days * 864e5).toUTCString();
        document.cookie = name + '=' + encodeURIComponent(value) + '; expires=' + expires + '; path=/; SameSite=Lax';
    };

    $wire.on('reload-page', () => window.location.reload());

    $wire.on('layout-changed', ({ layout }) => {
        window.setUiSwitcherCookie('filament_layout', layout);
        window.location.reload();
    });

    $wire.on('reset-settings', ({ layout }) => {
        window.setUiSwitcherCookie('filament_layout', layout);
        localStorage.removeItem('theme');
        window.location.reload();
    });

    $wire.on('font-size-changed', ({ size }) => {
        document.documentElement.style.fontSize = size + 'px';
    });
</script>
@endscript
