<?php

namespace Modules\Acl\Export;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Modules\Acl\Entities\Company;

class ExportCompany implements FromCollection, WithHeadings
{
    private $request = null;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function headings(): array
    {
        if($this->request->lang == 'ar')
        {
            return [
                'رقم',
                'الاسم بالإنجليزية',
                ' الاسم بالعربي',
                'رابط',
                'معلومات الوصول',
                'مجالات',
            ];
        }else
        {
            return [
                'Id',
                'Name (en)',
                'Name (ar)',
                'link',
                'Contact Info',
                'Industry',
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
        $datas = Company::with('industry');
        if(request('industry') && !empty(request('industry')))
        {
            $datas = $datas->WhereHas('company_industry', function($query)
            {
                $query->where('industry_id', request('industry'));
            });
        }
        if(request('link') && !empty(request('link')))
        {
            $datas = $datas->WhereHas('company_website', function($query)
            {
                if(user()->match_search)
                {
                    $s = '%' . request('link') . '%';
                    $operator = 'like';
                }else
                {
                    $s = request('link');
                    $operator = '=';
                }
                $query->where('url',$operator, $s);
            });
        }
        $datas = $datas->get();
        foreach($datas as $company)
        {
            $data[] = [
                'Id' => $company->id,
                'Name (en)' => $company->name_en ?? "",
                'Name (ar)' => $company->name_ar ?? "",
                'link' => implode(',',$company->company_website()->pluck('url')->toArray()),
                'Contact Info' => $company->contact_info ?? "",
                'Industry' => implode(" - ", $company->industry->pluck('name_' . request('lang'))->toArray()),
            ];
        }
        return collect($data);
    }
}


