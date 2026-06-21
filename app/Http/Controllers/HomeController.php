<?php

namespace App\Http\Controllers;

use App\Models\ant_visits;
use App\Models\ant_user;
use App\Models\antennes;
use App\Models\visits as visit;
use App\Models\user_groups as ug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
//amine 140
//Mohamed Chafik DJEBARI 105
class HomeController extends Controller
{
    public function get_index()
    {
               switch (Auth::guard('web')->user()->profile) {
                case 7:
                    return $this->index_7();
                    break;
                case 6:
                    return $this->index_6();
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
                case 3:
                return $this->index_3();
                break;
                case 2:
                return $this->index_2();
                break;
                  case 1:
                return $this->index_5();
                break;
                  case 9:
                return $this->index_9();
                break;

            default:
            abort(403, 'Profil utilisateur non autorisé ou non configuré.');
                break;
        }
 
    } 
    
    public function index_6() 
    {
        $ant_id=ant_user::where('ant_user','=',Auth::guard('web')->user()->id)->get();
        $ant_loc=antennes::where('id','=',$ant_id[0]['ant_group'])->get();
        $today=ant_visits::wheredate('entry_date',db::raw('CURDATE()'))
            ->leftjoin('antennes','antennes.id','=','antenne_visits.ant_location')
            ->where('antenne_visits.ant_location','=',$ant_id[0]['ant_group'])
            ->where('is_deleted','=',0)->count();
        $waiting=ant_visits::wheredate('entry_date',db::raw('CURDATE()'))
            ->leftjoin('antennes','antennes.id','=','antenne_visits.ant_location')
            ->where('antenne_visits.ant_location','=',$ant_id[0]['ant_group'])
            ->where('status','=',0)
            ->where('is_deleted','=',0)->count();
        $progress=ant_visits::wheredate('entry_date',db::raw('CURDATE()'))
            ->leftjoin('antennes','antennes.id','=','antenne_visits.ant_location')
            ->where('antenne_visits.ant_location','=',$ant_id[0]['ant_group'])
            ->where('status','=',1)
            ->where('is_deleted','=',0)->count();
        $finished=ant_visits::wheredate('entry_date',db::raw('CURDATE()'))
            ->leftjoin('antennes','antennes.id','=','antenne_visits.ant_location')
            ->where('antenne_visits.ant_location','=',$ant_id[0]['ant_group'])
            ->where('status','=',2)
            ->where('is_deleted','=',0)->count();
        $visits=db::table('antenne_visits')->selectRaw('antenne_visits.id,antennes.antenne_name as ant_name,antenne_visits.is_deleted,organisations.name as org_name,antenne_visitors.firstname,status,antenne_visitors.lastname,entry_date,users.name as emp_visited,antenne_visits.subject as subject')
        ->join('antenne_visitors','antenne_visitors.id','=','antenne_visits.visitor')
        ->join('organisations','organisations.id','=','antenne_visits.organization')
        ->join('antennes','antennes.id','antenne_visits.ant_location')
        ->leftjoin('users','users.id','=','antenne_visits.emp_visited')
        ->leftjoin('antenne_users','antenne_visits.ant_location','antenne_users.ant_group')
        ->wheredate('entry_date',db::raw('CURDATE()'))
        ->where('status','=',0)
        ->where('antenne_visits.is_deleted','=',0)
        ->where('antenne_users.ant_group','=',$ant_id[0]['ant_group'])
        ->groupByRaw('id')
        ->orderBy('entry_date','asc')->get();
        return view('Antenne_reception.home')
            ->with('url','home')
            ->with('today',$today)
            ->with('waiting',$waiting)
            ->with('progress',$progress)
            ->with('finished',$finished)
            ->with('loc',$ant_loc[0]['antenne_name'])
            ->with('data',$visits);
    }

