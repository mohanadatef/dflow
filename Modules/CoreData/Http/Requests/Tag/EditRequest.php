<?php

namespace Modules\CoreData\Http\Requests\Tag;

use Illuminate\Foundation\Http\FormRequest;
use Modules\CoreData\Entities\Tag;

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
        $rules = Tag::getValidationRules();
        $rules['name'] = $rules['name'] . ',name,' . $this->id . ',id';
        return $rules;
    }

}
