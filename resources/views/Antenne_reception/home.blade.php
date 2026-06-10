@extends('Antenne_reception.layouts.master')

@section('body')
    <div class="space-y-6">
        <section class="antenne-hero">
            <div>
                <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-rose-600">
                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                    Antenne active
                </div>
                <h1 class="mt-2 text-2xl font-black uppercase tracking-tight text-slate-950">Bonjour, {{ Auth::guard('web')->user()->lastname }}</h1>
                <p class="mt-1 text-xs font-medium text-slate-500">Suivi local des visiteurs, passages en attente et visites cloturees pour {{ $loc ?? 'cette antenne' }}.</p>
            </div>
            @if((int) Auth::guard('web')->user()->profile === 6)
                <a href="{{ route('i_ant_add_visitors') }}" class="antenne-action">
                    <svg class="h-4 w-4" viewBox="0 0 24 24"><path fill="currentColor" d="M11 13H5v-2h6V5h2v6h6v2h-6v6h-2z"/></svg>
                    Nouvelle visite
                </a>
            @endif
        </section>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="antenne-kpi">
                <div class="antenne-kpi-icon bg-rose-600"><svg class="h-5 w-5" viewBox="0 0 24 24"><path fill="currentColor" d="M16 11c1.66 0 3-1.34 3-3s-1.34-3-3-3s-3 1.34-3 3s1.34 3 3 3M8 11c1.66 0 3-1.34 3-3S9.66 5 8 5S5 6.34 5 8s1.34 3 3 3m0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5C15 14.17 10.33 13 8 13"/></svg></div>
                <div><p class="antenne-kpi-value">{{ $today }}</p><p class="antenne-kpi-label">Aujourd'hui</p></div>
            </div>
            <div class="antenne-kpi">
                <div class="antenne-kpi-icon bg-amber-500"><svg class="h-5 w-5" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2a10 10 0 1 0 10 10A10.011 10.011 0 0 0 12 2m1 10.414l3.293 3.293l-1.414 1.414L11 13.243V6h2z"/></svg></div>
                <div><p class="antenne-kpi-value">{{ $waiting }}</p><p class="antenne-kpi-label">En attente</p></div>
            </div>
            <div class="antenne-kpi">
                <div class="antenne-kpi-icon bg-emerald-600"><svg class="h-5 w-5" viewBox="0 0 24 24"><path fill="currentColor" d="m10 15.17l9.19-9.19l1.41 1.42L10 18L3.4 11.4l1.41-1.41z"/></svg></div>
                <div><p class="antenne-kpi-value">{{ $progress }}</p><p class="antenne-kpi-label">En cours</p></div>
            </div>
            <div class="antenne-kpi">
                <div class="antenne-kpi-icon bg-slate-800"><svg class="h-5 w-5" viewBox="0 0 24 24"><path fill="currentColor" d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2m-8 14l-5-5l1.41-1.41L11 14.17l5.59-5.59L18 10z"/></svg></div>
                <div><p class="antenne-kpi-value">{{ $finished }}</p><p class="antenne-kpi-label">Terminees</p></div>
            </div>
        </div>

        <section class="panel antenne-panel">
            <div class="antenne-panel-head">
                <div>
                    <h2 class="text-sm font-black uppercase tracking-wide text-slate-900">Liste d'attente antenne</h2>
                    <p class="text-xs font-medium text-slate-500">Visiteurs en attente de traitement local.</p>
                </div>
                <span class="rounded-full bg-rose-50 px-3 py-1 text-xs font-black text-rose-700">{{ $data->count() }} ligne(s)</span>
            </div>

            @if(!$data->isEmpty())
                <div class="overflow-x-auto">
                    <table class="modern-table antenne-table">
                        <thead>
                            <tr>
                                <th class="text-center">Num</th>
                                <th>Visiteur</th>
                                <th>Hote</th>
                                <th>Date entree</th>
                                <th>Objet</th>
                                <th class="text-center">Status</th>
                                @if((int) Auth::guard('web')->user()->profile === 7)
                                    <th class="text-right">Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 0; @endphp
                            @foreach($data as $row)
                                @php $i++; @endphp
                                <tr>
                                    <td class="px-5 py-4 text-center text-sm font-bold text-slate-700">{{ $i }}</td>
                                    <td class="px-5 py-4">
                                        <div class="font-bold text-slate-900">{{ $row->firstname }} {{ $row->lastname }}</div>
                                        <div class="text-xs font-medium text-slate-500">{{ $row->org_name }}</div>
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="text-sm font-bold text-slate-900">{{ $row->emp_visited }}</div>
                                        <div class="text-xs font-medium text-rose-600">{{ $row->ant_name }}</div>
                                    </td>
                                    <td class="px-5 py-4 text-sm font-medium text-slate-500">{{ to_normal_date($row->entry_date) }}</td>
                                    <td class="px-5 py-4 text-sm font-medium text-slate-600">{{ $row->subject }}</td>
                                    <td class="px-5 py-4 text-center">
                                        @switch($row->status)
                                            @case(0)<span class="status-chip status-waiting">En attente</span>@break
                                            @case(1)<span class="status-chip status-progress">En cours</span>@break
                                            @case(2)<span class="status-chip status-done">Terminee</span>@break
                                        @endswitch
                                    </td>
                                    @if((int) Auth::guard('web')->user()->profile === 7)
                                        <td class="px-5 py-4">
                                            <div class="flex justify-end">
                                                @if(($isAntenneHead ?? false) && empty($row->emp_visited))
                                                    <a class="rounded-lg bg-rose-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-rose-700" href="{{ route('i_edit_visitors', $row->id) }}">
                                                        Affecter
                                                    </a>
                                                @elseif($row->status == 0)
                                                    <form action="{{ route('p_workflow_visitors', $row->id) }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="status" value="1">
                                                        <button class="rounded-lg bg-rose-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-rose-700" type="submit">Receptionner</button>
                                                    </form>
                                                @elseif($row->status == 1)
                                                    <form action="{{ route('p_workflow_visitors', $row->id) }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="status" value="2">
                                                        <button class="rounded-lg bg-emerald-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-emerald-700" type="submit">Terminer</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-5 py-12 text-center">
                    <p class="font-black text-slate-700">Aucune visite en attente</p>
                    <p class="mt-1 text-sm text-slate-500">Les nouvelles visites de l'antenne apparaitront ici.</p>
                </div>
            @endif
        </section>
    </div>
@endsection
