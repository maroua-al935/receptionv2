<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PresidentAntennasToday extends Component
{
    public $antennesToday = [];

    public function mount()
    {
        $this->reloadData();
    }

    public function render()
    {
        return view('livewire.president-antennes-today');
    }

    private function reloadData(): void
    {
        $this->antennesToday = DB::table('antenne_visits')
            ->join('antennes', 'antennes.id', '=', 'antenne_visits.ant_location')
            ->selectRaw('antennes.id, antennes.antenne_name, count(antenne_visits.id) as visits_count')
            ->whereRaw('date(antenne_visits.entry_date) = CURRENT_DATE')
            ->where('antenne_visits.is_deleted', '=', 0)
            ->groupBy('antennes.id', 'antennes.antenne_name')
            ->orderByDesc('visits_count')
            ->orderBy('antennes.antenne_name')
            ->get()
            ->all();
    }
}
