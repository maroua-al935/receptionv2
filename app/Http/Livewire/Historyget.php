<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\visitors;
use App\Models\visits_permets;
use App\Models\visits;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Historyget extends Component
{
    public $query;
    public $results;
    public $cat;
    public $status;
    public $date;
    public $noresults;
    public $searchhidden;
    public $datehidden;
    public $totalVisits = 0;
public $todayVisits = 0;
public $companiesCount = 0;
public $activeVisitors = 0;
   public function mount()
{
    $this->query = "";
    $this->results = collect();
    $this->cat = "1";
    $this->status = "";
    $this->date = "";
    $this->noresults = 0;
    $this->datehidden = 1;
    $this->searchhidden = 0;

    $this->loadStats();
}
private function loadStats()
{
    $this->totalVisits = visits::count();

    $this->todayVisits = visits::whereDate('entry_date', now())->count();

    $this->companiesCount = visits::distinct('organization')->count('organization');

    $this->activeVisitors = visits::where('status', 'active')->count();
}
    public function resetdata()
    {
        $this->query="";
        $this->status="";
        $this->date="";
        $this->results = collect();
        $this->noresults=0;
        $this->datehidden = $this->cat == "3" ? 0 : 1;
        $this->searchhidden = $this->cat == "3" ? 1 : 0;

    }

    public function updatedCat()
    {
        $this->query = "";
        $this->date = "";
        $this->results = collect();
        $this->noresults = 0;
        $this->datehidden = $this->cat == "3" ? 0 : 1;
        $this->searchhidden = $this->cat == "3" ? 1 : 0;
    }

    public function search()
    {
        $this->noresults = 0;

        if ($this->cat == "1") {
            $this->searchbyname($this->query);
        } elseif ($this->cat == "2") {
            $this->searchbycompany($this->query);
        } elseif ($this->cat == "3") {
            $this->searchhidden = 1;
            $this->datehidden = 0;
            $this->searchbydate($this->date);
        } elseif ($this->cat == "4") {
            $this->searchbypermet($this->query);
        }
    }
    public function searchbyname($query)
    {
        if (!empty($this->query) && strlen($this->query) >2) {
            $this->results=$this->applyVisibility(visits::selectraw("visits.id,visits.is_deleted,organisations.name as org_name,visitors.firstname,status,visitors.lastname,entry_date,users.name as emp_visited,groups.group_name as service_name,visits.subject as subject")
                ->leftjoin('visitors', 'visitors.id', '=', 'visits.visitor')
                ->leftjoin('organisations', 'organisations.id', '=', 'visits.organization')
                ->leftjoin('groups', 'groups.id', '=', 'visits.service_emp_visited')
                ->leftjoin('users', 'users.id', '=', 'visits.emp_visited')
                ->whereraw("concat(visitors.firstname,' ',visitors.lastname) like '%".e($query)."%'"))
                ->when($this->status !== '', function ($builder) {
                    $builder->where('status', $this->status);
                })
                ->get();
            if ($this->results->count() >0) {
                return $this->results;
            } else {
                return $this->noresults=1;
            }
        }
        $this->results = collect();

    }
    public function exportExcel()
    {
        $rows = $this->exportRows();
        $filename = 'history-' . now()->format('Y-m-d_His') . '.csv';

        return response()->streamDownload(function () use ($rows) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, ['Visiteur', 'Société', 'Hôte', 'Service', 'Date entrée', 'Statut']);

            foreach ($rows as $row) {
                fputcsv($handle, [
                    trim(($row->firstname ?? '') . ' ' . ($row->lastname ?? '')),
                    $row->org_name ?? '',
                    $row->emp_visited ?? '',
                    $row->service_name ?? $row->ant_name ?? '',
                    $row->entry_date ?? '',
                    $this->formatStatusLabel($row->status ?? null),
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function exportPDF()
    {
        $rows = $this->exportRows();
        $html = view('livewire.history-pdf', [
            'rows' => $rows,
            'generatedAt' => now(),
        ])->render();

        return response()->streamDownload(function () use ($html) {
            echo $html;
        }, 'history-' . now()->format('Y-m-d_His') . '.html', [
            'Content-Type' => 'text/html; charset=UTF-8',
        ]);
    }


    public function searchbycompany($query)
    {
        if (!empty($this->query) && strlen($this->query) >2) {
            $this->results=$this->applyVisibility(visits::selectraw("visits.id,visits.is_deleted,organisations.name as org_name,visitors.firstname,status,visitors.lastname,entry_date,users.name as emp_visited,groups.group_name as service_name,visits.subject as subject")
              ->leftjoin('visitors', 'visitors.id', '=', 'visits.visitor')
              ->leftjoin('organisations', 'organisations.id', '=', 'visits.organization')
              ->leftjoin('groups', 'groups.id', '=', 'visits.service_emp_visited')
              ->leftjoin('users', 'users.id', '=', 'visits.emp_visited')
              ->whereraw("organisations.name like '%".e($query)."%'"))
              ->when($this->status !== '', function ($builder) {
                    $builder->where('status', $this->status);
                })
              ->get();
            if ($this->results->count() >0) {
                return $this->results;
            } else {
                return $this->noresults=1;
            }
        }
        return $this->results="";
    }


    public function searchbypermet($query)
    {
        if (!empty($this->query) && strlen($this->query) >2) {
            $this->results=$this->applyVisibility(visits_permets::selectraw("visits.id,visits.is_deleted,organisations.name as org_name,visitors.firstname,status,visitors.lastname,entry_date,users.name as emp_visited,groups.group_name as service_name,visits.subject as subject")
               ->leftjoin('visits', 'visits_permets.visit', '=', 'visits.id')
               ->leftjoin('visitors', 'visitors.id', '=', 'visits.visitor')
               ->leftjoin('organisations', 'organisations.id', '=', 'visits.organization')
               ->leftjoin('permet_minier', 'permet_minier.id', '=', 'visits_permets.permet')
               ->leftjoin('groups', 'groups.id', '=', 'visits.service_emp_visited')
               ->leftjoin('users', 'users.id', '=', 'visits.emp_visited')
               ->whereraw("permet_minier.designation like '%".e($query)."%'"))
               ->when($this->status !== '', function ($builder) {
                    $builder->where('status', $this->status);
                })
               ->get();
            if ($this->results->count() >0) {
                return $this->results;
            } else {
                return $this->noresults=1;
            }
        }
        return $this->results="";
    }

    public function searchbydate($query)
    {
        if(!empty($query)) {
             $this->results=$this->applyVisibility(visits::selectraw("visits.id,visits.is_deleted,organisations.name as org_name,visitors.firstname,status,visitors.lastname,entry_date,users.name as emp_visited,groups.group_name as service_name,visits.subject as subject")
              ->leftjoin('visitors', 'visitors.id', '=', 'visits.visitor')
              ->leftjoin('organisations', 'organisations.id', '=', 'visits.organization')
              ->leftjoin('groups', 'groups.id', '=', 'visits.service_emp_visited')
              ->leftjoin('users', 'users.id', '=', 'visits.emp_visited')
              ->wheredate('entry_date', $query))
              ->when($this->status !== '', function ($builder) {
                    $builder->where('status', $this->status);
                })
              ->get();
            if ($this->results->count() >0) {
                return $this->results;
            } else {
                return $this->noresults=1;
            }
        }
        return $this->results="";
    }

    public function render()
    {
        return view('livewire.historyget');
    }

    private function applyVisibility($query)
    {
        if ($this->isServiceAssignmentAgent()) {
            $query->where('visits.service_emp_visited', '=', $this->serviceAssignmentGroupId());
        }

        return $query;
    }

    private function isServiceAssignmentAgent(): bool
    {
        $user = Auth::guard('web')->user();

        return $user && (
            $user->name === 'agent_accueil_service'
            || $user->email === 'agent.accueil.service@visilog.local'
        );
    }

    private function serviceAssignmentGroupId(): int
    {
        return 19;
    }

    private function exportRows(): Collection
    {
        $query = visits::selectRaw("visits.id,visits.is_deleted,organisations.name as org_name,visitors.firstname,visitors.lastname,status,entry_date,users.name as emp_visited,groups.group_name as service_name,visits.subject as subject")
            ->leftJoin('visitors', 'visitors.id', '=', 'visits.visitor')
            ->leftJoin('organisations', 'organisations.id', '=', 'visits.organization')
            ->leftJoin('groups', 'groups.id', '=', 'visits.service_emp_visited')
            ->leftJoin('users', 'users.id', '=', 'visits.emp_visited');

        $query = $this->applyVisibility($query);
        $query = $this->applyFilters($query);

        return $query->orderByDesc('entry_date')->get();
    }

    private function applyFilters($query)
    {
        if ($this->status !== '') {
            $query->where('status', $this->status);
        }

        if ($this->cat === '3' && !empty($this->date)) {
            $query->whereDate('entry_date', $this->date);
            return $query;
        }

        if ($this->cat === '2' && !empty($this->query) && strlen($this->query) > 2) {
            $query->whereRaw("organisations.name like '%" . e($this->query) . "%'");
            return $query;
        }

        if ($this->cat === '4' && !empty($this->query) && strlen($this->query) > 2) {
            $query->leftJoin('visits_permets', 'visits_permets.visit', '=', 'visits.id')
                ->leftJoin('permet_minier', 'permet_minier.id', '=', 'visits_permets.permet')
                ->whereRaw("permet_minier.designation like '%" . e($this->query) . "%'");
            return $query;
        }

        if (!empty($this->query) && strlen($this->query) > 2) {
            $query->whereRaw("concat(visitors.firstname,' ',visitors.lastname) like '%" . e($this->query) . "%'");
        }

        return $query;
    }

    private function formatStatusLabel($status): string
    {
        return match ((string) $status) {
            '0' => 'En attente',
            '1' => 'En cours',
            '2' => 'Terminée',
            default => 'Inconnu',
        };
    }
}
