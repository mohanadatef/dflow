<?php

namespace Modules\Record\Http\Requests\AdRecordErrors;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Acl\Entities\Company;
use Modules\Acl\Entities\CompanyWebsite;
use Modules\Record\Entities\AdRecord;
use Modules\Record\Entities\AdRecordError;

class CreateRequest extends FormRequest
{
    public function __construct()
    {
        parent::__construct();
    }

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

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return AdRecordError::getValidationRules();
    }


}
