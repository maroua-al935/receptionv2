@extends('President.layouts.master')

@section('body')
    <div class="space-y-6">
        <div class="visitx-hero">
            <div>
                <p class="visitx-eyebrow">Président</p>
                <h1 class="page-title">Visiteurs antennes</h1>
                <p class="page-subtitle">Vue du jour des visiteurs traites dans le réseau antennes.</p>
            </div>
           
        </div>

        @livewire('antennes-list')
    </div>
@endsection
