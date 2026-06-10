<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\visitors;
use Illuminate\Support\Str;

class Ddsearch extends Component
{
    public $query;
    public $selected;
    public $results;
    
    public function mount()
    {
        $this->query="";
        $this->selected="";
        $this->results="";
        $this->data="";
    }
    public function resetdata()
    {
        $this->query="";
        $this->results="";
        $this->data="";
    }
    public function selected($id,$name)
    {
        if(!empty($id))
        {
        $this->resetdata();
        $this->query=$name;
        $this->data=$id;
        $select = ['id', 'firstname', 'lastname', 'cin'];
        if (\Illuminate\Support\Facades\Schema::hasColumn('visitors', 'nin')) {
            $select[] = 'nin';
        }
        $visitor = visitors::select($select)->where('id', '=', $id)->first();
        if ($visitor) {
            $this->dispatchBrowserEvent('visitor-selected', [
                'id' => $visitor->id,
                'fullname' => trim($visitor->firstname . ' ' . $visitor->lastname),
                'firstName' => $visitor->firstname,
                'lastName' => $visitor->lastname,
                'cin' => $visitor->cin,
                'nin' => $visitor->nin ?? null,
            ]);
        }
        }
    }

    public function render()
    {
        if(!empty($this->query))
        {
            $query = e($this->query);
            $this->results=visitors::selectraw("id,concat(firstname,' ',lastname) as fullname")
                ->where(function ($builder) use ($query) {
                    $builder->whereraw("concat(firstname,' ',lastname) like '%".$query."%'")
                        ->orWhere('cin', 'like', '%'.$query.'%');

                    if (\Illuminate\Support\Facades\Schema::hasColumn('visitors', 'nin')) {
                        $builder->orWhere('nin', 'like', '%'.$query.'%');
                    }
                })
                ->get()->toarray();
            //dd($this->results);
        }
        return view('Reception.livewire.ddsearch');
    }
}
