<?php

namespace Modules\CoreData\Http\Requests\Website;

use Illuminate\Foundation\Http\FormRequest;
use Modules\CoreData\Entities\Website;
use Modules\CoreData\Entities\WebsiteKey;

class CreateRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        $keys = json_decode($this->key[0], 1);
        if(!empty($keys))
        {
            $this->merge(['key' => $keys]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Website::getValidationRules();
    }
}
