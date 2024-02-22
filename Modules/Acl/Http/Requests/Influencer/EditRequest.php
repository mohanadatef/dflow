<?php

namespace Modules\Acl\Http\Requests\Influencer;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Acl\Entities\Influencer;
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

    protected function prepareForValidation()
    {
        $this->merge(['mobile' => $this->convertPersian($this->mobile)]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = Influencer::getValidationRules();
        $rules['name_en'] = $rules['name_en'] . ',name_en,' . $this->id . ',id';
        $rules['name_ar'] = $rules['name_ar'] . ',name_ar,' . $this->id . ',id';
        return $rules;
    }

}
