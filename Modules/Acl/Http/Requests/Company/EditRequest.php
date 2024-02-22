<?php

namespace Modules\Acl\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Acl\Entities\Company;

class EditRequest extends FormRequest
{
    public function __construct()
    {
        $this->name_en_u=false;
        $this->name_ar_u=false;
    }
    /**
     * Determine if the User is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if(!empty($this->industry))
        {
        $company_en=Company::where('id','!=',$this->id)->where('name_en',$this->name_en)->whereHas('industry',function ($query) {
            $query->whereIn('industry_id',$this->industry);
        })->first();
        if(!is_null($company_en))
        {
            $this->name_en_u=true;
        }
        $company_ar=Company::where('id','!=',$this->id)->where('name_ar',$this->name_ar)->whereHas('industry',function ($query) {
            $query->whereIn('industry_id',$this->industry);
        })->first();
        if(!is_null($company_ar))
        {
            $this->name_ar_u=true;
        }
        }
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = Company::getValidationRules();
        if($this->name_en_u)
        {
            $rules['name_en'] = $rules['name_en'] . '|unique:companies,name_en,' . $this->id . ',id';
        }
        if($this->name_ar_u)
        {
            $rules['name_ar'] = $rules['name_ar'] . '|unique:companies,name_ar,' . $this->id . ',id';
        }
        $rules['link.*'] = $rules['link.*'] . '|unique:companies_websites,url,' . $this->id . ',company_id';
        return $rules;
    }

}
