<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\group;
use App\Models\user_groups as ug;

class Ddnames extends Component
{
    public $names;
    public $services;
    public $service_s;
    public $name_s;

    public function mount()
    {
        $this->names = [];
        //$this->service_s="";
        $this->services = group::select('id', 'group_name')
            ->get()->toarray();
    }

    public function render()
    {
        if (!empty($this->service_s)) {
            $this->names = ug::select('users.id', 'users.name as name')
                ->leftjoin('users', 'users.id', 'user_groups.a_user')
                ->where('user_groups.a_group', '=', $this->service_s)
                ->get()->toarray();
        }

        return view('Reception.livewire.ddnames');
    }
}
