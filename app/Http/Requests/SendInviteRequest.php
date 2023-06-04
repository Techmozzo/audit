<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;

class SendInviteRequest extends ParentRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize():bool
    {
        return Gate::allows('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|unique:user_invitations,email',
            'name' => 'required|string'
        ];
    }
}
