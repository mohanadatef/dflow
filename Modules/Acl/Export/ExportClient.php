<?php

namespace Modules\Acl\Export;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportClient implements FromCollection, WithHeadings
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
                'الدور',
                'البريد الالكتروني',
                'شركة',
                'ويب سيت',
                'مجالات',
            ];
        } else {
            return [
                'Name',
                'Role',
                'Email',
                'Company',
                'Website',
                'Category',
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

        $datas =  User::with('role','company')->whereHas('role',function($query){
        $query->where('type',1);
    })->get();

        foreach ($datas as $user) {
            $data[] = [
                'name' => $user->name ?? "",
                'role' => $user->role->name ?? "",
                'email' => $user->email ?? "",
                'company' => $user->company->{"name_".$this->request->lang} ?? "",
                'website' => $user->website ?? "",
                'category' => implode(" - ", $user->category->pluck('name_'.request('lang'))->toArray()) ?? "",
            ];
        }


        return collect($data);
    }


}


