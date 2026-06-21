<?php

namespace App\Http\Livewire;

use App\Models\antennes;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AntennesList extends Component
{
    public $antennes;
    public $antennes_visited;
    public $antenneCounts = [];
    public $mapAntennes = [];
    public $state = false;
    public $selectedAntenneId = null;
    public $info;
    public $antenne_n;

    public function mount()
    {
        $this->reloadMapData();
    }

    public function select($select)
    {
        $this->selectedAntenneId = (int) $select;
        $this->state = true;
        $this->info = DB::table('antenne_visits')
            ->selectRaw('antenne_visits.id,organisations.name as org_name,antenne_visitors.firstname,status,antenne_visitors.lastname,entry_date,users.name as emp_visited,antennes.antenne_name as service_name')
            ->join('antenne_visitors', 'antenne_visitors.id', '=', 'antenne_visits.visitor')
            ->join('organisations', 'organisations.id', '=', 'antenne_visits.organization')
            ->join('antennes', 'antennes.id', '=', 'antenne_visits.ant_location')
            ->join('users', 'users.id', '=', 'antenne_visits.emp_visited')
            ->where('antenne_visits.is_deleted', '=', 0)
            ->where('ant_location', '=', $select)
            ->whereraw('date(entry_date) = current_date')
            ->get();
        $this->antenne_n = antennes::select('antenne_name')->where('id', '=', $select)->first();
        $this->reloadMapData();
    }

    public function close()
    {
        $this->state = false;
        $this->antenne_n = "";
        $this->selectedAntenneId = null;
        $this->reloadMapData();
    }

    public function render()
    {
        return view('livewire.antennes-list');
    }

    private function reloadMapData(): void
    {
        $this->antennes = DB::table('antennes')
            ->selectRaw('id as ant_id, antenne_name')
            ->orderBy('antenne_name', 'ASC')
            ->get();

        $this->antennes_visited = DB::table('antenne_visits')
            ->selectRaw('ant_location, count(id) as count')
            ->whereRaw('date(entry_date) = CURRENT_DATE')
            ->groupBy('ant_location')
            ->get();

        $this->antenneCounts = $this->antennes_visited->pluck('count', 'ant_location')->map(function ($count) {
            return (int) $count;
        })->all();

        $this->mapAntennes = $this->antennes->map(function ($antenne) {
            $marker = $this->markerForAntenna($antenne->antenne_name);
            $count = (int) ($this->antenneCounts[$antenne->ant_id] ?? 0);

            return [
                'id' => (int) $antenne->ant_id,
                'name' => $antenne->antenne_name,
                'x' => $marker['x'],
                'y' => $marker['y'],
                'w' => $marker['w'],
                'h' => $marker['h'],
                'tone' => $marker['tone'],
                'count' => $count,
                'active' => $count > 0,
            ];
        })->values()->all();
    }

    private function markerForAntenna(string $name): array
    {
        $markers = [
            'TINDOUF' => ['x' => 6.5, 'y' => 52, 'w' => 15, 'h' => 15, 'tone' => 'green'],
            'BECHAR' => ['x' => 30, 'y' => 38, 'w' => 11, 'h' => 11, 'tone' => 'violet'],
            'TLEMCEN' => ['x' => 35, 'y' => 15, 'w' => 7, 'h' => 7, 'tone' => 'green'],
            'ORAN' => ['x' => 40, 'y' => 11.75, 'w' => 6, 'h' => 6, 'tone' => 'emerald'],
            'SAIDA' => ['x' => 37.5, 'y' => 22, 'w' => 7, 'h' => 7, 'tone' => 'rose'],
            'CHLEF' => ['x' => 47, 'y' => 8, 'w' => 5, 'h' => 5, 'tone' => 'green'],
            'TIARET' => ['x' => 47, 'y' => 16, 'w' => 7, 'h' => 7, 'tone' => 'sky'],
            'BLIDA' => ['x' => 51, 'y' => 8, 'w' => 5, 'h' => 5, 'tone' => 'slate'],
            'BOUMERDES' => ['x' => 53, 'y' => 6, 'w' =>5, 'h' => 5, 'tone' => 'violet'],
            'BORDJ BOU ARRERIDJ' => ['x' => 54, 'y' => 16, 'w' => 5, 'h' => 5, 'tone' => 'amber'],
            'SETIF' => ['x' => 62.5, 'y' => 12, 'w' => 5, 'h' => 6, 'tone' => 'orange'],
            'DJELFA' => ['x' => 52, 'y' => 25, 'w' => 10, 'h' => 10, 'tone' => 'rose'],
            'BATNA' => ['x' => 69, 'y' => 16, 'w' => 10, 'h' => 10, 'tone' => 'violet'],
            'MILA' => ['x' => 66, 'y' => 7, 'w' => 7, 'h' => 7, 'tone' => 'amber'],
            'CONSTANTINE' => ['x' => 70, 'y' => 10.5, 'w' => 5, 'h' => 5, 'tone' => 'pink'],
            'GUELMA' => ['x' => 73, 'y' => 5.5, 'w' => 7, 'h' => 7, 'tone' => 'rose'],
            'OUM EL BOUAGHI' => ['x' => 75, 'y' => 12, 'w' => 5, 'h' => 5, 'tone' => 'indigo'],
            'TEBESSA' => ['x' => 74, 'y' => 18, 'w' => 5, 'h' => 5, 'tone' => 'cyan'],
            'OUARGLA' => ['x' => 66.5, 'y' => 37, 'w' => 14, 'h' => 14, 'tone' => 'lime'],
            'DJANET' => ['x' => 79, 'y' => 73, 'w' => 13, 'h' => 13, 'tone' => 'pink'],
            'TAMANRASSET' => ['x' => 56, 'y' => 82, 'w' => 16, 'h' => 16, 'tone' => 'rose'],
        ];

        $upperName = strtoupper(trim($name));

        return $markers[$upperName] ?? ['x' => 50, 'y' => 50, 'w' => 10, 'h' => 10, 'tone' => 'slate'];
    }
}
