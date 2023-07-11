<?php

namespace App\Http\Requests;

class TrialBalanceUploadRequest extends ParentRequest
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
            'trial_balance' => 'required|mimes:xls,xlsx|max:2000'
        ];
    }
}
