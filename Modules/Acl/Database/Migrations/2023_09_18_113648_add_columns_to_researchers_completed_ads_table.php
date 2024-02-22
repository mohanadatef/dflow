<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToResearchersCompletedAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('researcher_complete_ads');

        Schema::create('reseacher_influencers_daily', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('influencer_follower_platform_id');
            $table->foreign('influencer_follower_platform_id','influencer_follower_platform_daily')->references('id')->on('influencer_follower_platforms')->onDelete('cascade');
            $table->boolean('is_complete')->default(0);
            $table->unsignedBigInteger('researcher_id');
            $table->foreign('researcher_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('owner_researcher_id')->nullable();
            $table->dateTime('date');
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
        Schema::dropIfExists('reseacher_influencers_daily');
    }
}
