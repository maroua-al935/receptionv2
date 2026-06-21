@extends('Service.layouts.master')

@section('body')
    <div class="space-y-6">
        <div class="visitx-hero">
            <div>
                <p class="visitx-eyebrow">Service</p>
                <h1 class="page-title">Historique</h1>
                <p class="page-subtitle">Consultation des visites archivees et des mouvements precedents du service.</p>
            </div>
            <div class="visitx-hero-side">
                <div class="visitx-hero-chip">
                    <span class="visitx-hero-dot"></span>
                    Historique service
                </div>
            </div>
        </div>

        @livewire('historyget')
    </div>
@endsection
