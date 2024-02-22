<?php

namespace Modules\Acl\Export;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportUser implements FromCollection, WithHeadings
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
            ];
        } else {
            return [
                'Name',
                'Role',
                'Email',
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

        $datas =  User::with('role')->whereHas('role',function($query){
                $query->where('type',0);
        })->get();

        foreach ($datas as $user) {
            $data[] = [
                'name' => $user->name ?? "",
                'role' => $user->role->name ?? "",
                'email' => $user->email ?? "",
            ];
        }


        return collect($data);
    }


}


