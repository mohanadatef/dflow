<?php

namespace Modules\Record\Http\Requests\AdRecord;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Acl\Entities\Company;
use Modules\Acl\Entities\CompanyWebsite;
use Modules\Record\Entities\AdRecord;

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
            if(isset($this->name_en) && !empty($this->name_en))
            {
                $company_en = Company::where('name_en', $this->name_en)->whereHas('industry', function($query)
                {
                    $query->whereIn('industry_id', $this->industry);
                })->first();
                if(!is_null($company_en))
                {
                    $this->name_en_u = true;
                }
            }
            if(isset($this->name_ar) && !empty($this->name_ar))
            {
                $company_ar = Company::where('name_ar', $this->name_ar)->whereHas('industry', function($query)
                {
                    $query->whereIn('industry_id', $this->industry);
                })->first();
                if(!is_null($company_ar))
                {
                    $this->name_ar_u = true;
                }
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
        $rules= AdRecord::getValidationRules();
        $name_ar = 'required|string';
        $name_en = 'required|string';
        $link = 'required';
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
        if(empty($this->company_id))
        {

            $rules['industry'] = 'required|array';
        }
        if($this->is_promoted_products)
        {
            $rules['promoted_products'] = 'required';
        }
        if($this->is_promoted_offer)
        {
            $rules['promoted_offer'] = 'required';
        }
        return $rules;
    }

}
