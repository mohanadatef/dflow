<?php

namespace Modules\CoreData\Http\Requests\Website;

use Illuminate\Foundation\Http\FormRequest;
use Modules\CoreData\Entities\Website;

class EditRequest extends FormRequest
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


    protected function prepareForValidation()
    {
        $keys = json_decode($this->key, 1);
        {
            $this->merge(['key' => $keys]);
        }
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules()
    {
        $rules = Website::getValidationRules();

        $rules['name_en'] = $rules['name_en'] . ',name_en,' . $this->id . ',id';
        $rules['name_ar'] = $rules['name_ar'] . ',name_ar,' . $this->id . ',id';
        $rules['key.*'] = $rules['key.*'] . ','.$this->id . ',website_id';

        return $rules;
    }

}
