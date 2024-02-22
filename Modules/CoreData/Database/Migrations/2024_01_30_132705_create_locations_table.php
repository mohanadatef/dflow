<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Acl\Entities\InfluencerCity;
use Modules\CoreData\Entities\Location;
use Modules\CoreData\Entities\Event;
use Modules\CoreData\Entities\InfluencerTravel;
use Modules\CoreData\Entities\BrandActivity;
use Illuminate\Support\Facades\DB;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::rename('countries', 'locations');
        Schema::table('locations', function(Blueprint $table)
        {
            $table->unsignedBigInteger('parent_id')->nullable()->index()->default(0);
        });
        $city = DB::table('cities')->get();
        foreach($city as $c)
        {
            $country = new Location();
            $country->create(['name_en' => $c->name_en, 'name_ar' => $c->name_ar, 'active' => $c->active, 'parent_id' => $c->country_id]);
            Schema::table('events', function(Blueprint $table)
            {
                $table->foreign('city_id')->references('id')->on('locations')->onDelete('cascade')->change();
            });
            Event::where('city_id', $c->id)->update(['city_id' => $country->id]);
            Schema::table('influencer_travels', function(Blueprint $table)
            {
                $table->foreign('city_id')->references('id')->on('locations')->onDelete('cascade')->change();
            });
            InfluencerTravel::where('city_id', $c->id)->update(['city_id' => $country->id]);
            Schema::table('brand_activities', function(Blueprint $table)
            {
                $table->foreign('city_id')->references('id')->on('locations')->onDelete('cascade')->change();
            });
            BrandActivity::where('city_id', $c->id)->update(['city_id' => $country->id]);
            Schema::table('influencer_cities', function(Blueprint $table)
            {
                $table->foreign('city_id')->references('id')->on('locations')->onDelete('cascade')->change();
            });
            InfluencerCity::where('city_id', $c->id)->update(['city_id' => $country->id]);
            Schema::table('influencer_countries', function(Blueprint $table)
            {
                $table->foreign('country_id')->references('id')->on('locations')->onDelete('cascade')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('locations', function(Blueprint $table)
        {
            $table->dropColumn('parent_id');
        });
        Schema::rename('locations', 'countries');
    }
}
