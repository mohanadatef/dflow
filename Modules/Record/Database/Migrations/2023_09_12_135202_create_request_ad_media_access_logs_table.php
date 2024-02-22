<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestAdMediaAccessLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_ad_media_access_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_ad_media_access_id');
            $table->foreign('request_ad_media_access_id')->references('id')->on('request_ad_media_access')->onDelete('cascade');
            $table->string('status')->nullable();
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
        Schema::dropIfExists('request_ad_media_access_logs');
    }
}
