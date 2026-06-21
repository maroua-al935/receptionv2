@extends('Reception.layouts.master')

@section('body')
    <div class="space-y-6">
        <div class="visitx-hero">
            <div>
                <p class="visitx-eyebrow">Tableau de bord</p>
                <h1 class="page-title">Bonjour, {{ Auth::guard('web')->user()->lastname }}</h1>
                <p class="page-subtitle">Vue d'ensemble des visiteurs et de la file d'attente du jour.</p>
            </div>
            <div class="visitx-hero-side">
                <div class="visitx-hero-chip">
                    <span class="visitx-hero-dot"></span>
                    Flux reception actif
                </div>
                @if((int) Auth::guard('web')->user()->profile === 5)
                    <a href="{{ route('i_add_visitors') }}" class="primary-action inline-flex w-fit items-center gap-2">
                        <svg class="h-5 w-5" viewBox="0 0 24 24"><path fill="currentColor" d="M11 13H5v-2h6V5h2v6h6v2h-6v6h-2z"/></svg>
                        Ajouter un visiteur
                    </a>
                @endif
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="stat-card visitx-stat-card">
                <div class="visitx-stat-badge">Aujourd'hui</div>
                <div><p class="text-3xl font-semibold text-slate-900">{{ $today }}</p><p class="text-sm text-slate-500">Visiteurs aujourd'hui</p></div>
            </div>
            <div class="stat-card visitx-stat-card">
                <div class="visitx-stat-badge visitx-stat-badge-amber">Attention</div>
                <div><p class="text-3xl font-semibold text-slate-900">{{ $waiting }}</p><p class="text-sm text-slate-500">En attente</p></div>
            </div>
            <div class="stat-card visitx-stat-card">
                <div class="visitx-stat-badge visitx-stat-badge-green">En cours</div>
                <div><p class="text-3xl font-semibold text-slate-900">{{ $progress }}</p><p class="text-sm text-slate-500">En cours</p></div>
            </div>
            <div class="stat-card visitx-stat-card">
                <div class="visitx-stat-badge visitx-stat-badge-slate">Cloturees</div>
                <div><p class="text-3xl font-semibold text-slate-900">{{ $finished }}</p><p class="text-sm text-slate-500">Terminees</p></div>
            </div>
        </div>

        <section class="panel">
            <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900">Liste d'attente</h2>
                    <p class="text-sm text-slate-500">Visiteurs en attente de traitement.</p>
                </div>
                <span class="rounded-full bg-slate-100 px-3 py-1 text-sm font-medium text-slate-600">{{ $data->count() }} ligne(s)</span>
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
                                @if((int) Auth::guard('web')->user()->profile === 8)
                                    <th class="text-right">Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = $data->count() + 1; @endphp
                            @foreach($data as $row)
                                @php $i--; @endphp
                                <tr>
                                    <td class="px-5 py-4 text-center text-sm font-medium text-slate-700">{{ $i }}</td>
                                    <td class="px-5 py-4"><span class="rounded-lg bg-slate-100 px-3 py-1 text-sm font-semibold text-slate-700">{{ $row->badge_n ?: '-' }}</span></td>
                                    <td class="px-5 py-4">
                                        <div class="font-medium text-slate-900">{{ $row->firstname }} {{ $row->lastname }}</div>
                                        <div class="text-sm text-slate-500">{{ $row->org_name }}</div>
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="text-sm font-medium text-slate-900">{{ $row->emp_visited }}</div>
                                        <div class="text-sm text-slate-500">{{ $row->service_name }}</div>
                                    </td>
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
                                    @if((int) Auth::guard('web')->user()->profile === 8 && !in_array((int) $row->status, [2, 3], true))
                                        <td class="px-5 py-4 text-right">
                                            <a class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 transition hover:border-sky-200 hover:bg-sky-50 hover:text-sky-700" href="{{ route('i_edit_visitors',$row->id) }}">
                                                {{ empty($row->service_name) ? 'Orienter' : 'Modifier' }}
                                            </a>
                                        </td>
                                    @elseif((int) Auth::guard('web')->user()->profile === 8)
                                        <td class="px-5 py-4 text-right">
                                            <a class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 transition hover:border-sky-200 hover:bg-sky-50 hover:text-sky-700" href="{{ route('i_info',$row->id) }}">
                                                Voir
                                            </a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-5 py-12 text-center">
                    <p class="font-semibold text-slate-700">Aucune visite en attente</p>
                    <p class="mt-1 text-sm text-slate-500">Les nouvelles visites apparaitront ici.</p>
                </div>
            @endif
        </section>
    </div>
@endsection
