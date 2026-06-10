<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('privilege')->unique();
        });
        db::table('profiles')->insert([
            ['name'=>'Admin','privilege'=>5],
            ['name'=>'Président','privilege'=>4],
            ['name'=>'Superviseur','privilege'=>3],
            ['name'=>'Service','privilege'=>2],
            ['name'=>'Réception','privilege'=>1]

        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
};
