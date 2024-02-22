<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsBalanceToRequestAdMediaAccessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('request_ad_media_access', function (Blueprint $table) {
            $table->string('is_balance')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('request_ad_media_access', function (Blueprint $table) {
            $table->dropColumn('is_balance');
        });
    }
}
