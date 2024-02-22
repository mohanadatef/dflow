<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Basic\Entities\Seeder;

class CreateCompaniesWebsitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies_websites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->unsignedBigInteger('website_id');
            $table->foreign('website_id')->references('id')->on('websites')->onDelete('cascade');
            $table->string('url');
            $table->timestamps();
        });
        Artisan::call('db:seed', [
            '--class' => 'WebsiteTableSeeder',
            '--force' => true // <--- add this line
        ]);
        Seeder::create(['seeder' => 'WebsiteTableSeeder']);
        Artisan::call('db:seed', [
            '--class' => 'CompanyLinksDataSeeder',
            '--force' => true // <--- add this line
        ]);
        Seeder::create(['seeder' => 'CompanyLinksDataSeeder']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies_websites');
    }
}
