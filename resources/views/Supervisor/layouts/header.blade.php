<header class="topbar">
    <button @click="sidebarOpen = true" class="topbar-menu lg:hidden" aria-label="Menu">
        <svg class="h-6 w-6" viewBox="0 0 24 24"><path fill="currentColor" d="M4 6h16v2H4zm0 5h16v2H4zm0 5h10v2H4z"/></svg>
    </button>
    <div>
        <p class="text-xs font-black uppercase tracking-[0.24em] text-violet-700">VisiLog</p>
        <h2 class="text-lg font-semibold text-slate-900">Espace supervision</h2>
    </div>
    <div class="ml-auto flex items-center gap-3">
        <div class="hidden items-center gap-2 rounded-full border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-600 shadow-sm sm:flex">
            Lecture globale
        </div>
        <div x-data="{ dropdownOpen: false }" class="relative">
            <button @click="dropdownOpen = ! dropdownOpen" class="flex h-10 w-10 items-center justify-center rounded-full border border-violet-100 bg-violet-50 text-sm font-bold text-violet-700 shadow-sm">
                {{ strtoupper(substr(Auth::guard('web')->user()->lastname ?? 'U', 0, 1)) }}
            </button>
            <div x-cloak x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 z-10"></div>
            <div x-cloak x-show="dropdownOpen" class="absolute right-0 z-20 mt-3 w-56 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-xl">
                <div class="border-b border-slate-100 px-4 py-3">
                    <p class="text-sm font-semibold text-slate-900">{{ Auth::guard('web')->user()->name }}</p>
                    <p class="text-xs text-slate-500">{{ Auth::guard('web')->user()->email }}</p>
                </div>
                <form action="{{ route('p_logout') }}" method="post">
                    @csrf
                    <button class="block w-full px-4 py-3 text-left text-sm font-medium text-rose-600 hover:bg-rose-50" type="submit">Se deconnecter</button>
                </form>
            </div>
        </div>
    </div>
</header>
