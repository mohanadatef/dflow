<?php

namespace Modules\CoreData\Http\Requests\Calendar;

use Modules\CoreData\Entities\Calendar;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $from
 * @property mixed $to
 */
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
        return Calendar::getValidationRules();
    }


}
