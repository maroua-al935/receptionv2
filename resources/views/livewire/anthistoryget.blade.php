<div>
    <div class="mt-8 flex">
        <select name="search_cat" id="search_cat" wire:model="cat" wire:click="resetdata">
            <option value="1">Nom & Prénom</option>
            <option value="2">Société</option>
            <option value="4">Permis minier</option>
            <option value="3">Date</option>
        </select>
        <div name="search_box" id="search_box" class="@if($searchhidden) hidden @endif">
        <input type="text" name="search" id="search" placeholder="Recherche..." wire:model="query">
        </div>
        <div name="date_input" id="date_input" class="@if($datehidden) hidden @endif">
            <input type="date" name="date" id="date" wire:model="date">
        </div>
    </div>

        <div class="flex flex-col mt-6">
            <div class="py-2 -my-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                            @if(!is_string($results) && !empty($query) && !$results->isEmpty())
                <div class="inline-block min-w-full overflow-hidden align-middle border-b border-gray-200 shadow sm:rounded-lg">

                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-100 border-b border-gray-200 leading-4">Visiteur</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-100 border-b border-gray-200 leading-4">Hôte</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-100 border-b border-gray-200 leading-4">date entrée</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-100 border-b border-gray-200 leading-4">Status</th>
                                <th class="px-6 py-3 bg-gray-100 border-b border-gray-200"></th>
                            </tr>
                        </thead>

                        <tbody class="bg-white">
                                        @foreach($results as $row)

                                <tr class="hover:bg-gray-200">

                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-10 h-10">
