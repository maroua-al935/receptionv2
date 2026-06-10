<?php

namespace App\Http\Livewire;

use App\Models\ant_user;
use App\Models\ant_visitors;
use App\Models\ant_visits;
use App\Models\visits_permets_antennes;
use App\Models\antennes;
use Illuminate\Support\Facades\Auth;


use Livewire\Component;

class Anthistoryget extends Component
{
    public $query;
    public $results;
    public $cat;
    public $date;
    public $noresults;
    public $searchhidden;
    public $datehidden;
    public function mount()
    {
        $this->query="";
        $this->results="";
        $this->cat="1";
        $this->date="";
        $this->noresults=0;
        $this->datehidden=1;
        $this->searchhidden=0;
    }
    public function resetdata()
    {
        $this->query="";
        $this->date="";
        $this->results="";
        $this->noresults=0;
        $this->datehidden=1;
        $this->searchhidden=0;

    }
    public function searchbyname($query)
    {
        if (!empty($this->query) && strlen($this->query) >2) {
            $ant_id=ant_user::where('ant_user', '=', Auth::guard('web')->user()->id)->get();
            $this->results=ant_visits::selectraw("antenne_visits.id,antenne_visits.is_deleted,organisations.name as org_name,antenne_visitors.firstname,status,antenne_visitors.lastname,entry_date,users.name as emp_visited,antennes.antenne_name as ant_name,antenne_visits.subject as subject")
               ->leftjoin('antenne_visitors', 'antenne_visitors.id', '=', 'antenne_visits.visitor')
               ->leftjoin('organisations', 'organisations.id', '=', 'antenne_visits.organization')
               ->leftjoin('antennes', 'antennes.id', '=', 'antenne_visits.ant_location')
               ->leftjoin('users', 'users.id', '=', 'antenne_visits.emp_visited')
               ->leftjoin('antenne_users', 'antenne_users.ant_user', '=', 'users.id')
               ->whereraw(" concat(antenne_visitors.firstname,' ',antenne_visitors.lastname) like '%".e($query)."%'")
               ->where('antenne_users.ant_group', '=', $ant_id[0]['ant_group'])
               ->get();
            if ($this->results->count() >0) {
                return $this->results;
            } else {
                return $this->noresults=1;
            }
        }
        return $this->results="";

    }
    public function searchbycompany($query)
    {
        if (!empty($this->query) && strlen($this->query) >2) {
            $ant_id=ant_user::where('ant_user', '=', Auth::guard('web')->user()->id)->get();
            $this->results=ant_visits::selectraw("antenne_visits.id,antenne_visits.is_deleted,organisations.name as org_name,antenne_visitors.firstname,status,antenne_visitors.lastname,entry_date,users.name as emp_visited,antennes.antenne_name as ant_name,antenne_visits.subject as subject")
               ->join('antenne_visitors', 'antenne_visitors.id', '=', 'antenne_visits.visitor')
               ->join('organisations', 'organisations.id', '=', 'antenne_visits.organization')
               ->join('antennes', 'antennes.id', '=', 'antenne_visits.ant_location')
               ->leftjoin('users', 'users.id', '=', 'antenne_visits.emp_visited')
               ->leftjoin('antenne_users', 'antenne_users.ant_user', '=', 'users.id')
               ->whereraw("organisations.name like '%".e($query)."%'")
               ->where('antenne_users.ant_group', '=', $ant_id[0]['ant_group'])
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
            $ant_id=ant_user::where('ant_user', '=', Auth::guard('web')->user()->id)->get();
            $this->results=visits_permets_antennes::selectraw("antenne_visits.id,antenne_visits.is_deleted,organisations.name as org_name,antenne_visitors.firstname,status,antenne_visitors.lastname,entry_date,users.name as emp_visited,antennes.antenne_name as ant_name,antenne_visits.subject as subject")
               ->join('antenne_visits', 'antenne_visits_permet.visit', '=', 'antenne_visits.id')
               ->join('antenne_visitors', 'antenne_visitors.id', '=', 'antenne_visits.visitor')
               ->join('organisations', 'organisations.id', '=', 'antenne_visits.organization')
               ->join('permet_minier', 'permet_minier.id', '=', 'antenne_visits_permet.permet')
               ->join('antennes', 'antennes.id', '=', 'antenne_visits.ant_location')
               ->leftjoin('users', 'users.id', '=', 'antenne_visits.emp_visited')
               ->leftjoin('antenne_users', 'antenne_users.ant_user', '=', 'users.id')
               ->whereraw("permet_minier.designation like '%".e($query)."%'")
               ->where('antenne_users.ant_group', '=', $ant_id[0]['ant_group'])
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

            $ant_id=ant_user::where('ant_user', '=', Auth::guard('web')->user()->id)->get();
            $this->results=ant_visits::selectraw("antenne_visits.id,antenne_visits.is_deleted,organisations.name as org_name,antenne_visitors.firstname,status,antenne_visitors.lastname,entry_date,users.name as emp_visited,antennes.antenne_name as ant_name,antenne_visits.subject as subject")
            ->join('antenne_visitors', 'antenne_visitors.id', '=', 'antenne_visits.visitor')
            ->join('organisations', 'organisations.id', '=', 'antenne_visits.organization')
            ->join('antennes', 'antennes.id', 'antenne_visits.ant_location')
            ->leftjoin('users', 'users.id', '=', 'antenne_visits.emp_visited')
            ->leftjoin('antenne_users', 'antenne_visits.ant_location', 'antenne_users.ant_group')
                    ->wheredate('entry_date', $query)
                    ->where('antenne_users.ant_group', '=', $ant_id[0]['ant_group'])
                    ->groupByRaw('id')
            ->orderByDesc('entry_date')->get();
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
        if ($this->cat == "1") {
            $this->searchbyname($this->query);
        } elseif($this->cat == "2") {
            $this->searchbycompany($this->query);
        } elseif($this->cat == "3") {
            $this->searchhidden=1;
            $this->datehidden=0;
            $this->searchbydate($this->date);
        } elseif($this->cat == "4") {
            $this->searchbypermet($this->query);

        }
        return view('livewire.anthistoryget');
    }
}
