<?php

namespace Modules\CoreData\Http\Requests\Location;

use Illuminate\Foundation\Http\FormRequest;
use Modules\CoreData\Entities\Location;

class EditRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = Location::getValidationRules();
        $rules['name_en'] = $rules['name_en'] . ',name_en,' . $this->id . ',id';
        $rules['name_ar'] = $rules['name_ar'] . ',name_ar,' . $this->id . ',id';
        if($this->code)
        {
            $rules['code'] = $rules['code']. '|unique:locations,code,'. $this->id . ',id';
        }
        return $rules;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
