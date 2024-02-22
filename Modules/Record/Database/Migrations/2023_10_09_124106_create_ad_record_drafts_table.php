<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdRecordDraftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_record_drafts', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('influencer_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('user_id');

            $table->string('promoted_products')->nullable();
            $table->string('promoted_offer')->nullable();

            $table->boolean('mention_ad')->nullable()->default(false);
            $table->boolean('gov_ad')->nullable()->default(false);

            $table->text('notes')->nullable();

            $table->timestamp('date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ad_record_drafts');
    }
}
