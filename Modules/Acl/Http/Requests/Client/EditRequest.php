<?php

namespace Modules\Acl\Http\Requests\Client;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Basic\Traits\validationRulesTrait;

class EditRequest extends FormRequest
{
    use validationRulesTrait;

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
        $rules = User::getValidationRulesUpdate();
        $rules['company_id'] ='required';
        $rules['name'] = $rules['name'] . ',name,' . $this->id . ',id';
        $rules['email'] = $rules['email'] . ',email,' . $this->id . ',id';
        if(user()->role_id != 1)
        {
            $rules['email'] =str_replace('required|', '', $rules['email']);
        }
        return $rules;
    }

}
