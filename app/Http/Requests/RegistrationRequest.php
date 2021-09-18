<?php

namespace App\Http\Requests;

class RegistrationRequest extends ParentRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'company_name' => 'required|string',
            'company_email' => 'required|email|unique:companies,email',
            'company_phone' => 'required|string|max:15|unique:companies,phone',

            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:15|unique:users,phone',
            'password' => 'required|min:8',

            'managing_partner_name' => 'required|string',
            'managing_partner_email' => 'required|email|unique:users,email',
            'managing_partner_phone' => 'required|string|max:15|unique:users,phone',
        ];
    }
}
