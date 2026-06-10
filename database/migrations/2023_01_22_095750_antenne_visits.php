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
        if (Schema::hasTable('antenne_visits')) {
            return;
        }

        Schema::create('antenne_visits',function (Blueprint $table) {
            $table->id();
            $table->bigInteger('visitor')->unsigned()->index();
            $table->bigInteger('organization')->unsigned()->nullable()->index();
            $table->bigInteger('category')->unsigned()->index();
            $table->dateTime('entry_date');
            $table->dateTime('exit_date')->nullable();
            $table->bigInteger('ant_location')->unsigned()->index();
            $table->bigInteger('emp_visited')->unsigned()->nullable()->index();
            $table->integer('status');
            $table->boolean('hashost')->default(0);
            $table->string('subject')->nullable();
            $table->boolean('is_deleted')->default(0);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
            Schema::dropIfExists('antenne_visits');
    }
};
