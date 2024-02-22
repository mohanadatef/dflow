<?php

namespace Modules\Report\Http\Requests\ExternalDashboard;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Report\Entities\ExternalDashboard;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
        return ExternalDashboard::getValidationRules();
    }
}
