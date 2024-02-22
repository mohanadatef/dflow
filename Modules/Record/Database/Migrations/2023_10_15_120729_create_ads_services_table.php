<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        executionTime();
        Schema::create('ad_records_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ad_record_id');
            $table->foreign('ad_record_id')->references('id')
                ->on('ad_records')->onDelete('cascade');
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')
                ->on('services')->onDelete('cascade');
            $table->timestamps();
        });
        executionTime();
        \Modules\Record\Entities\AdRecord::select('id as ad_record_id','service_id')->each(function ($article) {
            $newUser = $article->replicate();
            $newUser->setTable('ad_records_services');
            $newUser->save();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ads_services');
    }
}
