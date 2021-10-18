<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;

class EngagementInvitationRequest extends ParentRequest
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
            'user_id' => 'required|integer',
            'engagement_team_role_id' => 'required|integer',
            'company_id' => 'required|integer'
        ];
    }
}
