<?php

namespace App\Http\Livewire;

use App\Models\ant_visits;
use App\Models\antennes;
use Livewire\Component;

class Allanthistoryget extends Component
{
    public $query = '';
    public $results;
    public $cat = '1';
    public $ant;
    public $ant_select = '';
    public $status = '';
    public $date = '';
    public $noresults = 0;
    public $totalVisits = 0;
    public $todayVisits = 0;
    public $companiesCount = 0;
    public $activeVisitors = 0;

    public function mount()
    {
        $this->results = collect();
        $this->ant = antennes::select('id', 'antenne_name')->orderBy('antenne_name')->get();

        $this->loadStats();
    }

    public function resetdata()
    {
        $this->query = '';
        $this->date = '';
        $this->status = '';
        $this->ant_select = '';
        $this->results = collect();
        $this->noresults = 0;
    }

    public function updatedCat()
    {
        $this->query = '';
        $this->date = '';
        $this->results = collect();
        $this->noresults = 0;
    }

    public function search()
    {
        $this->noresults = 0;

        $query = $this->baseQuery();
        $query = $this->applyFilters($query);

        $this->results = $query->orderByDesc('antenne_visits.entry_date')->get();
        $this->noresults = $this->results->isEmpty() ? 1 : 0;
    }

    public function render()
    {
        return view('livewire.allanthistoryget');
    }

    private function loadStats()
    {
        $baseQuery = ant_visits::where('is_deleted', '=', 0);

        $this->totalVisits = (clone $baseQuery)->count();
        $this->todayVisits = (clone $baseQuery)->whereDate('entry_date', now())->count();
        $this->companiesCount = (clone $baseQuery)->distinct('organization')->count('organization');
        $this->activeVisitors = (clone $baseQuery)->whereIn('status', [0, 1])->count();
    }

    private function baseQuery()
    {
        return ant_visits::selectRaw('antenne_visits.id, antenne_visits.is_deleted, organisations.name as org_name, antenne_visitors.firstname, antenne_visits.status as status, antenne_visitors.lastname, antenne_visits.entry_date, users.name as emp_visited, antennes.antenne_name as ant_name, antenne_visits.subject as subject')
            ->leftJoin('antenne_visitors', 'antenne_visitors.id', '=', 'antenne_visits.visitor')
            ->leftJoin('organisations', 'organisations.id', '=', 'antenne_visits.organization')
            ->leftJoin('antennes', 'antennes.id', '=', 'antenne_visits.ant_location')
            ->leftJoin('users', 'users.id', '=', 'antenne_visits.emp_visited')
            ->where('antenne_visits.is_deleted', '=', 0);
    }

    private function applyFilters($query)
    {
        if ($this->ant_select !== '') {
            $query->where('antenne_visits.ant_location', '=', $this->ant_select);
        }

        if ($this->status !== '') {
            $query->where('antenne_visits.status', '=', $this->status);
        }

        if ($this->cat === '3') {
            if (!empty($this->date)) {
                $query->whereDate('antenne_visits.entry_date', $this->date);
            }

            return $query;
        }

        if (empty($this->query) || strlen($this->query) <= 2) {
            return $query->whereRaw('1 = 0');
        }

        if ($this->cat === '2') {
            return $query->whereRaw("organisations.name like '%" . e($this->query) . "%'");
        }

        if ($this->cat === '4') {
            return $query->leftJoin('antenne_visits_permet', 'antenne_visits_permet.visit', '=', 'antenne_visits.id')
                ->leftJoin('permet_minier', 'permet_minier.id', '=', 'antenne_visits_permet.permet')
                ->whereRaw("permet_minier.designation like '%" . e($this->query) . "%'");
        }

        return $query->whereRaw("concat(antenne_visitors.firstname,' ',antenne_visitors.lastname) like '%" . e($this->query) . "%'");
    }
}
