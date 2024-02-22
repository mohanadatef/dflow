<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRedFlagToAdRecordDraftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ad_record_drafts', function (Blueprint $table) {
            $table->string('red_flag')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ad_record_drafts', function (Blueprint $table) {
            $table->dropColumn('red_flag');
        });
    }
}
