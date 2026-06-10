<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('antennes')) {
            return;
        }

        Schema::create('antennes', function (Blueprint $table) {
            $table->id();
            $table->string('antenne_name');
            $table->string('antenne_full_dn');
            $table->string('antenne_dn');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('antennes');
    }
};
