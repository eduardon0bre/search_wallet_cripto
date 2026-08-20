<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Search Wallet Cripto') }} - Projeto de Estudos</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    @endif
</head>

<body class="relative bg-slate-950 text-slate-100 antialiased font-sans min-h-screen flex flex-col justify-between">
    <!-- Background Image (Fixed full-screen behind Header, Main and Footer) -->
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none">
        <img src="{{ asset('images/maxim-hopman-fiXLQXAhCfk-unsplash.jpg') }}" alt="Background" class="w-full h-full object-cover object-center" />
    </div>

    <!-- Navbar -->
    <header class="relative z-50 border-b border-slate-800/40 bg-slate-900/20 backdrop-blur-xl sticky top-0 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
            </div>

            <nav class="flex items-center gap-3">
                @auth
                <a href="{{ route('filament.admin.pages.dashboard') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-sky-600 hover:bg-sky-700 text-white font-medium text-sm transition-all shadow-sm">
                    <span>Acessar Painel</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
                @else
                <a href="{{ route('filament.admin.auth.login') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-sky-600 hover:bg-sky-700 text-white font-medium text-sm transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    <span> Entrar </span>
                </a>
                @endauth
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="relative z-10 flex-1 flex flex-col justify-between py-12 sm:py-16">
        <!-- Hero Section -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full mb-12 sm:mb-16">
            <div class="max-w-2xl text-left">
                <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight leading-tight">
                    Estudando Tecnologias <br />
                    <span class="text-sky-400">
                        Laravel & Filament PHP
                    </span>
                </h1>

                <p class="mt-6 text-base sm:text-lg text-slate-300 leading-relaxed">
                    <strong>Projeto de estudo em Laravel para testar arquitetura de software, com painel
                        administrativo em Filament v3, componentes reativos em Livewire e gestão de
                        carteiras cripto e integração com APIs externas.</strong>
                </p>

                <!-- Call to Action Buttons -->
                <div class="mt-10 flex flex-col sm:flex-row items-center justify-start gap-4">
                    @auth
                    <a href="{{ route('filament.admin.pages.dashboard') }}"
                        class="w-full sm:w-auto px-7 py-3.5 rounded-xl bg-sky-600 hover:bg-sky-700 text-white font-semibold text-base transition-all shadow-md flex items-center justify-center gap-2">
                        <span>Acessar Painel</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                    @else
                    <a href="{{ route('filament.admin.auth.login') }}"
                        class="w-full sm:w-auto px-7 py-3.5 rounded-xl bg-sky-600 hover:bg-sky-700 text-white font-semibold text-base transition-all shadow-md flex items-center justify-center gap-2">
                        <span> Entrar </span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                    </a>
                    @endauth
                </div>
            </div>
        </section>

        <!-- Tech Stack & Explanation Section (Floating Cards) -->
        <section id="tecnologias" class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 w-full mb-12">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <h2 class="text-2xl font-bold text-white">Stack do Projeto</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Tech Card 1: Laravel -->
                <div class="p-6 rounded-2xl bg-slate-900/40 backdrop-blur-xl border border-slate-800/50 shadow-lg hover:shadow-xl hover:border-red-400/50 hover:-translate-y-1 transition-all duration-300 group">
                    <div class="w-12 h-12 rounded-xl bg-red-950/50 border border-red-800/40 flex items-center justify-center mb-4 shadow-sm group-hover:scale-105 transition-transform p-2.5">
                        <img src="{{ asset('images/logos/laravel.svg') }}" alt="Laravel Logo" class="w-full h-full object-contain" />
                    </div>
                    <h3 class="text-base font-bold text-white mb-1">Laravel Framework</h3>
                </div>

                <!-- Tech Card 2: Filament PHP -->
                <div class="p-6 rounded-2xl bg-slate-900/40 backdrop-blur-xl border border-slate-800/50 shadow-lg hover:shadow-xl hover:border-amber-400/50 hover:-translate-y-1 transition-all duration-300 group">
                    <div class="w-12 h-12 rounded-xl bg-amber-950/50 border border-amber-800/40 flex items-center justify-center mb-4 shadow-sm group-hover:scale-105 transition-transform p-2.5">
                        <img src="{{ asset('images/logos/logomark.svg') }}" alt="Filament PHP Logo" class="w-full h-full object-contain" />
                    </div>
                    <h3 class="text-base font-bold text-white mb-1">Filament PHP v3</h3>
                </div>

                <!-- Tech Card 3: Tailwind CSS -->
                <div class="p-6 rounded-2xl bg-slate-900/40 backdrop-blur-xl border border-slate-800/50 shadow-lg hover:shadow-xl hover:border-sky-400/50 hover:-translate-y-1 transition-all duration-300 group">
                    <div class="w-12 h-12 rounded-xl bg-sky-950/50 border border-sky-800/40 flex items-center justify-center mb-4 shadow-sm group-hover:scale-105 transition-transform p-2.5">
                        <img src="{{ asset('images/logos/tailwindcss.svg') }}" alt="Tailwind CSS Logo" class="w-full h-full object-contain" />
                    </div>
                    <h3 class="text-base font-bold text-white mb-1">Tailwind CSS</h3>
                </div>

                <!-- Tech Card 4: Livewire -->
                <div class="p-6 rounded-2xl bg-slate-900/40 backdrop-blur-xl border border-slate-800/50 shadow-lg hover:shadow-xl hover:border-pink-400/50 hover:-translate-y-1 transition-all duration-300 group">
                    <div class="w-12 h-12 rounded-xl bg-pink-950/50 border border-pink-800/40 flex items-center justify-center mb-4 shadow-sm group-hover:scale-105 transition-transform p-2.5">
                        <img src="{{ asset('images/logos/livewire.svg') }}" alt="Livewire Logo" class="w-full h-full object-contain" />
                    </div>
                    <h3 class="text-base font-bold text-white mb-1">Livewire 3</h3>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-slate-400 text-xs">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }} &bull; Projeto de Estudo & Aprendizado Tecnológico</p>
            </div>
        </footer>
    </main>
</body>

</html>