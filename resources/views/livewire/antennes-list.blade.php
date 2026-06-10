<div class="space-y-5">
    @php
        $totalPassages = 0;
        $activeAntennes = 0;
        foreach ($antennes as $antenneStat) {
            foreach ($antennes_visited as $visitedStat) {
                if ($antenneStat->ant_id == $visitedStat->ant_location) {
                    $totalPassages += $visitedStat->count;
                    if ($visitedStat->count > 0) {
                        $activeAntennes++;
                    }
                    break;
                }
            }
        }
    @endphp

    <div class="grid gap-4 lg:grid-cols-12">
        <aside class="lg:col-span-3">
            <div class="h-full rounded-2xl bg-white p-5 text-slate-900 shadow-sm" style="border:1px solid rgba(56,84,166,.18)">
                <p class="text-[10px] font-black uppercase tracking-widest" style="color:#2949A6">Reseau antennes</p>
                <h3 class="mt-2 text-xl font-black uppercase tracking-tight text-slate-950">Supervision</h3>
                <p class="mt-2 text-xs font-medium leading-relaxed text-slate-500">Vue rapide des terminaux antennes et de leur charge de passage aujourd'hui.</p>

                <div class="mt-6 grid gap-3">
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                        <p class="font-mono text-3xl font-black text-slate-950">{{ str_pad($antennes->count(), 2, '0', STR_PAD_LEFT) }}</p>
                        <p class="mt-1 text-[10px] font-bold uppercase tracking-wide text-slate-500">Antennes totales</p>
                    </div>
                    <div class="rounded-xl p-4" style="border:1px solid rgba(56,84,166,.18); background:rgba(56,84,166,.08)">
                        <p class="font-mono text-3xl font-black" style="color:#3854A6">{{ str_pad($activeAntennes, 2, '0', STR_PAD_LEFT) }}</p>
                        <p class="mt-1 text-[10px] font-bold uppercase tracking-wide" style="color:#3854A6">Actives aujourd'hui</p>
                    </div>
                    <div class="rounded-xl p-4" style="border:1px solid rgba(41,73,166,.18); background:rgba(41,73,166,.08)">
                        <p class="font-mono text-3xl font-black" style="color:#2949A6">{{ str_pad($totalPassages, 2, '0', STR_PAD_LEFT) }}</p>
                        <p class="mt-1 text-[10px] font-bold uppercase tracking-wide" style="color:#2949A6">Passages cumules</p>
                    </div>
                </div>
            </div>
        </aside>

        <section class="lg:col-span-9">
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="grid grid-cols-12 border-b border-slate-100 bg-slate-50 px-5 py-3 text-[10px] font-black uppercase tracking-widest text-slate-400">
                    <div class="col-span-5">Antenne</div>
                    <div class="col-span-3">Activite</div>
                    <div class="col-span-2 text-center">Passages</div>
                    <div class="col-span-2 text-right">Action</div>
                </div>

                <div class="divide-y divide-slate-100">
                    @foreach ($antennes as $antenne)
                        @php
                            $todayCount = 0;
                            foreach ($antennes_visited as $visited) {
                                if ($antenne->ant_id == $visited->ant_location) {
                                    $todayCount = $visited->count;
                                    break;
                                }
                            }
                            $levelWidth = min(100, $todayCount * 18);
                        @endphp

                        <button
                            type="button"
                            wire:click="select('{{ $antenne->ant_id }}')"
                            class="grid w-full grid-cols-12 items-center gap-3 px-5 py-4 text-left transition hover:bg-indigo-50/40"
                        >
                            <div class="col-span-5 flex min-w-0 items-center gap-3">
                                <div class="relative flex h-11 w-11 shrink-0 items-center justify-center rounded-xl {{ $todayCount > 0 ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-500' }}">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24"><path fill="currentColor" d="M15 11V5.83c0-.53-.21-1.04-.59-1.41L12.7 2.71a.996.996 0 0 0-1.41 0l-1.7 1.7C9.21 4.79 9 5.3 9 5.83V7H5c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-6c0-1.1-.9-2-2-2z"/></svg>
                                    @if($todayCount > 0)
                                        <span class="absolute -right-1 -top-1 h-3 w-3 rounded-full border-2 border-white bg-emerald-500"></span>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-black uppercase tracking-wide text-slate-900">{{ $antenne->antenne_name }}</p>
                                    <p class="text-[11px] font-semibold text-slate-500">Terminal #{{ str_pad($antenne->ant_id, 3, '0', STR_PAD_LEFT) }}</p>
                                </div>
                            </div>

                            <div class="col-span-3">
                                <div class="h-2 overflow-hidden rounded-full bg-slate-100">
                                    <div class="h-full rounded-full {{ $todayCount > 0 ? 'bg-indigo-600' : 'bg-slate-300' }}" style="width: {{ $todayCount > 0 ? max(16, $levelWidth) : 8 }}%"></div>
                                </div>
                                    <p class="mt-1 text-[10px] font-bold uppercase tracking-wide {{ $todayCount > 0 ? '' : 'text-slate-400' }}" @if($todayCount > 0) style="color:#2949A6" @endif>
                                    {{ $todayCount > 0 ? 'Flux detecte' : 'Aucun flux' }}
                                </p>
                            </div>

                            <div class="col-span-2 text-center">
                                <span class="inline-flex min-w-12 justify-center rounded-lg border {{ $todayCount > 0 ? '' : 'border-slate-200 bg-slate-50 text-slate-500' }} px-3 py-1 font-mono text-sm font-black" @if($todayCount > 0) style="border-color:rgba(56,84,166,.18); background:rgba(41,73,166,.08); color:#2949A6" @endif>
                                    {{ str_pad($todayCount, 2, '0', STR_PAD_LEFT) }}
                                </span>
                            </div>

                            <div class="col-span-2 flex justify-end">
                                <span class="inline-flex items-center gap-1 rounded-lg border border-slate-200 px-3 py-2 text-[10px] font-black uppercase tracking-wide text-slate-500 transition group-hover:border-indigo-200 group-hover:text-indigo-600">
                                    Voir
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24"><path fill="currentColor" d="m14 18l-1.4-1.45L16.15 13H4v-2h12.15L12.6 7.45L14 6l6 6z"/></svg>
                                </span>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>
        </section>
    </div>

    @if ($state)
        <div x-data="{ modelOpen: true }">
            <div x-show="modelOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex min-h-screen items-end justify-center px-4 text-center md:items-center sm:p-0">
                    <div x-cloak wire:click="close()" x-show="modelOpen" x-transition.opacity class="fixed inset-0 bg-slate-400/40 backdrop-blur-sm" aria-hidden="true"></div>

                    <div x-cloak x-show="modelOpen" x-transition class="relative my-8 inline-block w-full max-w-6xl overflow-hidden rounded-2xl border border-slate-200 bg-white text-left align-middle shadow-2xl">
                        <div class="flex items-start justify-between gap-4 border-b border-slate-100 px-6 py-5 text-slate-950" style="background:rgba(41,73,166,.08)">
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-widest" style="color:#2949A6">Detail antenne</p>
                                <h1 class="mt-1 text-xl font-black uppercase tracking-tight">Antenne {{ $antenne_n->antenne_name }}</h1>
                                <p class="mt-1 text-xs font-medium text-slate-500">Visiteurs enregistres aujourd'hui.</p>
                            </div>

                            <button wire:click="close()" class="rounded-lg border border-slate-200 bg-white p-2 text-slate-500 transition hover:bg-indigo-100 hover:text-indigo-700">
                                <svg class="h-5 w-5" viewBox="0 0 24 24"><path fill="currentColor" d="m12 10.6l4.95-4.95l1.4 1.4L13.4 12l4.95 4.95l-1.4 1.4L12 13.4l-4.95 4.95l-1.4-1.4L10.6 12L5.65 7.05l1.4-1.4z"/></svg>
                            </button>
                        </div>

                        @if (!$info->isEmpty())
                            <div class="overflow-x-auto">
                                <table class="modern-table">
                                    <thead>
                                        <tr>
                                            <th>Num</th>
                                            <th>Visiteur</th>
                                            <th>Hote</th>
                                            <th>Date entree</th>
                                            <th>Status</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i = 0; @endphp
                                        @foreach($info as $row)
                                            @php $i++; @endphp
                                            <tr>
                                                <td class="px-5 py-4 text-sm font-bold text-slate-700">{{ $i }}</td>
                                                <td class="px-5 py-4">
                                                    <div class="font-bold text-slate-900">{{ $row->firstname }} {{ $row->lastname }}</div>
                                                    <div class="text-xs font-medium text-slate-500">{{ $row->org_name }}</div>
                                                </td>
                                                <td class="px-5 py-4">
                                                    <div class="text-sm font-bold text-slate-900">{{ $row->emp_visited }}</div>
                                                    <div class="text-xs font-medium text-slate-500">Antenne {{ $row->service_name }}</div>
                                                </td>
                                                <td class="px-5 py-4 text-sm font-medium text-slate-500">{{ to_normal_date($row->entry_date) }}</td>
                                                <td class="px-5 py-4">
                                                    @switch($row->status)
                                                        @case(0)<span class="status-chip status-waiting">En attente</span>@break
                                                        @case(1)<span class="status-chip status-progress">En cours</span>@break
                                                        @case(2)<span class="status-chip status-done">Terminee</span>@break
                                                    @endswitch
                                                </td>
                                                <td class="px-5 py-4">
                                                    <div class="flex justify-end">
                                                        <a class="rounded-lg border border-slate-200 p-2 text-slate-600 transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-700" href="{{ route('i_ant_p_info',$row->id) }}" title="Voir">
                                                            <svg class="h-4 w-4" viewBox="0 0 24 24"><path fill="currentColor" d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5m0 12.5a5 5 0 1 1 0-10a5 5 0 0 1 0 10m0-8a3 3 0 1 0 0 6a3 3 0 0 0 0-6"/></svg>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="px-6 py-14 text-center">
                                <p class="font-black text-slate-700">Aucun visiteur aujourd'hui</p>
                                <p class="mt-1 text-sm text-slate-500">Cette antenne n'a aucun passage enregistre pour la journee.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
