<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Acl\Entities\Permission;

class PermissionCustomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $models = ['influencers'];
        $names = [
            ['label' => "discover", 'name' => 'discover'],
        ];
        foreach($models as $model)
        {
            foreach($names as $name)
            {
                if(!Permission::where('name', $name['name'] . '_' . $model)->first())
                {
                    Permission::create([
                        'name' => $name['name'] . '_' . $model,
                        'label' => $name['label'] . ' ' . strtolower(trim(str_replace('_', ' ', trim($model)))),
                        'action' => $name['name'],
                        'category' => $model
                    ]);
                }
            }
        }

        $models = ['ad_record'];
        $names = [
            ['label' => "create_errors", 'name' => 'create_errors'],
            ['label' => "view_errors", 'name' => 'view_errors'],
            ['label' => "duplicate", 'name' => 'duplicate'],
            ['label' => "fix category", 'name' => 'fix_category'],
        ];
        foreach($models as $model)
        {
            foreach($names as $name)
            {
                if(!Permission::where('name', $name['name'] . '_' . $model)->first())
                {
                    Permission::create([
                        'name' => $name['name'] . '_' . $model,
                        'label' => $name['label'] . ' ' . strtolower(trim(str_replace('_', ' ', trim($model)))),
                        'action' => $name['name'],
                        'category' => $model
                    ]);
                }
            }
        }


        $models = ['setting'];
        $names = [
            ['label' => "match search", 'name' => 'match_search'],
            ['label' => "update", 'name' => 'update'],
        ];
        foreach($models as $model)
        {
            foreach($names as $name)
            {
                if(!Permission::where('name', $name['name'] . '_' . $model)->first())
                {
                    Permission::create([
                        'name' => $name['name'] . '_' . $model,
                        'label' => $name['label'] . ' ' . strtolower(trim(str_replace('_', ' ', trim($model)))),
                        'action' => $name['name'],
                        'category' => $model
                    ]);
                }
            }
        }
        Permission::where('name', $name['name'] . '_' . $models[0])->first()->delete();
        $models = ['users'];
        $names = [
            ['label' => "log admin dashboard", 'name' => 'log_admin_dashboard'],
            ['label' => "admin dashboard", 'name' => 'admin_dashboard'],
            ['label' => "change password", 'name' => 'change_password'],
            ['label' => "login", 'name' => 'login'],
        ];
        foreach($models as $model)
        {
            foreach($names as $name)
            {
                if(!Permission::where('name', $name['name'] . '_' . $model)->first())
                {
                    Permission::create([
                        'name' => $name['name'] . '_' . $model,
                        'label' => $name['label'] . ' ' . strtolower(trim(str_replace('_', ' ', trim($model)))),
                        'action' => $name['name'],
                        'category' => $model
                    ]);
                }
            }
        }
        Permission::where('name', $name['name'] . '_' . $models[0])->first()->delete();
        $models = [
            'services',
            'platforms',
            'promotions',
            'categories',
            'influencer_group',
            'users',
            'clients',
            'companies',
            'influencers',
            'ad_record',
            'tag',
            'influencer_travel',
            'event',
            'brand_activity',
            'influencer_trend',
            'location'
        ];
        $names =
            [
                ['label' => "export", 'name' => 'export'],
            ];
        foreach($models as $model)
        {
            foreach($names as $name)
            {
                if(!Permission::where('name', $name['name'] . '_' . $model)->first())
                {
                    Permission::create([
                        'name' => $name['name'] . '_' . $model,
                        'label' => $name['label'] . ' ' . strtolower(trim(str_replace('_', ' ', trim($model)))),
                        'action' => $name['name'],
                        'category' => $model
                    ]);
                }
            }
        }
        $models = [
            'companies',
        ];
        $names =
            [
                ['label' => "merge template", 'name' => 'merge_template'],
                ['label' => "duplicate", 'name' => 'duplicate'],
            ];
        foreach($models as $model)
        {
            foreach($names as $name)
            {
                if(!Permission::where('name', $name['name'] . '_' . $model)->first())
                {
                    Permission::create([
                        'name' => $name['name'] . '_' . $model,
                        'label' => $name['label'] . ' ' . strtolower(trim(str_replace('_', ' ', trim($model)))),
                        'action' => $name['name'],
                        'category' => $model
                    ]);
                }
            }
        }
        $models = [
            'request_ad_media_access',
        ];
        $names =
            [
                ['label' => "view", 'name' => 'view'],
                ['label' => "my_request", 'name' => 'my_request'],
                ['label' => "status", 'name' => 'status'],
                ['label' => "log", 'name' => 'log'],
            ];
        foreach($models as $model)
        {
            foreach($names as $name)
            {
                if(!Permission::where('name', $name['name'] . '_' . $model)->first())
                {
                    Permission::create([
                        'name' => $name['name'] . '_' . $model,
                        'label' => $name['label'] . ' ' . strtolower(trim(str_replace('_', ' ', trim($model)))),
                        'action' => $name['name'],
                        'category' => $model
                    ]);
                }
            }
        }
        $models = [
            'ad_record','ad_record_draft',
        ];
        $names =
            [
                ['label' => "log", 'name' => 'log'],
            ];
        foreach($models as $model)
        {
            foreach($names as $name)
            {
                if(!Permission::where('name', $name['name'] . '_' . $model)->first())
                {
                    Permission::create([
                        'name' => $name['name'] . '_' . $model,
                        'label' => $name['label'] . ' ' . strtolower(trim(str_replace('_', ' ', trim($model)))),
                        'action' => $name['name'],
                        'category' => $model
                    ]);
                }
            }
        }

        $models = [
            'users',
        ];
        $names =
            [
                ['label' => "show researcher dashboard", 'name' => 'show_researcher_dashboard'],
            ];

        foreach ($models as $model) {
            foreach ($names as $name) {
                if(!Permission::where('name',$name['name'] . '_' . $model)->first())
                {
                    Permission::create([
                        'name' => $name['name'] . '_' . $model,
                        'label' => $name['label'] . ' ' . strtolower(trim(str_replace('_', ' ', trim($model)))),
                        'action' => $name['name'],
                        'category' => $model
                    ]);
                }
            }
        }
        $models = [
            'influencers',
        ];
        $names =
            [
                ['label' => "merge", 'name' => 'merge'],
            ];

        foreach ($models as $model) {
            foreach ($names as $name) {
                if(!Permission::where('name',$name['name'] . '_' . $model)->first())
                {
                    Permission::create([
                        'name' => $name['name'] . '_' . $model,
                        'label' => $name['label'] . ' ' . strtolower(trim(str_replace('_', ' ', trim($model)))),
                        'action' => $name['name'],
                        'category' => $model
                    ]);
                }
            }
        }


        $models = [
            'support_center',
        ];
        $names =
            [
                ['label' => "status", 'name' => 'status'],
                ['label' => "hidden_questions", 'name' => 'hidden_questions'],
                ['label' => "create_answer", 'name' => 'create_answer'],

            ];

        foreach ($models as $model) {
            foreach ($names as $name) {
                if(!Permission::where('name',$name['name'] . '_' . $model)->first())
                {
                    Permission::create([
                        'name' => $name['name'] . '_' . $model,
                        'label' => $name['label'] . ' ' . strtolower(trim(str_replace('_', ' ', trim($model)))),
                        'action' => $name['name'],
                        'category' => $model
                    ]);
                }
            }
        }

        $models = [
            'external_dashboard',
        ];
        $names =
            [
                ['label' => "change version", 'name' => 'change_version'],
                ['label' => "log", 'name' => 'log'],
                ['label' => "assign", 'name' => 'assign'],
            ];

        foreach ($models as $model) {
            foreach ($names as $name) {
                if(!Permission::where('name',$name['name'] . '_' . $model)->first())
                {
                    Permission::create([
                        'name' => $name['name'] . '_' . $model,
                        'label' => $name['label'] . ' ' . strtolower(trim(str_replace('_', ' ', trim($model)))),
                        'action' => $name['name'],
                        'category' => $model
                    ]);
                }
            }
        }
        $models = ['page'];
        $names = [
            ['label' => "market overview", 'name' => 'market_overview'],
            ['label' => "competitive analysis", 'name' => 'competitive_analysis'],
        ];
        foreach($models as $model)
        {
            foreach($names as $name)
            {
                if(!Permission::where('name', $name['name'] . '_' . $model)->first())
                {
                    Permission::create([
                        'name' => $name['name'] . '_' . $model,
                        'label' => $name['label'] . ' ' . strtolower(trim(str_replace('_', ' ', trim($model)))),
                        'action' => $name['name'],
                        'category' => $model
                    ]);
                }
            }
        }
        Permission::where('category', 'countries')->delete();
        Permission::where('category', 'cities')->delete();
        $models = [
            'influencers',
        ];
        $names =
            [
                ['label' => "upload_image", 'name' => 'upload_image'],

            ];

        foreach ($models as $model) {
            foreach ($names as $name) {
                if(!Permission::where('name',$name['name'] . '_' . $model)->first())
                {
                    Permission::create([
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
