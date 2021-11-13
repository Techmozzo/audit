<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;

class EngagementRequest extends ParentRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('staff');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'client_id' => 'required|integer',
            'name' => 'required|string',
            'year' => 'required|string',
            'first_time' => 'required|integer',
            // required
            'engagement_letter' => 'required|string',
            'accounting_standard' => 'required|string',
            'auditing_standard' => 'required|string',
            // 'staff_power' => 'required|string',
            // 'partner_skill' => 'required|string',
            'external_expert' => 'required|string',
            // 'members_dependence' => 'required|string',
            // optional
            'appointment_letter' => 'exclude_if:first_time,0|required|string',
            'contacted_previous_auditor' => 'exclude_if:first_time,0|required|string',
            'previous_auditor_response' => 'exclude_if:first_time,0|required|string',
            'previous_audit_opinion' => 'exclude_if:first_time,0|required|string',
            'other_audit_opinion' => 'exclude_if:first_time,0|required|string',
            'previous_audit_review' => 'exclude_if:first_time,0|required|string',
            'previous_year_management_letter' => 'exclude_if:first_time,0|required|string',
            'previous_year_asf' => 'exclude_if:first_time,0|required|string'
        ];
    }
}
