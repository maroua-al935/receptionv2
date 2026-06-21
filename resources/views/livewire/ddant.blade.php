<div>
    <div class="flex mt-4 w-full gap-3">
        <span class="inline-flex items-center whitespace-nowrap rounded-xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-600">Nom et Prenom</span>
        <select name="hostname" placeholder="" class="h-10 w-full rounded-xl border border-slate-200 bg-white px-4 py-2 shadow-sm">
            <option value="" selected>Choisir un employe</option>
            @foreach ($users as $user)
                <option value="{{ $user['ant_user'] }}">{{ $user['name'] }}</option>
            @endforeach
        </select>
    </div>
</div>
