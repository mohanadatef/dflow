<?php

namespace Modules\Record\Http\Requests\AdRecord;

use Illuminate\Foundation\Http\FormRequest;

class FixCategoryRequest extends FormRequest
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
        return [
            'target_company_category'=>'required|exists:categories,id',
            'correct_category'=>'required|exists:categories,id',
            'misclassified_category'=>'exists:categories,id',
        ];
    }
}
