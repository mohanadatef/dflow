<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\CoreData\Entities\Category;
use Modules\Record\Entities\ContentRecord;
use Illuminate\Support\Str;
use Modules\Record\Entities\ShortLink;
class ContentRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $contentRecords = ContentRecord::all();
        foreach ($contentRecords as $contentRecord) {
            $input['link'] = getFile($contentRecord->video->file ?? null, pathType()['ip'], getFileNameServer($contentRecord->video));
            $input['code'] = Str::random(6);
            $input['record_id'] = $contentRecord['id'];
            ShortLink::create($input);
        }
    }
}
