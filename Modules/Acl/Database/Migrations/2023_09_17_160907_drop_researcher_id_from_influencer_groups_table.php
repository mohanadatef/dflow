<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropResearcherIdFromInfluencerGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('influencer_groups', function (Blueprint $table) {
            $table->dropForeign('influencer_groups_researcher_id_foreign');
            $table->dropColumn('researcher_id');
        });
    }

}
