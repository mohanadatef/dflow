<?php

namespace Modules\Setting\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Setting\Entities\Contact;
use Modules\Setting\Entities\Fq;

class CreateRequest extends FormRequest
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
        return Contact::getValidationRules();
    }


}
