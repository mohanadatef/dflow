<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInfluencerGroupToInfluencerFollowerPlatformsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('influencer_follower_platforms', function (Blueprint $table) {
            $table->unsignedBigInteger('influencer_group_id')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('influencer_follower_platforms', function (Blueprint $table) {
            $table->dropColumn('influencer_group_id');
        });
    }
}
