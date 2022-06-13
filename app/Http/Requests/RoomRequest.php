<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
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
            'ward_id.required' => 'Ward is required',
            'room_type_id.required' => 'Room Type is required',
            'room_number.required' => 'Room Number is required',
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
                'ward_id' => 'required',
                'room_type_id' => 'required',
                'room_number' => 'required',
            ],
            default => [],
        };


    }
}
