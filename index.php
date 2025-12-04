<!DOCTYPE html>
<html class="dark" lang="tr">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>HowwydSheet - Modern Alt Sayfa Kütüphanesi</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />

    <!-- Styles -->
    <link rel="stylesheet" href="/src/output.css">
    <link rel="stylesheet" href="howwydsheet.css">

    <!-- Scripts -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="howwydsheet.js"></script>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('darkMode', {
                on: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),

                toggle() {
                    this.on = !this.on;
                    localStorage.setItem('theme', this.on ? 'dark' : 'light');
                    this.updateHtml();
                },

                updateHtml() {
                    if (this.on) {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                },

                init() {
                    this.updateHtml();
                }
            });
        });
    </script>

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>

<body class="font-display bg-background-light dark:bg-background-dark text-slate-900 dark:text-white overflow-x-hidden"
    x-data="{ mobileMenuOpen: false }">
    <div class="relative flex h-auto min-h-screen w-full flex-col group/design-root">

        <!-- Ambient Background Effects -->
        <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none">
            <div
                class="absolute top-0 left-1/4 w-96 h-96 bg-primary/20 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob">
            </div>
            <div
                class="absolute top-0 right-1/4 w-96 h-96 bg-purple-500/20 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000">
            </div>
            <div
                class="absolute -bottom-32 left-1/3 w-96 h-96 bg-pink-500/20 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000">
            </div>
        </div>

        <div class="layout-container flex h-full grow flex-col relative z-10">
            <div class="px-4 md:px-10 lg:px-20 xl:px-40 flex flex-1 justify-center py-5">
                <div class="layout-content-container flex flex-col w-full max-w-[1200px] flex-1">

                    <!-- Header -->
                    <header
                        class="flex items-center justify-between whitespace-nowrap border-b border-solid border-slate-200 dark:border-slate-800/50 bg-white/50 dark:bg-[#151022]/50 backdrop-blur-md px-4 sm:px-10 py-4 rounded-2xl sticky top-4 z-50 shadow-sm">
                        <div class="flex items-center gap-8">
                            <a href="/" class="flex items-center gap-3 group">
                                <div
                                    class="size-8 text-primary group-hover:scale-110 transition-transform duration-300">
                                    <svg fill="none" viewbox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                                        <path clip-rule="evenodd"
                                            d="M12.0799 24L4 19.2479L9.95537 8.75216L18.04 13.4961L18.0446 4H29.9554L29.96 13.4961L38.0446 8.75216L44 19.2479L35.92 24L44 28.7521L38.0446 39.2479L29.96 34.5039L29.9554 44H18.0446L18.04 34.5039L9.95537 39.2479L4 28.7521L12.0799 24Z"
                                            fill="currentColor" fill-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <h2 class="text-xl font-bold leading-tight tracking-tight">HowwydSheet</h2>
                            </a>
                        </div>

                        <!-- Desktop Nav -->
                        <nav class="hidden md:flex items-center gap-6">
                            <a href="docs.php"
                                class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary transition-colors">Dokümantasyon</a>
                            <a href="#features"
                                class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary transition-colors">Özellikler</a>
                            <a href="#examples"
                                class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary transition-colors">Örnekler</a>
                        </nav>

                        <!-- Actions -->
                        <div class="flex items-center gap-3">
                            <a href="https://github.com" target="_blank"
                                class="hidden sm:flex h-10 w-10 cursor-pointer items-center justify-center overflow-hidden rounded-xl bg-slate-100 dark:bg-white/5 text-slate-600 dark:text-white hover:bg-slate-200 dark:hover:bg-white/10 transition-all hover:scale-105">
                                <span class="material-symbols-outlined text-xl">code</span>
                            </a>
                            <button @click="$store.darkMode.toggle()"
                                class="flex h-10 w-10 cursor-pointer items-center justify-center overflow-hidden rounded-xl bg-slate-100 dark:bg-white/5 text-slate-600 dark:text-white hover:bg-slate-200 dark:hover:bg-white/10 transition-all hover:scale-105">
                                <span class="material-symbols-outlined text-xl"
                                    x-text="$store.darkMode.on ? 'light_mode' : 'dark_mode'">dark_mode</span>
                            </button>
                            <a href="docs.php"
                                class="hidden sm:flex h-10 px-5 cursor-pointer items-center justify-center rounded-xl bg-primary text-white font-bold text-sm hover:bg-primary/90 transition-all hover:scale-105 shadow-lg shadow-primary/25">
                                Başla
                            </a>
                            <!-- Mobile Menu Button -->
                            <button @click="mobileMenuOpen = !mobileMenuOpen"
                                class="md:hidden p-2 text-slate-600 dark:text-white">
                                <span class="material-symbols-outlined">menu</span>
                            </button>
                        </div>
                    </header>

                    <!-- Mobile Menu Overlay -->
                    <div x-show="mobileMenuOpen" class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm md:hidden"
                        @click="mobileMenuOpen = false" x-transition.opacity></div>
                    <div x-show="mobileMenuOpen"
                        class="fixed inset-y-0 right-0 z-50 w-64 bg-background-light dark:bg-background-dark p-6 shadow-2xl md:hidden"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0"
                        x-transition:leave-end="translate-x-full">
                        <div class="flex flex-col gap-6">
                            <div class="flex justify-between items-center">
                                <h3 class="font-bold text-lg">Menü</h3>
                                <button @click="mobileMenuOpen = false"><span
                                        class="material-symbols-outlined">close</span></button>
                            </div>
                            <nav class="flex flex-col gap-4">
                                <a href="docs.php" class="text-lg font-medium">Dokümantasyon</a>
                                <a href="#features" class="text-lg font-medium">Özellikler</a>
                                <a href="#examples" class="text-lg font-medium">Örnekler</a>
                            </nav>
                        </div>
                    </div>

                    <main class="flex-1">
                        <!-- Hero Section -->
                        <div class="pt-20 sm:pt-32 pb-16">
                            <div class="flex flex-col gap-8 items-center justify-center text-center px-4">
                                <div
                                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 border border-primary/20 text-primary text-sm font-medium animate-bounce">
                                    <span class="relative flex h-2 w-2">
                                        <span
                                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                                    </span>
                                    v2.0 Şimdi Yayında
                                </div>

                                <h1
                                    class="text-5xl sm:text-7xl font-black leading-tight tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-slate-900 via-primary to-slate-900 dark:from-white dark:via-primary dark:to-white max-w-4xl">
                                    Web için Modern <br /> Alt Sayfa Deneyimi
                                </h1>

                                <p
                                    class="text-slate-600 dark:text-slate-300 text-lg sm:text-xl font-normal leading-relaxed max-w-2xl mx-auto">
                                    Mobil uygulamaların akıcı hissini web sitenize taşıyın. AlpineJS ile güçlendirilmiş,
                                    hafif ve tamamen özelleştirilebilir alt sayfa (bottom sheet) kütüphanesi.
                                </p>

                                <div
                                    class="flex flex-col sm:flex-row flex-wrap gap-4 mt-4 justify-center w-full sm:w-auto">
                                    <a href="docs.php"
                                        class="flex items-center justify-center gap-2 h-14 px-8 rounded-2xl bg-primary text-white text-lg font-bold hover:bg-primary/90 transition-all hover:scale-105 shadow-xl shadow-primary/30 w-full sm:w-auto">
                                        <span class="material-symbols-outlined">rocket_launch</span>
                                        Hemen Başla
                                    </a>
                                    <button
                                        class="flex items-center justify-center gap-2 h-14 px-8 rounded-2xl bg-white dark:bg-white/10 text-slate-900 dark:text-white border border-slate-200 dark:border-white/10 text-lg font-bold hover:bg-slate-50 dark:hover:bg-white/20 transition-all hover:scale-105 w-full sm:w-auto">
                                        <span class="material-symbols-outlined">code</span>
                                        GitHub
                                    </button>
                                </div>

                                <!-- Code Preview -->
                                <div
                                    class="mt-12 w-full max-w-3xl mx-auto bg-[#1e1e1e] rounded-2xl shadow-2xl overflow-hidden border border-white/10 text-left transform hover:scale-[1.01] transition-transform duration-500">
                                    <div class="flex items-center gap-2 px-4 py-3 bg-[#252526] border-b border-white/5">
                                        <div class="flex gap-1.5">
                                            <div class="w-3 h-3 rounded-full bg-[#ff5f56]"></div>
                                            <div class="w-3 h-3 rounded-full bg-[#ffbd2e]"></div>
                                            <div class="w-3 h-3 rounded-full bg-[#27c93f]"></div>
                                        </div>
                                        <span class="text-xs text-gray-400 ml-2 font-mono">index.html</span>
                                    </div>
                                    <div class="p-6 overflow-x-auto">
                                        <pre class="font-mono text-sm text-gray-300"><code><span class="text-purple-400">&lt;div</span> <span class="text-blue-400">x-data</span>=<span class="text-green-400">"howwydSheet()"</span> <span class="text-purple-400">&gt;</span>
  <span class="text-gray-500">&lt;!-- Tetikleyici --&gt;</span>
  <span class="text-purple-400">&lt;button</span> <span class="text-blue-400">@click</span>=<span class="text-green-400">"show()"</span><span class="text-purple-400">&gt;</span>Sayfayı Aç<span class="text-purple-400">&lt;/button&gt;</span>

  <span class="text-gray-500">&lt;!-- Sayfa İçeriği --&gt;</span>
  <span class="text-purple-400">&lt;div</span> <span class="text-blue-400">class</span>=<span class="text-green-400">"sheet"</span> <span class="text-blue-400">x-show</span>=<span class="text-green-400">"isVisible"</span><span class="text-purple-400">&gt;</span>
    ...
  <span class="text-purple-400">&lt;/div&gt;</span>
