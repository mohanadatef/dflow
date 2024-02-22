<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResearcherCompleteAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('researcher_complete_ads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('influencer_follower_platform_id');
            $table->foreign('influencer_follower_platform_id')->references('id')->on('influencer_follower_platforms')->onDelete('cascade');
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
        Schema::dropIfExists('researcher_complete_ads');
    }
}
