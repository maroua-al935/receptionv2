@extends('layouts.master')

@section('body')
    <div class="mx-auto max-w-5xl space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-medium uppercase tracking-wide text-sky-700">Fiche visite</p>
                <h1 class="page-title">{{ $data[0]->firstname }} {{ $data[0]->lastname }}</h1>
                <p class="page-subtitle">Details du visiteur et informations de passage.</p>
            </div>
            <a href="{{ route('i_visitors') }}" class="danger-action inline-flex w-fit items-center gap-2">
                <svg class="h-5 w-5" viewBox="0 0 24 24"><path fill="currentColor" d="m7.825 13l5.6 5.6L12 20L4 12l8-8l1.425 1.4l-5.6 5.6H20v2z"/></svg>
                Retour
            </a>
        </div>

        <div class="grid gap-6 lg:grid-cols-[1fr_18rem]">
            <section class="panel panel-pad">
                <div class="mb-5 flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-sky-50 text-sky-700">
                        <svg class="h-6 w-6" viewBox="0 0 24 24"><path fill="currentColor" d="M12 12q-1.65 0-2.825-1.175T8 8t1.175-2.825T12 4t2.825 1.175T16 8t-1.175 2.825T12 12m-8 8v-2.8q0-.85.438-1.562T5.6 14.55q1.55-.775 3.15-1.162T12 13t3.25.388t3.15 1.162q.725.375 1.163 1.088T20 17.2V20z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">A propos du visiteur</h2>
                        <p class="text-sm text-slate-500">Identite et organisation.</p>
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="rounded-lg bg-slate-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Nom et prenom</p>
                        <p class="mt-1 font-semibold text-slate-900">{{ $data[0]->firstname }} {{ $data[0]->lastname }}</p>
                    </div>
                    @isset($data[0]->organisation)
                        <div class="rounded-lg bg-slate-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Societe</p>
                            <p class="mt-1 font-semibold text-slate-900">{{ $data[0]->organisation }}</p>
                        </div>
                    @endisset
                    @isset($data[0]->position)
                        <div class="rounded-lg bg-slate-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Poste</p>
                            <p class="mt-1 font-semibold text-slate-900">{{ $data[0]->position }}</p>
                        </div>
                    @endisset
                    <div class="rounded-lg bg-slate-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Piece d'identite</p>
                        <p class="mt-1 font-semibold text-slate-900">{{ $data[0]->id_type }} - N: {{ $data[0]->cin }}</p>
                    </div>
                </div>
            </section>

            <aside class="panel panel-pad">
                <p class="mb-3 text-sm font-semibold text-slate-900">Document</p>
                @if($data[0]->filepath != "")
                    <img class="aspect-[4/3] w-full rounded-lg object-cover shadow-sm" data-fancybox src="{{ asset($data[0]->filepath) }}" alt="piece identite">
                @else
                    <div class="flex aspect-[4/3] items-center justify-center rounded-lg bg-slate-100 text-sm font-medium text-slate-500">Aucune image</div>
                @endif
            </aside>
        </div>

        <section class="panel panel-pad">
            <div class="mb-5 flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-emerald-50 text-emerald-700">
                    <svg class="h-6 w-6" viewBox="0 0 24 24"><path fill="currentColor" d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19a2 2 0 0 0 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2m0 16H5V8h14z"/></svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-slate-900">A propos de la visite</h2>
                    <p class="text-sm text-slate-500">Etat, destination et horaires.</p>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <div class="rounded-lg bg-slate-50 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Status</p>
                    <div class="mt-2">
                        @switch($data[0]->status)
                            @case(0)<span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">Visite en attente</span>@break
                            @case(1)<span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800">Visite en cours</span>@break
                            @case(2)<span class="rounded-full bg-slate-200 px-3 py-1 text-xs font-semibold text-slate-700">Visite terminee</span>@break
                        @endswitch
                    </div>
                </div>
                @isset($data[0]->subject)
                    <div class="rounded-lg bg-slate-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Objet</p>
                        <p class="mt-1 font-semibold text-slate-900">{{ $data[0]->subject }}</p>
                    </div>
                @endisset
                @isset($data[0]->service)
                    <div class="rounded-lg bg-slate-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Service visite</p>
                        <p class="mt-1 font-semibold text-slate-900">{{ $data[0]->service }}</p>
                    </div>
                @endisset
                @isset($data[0]->usrname)
                    <div class="rounded-lg bg-slate-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Personne visitee</p>
                        <p class="mt-1 font-semibold text-slate-900">{{ $data[0]->usrname }}</p>
                    </div>
                @endisset
                <div class="rounded-lg bg-slate-50 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Date d'entree</p>
                    <p class="mt-1 font-semibold text-slate-900">{{ to_normal_date($data[0]->entry_date) }}</p>
                </div>
                <div class="rounded-lg bg-slate-50 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Date de sortie</p>
                    <p class="mt-1 font-semibold text-slate-900">{{ to_normal_date($data[0]->exit_date) }}</p>
                </div>
            </div>
        </section>
    </div>
@endsection