<span class="text-purple-400">&lt;/div&gt;</span></code></pre>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Features Section -->
                        <section id="features" class="py-20 relative">
                            <div
                                class="absolute inset-0 bg-slate-50/50 dark:bg-white/5 skew-y-3 transform origin-top-left -z-10">
                            </div>
                            <div class="max-w-[1200px] mx-auto px-4">
                                <div class="text-center mb-16">
                                    <h2 class="text-3xl md:text-4xl font-black mb-4">Neden HowwydSheet?</h2>
                                    <p class="text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">Geliştirici dostu
                                        API ve kullanıcı odaklı tasarımın mükemmel birleşimi.</p>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                                    <!-- Feature 1 -->
                                    <div
                                        class="p-8 rounded-3xl bg-white dark:bg-[#1e1a2e] border border-slate-100 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none hover:-translate-y-2 transition-transform duration-300">
                                        <div
                                            class="w-14 h-14 rounded-2xl bg-blue-500/10 flex items-center justify-center text-blue-500 mb-6">
                                            <span class="material-symbols-outlined text-3xl">bolt</span>
                                        </div>
                                        <h3 class="text-xl font-bold mb-3">Ultra Hafif</h3>
                                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed">Gereksiz kod
                                            yığınlarından arındırılmış. Sadece ihtiyacınız olan özellikler, maksimum
                                            performans.</p>
                                    </div>

                                    <!-- Feature 2 -->
                                    <div
                                        class="p-8 rounded-3xl bg-white dark:bg-[#1e1a2e] border border-slate-100 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none hover:-translate-y-2 transition-transform duration-300">
                                        <div
                                            class="w-14 h-14 rounded-2xl bg-purple-500/10 flex items-center justify-center text-purple-500 mb-6">
                                            <span class="material-symbols-outlined text-3xl">touch_app</span>
                                        </div>
                                        <h3 class="text-xl font-bold mb-3">Dokunmatik Dostu</h3>
                                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed">Doğal kaydırma
                                            hissi ve hassas dokunmatik kontroller ile mobil uygulama deneyimi.</p>
                                    </div>

                                    <!-- Feature 3 -->
                                    <div
                                        class="p-8 rounded-3xl bg-white dark:bg-[#1e1a2e] border border-slate-100 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none hover:-translate-y-2 transition-transform duration-300">
                                        <div
                                            class="w-14 h-14 rounded-2xl bg-pink-500/10 flex items-center justify-center text-pink-500 mb-6">
                                            <span class="material-symbols-outlined text-3xl">palette</span>
                                        </div>
                                        <h3 class="text-xl font-bold mb-3">Tam Özelleştirilebilir</h3>
                                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed">Tailwind CSS ile
                                            uyumlu. Tasarımınıza mükemmel şekilde uyum sağlaması için esnek yapı.</p>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Examples Section -->
                        <section id="examples" class="py-20" x-data>
                            <div class="max-w-[1200px] mx-auto px-4">
                                <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-4">
                                    <div>
                                        <h2 class="text-3xl md:text-4xl font-black mb-4">Canlı Örnekler</h2>
                                        <p class="text-slate-600 dark:text-slate-400">Farklı kullanım senaryolarını
                                            deneyimleyin.</p>
                                    </div>
                                    <a href="docs.php#examples"
                                        class="text-primary font-bold hover:underline flex items-center gap-1">
                                        Tümünü Gör <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                    </a>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Example 1 -->
                                    <div
                                        class="group bg-white dark:bg-[#1e1a2e] p-1 rounded-3xl border border-slate-200 dark:border-slate-800 hover:border-primary/50 transition-colors">
                                        <div
                                            class="bg-slate-50 dark:bg-[#151022] p-8 rounded-[20px] h-full flex flex-col">
                                            <div class="flex items-center gap-4 mb-6">
                                                <div
                                                    class="w-12 h-12 rounded-xl bg-white dark:bg-white/5 flex items-center justify-center shadow-sm">
                                                    <span
                                                        class="material-symbols-outlined text-primary text-2xl">aspect_ratio</span>
                                                </div>
                                                <div>
                                                    <h3 class="text-xl font-bold">Özel Boyut</h3>
                                                    <p class="text-sm text-slate-500">Başlangıç: %75</p>
                                                </div>
                                            </div>
                                            <p class="text-slate-600 dark:text-slate-400 mb-8 flex-1">Belirli bir
                                                yükseklikte açılan ve tam ekrana sürüklenebilen standart sayfa yapısı.
                                            </p>
                                            <button @click="$dispatch('open-sheet-1')"
                                                class="w-full py-4 px-6 bg-white dark:bg-white/10 text-slate-900 dark:text-white rounded-xl font-bold shadow-sm hover:shadow-md hover:scale-[1.02] transition-all flex items-center justify-center gap-2 group-hover:bg-primary group-hover:text-white">
                                                Demoyu Aç <span class="material-symbols-outlined">open_in_new</span>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Example 2 -->
                                    <div
                                        class="group bg-white dark:bg-[#1e1a2e] p-1 rounded-3xl border border-slate-200 dark:border-slate-800 hover:border-primary/50 transition-colors">
                                        <div
                                            class="bg-slate-50 dark:bg-[#151022] p-8 rounded-[20px] h-full flex flex-col">
                                            <div class="flex items-center gap-4 mb-6">
                                                <div
                                                    class="w-12 h-12 rounded-xl bg-white dark:bg-white/5 flex items-center justify-center shadow-sm">
                                                    <span
                                                        class="material-symbols-outlined text-primary text-2xl">fullscreen</span>
                                                </div>
                                                <div>
                                                    <h3 class="text-xl font-bold">Tam Ekran</h3>
                                                    <p class="text-sm text-slate-500">Mod: Fullscreen</p>
                                                </div>
                                            </div>
                                            <p class="text-slate-600 dark:text-slate-400 mb-8 flex-1">Geniş içerikler ve
                                                detaylı formlar için ideal olan tam ekran modu.</p>
                                            <button @click="$dispatch('open-sheet-2')"
                                                class="w-full py-4 px-6 bg-white dark:bg-white/10 text-slate-900 dark:text-white rounded-xl font-bold shadow-sm hover:shadow-md hover:scale-[1.02] transition-all flex items-center justify-center gap-2 group-hover:bg-primary group-hover:text-white">
                                                Demoyu Aç <span class="material-symbols-outlined">open_in_new</span>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Example 3 -->
                                    <div
                                        class="group bg-white dark:bg-[#1e1a2e] p-1 rounded-3xl border border-slate-200 dark:border-slate-800 hover:border-primary/50 transition-colors">
                                        <div
                                            class="bg-slate-50 dark:bg-[#151022] p-8 rounded-[20px] h-full flex flex-col">
                                            <div class="flex items-center gap-4 mb-6">
                                                <div
                                                    class="w-12 h-12 rounded-xl bg-white dark:bg-white/5 flex items-center justify-center shadow-sm">
                                                    <span
                                                        class="material-symbols-outlined text-primary text-2xl">swap_vert</span>
                                                </div>
                                                <div>
                                                    <h3 class="text-xl font-bold">Dinamik</h3>
                                                    <p class="text-sm text-slate-500">Başlangıç: %50</p>
                                                </div>
                                            </div>
                                            <p class="text-slate-600 dark:text-slate-400 mb-8 flex-1">Yarım ekranda
                                                başlar, kullanıcı etkileşimi ile tam ekrana genişler.</p>
                                            <button @click="$dispatch('open-sheet-3')"
                                                class="w-full py-4 px-6 bg-white dark:bg-white/10 text-slate-900 dark:text-white rounded-xl font-bold shadow-sm hover:shadow-md hover:scale-[1.02] transition-all flex items-center justify-center gap-2 group-hover:bg-primary group-hover:text-white">
                                                Demoyu Aç <span class="material-symbols-outlined">open_in_new</span>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Example 4 -->
                                    <div
                                        class="group bg-white dark:bg-[#1e1a2e] p-1 rounded-3xl border border-slate-200 dark:border-slate-800 hover:border-primary/50 transition-colors">
                                        <div
                                            class="bg-slate-50 dark:bg-[#151022] p-8 rounded-[20px] h-full flex flex-col">
                                            <div class="flex items-center gap-4 mb-6">
                                                <div
                                                    class="w-12 h-12 rounded-xl bg-white dark:bg-white/5 flex items-center justify-center shadow-sm">
                                                    <span
                                                        class="material-symbols-outlined text-primary text-2xl">lock</span>
                                                </div>
                                                <div>
                                                    <h3 class="text-xl font-bold">Kilitli Mod</h3>
                                                    <p class="text-sm text-slate-500">Özellik: Lockable</p>
                                                </div>
                                            </div>
                                            <p class="text-slate-600 dark:text-slate-400 mb-8 flex-1">Kullanıcıyı bir
                                                işlem yapmaya zorlamak için dışarı tıklamayı engeller.</p>
                                            <button @click="$dispatch('open-sheet-4')"
                                                class="w-full py-4 px-6 bg-white dark:bg-white/10 text-slate-900 dark:text-white rounded-xl font-bold shadow-sm hover:shadow-md hover:scale-[1.02] transition-all flex items-center justify-center gap-2 group-hover:bg-primary group-hover:text-white">
                                                Demoyu Aç <span class="material-symbols-outlined">open_in_new</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </main>

                    <!-- Footer -->
                    <footer
                        class="border-t border-slate-200 dark:border-slate-800 mt-20 bg-white/50 dark:bg-[#151022]/50 backdrop-blur-sm">
                        <div class="max-w-[1200px] mx-auto px-4 py-12">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                                <div class="col-span-1 md:col-span-2">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="size-8 text-primary">
                                            <svg fill="none" viewbox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                                                <path clip-rule="evenodd"
                                                    d="M12.0799 24L4 19.2479L9.95537 8.75216L18.04 13.4961L18.0446 4H29.9554L29.96 13.4961L38.0446 8.75216L44 19.2479L35.92 24L44 28.7521L38.0446 39.2479L29.96 34.5039L29.9554 44H18.0446L18.04 34.5039L9.95537 39.2479L4 28.7521L12.0799 24Z"
                                                    fill="currentColor" fill-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <span class="text-xl font-bold">HowwydSheet</span>
                                    </div>
                                    <p class="text-slate-500 dark:text-slate-400 max-w-sm">
                                        Modern web uygulamaları için geliştirilmiş, hafif ve güçlü alt sayfa
                                        kütüphanesi.
                                    </p>
                                </div>
                                <div>
                                    <h4 class="font-bold mb-4">Kaynaklar</h4>
                                    <ul class="space-y-2 text-slate-500 dark:text-slate-400">
                                        <li><a href="docs.php"
                                                class="hover:text-primary transition-colors">Dokümantasyon</a></li>
                                        <li><a href="#examples"
                                                class="hover:text-primary transition-colors">Örnekler</a></li>
                                        <li><a href="#" class="hover:text-primary transition-colors">Blog</a></li>
                                    </ul>
                                </div>
                                <div>
                                    <h4 class="font-bold mb-4">Topluluk</h4>
                                    <ul class="space-y-2 text-slate-500 dark:text-slate-400">
                                        <li><a href="https://github.com/batuhanatici"
                                                class="hover:text-primary transition-colors">GitHub</a></li>
                                        <li><a href="#" class="hover:text-primary transition-colors">Discord</a></li>
                                        <li><a href="https://x.com/howwydtr"
                                                class="hover:text-primary transition-colors">X</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div
                                class="border-t border-slate-200 dark:border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                                <p class="text-sm text-slate-500">© 2025 HOWWYD. Tüm hakları saklıdır.</p>
                                <div class="flex gap-4">
                                    <a href="/docs" class="text-slate-400 hover:text-primary transition-colors"><span
                                            class="material-symbols-outlined">code</span></a>
                                    <a href="mail:iletisim@howwyd.com"
                                        class="text-slate-400 hover:text-primary transition-colors"><span
                                            class="material-symbols-outlined">alternate_email</span></a>
                                </div>
                            </div>
                        </div>
                    </footer>

                </div>
            </div>
        </div>
    </div>

    <!-- Sheet Demos (AlpineJS) -->

    <!-- Example 1: Custom Size -->
    <div x-data="howwydSheet({ initialSize: '75%' })" @open-sheet-1.window="show()" class="sheet"
        :class="{ 'fullscreen': isFull }" x-show="isVisible" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-full" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-full" x-cloak>

        <div class="overlay" @click="hide()" x-show="isVisible" x-transition.opacity></div>

        <div class="contents bg-white dark:bg-[#1e1a2e] text-slate-900 dark:text-white" :style="sheetStyle">
            <header class="controls border-b border-slate-200 dark:border-slate-700" @mousedown="startDrag"
                @touchstart="startDrag" @mousemove.window="onDrag" @touchmove.window="onDrag" @mouseup.window="endDrag"
                @touchend.window="endDrag">
                <div class="draggable-area">
                    <div class="draggable-thumb bg-slate-300 dark:bg-slate-600"></div>
                </div>
            </header>
            <main class="body p-6">
                <h2 class="text-2xl font-bold mb-4">Özel Boyut Örneği</h2>
                <p class="mb-4 text-slate-600 dark:text-slate-300">Bu sayfa %75 yükseklikte açılır. Yukarı sürükleyerek
                    tam ekran yapabilir veya aşağı sürükleyerek kapatabilirsiniz.</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div class="p-4 rounded-xl bg-slate-100 dark:bg-[#2c2839]">
                        <h3 class="text-lg font-semibold mb-2">Duyarlı</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Tüm cihazlarda kusursuz çalışır.</p>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-100 dark:bg-[#2c2839]">
                        <h3 class="text-lg font-semibold mb-2">Otomatik Yükseklik</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400">İçerik yüksekliği otomatik ayarlanır.</p>
                    </div>
                </div>
                <button @click="hide()"
                    class="w-full px-4 py-3 rounded-lg bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-bold hover:opacity-90 transition-opacity">
                    Kapat
                </button>
            </main>
        </div>
    </div>

    <!-- Example 2: Full Screen -->
    <div x-data="howwydSheet({ fullscreenOnInit: true })" @open-sheet-2.window="show()" class="sheet fullscreen"
        x-show="isVisible" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-full" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-full" x-cloak>

        <div class="overlay" @click="hide()" x-show="isVisible" x-transition.opacity></div>

        <div class="contents bg-white dark:bg-[#1e1a2e] text-slate-900 dark:text-white" :style="sheetStyle">
            <header class="controls border-b border-slate-200 dark:border-slate-700" @mousedown="startDrag"
                @touchstart="startDrag" @mousemove.window="onDrag" @touchmove.window="onDrag" @mouseup.window="endDrag"
                @touchend.window="endDrag">
                <div class="draggable-area">
                    <div class="draggable-thumb bg-slate-300 dark:bg-slate-600"></div>
                </div>
            </header>
            <main class="body p-6">
                <h2 class="text-2xl font-bold mb-4">Tam Ekran Modu</h2>
                <p class="mb-4 text-slate-600 dark:text-slate-300">Bu sayfa tam ekran modunda açılır. Geniş içerikler
                    veya detaylı görünümler için idealdir.</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="p-4 rounded-xl bg-slate-100 dark:bg-[#2c2839]">
                        <h3 class="text-lg font-semibold mb-2">Sürükleyici</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Tam ekran deneyimi.</p>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-100 dark:bg-[#2c2839]">
                        <h3 class="text-lg font-semibold mb-2">Geniş</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Formlar ve listeler için harika.</p>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-100 dark:bg-[#2c2839]">
                        <h3 class="text-lg font-semibold mb-2">Detaylı</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Daha fazla bilgi gösterin.</p>
                    </div>
                </div>
                <button @click="hide()"
                    class="w-full px-4 py-3 rounded-lg bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-bold hover:opacity-90 transition-opacity">
                    Kapat
                </button>
            </main>
        </div>
    </div>

    <!-- Example 3: Dynamic -->
    <div x-data="howwydSheet({ initialSize: '50%' })" @open-sheet-3.window="show()" class="sheet"
        :class="{ 'fullscreen': isFull }" x-show="isVisible" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-full" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-full" x-cloak>

        <div class="overlay" @click="hide()" x-show="isVisible" x-transition.opacity></div>

        <div class="contents bg-white dark:bg-[#1e1a2e] text-slate-900 dark:text-white" :style="sheetStyle">
            <header class="controls border-b border-slate-200 dark:border-slate-700" @mousedown="startDrag"
                @touchstart="startDrag" @mousemove.window="onDrag" @touchmove.window="onDrag" @mouseup.window="endDrag"
                @touchend.window="endDrag">
                <div class="draggable-area">
                    <div class="draggable-thumb bg-slate-300 dark:bg-slate-600"></div>
                </div>
            </header>
            <main class="body p-6">
                <h2 class="text-2xl font-bold mb-4">Dinamik Mod</h2>
                <p class="mb-4 text-slate-600 dark:text-slate-300">%50 yükseklikte açılır. Tam ekran yapmak için yukarı
                    sürükleyin!</p>
                <div class="space-y-4 mb-6">
                    <div class="p-4 rounded-xl bg-slate-100 dark:bg-[#2c2839]">
                        <h3 class="text-lg font-semibold mb-2">Esnek</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Kullanıcı etkileşimine uyum sağlar.</p>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-100 dark:bg-[#2c2839]">
                        <h3 class="text-lg font-semibold mb-2">Kontrol</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Boyuta kullanıcı karar verir.</p>
                    </div>
                </div>
                <button @click="hide()"
                    class="w-full px-4 py-3 rounded-lg bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-bold hover:opacity-90 transition-opacity">
                    Kapat
                </button>
            </main>
        </div>
    </div>

    <!-- Example 4: Locked -->
    <div x-data="howwydSheet({ lockable: true })" @open-sheet-4.window="show()" class="sheet"
        :class="{ 'fullscreen': isFull }" x-show="isVisible" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-full" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-full" x-cloak>

        <div class="overlay" @click="hide()" x-show="isVisible" x-transition.opacity></div>

        <div class="contents bg-white dark:bg-[#1e1a2e] text-slate-900 dark:text-white" :style="sheetStyle">
            <header class="controls border-b border-slate-200 dark:border-slate-700" @mousedown="startDrag"
                @touchstart="startDrag" @mousemove.window="onDrag" @touchmove.window="onDrag" @mouseup.window="endDrag"
                @touchend.window="endDrag">
                <div class="draggable-area">
                    <div class="draggable-thumb bg-slate-300 dark:bg-slate-600"></div>
                </div>
            </header>
            <main class="body p-6">
                <h2 class="text-2xl font-bold mb-4">Kilitli Mod</h2>
                <p class="mb-4 text-slate-600 dark:text-slate-300">Bu sayfa dışarı tıklanarak kapatılamaz. Kritik
                    işlemler için uygundur.</p>
                <div class="mb-6 p-4 rounded-lg bg-pink-500/10 border border-pink-500/30">
                    <p class="text-pink-600 dark:text-pink-400 font-medium">Arka plana tıklamayı deneyin - kapanmayacak!
                    </p>
                </div>
                <button @click="hide(true)"
                    class="w-full px-4 py-3 rounded-lg bg-primary text-white font-bold hover:opacity-90 transition-opacity">
                    Kapat
                </button>
            </main>
        </div>
    </div>
</body>

</html>