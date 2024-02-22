<?php

namespace Modules\Record\Http\Requests\AdRecord;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
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
        $rule =  ['start'=>'nullable|date',
            'end'=>'nullable|date',
            'creation_end'=>'nullable|date',
            'creation_start'=>'nullable|date',
            ];
        if($this->start)
        {
            $rule['end'] = $rule['end']."|after_or_equal:start";
        }
        if($this->creation_start)
        {
            $rule['creation_end'] = $rule['creation_end']."|after_or_equal:creation_start";
        }
        return $rule;
    }
}
