@extends('Supervisor.layouts.master')

@section('body')
    <h3 class="text-3xl font-medium text-gray-700">Bonjour! {{Auth::guard('web')->user()->lastname}} Vous avez:</h3>

    <div class="mt-4">
        <div class="flex flex-wrap -mx-6">
            <div class="w-full px-6 sm:w-1/2 xl:w-1/4">
                <div class="flex items-center px-5 py-6 bg-white shadow-sm rounded-md">
                    <div class="p-3 bg-indigo-600 rounded-full bg-opacity-75">
<svg class="w-8 h-8 text-white" viewBox="0 0 512 512"><circle cx="152" cy="184" r="72" fill="currentColor"/><path fill="currentColor" d="M234 296c-28.16-14.3-59.24-20-82-20c-44.58 0-136 27.34-136 82v42h150v-16.07c0-19 8-38.05 22-53.93c11.17-12.68 26.81-24.45 46-34Z"/><path fill="currentColor" d="M340 288c-52.07 0-156 32.16-156 96v48h312v-48c0-63.84-103.93-96-156-96Z"/><circle cx="340" cy="168" r="88" fill="currentColor"/></svg>
                    </div>

                    <div class="mx-5">
                        <h4 class="text-2xl font-semibold text-gray-700">{{ $today }}</h4>
                        <div class="text-gray-500">Visiteur(s) aujourd'hui</div>
                    </div>
                </div>
            </div>

            <div class="w-full px-6 mt-6 sm:w-1/2 xl:w-1/4 sm:mt-0">
                <div class="flex items-center px-5 py-6 bg-white shadow-sm rounded-md">
                    <div class="p-3 bg-orange-600 rounded-full bg-opacity-75">
<svg class="w-8 h-8 text-white" viewBox="0 0 512 512"><circle cx="152" cy="184" r="72" fill="currentColor"/><path fill="currentColor" d="M234 296c-28.16-14.3-59.24-20-82-20c-44.58 0-136 27.34-136 82v42h150v-16.07c0-19 8-38.05 22-53.93c11.17-12.68 26.81-24.45 46-34Z"/><path fill="currentColor" d="M340 288c-52.07 0-156 32.16-156 96v48h312v-48c0-63.84-103.93-96-156-96Z"/><circle cx="340" cy="168" r="88" fill="currentColor"/></svg>

                    </div>

                    <div class="mx-5">
                        <h4 class="text-2xl font-semibold text-gray-700">{{ $waiting }}</h4>
                        <div class="text-gray-500">Visiteur(s) en attente</div>
                    </div>
                </div>
            </div>
            <div class="w-full px-6 mt-6 sm:w-1/2 xl:w-1/4 xl:mt-0">
                <div class="flex items-center px-5 py-6 bg-white shadow-sm rounded-md">
                    <div class="p-3 bg-green-600 rounded-full bg-opacity-75">
<svg class="w-8 h-8 text-white" viewBox="0 0 512 512"><circle cx="152" cy="184" r="72" fill="currentColor"/><path fill="currentColor" d="M234 296c-28.16-14.3-59.24-20-82-20c-44.58 0-136 27.34-136 82v42h150v-16.07c0-19 8-38.05 22-53.93c11.17-12.68 26.81-24.45 46-34Z"/><path fill="currentColor" d="M340 288c-52.07 0-156 32.16-156 96v48h312v-48c0-63.84-103.93-96-156-96Z"/><circle cx="340" cy="168" r="88" fill="currentColor"/></svg>

                    </div>

                    <div class="mx-5">
                        <h4 class="text-2xl font-semibold text-gray-700">{{ $progress }}</h4>
                        <div class="text-gray-500">Visite(s) en cours</div>
                    </div>
                </div>
            </div>
            <div class="w-full px-6 mt-6 sm:w-1/2 xl:w-1/4 xl:mt-0">
                <div class="flex items-center px-5 py-6 bg-white shadow-sm rounded-md">
                    <div class="p-3 bg-slate-600 rounded-full bg-opacity-75">
