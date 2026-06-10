@extends('President.layouts.master')

@section('body')
    <div class="space-y-6">
        <div>
            <p class="text-sm font-medium uppercase tracking-wide text-sky-700">Presidence</p>
            <h1 class="page-title">Bonjour, {{ Auth::guard('web')->user()->lastname }}</h1>
            <p class="page-subtitle">Vue consolidee des visites du siege et des antennes.</p>
        </div>

        <section class="space-y-4">
            <div class="flex items-center gap-3">
                <h2 class="text-lg font-semibold uppercase tracking-wide text-slate-700">Siege</h2>
                <div class="h-px flex-1 bg-gradient-to-r from-slate-300 to-transparent"></div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <div class="stat-card"><div class="stat-icon bg-sky-600"><svg class="h-6 w-6" viewBox="0 0 24 24"><path fill="currentColor" d="M16 11c1.66 0 3-1.34 3-3s-1.34-3-3-3s-3 1.34-3 3s1.34 3 3 3M8 11c1.66 0 3-1.34 3-3S9.66 5 8 5S5 6.34 5 8s1.34 3 3 3m0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5C15 14.17 10.33 13 8 13"/></svg></div><div><p class="text-3xl font-semibold text-slate-900">{{ $today }}</p><p class="text-sm text-slate-500">Visiteurs aujourd'hui</p></div></div>
                <div class="stat-card"><div class="stat-icon bg-amber-500"><svg class="h-6 w-6" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2a10 10 0 1 0 10 10A10.011 10.011 0 0 0 12 2m1 10.414l3.293 3.293l-1.414 1.414L11 13.243V6h2z"/></svg></div><div><p class="text-3xl font-semibold text-slate-900">{{ $waiting }}</p><p class="text-sm text-slate-500">En attente</p></div></div>
                <div class="stat-card"><div class="stat-icon bg-emerald-600"><svg class="h-6 w-6" viewBox="0 0 24 24"><path fill="currentColor" d="m10 15.17l9.19-9.19l1.41 1.42L10 18L3.4 11.4l1.41-1.41z"/></svg></div><div><p class="text-3xl font-semibold text-slate-900">{{ $progress }}</p><p class="text-sm text-slate-500">En cours</p></div></div>
                <div class="stat-card"><div class="stat-icon bg-slate-700"><svg class="h-6 w-6" viewBox="0 0 24 24"><path fill="currentColor" d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2m-8 14l-5-5l1.41-1.41L11 14.17l5.59-5.59L18 10z"/></svg></div><div><p class="text-3xl font-semibold text-slate-900">{{ $finished }}</p><p class="text-sm text-slate-500">Terminees</p></div></div>
            </div>
        </section>

        <section class="space-y-4">
            <div class="flex items-center gap-3">
                <h2 class="text-lg font-semibold uppercase tracking-wide text-slate-700">Antennes</h2>
                <div class="h-px flex-1 bg-gradient-to-r from-slate-300 to-transparent"></div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <div class="stat-card">
                    <div class="stat-icon bg-blue-600"><svg class="h-6 w-6" viewBox="0 0 24 24"><path fill="currentColor" d="M15 11V5.83c0-.53-.21-1.04-.59-1.41L12.7 2.71a.996.996 0 0 0-1.41 0l-1.7 1.7C9.21 4.79 9 5.3 9 5.83V7H5c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-6c0-1.1-.9-2-2-2z"/></svg></div>
                    <div><p class="text-3xl font-semibold text-slate-900">{{ $today_ant_visited }}</p><p class="text-sm text-slate-500">Antennes visitees</p></div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-cyan-600"><svg class="h-6 w-6" viewBox="0 0 24 24"><path fill="currentColor" d="M15 11V5.83c0-.53-.21-1.04-.59-1.41L12.7 2.71a.996.996 0 0 0-1.41 0l-1.7 1.7C9.21 4.79 9 5.3 9 5.83V7H5c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-6c0-1.1-.9-2-2-2z"/></svg></div>
                    <div><p class="text-3xl font-semibold text-slate-900">{{ $today_ant }}</p><p class="text-sm text-slate-500">Visiteurs antennes</p></div>
                </div>
            </div>
        </section>

        <section class="panel panel-pad">
            <div class="mb-5">
                <h2 class="text-lg font-semibold text-slate-900">Liste des antennes</h2>
                <p class="text-sm text-slate-500">Suivi des antennes et des passages associes.</p>
            </div>
            @livewire('antennes-list')
        </section>
    </div>
@endsection
