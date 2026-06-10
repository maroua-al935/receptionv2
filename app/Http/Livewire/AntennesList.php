<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\antennes;
use Illuminate\Support\Facades\DB;

class AntennesList extends Component
{
    public $antennes;
    public $antennes_visited;
    public $state=false;
    public $info;
    public $antenne_n;

    public function select($select)
    {
        $this->state=true;
        $this->info=db::table('antenne_visits')->selectRaw('antenne_visits.id,organisations.name as org_name,antenne_visitors.firstname,status,antenne_visitors.lastname,entry_date,users.name as emp_visited,antennes.antenne_name as service_name')
        ->join('antenne_visitors','antenne_visitors.id','=','antenne_visits.visitor')
        ->join('organisations','organisations.id','=','antenne_visits.organization')
        ->join('antennes','antennes.id','=','antenne_visits.ant_location')
        ->join('users','users.id','=','antenne_visits.emp_visited')
        ->where('antenne_visits.is_deleted','=',0)
        ->where('ant_location','=',$select)
        ->whereraw('date(entry_date) = current_date')
        ->get();
        $this->antenne_n=antennes::select('antenne_name')->where('id','=',$select)->first();
        $this->antennes=db::table('antennes')
        ->leftjoin('antenne_visits','antenne_visits.ant_location','=','antennes.id')
        ->selectraw('antennes.id as ant_id, antennes.antenne_name')
        ->orderby('antenne_name','ASC')
        ->groupBy('antennes.id')
        ->get();
        $this->antennes_visited=db::table('antenne_visits')
        ->selectraw('ant_location, count(id) as count ')
        ->whereRaw('date(entry_date)=CURRENT_DATE')
        ->groupBy('ant_location')
        ->get();

    }

    public function close()
    {
        $this->state=false;
        $this->antenne_n="";
        $this->antennes=db::table('antennes')
        ->leftjoin('antenne_visits','antenne_visits.ant_location','=','antennes.id')
        ->selectraw('antennes.id as ant_id, antennes.antenne_name')
        ->orderby('antenne_name','ASC')
        ->groupBy('antennes.id')
        ->get();
        $this->antennes_visited=db::table('antenne_visits')
        ->selectraw('ant_location, count(id) as count ')
        ->whereRaw('date(entry_date)=CURRENT_DATE')
        ->groupBy('ant_location')
        ->get();
    }

    public function mount()
    {
        $this->antennes=db::table('antennes')
        ->leftjoin('antenne_visits','antenne_visits.ant_location','=','antennes.id')
        ->selectraw('antennes.id as ant_id, antennes.antenne_name')
        ->orderby('antenne_name','ASC')
        ->groupBy('antennes.id')
        ->get();
        $this->antennes_visited=db::table('antenne_visits')
        ->selectraw('ant_location, count(id) as count ')
        ->whereRaw('date(entry_date)=CURRENT_DATE')
        ->groupBy('ant_location')
        ->get();
    }


    public function render()
    {
        return view('livewire.antennes-list');
    }
}
