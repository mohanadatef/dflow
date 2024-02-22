<?php

namespace Modules\CoreData\Export;

use Illuminate\Support\Collection;
use Modules\CoreData\Entities\BrandActivity;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportBrandActivity implements FromCollection, WithHeadings
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
                'موقع الايفينت',
                'مموئل',
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
                'City',
                'Event Location',
                'Sponsorship',
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

        $datas =  BrandActivity::with('influencer','platform','country','city','tag','sponsorship');
        if (request('influencer') && !empty(request('influencer'))) {
            $datas = $datas->WhereHas('brand_activity_influencer', function ($query) {
                $query->whereIn('influencer_id', request('influencer'));
            });
        }
        if (request('platform') && !empty(request('platform'))) {
            $datas = $datas->WhereHas('brand_activity_platform', function ($query) {
                $query->whereIn('platform_id', request('platform'));
            });
        }
        if (request('sponsorship') && !empty(request('sponsorship'))) {
            $datas = $datas->WhereHas('brand_activity_sponsorship', function ($query) {
                $query->whereIn('company_id', request('sponsorship'));
            });
        }
        $datas = $datas->get();
            foreach ($datas as $data) {
                $data[] = [
                    'subject' => $data->subject ?? "",
                    'brief' => $data->brief ?? "",
                    'DateFrom' => $data->date_from,
                    'DateTo' => $data->date_to,
                    'Tag' => $data->tag->{"name_".$this->request->lang} ?? "",
                    'influencer' => implode(" - ", $data->influencer->pluck('name_'.request('lang'))->toArray()),
                    'platform' => implode(" - ", $data->platform->pluck('name_'.request('lang'))->toArray()),
                    'Country' => $travel->country->{"name_".$this->request->lang} ?? "",
                    'City' => $travel->city->{"name_".$this->request->lang} ?? "",
                    'event_location' => $data->event_location ?? "",
                    'sponsorship' => implode(" - ", $data->sponsorship->pluck('name_'.request('lang'))->toArray()),
                ];
            }


        return collect($data);
    }


}


