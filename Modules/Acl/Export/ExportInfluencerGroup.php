<?php

namespace Modules\Acl\Export;

use Illuminate\Support\Collection;
use Modules\Acl\Entities\InfluencerGroup;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportInfluencerGroup implements FromCollection, WithHeadings
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
                'الاسم بالإنجليزية',
                ' الاسم بالعربي',
            ];
        } else {
            return [
                'Name (en)',
                'Name (ar)',
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

        $datas =  InfluencerGroup::get();

            foreach ($datas as $service) {
                $data[] = [
                    'name (en)' => $service->name_en ?? "",
                    'name (ar)' => $service->name_ar ?? "",
                ];
            }


        return collect($data);
    }


}


