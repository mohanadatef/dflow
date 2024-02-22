<?php

namespace Modules\CoreData\Http\Requests\Country;

use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_ar' => 'required|unique:countries,name_ar,' . $this->id,
            'name_en' => 'required|unique:countries,name_en,' . $this->id,
            'code' => 'required|unique:countries,code,' . $this->id,
        ];
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
