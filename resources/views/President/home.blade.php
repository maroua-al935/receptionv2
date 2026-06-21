@extends('President.layouts.master')

@section('body')
    @php
        $siegeCards = [
            ['label' => "Visiteurs siege aujourd'hui", 'value' => $today, 'tag' => '2% up', 'tone' => 'primary'],
            ['label' => 'Siege en attente', 'value' => $waiting, 'tag' => '1% down', 'tone' => 'warning'],
            ['label' => 'Siege en cours', 'value' => $progress, 'tag' => '3% up', 'tone' => 'success'],
            ['label' => 'Siege terminees', 'value' => $finished, 'tag' => 'Stable', 'tone' => 'slate'],
        ];

        $maxCardValue = max(1, $today, $waiting, $progress, $finished, $today_ant, $today_ant_visited);
        $networkTotal = max(1, $today + $today_ant);
        $siegeAngle = (int) round(($today / $networkTotal) * 360);
        $antennaAngle = (int) round(($today_ant / $networkTotal) * 360);
        $recentVisitors = $data->take(5);
        $statisticsPoints = [
            ['date' => 'Siege total', 'value' => $today, 'note' => 'Visiteurs du siege', 'accent' => '#7F56D9'],
            ['date' => 'En attente', 'value' => $waiting, 'note' => 'Attente au siege', 'accent' => '#9E77ED'],
            ['date' => 'En cours', 'value' => $progress, 'note' => 'Reception en cours', 'accent' => '#32D583'],
            ['date' => 'Antennes', 'value' => $today_ant, 'note' => 'Flux cumules antennes', 'accent' => '#FDB022'],
            ['date' => 'Sites actifs', 'value' => $today_ant_visited, 'note' => 'Antennes actives', 'accent' => '#0BA5EC'],
        ];
        $isTodayPeriod = ($selectedPeriod ?? 'today') === 'today';
    @endphp

    <div class="space-y-6">
        <div class="visitx-hero">
            <div>
                <p class="visitx-eyebrow">Presidence</p>
                <h1 class="page-title">Bonjour, {{ Auth::guard('web')->user()->lastname }}</h1>
                <p class="page-subtitle">Vue consolidee des visites du siege et des antennes.</p>
            </div>
            <div class="visitx-hero-side">
                <div class="visitx-hero-chip">
                    <span class="visitx-hero-dot"></span>
                    Supervision active
                </div>
                <a href="{{ route('i_visitors') }}" class="primary-action inline-flex w-fit items-center gap-2">
                    <svg class="h-5 w-5" viewBox="0 0 24 24"><path fill="currentColor" d="M12 4a8 8 0 1 1 0 16a8 8 0 0 1 0-16m0-2a10 10 0 1 0 0 20a10 10 0 0 0 0-20m1 5h-2v6h6v-2h-4z"/></svg>
                    Ouvrir le suivi
                </a>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            @foreach($siegeCards as $card)
                @php
                    $badgeClass = match ($card['tone']) {
                        'warning' => 'visitx-stat-badge visitx-stat-badge-amber',
                        'success' => 'visitx-stat-badge visitx-stat-badge-green',
                        'slate' => 'visitx-stat-badge visitx-stat-badge-slate',
                        default => 'visitx-stat-badge',
                    };
                    $bars = [];
                    $base = max(12, (int) round(($card['value'] / $maxCardValue) * 72));
                    for ($i = 0; $i < 5; $i++) {
                        $bars[] = max(10, min(74, $base - 18 + ($i * 8)));
                    }
                @endphp
                <div class="stat-card visitx-stat-card">
                    <div class="{{ $badgeClass }}">{{ $card['tag'] }}</div>
                    <div class="w-full">
                        <p class="text-sm text-slate-500">{{ $card['label'] }}</p>
                        <div class="mt-4 flex items-end justify-between gap-4">
                            <p class="text-4xl font-semibold leading-none text-slate-900">{{ $card['value'] }}</p>
                            <div class="flex h-14 items-end gap-1">
                                @foreach($bars as $barHeight)
                                    <span class="w-2 rounded-full {{ $card['tone'] === 'warning' ? 'bg-amber-400' : ($card['tone'] === 'success' ? 'bg-emerald-400' : ($card['tone'] === 'slate' ? 'bg-slate-300' : 'bg-violet-400')) }}" style="height: {{ $barHeight }}%"></span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_300px]">
            <section class="panel overflow-hidden">
                <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
                    <div>
                        <h2 class="text-xl font-semibold text-slate-900">Statistics (Total Visitor)</h2>
                        <p class="text-sm text-slate-500">Synthese du siege et du reseau antennes pour la periode selectionnee.</p>
                    </div>
                    <form method="get" action="{{ route('home') }}">
                        <select name="period" onchange="this.form.submit()" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm text-slate-500 shadow-sm outline-none">
                            <option value="today" @selected(($selectedPeriod ?? 'today') === 'today')>Aujourd'hui</option>
                            <option value="1_month" @selected(($selectedPeriod ?? '') === '1_month')>1 mois</option>
                            <option value="1_year" @selected(($selectedPeriod ?? '') === '1_year')>1 an</option>
                            <option value="2_years" @selected(($selectedPeriod ?? '') === '2_years')>2 ans</option>
                        </select>
                    </form>
                </div>

                <div class="px-6 py-6">
                    <div class="grid gap-4 md:grid-cols-5">
                        @foreach($statisticsPoints as $point)
                            @php
                                $fillHeight = max(14, min(100, (int) round(($point['value'] / $maxCardValue) * 100)));
                            @endphp
                            <div class="rounded-2xl border border-slate-100 bg-slate-50/70 p-4">
                                <p class="text-xs font-medium text-slate-500">{{ $point['date'] }}</p>
                                <p class="mt-2 text-4xl font-semibold leading-none text-slate-950">{{ $point['value'] }}</p>
                                <p class="mt-2 text-xs text-slate-400">{{ $point['note'] }}</p>
                                <div class="mt-6 flex h-40 items-end">
                                    <div class="relative w-full overflow-hidden rounded-2xl bg-white/80 ring-1 ring-slate-100">
                                        <div class="absolute inset-x-0 bottom-0 rounded-2xl" style="height: {{ $fillHeight }}%; background: linear-gradient(180deg, {{ $point['accent'] }}, {{ $point['accent'] }}99);"></div>
                                        <div class="relative flex h-40 items-end justify-center pb-3">
                                            <span class="rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-slate-700 shadow-sm">{{ $point['value'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <div class="flex flex-col gap-6">
                <section class="panel p-5">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-slate-900">Reseau siege / antennes</h2>
                        <span class="text-xs text-slate-400">Quotidien</span>
                    </div>
                    <div class="relative mx-auto mt-6 h-44 w-44 rounded-full" style="background: conic-gradient(#7F56D9 0deg {{ $siegeAngle }}deg, #32D583 {{ $siegeAngle }}deg {{ $siegeAngle + $antennaAngle }}deg, #FDB022 {{ $siegeAngle + $antennaAngle }}deg 360deg);">
                        <div class="absolute inset-[18px] flex items-center justify-center rounded-full bg-white text-center">
                            <div>
                                <p class="text-2xl font-bold text-slate-950">{{ $networkTotal }}</p>
                                <p class="text-xs leading-5 text-slate-500">visites consolidees<br>ce jour</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 space-y-3">
                        <div class="flex items-center gap-3 text-sm"><span class="h-2.5 w-2.5 rounded-full bg-violet-500"></span><span class="flex-1 text-slate-500">Siege</span><span class="font-semibold text-slate-900">{{ $today }}</span></div>
                        <div class="flex items-center gap-3 text-sm"><span class="h-2.5 w-2.5 rounded-full bg-emerald-400"></span><span class="flex-1 text-slate-500">Antennes</span><span class="font-semibold text-slate-900">{{ $today_ant }}</span></div>
                        <div class="flex items-center gap-3 text-sm"><span class="h-2.5 w-2.5 rounded-full bg-amber-400"></span><span class="flex-1 text-slate-500">Sites actifs</span><span class="font-semibold text-slate-900">{{ $today_ant_visited }}</span></div>
                    </div>
                </section>

                <section class="panel p-5">
                    <div class="text-center">
                        <h2 class="text-xl font-semibold text-slate-900">Acces rapides</h2>
                        <p class="mt-2 text-sm text-slate-500">Navigation presidentielle vers les ecrans de supervision.</p>
                    </div>
                    <div class="mt-5 space-y-3">
                        <a href="{{ route('i_visitors') }}" class="flex items-center justify-between rounded-2xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-violet-200 hover:bg-violet-50">
                            <span>Visiteurs siege</span>
                            <span>{{ $today }}</span>
                        </a>
                        <a href="{{ route('i_visitors_ant') }}" class="flex items-center justify-between rounded-2xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-emerald-200 hover:bg-emerald-50">
                            <span>Visiteurs antennes</span>
                            <span>{{ $today_ant }}</span>
                        </a>
                        <a href="{{ route('i_history') }}" class="flex items-center justify-between rounded-2xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:bg-slate-50">
                            <span>Historique siege</span>
                            <span>{{ $finished }}</span>
                        </a>
                    </div>
                </section>
            </div>
        </div>

        <section class="panel overflow-hidden">
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">{{ $isTodayPeriod ? 'Recent Visits' : 'Historique des visites' }}</h2>
                    <p class="text-sm text-slate-500">
                        {{ $isTodayPeriod ? "Dernieres visites enregistrees aujourd'hui dans le systeme de supervision." : "Historique des visites pour la periode " . ($periodLabel ?? '') . "." }}
                    </p>
                </div>
                <span class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm text-slate-500">{{ $isTodayPeriod ? 'Dernieres entrees' : ($periodLabel ?? 'Historique') }}</span>
            </div>

            <div class="px-6 py-5">
                <div class="mb-5 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="visitx-search flex w-full max-w-sm xl:flex">
                        <svg class="h-4 w-4" viewBox="0 0 24 24"><path fill="currentColor" d="M9.5 3a6.5 6.5 0 0 1 5.176 10.435l4.445 4.444l-1.414 1.414l-4.444-4.445A6.5 6.5 0 1 1 9.5 3m0 2a4.5 4.5 0 1 0 0 9a4.5 4.5 0 0 0 0-9"/></svg>
                        <input type="text" placeholder="Recherche visuelle uniquement" />
                    </div>
                    <a href="{{ route('i_visitors') }}" class="primary-action inline-flex w-fit items-center gap-2">
                        <svg class="h-5 w-5" viewBox="0 0 24 24"><path fill="currentColor" d="M11 13H5v-2h6V5h2v6h6v2h-6v6h-2z"/></svg>
                        Ouvrir la liste
                    </a>
                </div>

                @if(!$recentVisitors->isEmpty())
                    <div class="overflow-x-auto">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Visiteur</th>
                                    <th>Hote</th>
                                    <th>Objet</th>
                                    <th>Status</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentVisitors as $row)
                                    <tr>
                                        <td class="px-5 py-4 text-sm text-slate-500">{{ to_normal_date($row->entry_date) }}</td>
                                        <td class="px-5 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-violet-100 text-sm font-bold text-violet-700">
                                                    {{ strtoupper(substr($row->firstname ?? 'V', 0, 1)) }}{{ strtoupper(substr($row->lastname ?? 'I', 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="font-medium text-slate-900">{{ $row->firstname }} {{ $row->lastname }}</div>
                                                    <div class="text-sm text-slate-500">{{ $row->org_name ?: 'Organisme non renseigne' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4">
                                            <div class="text-sm font-medium text-slate-900">{{ $row->emp_visited ?: 'Non assigne' }}</div>
                                            <div class="text-sm text-slate-500">{{ $row->service_name ?: 'Service non renseigne' }}</div>
                                        </td>
                                        <td class="px-5 py-4 text-sm text-slate-500">{{ $row->subject ?: 'Sans objet' }}</td>
                                        <td class="px-5 py-4">
                                            @switch($row->status)
                                                @case(0)<span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">En attente</span>@break
                                                @case(1)<span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800">En cours</span>@break
                                                @case(2)<span class="rounded-full bg-slate-200 px-3 py-1 text-xs font-semibold text-slate-700">Terminee</span>@break
                                                @case(3)<span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-800">Badge a recuperer</span>@break
                                            @endswitch
                                        </td>
                                        <td class="px-5 py-4">
                                            <div class="flex justify-end">
                                                <a class="rounded-xl border border-slate-200 p-2 text-slate-600 transition hover:border-violet-200 hover:bg-violet-50 hover:text-violet-700" href="{{ route('i_info',$row->id) }}" title="Voir">
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
                    <div class="py-12 text-center">
                        <p class="font-semibold text-slate-700">Aucune visite siege a afficher</p>
                        <p class="mt-1 text-sm text-slate-500">Le tableau se remplira automatiquement avec les donnees existantes.</p>
                    </div>
                @endif
            </div>
        </section>

        <section class="panel panel-pad">
           
            @livewire('antennes-list')
        </section>
    </div>
@endsection
