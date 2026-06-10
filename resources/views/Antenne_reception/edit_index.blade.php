@extends('Antenne_reception.layouts.master')
@section('body')
<form action="{{ route('p_edit_visitors',preg_replace('/guests\/edit\//','',Request::path())) }}" method="post" enctype="multipart/form-data" class="visit-form-modern antenne-form">
    @csrf
    <div class="flex ">
        <div class="grow ">
<div class="w-full max-w-7xl py-2">
    <div class="form-card">
        <div class="flex flex-col gap-2 border-b border-slate-100 pb-5">
        <p class="text-[10px] font-black uppercase tracking-widest text-rose-600">Modification antenne</p>
        <span class="page-title block">Modifier le visiteur</span>
        <p class="page-subtitle">Mise a jour du statut et des informations de passage local.</p>
        </div>
        <div class="flex mt-4">
            <span class="float-left px-4 py-2 ml-8 text-sm bg-gray-300 border border-2 rounded-l whitespace-nowrap">Nom</span>
            <input type="text" name="fname" placeholder="" class="w-1/4 h-10 px-4 py-2 bg-gray-100 border border-2 rounded-r" value="{{ $data[0]->firstname }}"/>
            <span class="px-4 py-2 ml-8 text-sm bg-gray-300 border border-2 rounded-l float-middle whitespace-nowrap">Prenom</span>
            <input type="text" name="lname" placeholder="" class="w-1/4 h-10 px-4 py-2 bg-gray-100 border border-2 rounded-r" value="{{ $data[0]->lastname }}"/>


        </div>
        <div class="flex mt-4">
            <span class="float-left px-4 py-2 ml-8 text-sm bg-gray-300 border border-2 rounded-l whitespace-nowrap">Catégorie</span>
            <select name="category" class="float-right w-1/4 h-10 px-4 py-2 mr-2 bg-gray-100 border border-2 rounded-r">
                @foreach($cats as $cat)
                @if($data[0]->category == $cat->id)
                <option value="{{ $cat->id }}" selected>{{ $cat->name }}</option>
                @else
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endif
                @endforeach
            </select>

            <span class="float-left px-4 py-2 ml-8 text-sm bg-gray-300 border border-2 rounded-l whitespace-nowrap">Société</span>
            <input type="text" name="org" class="w-1/4 h-10 px-4 py-2 bg-gray-100 border border-2 rounded-r" value="{{ $data[0]->org_name }}">

        </div>
        <div class="flex mt-4">
            <span class="float-left px-4 py-2 ml-8 text-sm bg-gray-300 border border-2 rounded-l whitespace-nowrap">Pièce d'identité</span>
        <select name="alt_type" class="float-right w-1/4 h-10 px-4 py-2 mr-2 bg-gray-100 border border-2 rounded-r">
            @foreach ($id_types as $type)
                @if ($type->id == $data[0]->id_type)
                    <option value="{{$type->id}}" selected>{{$type->name}}</option>
                @else
                    <option value="{{$type->id}}">{{$type->name}}</option>
                @endif
            @endforeach
        </select>
        </div>
        <div class="flex mt-4">
            <span class="float-left px-4 py-2 ml-8 text-sm bg-gray-300 border border-2 rounded-l whitespace-nowrap">Status</span>
            <select id="state" name="status" class="float-right w-1/4 h-10 px-4 py-2 mr-2 bg-gray-100 border border-2 rounded-r">
                @switch($data[0]->status)
                @case(0)
                <option value="0" selected>En attente</option>
                <option value="1" >En cours</option>
                <option value="2" >Terminée</option>
                @break
                @case(1)
                <option value="0" >En attente</option>
                <option value="1" selected>En cours</option>
                <option value="2" >Terminée</option>
                @break
                @case(2)
                <option value="0" >En attente</option>
                <option value="1" >En cours</option>
                <option value="2" selected>Terminée</option>
                @break
                @endswitch
            </select>
            <div id="exittime" class="hidden">
            <span class="float-left px-4 py-2 ml-8 text-sm bg-gray-300 border border-2 h-10 rounded-l whitespace-nowrap">Date de sortie</span>
            <input type="datetime-local" id="exittime_val" name="exitdate" placeholder="" class="w-fit h-10 px-4 py-2 bg-gray-100 border border-2 rounded-r">
            </div>

        </div>
        @if((int) Auth::guard('web')->user()->profile === 7)
            <div class="flex mt-4">
                <span class="float-left px-4 py-2 ml-8 text-sm bg-gray-300 border border-2 rounded-l whitespace-nowrap">Rediriger vers</span>
                <select name="hostname" class="float-right w-1/4 h-10 px-4 py-2 mr-2 bg-gray-100 border border-2 rounded-r" required>
                    <option value="">Choisir une personne</option>
                    @foreach(($antenneUsers ?? collect()) as $antenneUser)
                        <option value="{{ $antenneUser->id }}">{{ $antenneUser->name }}</option>
                    @endforeach
                </select>
            </div>
        @endif
        <div>



<div class="mb-12 pt-4">
        <div class=" mb-4">
            <input type="submit" class="mr-4 ml-4 float-right w-28 button" Value="Modifier">
</form>
        </div>
</div>
    </div>

</div>
</div>
</div>
</div>

<script type="module">
$("#state").click( function() {
var date = new Date();
var dateStr =
date.getFullYear()
 + "-" +
  ("00" + (date.getMonth() + 1)).slice(-2) 
   + "-" +
("00" + date.getDate()).slice(-2)
   + "T" +
  ("00" + date.getHours()).slice(-2) + ":" +
  ("00" + date.getMinutes()).slice(-2);
if ($("#state").find(":selected").val()=="2")
{
    $("#exittime_val").val(dateStr);
    $("#exittime").removeClass('hidden');
}else{
    $("#exittime").addClass('hidden');
}
});

</script>
@endsection
