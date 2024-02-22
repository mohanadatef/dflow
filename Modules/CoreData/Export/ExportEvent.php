<?php

namespace Modules\CoreData\Export;

use Illuminate\Support\Collection;
use Modules\CoreData\Entities\Event;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportEvent implements FromCollection, WithHeadings
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
                'الكاتيجورى',
                'البلد',
                'المدينة',
            ];
        } else {
            return [
                'Subject',
                'Brief',
                'Date From',
                'Date To',
                'Tag',
                'Influencer',
                'Category',
                'Country',
                'City',
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

        $datas =  Event::with('influencer','category','country','city','tag');
        if (request('category') && !empty(request('category'))) {
            $datas = $datas->WhereHas('event_category', function ($query) {
                $query->whereIn('category_id', request('category'));
            });
        }
        if (request('influencer') && !empty(request('influencer'))) {
            $datas = $datas->WhereHas('event_influencer', function ($query) {
                $query->whereIn('influencer_id', request('influencer'));
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
                    'category' => implode(" - ", $data->category->pluck('name_'.request('lang'))->toArray()),
                    'Country' => $travel->country->{"name_".$this->request->lang} ?? "",
                    'City' => $travel->city->{"name_".$this->request->lang} ?? "",
                ];
            }


        return collect($data);
    }


}


