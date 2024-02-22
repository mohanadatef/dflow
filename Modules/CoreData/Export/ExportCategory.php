<?php

namespace Modules\CoreData\Export;

use Illuminate\Support\Collection;
use Modules\CoreData\Entities\Category;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportCategory implements FromCollection, WithHeadings
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
                ' اسم الاب',
                'مجموعه',
            ];
        } else {
            return [
                'Name (en)',
                'Name (ar)',
                'Parent Name',
                'group',
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

        $datas =  Category::with('parents');
        if (request('group') && !empty(request('group'))) {
            $datas = $datas->where('group', request('group'));
        }
        $datas = $datas->get();

            foreach ($datas as $category) {
                $data[] = [
                    'name (en)' => $category->name_en ?? "",
                    'name (ar)' => $category->name_ar ?? "",
                    'parent name' => $category->parents->{"name_".$this->request->lang} ?? "",
                    'group' => $category->group ?? "",
                ];
            }


        return collect($data);
    }


}


