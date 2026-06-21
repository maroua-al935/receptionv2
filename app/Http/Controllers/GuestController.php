<?php

namespace App\Http\Controllers;

//models

use App\Models\ant_user;
use App\Models\ant_visitors;
use App\Models\ant_visits;
use App\Models\antennes;
use App\Models\visitors as visitor;
use App\Models\visits as visit;
use App\Models\group;
use App\Models\user_groups as ug;
use App\Models\attachments as attach;
use App\Models\organisations as organisation;
use App\Models\services as services;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

//end models
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\types;
use Illuminate\Validation\Rules\Exists;

class GuestController extends Controller
{
    public function get_index()
    {
        switch (Auth::guard('web')->user()->profile) {
            case 6:
                return $this->index_6();
                break;
            case 7:
                return $this->index_7();
                break;
            case 5:
                return $this->index_5();
                break;
            case 8:
                return $this->index_8();
                break;
            case 4:
                return $this->index_4();
                break;

            case 2:
                return $this->index_2();
                break;
                
            case 9:
                return $this->index_4();
                break;
        }
    }
    public function index_6()
    {

        $ant_id = ant_user::where('ant_user', '=', Auth::guard('web')->user()->id)->get();
        $ant_loc = antennes::where('id', '=', $ant_id[0]['ant_group'])->get();
        $visits = db::table('antenne_visits')->selectRaw('antenne_visits.id, antennes.antenne_name as ant_name,antenne_visits.is_deleted,organisations.name as org_name,antenne_visitors.firstname,status,antenne_visitors.lastname,entry_date,users.name as emp_visited')
            ->join('antenne_visitors', 'antenne_visitors.id', '=', 'antenne_visits.visitor')
            ->join('organisations', 'organisations.id', '=', 'antenne_visits.organization')
            ->join('antennes', 'antennes.id', 'antenne_visits.ant_location')
            ->leftjoin('users', 'users.id', '=', 'antenne_visits.emp_visited')
            ->leftjoin('antenne_users', 'antenne_visits.ant_location', 'antenne_users.ant_group')
            ->wheredate('entry_date', db::raw('CURDATE()'))
            ->where('antenne_visits.is_deleted', '=', 0)
            ->where('antenne_users.ant_group', '=', $ant_id[0]['ant_group'])
            ->groupByRaw('id')
            ->orderByDesc('entry_date')->get();

        $old = db::table('antenne_visits')->selectRaw('antenne_visits.id, antennes.antenne_name as ant_name,antenne_visits.is_deleted,organisations.name as org_name,antenne_visitors.firstname,status,antenne_visitors.lastname,entry_date,users.name as emp_visited')
            ->join('antenne_visitors', 'antenne_visitors.id', '=', 'antenne_visits.visitor')
            ->leftjoin('organisations', 'organisations.id', '=', 'antenne_visits.organization')
            ->join('antennes', 'antennes.id', 'antenne_visits.ant_location')
            ->leftjoin('users', 'users.id', '=', 'antenne_visits.emp_visited')
            ->whereraw('entry_date < CURDATE()')
            ->whereIn('status', [0, 1, 3])
            ->where('antenne_visits.is_deleted', '=', 0)
            ->where('antenne_visits.ant_location', '=', $ant_id[0]['ant_group'])
            ->orderByDesc('entry_date')->get();

        return view('Antenne_reception.visitors')->with('url', 'guest')->with('data', $visits)->with('old', $old)->with('loc', $ant_loc[0]['antenne_name']);
    }

    public function index_7()
    {
        $antUser = ant_user::where('ant_user', '=', Auth::guard('web')->user()->id)->first();
        if (!$antUser) {
            abort(403);
        }

        $ant_loc = antennes::where('id', '=', $antUser->ant_group)->first();
        $isHead = $this->isAntenneHead(Auth::guard('web')->user()->id, $antUser->ant_group);

        $query = db::table('antenne_visits')->selectRaw('antenne_visits.id, antennes.antenne_name as ant_name,antenne_visits.is_deleted,organisations.name as org_name,antenne_visitors.firstname,status,antenne_visitors.lastname,entry_date,users.name as emp_visited')
            ->join('antenne_visitors', 'antenne_visitors.id', '=', 'antenne_visits.visitor')
            ->leftjoin('organisations', 'organisations.id', '=', 'antenne_visits.organization')
            ->join('antennes', 'antennes.id', 'antenne_visits.ant_location')
            ->leftjoin('users', 'users.id', '=', 'antenne_visits.emp_visited')
            ->wheredate('entry_date', db::raw('CURDATE()'))
            ->where('antenne_visits.ant_location', '=', $antUser->ant_group)
            ->where('antenne_visits.is_deleted', '=', 0)
            ->where(function ($query) use ($isHead) {
                $query->where('antenne_visits.emp_visited', '=', Auth::guard('web')->user()->id);
                if ($isHead) {
                    $query->orWhereNull('antenne_visits.emp_visited');
                }
            });

        $visits = $query->orderByDesc('entry_date')->get();

        $old = db::table('antenne_visits')->selectRaw('antenne_visits.id, antennes.antenne_name as ant_name,antenne_visits.is_deleted,organisations.name as org_name,antenne_visitors.firstname,status,antenne_visitors.lastname,entry_date,users.name as emp_visited')
            ->join('antenne_visitors', 'antenne_visitors.id', '=', 'antenne_visits.visitor')
            ->leftjoin('organisations', 'organisations.id', '=', 'antenne_visits.organization')
            ->join('antennes', 'antennes.id', 'antenne_visits.ant_location')
            ->leftjoin('users', 'users.id', '=', 'antenne_visits.emp_visited')
            ->whereraw('entry_date < CURDATE()')
            ->whereIn('status', [0, 1, 3])
            ->where('antenne_visits.ant_location', '=', $antUser->ant_group)
            ->where('antenne_visits.is_deleted', '=', 0)
            ->where(function ($query) use ($isHead) {
                $query->where('antenne_visits.emp_visited', '=', Auth::guard('web')->user()->id);
                if ($isHead) {
                    $query->orWhereNull('antenne_visits.emp_visited');
                }
            })
            ->orderByDesc('entry_date')->get();

        return view('Antenne_reception.visitors')
            ->with('url', 'guest')
            ->with('data', $visits)
            ->with('old', $old)
            ->with('loc', $ant_loc->antenne_name ?? 'cette antenne')
            ->with('isAntenneHead', $isHead);
    }

