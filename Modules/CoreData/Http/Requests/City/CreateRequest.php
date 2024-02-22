<?php

namespace Modules\CoreData\Http\Requests\City;

use Illuminate\Foundation\Http\FormRequest;
use Modules\CoreData\Entities\City;

class CreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return City::getValidationRules();
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
