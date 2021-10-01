<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;

class RoleRequest extends ParentRequest
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
            'role_id' => 'required|array',
            'role_id.*' => 'required|integer|distinct',
            'user_id' => 'required|integer'
        ];
    }
}
