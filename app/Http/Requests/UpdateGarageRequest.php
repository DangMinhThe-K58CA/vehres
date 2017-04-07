<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGarageRequest extends FormRequest
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
            'name' => 'required|min:3',
            'avatar' => 'image',
            'address' => 'required|min:10',
            'phone_number' => 'required|min:8',
            'website' => 'required|min:8',
            'working_time' => 'required|min:8',
            'short_description' => 'required|min:8',
            'description' => 'required|min:8',
        ];
    }
}
