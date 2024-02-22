<?php

namespace Modules\CoreData\Export;

use Illuminate\Support\Collection;
use Modules\CoreData\Entities\Platform;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportPlatform implements FromCollection, WithHeadings
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
                'خدمات'
            ];
        } else {
            return [
                'Name (en)',
                'Name (ar)',
                'Service',
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

        $datas =  Platform::with('service')->get();

            foreach ($datas as $platfrom) {
                $data[] = [
                    'name (en)' => $platfrom->name_en ?? "",
                    'name (ar)' => $platfrom->name_ar ?? "",
                    'Service' => implode(" - ", $platfrom->service->pluck('name_'.request('lang'))->toArray()),
                ];
            }


        return collect($data);
    }


}


