<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ClientRequest extends ParentRequest
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
            'name' => 'required|string',
            'email' => Rule::unique('clients')->where(function($query){
                return $query->where('company_id', auth()->user()->company_id);
            }),
            'phone' => Rule::unique('clients')->where(function($query){
                return $query->where('company_id', auth()->user()->company_id);
            }),
            'address' => 'required|string',
            'registered_address' => 'required|string',
            'is_public_entity'=> 'required|integer',
            'nature_of_business' => 'required|string',
            'doubts' => 'required|string',
        ];
    }
}
