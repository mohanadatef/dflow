<?php

namespace Modules\Material\Export;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Modules\Material\Entities\InfluencerTrend;

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

        $datas =  InfluencerTrend::with('influencer','country','tag');
        if (request('influencer') && !empty(request('influencer'))) {
            $datas = $datas->WhereHas('influencer_trend_influencer', function ($query) {
                $query->whereIn('influencer_id', request('influencer'));
            });
        }
        $datas = $datas->get();
        foreach ($datas as $data) {
                $dat[] = [
                    'subject' => $data->subject ?? "",
                    'brief' => $data->brief ?? "",
                    'DateFrom' => $data->date_from,
                    'DateTo' => $data->date_to,
                    'Tag' => implode(" - ", $data->tag->pluck('name')->toArray()),
                    'influencer' => implode(" - ", $data->influencer->pluck('name_'.request('lang'))->toArray()),
                    'Country' => $data->country->{"name_".$this->request->lang} ?? "",
                    'audience_impression' => $data->audience_impression ?? "",
                ];
            }


        return collect($dat);
    }


}


