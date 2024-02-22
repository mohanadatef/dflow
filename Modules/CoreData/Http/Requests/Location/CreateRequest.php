<?php

namespace Modules\CoreData\Http\Requests\Location;

use Illuminate\Foundation\Http\FormRequest;
use Modules\CoreData\Entities\Location;

class CreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules =  Location::getValidationRules();
        if($this->code)
        {
            $rules['code'] = $rules['code']. '|unique:locations';
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
