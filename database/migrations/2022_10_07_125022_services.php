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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        db::table('services')->insert([
            ['name'=>"PCD"],
            ['name'=>"Service MARCHÉ"],
            ['name'=>"DPM - DCM Direction des permis miniers"],
            ['name'=>"DPM - DDM Direction de la promotion minières"],
            ['name'=>"DRC - Direction de la recherche minières"],
            ['name'=>"DRC - Direction du contrôle minier"],
        ]);
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
