<?php

namespace Modules\Acl\Http\Requests\InfluencerGroupSchedule;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Acl\Entities\InfluencerGroupSchedule;

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
        return InfluencerGroupSchedule::getValidationRules();
    }

}
