<?php

namespace Modules\Acl\Http\Requests\Influencer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Acl\Entities\Company;
use Modules\Acl\Entities\Influencer;

class MergeRequest extends FormRequest
{
    /**
     * Determine if the User is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = Influencer::getValidationRules();
        $rules['name_en'] ='required|string|regex:/^[a-zA-Z0-9\s]+$/';
        $rules['name_ar'] ='required|string';
        $rules['influencer_id'] = 'required';
        $ids[]=$this->influencer_id;
        $ids[]=$this->id;
        if($this->name_en)
        {
            $count = Influencer::whereNotIn('id',$ids)->where('name_en',$this->name_en)->count();
            if($count)
            {
                $rules['name_en'] = $rules['name_en'] . '|unique:influencers,name_en';
            }
        }
        if($this->name_ar )
        {
            $count = Influencer::whereNotIn('id',$ids)->where('name_ar',$this->name_ar)->count();
            if($count)
            {
                $rules['name_ar'] = $rules['name_ar'] . '|unique:influencers,name_ar';
            }
        }
        return $rules;
    }
}
