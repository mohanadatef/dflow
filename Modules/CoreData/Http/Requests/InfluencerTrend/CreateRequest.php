<?php

namespace Modules\CoreData\Http\Requests\InfluencerTrend;

use Illuminate\Foundation\Http\FormRequest;
use Modules\CoreData\Entities\InfluencerTrend;
use Modules\CoreData\Entities\Tag;

class CreateRequest extends FormRequest
{
    public function __construct()
    {
        parent::__construct();
        $this->name_en_u = false;
        $this->name_ar_u = false;
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
        $tag = null;
        if(isset($this->tag_id) && empty($this->tag_id))
        {
            if(isset($this->name_en))
            {
                $tag_en = Tag::where('name_en', $this->name_en)->first();
                if(!is_null($tag_en))
                {
                    $this->name_en_u = true;
                }
            }else
            {
                $this->name_en_u = true;
            }
            if(isset($this->name_ar))
            {
                $tag_ar = Tag::where('name_ar', $this->name_ar)->first();
                if(!is_null($tag_ar))
                {
                    $this->name_ar_u = true;
                }
            }else
            {
                $this->name_en_u = true;
            }
            if(!$this->name_ar_u && !$this->name_en_u)
            {
                $tag = Tag::create(['name_en' => $this->name_en, 'name_ar' => $this->name_ar]);
                $this->request->add(['tag_id' => $tag->id]);
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
        $rules = InfluencerTrend::getValidationRules();
        $name_ar = 'required|string';
        $name_en = 'required|string';
        if($this->name_en_u)
        {
            $rules['name_en'] = $name_en . '|unique:tags';
        }
        if($this->name_ar_u)
        {
            $rules['name_ar'] = $name_ar . '|unique:tags';
        }
        return $rules;
    }
}
