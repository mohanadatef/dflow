<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('platforms', function (Blueprint $table) {
            $table->index('name_en');
            $table->index('name_ar');
        });
        Schema::table('sizes', function (Blueprint $table) {
            $table->index('name_en');
            $table->index('name_ar');
        });
        Schema::table('services', function (Blueprint $table) {
            $table->index('name_en');
            $table->index('name_ar');
        });
        Schema::table('promotion_types', function (Blueprint $table) {
            $table->index('name_en');
            $table->index('name_ar');
        });
        Schema::table('interests', function (Blueprint $table) {
            $table->index('name_en');
            $table->index('name_ar');
        });
        Schema::table('campaigns', function (Blueprint $table) {
            $table->index('name_en');
            $table->index('name_ar');
        });
        Schema::table('companies', function (Blueprint $table) {
            $table->index('name_en');
            $table->index('name_ar');
            $table->index('active');
        });
        Schema::table('countries', function (Blueprint $table) {
            $table->index('name_en');
            $table->index('name_ar');
            $table->index('name_fr');
            $table->index('code');
        });
        Schema::table('cities', function (Blueprint $table) {
            $table->index('name_en');
            $table->index('name_ar');
            $table->index('name_fr');
            $table->index('code');
        });
        Schema::table('influencers', function (Blueprint $table) {
            $table->index('name');
            $table->index('name_ar');
            $table->index('active');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->index('name_en');
            $table->index('name_ar');
            $table->index('active');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->index('name');
            $table->index('active');
        });
        Schema::table('permissions', function (Blueprint $table) {
            $table->index('name');
            $table->index('label');
        });
        Schema::table('ad_records', function (Blueprint $table) {
            $table->index('promoted_products');
            $table->index('promoted_offer');
            $table->index('mention_ad');
            $table->index('gov_ad');
        });
    }
}