    public function index_7()
    {
        $antUser = ant_user::where('ant_user', '=', Auth::guard('web')->user()->id)->first();
        if (!$antUser) {
            abort(403);
        }

        $ant_loc = antennes::where('id', '=', $antUser->ant_group)->first();
        $isHead = $this->isAntenneHead(Auth::guard('web')->user()->id, $antUser->ant_group);

        $base = ant_visits::wheredate('entry_date', db::raw('CURDATE()'))
            ->where('ant_location', '=', $antUser->ant_group)
            ->where('is_deleted', '=', 0);

        $today = (clone $base)->when(!$isHead, function ($query) {
            $query->where('emp_visited', '=', Auth::guard('web')->user()->id);
        })->count();
        $waiting = (clone $base)->where('status', '=', 0)
            ->when($isHead, function ($query) {
                $query->whereNull('emp_visited');
            }, function ($query) {
                $query->where('emp_visited', '=', Auth::guard('web')->user()->id);
            })->count();
        $progress = (clone $base)->where('status', '=', 1)
            ->where('emp_visited', '=', Auth::guard('web')->user()->id)
            ->count();
        $finished = (clone $base)->where('status', '=', 2)
            ->where('emp_visited', '=', Auth::guard('web')->user()->id)
            ->count();

        $visits = db::table('antenne_visits')
            ->selectRaw('antenne_visits.id,antennes.antenne_name as ant_name,antenne_visits.is_deleted,organisations.name as org_name,antenne_visitors.firstname,status,antenne_visitors.lastname,entry_date,users.name as emp_visited,antenne_visits.subject as subject')
            ->join('antenne_visitors', 'antenne_visitors.id', '=', 'antenne_visits.visitor')
            ->leftjoin('organisations', 'organisations.id', '=', 'antenne_visits.organization')
            ->join('antennes', 'antennes.id', 'antenne_visits.ant_location')
            ->leftjoin('users', 'users.id', '=', 'antenne_visits.emp_visited')
            ->wheredate('entry_date', db::raw('CURDATE()'))
            ->where('antenne_visits.ant_location', '=', $antUser->ant_group)
            ->where('antenne_visits.is_deleted', '=', 0)
            ->whereIn('status', [0, 1])
            ->where(function ($query) use ($isHead) {
                $query->where('antenne_visits.emp_visited', '=', Auth::guard('web')->user()->id);
                if ($isHead) {
                    $query->orWhereNull('antenne_visits.emp_visited');
                }
            })
            ->orderBy('entry_date', 'asc')->get();

        return view('Antenne_reception.home')
            ->with('url', 'home')
            ->with('today', $today)
            ->with('waiting', $waiting)
            ->with('progress', $progress)
            ->with('finished', $finished)
            ->with('loc', $ant_loc->antenne_name ?? 'cette antenne')
            ->with('data', $visits)
            ->with('isAntenneHead', $isHead);
    }
                   
    public function index_5() 
    {
        $today=visit::wheredate('entry_date',db::raw('CURDATE()'))
            ->where('is_deleted','=',0)->count();
        $waiting=visit::wheredate('entry_date',db::raw('CURDATE()'))
            ->where('status','=',0)
            ->where('is_deleted','=',0)->count();
        $progress=visit::wheredate('entry_date',db::raw('CURDATE()'))
            ->where('status','=',1)
            ->where('is_deleted','=',0)->count();
        $finished=visit::wheredate('entry_date',db::raw('CURDATE()'))
            ->where('status','=',2)
            ->where('is_deleted','=',0)->count();
        $visits=db::table('visits')->selectRaw('visits.id,badge_n,visits.is_deleted,organisations.name as org_name,visitors.firstname,status,visitors.lastname,entry_date,users.name as emp_visited,groups.group_name as service_name,visits.subject as subject')
        ->leftjoin('visitors','visitors.id','=','visits.visitor')
        ->leftjoin('organisations','organisations.id','=','visits.organization')
        ->leftjoin('groups','groups.id','=','visits.service_emp_visited')
        ->leftjoin('users','users.id','=','visits.emp_visited')
        ->wheredate('entry_date',db::raw('CURDATE()'))
        ->whereIn('status',[0,1,3])
        ->where('visits.is_deleted','=',0)
        ->orderByDesc('entry_date')->get();
        return view('Reception.home')
            ->with('url','home')
            ->with('today',$today)
            ->with('progress',$progress)
            ->with('waiting',$waiting)
            ->with('finished',$finished)
            ->with('data',$visits);
    }

