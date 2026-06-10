<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('antenne_users') || Schema::hasColumn('antenne_users', 'is_head')) {
            return;
        }

        Schema::table('antenne_users', function (Blueprint $table) {
            $table->boolean('is_head')->default(false)->after('ant_group');
        });
    }

    public function down()
    {
        if (!Schema::hasTable('antenne_users') || !Schema::hasColumn('antenne_users', 'is_head')) {
            return;
        }

        Schema::table('antenne_users', function (Blueprint $table) {
            $table->dropColumn('is_head');
        });
    }
};
