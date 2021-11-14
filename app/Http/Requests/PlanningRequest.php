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
            'classes' => 'required|array',
            'classes.*' => 'required|array|distinct',
            'classes.*.name' => 'required|string',
            'classes.*.process_flow_document' => 'required'
        ];
    }
}
