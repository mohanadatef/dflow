<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Acl\Entities\Permission;
use Modules\Acl\Entities\Role;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $models = modelPermission();

        $names =
            [
                ['label' => "view", 'name' => 'view'],
                ['label' => "create", 'name' => 'create'],
                ['label' => "update", 'name' => 'update'],
                ['label' => "delete", 'name' => 'delete'],
            ];

        foreach ($models as $model) {
            foreach ($names as $name) {
                if(!Permission::where('name',$name['name'] . '_' . $model)->first() && $model != 'setting')
                {
                $permission = Permission::create([
                    'name' => $name['name'] . '_' . $model,
                    'label' => $name['label'] . ' ' . strtolower(trim(str_replace('_', ' ', trim($model)))),
                    'action' => $name['name'],
                    'category' => $model
                ]);

                }
            }
        }
    }
}
