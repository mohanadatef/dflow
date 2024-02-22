<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntgrationAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intgration_account', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id')->references('id')->on('users');
            $table->string('account_id')->nullable();
            $table->string('email')->index();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->string('avater')->nullable();
            $table->boolean('login')->default(1);
            $table->string('access_token')->nullable();
            $table->string('refresh_token')->nullable();
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
        Schema::dropIfExists('intgration_account');
    }
}

