@extends('Reception.layouts.master')

@section('body')
@php $profile = (int) Auth::guard('web')->user()->profile; @endphp
<form action="{{ route('p_edit_visitors', preg_replace('/guests\/edit\//', '', Request::path())) }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="w-full max-w-6xl">
        <div class="form-card">
            <div class="border-b border-slate-100 pb-5">
                <span class="page-title block">Modifier la visite</span>
                <p class="page-subtitle">Orientation, affectation service et cloture apres restitution du badge.</p>
            </div>

            @if(!in_array($profile, [3, 4, 8, 9], true))
            <div class="mt-5 grid gap-4 lg:grid-cols-2">
                <label class="block">
                    <span class="mb-1 block text-sm font-semibold text-slate-700">Nom</span>
                    <input type="text" name="fname" class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2" value="{{ $data[0]->firstname }}" />
                </label>

                <label class="block">
                    <span class="mb-1 block text-sm font-semibold text-slate-700">Prenom</span>
                    <input type="text" name="lname" class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2" value="{{ $data[0]->lastname }}" />
                </label>
            </div>
            @else
            <div class="mt-5 grid gap-4 lg:grid-cols-2">
                <div class="rounded-lg bg-slate-50 px-4 py-3">
                    <span class="text-sm font-semibold text-slate-700">Visiteur</span>
                    <p class="mt-1 text-slate-900">{{ $data[0]->firstname }} {{ $data[0]->lastname }}</p>
                </div>
                <div class="rounded-lg bg-slate-50 px-4 py-3">
                    <span class="text-sm font-semibold text-slate-700">Badge</span>
                    <p class="mt-1 text-slate-900">{{ $data[0]->badge_n ?: '-' }}</p>
                </div>
            </div>
            @endif

            <div class="mt-5">
                @if($profile === 8)
                    <label class="block rounded-xl bg-slate-50/70 p-4">
                        <span class="mb-1 block text-sm font-semibold text-slate-700">Service</span>
                        <select name="service" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2">
                            <option value="">Choisir un service</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" @selected($data[0]->service_id == $service->id)>{{ $service->group_name }}</option>
                            @endforeach
                        </select>
                    </label>
                @elseif(in_array($profile, [3, 4], true))
                    <div class="rounded-xl bg-slate-50/70 p-4">
                        <div class="mb-4">
                            <span class="mb-1 block text-sm font-semibold text-slate-700">Service</span>
                            <p class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-slate-900">{{ $data[0]->service_name }}</p>
                        </div>
                        <label class="block">
                            <span class="mb-1 block text-sm font-semibold text-slate-700">Personne visitee</span>
                            <select name="hostname" class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2">
                                <option value="">Choisir un employe</option>
                                @foreach($serviceUsers as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                @else
                    @livewire('ddnames', ['service_s' => $data[0]->service_id, 'name_s' => $data[0]->emp_visited])
                @endif
            </div>

            @if(!in_array($profile, [3, 4, 5, 8], true))
            <div class="mt-5 grid gap-4 lg:grid-cols-2">
                <label class="block">
                    <span class="mb-1 block text-sm font-semibold text-slate-700">Numero badge</span>
                    <input type="text" name="badge_n" placeholder="Badge remis" class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2" value="{{ $data[0]->badge_n }}" />
                </label>

                <label class="block">
                    <span class="mb-1 block text-sm font-semibold text-slate-700">Categorie</span>
                    <select name="category" class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2">
                        @foreach($cats as $cat)
                            <option value="{{ $cat->id }}" @selected($data[0]->category == $cat->id)>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="block">
                    <span class="mb-1 block text-sm font-semibold text-slate-700">Societe</span>
                    <input type="text" name="org" class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2" value="{{ $data[0]->org_name }}">
                </label>

                <label class="block">
                    <span class="mb-1 block text-sm font-semibold text-slate-700">Piece d'identite</span>
                    <select name="alt_type" class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2">
                        @foreach ($id_types as $type)
                            <option value="{{ $type->id }}" @selected($type->id == $data[0]->id_type)>{{ $type->name }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="block">
                    <span class="mb-1 block text-sm font-semibold text-slate-700">Statut</span>
                    <select id="state" name="status" class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2">
                        <option value="0" @selected($data[0]->status == 0)>En attente</option>
                        <option value="1" @selected($data[0]->status == 1)>En cours</option>
                        <option value="3" @selected($data[0]->status == 3)>Visite terminee - badge a recuperer</option>
                        <option value="2" @selected($data[0]->status == 2)>Cloturee</option>
                    </select>
                </label>

                <label id="exittime" class="hidden">
                    <span class="mb-1 block text-sm font-semibold text-slate-700">Date de sortie</span>
                    <input type="datetime-local" id="exittime_val" name="exitdate" class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2">
                </label>
            </div>
            @endif

            <div class="mt-6 flex justify-end">
                <input type="submit" class="primary-action w-28 button" value="{{ $profile === 8 ? 'Orienter' : (in_array($profile, [3, 4], true) ? 'Affecter' : 'Modifier') }}">
            </div>
        </div>
    </div>
</form>

<script type="module">
    $("#state").on('change click', function() {
        var date = new Date();
        var dateStr =
            date.getFullYear() +
            "-" +
            ("00" + (date.getMonth() + 1)).slice(-2) +
            "-" +
            ("00" + date.getDate()).slice(-2) +
            "T" +
            ("00" + date.getHours()).slice(-2) + ":" +
            ("00" + date.getMinutes()).slice(-2);
        if ($("#state").find(":selected").val() == "2") {
            $("#exittime_val").val(dateStr);
            $("#exittime").removeClass('hidden');
        } else {
            $("#exittime").addClass('hidden');
        }
    });
</script>
@endsection
