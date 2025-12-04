<!DOCTYPE html>
<html class="dark" lang="tr">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>HowwydSheet Dokümantasyon</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />

    <!-- Styles -->
    <link rel="stylesheet" href="/src/output.css">
    <link rel="stylesheet" href="howwydsheet.css">
    <link rel="stylesheet" href="prism.css">

    <!-- Scripts -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="howwydsheet.js"></script>
    <script src="prism.js"></script>

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

            // Documentation Logic
            Alpine.data('docs', () => ({
                searchOpen: false,
                searchQuery: '',
                activeSection: '',
                toastMessage: '',
                showToast: false,
                items: [],
                filteredItems: [],
                selectedIndex: -1,

                init() {
                    // Build Search Index Dynamically
                    this.$nextTick(() => {
                        this.buildSearchIndex();
                    });

                    // Scroll Spy
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                this.activeSection = entry.target.id;
                            }
                        });
                    }, { rootMargin: '-20% 0px -60% 0px' }); // Adjust margin to trigger earlier

                    document.querySelectorAll('section[id]').forEach(section => {
                        observer.observe(section);
                    });

                    // Ctrl+K Shortcut
                    document.addEventListener('keydown', (e) => {
                        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                            e.preventDefault();
                            this.searchOpen = true;
                        }
                        if (e.key === 'Escape') {
                            this.searchOpen = false;
                        }
                    });

                    // Lock Body Scroll
                    this.$watch('searchOpen', (value) => {
                        if (value) {
                            // Ensure items are built
                            if (this.items.length === 0) {
                                this.buildSearchIndex();
                            }

                            document.body.style.overflow = 'hidden';
                            this.$nextTick(() => this.$refs.searchInput.focus());
                            this.selectedIndex = -1;
                        } else {
                            document.body.style.overflow = '';
                            this.searchQuery = '';
                        }
                    });

                    // Watch search query
                    this.$watch('searchQuery', () => {
                        this.filterItems();
                    });
                },

                buildSearchIndex() {
                    // Target the main sidebar by ID to be precise
                    const sidebar = document.getElementById('docs-sidebar');
                    if (!sidebar) {
                        return;
                    }

                    const sidebarLinks = sidebar.querySelectorAll('a[href^="#"]');
                    this.items = Array.from(sidebarLinks).map(link => {
                        const id = link.getAttribute('href').substring(1);

                        // Clone to remove icons from text
                        const clone = link.cloneNode(true);
                        clone.querySelectorAll('.material-symbols-outlined').forEach(el => el.remove());
                        const title = clone.innerText.trim();

                        // Find category: traverse up to container, then prev sibling h3
                        const container = link.closest('.flex-col');
                        const categoryTitle = container ? container.querySelector('h3') : null;
                        const type = categoryTitle ? categoryTitle.innerText.trim() : 'Genel';

                        return { id, title, type };
                    });

                    this.filterItems();
                },

                filterItems() {
                    if (!this.searchQuery) {
                        this.filteredItems = this.items;
                        return;
                    }

                    const query = this.searchQuery.toLowerCase();
                    this.filteredItems = this.items.filter(item =>
                        item.title.toLowerCase().includes(query) ||
                        item.type.toLowerCase().includes(query)
                    );
                },

                nextResult() {
                    if (this.filteredItems.length === 0) return;
                    this.selectedIndex = (this.selectedIndex + 1) % this.filteredItems.length;
                    this.scrollToSelected();
                },

                prevResult() {
                    if (this.filteredItems.length === 0) return;
                    this.selectedIndex = (this.selectedIndex - 1 + this.filteredItems.length) % this.filteredItems.length;
                    this.scrollToSelected();
                },

                selectResult() {
                    if (this.selectedIndex >= 0 && this.filteredItems[this.selectedIndex]) {
                        this.scrollTo(this.filteredItems[this.selectedIndex].id);
                    }
                },

                scrollToSelected() {
                    this.$nextTick(() => {
                        const selectedEl = this.$refs.results.children[this.selectedIndex];
                        if (selectedEl) {
                            selectedEl.scrollIntoView({ block: 'nearest' });
                        }
                    });
                },

                copyToClipboard(text) {
                    navigator.clipboard.writeText(text).then(() => {
                        this.toastMessage = 'Kopyalandı!';
                        this.showToast = true;
                        setTimeout(() => this.showToast = false, 2000);
                    });
                },

                scrollTo(id) {
                    const el = document.getElementById(id);
                    if (el) {
                        el.scrollIntoView({ behavior: 'smooth' });
                        this.searchOpen = false;
                        this.activeSection = id;
                    }
                }
            }));
        });
    </script>

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        /* Custom scrollbar for sidebar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: rgba(156, 163, 175, 0.5);
            border-radius: 20px;
        }

        .sidebar-link.active {
            @apply text-primary bg-primary/10 border-r-2 border-primary;
        }

        /* Light mode fixes */
        html:not(.dark) body {
            @apply bg-slate-50 text-slate-900;
        }

        html:not(.dark) .sidebar-link:hover {
            @apply bg-slate-200;
        }
    </style>