    public function index_8()
    {
        $today=visit::wheredate('entry_date',db::raw('CURDATE()'))
            ->where('is_deleted','=',0)->count();
        $waiting=visit::wheredate('entry_date',db::raw('CURDATE()'))
            ->where('status','=',0)
            ->whereNull('service_emp_visited')
            ->where('is_deleted','=',0)->count();
        $progress=visit::wheredate('entry_date',db::raw('CURDATE()'))
            ->where('status','=',0)
            ->whereNotNull('service_emp_visited')
            ->whereNull('emp_visited')
            ->where('is_deleted','=',0)->count();
        $finished=visit::wheredate('entry_date',db::raw('CURDATE()'))
            ->where('status','=',2)
            ->where('is_deleted','=',0)->count();
        $visits=db::table('visits')->selectRaw('visits.id,badge_n,visits.is_deleted,organisations.name as org_name,visitors.firstname,status,visitors.lastname,entry_date,users.name as emp_visited,groups.group_name as service_name,visits.subject as subject')
        ->leftjoin('visitors','visitors.id','=','visits.visitor')
        ->leftjoin('organisations','organisations.id','=','visits.organization')
        ->leftjoin('groups','groups.id','=','visits.service_emp_visited')
        ->leftjoin('users','users.id','=','visits.emp_visited')
        ->wheredate('entry_date',db::raw('CURDATE()'))
        ->whereIn('status',[0,1,3])
        ->where('visits.is_deleted','=',0)
        ->orderBy('entry_date','asc')->get();
        return view('Reception.home')
            ->with('url','home')
            ->with('today',$today)
            ->with('progress',$progress)
            ->with('waiting',$waiting)
            ->with('finished',$finished)
            ->with('data',$visits);
    }
    
    public function index_4() 
    {
        $isAssignmentAgent = $this->isServiceAssignmentAgent();
        $assignmentServiceId = $this->serviceAssignmentGroupId();
        $serviceIds=ug::where('a_user','=',Auth::guard('web')->user()->id)->pluck('a_group');
        $headServiceIds=ug::where('a_user','=',Auth::guard('web')->user()->id)
            ->where('is_head','=',1)
            ->pluck('a_group');
        $today=visit::wheredate('entry_date',db::raw('CURDATE()'))
            ->where('is_deleted','=',0)
            ->where(function ($query) use ($headServiceIds, $isAssignmentAgent, $assignmentServiceId) {
                $query->where('emp_visited','=',Auth::guard('web')->user()->id)
                    ->orWhere(function ($query) use ($headServiceIds, $isAssignmentAgent, $assignmentServiceId) {
                        if ($isAssignmentAgent) {
                            $query->where('service_emp_visited', '=', $assignmentServiceId)
                                ->whereNull('emp_visited');
                            return;
                        }
                        $query->whereIn('service_emp_visited',$headServiceIds)
                            ->whereNull('emp_visited');
                    });
            })->count();
        $waiting=visit::wheredate('entry_date',db::raw('CURDATE()'))
            ->where('status','=',0)
            ->where('is_deleted','=',0)
            ->whereNull('emp_visited')
            ->when($isAssignmentAgent, function ($query) use ($assignmentServiceId) {
                $query->where('service_emp_visited', '=', $assignmentServiceId);
            }, function ($query) use ($headServiceIds) {
                $query->whereIn('service_emp_visited',$headServiceIds);
            })->count();
        $progress=visit::wheredate('entry_date',db::raw('CURDATE()'))
            ->where('status','=',1)
            ->where('is_deleted','=',0)->where('emp_visited','=',Auth::guard('web')->user()->id)->count();
        $finished=visit::wheredate('entry_date',db::raw('CURDATE()'))
            ->where('status','=',2)
            ->where('is_deleted','=',0)->where('emp_visited','=',Auth::guard('web')->user()->id)->count();
        $visits=db::table('visits')->selectRaw('visits.id,badge_n,visits.is_deleted,organisations.name as org_name,visitors.firstname,status,visitors.lastname,entry_date,users.name as emp_visited,groups.group_name as service_name,visits.subject as subject')
        ->leftjoin('visitors','visitors.id','=','visits.visitor')
        ->leftjoin('organisations','organisations.id','=','visits.organization')
        ->leftjoin('groups','groups.id','=','visits.service_emp_visited')
        ->leftjoin('users','users.id','=','visits.emp_visited')
        ->wheredate('entry_date',db::raw('CURDATE()'))
        ->whereIn('status',[0,1])
        ->where('visits.is_deleted','=',0)
        ->where(function ($query) use ($headServiceIds, $isAssignmentAgent, $assignmentServiceId) {
            $query->where('emp_visited','=',Auth::guard('web')->user()->id)
                ->orWhere(function ($query) use ($headServiceIds, $isAssignmentAgent, $assignmentServiceId) {
                    if ($isAssignmentAgent) {
                        $query->where('service_emp_visited', '=', $assignmentServiceId)
                            ->whereNull('emp_visited');
                        return;
                    }
                    $query->whereIn('service_emp_visited',$headServiceIds)
                        ->whereNull('emp_visited');
                });
        })
        ->orderBy('entry_date')->get();
        return view('Service.home')
            ->with('url','home')
            ->with('today',$today)
            ->with('progress',$progress)
            ->with('waiting',$waiting)
            ->with('finished',$finished)
            ->with('data',$visits);
    }

