<?php

namespace App\Http\Requests;

class ConclusionRequest extends ParentRequest
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
            'overall_analytical_review' => 'required|string',
            'going_concern_procedures' => 'required|string',
            'subsequent_procedures' => 'required|string',
            'management_representation_letter' => 'required|string',
            'management_letter' => 'required|string',
            'audit_summary_misstatement' => 'required|string',
            'audit_report' => 'required|string',
            'audited_financial_statement' => 'required|string',
            'other_financial_info' => 'required|string',
        ];
    }
}
