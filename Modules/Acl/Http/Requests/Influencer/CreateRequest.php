<?php

namespace Modules\Acl\Http\Requests\Influencer;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Acl\Entities\Influencer;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the Influencer is authorized to make this request.
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
        return Influencer::getValidationRules();
    }

}