    public function index_5()
    {
        $visits = db::table('visits')->selectRaw('visits.id,badge_n,visits.is_deleted,organisations.name as org_name,visitors.firstname,status,visitors.lastname,entry_date,users.name as emp_visited,groups.group_name as service_name')
            ->leftjoin('visitors', 'visitors.id', '=', 'visits.visitor')
            ->leftjoin('organisations', 'organisations.id', '=', 'visits.organization')
            ->leftjoin('groups', 'groups.id', '=', 'visits.service_emp_visited')
            ->leftjoin('users', 'users.id', '=', 'visits.emp_visited')
            ->wheredate('entry_date', db::raw('CURDATE()'))
            ->where('visits.is_deleted', '=', 0)
            ->orderByDesc('entry_date')->get();

            $visits_old = db::table('visits')->selectRaw('visits.id,badge_n,visits.is_deleted,organisations.name as org_name,visitors.firstname,status,visitors.lastname,entry_date,users.name as emp_visited,groups.group_name as service_name')
            ->leftjoin('visitors', 'visitors.id', '=', 'visits.visitor')
            ->leftjoin('organisations', 'organisations.id', '=', 'visits.organization')
            ->leftjoin('groups', 'groups.id', '=', 'visits.service_emp_visited')
            ->leftjoin('users', 'users.id', '=', 'visits.emp_visited')
            ->whereraw('entry_date < CURDATE()')
            ->whereIn('status', [0, 3])
            ->where('visits.is_deleted', '=', 0)
            ->orderByDesc('entry_date')->get();



        return view('Service.visitors', ['url' => 'guest'], ['data' => $visits, 'old' => $visits_old]);
    }

    public function index_8()
    {
        $visits = db::table('visits')->selectRaw('visits.id,badge_n,visits.is_deleted,organisations.name as org_name,visitors.firstname,status,visitors.lastname,entry_date,users.name as emp_visited,groups.group_name as service_name')
            ->leftjoin('visitors', 'visitors.id', '=', 'visits.visitor')
            ->leftjoin('organisations', 'organisations.id', '=', 'visits.organization')
            ->leftjoin('groups', 'groups.id', '=', 'visits.service_emp_visited')
            ->leftjoin('users', 'users.id', '=', 'visits.emp_visited')
            ->wheredate('entry_date', db::raw('CURDATE()'))
            ->where('visits.is_deleted', '=', 0)
            ->orderBy('entry_date')->get();

        $visits_old = db::table('visits')->selectRaw('visits.id,badge_n,visits.is_deleted,organisations.name as org_name,visitors.firstname,status,visitors.lastname,entry_date,users.name as emp_visited,groups.group_name as service_name')
            ->leftjoin('visitors', 'visitors.id', '=', 'visits.visitor')
            ->leftjoin('organisations', 'organisations.id', '=', 'visits.organization')
            ->leftjoin('groups', 'groups.id', '=', 'visits.service_emp_visited')
            ->leftjoin('users', 'users.id', '=', 'visits.emp_visited')
            ->whereraw('entry_date < CURDATE()')
            ->whereIn('status', [0, 3])
            ->where('visits.is_deleted', '=', 0)
            ->orderByDesc('entry_date')->get();

        return view('Service.visitors', ['url' => 'guest'], ['data' => $visits, 'old' => $visits_old]);
    }

    public function index_4()
    {
        $serviceIds = ug::where('a_user', '=', Auth::guard('web')->user()->id)->pluck('a_group');
        $headServiceIds = ug::where('a_user', '=', Auth::guard('web')->user()->id)
            ->where('is_head', '=', 1)
            ->pluck('a_group');
        $isAssignmentAgent = $this->isServiceAssignmentAgent();
        $assignmentServiceId = $this->serviceAssignmentGroupId();

        $visibleScope = function ($query) use ($headServiceIds, $isAssignmentAgent, $assignmentServiceId) {
            $query->where('visits.emp_visited', '=', Auth::guard('web')->user()->id)
                ->orWhere(function ($query) use ($headServiceIds, $isAssignmentAgent, $assignmentServiceId) {
                    if ($isAssignmentAgent) {
                        $query->where('visits.service_emp_visited', '=', $assignmentServiceId)
                            ->whereNull('visits.emp_visited');
                        return;
                    }

                    $query->whereIn('visits.service_emp_visited', $headServiceIds)
                        ->whereNull('visits.emp_visited');
                });
        };

        $select = 'visits.id,badge_n,visits.is_deleted,organisations.name as org_name,visitors.firstname,status,visitors.lastname,entry_date,users.name as emp_visited,groups.group_name as service_name';

        $visits = db::table('visits')->selectRaw($select)
            ->leftjoin('visitors', 'visitors.id', '=', 'visits.visitor')
            ->leftjoin('organisations', 'organisations.id', '=', 'visits.organization')
            ->leftjoin('groups', 'groups.id', '=', 'visits.service_emp_visited')
            ->leftjoin('users', 'users.id', '=', 'visits.emp_visited')
            ->wheredate('entry_date', db::raw('CURDATE()'))
            ->where('visits.is_deleted', '=', 0)
            ->where($visibleScope)
            ->orderByDesc('entry_date')->get();

        $visits_old = db::table('visits')->selectRaw($select)
            ->leftjoin('visitors', 'visitors.id', '=', 'visits.visitor')
            ->leftjoin('organisations', 'organisations.id', '=', 'visits.organization')
            ->leftjoin('groups', 'groups.id', '=', 'visits.service_emp_visited')
            ->leftjoin('users', 'users.id', '=', 'visits.emp_visited')
            ->whereraw('entry_date < CURDATE()')
            ->whereIn('status', [0, 1, 3])
            ->where('visits.is_deleted', '=', 0)
            ->where($visibleScope)
            ->orderByDesc('entry_date')->get();

        return view('Service.visitors', ['url' => 'guest'], ['data' => $visits, 'old' => $visits_old]);
    }

    public function index_2()
    {
        $visits = db::table('visits')->selectRaw('visits.id,visits.is_deleted,organisations.name as org_name,visitors.firstname,status,visitors.lastname,entry_date,users.name as emp_visited,groups.group_name as service_name')
            ->leftjoin('visitors', 'visitors.id', '=', 'visits.visitor')
            ->leftjoin('organisations', 'organisations.id', '=', 'visits.organization')
            ->leftjoin('groups', 'groups.id', '=', 'visits.service_emp_visited')
            ->leftjoin('users', 'users.id', '=', 'visits.emp_visited')
            ->wheredate('entry_date', db::raw('CURDATE()'))
            ->where('visits.is_deleted', '=', 0)
            ->orderByDesc('entry_date')->get();
        return view('President.visitors', ['url' => 'guest'], ['data' => $visits]);
    }

