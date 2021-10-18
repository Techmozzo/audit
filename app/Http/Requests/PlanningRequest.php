<?php

namespace App\Http\Requests;

class PlanningRequest extends ParentRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
            'trial_balance' => 'required|string',

            'class_name' => 'required|array',
            'class_name.*' => 'required|string|distinct',
            'process_flow_document' => 'required|array',
            'process_flow_document.*' => 'required',
        ];
    }
}
