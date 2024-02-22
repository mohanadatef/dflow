<?php

namespace Modules\Acl\Export;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Modules\Acl\Entities\Influencer;

class InfluencerExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return array_merge(['id', 'name_en','name_ar', 'platform_info', 'type', 'category', 'gender','city'],platformType()['platform'],platformType()['service']);
    }

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection(): Collection
    {
        $data = [];
        $query = Influencer::with('influencer_follower_platform', 'influencer_follower_platform.size', 'category', 'platform');
        if (isset($this->request->infuencerSelect) && !empty($this->request->infuencerSelect)) {
            if (isset($this->request->infuencerSelect) && !empty($this->request->infuencerSelect)) {
                if (is_array($this->request->infuencerSelect)) {
                    $query->whereIn('id', $this->request->infuencerSelect)->get();
                } elseif (str_contains($this->request->infuencerSelect, ',')) {
                    $query->whereIn('id', explode(',', $this->request->infuencerSelect))->get();
                } else {
                    $query->where('id', $this->request->infuencerSelect)->get();
                }
            }
        }
        if(isset($this->request->gender) && !empty($this->request->gender))
        {
            $query = $query->where('gender',$this->request->gender);
        }

        if(request('country_id') && !empty(request('country_id')))
        {
            $query = $query->WhereHas('country', function ($query1) {
                $query1->whereIn('country_id' , request('country_id'));
            });
        }
        if(request('category') && !empty(request('category')))
        {
            $query = $query->WhereHas('category', function ($query1) {
                $query1->whereIn('category_id' , request('category'));
            });
        }
        if(request('size') && !empty(request('size')))
        {
            $query = $query->WhereHas('influencer_follower_platform', function ($query1) {
                $query1->whereIn('size_id' , request('size'));
            });
        }
        if(isset($this->request->name) && !empty($this->request->name))
        {
            $query = $query->where(function ($q){
                $q->where('name_en','like','%'.$this->request->name.'%')->orWhere('name_ar','like','%'.$this->request->name.'%');
            });
        }
        $influencer = $query->get();
        $platform_keys=array_keys(array_flip(platformType()['platform']));
        $service_keys=array_keys(array_flip(platformType()['service']));
        $platform_values = array_fill(0, count($platform_keys), null);
        $service_values = array_fill(0, count($service_keys), 0);
        $platform_new_array = array_combine($platform_keys, $platform_values);
        $service_new_array = array_combine($service_keys, $service_values);
        foreach ($influencer as $if) {
            $platformIf = [];
            $sizeIf = [];
            $service_new_arra = $service_new_array;
            $platform_new_arra = $platform_new_array;
            foreach ($if->influencer_follower_platform as $follower) {
                $sizeIf[] =  $follower->size?->name_en;
                $platformIf[] =  $follower->platform?->name_en;
                $platform_new_arra[$follower->platform?->name_en] =  $follower->url;
            }
            foreach($if->influencer_service_platform as $service_platform)
            {
                $service_new_arra[$service_platform->platform->name_en .'_'.$service_platform->service->name_en] = $service_platform->price ?? 0;
            }
            $data [] = array_merge([
                'id' => $if->id,
                "name_en" => $if->name_en,
                "name_ar" => $if->name_ar,
                "platform_info" => implode(',',$platformIf),
                "type" => implode(',',$sizeIf),
                "category" => implode(',',$if->category->pluck('name_en')->toArray()),
                "gender" => $if->gender,
                "city" => implode(',',$if->city->pluck('name_en')->toArray() ?? []),
            ],$platform_new_arra,$service_new_arra);
        }
        return collect($data);
    }
}