    public function index_9()
    {
        $ddmServiceId = 19;
        $serviceIds = ug::where('a_user', '=', Auth::guard('web')->user()->id)->pluck('a_group');

        $visits = db::table('visits')->selectRaw('visits.id,badge_n,visits.is_deleted,organisations.name as org_name,visitors.firstname,status,visitors.lastname,entry_date,users.name as emp_visited,groups.group_name as service_name')
            ->leftjoin('visitors', 'visitors.id', '=', 'visits.visitor')
            ->leftjoin('organisations', 'organisations.id', '=', 'visits.organization')
            ->leftjoin('groups', 'groups.id', '=', 'visits.service_emp_visited')
            ->leftjoin('users', 'users.id', '=', 'visits.emp_visited')
            ->whereDate('entry_date', db::raw('CURDATE()'))
            ->where('visits.is_deleted', '=', 0)
            ->where('visits.service_emp_visited', '=', $ddmServiceId)
            ->where(function ($query) use ($serviceIds, $ddmServiceId) {
                $query->whereNull('visits.emp_visited')
                    ->orWhere('visits.emp_visited', '=', Auth::guard('web')->user()->id)
                    ->orWhere(function ($query) use ($ddmServiceId) {
                        $query->where('visits.service_emp_visited', '=', $ddmServiceId);
                    });
            })
            ->orderByDesc('entry_date')
            ->get();

        $visits_old = db::table('visits')->selectRaw('visits.id,badge_n,visits.is_deleted,organisations.name as org_name,visitors.firstname,status,visitors.lastname,entry_date,users.name as emp_visited,groups.group_name as service_name')
            ->leftjoin('visitors', 'visitors.id', '=', 'visits.visitor')
            ->leftjoin('organisations', 'organisations.id', '=', 'visits.organization')
            ->leftjoin('groups', 'groups.id', '=', 'visits.service_emp_visited')
            ->leftjoin('users', 'users.id', '=', 'visits.emp_visited')
            ->whereRaw('entry_date < CURDATE()')
            ->where('visits.is_deleted', '=', 0)
            ->where('visits.service_emp_visited', '=', $ddmServiceId)
            ->orderByDesc('entry_date')
            ->get();

        return view('Service.visitors', ['url' => 'guest'], ['data' => $visits, 'old' => $visits_old]);
    }
    public function index_2_ant()
    {
        $antenne_visits = db::table('antenne_visits')->selectRaw('antenne_visits.id,antenne_visits.is_deleted,organisations.name as org_name,antenne_visitors.firstname,status,antenne_visitors.lastname,entry_date,users.name as emp_visited,antennes.antenne_name as service_name')
            ->leftjoin('antenne_visitors', 'antenne_visitors.id', '=', 'antenne_visits.visitor')
            ->leftjoin('organisations', 'organisations.id', '=', 'antenne_visits.organization')
            ->leftjoin('antennes', 'antennes.id', '=', 'antenne_visits.ant_location')
            ->leftjoin('users', 'users.id', '=', 'antenne_visits.emp_visited')
            ->wheredate('entry_date', db::raw('CURDATE()'))
            ->where('antenne_visits.is_deleted', '=', 0)
            ->orderByDesc('entry_date')->get();




    return view('President.visitors_ant', ['url' => 'guest_ant'],
	    ['data' => $antenne_visits]);
    }



    public function add_index()
    {

        $cats = db::table('categories')->selectRaw('id,name')->get();
        $id_types = db::table('id_types')->selectRaw('id,name')->get();
        $services = db::table('groups')->selectRaw('id,group_name as name')->get();
        $roles = db::table('positions')->selectRaw('id,name')->get();
        $cur_date = Carbon::now()->toDateTimeString();
        $cur_date = Carbon::createFromFormat('Y-m-d H:i:s', $cur_date)->format('Y-m-d\TH:i');
        if (Auth::guard('web')->user()->profile == 6) {
            $loc = "";
        } else {
            $loc = "";
        }
        return view("Reception.add_index")
            ->with('url', 'guest')
            ->with('cats', $cats)
            ->with('id_types', $id_types)
            ->with('services', $services)
            ->with('roles', $roles)
            ->with('cur_date', $cur_date);
    }

    public function ant_add_index()
    {
        $ant_id = ant_user::where('ant_user', '=', Auth::guard('web')->user()->id)->get();
        $ant_loc = antennes::where('id', '=', $ant_id[0]['ant_group'])->get();

        $cats = db::table('categories')->selectRaw('id,name')->get();
        $id_types = db::table('id_types')->selectRaw('id,name')->get();
        $roles = db::table('positions')->selectRaw('id,name')->get();
        $cur_date = Carbon::now()->toDateTimeString();
        $cur_date = Carbon::createFromFormat('Y-m-d H:i:s', $cur_date)->format('Y-m-d\TH:i');

        return view("Antenne_reception.add_index")
            ->with('url', 'guest')
            ->with('loc', $ant_loc[0]['antenne_name'])
            ->with('cats', $cats)
            ->with('id_types', $id_types)
            ->with('roles', $roles)
            ->with('cur_date', $cur_date);
    }



    public function ant_edit_index(Request $request, $id)
    {
        $ant_id = ant_user::where('ant_user', '=', Auth::guard('web')->user()->id)->get();
        $ant_loc = antennes::where('id', '=', $ant_id[0]['ant_group'])->get();
        $visits = db::table('antenne_visits')
            ->selectRaw('antenne_visitors.firstname,antenne_visitors.lastname,category,status,antenne_visitors.lastname,entry_date,users.name as usrname, organisations.name as org_name, antenne_visitors.id_type as id_type')
            ->leftjoin('antenne_visitors', 'antenne_visitors.id', '=', 'antenne_visits.visitor')
            ->leftjoin('organisations', 'antenne_visits.organization', '=', 'organisations.id')
            ->leftjoin('id_types', 'antenne_visitors.id_type', '=', 'id_types.id')
            ->leftjoin('antennes', 'antennes.id', '=', 'antenne_visits.ant_location')
            ->leftjoin('users', 'users.id', '=', 'antenne_visits.emp_visited')
            ->where('antenne_visits.id', '=', $id)->get();
        $cats = db::table('categories')->selectRaw('id,name')->get();
        $id_types = db::table('id_types')->selectRaw('id,name')->get();
        return view('Antenne_reception.edit_index')
            ->with('data', $visits)
            ->with('url', 'guest')
            ->with('cats', $cats)
            ->with('loc', $ant_loc[0]['antenne_name'])
            ->with('id_types', $id_types);
    }



