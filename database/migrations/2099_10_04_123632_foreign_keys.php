<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\group;
use App\Models\User;
use App\Models\user_groups as ug;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('visitors',function (Blueprint $table) {
            $table->foreign('id_type')->references('id')->on('id_types');
            $table->foreign('position')->references('id')->on('positions');
            $table->foreign('attachment')->references('id')->on('attachments');
        });
        Schema::table('visits',function (Blueprint $table) {
            $table->foreign('visitor')->references('id')->on('visitors');
            $table->foreign('category')->references('id')->on('categories');
            $table->foreign('service_emp_visited')->references('id')->on('groups');
            $table->foreign('organization')->references('id')->on('organisations');
            $table->foreign('emp_visited')->references('id')->on('users');
        });
        Schema::table('user_groups', function (Blueprint $table) {
            $table->foreign('a_user')->references('id')->on('users');
            $table->foreign('a_group')->references('id')->on('groups');
        });
        Schema::table('users',function (Blueprint $table) {
            $table->foreign('profile')->references('id')->on('profiles');
        });
        Schema::table('antenne_visitors',function (Blueprint $table) {
            $table->foreign('id_type')->references('id')->on('id_types');
            $table->foreign('position')->references('id')->on('positions');
            $table->foreign('attachment')->references('id')->on('attachments');
        });
        Schema::table('antenne_visits',function (Blueprint $table) {
            $table->foreign('visitor')->references('id')->on('visitors');
            $table->foreign('category')->references('id')->on('categories');
            $table->foreign('organization')->references('id')->on('organisations');
            $table->foreign('emp_visited')->references('id')->on('users');
            $table->foreign('ant_location')->references('id')->on('antennes');
        });
        Schema::table('antenne_users', function (Blueprint $table) {
            $table->foreign('ant_user')->references('id')->on('users');
            $table->foreign('ant_group')->references('id')->on('antennes');
        });

/*
        group::create([
            'id'=>1,
            'group_name'=>'group1',
            'group_full_dn'=>'dn1',
            'group_dn'=>'gr1'
        ]);
        user::insert([
            ['id'=>1,'name'=>'moh kamal','firstname'=>'moh','lastname'=>'kamal'],           
            ['id'=>2,'name'=>'amine jamal','firstname'=>'amine','lastname'=>'jamal'],           
            ['id'=>3,'name'=>'rafik janne','firstname'=>'rafik','lastname'=>'janne']
        ]);

        ug::insert([
            ['user'=>1,'group'=>1],
            ['user'=>2,'group'=>1],
            ['user'=>3,'group'=>1]
        ]);
 */       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
