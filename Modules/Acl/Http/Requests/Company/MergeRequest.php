<?php

namespace Modules\Acl\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Acl\Entities\Company;
use Modules\Acl\Entities\CompanyWebsite;

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
        if (!empty($this->companies)){
            $ids = json_decode($this->companies[0]);
        }
        $ids[]=$this->company_id;
        $rules = Company::getValidationRules();
        $rules['companies'] = 'array|required';
        if($this->name_en && !empty($this->companies))
        {
            $count = Company::whereNotIn('id',$ids)->where('name_en',$this->name_en)->count();
            if($count)
            {
                $rules['name_en'] = $rules['name_en'] . '|unique:companies,name_en';
            }
        }
        if($this->name_ar && !empty($this->companies))
        {
            $count = Company::whereNotIn('id',$ids)->where('name_ar',$this->name_ar)->count();
            if($count)
            {
                $rules['name_ar'] = $rules['name_ar'] . '|unique:companies,name_ar';
            }
        }
        $rules['company_id'] = 'required';
        if($this->link && !empty($this->companies))
        {
        $count = CompanyWebsite::whereNotIn('company_id',$ids)->where('url',$this->link)->count();
        if($count)
        {
            $rules['link.*'] = $rules['link.*'] . '|unique:companies_websites,url';
        }
        }
        return $rules;
    }
}