    public function edit_index(Request $request, $id)
    {
        if (Auth::guard('web')->user()->profile == 6) {
            return $this->ant_edit_index($request, $id);
        }
        if (Auth::guard('web')->user()->profile == 7) {
            return $this->ant_service_edit_index($request, $id);
        }

        $visits = db::table('visits')
            ->selectRaw('visitors.firstname,visitors.lastname,category,status,badge_n,visitors.lastname,entry_date,users.name as usrname,groups.group_name as service_name,groups.id as service_id, organisations.name as org_name, visitors.id_type as id_type, emp_visited')
            ->leftjoin('visitors', 'visitors.id', '=', 'visits.visitor')
            ->leftjoin('organisations', 'visits.organization', '=', 'organisations.id')
            ->leftjoin('id_types', 'visitors.id_type', '=', 'id_types.id')
            ->leftjoin('groups', 'groups.id', '=', 'visits.service_emp_visited')
            ->leftjoin('users', 'users.id', '=', 'visits.emp_visited')

            ->where('visits.id', '=', $id)->get();
        if ($visits->isEmpty()) {
            abort(404);
        }

        $profile = (int) Auth::guard('web')->user()->profile;
        if ($profile === 8 && in_array((int) $visits[0]->status, [2, 3], true)) {
            abort(403);
        }
        if (in_array($profile, [3, 4], true)) {
            $serviceIds = ug::where('a_user', '=', Auth::guard('web')->user()->id)->pluck('a_group')->toArray();
            $isAssignmentAgent = $this->isServiceAssignmentAgent();
            if ((!$isAssignmentAgent && !in_array((int) $visits[0]->service_id, array_map('intval', $serviceIds), true)) || !is_null($visits[0]->emp_visited)) {
                abort(403);
            }
            if ($profile === 4 && !$isAssignmentAgent && !$this->isServiceHead(Auth::guard('web')->user()->id, $visits[0]->service_id)) {
                abort(403);
            }
        }
        $cats = db::table('categories')->selectRaw('id,name')->get();
        $id_types = db::table('id_types')->selectRaw('id,name')->get();
        $services = group::get(['id', 'group_name']);
        $serviceUsers = collect();
        if (in_array($profile, [3, 4], true)) {
            $serviceUsers = ug::select('users.id', 'users.name')
                ->leftjoin('users', 'users.id', '=', 'user_groups.a_user')
                ->where('user_groups.a_group', '=', $visits[0]->service_id)
                ->get();
        } elseif ($profile === 9) {
            $serviceUsers = ug::select('users.id', 'users.name')
                ->leftjoin('users', 'users.id', '=', 'user_groups.a_user')
                ->where('user_groups.a_group', '=', $this->serviceAssignmentGroupId())
                ->get();
        }
        return view('Reception.edit_index')
            ->with('data', $visits)
            ->with('url', 'guest')
            ->with('cats', $cats)
            ->with('id_types', $id_types)
            ->with('services', $services)
            ->with('serviceUsers', $serviceUsers);
    }

    public function ant_edit(Request $request, $id)
    {
        if (Auth::guard('web')->user()->profile == 7) {
            return $this->ant_service_edit($request, $id);
        }

        $visitor_valid = $request->validate([
            'fname' => ['required', 'bail'],
            'lname' => ['required', 'bail'],
            'org' => ['nullable'],
            'category' => ['required', 'bail']
        ]);

        if (!is_null($visitor_valid['org'])) {

            $org = organisation::where('name', '=', $request->org)->get();
            if ($org->isnotempty()) {
                $org_id = $org[0]->id;
            }
            if ($org->count() == 0) {
                $org = organisation::create([
                    'name' => $request->org
                ]);
                $org_id = $org->id;
            }
        } else {
            $org_id = null;
        }

        db::table('antenne_visits')->where('id', '=', $id)
            ->update([
                'category' => $request->category,
                'organization' => $org_id,
                'status' => $request->status
            ]);
        $visitor_id = db::table('antenne_visits')->selectRaw('visitor')->where('id', '=', $id)->get();
        db::table('antenne_visitors')->where('id', '=', $visitor_id[0]->visitor)
            ->update([
                'firstname' => $request->fname,
                'id_type' => $request->alt_type,
                'lastname' => $request->lname
            ]);

        if ($request->status == 2 && !is_null($request->exitdate)) {
            $request->validate([
                'exitdate' => ['required'],
            ]);
            db::table('antenne_visits')->where('id', '=', $id)
                ->update([
                    'exit_date' => $request->exitdate

                ]);
        }
        return redirect()->route('i_visitors');
    }

