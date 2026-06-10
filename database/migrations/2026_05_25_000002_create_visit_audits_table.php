<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('visit_audits')) {
            return;
        }

        Schema::create('visit_audits', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('visit_id')->unsigned()->index();
            $table->bigInteger('changed_by')->unsigned()->nullable()->index();
            $table->bigInteger('profile_id')->unsigned()->nullable()->index();
            $table->string('action', 80);
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('visit_audits');
    }
};
