<?php

namespace Database\Seeders;

use App\Models\User;
use Modules\Acl\Entities\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ResearcherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // researchers
        $role = Role::where('name', 'researcher')->first();

        $user = User::create([
            'name' => 'Researcher',
            'email' => 'researcher@researcher.com',
            'website' => 'researcher.com',
            'password' => Hash::make('12345678'),
        ]);
        $user->roles()->attach($role);


        $user = User::create([
            'name' => 'Researcher2',
            'email' => 'researcher2@researcher.com',
            'website' => 'researcher2.com',
            'password' => Hash::make('12345678'),
        ]);
        $user->roles()->attach($role);


        $user = User::create([
            'name' => 'Researcher3',
            'email' => 'researcher3@researcher.com',
            'website' => 'researcher3.com',
            'password' => Hash::make('12345678'),
        ]);
        $user->roles()->attach($role);
    }
}