    public function edit(Request $request, $id)
    {
        //        if (!is_null($request->hostname)){
        if (in_array((int) Auth::guard('web')->user()->profile, [6, 7], true)) {
            return $this->ant_edit($request, $id);
        }
        $profile = (int) Auth::guard('web')->user()->profile;

        if ($profile === 8) {
            $valid = $request->validate([
                'service' => ['required'],
            ]);

            $visit = db::table('visits')->where('id', '=', $id)->where('is_deleted', '=', 0)->first();
            if (!$visit || in_array((int) $visit->status, [2, 3], true)) {
                abort(403);
            }

            $updated = db::table('visits')
                ->where('id', '=', $id)
                ->where('is_deleted', '=', 0)
                ->whereNotIn('status', [2, 3])
                ->update([
                    'service_emp_visited' => $valid['service'],
                    'emp_visited' => null,
                ]);

            if (!$updated) {
                abort(403);
            }

            $this->auditVisit($id, 'orientation_updated', [
                'service_emp_visited' => $visit->service_emp_visited,
                'emp_visited' => $visit->emp_visited,
            ], [
                'service_emp_visited' => $valid['service'],
                'emp_visited' => null,
            ]);

            return redirect()->route('i_visitors');
        }

        if (in_array($profile, [3, 4], true)) {
            $valid = $request->validate([
                'hostname' => ['required'],
            ]);

            $visit = db::table('visits')->where('id', '=', $id)->where('is_deleted', '=', 0)->first();
            if (!$visit || !is_null($visit->emp_visited)) {
                abort(403);
            }

            $serviceIds = ug::where('a_user', '=', Auth::guard('web')->user()->id)->pluck('a_group')->toArray();
            $isAssignmentAgent = $this->isServiceAssignmentAgent();
            if ($isAssignmentAgent && (int) $visit->service_emp_visited !== $this->serviceAssignmentGroupId()) {
                abort(403);
            }
            if (!$isAssignmentAgent && !in_array((int) $visit->service_emp_visited, array_map('intval', $serviceIds), true)) {
                abort(403);
            }
            if ($profile === 4 && !$isAssignmentAgent && !$this->isServiceHead(Auth::guard('web')->user()->id, $visit->service_emp_visited)) {
                abort(403);
            }
            $hostInService = ug::where('a_group', '=', $visit->service_emp_visited)
                ->where('a_user', '=', $valid['hostname'])
                ->exists();
            if (!$hostInService) {
                abort(403);
            }

            db::table('visits')->where('id', '=', $id)
                ->update([
                    'emp_visited' => $valid['hostname'],
                ]);

            $this->auditVisit($id, 'host_assigned_by_service', [
                'emp_visited' => $visit->emp_visited,
            ], [
                'emp_visited' => $valid['hostname'],
            ]);

            return redirect()->route('l_index');
        }

        if ($profile === 9) {
            $valid = $request->validate([
                'hostname' => ['required'],
                'status' => ['required', 'integer', 'in:1,2,3'],
            ]);

            $visit = DB::table('visits')->where('id', '=', $id)->where('is_deleted', '=', 0)->first();
            if (!$visit || !is_null($visit->emp_visited)) {
                abort(403);
            }

            if ((int) $visit->service_emp_visited !== $this->serviceAssignmentGroupId()) {
                abort(403);
            }

            $hostInService = ug::where('a_group', '=', $this->serviceAssignmentGroupId())
                ->where('a_user', '=', $valid['hostname'])
                ->exists();
            if (!$hostInService) {
                abort(403);
            }

            $updates = [
                'emp_visited' => $valid['hostname'],
                'status' => (int) $valid['status'],
            ];

            if ((int) $valid['status'] === 1 && empty($visit->accept_time)) {
                $updates['accept_time'] = Carbon::now();
            }

            if ((int) $valid['status'] === 3 && empty($visit->sendup_time)) {
                $updates['sendup_time'] = Carbon::now();
            }

            if ((int) $valid['status'] === 2) {
                $updates['exit_date'] = Carbon::now();
                $updates['validation_time'] = Carbon::now();
                $updates['validation_by'] = $userId;
            }

            DB::table('visits')->where('id', '=', $id)->update($updates);

            $this->auditVisit($id, 'ddm_visit_assigned', [
                'emp_visited' => $visit->emp_visited,
                'status' => $visit->status,
            ], $updates);

            return redirect()->route('home');
        }

        $oldVisit = db::table('visits')->where('id', '=', $id)->first();
        $visitor_valid = $request->validate([
            'fname' => ['required', 'bail'],
            'lname' => ['required', 'bail'],
            'org' => ['nullable'],
            'hostname' => ['nullable'],
            'service' => ['required'],
            'badge_n' => ['nullable', 'max:100'],
            'category' => ['required', 'bail']
        ]);

        if (!is_null($visitor_valid['org'])) {

            $org = organisation::where('name', '=', $request->org)->get();
            if ($org->isnotempty()) {
                $org_id = $org[0]->id;
            }
            if ($org->count() == 0) {
                $org = organisation::create([
                    'name' => $request->org
                ]);
                $org_id = $org->id;
            }
        } else {
            $org_id = null;
        }

        db::table('visits')->where('id', '=', $id)
            ->update([
                'category' => $request->category,
                'organization' => $org_id,
                'service_emp_visited' => $request->service,
                'emp_visited' => $request->hostname,
                'badge_n' => $request->badge_n,
                'status' => $request->status
            ]);
        $this->auditVisit($id, 'visit_updated', [
            'category' => $oldVisit->category ?? null,
            'organization' => $oldVisit->organization ?? null,
            'service_emp_visited' => $oldVisit->service_emp_visited ?? null,
            'emp_visited' => $oldVisit->emp_visited ?? null,
            'badge_n' => $oldVisit->badge_n ?? null,
            'status' => $oldVisit->status ?? null,
        ], [
            'category' => $request->category,
            'organization' => $org_id,
            'service_emp_visited' => $request->service,
            'emp_visited' => $request->hostname,
            'badge_n' => $request->badge_n,
            'status' => $request->status,
        ]);
        $visitor_id = db::table('visits')->selectRaw('visitor')->where('id', '=', $id)->get();
        db::table('visitors')->where('id', '=', $visitor_id[0]->visitor)
            ->update([
                'firstname' => $request->fname,
                'id_type' => $request->alt_type,
                'lastname' => $request->lname
            ]);

        if ($request->status == 2 && !is_null($request->exitdate)) {
            $request->validate([
                'exitdate' => ['required'],
            ]);
            db::table('visits')->where('id', '=', $id)
                ->update([
                    'exit_date' => $request->exitdate,
                    'validation_time' => Carbon::now(),
                    'validation_by' => Auth::guard('web')->user()->id

                ]);
        }
        if ($request->status == 3) {
            db::table('visits')->where('id', '=', $id)
                ->whereNull('sendup_time')
                ->update([
                    'sendup_time' => Carbon::now()
                ]);
        }
        return redirect()->route('i_visitors');
    }

    public function workflow(Request $request, $id)
    {
        $valid = $request->validate([
            'status' => ['required', 'integer', 'in:1,2,3'],
        ]);

        $profile = (int) Auth::guard('web')->user()->profile;
        $userId = Auth::guard('web')->user()->id;
        $nextStatus = (int) $valid['status'];

        if ($profile === 7) {
            $visit = DB::table('antenne_visits')->where('id', '=', $id)->where('is_deleted', '=', 0)->first();
            if (!$visit || (int) $visit->emp_visited !== (int) $userId || !in_array($nextStatus, [1, 2], true)) {
                abort(403);
            }

            $updates = ['status' => $nextStatus];
            if ($nextStatus === 2) {
                $updates['exit_date'] = Carbon::now();
            }

            DB::table('antenne_visits')->where('id', '=', $id)->update($updates);

            return redirect()->back();
        }

        $visit = DB::table('visits')->where('id', '=', $id)->where('is_deleted', '=', 0)->first();
        if (!$visit) {
            abort(404);
        }

        if ($profile == 4 && ((int) $visit->emp_visited !== (int) $userId || !in_array($nextStatus, [1, 3], true))) {
            abort(403);
        }

        if ($profile === 9) {
            if ((int) $visit->emp_visited !== (int) $userId || !in_array($nextStatus, [1, 2, 3], true)) {
                abort(403);
            }

            $updates = ['status' => $nextStatus];
            if ($nextStatus === 1 && empty($visit->accept_time)) {
                $updates['accept_time'] = Carbon::now();
            }
            if ($nextStatus === 3 && empty($visit->sendup_time)) {
                $updates['sendup_time'] = Carbon::now();
            }
            if ($nextStatus === 2) {
                $updates['exit_date'] = Carbon::now();
                $updates['validation_time'] = Carbon::now();
                $updates['validation_by'] = $userId;
            }

            DB::table('visits')->where('id', '=', $id)->update($updates);

            return redirect()->back();
        }

        if ($profile == 5 && $nextStatus !== 2) {
            abort(403);
        }

        if (!in_array($profile, [4, 5], true)) {
            abort(403);
        }

        $updates = ['status' => $nextStatus];

        if ($nextStatus === 1 && empty($visit->accept_time)) {
            $updates['accept_time'] = Carbon::now();
        }

        if ($nextStatus === 3 && empty($visit->sendup_time)) {
            $updates['sendup_time'] = Carbon::now();
        }

        if ($nextStatus === 2) {
            $updates['exit_date'] = Carbon::now();
            $updates['validation_time'] = Carbon::now();
            $updates['validation_by'] = $userId;
        }

        DB::table('visits')->where('id', '=', $id)->update($updates);

        $this->auditVisit($id, 'workflow_status_updated', [
            'status' => $visit->status,
            'exit_date' => $visit->exit_date ?? null,
            'accept_time' => $visit->accept_time ?? null,
            'sendup_time' => $visit->sendup_time ?? null,
        ], $updates);

        return redirect()->back();
    }

