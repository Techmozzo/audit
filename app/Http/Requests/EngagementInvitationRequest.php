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
            'team_members' => 'required|array',
            'team_members.*' => 'required|array',
            'team_members.*.user_id' => 'required|integer',
            'team_members.*.engagement_team_role_id' => 'required|integer'
        ];
    }
}
