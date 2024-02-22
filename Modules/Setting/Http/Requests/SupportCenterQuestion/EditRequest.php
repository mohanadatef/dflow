<?php

namespace Modules\Setting\Http\Requests\SupportCenterQuestion;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Setting\Entities\SupportCenterQuestion;

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
        return SupportCenterQuestion::getValidationRules();
    }


}
