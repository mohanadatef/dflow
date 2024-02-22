<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinkTrackingClicksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link_tracking_clicks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('link_tracking_id');
            $table->foreign('link_tracking_id')->references('id')->on('link_tracking')->onDelete('cascade');
            $table->string('ip')->nullable();
            $table->string('device')->nullable();
            $table->string('operating_system')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('region')->nullable();
            $table->string('country_code')->nullable();
            $table->string('continent_name')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('timezone')->nullable();
            $table->string('currency_code')->nullable();
            $table->string('currency_symbol')->nullable();
            $table->text('data')->nullable();
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
        Schema::dropIfExists('link_tracking_clicks');
    }
}