    public function index_9()
    {
        $ddmServiceId = $this->ddmServiceGroupId();
        $serviceIds = ug::where('a_user', '=', Auth::guard('web')->user()->id)->pluck('a_group');

        $today = visit::wheredate('entry_date', db::raw('CURDATE()'))
            ->where('is_deleted', '=', 0)
            ->where('service_emp_visited', '=', $ddmServiceId)
            ->count();
        $waiting = visit::wheredate('entry_date', db::raw('CURDATE()'))
            ->where('status', '=', 0)
            ->where('is_deleted', '=', 0)
            ->where('service_emp_visited', '=', $ddmServiceId)
            ->whereNull('emp_visited')
            ->count();
        $progress = visit::wheredate('entry_date', db::raw('CURDATE()'))
            ->where('status', '=', 1)
            ->where('is_deleted', '=', 0)
            ->where('service_emp_visited', '=', $ddmServiceId)
            ->count();
        $finished = visit::wheredate('entry_date', db::raw('CURDATE()'))
            ->where('status', '=', 2)
            ->where('is_deleted', '=', 0)
            ->where('service_emp_visited', '=', $ddmServiceId)
            ->count();

        $visits = db::table('visits')->selectRaw('visits.id,badge_n,visits.is_deleted,organisations.name as org_name,visitors.firstname,status,visitors.lastname,entry_date,users.name as emp_visited,groups.group_name as service_name,visits.subject as subject')
            ->leftjoin('visitors', 'visitors.id', '=', 'visits.visitor')
            ->leftjoin('organisations', 'organisations.id', '=', 'visits.organization')
            ->leftjoin('groups', 'groups.id', '=', 'visits.service_emp_visited')
            ->leftjoin('users', 'users.id', '=', 'visits.emp_visited')
            ->wheredate('entry_date', db::raw('CURDATE()'))
            ->where('visits.is_deleted', '=', 0)
            ->where('visits.service_emp_visited', '=', $ddmServiceId)
            ->whereIn('status', [0, 1])
            ->where(function ($query) use ($serviceIds, $ddmServiceId) {
                $query->where('emp_visited', '=', Auth::guard('web')->user()->id)
                    ->orWhere(function ($query) use ($ddmServiceId) {
                        $query->where('service_emp_visited', '=', $ddmServiceId)
                            ->whereNull('emp_visited');
                    });
            })
            ->orderBy('entry_date')
            ->get();

        $serviceUsers = ug::select('users.id', 'users.name')
            ->leftjoin('users', 'users.id', '=', 'user_groups.a_user')
            ->where('user_groups.a_group', '=', $ddmServiceId)
            ->orderBy('users.name')
            ->get();

        return view('Service.home')
            ->with('url', 'home')
            ->with('today', $today)
            ->with('progress', $progress)
            ->with('waiting', $waiting)
            ->with('finished', $finished)
            ->with('data', $visits)
            ->with('serviceUsers', $serviceUsers)
            ->with('serviceName', 'DDM')
            ->with('serviceId', $ddmServiceId);
    }

