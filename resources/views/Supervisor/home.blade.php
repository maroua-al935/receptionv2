@extends('Supervisor.layouts.master')

@section('body')
    <div class="space-y-6">
        <div class="visitx-hero">
            <div>
                <p class="visitx-eyebrow">Supervision</p>
                <h1 class="page-title">Bonjour, {{ Auth::guard('web')->user()->lastname }}</h1>
                <p class="page-subtitle">Vue globale des flux visiteurs, en attente, en cours et termines.</p>
            </div>
            <div class="visitx-hero-side">
                <div class="visitx-hero-chip">
                    <span class="visitx-hero-dot"></span>
                    Controle central
                </div>
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="stat-card">
                <div class="stat-icon bg-violet-600"><svg class="h-6 w-6" viewBox="0 0 512 512"><circle cx="152" cy="184" r="72" fill="currentColor"/><path fill="currentColor" d="M234 296c-28.16-14.3-59.24-20-82-20c-44.58 0-136 27.34-136 82v42h150v-16.07c0-19 8-38.05 22-53.93c11.17-12.68 26.81-24.45 46-34Z"/><path fill="currentColor" d="M340 288c-52.07 0-156 32.16-156 96v48h312v-48c0-63.84-103.93-96-156-96Z"/><circle cx="340" cy="168" r="88" fill="currentColor"/></svg></div>
                <div><p class="text-3xl font-semibold text-slate-900">{{ $today }}</p><p class="text-sm text-slate-500">Visiteurs aujourd'hui</p></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-amber-500"><svg class="h-6 w-6" viewBox="0 0 512 512"><circle cx="152" cy="184" r="72" fill="currentColor"/><path fill="currentColor" d="M234 296c-28.16-14.3-59.24-20-82-20c-44.58 0-136 27.34-136 82v42h150v-16.07c0-19 8-38.05 22-53.93c11.17-12.68 26.81-24.45 46-34Z"/><path fill="currentColor" d="M340 288c-52.07 0-156 32.16-156 96v48h312v-48c0-63.84-103.93-96-156-96Z"/><circle cx="340" cy="168" r="88" fill="currentColor"/></svg></div>
                <div><p class="text-3xl font-semibold text-slate-900">{{ $waiting }}</p><p class="text-sm text-slate-500">En attente</p></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-emerald-600"><svg class="h-6 w-6" viewBox="0 0 512 512"><circle cx="152" cy="184" r="72" fill="currentColor"/><path fill="currentColor" d="M234 296c-28.16-14.3-59.24-20-82-20c-44.58 0-136 27.34-136 82v42h150v-16.07c0-19 8-38.05 22-53.93c11.17-12.68 26.81-24.45 46-34Z"/><path fill="currentColor" d="M340 288c-52.07 0-156 32.16-156 96v48h312v-48c0-63.84-103.93-96-156-96Z"/><circle cx="340" cy="168" r="88" fill="currentColor"/></svg></div>
                <div><p class="text-3xl font-semibold text-slate-900">{{ $progress }}</p><p class="text-sm text-slate-500">En cours</p></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-slate-700"><svg class="h-6 w-6" viewBox="0 0 512 512"><circle cx="152" cy="184" r="72" fill="currentColor"/><path fill="currentColor" d="M234 296c-28.16-14.3-59.24-20-82-20c-44.58 0-136 27.34-136 82v42h150v-16.07c0-19 8-38.05 22-53.93c11.17-12.68 26.81-24.45 46-34Z"/><path fill="currentColor" d="M340 288c-52.07 0-156 32.16-156 96v48h312v-48c0-63.84-103.93-96-156-96Z"/><circle cx="340" cy="168" r="88" fill="currentColor"/></svg></div>
                <div><p class="text-3xl font-semibold text-slate-900">{{ $finished }}</p><p class="text-sm text-slate-500">Terminees</p></div>
            </div>
        </div>

        <section class="panel overflow-hidden">
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Liste d'attente</h2>
                    <p class="text-sm text-slate-500">Suivi lecture seule des visites en attente de traitement.</p>
                </div>
                <span class="rounded-full bg-slate-100 px-3 py-1 text-sm font-medium text-slate-600">{{ $data->count() }} ligne(s)</span>
            </div>

            @if(!$data->isEmpty())
                <div class="overflow-x-auto">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th class="text-center">Num</th>
                                <th>Visiteur</th>
                                <th>Hote</th>
                                <th>Date entree</th>
                                <th>Objet</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 0; @endphp
                            @foreach($data as $row)
                                @php $i++; @endphp
                                <tr>
                                    <td class="px-5 py-4 text-center text-sm font-medium text-slate-700">{{ $i }}</td>
                                    <td class="px-5 py-4">
                                        <div class="font-medium text-slate-900">{{ $row->firstname }} {{ $row->lastname }}</div>
                                        <div class="text-sm text-slate-500">{{ $row->org_name }}</div>
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="text-sm font-medium text-slate-900">{{ $row->emp_visited }}</div>
                                        <div class="text-sm text-slate-500">{{ $row->service_name }}</div>
                                    </td>
                                    <td class="px-5 py-4 text-sm text-slate-500">{{ $row->entry }}</td>
                                    <td class="px-5 py-4 text-sm text-slate-600">{{ $row->subject }}</td>
                                    <td class="px-5 py-4 text-center">
                                        @switch($row->status)
                                            @case(0)<span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">En attente</span>@break
                                            @case(1)<span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800">En cours</span>@break
                                            @case(2)<span class="rounded-full bg-slate-200 px-3 py-1 text-xs font-semibold text-slate-700">Terminee</span>@break
                                        @endswitch
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-14 text-center">
                    <p class="font-semibold text-slate-700">Aucune visite dans cette file.</p>
                    <p class="mt-1 text-sm text-slate-500">Les enregistrements de supervision apparaitront ici automatiquement.</p>
                </div>
            @endif
        </section>
    </div>
@endsection
