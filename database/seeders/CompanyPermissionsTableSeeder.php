<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Acl\Entities\Permission;
use Modules\Acl\Entities\Role;

class CompanyPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $models = [
            'companies',
        ];

        $names =
            [
                ['label' => "merge", 'name' => 'merge'],
            ];

        foreach ($models as $model) {
            foreach ($names as $name) {
                if(!Permission::where('name',$name['name'] . '_' . $model)->first())
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
