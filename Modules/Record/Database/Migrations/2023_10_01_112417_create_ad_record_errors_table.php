<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdRecordErrorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_record_errors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ad_record_id');
            $table->foreign('ad_record_id')->references('id')->on('ad_records')->onDelete('cascade');
            $table->unsignedBigInteger('created_by_id');
            $table->foreign('created_by_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('solved_by_id')->nullable();
            $table->foreign('solved_by_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('message');
            $table->timestamp('solved_at')->nullable();
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
        Schema::dropIfExists('ad_record_errors');
    }
}
