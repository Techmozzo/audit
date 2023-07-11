<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;

class FileUploadRequest extends ParentRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('user');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'document' => 'required|mimes:jpg,png,jpeg,doc,docx,pdf,xls,ods,csv,xlsx|max:2000'
        ];
    }
}
