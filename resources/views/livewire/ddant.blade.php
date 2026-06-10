<div>
        <div>

        <div class="flex mt-4">
            <span class="px-4 py-2 ml-8 text-sm bg-gray-300 border border-2 rounded-l whitespace-nowrap">Nom et Prénom</span>
            <select name="hostname" placeholder="" class="h-10 px-4 py-2 bg-gray-100 border border-2 rounded-r w-fit">
                <option value="" selected>Choisir un employé</option>
            @foreach ($users as $user)
               <option value="{{ $user['ant_user'] }}">{{ $user['name'] }}</option> 
            @endforeach
            </select>
        </div>
</div>
</div>
