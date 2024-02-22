<?php

namespace Modules\CoreData\Export;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Modules\CoreData\Entities\Location;

class ExportLocation implements FromCollection, WithHeadings
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
                'اسم الاب',
            ];
        } else {
            return [
                'Name (en)',
                'Name (ar)',
                'Parent Name',
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

        $datas =  Location::with('parents');
        if (request('parent_id') && !empty(request('parent_id'))) {
            $datas = $datas->where('parent_id', request('parent_id'));
        }
        $datas = $datas->get();

            foreach ($datas as $location) {
                $data[] = [
                    'name (en)' => $location->name_en ?? "",
                    'name (ar)' => $location->name_ar ?? "",
                    'parent name' => $location->parents->{"name_".$this->request->lang} ?? "",
                ];
            }
        return collect($data);
    }


}