</head>

<body class="font-display bg-background-light dark:bg-background-dark text-slate-900 dark:text-white overflow-x-hidden"
    x-data="{ mobileMenuOpen: false, ...docs() }">

    <!-- Toast Notification -->
    <div x-show="showToast" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
        class="fixed bottom-6 right-6 z-50 px-4 py-2 bg-slate-900 text-white rounded-lg shadow-lg flex items-center gap-2"
        x-cloak>
        <span class="material-symbols-outlined text-green-400">check_circle</span>
        <span x-text="toastMessage"></span>
    </div>

    <!-- Search Modal -->
    <div x-show="searchOpen" class="fixed inset-0 z-[60] overflow-y-auto" role="dialog" aria-modal="true" x-cloak>
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="searchOpen = false" x-transition.opacity></div>

        <div class="flex min-h-full items-start justify-center p-4 sm:p-6 mt-10">
            <div class="relative w-full max-w-2xl transform overflow-hidden rounded-2xl bg-white dark:bg-[#1e1a2e] shadow-2xl transition-all border border-slate-200 dark:border-slate-700"
                x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">

                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                        <span class="material-symbols-outlined text-slate-400">search</span>
                    </div>
                    <input x-ref="searchInput" x-model="searchQuery"
                        class="h-14 w-full border-0 bg-transparent pl-12 pr-4 text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-0 sm:text-sm"
                        placeholder="Dökümantasyonda ara..." @keydown.down.prevent="nextResult()"
                        @keydown.up.prevent="prevResult()" @keydown.enter.prevent="selectResult()" type="text">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                        <kbd
                            class="inline-flex items-center rounded border border-slate-200 dark:border-slate-700 px-2 font-sans text-xs font-medium text-slate-400">ESC</kbd>
                    </div>
                </div>

                <ul x-ref="results"
                    class="max-h-96 scroll-py-3 overflow-y-auto p-3 border-t border-slate-200 dark:border-slate-700"
                    id="options" role="listbox">
                    <template x-for="(section, index) in filteredItems" :key="section.id">
                        <li class="group flex cursor-pointer items-center select-none rounded-xl p-3 hover:bg-slate-100 dark:hover:bg-white/5"
                            :class="{'bg-slate-100 dark:bg-white/5': index === selectedIndex}"
                            @click="scrollTo(section.id)">
                            <div
                                class="flex h-10 w-10 flex-none items-center justify-center rounded-lg bg-slate-100 dark:bg-white/5 ring-1 ring-slate-200 dark:ring-white/10">
                                <span class="material-symbols-outlined text-slate-500"
                                    x-text="section.id === 'faq' ? 'help' : 'article'"></span>
                            </div>
                            <div class="ml-4 flex-auto">
                                <p class="text-sm font-medium text-slate-700 dark:text-slate-200"
                                    x-text="section.title"></p>
                                <p class="text-xs text-slate-500" x-text="section.type"></p>
                            </div>
                            <span class="material-symbols-outlined text-slate-400 opacity-0 group-hover:opacity-100"
                                :class="{'opacity-100': index === selectedIndex}">arrow_forward</span>
                        </li>
                    </template>
                    <li x-show="filteredItems.length === 0" class="p-4 text-center text-sm text-slate-500">
                        Sonuç bulunamadı.
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="relative flex h-auto min-h-screen w-full flex-col">
        <!-- Top Nav Bar -->
        <header
            class="sticky top-0 z-40 flex h-16 items-center justify-between whitespace-nowrap border-b border-solid border-slate-200 dark:border-slate-800 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-sm px-4 md:px-8">
            <div class="flex items-center gap-6">
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="lg:hidden p-2 text-slate-500 hover:bg-slate-200 dark:hover:bg-white/10 rounded-lg">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <div class="flex items-center gap-3 text-slate-900 dark:text-white">
                    <div class="size-6 text-primary">
                        <svg fill="none" viewbox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd"
                                d="M12.0799 24L4 19.2479L9.95537 8.75216L18.04 13.4961L18.0446 4H29.9554L29.96 13.4961L38.0446 8.75216L44 19.2479L35.92 24L44 28.7521L38.0446 39.2479L29.96 34.5039L29.9554 44H18.0446L18.04 34.5039L9.95537 39.2479L4 28.7521L12.0799 24Z"
                                fill="currentColor" fill-rule="evenodd"></path>
                        </svg>
                    </div>
                    <a href="/" class="text-lg font-bold leading-tight tracking-[-0.015em]">HowwydSheet</a>
                </div>
            </div>
            <div class="flex-1 max-w-lg px-4 hidden md:flex">
                <label class="flex w-full min-w-40 !h-10 cursor-pointer" @click="searchOpen = true">
                    <div
                        class="flex w-full flex-1 items-stretch rounded-lg h-full border border-slate-300 dark:border-slate-700 bg-white dark:bg-black/20 hover:border-primary transition-colors">
                        <div class="text-slate-400 dark:text-slate-500 flex items-center justify-center pl-3">
                            <span class="material-symbols-outlined text-base">search</span>
                        </div>
                        <input readonly
                            class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden text-slate-900 dark:text-white focus:outline-0 focus:ring-0 border-none bg-transparent h-full placeholder:text-slate-400 dark:placeholder:text-slate-500 px-2 text-sm font-normal leading-normal cursor-pointer"
                            placeholder="Dökümantasyonda ara..." />
                        <div class="text-slate-400 dark:text-slate-500 flex items-center pr-3">
                            <kbd
                                class="font-sans text-xs font-semibold p-1 border border-slate-300 dark:border-slate-700 rounded-md">Ctrl+K</kbd>
                        </div>
                    </div>
                </label>
            </div>
            <div class="flex items-center gap-2">
                <a href="https://github.com" target="_blank"
                    class="flex h-10 w-10 cursor-pointer items-center justify-center overflow-hidden rounded-lg bg-transparent text-slate-500 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-white/10">
                    <span class="material-symbols-outlined !text-2xl"
                        style="font-variation-settings: 'wght' 300;">code</span>
                </a>
                <button @click="$store.darkMode.toggle()"
                    class="flex h-10 w-10 cursor-pointer items-center justify-center overflow-hidden rounded-lg bg-transparent text-slate-500 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-white/10">
                    <span class="material-symbols-outlined !text-2xl" style="font-variation-settings: 'wght' 300;"
                        x-text="$store.darkMode.on ? 'light_mode' : 'dark_mode'">dark_mode</span>
                </button>
            </div>
        </header>

        <div class="flex flex-1 relative">
            <!-- Mobile Sidebar Overlay -->
            <div x-show="mobileMenuOpen" @click="mobileMenuOpen = false"
                class="fixed inset-0 bg-black/50 z-40 lg:hidden" x-transition.opacity></div>

            <!-- Side Nav Bar -->
            <aside id="docs-sidebar" :class="mobileMenuOpen ? 'translate-x-0' : '-translate-x-full'"
                class="fixed lg:sticky top-0 lg:top-16 h-screen lg:h-[calc(100vh-4rem)] w-64 flex-shrink-0 border-r border-slate-200 dark:border-slate-800 bg-background-light dark:bg-background-dark z-50 lg:z-0 transition-transform duration-300 lg:translate-x-0 custom-scrollbar overflow-y-auto p-6">
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col gap-1">
                        <h3 class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Başlangıç
                        </h3>
                        <a href="#installation"
                            :class="activeSection === 'installation' ? 'text-primary bg-primary/10' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-200/50 dark:hover:bg-white/5'"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors">
                            <span class="material-symbols-outlined !text-xl">download</span>
                            Kurulum
                        </a>
                        <a href="#usage"
                            :class="activeSection === 'usage' ? 'text-primary bg-primary/10' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-200/50 dark:hover:bg-white/5'"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors">
                            <span class="material-symbols-outlined !text-xl">play_circle</span>
                            Kullanım
                        </a>
                    </div>

                    <div class="flex flex-col gap-1 mt-4">
                        <h3 class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Temel
                            Kavramlar</h3>
                        <a href="#sizing"
                            :class="activeSection === 'sizing' ? 'text-primary bg-primary/10' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-200/50 dark:hover:bg-white/5'"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors">
                            <span class="material-symbols-outlined !text-xl">aspect_ratio</span>
                            Boyutlandırma
                        </a>
                        <a href="#locking"
                            :class="activeSection === 'locking' ? 'text-primary bg-primary/10' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-200/50 dark:hover:bg-white/5'"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors">
                            <span class="material-symbols-outlined !text-xl">lock</span>
                            Kilitleme
                        </a>
                    </div>

                    <div class="flex flex-col gap-1 mt-4">
                        <h3 class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">API
                            Referansı</h3>
                        <a href="#configuration"
                            :class="activeSection === 'configuration' ? 'text-primary bg-primary/10' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-200/50 dark:hover:bg-white/5'"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors">
                            <span class="material-symbols-outlined !text-xl">settings</span>
                            Yapılandırma
                        </a>
                        <a href="#methods"
                            :class="activeSection === 'methods' ? 'text-primary bg-primary/10' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-200/50 dark:hover:bg-white/5'"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors">
                            <span class="material-symbols-outlined !text-xl">function</span>
                            Metotlar
                        </a>
                    </div>

                    <div class="flex flex-col gap-1 mt-4">
                        <h3 class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Destek</h3>
                        <a href="#faq"
                            :class="activeSection === 'faq' ? 'text-primary bg-primary/10' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-200/50 dark:hover:bg-white/5'"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors">
                            <span class="material-symbols-outlined !text-xl">help</span>
                            SSS
                        </a>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 w-full p-6 md:p-12 min-w-0">
                <div class="max-w-4xl mx-auto">
                    <!-- Breadcrumbs -->
                    <div class="flex flex-wrap gap-2 mb-6">
                        <a class="text-slate-500 dark:text-slate-400 text-sm font-medium hover:text-primary"
                            href="#">Dökümanlar</a>
                        <span class="text-slate-400 dark:text-slate-500 text-sm font-medium">/</span>
                        <span class="text-slate-900 dark:text-slate-100 text-sm font-medium">Başlangıç</span>
                    </div>

                    <!-- Installation -->
                    <section id="installation" class="mb-16 scroll-mt-24">
                        <h1
                            class="text-4xl md:text-5xl font-black leading-tight tracking-[-0.033em] mb-4 text-slate-900 dark:text-white">
                            Kurulum</h1>
                        <p class="text-slate-600 dark:text-slate-300 text-lg leading-relaxed mb-8">
                            HowwydSheet'i projenize dahil ederek hemen kullanmaya başlayın. Modern ve reaktif bir
                            deneyim için AlpineJS ile güçlendirilmiştir.
                        </p>

                        <div class="bg-slate-900 rounded-xl overflow-hidden mb-8 border border-slate-800">
                            <div
                                class="flex justify-between items-center px-4 py-2 bg-slate-800/50 border-b border-slate-700">
                                <span class="text-slate-400 text-xs font-semibold uppercase">HTML</span>
                                <button
                                    @click="copyToClipboard('<link rel=\'stylesheet\' href=\'https://cdn.howwyd.com/sheet/v2/index.css\'>\n<script defer src=\'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js\'></script>\n<script src=\'https://cdn.howwyd.com/sheet/v2/index.js\'></script>')"
                                    class="text-slate-400 hover:text-white text-xs font-medium flex items-center gap-1">
                                    <span class="material-symbols-outlined !text-sm">content_copy</span> Kopyala
                                </button>
                            </div>
                            <pre class="p-4 overflow-x-auto"><code class="language-html">&lt;!-- Stiller --&gt;
