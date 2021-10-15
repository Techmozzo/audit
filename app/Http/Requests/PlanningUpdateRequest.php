<?php

namespace App\Http\Requests;

class PlanningUpdateRequest extends ParentRequest
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
            'materiality_benchmark_id',
            'materiality_limit',
            'materiality_amount',
            'materiality_reason',
            'materiality_type'
        ];
    }
}
