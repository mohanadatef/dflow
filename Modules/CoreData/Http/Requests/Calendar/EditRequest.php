<?php

namespace Modules\CoreData\Http\Requests\Calendar;

use Modules\CoreData\Entities\Calendar;
use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
{
    /**
     * Determine if the User is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return Calendar::getUpdateValidationRules();
    }

}
