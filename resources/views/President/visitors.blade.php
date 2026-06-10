    @extends('President.layouts.master')

@section('body')
    <div class="">
    <h3 class="text-3xl font-medium text-gray-700">Visiteurs siège</h3>
</div>
    <!--
    <input  wire:click.prevent="doShow()" type="submit" class="w-24 h-12 bg-green-100 rounded-full button" value="Ajouter">
    </livewire:addvisitor>

    <div class="mt-8">
        <h4 class="text-gray-600">Table with pagination</h4>
        
        <div class="mt-6">
            <h2 class="text-xl font-semibold leading-tight text-gray-700">Users</h2>

            <div class="flex flex-col mt-3 sm:flex-row">
                <div class="flex">
                    <div class="relative">
                        <select class="block w-full h-full px-4 py-2 pr-8 leading-tight text-gray-700 bg-white border border-gray-400 rounded-l appearance-none focus:outline-none focus:bg-white focus:border-gray-500">
                            <option>5</option>
                            <option>10</option>
                            <option>20</option>
                        </select>

                        <div class="absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 pointer-events-none">
                            <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                            </svg>
                        </div>
                    </div>

                    <div class="relative">
                        <select class="block w-full h-full px-4 py-2 pr-8 leading-tight text-gray-700 bg-white border-t border-b border-r border-gray-400 rounded-r appearance-none sm:rounded-r-none sm:border-r-0 focus:outline-none focus:border-l focus:border-r focus:bg-white focus:border-gray-500">
                            <option>All</option>
                            <option>Active</option>
                            <option>Inactive</option>
                        </select>

                        <div class="absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 pointer-events-none">
                            <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="relative block mt-2 sm:mt-0">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                        <svg viewBox="0 0 24 24" class="w-4 h-4 text-gray-500 fill-current">
                            <path d="M10 4a6 6 0 100 12 6 6 0 000-12zm-8 6a8 8 0 1114.32 4.906l5.387 5.387a1 1 0 01-1.414 1.414l-5.387-5.387A8 8 0 012 10z"></path>
                        </svg>
                    </span>

                    <input placeholder="Search" class="block w-full py-2 pl-8 pr-6 text-sm text-gray-700 placeholder-gray-400 bg-white border border-b border-gray-400 rounded-l rounded-r appearance-none sm:rounded-l-none focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none" />
                </div>
            </div>

            <div class="px-4 py-4 -mx-4 overflow-x-auto sm:-mx-8 sm:px-8">
                <div class="inline-block min-w-full overflow-hidden rounded-lg shadow">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b-2 border-gray-200">User</th>
                                <th class="px-5 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b-2 border-gray-200">Rol</th>
                                <th class="px-5 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b-2 border-gray-200">Created at</th>
                                <th class="px-5 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b-2 border-gray-200">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-10 h-10">
                                            <img class="w-full h-full rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.2&w=160&h=160&q=80" alt="" />
                                        </div>

                                        <div class="ml-3">
                                            <p class="text-gray-900 whitespace-no-wrap">Vera Carpenter</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                    <p class="text-gray-900 whitespace-no-wrap">Admin</p>
                                </td>
                                <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                    <p class="text-gray-900 whitespace-no-wrap">Jan 21, 2020</p>
                                </td>
                                <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                    <span class="relative inline-block px-3 py-1 font-semibold leading-tight text-green-900">
                                        <span aria-hidden class="absolute inset-0 bg-green-200 rounded-full opacity-50"></span>
                                        <span class="relative">Activo</span>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-10 h-10">
                                            <img class="w-full h-full rounded-full" src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.2&w=160&h=160&q=80" alt="" />
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-gray-900 whitespace-no-wrap"> Blake Bowman</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                    <p class="text-gray-900 whitespace-no-wrap">Editor</p>
                                </td>
                                <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                    <p class="text-gray-900 whitespace-no-wrap">Jan 01, 2020</p>
                                </td>
                                <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                    <span class="relative inline-block px-3 py-1 font-semibold leading-tight text-green-900">
                                        <span aria-hidden class="absolute inset-0 bg-green-200 rounded-full opacity-50"></span>
                                        <span class="relative">Activo</span>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-10 h-10">
                                            <img class="w-full h-full rounded-full" src="https://images.unsplash.com/photo-1540845511934-7721dd7adec3?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.2&w=160&h=160&q=80" alt="" />
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-gray-900 whitespace-no-wrap">Dana Moore</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                    <p class="text-gray-900 whitespace-no-wrap">Editor</p>
                                </td>
                                <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                    <p class="text-gray-900 whitespace-no-wrap">Jan 10, 2020</p>
                                </td>
                                <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                    <span class="relative inline-block px-3 py-1 font-semibold leading-tight text-orange-900">
                                        <span aria-hidden class="absolute inset-0 bg-orange-200 rounded-full opacity-50"></span>
                                        <span class="relative">Suspended</span>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-5 py-5 text-sm bg-white">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-10 h-10">
                                            <img class="w-full h-full rounded-full" src="https://images.unsplash.com/photo-1522609925277-66fea332c575?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.2&h=160&w=160&q=80" alt="" />
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-gray-900 whitespace-no-wrap">Alonzo Cox</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-5 text-sm bg-white">
                                    <p class="text-gray-900 whitespace-no-wrap">Admin</p>
                                </td>
                                <td class="px-5 py-5 text-sm bg-white">
                                    <p class="text-gray-900 whitespace-no-wrap">Jan 18, 2020</p>
                                </td>
                                <td class="px-5 py-5 text-sm bg-white">
                                    <span class="relative inline-block px-3 py-1 font-semibold leading-tight text-red-900">
                                        <span aria-hidden class="absolute inset-0 bg-red-200 rounded-full opacity-50"></span>
                                        <span class="relative">Inactive</span>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="flex flex-col items-center px-5 py-5 bg-white border-t xs:flex-row xs:justify-between">
                        <span class="text-xs text-gray-900 xs:text-sm">Showing 1 to 4 of 50 Entries</span>

                        <div class="inline-flex mt-2 xs:mt-0">
                            <button class="px-4 py-2 text-sm font-semibold text-gray-800 bg-gray-300 rounded-l hover:bg-gray-400">Prev</button>
                            <button class="px-4 py-2 text-sm font-semibold text-gray-800 bg-gray-300 rounded-r hover:bg-gray-400">Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8">
    -->
        <h4 class="text-gray-600">Aujourd'hui</h4>

        <div class="flex flex-col mt-6">
            <div class="py-2 -my-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                            @if(!$data->isEmpty())
                <div class="inline-block min-w-full overflow-hidden align-middle border-b border-gray-200 shadow sm:rounded-lg">

                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-100 border-b border-gray-200 leading-4">Num</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-100 border-b border-gray-200 leading-4">Visiteur</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-100 border-b border-gray-200 leading-4">Hôte</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-100 border-b border-gray-200 leading-4">date entrée</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-100 border-b border-gray-200 leading-4">Status</th>
                                <th class="px-6 py-3 bg-gray-100 border-b border-gray-200"></th>
                            </tr>
                        </thead>

                        <tbody class="bg-white">
    @php $i=$data->count()+1; @endphp
                                        @foreach($data as $row)
    @php $i--; @endphp

                                <tr class="hover:bg-gray-200">
           <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    <div class="text-sm text-gray-900 leading-5">{{ $i }}</div>
                                </td>

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
                            <a class="mr-2 text-indigo-600 hover:text-indigo-900" href="{{ route('i_info',$row->id)}}">
                                <svg class="w-4 h-4" viewBox="0 0 24 24"><path fill="currentColor" d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5s5 2.24 5 5s-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3s3-1.34 3-3s-1.34-3-3-3z"/></svg>
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
                                <span class="font-bold text-red-600">Apparemment il n'y a rien ici 😔</span>

                                </div>
                                </div>
                            @endif

            </div>
        </div>
    </div>
@endsection