&lt;link rel="stylesheet" href="https://cdn.howwyd.com/sheet/v2/index.css"&gt;

&lt;!-- Scriptler --&gt;
&lt;script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"&gt;&lt;/script&gt;
&lt;script src="https://cdn.howwyd.com/sheet/v2/index.js"&gt;&lt;/script&gt;</code></pre>
                        </div>
                    </section>

                    <!-- Usage -->
                    <section id="usage" class="mb-16 scroll-mt-24">
                        <h2
                            class="text-2xl font-bold mb-4 text-slate-900 dark:text-white border-b border-slate-200 dark:border-slate-800 pb-2">
                            Kullanım</h2>
                        <p class="text-slate-600 dark:text-slate-300 mb-6">
                            Bir sayfayı başlatmak için <code>x-data="howwydSheet()"</code> direktifini kullanın.
                            Görünürlüğü kontrol etmek için standart AlpineJS direktiflerini kullanabilirsiniz.
                        </p>

                        <div class="bg-slate-900 rounded-xl overflow-hidden mb-8 border border-slate-800">
                            <div
                                class="flex justify-between items-center px-4 py-2 bg-slate-800/50 border-b border-slate-700">
                                <span class="text-slate-400 text-xs font-semibold uppercase">HTML</span>
                                <button @click="copyToClipboard($el.parentElement.nextElementSibling.innerText)"
                                    class="text-slate-400 hover:text-white text-xs font-medium flex items-center gap-1">
                                    <span class="material-symbols-outlined !text-sm">content_copy</span> Kopyala
                                </button>
                            </div>
                            <pre class="p-4 overflow-x-auto"><code class="language-html">&lt;!-- Tetikleyici Buton --&gt;
