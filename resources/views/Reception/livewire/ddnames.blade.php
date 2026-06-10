        <div class="rounded-xl bg-slate-50/70 p-4">
            <div class="flex flex-wrap items-center gap-3 mt-0">
                <span class="px-4 py-2 ml-8 text-sm bg-gray-300 border border-2 rounded-l whitespace-nowrap">Service</span>
                <select name="service" class="h-10 min-w-[16rem] px-4 py-2 mr-2 bg-gray-100 border border-2 rounded-r w-fit" wire:model="service_s">
                    <option value="">Choisir un service</option>
                    @foreach ($services as $service)
                    <option value="{{ $service['id'] }}">{{ $service['group_name'] }}</option>
                    @endforeach
                </select>

            </div>
            @if(!empty($names))
            <div class="flex flex-wrap items-center gap-3 mt-4">
                <span class="px-4 py-2 ml-8 text-sm bg-gray-300 border border-2 rounded-l whitespace-nowrap">Nom et Prénom</span>
                <select name="hostname" placeholder="" class="h-10 min-w-[16rem] px-4 py-2 bg-gray-100 border border-2 rounded-r w-fit" wire:model="name_s">
                    <option value="" selected>Choisir un employé</option>
                    @foreach ($names as $name)
                    <option value="{{ $name['id'] }}">{{ $name['name'] }}</option>
                    @endforeach
                </select>
            </div>
            @endif
        </div>
