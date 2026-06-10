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
        Schema::create('id_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        db::table('id_types')->insert([
            ['name'=>"Carte d'identité"],
            ['name'=>"Permis de conduire"],
            ['name'=>"Passeport"],
            ['name'=>"Carte Professionelle"],
            ['name'=>"Carte chifa"]
        ]);



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('id_types');
    }
};
