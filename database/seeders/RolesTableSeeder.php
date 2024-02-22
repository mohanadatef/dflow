<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Acl\Entities\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create([
            'name' => 'Super Admin',
            'label' => 'super_admin',
        ]);

        $user = User::get()->first();
        $user->roles()->attach($role);

        Role::create([
            'name' => 'IMD',
            'label' => 'IMD',
        ]);
        Role::create([
            'name' => 'researcher',
            'label' => 'researcher',
        ]);
        Role::create([
            'name' => 'client',
            'label' => 'client',
        ]);
    }
}
