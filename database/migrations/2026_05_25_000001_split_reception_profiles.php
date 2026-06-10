<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::table('profiles')->where('id', 5)->update([
            'name' => "Agent d'accueil",
            'privilege' => 1,
        ]);

        DB::table('profiles')->updateOrInsert(
            ['id' => 8],
            ['name' => "Agent d'orientation", 'privilege' => 7]
        );
    }

    public function down()
    {
        DB::table('profiles')->where('id', 5)->update([
            'name' => 'Reception',
            'privilege' => 1,
        ]);

        DB::table('profiles')->where('id', 8)->delete();
    }
};