    public function store_antenne(Request $request)
    {
        if ($request->new_visitor && !$request->exists) {
            $valid = $request->validate([
                'fname' => ['required', 'bail'],
                'lname' => ['required', 'bail'],
                'category' => ['required', 'bail'],
                'org' => ['nullable'],
                'role' => ['required'],
                'other_value' => ['nullable'],
                'permet' => ['nullable'],
                'date_entry' => ['required', 'bail'],
                'id_cat' => ['required', 'bail'],
                'cin' => ['required', 'bail'],
                'nin' => ['nullable'],
                'hostname' => ['nullable'],
                'files' => [File::types(['jpg', 'jpeg', 'png']), 'nullable'],
            ]);
            if (!is_null($request->org)) {
                $org = organisation::where('name', '=', $request->org)->get();
                if ($org->isnotempty()) {
                    $org_out = $org[0]->id;
                }
                if ($org->isempty()) {
                    $org = organisation::create([
                        'name' => $valid['org']
                    ]);
                    $org_out = $org->id;
                }
                if ($request->role == "other") {
                    if (!is_null($request->other_value)) {
                        $pos_exists = DB::table('positions')->select('id', 'name')->whereraw('name like "' . $request->other_value . '"')->first();
                        if ($pos_exists) {
                            $position = $pos_exists->id;
                        } else {
                            $new_pos = db::table('positions')->insertGetId([
                                'name' => $request->other_value
                            ]);
                            $position = $new_pos;
                        }
                    }
                } else {
                    $position = $request->role;
                }
            } else {
                $org_out = null;
                $position = null;
            }


            $visitorData = [
                'firstname' => $valid['fname'],
                'lastname' => $valid['lname'],
                'position' => $position,
                'id_type' => $valid['id_cat'],
                'cin' => $valid['cin'],
            ];
            if (Schema::hasColumn('antenne_visitors', 'nin')) {
                $visitorData['nin'] = $valid['nin'];
            }
            $visitor_id = ant_visitors::create($visitorData);
            $ant_id = ant_user::where('ant_user', '=', Auth::guard('web')->user()->id)->get();
            $visit = ant_visits::create([
                'visitor' => $visitor_id->id,
                'category' => $valid['category'],
                'subject' => $valid['subject'],
                'organization' => $org_out,
                'entry_date' => $valid['date_entry'],
                'emp_visited' => $valid['hostname'],
                'ant_location' => $ant_id[0]['ant_group'],
                'status' => 0,
            ]);
            if (!is_null($request->permets)) {
                $data = explode(",", $request->permets);
                foreach ($data as $row) {
                    $permet = db::table('permet_minier')->select('id')->where('designation', '=', $row)->first();
                    if (!$permet) {
                        $permet = db::table('permet_minier')->insertGetId([
                            'designation' => $row
                        ]);
                        if ($org_out) {
                            db::table('organisation_permet')->insert([
                                'organisation_id' => $org_out,
                                'permet_id' => $permet
                            ]);
                        }
                    } else {
                        $permet = $permet->id;
                    }
                    db::table('antenne_visits_permet')->insert([
                        'permet' => $permet,
                        'visit' => $visit->id
                    ]);
                }
            }
            return redirect()->route('i_visitors');
        } elseif ($request->exists) {
            $valid = $request->validate([
                'user' => ['nullable'],
                'category' => ['required', 'bail'],
                'subject' => ['nullable'],
                'org' => ['nullable'],
                'date_entry' => ['required', 'bail'],
                'hostname' => ['nullable'],
                'fname' => ['nullable'],
                'lname' => ['nullable'],
                'cin' => ['nullable'],
                'nin' => ['nullable'],
                'id_cat' => ['nullable'],
            ]);
            $valid['user'] = $this->resolveVisitorIdForExisting('antenne_visitors', $valid);
            if (empty($valid['user'])) {
                return back()->with('error', 'Visiteur existant introuvable. Relisez la carte ou selectionnez le visiteur.');
            }
            if (!is_null($request->org)) {
                $org = organisation::where('name', '=', $request->org)->get();
                if ($org->isnotempty()) {
                    $org_out = $org[0]->id;
                }
                if ($org->isempty()) {
                    $org = organisation::create([
                        'name' => $valid['org']
                    ]);
                    $org_out = $org->id;
                }
            } else {
                $org_out = null;
            }

            $ant_id = ant_user::where('ant_user', '=', Auth::guard('web')->user()->id)->get();
            ant_visits::create([
                'visitor' => $valid['user'],
                'category' => $valid['category'],
                'organization' => $org_out,
                'subject' => $valid['subject'],
                'entry_date' => $valid['date_entry'],
                'emp_visited' => $valid['hostname'],
                'ant_location' => $ant_id[0]['ant_group'],
                'status' => 0,
            ]);

            return redirect()->route('i_visitors');
        }
    }

    public function find_card_visitor(Request $request)
    {
        $nin = trim((string) $request->query('nin', ''));
        $cin = trim((string) $request->query('cin', ''));
        $idCat = trim((string) $request->query('id_cat', ''));
        $table = Auth::guard('web')->user()->profile == 6 ? 'antenne_visitors' : 'visitors';

        $select = ['id', 'firstname', 'lastname', 'cin', 'id_type'];
        if (Schema::hasColumn($table, 'nin')) {
            $select[] = 'nin';
        }

        $query = DB::table($table)
            ->select($select)
            ->where('is_deleted', '=', 0);

        if ($nin !== '' && Schema::hasColumn($table, 'nin')) {
            $query->where('nin', '=', $nin);
        } elseif ($cin !== '') {
            $query->where('cin', '=', $cin);
        } else {
            return response()->json(['found' => false]);
        }

        if ($idCat !== '' && ctype_digit($idCat)) {
            $query->where('id_type', '=', (int) $idCat);
        }

        $visitor = $query->first();
        if (!$visitor && $nin !== '' && $cin !== '') {
            $fallbackQuery = DB::table($table)
                ->select($select)
                ->where('is_deleted', '=', 0)
                ->where('cin', '=', $cin);

            if ($idCat !== '' && ctype_digit($idCat)) {
                $fallbackQuery->where('id_type', '=', (int) $idCat);
            }

            $visitor = $fallbackQuery->first();
        }

        if (!$visitor) {
            return response()->json(['found' => false]);
        }

        return response()->json([
            'found' => true,
            'visitor' => [
                'id' => $visitor->id,
                'fullname' => trim($visitor->firstname . ' ' . $visitor->lastname),
                'firstName' => $visitor->firstname,
                'lastName' => $visitor->lastname,
                'cin' => $visitor->cin,
                'nin' => $visitor->nin ?? null,
                'idType' => $visitor->id_type,
            ],
        ]);
    }

