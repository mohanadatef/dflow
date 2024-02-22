<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternalDashboardVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_dashboard_versions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('external_dashboard_id');
            $table->foreign('external_dashboard_id')->references('id')->on('external_dashboards')->onDelete('cascade');
            $table->integer('major');
            $table->integer('minor');
            $table->integer('batch');
            $table->string('default')->default('1');
            $table->string('dashboard_data')->default('');
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
        Schema::dropIfExists('external_dashboard_versions');
    }
}
