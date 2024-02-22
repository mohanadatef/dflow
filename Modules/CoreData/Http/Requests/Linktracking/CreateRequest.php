<?php

namespace Modules\CoreData\Http\Requests\Linktracking;

use Illuminate\Foundation\Http\FormRequest;
use Modules\CoreData\Entities\LinkTracking;

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
        return LinkTracking::getValidationRules();
    }


}
