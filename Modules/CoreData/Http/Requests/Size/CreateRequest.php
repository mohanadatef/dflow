<?php

namespace Modules\CoreData\Http\Requests\Size;

use Illuminate\Foundation\Http\FormRequest;
use Modules\CoreData\Entities\Size;

class CreateRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Size::getValidationRules();
    }


}
