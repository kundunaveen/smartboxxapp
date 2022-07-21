<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Contracts\Validation\Validator;

class CompanyRequest extends FormRequest
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
            'name' => ['required', 'string','unique:companies'],
            'email' => ['required','email','unique:companies'],
            'code' => ['required'],
            'phone' => ['required','regex:/^([0-9\s\-\+\(\)]*)$/','min:10'],
            'contact_firstname' => ['required'],
            'contact_lastname' => ['required'],
            'street' => ['required','min:8'],
            'country' =>  ['required'],
            'state' =>  ['required'],
            'city' =>  ['required'],
            'zip' =>  ['required'],
         ];
    }

    public function failedValidation(Validator $validator)

    {

        throw new HttpResponseException(response()->json([

            'status'   => false,

            // 'message'   => 'Validation errors',

            'data'      => $validator->errors()

        ]));

    }

    // public function messages()

    // {

    //     return [

    //         'title.required' => 'Title is required',

    //         'body.required' => 'Body is required'

    //     ];

    // }

}
