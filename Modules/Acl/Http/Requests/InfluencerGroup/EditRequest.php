<?php

namespace Modules\Acl\Http\Requests\InfluencerGroup;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Acl\Entities\InfluencerGroup;
use Modules\Basic\Traits\validationRulesTrait;

class EditRequest extends FormRequest
{
    use validationRulesTrait;

    /**
     * Determine if the Influencer is authorized to make this request.
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
        $rules = InfluencerGroup::getValidationRules();
        $rules['name_en'] = $rules['name_en'] . ',name_en,' . $this->id . ',id';
        $rules['name_ar'] = $rules['name_ar'] . ',name_ar,' . $this->id . ',id';
        return $rules;
    }

}
