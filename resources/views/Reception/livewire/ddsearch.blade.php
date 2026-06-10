        <div>
        <div class="flex mt-4 w-2/4">
            <span  class="px-4 py-2 ml-8 text-sm bg-gray-300 border border-2 rounded-l whitespace-nowrap">Nom et Prénom</span>
            <input type="text" autocomplete="off" list="autocompleteOff" aria-autocomplete="none" name="exists_name" class="w-full h-10 px-4 py-2 bg-gray-100 border border-2 rounded-r" wire:model="query" wire:keydown.escape="resetdata"/>
        </div>

            <div class="modal fade fixed overflow-y-auto mt-0 ml-40 w-48 list-group z-10 pin-t pin-l" wire:loading>
                <div class=" bg-white border-r-2 border-l-2 border-b-2 rounded-lg shadow-lg">
                    <span class="float-center text-blue-600 leading-10 block">Chargement...</span>
                </div>
            </div>

        @if(!empty($query) && !empty($results) && $results[0]['fullname']!=$query)
        <div class="fixed top-0 right-0 bottom-0 left-0" wire:click="resetdata"></div>
        @if (!empty($results))
            <div class="modal fade fixed overflow-y-auto mt-0 ml-40 w-48 list-group z-10 pin-t pin-l">
                <div class=" bg-white border-r-2 border-l-2 border-b-2 rounded-lg shadow-lg">
                @foreach ($results as $i => $result)
                    <span class="float-center hover:bg-gray-500 leading-10 block" wire:click="selected({{$result['id']}}, '{{$result['fullname']}}')">{{$result['fullname']}}</span>
                @endforeach
                </div>
            </div>
        @else
        <div class="modal fade fixed overflow-y-auto mt-0 ml-40 w-48 rounded-t-none shadow-sm shadow-slate-300 list-group z-10 pin-t pin-l">
        <div class=" bg-gray-300">
        <span class="text-red-600 text-lg">Aucun résultat</span>
        </div>
        </div>
        @endif
        @endif
        @if(!empty($data))
        <input hidden name="user" wire:model="data">
        @endif

</div>
