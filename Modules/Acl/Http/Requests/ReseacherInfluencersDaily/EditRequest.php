<?php

namespace Modules\Acl\Http\Requests\ReseacherInfluencersDaily;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Acl\Entities\ReseacherInfluencersDaily;
use Modules\Basic\Traits\validationRulesTrait;

class EditRequest extends FormRequest
{
    use validationRulesTrait;

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
        return ReseacherInfluencersDaily::getValidationRules();
    }

}
