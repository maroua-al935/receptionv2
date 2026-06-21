<div class="rounded-xl bg-slate-50/70 p-4">
    <div class="flex flex-wrap items-center gap-3 mt-0">
        <span class="inline-flex items-center whitespace-nowrap rounded-xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-600">Service</span>
        <select name="service" class="h-10 min-w-[16rem] rounded-xl border border-slate-200 bg-white px-4 py-2 shadow-sm w-fit" wire:model="service_s">
            <option value="">Choisir un service</option>
            @foreach ($services as $service)
                <option value="{{ $service['id'] }}">{{ $service['group_name'] }}</option>
            @endforeach
        </select>
    </div>

    @if(!empty($names))
        <div class="flex flex-wrap items-center gap-3 mt-4">
            <span class="inline-flex items-center whitespace-nowrap rounded-xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-600">Nom et Prenom</span>
            <select name="hostname" placeholder="" class="h-10 min-w-[16rem] rounded-xl border border-slate-200 bg-white px-4 py-2 shadow-sm w-fit" wire:model="name_s">
                <option value="" selected>Choisir un employe</option>
                @foreach ($names as $name)
                    <option value="{{ $name['id'] }}">{{ $name['name'] }}</option>
                @endforeach
            </select>
        </div>
    @endif
</div>
