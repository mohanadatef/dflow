<?php

namespace Modules\Record\Http\Requests\ContentRecord;

use Modules\Record\Entities\ContentRecord;
use Illuminate\Foundation\Http\FormRequest;

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
        return ContentRecord::getValidationRules();
    }


}
