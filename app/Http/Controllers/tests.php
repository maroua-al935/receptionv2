<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LdapRecord\Models\ActiveDirectory\User;
use App\Models\group as local_group;
use App\Models\User as local_user;
use App\Models\user_groups as ug;
use LdapRecord\Models\ActiveDirectory\Group;
use Illuminate\Support\Facades\Auth;
use LdapRecord\Models\ActiveDirectory\OrganizationalUnit;

class tests extends Controller
{

    public function get_test() {
        return view("president.test");
    }

    public function get_groups()
    {


        //$users = User::in('ou=Informatique,ou=Siege,ou=Users,ou=ANAM,dc=corp,dc=anam,dc=dz')->get();
        //dd($users);

       $allowed_groups=[
            'gr_Informatique',
            'gr_Marché',
            'gr_Controle Minier',
            'gr_Recherche',
            'gr_DCM',
            'gr_DDM',
            'gr_DFC',
            'gr_DRHL',
            'gr_Fiscalite',
            'gr_Comite Direction',
            'gr_Juridique',
            'gr_DPM'];
        #$groups = Group::in('ou=Siege,ou=Users,ou=ANAM,dc=corp,dc=anam,dc=dz')->get();
        $groups = Group::in('ou=Siege,ou=Users,ou=ANAM,dc=corp,dc=anam,dc=dz')->get();
dd($groups[2]->member);
        $users = local_user::select('id','user_dn')->where('user_dn','like',"%promotion%")->get();
        ug::select('*')->delete();
        local_group::select('*')->delete();
        foreach($groups as $group) {
            if (in_array($group->name[0],$allowed_groups))
            {
            local_group::create([
                'group_name'=>$group->samaccountname[0],
               'group_full_dn'=>$group->distinguishedname[0],
                'group_dn'=>$group->name[0],
        ]);
            foreach($group->member as $member)
            {
        $group_id=local_group::select('id','group_dn','group_name')->where('group_dn','=',$group->name)->get();
        $group_name=$group_id[0]->group_name;
        $users = local_user::select('id','user_dn')->where('user_dn','=',$member)->get();
        if ($users->count() >0)
        {
            ug::create([
                'user'=>$users[0]->id,
                'group'=>$group_id[0]->id,
            ]);
        }
            }


            }
            }
        #foreach($allowed_groups as $group) {
        //$users = User::in("ou=$group_name,ou=Siege,ou=Users,ou=ANAM,dc=corp,dc=anam,dc=dz")->get();
       // $users=$users->where('sidKey','like','%sid%')->get();
    #}


    }
    public function index()
    {

        //$users = User::get();
        //$users = Group::find('cn=gr_app_reception,ou=groupes,ou=Users,ou=ANAM,dc=corp,dc=anam,dc=dz')->members()->get();
        $users = User::in('ou=Magasin,ou=Siege,ou=Users,ou=ANAM,dc=corp,dc=anam,dc=dz')->get();
        //$users = Group::find('cn=gr_app_reception,ou=groupes,ou=Users,ou=ANAM,dc=corp,dc=anam,dc=dz')->members()->get();
        //dd($users);
        //$users = User::in('ou=siege,ou=Users,ou=ANAM,dc=corp,dc=anam,dc=dz')->get();
     //   if (Auth::attempt(['samaccountname'=>'ANAM1532','password'=>'WfqgyH0MoKb2MUww'])) {
      //      $user=Auth::user();
      //      dd($user);
      //  dd($user instanceof \App\Models\User);
       // }
       dd($users);

        return view('test');
    }
    protected function credentials(Request $request)
    {


    }
    public function post()
    {
        //
    }
}
