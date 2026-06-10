<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('user_groups') || Schema::hasColumn('user_groups', 'is_head')) {
            return;
        }

        Schema::table('user_groups', function (Blueprint $table) {
            $table->boolean('is_head')->default(false)->after('a_group');
        });
    }

    public function down()
    {
        if (!Schema::hasTable('user_groups') || !Schema::hasColumn('user_groups', 'is_head')) {
            return;
        }

        Schema::table('user_groups', function (Blueprint $table) {
            $table->dropColumn('is_head');
        });
    }
};
