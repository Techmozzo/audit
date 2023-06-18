<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaterialityRequest extends ParentRequest
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

            'materiality_benchmark_amount' => 'required|numeric|between:0,999999999999999.99',
            'materiality_benchmark_reason' => 'required|string',

            'overall_materiality_level_id' => 'required|integer|different:performance_materiality_level_id|different:threshold_level_id',
            'overall_materiality_limit' => 'required|numeric|between:0,999999999999999.99',
            'overall_materiality_amount' => 'required|numeric|between:0,999999999999999.99',
            'overall_materiality_reason' => 'required|string',

            'performance_materiality_level_id' => 'required|integer|different:overall_materiality_level_id|different:threshold_level_id',
            'performance_materiality_limit' => 'required|numeric|between:0,999999999999999.99',
            'performance_materiality_amount' => 'required|numeric|between:0,999999999999999.99',
            'performance_materiality_reason' => 'required|string',

            'threshold_level_id' => 'required|integer|different:performance_materiality_level_id|different:overall_materiality_level_id',
            'threshold_limit' => 'required|numeric|between:0,999999999999999.99',
            'threshold_amount' => 'required|numeric|between:0,999999999999999.99',
            'threshold_reason' => 'required|string',
        ];
    }
}
