<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeSizeToInfluencerFollowerPlatformsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('influencer_follower_platforms', function (Blueprint $table) {
            $table->foreign('size_id')->references('id')->on('sizes')->onDelete('cascade');
        });
    }

}
