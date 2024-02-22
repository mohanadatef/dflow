<?php

namespace Modules\CoreData\Export;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Modules\CoreData\Entities\Tag;

class ExportTag implements FromCollection, WithHeadings
{
    private $request = null;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function headings(): array
    {
        if ($this->request->lang == 'ar') {
            return [
                'الاسم',
            ];
        } else {
            return [
                'Name',
            ];
        }
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        ini_set('memory_limit', '-1');
        $data = [];

        $datas =  Tag::all();
            foreach ($datas as $tag) {
                $data[] = [
                    'name' => $tag->name,
                ];
            }
        return collect($data);
    }


}


