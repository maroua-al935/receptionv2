<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Addvisitor extends Component
{
    public $show;

    public function mount() {
        $this->show = false;
    }

    public function doShow() {
        $this->show = true;
    }

    public function doClose() {
        $this->show = false;
    }
    public function render()
    {
        return view('livewire.addvisitor');
    }
}
