<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInfluencerGroupIdToInfluencerGroupLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('influencer_group_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('new_influencer_group_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('influencer_group_logs', function (Blueprint $table) {
            $table->drop('new_influencer_group_id');
        });
    }
}
