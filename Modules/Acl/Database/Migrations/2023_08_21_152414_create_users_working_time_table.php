<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersWorkingTimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_working_time', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->float('working_hours');
            $table->dateTime('date');
            $table->dateTime('last_seen_at');
            $table->dateTime('first_login');
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
        Schema::dropIfExists('users_working_time');
    }
}