    public function index_3() 
    {
        $serviceIds=ug::where('a_user','=',Auth::guard('web')->user()->id)->pluck('a_group');
        $today=visit::wheredate('entry_date',db::raw('CURDATE()'))
            ->where('is_deleted','=',0)
            ->whereIn('service_emp_visited',$serviceIds)
            ->count();
        $waiting=visit::wheredate('entry_date',db::raw('CURDATE()'))
            ->where('status','=',0)
            ->whereIn('service_emp_visited',$serviceIds)
            ->whereNull('emp_visited')
            ->where('is_deleted','=',0)->count();
        $progress=visit::wheredate('entry_date',db::raw('CURDATE()'))
            ->where('status','=',1)
            ->whereIn('service_emp_visited',$serviceIds)
            ->where('is_deleted','=',0)->count();
        $finished=visit::wheredate('entry_date',db::raw('CURDATE()'))
            ->where('status','=',2)
            ->whereIn('service_emp_visited',$serviceIds)
            ->where('is_deleted','=',0)->count();
        $visits=db::table('visits')->selectRaw('visits.id,badge_n,visits.is_deleted,organisations.name as org_name,visitors.firstname,status,visitors.lastname,entry_date,users.name as emp_visited,groups.group_name as service_name,visits.subject as subject')
        ->leftjoin('visitors','visitors.id','=','visits.visitor')
        ->leftjoin('organisations','organisations.id','=','visits.organization')
        ->leftjoin('groups','groups.id','=','visits.service_emp_visited')
        ->leftjoin('users','users.id','=','visits.emp_visited')
        ->wheredate('entry_date',db::raw('CURDATE()'))
        ->where('status','=',0)
        ->whereNull('emp_visited')
        ->where('visits.is_deleted','=',0)
        ->whereIn('service_emp_visited',$serviceIds)
        ->orderBy('entry_date')->get();
        return view('Service.home')
            ->with('url','home')
            ->with('today',$today)
            ->with('progress',$progress)
            ->with('waiting',$waiting)
            ->with('finished',$finished)
            ->with('data',$visits);
    }

    public function index_2() 
    {
        $period = request('period', 'today');
        $allowedPeriods = ['today', '1_month', '1_year', '2_years'];
        if (!in_array($period, $allowedPeriods, true)) {
            $period = 'today';
        }

        $periodStart = match ($period) {
            '1_month' => now()->subMonth()->startOfDay(),
            '1_year' => now()->subYear()->startOfDay(),
            '2_years' => now()->subYears(2)->startOfDay(),
            default => now()->startOfDay(),
        };

        $periodEnd = now()->endOfDay();

        $visitBase = visit::whereBetween('entry_date', [$periodStart, $periodEnd])
            ->where('is_deleted', '=', 0);

        $today = (clone $visitBase)->count();
        $waiting = (clone $visitBase)->where('status', '=', 0)->count();
        $progress = (clone $visitBase)->where('status', '=', 1)->count();
        $finished = (clone $visitBase)->where('status', '=', 2)->count();
        $ant_visited = ant_visits::whereBetween('entry_date', [$periodStart, $periodEnd])
            ->get()
            ->unique('ant_location')
            ->count();
        $ant_visited_count = ant_visits::whereBetween('entry_date', [$periodStart, $periodEnd])->count();

        $visits=db::table('visits')->selectRaw('visits.id,visits.is_deleted,organisations.name as org_name,visitors.firstname,status,visitors.lastname,entry_date,users.name as emp_visited,groups.group_name as service_name,visits.subject as subject')
        ->leftjoin('visitors','visitors.id','=','visits.visitor')
        ->leftjoin('organisations','organisations.id','=','visits.organization')
        ->leftjoin('groups','groups.id','=','visits.service_emp_visited')
        ->leftjoin('users','users.id','=','visits.emp_visited')
        ->whereBetween('entry_date', [$periodStart, $periodEnd])
        ->whereIn('status',[0,1,2,3])
        ->where('visits.is_deleted','=',0)
        ->orderByDesc('entry_date')
        ->limit($period === 'today' ? 5 : 12)
        ->get();

        $periodLabel = match ($period) {
            '1_month' => '1 mois',
            '1_year' => '1 an',
            '2_years' => '2 ans',
            default => "Aujourd'hui",
        };

        return view('President.home')
            ->with('url','home')
            ->with('today',$today)
            ->with('progress',$progress)
            ->with('waiting',$waiting)
            ->with('finished',$finished)
            ->with('selectedPeriod', $period)
            ->with('periodLabel', $periodLabel)
            ->with('today_ant_visited',$ant_visited)
            ->with('today_ant',$ant_visited_count)
            ->with('data',$visits);
    }

    private function isAntenneHead($userId, $antenneId): bool
    {
        if (!$userId || !$antenneId || !\Illuminate\Support\Facades\Schema::hasColumn('antenne_users', 'is_head')) {
            return false;
        }

        return ant_user::where('ant_user', '=', $userId)
            ->where('ant_group', '=', $antenneId)
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

    private function ddmServiceGroupId(): int
    {
        return 19;
    }

}
