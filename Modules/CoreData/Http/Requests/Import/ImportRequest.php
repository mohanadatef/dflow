<?php

namespace Modules\CoreData\Http\Requests\Import;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ImportRequest extends FormRequest
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
        return [
            'file' => 'required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->redirect = $this::url();
        session()->put('bad', 'You must import the file first.');
        parent::failedValidation($validator);
    }

}
