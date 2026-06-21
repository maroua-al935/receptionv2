<div class="mt-5 rounded-2xl border border-violet-300/30 bg-white/10 p-4 text-white">
    <div class="flex items-center justify-between gap-3">
        <div>
            <p class="text-[10px] font-black uppercase tracking-widest text-violet-300">Accueil</p>
            <h3 class="mt-1 text-sm font-black uppercase tracking-wide text-white">Antennes du jour</h3>
        </div>
        <span class="rounded-full bg-violet-500/20 px-2.5 py-1 text-[10px] font-black uppercase tracking-widest text-violet-200">
            {{ count($antennesToday) }}
        </span>
    </div>

    <div class="mt-4 space-y-2">
        @forelse($antennesToday as $antenne)
            <div class="flex items-center justify-between rounded-xl bg-white/5 px-3 py-2">
                <div class="min-w-0">
                    <p class="truncate text-sm font-semibold text-white">{{ $antenne->antenne_name }}</p>
                    <p class="text-[10px] uppercase tracking-widest text-violet-200">Visites aujourd'hui</p>
                </div>
                <span class="ml-3 rounded-full bg-violet-500/20 px-2.5 py-1 text-xs font-black text-violet-100">
                    {{ $antenne->visits_count }}
                </span>
            </div>
        @empty
            <div class="rounded-xl border border-dashed border-violet-300/30 bg-white/5 px-3 py-4 text-center">
                <p class="text-sm font-semibold text-white">Aucune antenne visitée</p>
                <p class="mt-1 text-[11px] text-violet-200">Les visites d'aujourd'hui s'affichent ici.</p>
            </div>
        @endforelse
    </div>
</div>
