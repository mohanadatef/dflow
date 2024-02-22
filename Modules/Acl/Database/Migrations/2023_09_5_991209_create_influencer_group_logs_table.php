<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInfluencerGroupLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('influencer_group_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('influencer_group_id');
            $table->foreign('influencer_group_id')->references('id')->on('influencer_groups')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('influencer_follower_platform_id');
            $table->foreign('influencer_follower_platform_id')->references('id')->on('influencer_follower_platforms')->onDelete('cascade');
            $table->string('type')->default('1');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('influencer_group_platforms');
    }
}
