<?php

namespace Modules\Acl\Http\Requests\Client;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Basic\Traits\validationRulesTrait;

class CreateRequest extends FormRequest
{
    use validationRulesTrait;

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
    public function rules()
    {
   
        $rules = User::getValidationRules();
        $rules['company_id'] ='required';
        return $rules;
    }

}
