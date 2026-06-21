<div class="space-y-3">
    <div class="flex w-full gap-3">
        <span class="inline-flex items-center whitespace-nowrap rounded-xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-600">Nom et Prenom</span>
        <input type="text" autocomplete="off" list="autocompleteOff" aria-autocomplete="none" name="exists_name" class="h-10 w-full rounded-xl border border-slate-200 bg-white px-4 py-2 shadow-sm" wire:model="query" wire:keydown.escape="resetdata"/>
    </div>

    <div class="modal fade fixed mt-0 ml-40 w-72 list-group z-10 pin-t pin-l rounded-2xl border border-slate-200 bg-white shadow-xl" wire:loading>
        <div class="p-4">
            <span class="block text-center text-sm font-semibold text-violet-700">Chargement...</span>
        </div>
    </div>

    @if(!empty($query) && !empty($results) && $results[0]['fullname']!=$query)
        <div class="fixed top-0 right-0 bottom-0 left-0" wire:click="resetdata"></div>
        @if (!empty($results))
            <div class="modal fade fixed mt-0 ml-40 w-72 list-group z-10 pin-t pin-l rounded-2xl border border-slate-200 bg-white shadow-xl">
                <div class="py-2">
                    @foreach ($results as $i => $result)
                        <button type="button" class="block w-full px-4 py-3 text-left text-sm font-medium text-slate-700 transition hover:bg-violet-50 hover:text-violet-700" wire:click="selected({{$result['id']}}, '{{$result['fullname']}}')">{{$result['fullname']}}</button>
                    @endforeach
                </div>
            </div>
        @else
            <div class="modal fade fixed mt-0 ml-40 w-72 list-group z-10 pin-t pin-l rounded-2xl border border-slate-200 bg-white shadow-xl">
                <div class="p-4">
                    <span class="block text-center text-sm font-semibold text-rose-600">Aucun resultat</span>
                </div>
            </div>
        @endif
    @endif

    @if(!empty($data))
        <input hidden name="user" wire:model="data">
    @endif
</div>
