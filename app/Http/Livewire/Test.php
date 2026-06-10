<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Test extends Component
{
    public $message="Fuck you!";
    public $show;
        protected $listeners = ['listen' => 'listen'];

    public function mount()
    {
        $this->show=false;
    }
    public function show()
    {
        $this->show=true;
    }
    public function hide()
    {
        $this->show=false;
    }
    public function listen()
    {
        $this->_show();
    }
    public function render()
    {
        return view('livewire.test');
    }
}
