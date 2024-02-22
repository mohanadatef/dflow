<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInfluencerGroupToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('influencer_group_id')->nullable()->after('active');
            $table->foreign('influencer_group_id')->references('id')->on('influencer_groups')->onDelete('cascade');
        });
    }

}
