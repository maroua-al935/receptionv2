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
        if (Schema::hasTable('antenne_users')) {
            return;
        }

        Schema::create('antenne_users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ant_user')->unsigned()->index();
            $table->bigInteger('ant_group')->unsigned()->index();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('antenne_users');
    }
};
