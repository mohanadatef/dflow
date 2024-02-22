<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\CoreData\Entities\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $array = [
            'Sports and Fitness', 'Gamers', 'Bloggers', 'Photographers', 'Travel', 'Business & Careers', 'Fashion & Beauty',
            'Parenting', 'Food & Cooking', 'Awareness', 'Lifestyle', 'Cars & Motorbikes', 'Cinema & Actors', 'Art & Artist', 'Journalist',
            'DIY & Design', 'Health', 'Kids & Family', 'Humor & Fun', 'News', 'Tech', 'Science', 'Daily',
            'Tv Host & Media', 'Public figure'
        ];
        foreach ($array as $arr) {
            Category::create([
                'name_en' => $arr,
                'name_ar' => $arr,
                'group' => groupType()['fg'],
            ]);
        }
    }
}
