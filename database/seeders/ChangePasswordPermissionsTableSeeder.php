<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Acl\Entities\Permission;
use Modules\Acl\Entities\PermissionRole;
use Modules\Acl\Entities\Role;

class ChangePasswordPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if(!Permission::where('name','change_password_users')->first())
        {
        $permission = Permission::create([
            'name' => 'change_password_users',
            'label' => 'change_password_users',
            'action' => 'change_password_users',
            'category' => 'users'
        ]);
        PermissionRole::create(['role_id' => 1, 'permission_id' => $permission->id]);
    }
    }

}
