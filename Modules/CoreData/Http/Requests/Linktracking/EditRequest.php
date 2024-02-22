<?php

namespace Modules\CoreData\Http\Requests\Linktracking;

use Illuminate\Foundation\Http\FormRequest;
use Modules\CoreData\Entities\LinkTracking;

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
        return [
            'destination' => 'required|url',
            'title' => 'required',
            'countries.*.country_id' => 'nullable|exists:locations,id',
            'countries.*.destination' => 'nullable|url',
            'ios_url' => 'nullable|url',
            'android_url' => 'nullable|url',
            'windows_url' => 'nullable|url',
            'linux_url' => 'nullable|url',
            'mac_url' => 'nullable|url',
            'influencer_id'=>'required',
        ];
    }

}
