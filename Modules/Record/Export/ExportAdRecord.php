<?php

namespace Modules\Record\Export;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Modules\Acl\Service\CompanyService;
use Modules\Record\Entities\AdRecord;

class ExportAdRecord implements FromCollection, WithHeadings
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
                'التاريخ',
                'كود السجل',
                'الموثر بالإنجليزية',
                ' الموثر بالعربي',
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
                'رابط الشركه المعلنه',
                'رابط',
                'علم احمر'
            ];
        }else
        {
            return [
                'date',
                'Ad Record ID',
                'Influencer (en)',
                'Influencer (ar)',
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
                'promoted companies link',
                'Link',
                'red_flag'
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
        if($this->request->start && $this->request->end)
        {
            $range_start = Carbon::parse($this->request->start)->startOfDay();
            $range_end = Carbon::parse($this->request->end)->endOfDay();
        }
        if($this->request->creation_start && $this->request->creation_end)
        {
            $range_creation_start = Carbon::parse($this->request->creation_start);
            $range_creation_end = Carbon::parse($this->request->creation_end);
        }
        if($this->request->creationD_start && $this->request->creationD_end)
        {
            $range_creation_start = Carbon::parse($this->request->creationD_start);
            $range_creation_end = Carbon::parse($this->request->creationD_end);
        }
        if($this->request->creationDL_start && $this->request->creationDL_end)
        {
            $range_creation_start = Carbon::parse($this->request->creationDL_start)->setTime(9, 0, 0);
            $range_creation_end = Carbon::parse($this->request->creationDL_end)->addDays(1)->setTime(9, 0, 0);
        }
        $datas = AdRecord::select('date', 'id', 'influencer_id', 'platform_id', 'user_id', 'company_id',
            'promoted_products', 'promoted_offer', 'mention_ad', 'gov_ad', 'notes', 'price')
            ->with(['influencer', 'user', 'company', 'platform', 'service', 'category', 'target_market', 'service', 'promotion_type']);
        if(!empty($this->request->start) && !empty($this->request->end))
        {
            $datas = $datas->whereBetween('date', [$range_start, $range_end]);
        }
        if(isset($range_creation_start) && !empty($range_creation_start) && isset($range_creation_end) && !empty($range_creation_end))
        {
            $datas = $datas->whereBetween('created_at', [$range_creation_start, $range_creation_end]);
        }
        if($this->request->user && !empty($this->request->user))
        {
            $datas = $datas->whereIn('user_id', $this->request->user);
        }
        if($this->request->red_flag && !empty($this->request->red_flag))
        {
            $datas = $datas->where('red_flag', $this->request->red_flag);
        }
        if($this->request->role && !empty($this->request->role))
        {
            $datas = $datas->WhereHas('user', function($query)
            {
                $query->where('role_id', $this->request->role);
            });
        }
        if($this->request->search_admin && !empty($this->request->search_admin))
        {
            if(user()->match_search)
            {
                $s = '%' . $this->request->search_admin . '%';
                $operator = 'like';
            }else
            {
                $s = $this->request->search_admin;
                $operator = '=';
            }
            $datas = $datas->WhereHas('user', function($query) use ($operator, $s)
            {
                $query->where('name', $operator, $s)->orWhere('email', $operator, $s);
            });
        }
        if(request('influencer_id') && !empty(request('influencer_id')))
        {
            $datas = $datas->whereIn('influencer_id', request('influencer_id'));
        }
        if(request('target_company_category') && !empty(request('target_company_category')))
        {
            $company_ids = app()->make(CompanyService::class)
                ->findBy(new Request(['industry' => request('target_company_category'), 'active' => activeType()['as']]),
                    pluck: ['id', 'id'])->toArray();
            $datas = $datas->whereIn('company_id', $company_ids);
        }
        if(request('company_ids') && !empty(request('company_ids')))
        {
            $datas = $datas->whereIn('company_id', request('company_ids'));
        }
        if(request('platform_id') && !empty(request('platform_id')))
        {
            $datas = $datas->whereIn('platform_id', request('platform_id'));
        }
        if(request('category') && !empty(request('category')))
        {
            $datas = $datas->WhereHas('ad_record_category', function($query)
            {
                $query->whereIn('category_id', request('category'));
            });
        }
        if(request('search') && !empty(request('search')))
        {
            $searchTerm = request('search');
            $datas = $datas->where(function($query) use ($searchTerm)
            {
                $query->where('date', $searchTerm)
                    ->orWhereHas('influencer', function($query) use ($searchTerm)
                    {
                        $query->where('name_en', 'like', '%' . $searchTerm . '%')
                            ->orWhere('name_ar', 'like', '%' . $searchTerm . '%');
                    })
                    ->orWhereHas('company', function($query) use ($searchTerm)
                    {
                        $query->where('name_en', 'like', '%' . $searchTerm . '%')
                            ->orWhere('name_ar', 'like', '%' . $searchTerm . '%');
                    });
            });
        }
        $datas->orderBy('id', 'desc')->chunk(1000, function($adRecords) use (&$data)
        {
            foreach($adRecords as $adRecord)
            {
                $data[] = [
                    'date' => $adRecord->date,
                    'Ad Record ID' => $adRecord->id,
                    'Influencer Name (en)' => $adRecord->influencer->name_en ?? "",
                    'Influencer Name (ar)' => $adRecord->influencer->name_ar ?? "",
                    'User' => $adRecord->user->name ?? "",
                    'Company (en)' => $adRecord->company->name_en ?? "",
                    'Company (ar)' => $adRecord->company->name_ar ?? "",
                    'Promoted Products' => $adRecord->promoted_products,
                    'Promoted Offer' => $adRecord->promoted_offer,
                    'Mention Ad' => $adRecord->mention_ad ? "Yes" : "No",
                    'Gov Ad' => $adRecord->gov_ad ? "Yes" : "No",
                    'Notes' => $adRecord->notes,
                    'price' => $adRecord->price,
                    'platform' => $adRecord->platform->{"name_" . $this->request->lang} ?? "",
                    'service' => implode(" - ", $adRecord->service->pluck('name_' . request('lang'))->toArray()),
                    'category' => implode(" - ", $adRecord->category->pluck('name_' . request('lang'))->toArray()),
                    'target_market' => implode(" - ",
                        $adRecord->target_market->pluck('name_' . request('lang'))->toArray()),
                    'promotion_type' => implode(" - ",
                        $adRecord->promotion_type->pluck('name_' . request('lang'))->toArray()),
                    'ad_link' => route('ad_record.show', $adRecord->id),
                    'promoted_companies_link' => implode(',',
                            $adRecord->company->company_website()->pluck('url')->toArray()) ?? "",
                    'Link' => $adRecord->url_post ?? "",
                    'red_flag' => $adRecord->red_flag ? "Yes" : "No",
                ];
            }
        });
        return collect($data);
    }
}


