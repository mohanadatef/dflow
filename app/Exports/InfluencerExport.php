<?php

namespace App\Exports;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Modules\Acl\Entities\Influencer;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InfluencerExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return array_merge(['id', 'INFLUENCER NAME', 'PLATFORM INFO', 'TYPE', 'CATEGORY', 'GENDER'],platformType());
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
            $query = $query->whereIn('country_id' , request('country_id'));

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
        foreach ($influencer as $if) {
            $platformIf = "";
            $categoryIf = "";
            $sizeIf = "";
            $keys=array_keys(array_flip(platformType()));
            $values = array_fill(0, count($keys), null);
            $new_array = array_combine($keys, $values);
            foreach ($if->influencer_follower_platform as $follower) {
                $sizeIf = $sizeIf . $follower->size?->name_en . ',';
                $platformIf = $platformIf . $follower->platform?->name_en  .',';
                $new_array[$follower->platform?->name_en] =  $follower->url;
            }
            foreach ($if->category as $category) {
                $categoryIf = $categoryIf . $category->name_en . ',';
            }
            $data [] = array_merge([
                'id' => $if->id,
                "INFLUENCER NAME" => $if->name_en,
                "PLATFORM INFO" => $platformIf,
                "TYPE" => $sizeIf,
                "CATEGORY" => $categoryIf,
                "GENDER" => $if->gender,
            ],$new_array);
        }
        return collect($data);
    }
}
