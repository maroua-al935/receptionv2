@extends('..President.layouts.master')

@section('body')
    @php
        $url = "visits;";
    @endphp

    <div class="space-y-6">
        <div class="visitx-hero">
            <div>
                <p class="visitx-eyebrow">Profils</p>
                <h1 class="page-title">Configuration rapide</h1>
                <p class="page-subtitle">Zone de test des profils dans le meme style que le reste de l'interface.</p>
            </div>
        </div>

        <section class="panel panel-pad max-w-xl">
            <label for="test" class="mb-3 block text-xs font-bold uppercase tracking-[0.18em] text-slate-500">Selection du profil</label>
            <select name="test" id="test" x-data="{ state: 'null' }" x-init="$watch('state', value => post_l(state))" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-violet-300 focus:bg-white focus:ring-4 focus:ring-violet-100">
                <option value="">Choisir</option>
                <option @click="state = $el.value" value="1">a</option>
                <option @click="state = $el.value" value="2">b</option>
                <option @click="state = $el.value" value="3">c</option>
                <option @click="state = $el.value" value="4">d</option>
            </select>
        </section>
    </div>

    <script>
        function post_l(state) {
            fetch('http://localhost/profiles', {
                method: 'POST',
                body: JSON.stringify({ state_out: state }),
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
            })
        }
    </script>
@endsection
