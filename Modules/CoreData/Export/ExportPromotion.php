<?php

namespace Modules\CoreData\Export;

use Illuminate\Support\Collection;
use Modules\CoreData\Entities\PromotionType;
use Modules\CoreData\Entities\Service;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportPromotion implements FromCollection, WithHeadings
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

        $datas =  PromotionType::all();

            foreach ($datas as $PromotionType) {
                $data[] = [
                    'name (en)' => $PromotionType->name_en ?? "",
                    'name (ar)' => $PromotionType->name_ar ?? "",
                ];
            }


        return collect($data);
    }


}