<svg class="w-8 h-8 text-white" viewBox="0 0 512 512"><circle cx="152" cy="184" r="72" fill="currentColor"/><path fill="currentColor" d="M234 296c-28.16-14.3-59.24-20-82-20c-44.58 0-136 27.34-136 82v42h150v-16.07c0-19 8-38.05 22-53.93c11.17-12.68 26.81-24.45 46-34Z"/><path fill="currentColor" d="M340 288c-52.07 0-156 32.16-156 96v48h312v-48c0-63.84-103.93-96-156-96Z"/><circle cx="340" cy="168" r="88" fill="currentColor"/></svg>

                    </div>

                    <div class="mx-5">
                        <h4 class="text-2xl font-semibold text-gray-700">{{ $finished }}</h4>
                        <div class="text-gray-500">Visites terminées</div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <h3 class="mt-4 text-3xl font-medium text-gray-700">Liste d'attente</h3>
    <div class="mt-8">

    </div>

    <div class="flex flex-col mt-8">
        <div class="py-2 -my-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">

                            @if(!$data->isEmpty())
            <div class="inline-block min-w-full overflow-hidden align-middle border-b border-gray-200 shadow sm:rounded-lg">
                <table class="min-w-full">
                    <thead>
                        <tr>
                                <th class="px-6 py-3 text-center text-xs w-1 font-medium tracking-wider text-gray-500 uppercase bg-gray-100 border-b border-gray-200 leading-4">Num</th>
                                <th class="px-6 py-3 text-xs w-52 font-medium tracking-wider text-center text-gray-500 uppercase bg-gray-100 border-b border-gray-200 leading-4">Visiteur</th>
                                <th class="px-6 py-3 text-xs w-52 font-medium tracking-wider text-center text-gray-500 uppercase bg-gray-100 border-b border-gray-200 leading-4">Hôte</th>
                                <th class="px-6 py-3 text-xs w-36 font-medium tracking-wider text-center text-gray-500 uppercase bg-gray-100 border-b border-gray-200 leading-4">date entrée</th>
                                <th class="px-6 py-3 text-xs w-fit font-medium tracking-wider text-center text-gray-500 uppercase bg-gray-100 border-b border-gray-200 leading-4">Objet</th>
                                <th class="px-6 py-3 text-xs w-32 font-medium tracking-wider text-center text-gray-500 uppercase bg-gray-100 border-b border-gray-200 leading-4">Status</th>
                        </tr>
                    </thead>

                        <tbody class="bg-white">
    @php $i=0; @endphp
                                        @foreach($data as $row)
    @php $i++; @endphp

                            <tr>
           <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-center">
                                    <div class="text-sm text-gray-900 leading-5">{{ $i }}</div>
                                </td>

                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    <div class="flex items-center text-center align-middle justify-center">
                                        <div class="flex-shrink-0 w-10 h-10 text-center">
<svg  class="w-10 h-10 text-indigo-600"  viewBox="0 0 256 256"><path fill="currentColor" d="M128 24a104 104 0 1 0 104 104A104.2 104.2 0 0 0 128 24Zm0 192a88 88 0 1 1 88-88a88.1 88.1 0 0 1-88 88ZM80 108a12 12 0 1 1 12 12a12 12 0 0 1-12-12Zm72 0a12 12 0 1 1 12 12a12 12 0 0 1-12-12Zm24.5 48a56 56 0 0 1-97 0a8 8 0 1 1 13.8-8a40.1 40.1 0 0 0 69.4 0a8 8 0 0 1 13.8 8Z"/></svg>
                                        </div>

                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 leading-5">{{ $row->firstname }} {{ $row->lastname }}</div>
                                            <div class="text-sm text-gray-500 leading-5">{{ $row->org_name }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    
                                    <div class="text-sm text-center text-gray-900 leading-5">{{ $row->emp_visited }}</div>
                                    <div class="text-sm text-center text-gray-500 leading-5">{{ $row->service_name }}</div>
                                </td>


                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-no-wrap border-b border-gray-200 leading-5 text-center">{{ $row->entry }}</td>
                                <td class="px-6 py-4 text-sm font-medium whitespace-no-wrap border-b border-gray-200 leading-5 justify-center">
                                    <div class="text-sm text-center text-gray-500">{{ $row->subject }}</div>
                                </td>

                                <td class="px-6 py-4 text-center whitespace-no-wrap border-b border-gray-200">
                                    @switch($row->status)
                                    @case(0)
                                    <span class="inline-flex px-2 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full leading-5">En attente</span>
                                    @break
                                    @case(1)
                                    <span class="inline-flex px-2 text-xs font-semibold text-green-800 bg-green-100 rounded-full leading-5">En cours</span>
                                    @break
                                    @case(2)
                                    <span class="inline-flex px-2 text-xs font-semibold bg-gray-300 rounded-full text-black-800 leading-5">Terminée</span>
                                    @break
                                    @endswitch
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
                </table>
            </div>
        </div>
    </div>
@endsection
