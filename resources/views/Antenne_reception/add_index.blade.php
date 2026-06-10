@extends('Antenne_reception.layouts.master')

@section('body')
    <form action="{{ route('p_add_visitors') }}" method="post" enctype="multipart/form-data" class="visit-form-modern antenne-form">
        @csrf
        <div class="flex ">
            <div class="grow ">
                <div class="w-full max-w-7xl py-2">
                    <div class="form-card">
                        <div class="flex flex-col gap-2 border-b border-slate-100 pb-5">
                            <p class="text-[10px] font-black uppercase tracking-widest text-rose-600">Nouvelle visite antenne</p>
                            <span class="page-title block">Enregistrer un visiteur</span>
                            <p class="page-subtitle">Capture du visiteur et rattachement a l'antenne de destination.</p>
                            @if (!is_null(Session::get('error')))
                                <br>
                                <span x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                                    class="px-2 py-2 text-lg font-semibold justify-center text-red-600">{{ Session::get('error') }}</span>
                            @endif
                        </div>
                        <div class="flex mt-4">
                            <span
                                class="float-left px-4 py-2 ml-8 text-sm bg-gray-300 border border-2 rounded-l whitespace-nowrap">Nouveau
                                visiteur
                                <input type="radio" id="new" name="new_visitor"
                                    class="px-4 py-2 bg-gray-100 border border-2 rounded-r" checked></span>
                            <span
                                class="float-left px-4 py-2 ml-8 text-sm bg-gray-300 border border-2 rounded-l whitespace-nowrap">Visiteur
                                existant
                                <input type="radio" id="exists" name="exists"
                                    class="px-4 py-2 bg-gray-100 border border-2 rounded-r"></span>

                        </div>
                        <div id="new_user">
                            <div class="flex mt-4">
                                <span
                                    class="float-left px-4 py-2 ml-8 text-sm bg-gray-300 border border-2 rounded-l whitespace-nowrap">Nom</span>
                                <input type="text" name="fname" placeholder=""
                                    class="w-1/4 h-10 px-4 py-2 bg-gray-100 border border-2 rounded-r" />
                                <span
                                    class="px-4 py-2 ml-8 text-sm bg-gray-300 border border-2 rounded-l float-middle whitespace-nowrap">Prenom</span>
                                <input type="text" name="lname" placeholder=""
                                    class="w-1/4 h-10 px-4 py-2 bg-gray-100 border border-2 rounded-r" />


                            </div>

                            
                            <div class="flex mt-4 w-full">
                                <span
                                    class=" px-4 py-2 ml-8 text-sm bg-gray-300 border border-2 rounded-l float-middle whitespace-nowrap">Poste</span>
                                <select name="role" id="role"
                                    class="float-right w-1/4 h-10 px-4 py-2 mr-2 bg-gray-100 border border-2 rounded-r">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                    <option value="other">Autre</option>
                                </select>
                                <div id="other" class=" ml-8 w-2/4 flex hidden">
                                    <span
                                        class=" px-4 py-2 text-sm bg-gray-300 border border-2 rounded-l float-middle whitespace-nowrap">Autre
                                        Poste</span>
                                    <input id="other_field" type="text" name="other_value" placeholder=""
                                        class=" h-10 px-4 py-2 bg-gray-100 border border-2 rounded-r" />
                                </div>
                            </div>
                            <div class="flex mt-4">
                                <span
                                    class="float-left px-4 py-2 ml-8 text-sm bg-gray-300 border border-2 rounded-l whitespace-nowrap">Pièce
                                    d'identité</span>
                                <select name="id_cat"
                                    class="float-right w-1/4 h-10 px-4 py-2 mr-2 bg-gray-100 border border-2 rounded-r">
                                    @foreach ($id_types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                <span
                                    class="px-4 py-2 ml-8 text-sm bg-gray-300 border border-2 rounded-l whitespace-nowrap">Numéro
                                    piece</span>
                                <input type="text" name="cin" placeholder=""
                                    class="w-1/4 h-10 px-4 py-2 bg-gray-100 border border-2 rounded-r" />


                            </div>

                        </div>

                        <div id="user_exists" class="hidden">
                            @livewire('ddsearch')
                        </div>
                        <div class="flex mt-4">
                            <span
                                class="float-left px-4 py-2 ml-8 text-sm bg-gray-300 border border-2 rounded-l whitespace-nowrap">Objet
                                de visite</span>
                            <input type="text" name="subject" placeholder=""
                                class="w-1/4 h-10 px-4 py-2 bg-gray-100 border border-2 rounded-r" />
                            <span
                                class="float-left px-4 py-2 ml-8 text-sm bg-gray-300 border border-2 rounded-l whitespace-nowrap">Type</span>
                            <select name="category"
                                class="float-right w-1/4 h-10 px-4 py-2 mr-2 bg-gray-100 border border-2 rounded-r">
                                @foreach ($cats as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>


                        </div>

                        <div class="flex mt-4">
                            <span
                                class="px-4 py-2 ml-8 text-sm bg-gray-300 border border-2 rounded-l float-middle whitespace-nowrap">Société</span>
                            <input type="text" name="org" placeholder=""
                                class="w-1/4 h-10 px-4 py-2 bg-gray-100 border border-2 rounded-r" />
                            <span
                                class="float-left px-4 py-2 ml-8 text-sm bg-gray-300 border border-2 rounded-l whitespace-nowrap">Heure
                                d'entrée</span>
                            <input type="datetime-local" name="date_entry" value="{{ $cur_date }}"
                                class="h-10 px-4 py-2 bg-gray-100 border border-2 rounded-r w-fit disabled:bg-gray-400">
                        </div>
                        <div class="flex mt-4">
                            <span
                                class="px-4 py-2 ml-8 text-sm bg-gray-300 border-2 rounded-l float-middle whitespace-nowrap">Permis
                                minier(s)</span>
                            <input id="permetadd" type="text" name="permetadd" placeholder=""
                                class="w-1/4 h-10 px-4 py-2 bg-gray-100 border-2 rounded-r" />

                            <button id="addbtn" type="button" class="h-8 w-8 mr-4 ml-2"><svg
                                    class="w-10 h-10 px-2 py-2 text-white bg-green-500 hover:bg-green-600 rounded-md"
                                    viewBox="0 0 256 256">
                                    <path fill="currentColor"
                                        d="M228 128a12 12 0 0 1-12 12h-76v76a12 12 0 0 1-24 0v-76H40a12 12 0 0 1 0-24h76V40a12 12 0 0 1 24 0v76h76a12 12 0 0 1 12 12Z" />
                                </svg></button>
                            <button id="clrbtn" type="button" class=" h-8 w-8"><svg
                                    class="w-10 h-10 px-2 py-2 text-white bg-red-500 rounded-md hover:bg-red-600"
                                    viewBox="0 0 256 256">
                                    <path fill="currentColor"
                                        d="M216 48h-40v-8a24 24 0 0 0-24-24h-48a24 24 0 0 0-24 24v8H40a8 8 0 0 0 0 16h8v144a16 16 0 0 0 16 16h128a16 16 0 0 0 16-16V64h8a8 8 0 0 0 0-16ZM96 40a8 8 0 0 1 8-8h48a8 8 0 0 1 8 8v8H96Zm96 168H64V64h128Zm-80-104v64a8 8 0 0 1-16 0v-64a8 8 0 0 1 16 0Zm48 0v64a8 8 0 0 1-16 0v-64a8 8 0 0 1 16 0Z" />
                                </svg></button>
                        </div>

                        <div class="flex mt-4">
                            <textarea id="permets" readonly cols="30" rows="2" type="text" name="permets" value=""
                                class="ml-8 hidden px-4 py-2 bg-gray-100 border-2 rounded-r w-fit disabled:bg-gray-400"></textarea>
                        </div>


                        <div>
                            <div class="mt-4 mb-4">
                                <span class="px-2 py-2 text-2xl font-semibold">Personne visitée</span>
                            </div>
                            @livewire('ddant')
                        </div>

                        <div class="pb-12 mt-4 mr-12">
                            <input type="submit"
                                class="float-right w-24 px-2 py-2 font-semibold text-white bg-green-600 rounded-lg button hover:bg-green-500"
                                Value="Ajouter">
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </form>
    <script type="module">
        $("#new").click(function() {
            $("#exists").prop('checked', false);
            $("#new_user").removeClass('hidden');
            $("#user_exists").addClass('hidden');
        });
        $("#exists").click(function() {
            $("#new").prop('checked', false);
            $("#new_user").addClass('hidden');
            $("#user_exists").removeClass('hidden');
        });
        $("#hashost").click(function() {
            $("#visited").toggleClass('hidden');
        });
        $('#role').click(function() {
            if ($('#role option:selected').val() == "other") {
                $("#other").removeClass('hidden');
            } else {
                $("#other").addClass('hidden');
                $("#other_field").val(null);
            }
        });
        $(document).ready(function() {
            $('#permetadd').on('change', function() {
                $('#permetadd').val() != "" ? $('#permets').removeClass('hidden') : $('#permets').addClass(
                    'hidden')
            });
            $('#addbtn').on('click', function() {
                const addPermet = document.getElementById('permetadd')
                const permets = document.getElementById('permets')
                if (addPermet.value != "" && !permets.value.match(addPermet.value) && !addPermet.value
                    .match(",")) {

                    permets.value == "" ? permets.value = addPermet.value : permets.value = permets.value +
                        ',' + addPermet.value
                    addPermet.value = ""
                }

            });
            $('#clrbtn').on('click', function() {
                const permets = document.getElementById('permets')
                permets.value == "" ? "" : permets.value = ""
                $(permets).addClass('hidden')


            });


        });
    </script>
@endsection
