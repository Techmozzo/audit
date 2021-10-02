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
            'client_id',
            'year',
            'first_time',
            'audit_id'
        ];
    }
}
