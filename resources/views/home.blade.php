<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <x-head />

    <body class="bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800 min-h-screen flex flex-col">
        <!-- Header -->
        <header class="w-full py-4 px-6">
            <nav class="max-w-6xl mx-auto flex items-center justify-between">
                <div class="text-xl font-bold text-slate-800 dark:text-white">
                    {{ config('app.name', 'Laravel') }}
                </div>

                @if (Route::has('filament.admin.auth.login'))
                    <div class="flex items-center gap-4">
                        @auth
                            <a href="{{ url('/admin') }}"
                               class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                                {{ translator('home.dashboard') }}
                            </a>
                        @else
                            <a href="{{ route('filament.admin.auth.login') }}"
                               class="px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-200 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                {{ translator('home.login') }}
                            </a>
                        @endauth
                    </div>
                @endif
            </nav>
        </header>

        <!-- Main Content -->
        <main class="flex-1 flex items-center justify-center px-6">
            <div class="text-center max-w-2xl">
                <!-- Hero Icon -->
                <div class="mb-8 flex justify-center">
                    <div class="w-20 h-20 bg-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>

                <!-- Hero Text -->
                <h1 class="text-4xl md:text-5xl font-bold text-slate-800 dark:text-white mb-4">
                    {{ translator('home.welcome') }}
                </h1>

                <p class="text-lg text-slate-600 dark:text-slate-300 mb-8">
                    {{ translator('home.welcome_description') }}
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @auth
                        <a href="{{ url('/admin') }}"
                           class="px-6 py-3 text-base font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors shadow-md hover:shadow-lg">
                            {{ translator('home.go_to_dashboard') }}
                        </a>
                    @else
                        <a href="{{ route('filament.admin.auth.login') }}"
                           class="px-6 py-3 text-base font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors shadow-md hover:shadow-lg">
                            {{ translator('home.get_started') }}
                        </a>
                    @endauth
                </div>

                <!-- Features -->
                <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="p-6 bg-white dark:bg-slate-800 rounded-xl shadow-sm">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mb-4 mx-auto">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-2">{{ translator('home.feature_secure') }}</h3>
                        <p class="text-sm text-slate-600 dark:text-slate-400">{{ translator('home.feature_secure_desc') }}</p>
                    </div>

                    <div class="p-6 bg-white dark:bg-slate-800 rounded-xl shadow-sm">
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mb-4 mx-auto">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-2">{{ translator('home.feature_fast') }}</h3>
                        <p class="text-sm text-slate-600 dark:text-slate-400">{{ translator('home.feature_fast_desc') }}</p>
                    </div>

                    <div class="p-6 bg-white dark:bg-slate-800 rounded-xl shadow-sm">
                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center mb-4 mx-auto">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-2">{{ translator('home.feature_multilang') }}</h3>
                        <p class="text-sm text-slate-600 dark:text-slate-400">{{ translator('home.feature_multilang_desc') }}</p>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="py-6 px-6">
            <div class="max-w-6xl mx-auto text-center text-sm text-slate-500 dark:text-slate-400">
                &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. {{ translator('home.all_rights_reserved') }}
            </div>
        </footer>
    </body>
</html>
