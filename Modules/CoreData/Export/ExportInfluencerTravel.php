<?php

namespace Modules\CoreData\Export;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Modules\CoreData\Entities\InfluencerTravel;

class ExportInfluencerTravel implements FromCollection, WithHeadings
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
                'الموثر',
                'البلد',
                'المدينة',
                'من تاريخ',
                'الى تاريخ',
            ];
        } else {
            return [
                'Influencer',
                'Country',
                'City',
                'Date From',
                'Date To',
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

        $datas =  InfluencerTravel::with('influencer','country','city');
        if (request('influencer_id') && !empty(request('influencer_id'))) {
            $datas = $datas->whereIn('influencer_id', request('influencer_id'));
        }
        $datas = $datas->get();

            foreach ($datas as $travel) {
                $data[] = [
                    'Influencer' => $travel->influencer->{"name_".$this->request->lang} ?? "",
                    'Country' => $travel->country->{"name_".$this->request->lang} ?? "",
                    'City' => $travel->city->{"name_".$this->request->lang} ?? "",
                    'DateFrom' => $travel->date_from,
                    'DateTo' => $travel->date_to,
                ];
            }


        return collect($data);
    }


}


