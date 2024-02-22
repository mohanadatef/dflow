<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\CoreData\Entities\WebsiteKey;

class CompanyLinksDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $urls = \Modules\Acl\Entities\Company::whereNotNull('link')->select('id', 'link')->get();
        $keys = WebsiteKey::all();
        $id = WebsiteKey::where('key', 'general')->first()['website_id'];
        foreach ($urls as $url){
            $bool = 0;
            foreach ($keys as $key){
                if(strpos(strtolower($url->link), strtolower($key->key)) != 0){
                    $bool = 1;
                    break;
                }
            }
            $url->company_website()->create([
                'website_id' => $bool == 1 ? $key->website_id : $id,
                'url' =>strtolower($url->link)
            ]);
        }
    }
}
