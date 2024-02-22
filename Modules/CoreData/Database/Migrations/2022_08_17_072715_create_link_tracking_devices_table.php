<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinkTrackingDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link_tracking_devices', function (Blueprint $table) {
            $table->id();
            $table->string('ios')->nullable();
            $table->string('android')->nullable();
            $table->string('windows')->nullable();
            $table->string('linux')->nullable();
            $table->string('mac')->nullable();
            $table->unsignedBigInteger('link_tracking_id');
            $table->foreign('link_tracking_id')->references('id')->on('link_tracking')->onDelete('cascade');
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
        Schema::dropIfExists('link_tracking_devices');
    }
}
