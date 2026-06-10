<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('visitors', function (Blueprint $table) {
            if (!Schema::hasColumn('visitors', 'nin')) {
                $table->string('nin')->nullable()->after('cin');
            }
        });

        Schema::table('antenne_visitors', function (Blueprint $table) {
            if (!Schema::hasColumn('antenne_visitors', 'nin')) {
                $table->string('nin')->nullable()->after('cin');
            }
        });
    }

    public function down()
    {
        Schema::table('visitors', function (Blueprint $table) {
            if (Schema::hasColumn('visitors', 'nin')) {
                $table->dropColumn('nin');
            }
        });

        Schema::table('antenne_visitors', function (Blueprint $table) {
            if (Schema::hasColumn('antenne_visitors', 'nin')) {
                $table->dropColumn('nin');
            }
        });
    }
};
