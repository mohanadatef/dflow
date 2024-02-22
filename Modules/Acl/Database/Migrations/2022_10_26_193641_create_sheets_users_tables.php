<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSheetsUsersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sheets_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id')->references('id')->on('users');
            $table->string('intgration_account_id')->references('id')->on('intgration_account');
            $table->string('sheet_id')->index();
            $table->string('sheet_name')->nullable();
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
        Schema::dropIfExists('sheets_users');
    }
}