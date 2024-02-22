<?php

namespace Modules\Record\Http\Requests\AdRecordDraft;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Acl\Entities\Company;
use Modules\Acl\Entities\CompanyWebsite;

class EditRequest extends FormRequest
{
    public function __construct()
    {
        parent::__construct();
        $this->name_en_u=false;
        $this->name_ar_u=false;
        $this->link_v=false;
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
        $company=null;
        if(!empty($this->industry))
        {
            $company_en=Company::where('name_en',$this->name_en)->whereHas('industry',function ($query) {
                $query->whereIn('industry_id',$this->industry);
            })->first();
            if(!is_null($company_en))
            {
                $this->name_en_u=true;
            }
            $company_ar=Company::where('name_ar',$this->name_ar)->whereHas('industry',function ($query) {
                $query->whereIn('industry_id',$this->industry);
            })->first();
            if(!is_null($company_ar))
            {
                $this->name_ar_u=true;
            }
            if($this->link)
            {
                $l = CompanyWebsite::whereIn('url',$this->link)->first();
                if(!is_null($l))
                {
                    $this->link_v=true;
                }
            }
            if(! $this->name_ar_u && ! $this->name_en_u && ! $this->link_v) {
                $company = Company::create(['name_en' => $this->name_en, 'name_ar' => $this->name_ar]);
                $company->industry()->sync((array)$this->industry);
                $this->request->add(['company_id' => $company->id]);
                if($this->link)
                {
                foreach ($this->link as $key => $value){
                    $company->company_website()->create(['website_id' => $key, 'url' => strtolower($value)]);
                }
                }
            }
        }
        if(!empty($this->company_industry))
        {
            if($company)
            {
                $company->industry()->sync((array)$this->company_industry);
            }else{
                $company = Company::find($this->company_id);
                $company->industry()->sync((array)$this->company_industry);
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
        $name_ar = 'required|string';
        $name_en = 'required|string';
        $link = 'required';
        $rules = [];
        if($this->name_en_u)
        {
            $rules['name_en'] = $name_en . '|unique:companies';

        }
        if($this->name_ar_u)
        {
            $rules['name_ar'] = $name_ar . '|unique:companies';

        }
        if($this->link_v)
        {
            $rules['link.*'] = $link . '|unique:companies_websites,url';

        }

        return $rules;
    }

}