&lt;button @click="$dispatch('open-sheet')"&gt;Sayfayı Aç&lt;/button&gt;

&lt;!-- Sayfa Bileşeni --&gt;
&lt;div x-data="howwydSheet({ initialSize: '50%' })" 
     @open-sheet.window="show()" 
     class="sheet" 
     x-show="isVisible" 
     x-cloak&gt;
    
    &lt;!-- Arka Plan Örtüsü --&gt;
    &lt;div class="overlay" @click="hide()"&gt;&lt;/div&gt;
    
    &lt;!-- İçerik Alanı --&gt;
    &lt;div class="contents" :style="sheetStyle"&gt;
        &lt;header class="controls" 
                @mousedown="startDrag" @touchstart="startDrag"
                @mousemove.window="onDrag" @touchmove.window="onDrag"
                @mouseup.window="endDrag" @touchend.window="endDrag"&gt;
            &lt;div class="draggable-area"&gt;
                &lt;div class="draggable-thumb"&gt;&lt;/div&gt;
            &lt;/div&gt;
        &lt;/header&gt;
        &lt;main class="body"&gt;
            &lt;h2&gt;Merhaba Dünya&lt;/h2&gt;
        &lt;/main&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                        </div>
                    </section>

                    <!-- Sizing -->
                    <section id="sizing" class="mb-16 scroll-mt-24">
                        <h2
                            class="text-2xl font-bold mb-4 text-slate-900 dark:text-white border-b border-slate-200 dark:border-slate-800 pb-2">
                            Boyutlandırma</h2>
                        <p class="text-slate-600 dark:text-slate-300 mb-6">
                            Sayfanın başlangıç yüksekliğini <code>initialSize</code> parametresi ile ayarlayabilirsiniz.
                            Yüzde (%) veya piksel (px) değerleri kabul edilir.
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="p-4 border border-slate-200 dark:border-slate-800 rounded-lg">
                                <code class="text-primary font-bold">initialSize: '50%'</code>
                                <p class="text-sm text-slate-500 mt-2">Ekranın yarısı kadar açılır.</p>
                            </div>
                            <div class="p-4 border border-slate-200 dark:border-slate-800 rounded-lg">
                                <code class="text-primary font-bold">initialSize: '300px'</code>
                                <p class="text-sm text-slate-500 mt-2">300 piksel yükseklikte açılır.</p>
                            </div>
                        </div>
                    </section>

                    <!-- Locking -->
                    <section id="locking" class="mb-16 scroll-mt-24">
                        <h2
                            class="text-2xl font-bold mb-4 text-slate-900 dark:text-white border-b border-slate-200 dark:border-slate-800 pb-2">
                            Kilitleme (Locking)</h2>
                        <p class="text-slate-600 dark:text-slate-300 mb-6">
                            Kullanıcının sayfayı yanlışlıkla kapatmasını önlemek için <code>lockable: true</code>
                            özelliğini kullanın. Bu modda arka plan örtüsüne tıklamak sayfayı kapatmaz.
                        </p>
                        <div
                            class="bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-lg border border-yellow-200 dark:border-yellow-900/50 mb-4">
                            <p class="text-yellow-800 dark:text-yellow-200 text-sm">
                                <span class="font-bold">İpucu:</span> Kilitli modda sayfayı kapatmak için
                                <code>hide(true)</code> metodunu çağıran bir buton eklemeyi unutmayın.
                            </p>
                        </div>
                    </section>

                    <!-- Configuration -->
                    <section id="configuration" class="mb-16 scroll-mt-24">
                        <h2
                            class="text-2xl font-bold mb-4 text-slate-900 dark:text-white border-b border-slate-200 dark:border-slate-800 pb-2">
                            Yapılandırma</h2>
                        <p class="text-slate-600 dark:text-slate-300 mb-6">
                            <code>howwydSheet()</code> fonksiyonuna bir yapılandırma nesnesi geçirerek davranışı
                            özelleştirin.
                        </p>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-slate-200 dark:border-slate-700">
                                        <th class="py-3 px-4 font-semibold text-slate-900 dark:text-white">Seçenek</th>
                                        <th class="py-3 px-4 font-semibold text-slate-900 dark:text-white">Tip</th>
                                        <th class="py-3 px-4 font-semibold text-slate-900 dark:text-white">Varsayılan
                                        </th>
                                        <th class="py-3 px-4 font-semibold text-slate-900 dark:text-white">Açıklama</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm">
                                    <tr class="border-b border-slate-200 dark:border-slate-800">
                                        <td class="py-3 px-4 font-mono text-primary">initialSize</td>
                                        <td class="py-3 px-4 text-slate-600 dark:text-slate-400">string</td>
                                        <td class="py-3 px-4 text-slate-600 dark:text-slate-400">'50%'</td>
                                        <td class="py-3 px-4 text-slate-600 dark:text-slate-400">Sayfanın başlangıç
                                            yüksekliği.</td>
                                    </tr>
                                    <tr class="border-b border-slate-200 dark:border-slate-800">
                                        <td class="py-3 px-4 font-mono text-primary">lockable</td>
                                        <td class="py-3 px-4 text-slate-600 dark:text-slate-400">boolean</td>
                                        <td class="py-3 px-4 text-slate-600 dark:text-slate-400">false</td>
                                        <td class="py-3 px-4 text-slate-600 dark:text-slate-400">True ise, dışarı
                                            tıklamak kapatmaz.</td>
                                    </tr>
                                    <tr class="border-b border-slate-200 dark:border-slate-800">
                                        <td class="py-3 px-4 font-mono text-primary">fullscreenOnInit</td>
                                        <td class="py-3 px-4 text-slate-600 dark:text-slate-400">boolean</td>
                                        <td class="py-3 px-4 text-slate-600 dark:text-slate-400">false</td>
                                        <td class="py-3 px-4 text-slate-600 dark:text-slate-400">Başlangıçta tam ekran
                                            açılır.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <!-- Methods -->
                    <section id="methods" class="mb-16 scroll-mt-24">
                        <h2
                            class="text-2xl font-bold mb-4 text-slate-900 dark:text-white border-b border-slate-200 dark:border-slate-800 pb-2">
                            Metotlar</h2>
                        <p class="text-slate-600 dark:text-slate-300 mb-6">
                            Bileşen içinde kullanabileceğiniz metotlar.
                        </p>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-slate-200 dark:border-slate-700">
                                        <th class="py-3 px-4 font-semibold text-slate-900 dark:text-white">Metot</th>
                                        <th class="py-3 px-4 font-semibold text-slate-900 dark:text-white">Parametreler
                                        </th>
                                        <th class="py-3 px-4 font-semibold text-slate-900 dark:text-white">Açıklama</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm">
                                    <tr class="border-b border-slate-200 dark:border-slate-800">
                                        <td class="py-3 px-4 font-mono text-primary">show()</td>
                                        <td class="py-3 px-4 text-slate-600 dark:text-slate-400">-</td>
                                        <td class="py-3 px-4 text-slate-600 dark:text-slate-400">Sayfayı açar.</td>
                                    </tr>
                                    <tr class="border-b border-slate-200 dark:border-slate-800">
                                        <td class="py-3 px-4 font-mono text-primary">hide(force)</td>
                                        <td class="py-3 px-4 text-slate-600 dark:text-slate-400">force: boolean</td>
                                        <td class="py-3 px-4 text-slate-600 dark:text-slate-400">Sayfayı kapatır.
                                            <code>force=true</code> ise kilitli olsa bile kapatır.
                                        </td>
                                    </tr>
                                    <tr class="border-b border-slate-200 dark:border-slate-800">
                                        <td class="py-3 px-4 font-mono text-primary">toggle()</td>
                                        <td class="py-3 px-4 text-slate-600 dark:text-slate-400">-</td>
                                        <td class="py-3 px-4 text-slate-600 dark:text-slate-400">Görünürlük durumunu
                                            değiştirir.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <!-- FAQ -->
                    <section id="faq" class="mb-16 scroll-mt-24">
                        <h2
                            class="text-2xl font-bold mb-4 text-slate-900 dark:text-white border-b border-slate-200 dark:border-slate-800 pb-2">
                            Sıkça Sorulan Sorular</h2>
                        <div class="space-y-4">
                            <div
                                class="p-4 rounded-xl bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-slate-800">
                                <h3 class="font-bold text-lg mb-2">React veya Vue ile çalışır mı?</h3>
                                <p class="text-slate-600 dark:text-slate-400">Evet, HowwydSheet framework bağımsızdır
                                    ancak AlpineJS üzerine kuruludur. React veya Vue bileşenleriniz içinde rahatlıkla
                                    kullanabilirsiniz.</p>
                            </div>
                            <div
                                class="p-4 rounded-xl bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-slate-800">
                                <h3 class="font-bold text-lg mb-2">Mobil cihazlarda performans nasıl?</h3>
                                <p class="text-slate-600 dark:text-slate-400">Son derece yüksek. CSS transform ve
                                    requestAnimationFrame kullanarak 60fps akıcılık hedeflenmiştir.</p>
                            </div>
                            <div
                                class="p-4 rounded-xl bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-slate-800">
                                <h3 class="font-bold text-lg mb-2">Ücretli mi?</h3>
                                <p class="text-slate-600 dark:text-slate-400">Hayır, HowwydSheet tamamen açık kaynaklı
                                    ve ücretsizdir.</p>
                            </div>
                        </div>
                    </section>

                </div>
            </main>

            <!-- Right Sidebar -->
            <aside
                class="hidden xl:block sticky top-16 h-[calc(100vh-4rem)] w-64 flex-shrink-0 border-l border-slate-200 dark:border-slate-800 p-6">
                <h3 class="text-slate-900 dark:text-white text-sm font-semibold mb-4">Bu Sayfada</h3>
                <ul class="space-y-2 border-l-2 border-slate-200 dark:border-slate-700">
                    <li><a href="#installation"
                            :class="activeSection === 'installation' ? 'text-primary border-primary' : 'text-slate-500 dark:text-slate-400 hover:text-primary hover:border-primary'"
                            class="block pl-4 text-sm font-medium border-l-2 border-transparent -ml-px transition-colors">Kurulum</a>
                    </li>
                    <li><a href="#usage"
                            :class="activeSection === 'usage' ? 'text-primary border-primary' : 'text-slate-500 dark:text-slate-400 hover:text-primary hover:border-primary'"
                            class="block pl-4 text-sm font-medium border-l-2 border-transparent -ml-px transition-colors">Kullanım</a>
                    </li>
                    <li><a href="#sizing"
                            :class="activeSection === 'sizing' ? 'text-primary border-primary' : 'text-slate-500 dark:text-slate-400 hover:text-primary hover:border-primary'"
                            class="block pl-4 text-sm font-medium border-l-2 border-transparent -ml-px transition-colors">Boyutlandırma</a>
                    </li>
                    <li><a href="#locking"
                            :class="activeSection === 'locking' ? 'text-primary border-primary' : 'text-slate-500 dark:text-slate-400 hover:text-primary hover:border-primary'"
                            class="block pl-4 text-sm font-medium border-l-2 border-transparent -ml-px transition-colors">Kilitleme</a>
                    </li>
                    <li><a href="#configuration"
                            :class="activeSection === 'configuration' ? 'text-primary border-primary' : 'text-slate-500 dark:text-slate-400 hover:text-primary hover:border-primary'"
                            class="block pl-4 text-sm font-medium border-l-2 border-transparent -ml-px transition-colors">Yapılandırma</a>
                    </li>
                    <li><a href="#methods"
                            :class="activeSection === 'methods' ? 'text-primary border-primary' : 'text-slate-500 dark:text-slate-400 hover:text-primary hover:border-primary'"
                            class="block pl-4 text-sm font-medium border-l-2 border-transparent -ml-px transition-colors">Metotlar</a>
                    </li>
                    <li><a href="#faq"
                            :class="activeSection === 'faq' ? 'text-primary border-primary' : 'text-slate-500 dark:text-slate-400 hover:text-primary hover:border-primary'"
                            class="block pl-4 text-sm font-medium border-l-2 border-transparent -ml-px transition-colors">SSS</a>
                    </li>
                </ul>
            </aside>
        </div>
    </div>
</body>

</html>