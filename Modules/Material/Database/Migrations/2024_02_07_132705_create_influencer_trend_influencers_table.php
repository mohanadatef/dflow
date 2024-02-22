<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Material\Entities\InfluencerTrend;

class CreateInfluencerTrendInfluencersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('influencer_trend_influencers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('influencer_id');
            $table->foreign('influencer_id')->references('id')->on('influencers')->onDelete('cascade');
            $table->unsignedBigInteger('influencer_trend_id');
            $table->foreign('influencer_trend_id')->references('id')->on('influencer_trends')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        foreach(InfluencerTrend::all() as $trent )
        {
            $trent->influencer()->sync([$trent->influencer_id]);
        }
        Schema::table('influencer_trends', function (Blueprint $table) {
            $table->dropForeign('influencer_trends_influencer_id_foreign');
            $table->dropColumn('influencer_id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('influencer_trend_influencers');
    }
}
