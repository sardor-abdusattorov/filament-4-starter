<div>
    {{-- Toggle Button --}}
    <button
        wire:click="toggle"
        type="button"
        class="fi-icon-btn relative flex items-center justify-center rounded-lg outline-none transition duration-75 focus-visible:ring-2 disabled:pointer-events-none disabled:opacity-70 -m-1.5 h-9 w-9 text-gray-400 hover:text-gray-500 focus-visible:ring-primary-600 dark:text-gray-500 dark:hover:text-gray-400 dark:focus-visible:ring-primary-500"
        title="UI Settings"
    >
        <x-filament::icon
            icon="heroicon-o-cog-6-tooth"
            class="h-5 w-5"
        />
    </button>

    {{-- Slide-over Panel --}}
    <div
        x-data="{ open: @entangle('isOpen') }"
        x-show="open"
        x-cloak
        class="fixed inset-0 z-50 overflow-hidden"
        aria-labelledby="slide-over-title"
        role="dialog"
        aria-modal="true"
    >
        {{-- Backdrop --}}
        <div
            x-show="open"
            x-transition:enter="ease-in-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in-out duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-500/75 dark:bg-gray-900/75 transition-opacity"
            @click="$wire.close()"
        ></div>

        {{-- Panel --}}
        <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
            <div
                x-show="open"
                x-transition:enter="transform transition ease-in-out duration-300"
                x-transition:enter-start="translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transform transition ease-in-out duration-300"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full"
                class="w-screen max-w-md"
            >
                <div class="flex h-full flex-col overflow-y-scroll bg-white dark:bg-gray-900 shadow-xl">
                    {{-- Header --}}
                    <div class="flex items-center justify-between px-4 py-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-2">
                            <x-filament::icon
                                icon="heroicon-o-cog-6-tooth"
                                class="h-5 w-5 text-gray-500 dark:text-gray-400"
                            />
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white" id="slide-over-title">
                                {{ __('Settings') }}
                            </h2>
                        </div>
                        <div class="flex items-center gap-2">
                            <button
                                wire:click="resetSettings"
                                type="button"
                                class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400"
                                title="{{ __('Reset') }}"
                            >
                                <x-filament::icon
                                    icon="heroicon-o-arrow-path"
                                    class="h-5 w-5"
                                />
                            </button>
                            <button
                                wire:click="close"
                                type="button"
                                class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400"
                            >
                                <x-filament::icon
                                    icon="heroicon-o-x-mark"
                                    class="h-5 w-5"
                                />
                            </button>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="flex-1 px-4 py-6 space-y-8">
                        {{-- Theme Mode --}}
                        <div>
                            <div class="flex items-center gap-2 mb-4">
                                <x-filament::icon
                                    icon="heroicon-o-computer-desktop"
                                    class="h-5 w-5 text-gray-500 dark:text-gray-400"
                                />
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white">{{ __('Mode') }}</h3>
                            </div>
                            <div class="flex gap-2 p-1 bg-gray-100 dark:bg-gray-800 rounded-lg">
                                <button
                                    wire:click="setTheme('light')"
                                    type="button"
                                    @class([
                                        'flex-1 flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium rounded-md transition-colors',
                                        'bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm' => $theme === 'light',
                                        'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300' => $theme !== 'light',
                                    ])
                                >
                                    <x-filament::icon icon="heroicon-o-sun" class="h-4 w-4" />
                                </button>
                                <button
                                    wire:click="setTheme('dark')"
                                    type="button"
                                    @class([
                                        'flex-1 flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium rounded-md transition-colors',
                                        'bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm' => $theme === 'dark',
                                        'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300' => $theme !== 'dark',
                                    ])
                                >
                                    <x-filament::icon icon="heroicon-o-moon" class="h-4 w-4" />
                                </button>
                                <button
                                    wire:click="setTheme('system')"
                                    type="button"
                                    @class([
                                        'flex-1 flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium rounded-md transition-colors',
                                        'bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm' => $theme === 'system',
                                        'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300' => $theme !== 'system',
                                    ])
                                >
                                    <x-filament::icon icon="heroicon-o-computer-desktop" class="h-4 w-4" />
                                </button>
                            </div>
                        </div>

                        {{-- Layout --}}
                        <div>
                            <div class="flex items-center gap-2 mb-4">
                                <x-filament::icon
                                    icon="heroicon-o-squares-2x2"
                                    class="h-5 w-5 text-gray-500 dark:text-gray-400"
                                />
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white">{{ __('Layout') }}</h3>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                @foreach($availableLayouts as $layoutKey => $layoutLabel)
                                    <button
                                        wire:click="setLayout('{{ $layoutKey }}')"
                                        type="button"
                                        @class([
                                            'relative flex flex-col items-center justify-center p-4 border-2 rounded-lg transition-colors',
                                            'border-primary-500 bg-primary-50 dark:bg-primary-950' => $layout === $layoutKey,
                                            'border-gray-200 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600' => $layout !== $layoutKey,
                                        ])
                                    >
                                        @if($layoutKey === 'sidebar')
                                            <div class="flex w-16 h-12 border border-gray-300 dark:border-gray-600 rounded overflow-hidden">
                                                <div class="w-4 bg-gray-300 dark:bg-gray-600"></div>
                                                <div class="flex-1 bg-gray-100 dark:bg-gray-800"></div>
                                            </div>
                                        @else
                                            <div class="flex flex-col w-16 h-12 border border-gray-300 dark:border-gray-600 rounded overflow-hidden">
                                                <div class="h-3 bg-gray-300 dark:bg-gray-600"></div>
                                                <div class="flex-1 bg-gray-100 dark:bg-gray-800"></div>
                                            </div>
                                        @endif
                                        <span class="mt-2 text-xs font-medium text-gray-700 dark:text-gray-300">{{ $layoutLabel }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- Primary Color --}}
                        <div>
                            <div class="flex items-center gap-2 mb-4">
                                <x-filament::icon
                                    icon="heroicon-o-swatch"
                                    class="h-5 w-5 text-gray-500 dark:text-gray-400"
                                />
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white">{{ __('Color') }}</h3>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                @foreach($availableColors as $colorName => $colorHex)
                                    <button
                                        wire:click="setPrimaryColor('{{ $colorName }}')"
                                        type="button"
                                        class="relative w-8 h-8 rounded-full transition-transform hover:scale-110 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-900"
                                        style="background-color: {{ $colorHex }};"
                                        title="{{ ucfirst($colorName) }}"
                                    >
                                        @if($primaryColor === $colorName)
                                            <span class="absolute inset-0 flex items-center justify-center">
                                                <x-filament::icon
                                                    icon="heroicon-s-check"
                                                    class="h-4 w-4 text-white"
                                                />
                                            </span>
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- Font --}}
                        <div>
                            <div class="flex items-center gap-2 mb-4">
                                <x-filament::icon
                                    icon="heroicon-o-language"
                                    class="h-5 w-5 text-gray-500 dark:text-gray-400"
                                />
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white">{{ __('Font') }}</h3>
                            </div>

                            {{-- Font Family --}}
                            <div class="mb-4">
                                <label class="block text-xs text-gray-500 dark:text-gray-400 mb-2">{{ __('Family') }}</label>
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach($availableFonts as $fontKey => $fontLabel)
                                        <button
                                            wire:click="setFontFamily('{{ $fontKey }}')"
                                            type="button"
                                            @class([
                                                'flex flex-col items-center justify-center p-3 border-2 rounded-lg transition-colors',
                                                'border-primary-500 bg-primary-50 dark:bg-primary-950' => $fontFamily === $fontKey,
                                                'border-gray-200 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600' => $fontFamily !== $fontKey,
                                            ])
                                            style="font-family: '{{ $fontKey }}', sans-serif;"
                                        >
                                            <span class="text-2xl font-medium text-gray-700 dark:text-gray-300">Aa</span>
                                            <span class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $fontLabel }}</span>
                                            @if($fontFamily === $fontKey)
                                                <span class="absolute top-1 right-1">
                                                    <x-filament::icon
                                                        icon="heroicon-s-check-circle"
                                                        class="h-4 w-4 text-primary-500"
                                                    />
                                                </span>
                                            @endif
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Font Size --}}
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <label class="text-xs text-gray-500 dark:text-gray-400">{{ __('Size') }}</label>
                                    <span class="text-xs font-medium text-gray-700 dark:text-gray-300">{{ $fontSize }}px</span>
                                </div>
                                <input
                                    type="range"
                                    min="12"
                                    max="20"
                                    step="1"
                                    wire:model.live="fontSize"
                                    wire:change="setFontSize($event.target.value)"
                                    class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700 accent-primary-500"
                                />
                                <div class="flex justify-between text-xs text-gray-400 mt-1">
                                    <span>12px</span>
                                    <span>20px</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script>
    $wire.on('ui-settings-changed', ({ setting, value }) => {
        applyUiSetting(setting, value);
    });

    $wire.on('ui-settings-reset', () => {
        // Reload page to apply default settings
        window.location.reload();
    });

    function applyUiSetting(setting, value) {
        switch (setting) {
            case 'theme':
                applyTheme(value);
                break;
            case 'primary_color':
                applyPrimaryColor(value);
                break;
            case 'font_family':
                applyFontFamily(value);
                break;
            case 'font_size':
                applyFontSize(value);
                break;
            case 'layout':
                // Layout change requires page reload
                window.location.reload();
                break;
        }
    }

    function applyTheme(theme) {
        const html = document.documentElement;

        if (theme === 'dark') {
            html.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        } else if (theme === 'light') {
            html.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        } else {
            // System preference
            localStorage.removeItem('theme');
            if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                html.classList.add('dark');
            } else {
                html.classList.remove('dark');
            }
        }
    }

    function applyPrimaryColor(color) {
        // Store for page reload application
        // The actual color will be applied on next page load via CSS variables
        // For immediate effect, we can try to update CSS variables
        const colorMap = {
            'slate': { '50': '248, 250, 252', '100': '241, 245, 249', '200': '226, 232, 240', '300': '203, 213, 225', '400': '148, 163, 184', '500': '100, 116, 139', '600': '71, 85, 105', '700': '51, 65, 85', '800': '30, 41, 59', '900': '15, 23, 42', '950': '2, 6, 23' },
            'gray': { '50': '249, 250, 251', '100': '243, 244, 246', '200': '229, 231, 235', '300': '209, 213, 219', '400': '156, 163, 175', '500': '107, 114, 128', '600': '75, 85, 99', '700': '55, 65, 81', '800': '31, 41, 55', '900': '17, 24, 39', '950': '3, 7, 18' },
            'zinc': { '50': '250, 250, 250', '100': '244, 244, 245', '200': '228, 228, 231', '300': '212, 212, 216', '400': '161, 161, 170', '500': '113, 113, 122', '600': '82, 82, 91', '700': '63, 63, 70', '800': '39, 39, 42', '900': '24, 24, 27', '950': '9, 9, 11' },
            'neutral': { '50': '250, 250, 250', '100': '245, 245, 245', '200': '229, 229, 229', '300': '212, 212, 212', '400': '163, 163, 163', '500': '115, 115, 115', '600': '82, 82, 82', '700': '64, 64, 64', '800': '38, 38, 38', '900': '23, 23, 23', '950': '10, 10, 10' },
            'stone': { '50': '250, 250, 249', '100': '245, 245, 244', '200': '231, 229, 228', '300': '214, 211, 209', '400': '168, 162, 158', '500': '120, 113, 108', '600': '87, 83, 78', '700': '68, 64, 60', '800': '41, 37, 36', '900': '28, 25, 23', '950': '12, 10, 9' },
            'red': { '50': '254, 242, 242', '100': '254, 226, 226', '200': '254, 202, 202', '300': '252, 165, 165', '400': '248, 113, 113', '500': '239, 68, 68', '600': '220, 38, 38', '700': '185, 28, 28', '800': '153, 27, 27', '900': '127, 29, 29', '950': '69, 10, 10' },
            'orange': { '50': '255, 247, 237', '100': '255, 237, 213', '200': '254, 215, 170', '300': '253, 186, 116', '400': '251, 146, 60', '500': '249, 115, 22', '600': '234, 88, 12', '700': '194, 65, 12', '800': '154, 52, 18', '900': '124, 45, 18', '950': '67, 20, 7' },
            'amber': { '50': '255, 251, 235', '100': '254, 243, 199', '200': '253, 230, 138', '300': '252, 211, 77', '400': '251, 191, 36', '500': '245, 158, 11', '600': '217, 119, 6', '700': '180, 83, 9', '800': '146, 64, 14', '900': '120, 53, 15', '950': '69, 26, 3' },
            'yellow': { '50': '254, 252, 232', '100': '254, 249, 195', '200': '254, 240, 138', '300': '253, 224, 71', '400': '250, 204, 21', '500': '234, 179, 8', '600': '202, 138, 4', '700': '161, 98, 7', '800': '133, 77, 14', '900': '113, 63, 18', '950': '66, 32, 6' },
            'lime': { '50': '247, 254, 231', '100': '236, 252, 203', '200': '217, 249, 157', '300': '190, 242, 100', '400': '163, 230, 53', '500': '132, 204, 22', '600': '101, 163, 13', '700': '77, 124, 15', '800': '63, 98, 18', '900': '54, 83, 20', '950': '26, 46, 5' },
            'green': { '50': '240, 253, 244', '100': '220, 252, 231', '200': '187, 247, 208', '300': '134, 239, 172', '400': '74, 222, 128', '500': '34, 197, 94', '600': '22, 163, 74', '700': '21, 128, 61', '800': '22, 101, 52', '900': '20, 83, 45', '950': '5, 46, 22' },
            'emerald': { '50': '236, 253, 245', '100': '209, 250, 229', '200': '167, 243, 208', '300': '110, 231, 183', '400': '52, 211, 153', '500': '16, 185, 129', '600': '5, 150, 105', '700': '4, 120, 87', '800': '6, 95, 70', '900': '6, 78, 59', '950': '2, 44, 34' },
            'teal': { '50': '240, 253, 250', '100': '204, 251, 241', '200': '153, 246, 228', '300': '94, 234, 212', '400': '45, 212, 191', '500': '20, 184, 166', '600': '13, 148, 136', '700': '15, 118, 110', '800': '17, 94, 89', '900': '19, 78, 74', '950': '4, 47, 46' },
            'cyan': { '50': '236, 254, 255', '100': '207, 250, 254', '200': '165, 243, 252', '300': '103, 232, 249', '400': '34, 211, 238', '500': '6, 182, 212', '600': '8, 145, 178', '700': '14, 116, 144', '800': '21, 94, 117', '900': '22, 78, 99', '950': '8, 51, 68' },
            'sky': { '50': '240, 249, 255', '100': '224, 242, 254', '200': '186, 230, 253', '300': '125, 211, 252', '400': '56, 189, 248', '500': '14, 165, 233', '600': '2, 132, 199', '700': '3, 105, 161', '800': '7, 89, 133', '900': '12, 74, 110', '950': '8, 47, 73' },
            'blue': { '50': '239, 246, 255', '100': '219, 234, 254', '200': '191, 219, 254', '300': '147, 197, 253', '400': '96, 165, 250', '500': '59, 130, 246', '600': '37, 99, 235', '700': '29, 78, 216', '800': '30, 64, 175', '900': '30, 58, 138', '950': '23, 37, 84' },
            'indigo': { '50': '238, 242, 255', '100': '224, 231, 255', '200': '199, 210, 254', '300': '165, 180, 252', '400': '129, 140, 248', '500': '99, 102, 241', '600': '79, 70, 229', '700': '67, 56, 202', '800': '55, 48, 163', '900': '49, 46, 129', '950': '30, 27, 75' },
            'violet': { '50': '245, 243, 255', '100': '237, 233, 254', '200': '221, 214, 254', '300': '196, 181, 253', '400': '167, 139, 250', '500': '139, 92, 246', '600': '124, 58, 237', '700': '109, 40, 217', '800': '91, 33, 182', '900': '76, 29, 149', '950': '46, 16, 101' },
            'purple': { '50': '250, 245, 255', '100': '243, 232, 255', '200': '233, 213, 255', '300': '216, 180, 254', '400': '192, 132, 252', '500': '168, 85, 247', '600': '147, 51, 234', '700': '126, 34, 206', '800': '107, 33, 168', '900': '88, 28, 135', '950': '59, 7, 100' },
            'fuchsia': { '50': '253, 244, 255', '100': '250, 232, 255', '200': '245, 208, 254', '300': '240, 171, 252', '400': '232, 121, 249', '500': '217, 70, 239', '600': '192, 38, 211', '700': '162, 28, 175', '800': '134, 25, 143', '900': '112, 26, 117', '950': '74, 4, 78' },
            'pink': { '50': '253, 242, 248', '100': '252, 231, 243', '200': '251, 207, 232', '300': '249, 168, 212', '400': '244, 114, 182', '500': '236, 72, 153', '600': '219, 39, 119', '700': '190, 24, 93', '800': '157, 23, 77', '900': '131, 24, 67', '950': '80, 7, 36' },
            'rose': { '50': '255, 241, 242', '100': '255, 228, 230', '200': '254, 205, 211', '300': '253, 164, 175', '400': '251, 113, 133', '500': '244, 63, 94', '600': '225, 29, 72', '700': '190, 18, 60', '800': '159, 18, 57', '900': '136, 19, 55', '950': '76, 5, 25' },
        };

        if (colorMap[color]) {
            const root = document.documentElement;
            Object.entries(colorMap[color]).forEach(([shade, rgb]) => {
                root.style.setProperty(`--primary-${shade}`, rgb);
            });
        }
    }

    function applyFontFamily(font) {
        document.documentElement.style.setProperty('--font-family', `"${font}", ui-sans-serif, system-ui, sans-serif`);
        document.body.style.fontFamily = `"${font}", ui-sans-serif, system-ui, sans-serif`;
    }

    function applyFontSize(size) {
        document.documentElement.style.fontSize = `${size}px`;
    }
</script>
@endscript
