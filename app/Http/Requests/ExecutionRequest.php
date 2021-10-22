<?php

namespace App\Http\Requests;


class ExecutionRequest extends ParentRequest
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
            'contract_agreement_review' => 'required|string',
            'legal_counsel_review' => 'required|string',
            'contingent_liability_review' => 'required|string',
            'party_transaction_review' => 'required|string',
            'expert_work_review' => 'required|string',
            'other_estimate_review' => 'required|string'
        ];
    }
}
