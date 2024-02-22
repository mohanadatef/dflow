<?php

namespace Modules\CoreData\Http\Requests\Country;

use Illuminate\Foundation\Http\FormRequest;
use Modules\CoreData\Entities\Country;

class CreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Country::getValidationRules();
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
