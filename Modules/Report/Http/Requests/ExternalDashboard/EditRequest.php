<?php

namespace Modules\Report\Http\Requests\ExternalDashboard;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Report\Entities\ExternalDashboard;

class EditRequest extends FormRequest
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
        $rules = ExternalDashboard::getValidationRules();
        $rules['name'] = $rules['name'] . ',name,' . $this->id . ',id';
        $rules['major'] = 'required';
        $rules['minor'] = 'required';
        $rules['batch'] = 'required';
        return $rules;
    }
}
