<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\ant_user;
use App\Models\ant_visitors;
use App\Models\ant_visits;
use App\Models\antennes;


class ddant extends Component
{
    public $users;
    
    public function mount()
    {
        $this->users=[];
    }

    public function render()
    {
        $ant_id=ant_user::select('ant_group')->where('ant_user','=',Auth::guard('web')->user()->id)->get();
        $this->users=ant_user::select('ant_user','users.name')
        ->where('ant_group','=',$ant_id[0]['ant_group'])
        ->leftjoin('users','users.id','antenne_users.ant_user')
        ->where('users.profile','=',7)
        ->orderBy('users.name')
        ->get()->toarray();
        return view('livewire.ddant');
    }
}
