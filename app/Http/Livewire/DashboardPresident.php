<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DashboardPresident extends Component
{
    public $query;
    public $results;
    protected $listeners = ['test' => 'test'];
    public function test() {
        dd('test');
    }
    public function render()
    {
        return view('livewire.dashboard-president');
    }
}
