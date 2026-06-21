@extends('President.layouts.master')
@section('body')
<div class="space-y-6">
    <div class="visitx-hero">
        <div>
            <p class="visitx-eyebrow">Historique</p>
            <h1 class="page-title">Archive siege</h1>
            <p class="page-subtitle">Consultation centralisee des visites historiques du siege.</p>
        </div>
        <div class="visitx-hero-side">
            <div class="visitx-hero-chip">
                <span class="visitx-hero-dot"></span>
                Historique actif
            </div>
        </div>
    </div>
</div>
@livewire('historyget')

@endsection
