@extends('Antenne_reception.layouts.master')
@section('body')
<div class="space-y-6">
    <div>
        <p class="text-[10px] font-black uppercase tracking-widest text-rose-600">Archive antenne</p>
        <h1 class="page-title">Historique</h1>
        <p class="page-subtitle">Registre des passages finalises ou anciens pour {{ $loc ?? 'cette antenne' }}.</p>
    </div>
    <section class="panel antenne-panel panel-pad">
        @livewire('anthistoryget')
    </section>
</div>

@endsection
