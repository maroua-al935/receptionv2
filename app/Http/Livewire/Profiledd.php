<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Profiledd extends Component
{
    public $show;
    public $listeners = ['act'=>'toggle'];
    
    public function mount() 
    {
        $this->show = false;
    }
    
    public function toggle()
    {
        if ($this->show == false) 
        {
            $this->show == true;
        }else{
            $this->show == false;
        }
    }
    public function render()
    {
        return view('livewire.profiledd');
    }
}