    private function resolveVisitorIdForExisting(string $table, array $valid)
    {
        if (!empty($valid['user'])) {
            return $valid['user'];
        }

        $nin = trim((string)($valid['nin'] ?? ''));
        if ($nin !== '' && Schema::hasColumn($table, 'nin')) {
            $visitor = DB::table($table)
                ->where('is_deleted', '=', 0)
                ->where('nin', '=', $nin)
                ->first(['id']);
            if ($visitor) {
                return $visitor->id;
            }
        }

        $cin = trim((string)($valid['cin'] ?? ''));
        if ($cin !== '') {
            $query = DB::table($table)
                ->where('is_deleted', '=', 0)
                ->where('cin', '=', $cin);

            $idCat = trim((string)($valid['id_cat'] ?? ''));
            if ($idCat !== '' && ctype_digit($idCat)) {
                $query->where('id_type', '=', (int) $idCat);
            }

            $visitor = $query->first(['id']);
            if ($visitor) {
                return $visitor->id;
            }
        }

        return null;
    }

    public function store(Request $request)
    {
        if (Auth::guard('web')->user()->profile == 6) {
            return $this->store_antenne($request);
        }
        if (Auth::guard('web')->user()->profile != 5) {
            abort(403);
        }
        //new user with host
        if ($request->new_visitor && !$request->exists) {
            $valid = $request->validate([
                'fname' => ['required', 'bail'],
                'lname' => ['required', 'bail'],
                'category' => ['required', 'bail'],
                'org' => ['nullable'],
                'role' => ['required'],
                'other_value' => ['nullable'],
                'date_entry' => ['required', 'bail'],
                'id_cat' => ['required', 'bail'],
                'cin' => ['required', 'bail'],
                'nin' => ['required', 'bail'],
                'hostname' => ['nullable'],
                'service' => ['nullable'],
                'badge_n' => ['required', 'max:100'],
                'subject' => ['nullable', 'max:255'],
                'permets' => ['nullable'],
                'files' => [File::types(['jpg', 'jpeg', 'png']), 'nullable'],
            ], [
                'fname.required' => 'Le nom est obligatoire.',
                'lname.required' => 'Le prenom est obligatoire.',
                'cin.required' => 'Le numero de piece est obligatoire.',
                'nin.required' => 'Le NIN est obligatoire.',
                'badge_n.required' => 'Le numero de badge est obligatoire.',
                'category.required' => 'Le type de visite est obligatoire.',
                'date_entry.required' => "L'heure d'entree est obligatoire.",
            ]);

            if (!is_null(request('files')) && request('files')->isvalid()) {
                $path = request('files')->store('public/scans');
                $add_att = attach::create([
                    'filepath' => $path
                ]);
                $att = $add_att->id;
            } else {
                $att = null;
            }
            if (!is_null($request->org)) {
                $org = organisation::where('name', '=', $request->org)->get();
                if ($org->isnotempty()) {
                    $org_out = $org[0]->id;
                }
                if ($org->isempty()) {
                    $org = organisation::create([
                        'name' => $valid['org']
                    ]);
                    $org_out = $org->id;
                }
                if ($request->role == "other") {
                    if (!is_null($request->other_value)) {
                        $pos_exists = DB::table('positions')->select('id', 'name')->whereraw('name like "' . $request->other_value . '"')->first();
                        if ($pos_exists) {
                            $position = $pos_exists->id;
                        } else {
                            $new_pos = db::table('positions')->insertGetId([
                                'name' => $request->other_value
                            ]);
                            $position = $new_pos;
                        }
                    }
                } else {
                    $position = $request->role;
                }
            } else {
                $org_out = null;
                $position = null;
            }




            $visitorData = [
                'firstname' => $valid['fname'],
                'lastname' => $valid['lname'],
                'position' => $position,
                'id_type' => $valid['id_cat'],
                'cin' => $valid['cin'],
            ];
            if (Schema::hasColumn('visitors', 'nin')) {
                $visitorData['nin'] = $valid['nin'];
            }
            $visitor_id = visitor::create($visitorData);
            $visit = visit::create([
                'visitor' => $visitor_id->id,
                'category' => $valid['category'],
                'subject' => $valid['subject'],
                'organization' => $org_out,
                'observations' => $request->observations,
                'entry_date' => $valid['date_entry'],
                'emp_visited' => null,
                'service_emp_visited' => null,
                'badge_n' => $valid['badge_n'],
                'status' => 0,
            ]);
            $this->auditVisit($visit->id, 'visit_created_by_reception', null, [
                'visitor' => $visitor_id->id,
                'category' => $valid['category'],
                'subject' => $valid['subject'],
                'organization' => $org_out,
                'entry_date' => $valid['date_entry'],
                'badge_n' => $valid['badge_n'],
                'status' => 0,
            ]);
            if (!is_null($request->permets)) {
                $data = explode(",", $request->permets);
                foreach ($data as $row) {
                    $permet = db::table('permet_minier')->select('id')->where('designation', '=', $row)->first();
                    if (!$permet) {
                        $permet = db::table('permet_minier')->insertGetId([
                            'designation' => $row
                        ]);
                        if ($org_out) {
                            db::table('organisation_permet')->insert([
                                'organisation_id' => $org_out,
                                'permet_id' => $permet
                            ]);
                        }
                    } else {
                        $permet = $permet->id;
                    }
                    db::table('visits_permet')->insert([
                        'permet' => $permet,
                        'visit' => $visit->id
                    ]);
                }
            }

            return redirect()->route('i_visitors');
        } elseif ($request->exists) {
            $valid = $request->validate([
                'user' => ['nullable'],
                'category' => ['required', 'bail'],
                'subject' => ['nullable'],
                'org' => ['nullable'],
                'date_entry' => ['required', 'bail'],
                'hostname' => ['nullable'],
                'service' => ['nullable'],
                'badge_n' => ['required', 'max:100'],
                'fname' => ['nullable'],
                'lname' => ['nullable'],
                'cin' => ['nullable'],
                'nin' => ['nullable'],
                'id_cat' => ['nullable'],
            ]);
            $valid['user'] = $this->resolveVisitorIdForExisting('visitors', $valid);
            if (empty($valid['user'])) {
                return back()->with('error', 'Visiteur existant introuvable. Relisez la carte ou selectionnez le visiteur.');
            }
            if (!is_null($request->org)) {
                $org = organisation::where('name', '=', $request->org)->get();
                if ($org->isnotempty()) {
                    $org_out = $org[0]->id;
                }
                if ($org->isempty()) {
                    $org = organisation::create([
                        'name' => $valid['org']
                    ]);
                    $org_out = $org->id;
                }
            } else {
                $org_out = null;
            }

            $visit = visit::create([
                'visitor' => $valid['user'],
                'category' => $valid['category'],
                'organization' => $org_out,
                'observations' => $request->observations,
                'subject' => $valid['subject'],
                'entry_date' => $valid['date_entry'],
                'emp_visited' => $request->hostname ? $valid['hostname'] : null,
                'service_emp_visited' => $request->service,
                'badge_n' => $valid['badge_n'],
                'status' => 0,
            ]);
            $this->auditVisit($visit->id, 'visit_created_existing_visitor', null, [
                'visitor' => $valid['user'],
                'category' => $valid['category'],
                'organization' => $org_out,
                'subject' => $valid['subject'],
                'entry_date' => $valid['date_entry'],
                'badge_n' => $valid['badge_n'],
                'status' => 0,
            ]);

            return redirect()->route('i_visitors');
        }
    }
    public function delete(Request $request, $id)
    {
        if (!in_array((int) Auth::guard('web')->user()->profile, [5, 6], true)) {
            abort(403);
        }

        $oldVisit = visit::where('id', $id)->first();
        visit::where('id', $id)
            ->update(['is_deleted' => 1]);
        $this->auditVisit($id, 'visit_deleted', [
            'is_deleted' => $oldVisit->is_deleted ?? null,
        ], [
            'is_deleted' => 1,
        ]);
        return redirect()->route('i_visitors');
    }

