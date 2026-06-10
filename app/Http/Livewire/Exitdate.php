<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\Carbon;

class Exitdate extends Component
{
    public $date;
    protected $listeners = ['state'=>'state'];
    
    public function state()
    {
        $this->state=$state;
    }

    public function mount()
    {
        $this->date=Carbon::now();
    }
    public function render()
    {
        return view('Reception.livewire.exitdate');
    }
}
