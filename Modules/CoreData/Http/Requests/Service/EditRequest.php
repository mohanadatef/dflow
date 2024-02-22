<?php

namespace Modules\CoreData\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;
use Modules\CoreData\Entities\Service;

class EditRequest extends FormRequest
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
        $rules = Service::getValidationRules();
        $rules['name_en'] = $rules['name_en'] . ',name_en,' . $this->id . ',id';
        $rules['name_ar'] = $rules['name_ar'] . ',name_ar,' . $this->id . ',id';
        return $rules;
    }

}
