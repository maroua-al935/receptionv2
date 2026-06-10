@extends('layouts.master')
@section('body')
<div class="container w-full">
    <div class="w-3/4 bg-white px-4 py-4 rounded-lg">
        <div class="flex">
            <svg class="w-14 text-black mr-4" viewBox="0 0 24 24"><path fill="currentColor" d="M12 12q-1.65 0-2.825-1.175Q8 9.65 8 8q0-1.65 1.175-2.825Q10.35 4 12 4q1.65 0 2.825 1.175Q16 6.35 16 8q0 1.65-1.175 2.825Q13.65 12 12 12Zm-8 8v-2.8q0-.85.438-1.563q.437-.712 1.162-1.087q1.55-.775 3.15-1.163Q10.35 13 12 13t3.25.387q1.6.388 3.15 1.163q.725.375 1.162 1.087Q20 16.35 20 17.2V20Z"/></svg>
            <span class="text-2xl font-semibold mt-2">à propos du visiteur</span>
        </div>
        <div class="block float-right mr-8" style="width: 12rem;height:8rem;">
        @if($data[0]->filepath != "")
                <img class="rounded-lg select-none cursor-pointer" data-fancybox src="{{ asset($data[0]->filepath)}}" alt="not available">
        @endif
                <span class="-mt-4 ml-4 text-base font-semibold">{{ $data[0]->id_type }}</span>
                <br>
                 <span class="ml-4 text-base font-semibold">N:</span>
                <span class="text-base">{{ $data[0]->cin }}</span>

        </div>
        <div class="ml-8 mt-8 flex w-2/4">
            <span class="text-base font-semibold mr-4">nom et prénom:</span>
            <span class="text-base">{{ $data[0]->firstname }}&nbsp;{{ $data[0]->lastname }}</span>
        </div>
        <div class="ml-8 mt-4 flex">
        @isset($data[0]->organisation)
            <div class="mr-12">
                <span class="text-base font-semibold mr-4">Société:</span>
                <span class="text-base">{{ $data[0]->organisation }}</span>
            </div>
        @endisset
        @isset($data[0]->position)
            <div>
                <span class="text-base font-semibold mr-4">Poste:</span>
                <span class="text-base">{{ $data[0]->position }}</span>
            </div>
        @endisset

        </div>
        <div class="flex mt-8">
            <svg class="w-14 text-black mr-4" viewBox="0 0 16 16"><path fill="currentColor" d="M8 5a2 2 0 1 0 0 4a2 2 0 0 0 0-4Zm-2.305 5c-.331 0-.69.238-.72.657c-.023.315.005.922.46 1.453c.461.54 1.269.89 2.565.89s2.104-.35 2.566-.89c.454-.531.482-1.138.46-1.453c-.03-.42-.39-.657-.721-.657h-4.61Zm5.22-8h.585A1.5 1.5 0 0 1 13 3.5v10a1.5 1.5 0 0 1-1.5 1.5h-7A1.5 1.5 0 0 1 3 13.5v-10A1.5 1.5 0 0 1 4.5 2h.585A1.5 1.5 0 0 1 6.5 1h3a1.5 1.5 0 0 1 1.415 1Zm-5.83 1H4.5a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5v-10a.5.5 0 0 0-.5-.5h-.585A1.5 1.5 0 0 1 9.5 4h-3a1.5 1.5 0 0 1-1.415-1ZM6 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5Z"/></svg>
            <span class="text-2xl font-semibold mt-2">à propos de la visite</span>
        </div>
         <div class="ml-8 mt-8 flex w-2/4">
            @switch($data[0]->status)
                @case(0)
                    <span class="text-base font-semibold mr-4">Visite en attente</span>
                @break
                @case(1)
                    <span class="text-base font-semibold mr-4">Visite en cours</span>
                @break
                @case(2)
                    <span class="text-base font-semibold mr-4">Visite terminée</span>
                @break
            @endswitch
        </div>
        @isset($data[0]->subject)
        <div class="ml-8 mt-4 flex w-2/4">
            <span class="text-base font-semibold mr-4">Objet:</span>
            <span class="text-base">{{ $data[0]->subject }}</span>
        </div>
        @endisset

       
        <div class="ml-8 mt-4 flex">
        @isset($data[0]->service)
            <div class="mr-12">
                <span class="text-base font-semibold mr-4">Service visité:</span>
                <span class="text-base">{{ $data[0]->service }}</span>
            </div>
        @endisset
        @isset($data[0]->usrname)
            <div>
                <span class="text-base font-semibold mr-4">Personne visitée:</span>
                <span class="text-base">{{ $data[0]->usrname }}</span>
            </div>
        @endisset

        </div>

        
        <div class="ml-8 mt-4 flex">
            <div class="mr-12">
                <span class="text-base font-semibold mr-4">Date d'entrée:</span>
                <span class="text-base">{{ to_normal_date($data[0]->entry_date) }}</span>
            </div>
            <div>
                <span class="text-base font-semibold mr-4">Date de sortie:</span>
                @if ($data[0]->exit_date != NULL)
                <span class="text-base">{{ to_normal_date($data[0]->exit_date) }}</span>
                @else
                <span class="text-base">N/d</span>
                @endif
            </div>

        </div>
        <div class="mb-12">
            <a href="{{ route('home') }}"><input class="w-24 bg-red-600 hover:bg-red-700 rounded-lg text-white font-semibold float-right px-2 py-2" type="button" value="Retour"></a>
        </div>
        </div>
    </div>
</div>
@endsection