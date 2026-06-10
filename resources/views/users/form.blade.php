@extends('President.layouts.master')

@section('body')
    @php
        $selectedServiceIds = array_map('intval', old('services', isset($selectedGroups) ? $selectedGroups->all() : []));
        $headServiceIds = array_map('intval', old('head_services', isset($headGroups) ? $headGroups->all() : []));
        $selectedAntenneIds = array_map('intval', old('antennes', isset($selectedAntennes) ? $selectedAntennes->all() : []));
        $headAntenneIds = array_map('intval', old('head_antennes', isset($headAntennes) ? $headAntennes->all() : []));
        $assignmentType = old('assignment_type', !empty($selectedAntenneIds) ? 'antenne' : 'siege');
    @endphp
    <div class="container mx-auto px-4 sm:px-8">
        <div class="py-8">
            <div>
                <h2 class="text-2xl font-semibold leading-tight">{{ isset($user) ? 'Edit User' : 'Add User' }}</h2>
            </div>
            @if($errors->any())
                <div class="mt-4 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                    <p class="font-bold">Corrigez les informations suivantes :</p>
                    <ul class="mt-2 list-disc space-y-1 pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" method="POST">
                    @csrf
                    @if (isset($user))
                        @method('PUT')
                    @endif
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                    <input type="text" name="name" id="name"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                        value="{{ old('name', $user->name ?? '') }}" required>
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" name="email" id="email"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                        value="{{ old('email', $user->email ?? '') }}" required>
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="firstname" class="block text-sm font-medium text-gray-700">First
                                        Name</label>
                                    <input type="text" name="firstname" id="firstname"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                        value="{{ old('firstname', $user->firstname ?? '') }}">
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="lastname" class="block text-sm font-medium text-gray-700">Last
                                        Name</label>
                                    <input type="text" name="lastname" id="lastname"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                        value="{{ old('lastname', $user->lastname ?? '') }}">
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                                    <input type="text" name="phone" id="phone"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                        value="{{ old('phone', $user->phone ?? '') }}">
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="profile"
                                        class="block text-sm font-medium text-gray-700">Profile</label>
                                    <select name="profile" id="profile"
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        required>
                                        @foreach ($profiles as $profile)
                                            <option value="{{ $profile->id }}"
                                                {{ (int) old('profile', $user->profile ?? 0) === (int) $profile->id ? 'selected' : '' }}>
                                                {{ $profile->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="password"
                                        class="block text-sm font-medium text-gray-700">Password</label>
                                    <input type="password" name="password" id="password"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                        {{ isset($user) ? '' : 'required' }}>
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="password_confirmation"
                                        class="block text-sm font-medium text-gray-700">Confirm Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>

                            <div class="rounded-lg border border-slate-200 bg-white p-4">
                                <h3 class="text-base font-semibold text-slate-900">Type d'affectation</h3>
                                <div class="mt-3 flex flex-wrap gap-4">
                                    <label class="inline-flex items-center gap-2 rounded-lg border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700">
                                        <input type="radio" name="assignment_type" value="siege" class="assignment-type h-4 w-4" @checked($assignmentType === 'siege')>
                                        Siege
                                    </label>
                                    <label class="inline-flex items-center gap-2 rounded-lg border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700">
                                        <input type="radio" name="assignment_type" value="antenne" class="assignment-type h-4 w-4" @checked($assignmentType === 'antenne')>
                                        Antenne
                                    </label>
                                </div>
                            </div>

                            <div id="siege-panel" class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                                <div class="mb-4">
                                    <h3 class="text-base font-semibold text-slate-900">Services et chef de service</h3>
                                    <p class="mt-1 text-sm text-slate-500">Cochez les services de cet utilisateur. Cochez "Chef" pour le definir comme chef du service.</p>
                                </div>

                                <div class="overflow-hidden rounded-lg border border-slate-200 bg-white">
                                    <table class="min-w-full divide-y divide-slate-200">
                                        <thead class="bg-slate-50">
                                            <tr>
                                                <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Service</th>
                                                <th class="w-28 px-4 py-3 text-center text-xs font-bold uppercase tracking-wide text-slate-500">Membre</th>
                                                <th class="w-28 px-4 py-3 text-center text-xs font-bold uppercase tracking-wide text-slate-500">Chef</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            @foreach($groups as $group)
                                                @php
                                                    $isSelected = in_array((int) $group->id, $selectedServiceIds, true);
                                                    $isHead = in_array((int) $group->id, $headServiceIds, true);
                                                @endphp
                                                <tr>
                                                    <td class="px-4 py-3 text-sm font-semibold text-slate-800">{{ $group->group_name }}</td>
                                                    <td class="px-4 py-3 text-center">
                                                        <input type="checkbox" name="services[]" value="{{ $group->id }}" class="service-checkbox h-4 w-4 rounded border-slate-300" @checked($isSelected)>
                                                    </td>
                                                    <td class="px-4 py-3 text-center">
                                                        <input type="checkbox" name="head_services[]" value="{{ $group->id }}" class="head-checkbox h-4 w-4 rounded border-slate-300" @checked($isHead) @disabled(!$isSelected)>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div id="antenne-panel" class="rounded-lg border border-rose-200 bg-rose-50 p-4">
                                <div class="mb-4">
                                    <h3 class="text-base font-semibold text-slate-900">Antennes et chef d'antenne</h3>
                                    <p class="mt-1 text-sm text-slate-500">Cochez les antennes de cet utilisateur. Cochez "Chef" pour lui permettre de receptionner puis orienter les visites de cette antenne.</p>
                                </div>

                                <div class="overflow-hidden rounded-lg border border-rose-200 bg-white">
                                    <table class="min-w-full divide-y divide-slate-200">
                                        <thead class="bg-rose-50">
                                            <tr>
                                                <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Antenne</th>
                                                <th class="w-28 px-4 py-3 text-center text-xs font-bold uppercase tracking-wide text-slate-500">Membre</th>
                                                <th class="w-28 px-4 py-3 text-center text-xs font-bold uppercase tracking-wide text-slate-500">Chef</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            @foreach($antennes as $antenne)
                                                @php
                                                    $isSelected = in_array((int) $antenne->id, $selectedAntenneIds, true);
                                                    $isHead = in_array((int) $antenne->id, $headAntenneIds, true);
                                                @endphp
                                                <tr>
                                                    <td class="px-4 py-3 text-sm font-semibold text-slate-800">{{ $antenne->antenne_name }}</td>
                                                    <td class="px-4 py-3 text-center">
                                                        <input type="checkbox" name="antennes[]" value="{{ $antenne->id }}" class="antenne-checkbox h-4 w-4 rounded border-slate-300" @checked($isSelected)>
                                                    </td>
                                                    <td class="px-4 py-3 text-center">
                                                        <input type="checkbox" name="head_antennes[]" value="{{ $antenne->id }}" class="antenne-head-checkbox h-4 w-4 rounded border-slate-300" @checked($isHead) @disabled(!$isSelected)>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ isset($user) ? 'Update' : 'Create' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function syncHeadCheckboxes() {
            document.querySelectorAll('.service-checkbox').forEach(function (serviceCheckbox) {
                const row = serviceCheckbox.closest('tr');
                const headCheckbox = row.querySelector('.head-checkbox');
                headCheckbox.disabled = !serviceCheckbox.checked || serviceCheckbox.disabled;
                if (!serviceCheckbox.checked) {
                    headCheckbox.checked = false;
                }
            });

            document.querySelectorAll('.antenne-checkbox').forEach(function (antenneCheckbox) {
                const row = antenneCheckbox.closest('tr');
                const headCheckbox = row.querySelector('.antenne-head-checkbox');
                headCheckbox.disabled = !antenneCheckbox.checked || antenneCheckbox.disabled;
                if (!antenneCheckbox.checked) {
                    headCheckbox.checked = false;
                }
            });
        }

        function setAssignmentType(type) {
            const siegePanel = document.getElementById('siege-panel');
            const antennePanel = document.getElementById('antenne-panel');
            const showSiege = type === 'siege';

            siegePanel.classList.toggle('hidden', !showSiege);
            antennePanel.classList.toggle('hidden', showSiege);

            siegePanel.querySelectorAll('input').forEach(function (input) {
                input.disabled = !showSiege;
            });
            antennePanel.querySelectorAll('input').forEach(function (input) {
                input.disabled = showSiege;
            });

            syncHeadCheckboxes();
        }

        document.querySelectorAll('.assignment-type').forEach(function (radio) {
            radio.addEventListener('change', function () {
                setAssignmentType(radio.value);
            });
        });

        document.querySelectorAll('.service-checkbox').forEach(function (serviceCheckbox) {
            serviceCheckbox.addEventListener('change', function () {
                syncHeadCheckboxes();
            });
        });

        document.querySelectorAll('.head-checkbox').forEach(function (headCheckbox) {
            headCheckbox.addEventListener('change', function () {
                const row = headCheckbox.closest('tr');
                const serviceCheckbox = row.querySelector('.service-checkbox');
                if (headCheckbox.checked) {
                    serviceCheckbox.checked = true;
                    headCheckbox.disabled = false;
                }
            });
        });

        document.querySelectorAll('.antenne-checkbox').forEach(function (antenneCheckbox) {
            antenneCheckbox.addEventListener('change', function () {
                syncHeadCheckboxes();
            });
        });

        document.querySelectorAll('.antenne-head-checkbox').forEach(function (headCheckbox) {
            headCheckbox.addEventListener('change', function () {
                const row = headCheckbox.closest('tr');
                const antenneCheckbox = row.querySelector('.antenne-checkbox');
                if (headCheckbox.checked) {
                    antenneCheckbox.checked = true;
                    headCheckbox.disabled = false;
                }
            });
        });

        const checkedAssignmentType = document.querySelector('.assignment-type:checked');
        setAssignmentType(checkedAssignmentType ? checkedAssignmentType.value : 'siege');
    </script>
@endsection
