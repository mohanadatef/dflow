<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
class AddRoleIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id');
        });

        $users = User::all();
        foreach ($users as $user) {
            $user->update(['role_id' => \Illuminate\Support\Facades\DB::Table('role_user')->where('user_id',$user->id)->first()->role_id]);
        }
        if(User::where('role_id',0)->count() == 0 && User::whereNull('role_id')->count() == 0){
            Schema::drop('role_user');
        }
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role_id');
        });
    }
}
