<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfluencerGroupSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('influencer_group_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('day');
            $table->unsignedBigInteger('influencer_group_id');
            $table->foreign('influencer_group_id')->references('id')->on('influencer_groups')->onDelete('cascade');
            $table->unsignedBigInteger('researcher_id');
            $table->foreign('researcher_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('influencer_group_schedules');
    }
}