    private function auditVisit($visitId, string $action, $oldValues = null, $newValues = null): void
    {
        if (!Schema::hasTable('visit_audits')) {
            return;
        }

        DB::table('visit_audits')->insert([
            'visit_id' => $visitId,
            'changed_by' => Auth::guard('web')->check() ? Auth::guard('web')->user()->id : null,
            'profile_id' => Auth::guard('web')->check() ? Auth::guard('web')->user()->profile : null,
            'action' => $action,
            'old_values' => is_null($oldValues) ? null : json_encode($oldValues, JSON_UNESCAPED_UNICODE),
            'new_values' => is_null($newValues) ? null : json_encode($newValues, JSON_UNESCAPED_UNICODE),
            'created_at' => Carbon::now(),
        ]);
    }

    private function resolveServiceHead($serviceId)
    {
        if (!$serviceId) {
            return null;
        }

        if (Schema::hasColumn('user_groups', 'is_head')) {
            $head = DB::table('user_groups')
                ->leftJoin('users', 'users.id', '=', 'user_groups.a_user')
                ->where('user_groups.a_group', '=', $serviceId)
                ->where('user_groups.is_head', '=', 1)
                ->orderBy('users.name')
                ->first(['users.id']);

            if ($head) {
                return $head->id;
            }
        }

        $priorityHead = DB::table('user_groups')
            ->leftJoin('users', 'users.id', '=', 'user_groups.a_user')
            ->where('user_groups.a_group', '=', $serviceId)
            ->whereIn('users.profile', [2, 3, 4])
            ->orderByRaw('CASE users.profile WHEN 2 THEN 1 WHEN 3 THEN 2 WHEN 4 THEN 3 ELSE 4 END')
            ->orderBy('users.name')
            ->first(['users.id']);

        return $priorityHead->id ?? null;
    }

    private function isServiceHead($userId, $serviceId): bool
    {
        if (!$userId || !$serviceId || !Schema::hasColumn('user_groups', 'is_head')) {
            return false;
        }

        return DB::table('user_groups')
            ->where('a_user', '=', $userId)
            ->where('a_group', '=', $serviceId)
            ->where('is_head', '=', 1)
            ->exists();
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

    private function ant_service_edit_index(Request $request, $id)
    {
        $antUser = ant_user::where('ant_user', '=', Auth::guard('web')->user()->id)->first();
        if (!$antUser || !$this->isAntenneHead(Auth::guard('web')->user()->id, $antUser->ant_group)) {
            abort(403);
        }

        $ant_loc = antennes::where('id', '=', $antUser->ant_group)->first();
        $visits = db::table('antenne_visits')
            ->selectRaw('antenne_visitors.firstname,antenne_visitors.lastname,category,status,antenne_visitors.lastname,entry_date,users.name as usrname, organisations.name as org_name, antenne_visitors.id_type as id_type, emp_visited, ant_location')
            ->leftjoin('antenne_visitors', 'antenne_visitors.id', '=', 'antenne_visits.visitor')
            ->leftjoin('organisations', 'antenne_visits.organization', '=', 'organisations.id')
            ->leftjoin('id_types', 'antenne_visitors.id_type', '=', 'id_types.id')
            ->leftjoin('antennes', 'antennes.id', '=', 'antenne_visits.ant_location')
            ->leftjoin('users', 'users.id', '=', 'antenne_visits.emp_visited')
            ->where('antenne_visits.id', '=', $id)
            ->where('antenne_visits.ant_location', '=', $antUser->ant_group)
            ->get();

        if ($visits->isEmpty() || !is_null($visits[0]->emp_visited)) {
            abort(403);
        }

        $cats = db::table('categories')->selectRaw('id,name')->get();
        $id_types = db::table('id_types')->selectRaw('id,name')->get();
        $antenneUsers = ant_user::select('users.id', 'users.name')
            ->leftjoin('users', 'users.id', '=', 'antenne_users.ant_user')
            ->where('antenne_users.ant_group', '=', $antUser->ant_group)
            ->where('users.profile', '=', 7)
            ->orderBy('users.name')
            ->get();

        return view('Antenne_reception.edit_index')
            ->with('data', $visits)
            ->with('url', 'guest')
            ->with('cats', $cats)
            ->with('loc', $ant_loc->antenne_name ?? 'cette antenne')
            ->with('id_types', $id_types)
            ->with('antenneUsers', $antenneUsers)
            ->with('isAntenneHead', true);
    }

    private function ant_service_edit(Request $request, $id)
    {
        $valid = $request->validate([
            'hostname' => ['required'],
        ]);

        $antUser = ant_user::where('ant_user', '=', Auth::guard('web')->user()->id)->first();
        if (!$antUser || !$this->isAntenneHead(Auth::guard('web')->user()->id, $antUser->ant_group)) {
            abort(403);
        }

        $visit = DB::table('antenne_visits')
            ->where('id', '=', $id)
            ->where('ant_location', '=', $antUser->ant_group)
            ->where('is_deleted', '=', 0)
            ->first();
        if (!$visit || !is_null($visit->emp_visited)) {
            abort(403);
        }

        $hostInAntenne = ant_user::where('ant_group', '=', $antUser->ant_group)
            ->where('ant_user', '=', $valid['hostname'])
            ->exists();
        if (!$hostInAntenne) {
            abort(403);
        }

        DB::table('antenne_visits')->where('id', '=', $id)->update([
            'emp_visited' => $valid['hostname'],
        ]);

        return redirect()->route('l_index');
    }

    private function isAntenneHead($userId, $antenneId): bool
    {
        if (!$userId || !$antenneId || !Schema::hasColumn('antenne_users', 'is_head')) {
            return false;
        }

        return ant_user::where('ant_user', '=', $userId)
            ->where('ant_group', '=', $antenneId)
            ->where('is_head', '=', 1)
            ->exists();
    }

}
