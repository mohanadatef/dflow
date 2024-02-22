<?php

namespace Modules\CoreData\Export;

use Illuminate\Support\Collection;
use Modules\CoreData\Entities\BrandActivity;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Modules\CoreData\Entities\InfluencerTrend;

class ExportInfluencerTrend implements FromCollection, WithHeadings
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
                'الموضوع',
                'نبذه',
                'من تاريخ',
                'الى تاريخ',
                'تاج',
                'الموثر',
                'بلات فورم',
                'البلد',
                'المدينة',
                'انطباع الجمهور',
            ];
        } else {
            return [
                'Subject',
                'Brief',
                'Date From',
                'Date To',
                'Tag',
                'Influencer',
                'Platform',
                'Country',
                'audience_impression',
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

        $datas =  InfluencerTrend::with('influencer','platform','country','tag');
        if (request('influencer_id') && !empty(request('influencer_id'))) {
            $datas = $datas->whereIn('influencer_id', request('influencer_id'));
        }
        if (request('platform') && !empty(request('platform'))) {
            $datas = $datas->WhereHas('influencer_trend_platform', function ($query) {
                $query->whereIn('platform_id', request('platform'));
            });
        }
        $datas = $datas->get();
        foreach ($datas as $data) {
                $dat[] = [
                    'subject' => $data->subject ?? "",
                    'brief' => $data->brief ?? "",
                    'DateFrom' => $data->date_from,
                    'DateTo' => $data->date_to,
                    'Tag' => $data->tag->{"name_".$this->request->lang} ?? "",
                    'influencer' => $data->influencer->{"name_".$this->request->lang} ?? "",
                    'platform' => implode(" - ", $data->platform->pluck('name_'.request('lang'))->toArray()),
                    'Country' => $data->country->{"name_".$this->request->lang} ?? "",
                    'audience_impression' => $data->audience_impression ?? "",
                ];
            }


        return collect($dat);
    }


}


