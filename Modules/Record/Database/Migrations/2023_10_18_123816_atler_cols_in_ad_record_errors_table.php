<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AtlerColsInAdRecordErrorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ad_record_errors', function (Blueprint $table) {
            $table->renameColumn('solved_by_id', 'action_by_id');
            $table->renameColumn('solved_at', 'action_at');
            $table->integer('action')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ad_record_errors', function (Blueprint $table) {
            //
        });
    }
}
