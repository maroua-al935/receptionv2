<div x-cloak :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed inset-0 z-20 bg-slate-400/40 backdrop-blur-sm transition-opacity lg:hidden"></div>

<aside x-cloak :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="app-sidebar fixed inset-y-0 left-0 z-30 w-72 overflow-y-auto transition duration-300 transform lg:translate-x-0 lg:static lg:inset-0">
    <div class="sidebar-brand">
        <img class="h-12 w-12 object-contain" src="{{ url('images/logo.png') }}" alt="VisiLog">
        <div><p class="text-xs font-black uppercase tracking-widest text-white">Reception Console</p><p class="text-[9px] font-extrabold uppercase tracking-wider text-indigo-400">ANAM Central</p></div>
    </div>
    <div class="console-status">
        <div class="console-status-title">Console Centrale</div>
        <p class="console-status-text">Surete, acces et tracabilite des visiteurs.</p>
    </div>
    <nav class="sidebar-nav">
        <a class="sidebar-link @if($url == 'home') sidebar-link-active @endif" href="/"><svg class="h-5 w-5" viewBox="0 0 24 24"><path fill="currentColor" d="M10 20v-6h4v6h5v-8h3L12 3L2 12h3v8z"/></svg>Accueil</a>
        <a class="sidebar-link @if($url == 'guest') sidebar-link-active @endif" href="{{ route('i_visitors') }}"><svg class="h-5 w-5" viewBox="0 0 24 24"><path fill="currentColor" d="M16 11c1.66 0 3-1.34 3-3s-1.34-3-3-3s-3 1.34-3 3M8 11c1.66 0 3-1.34 3-3S9.66 5 8 5S5 6.34 5 8s1.34 3 3 3m0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5C15 14.17 10.33 13 8 13"/></svg>Visiteurs</a>
        <a class="sidebar-link @if($url == 'history') sidebar-link-active @endif" href="{{ route('i_history') }}"><svg class="h-5 w-5" viewBox="0 0 24 24"><path fill="currentColor" d="M13 3a9 9 0 1 1-9 9H1l4-4l4 4H6a7 7 0 1 0 7-7zm-1 4h2v5l4 2l-1 1.73l-5-3z"/></svg>Historique</a>
    </nav>
</aside>
