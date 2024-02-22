<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinkTrackingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link_tracking', function (Blueprint $table) {
            $table->id();
            $table->string('link_id');
            $table->string('destination');
            $table->string('title');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('options')->nullable();
            $table->text('countries')->nullable();
            $table->string('ios_url')->nullable();
            $table->string('android_url')->nullable();
            $table->string('windows_url')->nullable();
            $table->string('linux_url')->nullable();
            $table->string('mac_url')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('link_tracking');
    }
}
