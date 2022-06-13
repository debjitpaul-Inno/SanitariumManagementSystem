<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WardRequest extends FormRequest
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
    public function messages()
    {
        return [
            'name.required' => 'Ward Name is required',
            'ward_number.required' => 'Ward Number is required',
            'floor.required' => 'Floor Number is required' ,
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $method = $this->method();
        return match($method){
            'PUT','POST' =>[
                'name' => 'required',
                'ward_number' => 'required',
                'floor' => 'required'
            ],
            default => [],
        };


    }
}
