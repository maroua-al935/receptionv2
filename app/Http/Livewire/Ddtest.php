<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Ddtest extends Component
{
public $services;
public $choice;
public function mount()
    {
        $this->services=array(
    0=>array('id'=>0,'name'=>'zero'),
    1=>array('id'=>1,'name'=>'one'),
    2=>array('id'=>2,'name'=>'two')
);
    $this->choice="";
    }

    public function render()
    {
        if (!empty($this->choice)) {
        }
        return view('livewire.ddtest');
    }
}
