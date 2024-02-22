<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserToInfluencerGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('influencer_groups', function (Blueprint $table) {
            $table->unsignedBigInteger('researcher_id')->nullable()->after('name_ar');
            $table->foreign('researcher_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

}
