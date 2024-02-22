<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColsToAdRecordDraftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ad_record_drafts', function (Blueprint $table) {
            $table->string('url_post')->nullable();
            $table->integer('price')->nullable()->default(0)->after('date');
            $table->unsignedBigInteger('platform_id')->nullable();

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
            //
        });
    }
}
