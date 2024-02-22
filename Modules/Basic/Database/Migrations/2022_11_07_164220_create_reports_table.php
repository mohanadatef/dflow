<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('platform')->nullable();
            $table->string('identifier')->nullable();
            $table->string('type')->nullable();
            $table->string('license_status')->nullable();
            $table->date('status_date')->nullable();
            $table->string('advertised_party')->nullable();
            $table->string('advertise_category')->nullable();
            $table->date('report_date')->nullable();
            $table->string('advertise_url')->nullable();
            $table->string('image')->nullable();

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
        Schema::dropIfExists('reports');
    }
}
