@extends('Service.layouts.master')

@section('body')
    @php
        $serviceCards = [
            ['label' => "Visiteurs service aujourd'hui", 'value' => $today, 'tag' => '2% up', 'tone' => 'primary'],
            ['label' => 'Service en attente', 'value' => $waiting, 'tag' => '1% down', 'tone' => 'warning'],
            ['label' => 'Service en cours', 'value' => $progress, 'tag' => '3% up', 'tone' => 'success'],
            ['label' => 'Service terminees', 'value' => $finished, 'tag' => 'Stable', 'tone' => 'slate'],
        ];

        $maxCardValue = max(1, $today, $waiting, $progress, $finished);
        $recentVisitors = $data->take(5);
        $isTodayPeriod = true;
    @endphp

    <div class="space-y-6">
        <div class="visitx-hero">
            <div>
                <p class="visitx-eyebrow">Service</p>
                <h1 class="page-title">Bonjour, {{ Auth::guard('web')->user()->lastname }}</h1>
                <p class="page-subtitle">Suivi des visiteurs affectes a votre service et des traitements en cours.</p>
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
            @foreach($serviceCards as $card)
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

        <section class="panel overflow-hidden">
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Liste d'attente du service</h2>
                    <p class="text-sm text-slate-500">Visiteurs du jour pour le service, avec affectation, lancement et cloture.</p>
                </div>
                <a href="{{ route('i_visitors') }}" class="primary-action inline-flex w-fit items-center gap-2">
                    <svg class="h-5 w-5" viewBox="0 0 24 24"><path fill="currentColor" d="M11 13H5v-2h6V5h2v6h6v2h-6v6h-2z"/></svg>
                    Ouvrir la liste
                </a>
            </div>

            @if(!$data->isEmpty())
                <div class="overflow-x-auto">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th class="text-center">Num</th>
                                <th>Badge</th>
                                <th>Visiteur</th>
                                <th>Hote</th>
                                <th>Date entree</th>
                                <th>Objet</th>
                                <th class="text-center">Status</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 0; @endphp
                            @foreach($data as $row)
                                @php $i++; @endphp
                                <tr>
                                    <td class="px-5 py-4 text-center text-sm font-medium text-slate-700">{{ $i }}</td>
                                    <td class="px-5 py-4"><span class="rounded-lg bg-slate-100 px-3 py-1 text-sm font-semibold text-slate-700">{{ $row->badge_n ?: '-' }}</span></td>
                                    <td class="px-5 py-4"><div class="font-medium text-slate-900">{{ $row->firstname }} {{ $row->lastname }}</div><div class="text-sm text-slate-500">{{ $row->org_name }}</div></td>
                                    <td class="px-5 py-4"><div class="text-sm font-medium text-slate-900">{{ $row->emp_visited }}</div><div class="text-sm text-slate-500">{{ $row->service_name }}</div></td>
                                    <td class="px-5 py-4 text-sm text-slate-500">{{ to_normal_date($row->entry_date) }}</td>
                                    <td class="px-5 py-4 text-sm text-slate-600">{{ $row->subject }}</td>
                                    <td class="px-5 py-4 text-center">
                                        @switch($row->status)
                                            @case(0)<span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">En attente</span>@break
                                            @case(1)<span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800">En cours</span>@break
                                            @case(2)<span class="rounded-full bg-slate-200 px-3 py-1 text-xs font-semibold text-slate-700">Terminee</span>@break
                                            @case(3)<span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-800">Badge a recuperer</span>@break
                                        @endswitch
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="flex justify-end">
                                            @if((int) Auth::guard('web')->user()->profile === 9 && $row->status == 0)
                                                <form action="{{ route('p_edit_visitors', $row->id) }}" method="post" class="flex items-center gap-2">
                                                    @csrf
                                                    <select name="hostname" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs text-slate-700">
                                                        <option value="">Choisir un agent</option>
                                                        @foreach(($serviceUsers ?? collect()) as $user)
                                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" name="status" value="1">
                                                    <button class="rounded-xl bg-violet-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-violet-700" type="submit">Affecter et lancer</button>
                                                </form>
                                            @elseif(in_array((int) Auth::guard('web')->user()->profile, [3, 4], true) && empty($row->emp_visited))
                                                <a class="rounded-xl bg-violet-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-violet-700" href="{{ route('i_edit_visitors', $row->id) }}">
                                                    Affecter
                                                </a>
                                            @elseif($row->status == 0)
                                                <form action="{{ route('p_workflow_visitors', $row->id) }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="status" value="1">
                                                    <button class="rounded-xl bg-violet-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-violet-700" type="submit">Lancer</button>
                                                </form>
                                            @elseif($row->status == 1)
                                                <form action="{{ route('p_workflow_visitors', $row->id) }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="status" value="3">
                                                    <button class="rounded-xl bg-emerald-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-emerald-700" type="submit">Visite terminee</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-5 py-12 text-center">
                    <p class="font-semibold text-slate-700">Aucune visite en attente</p>
                    <p class="mt-1 text-sm text-slate-500">Les nouvelles affectations apparaitront ici.</p>
                </div>
            @endif
        </section>
    </div>
@endsection
