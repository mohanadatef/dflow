<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\CoreData\Entities\Category;

class UpdateIndustryInCategoriesTableTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::orderBy('id')->get();
        foreach ($categories as $category) {
            if ($category->group == 'industry') {
                if ($category->parent_id == null) {
                    $category->group = 'industry_parent';
                    $category->save();
                } else {
                    $category->group = 'industry_child';
                    $category->save();
                }
            }
        }
    }
}
