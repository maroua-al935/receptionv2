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
        if (Schema::hasTable('antenne_visitors')) {
            return;
        }

        Schema::create('antenne_visitors', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->bigInteger('position')->unsigned()->nullable()->index();
            $table->bigInteger('attachment')->unsigned()->nullable()->index();
            $table->string('cin');
            $table->bigInteger('id_type')->unsigned()->index();
            $table->boolean('is_deleted')->default(0);
            $table->timestamps();

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
            Schema::dropIfExists('antenne_visitors');
    }
};
