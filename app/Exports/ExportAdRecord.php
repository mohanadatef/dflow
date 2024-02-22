<?php

namespace App\Exports;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Modules\Record\Entities\AdRecord;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportAdRecord implements FromCollection, WithHeadings
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
                'التاريخ',
                'كود السجل',
                'المؤثر',
                'المستخدم',
                'الشركة بالإنجليزية',
                ' الشركة بالعربي',
                'المنتجات المروجة',
                'العروض المروجة',
                'ذكر كلمة إعلان',
                'إعلان حكومي',
                'ملحوظات',
                'السعر',
                'المنصة',
                'الخدمة',
                'الفئة',
                'البلد المستهدف',
                'نوع الترويج',
                'رابط الاعلان',
                'رابط الشركه المعلنه'
            ];
        } else {
            return [
                'date',
                'Ad Record ID',
                'Influencer',
                'User',
                'Company (en)',
                'Company (ar)',
                'Promoted Products',
                'Promoted Offer',
                'Mention Ad',
                'Gov Ad',
                'Notes',
                'price',
                'platform',
                'service',
                'category',
                'target market',
                'promotion type',
                'ad link',
                'promoted companies link'
            ];
        }
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        ini_set('memory_limit', '-1');
        // category, user, influencer
        $data = [];

        if ($this->request->start && $this->request->end) {
            $range_start = Carbon::parse($this->request->start)->startOfDay();
            $range_end = Carbon::parse($this->request->end)->endOfDay();
        }
        if ($this->request->creation_start && $this->request->creation_end) {
            $range_creation_start = Carbon::parse($this->request->creation_start)->startOfDay();
            $range_creation_end = Carbon::parse($this->request->creation_end)->endOfDay();
        }

        $datas = AdRecord::select('date', 'id', 'influencer_id','platform_id','service_id', 'user_id', 'company_id', 'promoted_products', 'promoted_offer', 'mention_ad', 'gov_ad', 'notes', 'price')
            ->with(['influencer', 'user', 'company', 'platform', 'service', 'category', 'target_market', 'promotion_type']);

        if (!empty($this->request->start) && !empty($this->request->end)) {
            $datas = $datas->whereBetween('date', [$range_start, $range_end]);
        }

        if (isset($range_creation_start) && !empty($range_creation_start) && isset($range_creation_end) && !empty($range_creation_end)) {
            $datas = $datas->whereBetween('created_at', [$range_creation_start, $range_creation_end]);
        }
        if ($this->request->user && !empty($this->request->user)) {
            $datas = $datas->whereIn('user_id', $this->request->user);
        }
        if (request('influencer_id') && !empty(request('influencer_id'))) {
            $datas = $datas->whereIn('influencer_id', request('influencer_id'));
        }
        if (request('company_ids') && !empty(request('company_ids'))) {
            $datas = $datas->whereIn('company_id', request('company_ids'));
        }
        if (request('platform_id') && !empty(request('platform_id'))) {
            $datas = $datas->whereIn('platform_id', request('platform_id'));
        }
        if (request('category') && !empty(request('category'))) {
            $datas = $datas->WhereHas('ad_record_category', function ($query) {
                $query->whereIn('category_id', request('category'));
            });
        }

        if (request('search') && !empty(request('search'))) {
            $searchTerm = request('search');

            $datas = $datas->where(function ($query) use ($searchTerm) {
                $query->where('date', $searchTerm)
                    ->orWhereHas('influencer', function ($query) use ($searchTerm) {
                        $query->where('name_en', 'like', '%' . $searchTerm . '%')
                            ->orWhere('name_ar', 'like', '%' . $searchTerm . '%');
                    })
                    ->orWhereHas('company', function ($query) use ($searchTerm) {
                        $query->where('name_en', 'like', '%' . $searchTerm . '%')
                            ->orWhere('name_ar', 'like', '%' . $searchTerm . '%');
                    });
            });
        }

        $datas->orderBy('id', 'desc')->chunk(1000, function ($adRecords) use (&$data) {
            foreach ($adRecords as $adRecord) {
                $data[] = [
                    'date' => $adRecord->date,
                    'Ad Record ID' => $adRecord->id,
                    'Influencer Name' => $adRecord->influencer->{"name_".request('lang')} ?? "",
                    'User' => $adRecord->user->name ?? "",
                    'Company (en)' => $adRecord->company->name_en ?? "",
                    'Company (ar)' => $adRecord->company->name_ar ?? "",
                    'Promoted Products' => $adRecord->promoted_products,
                    'Promoted Offer' => $adRecord->promoted_offer,
                    'Mention Ad' => $adRecord->mention_ad ? "Yes" : "No",
                    'Gov Ad' => $adRecord->gov_ad ? "Yes" : "No",
                    'Notes' => $adRecord->notes,
                    'price' => $adRecord->price,
                    'platform' => $adRecord->platform->{"name_".$this->request->lang} ?? "",
                    'service' => $adRecord->service->{"name_".$this->request->lang} ?? "",
                    'category' => implode(" - ", $adRecord->category->pluck('name_'.request('lang'))->toArray()),
                    'target_market' => implode(" - ", $adRecord->target_market->pluck('name_'.request('lang'))->toArray()),
                    'promotion_type' => implode(" - ", $adRecord->promotion_type->pluck('name_'.request('lang'))->toArray()),
                    'ad_link' => route('ad_record.show',$adRecord->id),
                    'promoted_companies_link' => $adRecord->company->link ?? "",
                ];
            }
        });

        return collect($data);
    }


}


