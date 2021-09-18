<?php

namespace App\Http\Requests;

use App\Models\UserInvitation;

class RegisterUserRequest extends ParentRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $pendingInvite = UserInvitation::where([['email', $this->request->get('email')], ['status', 0]])->first();
        return $pendingInvite !== null ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:15|unique:users,phone',
            'password' => 'required|min:8',
        ];
    }
}
