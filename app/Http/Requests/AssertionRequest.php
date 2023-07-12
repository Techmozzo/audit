<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssertionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'procedures' => 'required|array',
            'procedures.*' => 'required|array',
            'procedures.*.assertions' => 'required|array',
            'procedures.*.assertions.*' => 'required|integer|exists:procedure_assertions,id',
            'procedures.*.other_info' => 'nullable|string',
            'procedures.*.id' => 'required|integer|exists:procedures,id',
        ];
    }
}
