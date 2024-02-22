<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexAdRecordsTable extends Migration
{
    /**
     * Run thendex migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ad_records', function (Blueprint $table) {
            $table->index(['date', 'created_at']);
        });
    }

}
