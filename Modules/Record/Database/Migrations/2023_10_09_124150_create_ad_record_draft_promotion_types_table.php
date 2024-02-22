<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdRecordDraftPromotionTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_record_draft_promotion_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ad_record_draft_id');
            $table->foreign('ad_record_draft_id')->references('id')->on('ad_record_drafts')->onDelete('cascade');
            $table->unsignedBigInteger('promotion_type_id');
            $table->foreign('promotion_type_id')->references('id')->on('promotion_types')->onDelete('cascade');
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
        Schema::dropIfExists('ad_record_draft_promotion_types');
    }
}
