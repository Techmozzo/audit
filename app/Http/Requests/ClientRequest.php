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

            'director_name' => 'required|array',
            'director_name.*' => 'required|string',
            'director_units_held' => 'required|array',
            'director_units_held.*' => 'required|string',
            'director_designation' => 'required|array',
            'director_designation.*' => 'required|string',

            'is_part_of_group' => 'required|integer',
            'subsidiary_name' => 'exclude_if:is_part_of_group,0|required|array',
            'subsidiary_name.*' => 'exclude_if:is_part_of_group,0|required|string',
            'subsidiary_percentage_holding' => 'exclude_if:is_part_of_group,0|required|array',
            'subsidiary_percentage_holding.*' => 'exclude_if:is_part_of_group,0|required|integer',
            'subsidiary_nature' => 'exclude_if:is_part_of_group,0|required|array',
            'subsidiary_nature.*' => 'exclude_if:is_part_of_group,0|required|string',
            'subsidiary_nature_of_business' => 'exclude_if:is_part_of_group,0|required|array',
            'subsidiary_nature_of_business.*' => 'exclude_if:is_part_of_group,0|required|string'


            // 'directors' => 'required|array',
            // 'directors.*' => 'required|array',
            // 'directors.*.name' => 'required|string',
            // 'directors.*.units_held' => 'required|integer',
            // 'directors.*.designation' => 'required|string',

            // 'is_part_of_group' => 'required|integer',

            // 'subsidiaries' => 'exclude_if:is_part_of_group,0|required|array',
            // 'subsidiaries.*' => 'exclude_if:is_part_of_group,0|required|array',
            // 'subsidiaries.*.name' => 'exclude_if:is_part_of_group,0|required|string',
            // 'subsidiaries.*.percentage_holding' => 'exclude_if:is_part_of_group,0|required|integer',
            // 'subsidiaries.*.nature' => 'exclude_if:is_part_of_group,0|required|string',
            // 'subsidiaries.*.nature_of_business' => 'exclude_if:is_part_of_group,0|required|string'
        ];
    }
}
