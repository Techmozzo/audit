<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;

class CompanyRegistrationRequest extends ParentRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
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
            'company_name' => 'required|string',
            'company_email' => 'required|email|unique:companies,email',
            'company_phone' => 'required|string|max:15|unique:companies,phone',
            'managing_partner_name' => 'required|string',
            'managing_partner_email' => 'required|email|unique:users,email,'.auth()->user()->email.',email',
            'managing_partner_phone' => 'required|string|max:15|unique:users,phone,'.auth()->user()->phone.',phone',
        ];
    }
}