<svg  class="w-10 h-10 text-indigo-600"  viewBox="0 0 256 256"><path fill="currentColor" d="M128 24a104 104 0 1 0 104 104A104.2 104.2 0 0 0 128 24Zm0 192a88 88 0 1 1 88-88a88.1 88.1 0 0 1-88 88ZM80 108a12 12 0 1 1 12 12a12 12 0 0 1-12-12Zm72 0a12 12 0 1 1 12 12a12 12 0 0 1-12-12Zm24.5 48a56 56 0 0 1-97 0a8 8 0 1 1 13.8-8a40.1 40.1 0 0 0 69.4 0a8 8 0 0 1 13.8 8Z"/></svg>
                                        </div>

                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 leading-5">{{ $row->firstname }} {{ $row->lastname }}</div>
                                            <div class="text-sm text-gray-500 leading-5">{{ $row->org_name }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    <div class="text-sm text-gray-900 leading-5">{{ $row->emp_visited }}</div>
                                    <div class="text-sm text-gray-500 leading-5">{{ $row->service_name }}</div>
                                </td>



                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-no-wrap border-b border-gray-200 leading-5">{{ to_normal_date($row->entry_date) }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    @switch($row->status)
                                    @case(0)
                                    <span class="inline-flex px-2 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full leading-5 w-fit">En attente</span>
                                    @break
                                    @case(1)
                                    <span class="inline-flex px-2 text-xs font-semibold text-green-800 bg-green-100 rounded-full leading-5">En cours</span>
                                    @break
                                    @case(2)
                                    <span class="inline-flex px-2 text-xs font-semibold bg-gray-300 rounded-full text-black-800 leading-5">Terminée</span>
                                    @break
                                    @endswitch
                                </td>

                                <td class="px-6 py-4 text-sm font-medium text-right whitespace-no-wrap border-b border-gray-200 leading-5">
                                <div class="flex">
                            <a class="mr-2 text-indigo-600 hover:text-indigo-900" href="{{ route('i_ant_info',$row->id) }}">
                                <svg class="w-4 h-4" viewBox="0 0 24 24"><path fill="currentColor" d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5s5 2.24 5 5s-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3s3-1.34 3-3s-1.34-3-3-3z"/></svg>
                            </a>
                                    <a href="{{ route('i_edit_visitors',$row->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24"><path fill="currentColor" d="m19.3 8.925l-4.25-4.2l1.4-1.4q.575-.575 1.413-.575q.837 0 1.412.575l1.4 1.4q.575.575.6 1.388q.025.812-.55 1.387ZM17.85 10.4L7.25 21H3v-4.25l10.6-10.6Z"/></svg>
                                    </a>

</div>
                                </td>
                            </tr>
                            @endforeach
                                                  </tbody>
                    </table>

                </div>
                            @else
                                <div class="flex justify-center mt-12">
                                <div class="flex flex-wrap rounded-lg w-fit">
                                @if ($noresults && !empty($query))
                                    
                                <span class="font-bold text-red-600">Aucun resultat... 😔</span>
                                @endif

                                </div>
                                </div>
                            @endif
                            @if(!empty($date) && !is_string($results) && !$results->isEmpty())
                <div class="inline-block min-w-full overflow-hidden align-middle border-b border-gray-200 shadow sm:rounded-lg">

                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-100 border-b border-gray-200 leading-4">Visiteur</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-100 border-b border-gray-200 leading-4">Hôte</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-100 border-b border-gray-200 leading-4">date entrée</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-100 border-b border-gray-200 leading-4">Status</th>
                                <th class="px-6 py-3 bg-gray-100 border-b border-gray-200"></th>
                            </tr>
                        </thead>

                        <tbody class="bg-white">
                                        @foreach($results as $row)

                                <tr class="hover:bg-gray-200">

                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-10 h-10">
<svg  class="w-10 h-10 text-indigo-600"  viewBox="0 0 256 256"><path fill="currentColor" d="M128 24a104 104 0 1 0 104 104A104.2 104.2 0 0 0 128 24Zm0 192a88 88 0 1 1 88-88a88.1 88.1 0 0 1-88 88ZM80 108a12 12 0 1 1 12 12a12 12 0 0 1-12-12Zm72 0a12 12 0 1 1 12 12a12 12 0 0 1-12-12Zm24.5 48a56 56 0 0 1-97 0a8 8 0 1 1 13.8-8a40.1 40.1 0 0 0 69.4 0a8 8 0 0 1 13.8 8Z"/></svg>
                                        </div>

                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 leading-5">{{ $row->firstname }} {{ $row->lastname }}</div>
                                            <div class="text-sm text-gray-500 leading-5">{{ $row->org_name }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    <div class="text-sm text-gray-900 leading-5">{{ $row->emp_visited }}</div>
                                    <div class="text-sm text-gray-500 leading-5">{{ $row->ant_name }}</div>
                                </td>


                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-no-wrap border-b border-gray-200 leading-5">{{ to_normal_date($row->entry_date) }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    @switch($row->status)
                                    @case(0)
                                    <span class="inline-flex px-2 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full leading-5 w-fit">En attente</span>
                                    @break
                                    @case(1)
                                    <span class="inline-flex px-2 text-xs font-semibold text-green-800 bg-green-100 rounded-full leading-5">En cours</span>
                                    @break
                                    @case(2)
                                    <span class="inline-flex px-2 text-xs font-semibold bg-gray-300 rounded-full text-black-800 leading-5">Terminée</span>
                                    @break
                                    @endswitch
                                </td>

                                <td class="px-6 py-4 text-sm font-medium text-right whitespace-no-wrap border-b border-gray-200 leading-5">
                                <div class="flex">
                            <a class="mr-2 text-indigo-600 hover:text-indigo-900" href="{{ route('i_ant_info',$row->id) }}">
                                <svg class="w-4 h-4" viewBox="0 0 24 24"><path fill="currentColor" d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5s5 2.24 5 5s-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3s3-1.34 3-3s-1.34-3-3-3z"/></svg>
                            </a>
                                    <a href="{{ route('i_edit_visitors',$row->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24"><path fill="currentColor" d="m19.3 8.925l-4.25-4.2l1.4-1.4q.575-.575 1.413-.575q.837 0 1.412.575l1.4 1.4q.575.575.6 1.388q.025.812-.55 1.387ZM17.85 10.4L7.25 21H3v-4.25l10.6-10.6Z"/></svg>
                                    </a>

</div>
                                </td>
                            </tr>
                            @endforeach
                                                  </tbody>
                    </table>

                </div>
                            @else
                                <div class="flex justify-center mt-12">
                                <div class="flex flex-wrap rounded-lg w-fit">
                                @if ($noresults && !empty($date))
                                    
                                <span class="font-bold text-red-600">Aucun resultat... 😔</span>
                                @endif

                                </div>
                                </div>
                            @endif

            </div>
        </div>
    </div>


        </div>
    </div>
    </div>
