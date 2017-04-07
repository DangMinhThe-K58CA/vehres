<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddingGarageRequest extends FormRequest
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
            'name' => 'required|between:3,100|unique:garages,name',
            'address' => 'required|min:3',
            'phone_number' => 'required|min:8',
            'website' => 'required|min:8',
            'working_time' => 'required|min:8',
            'short_description' => 'required|between:8,200',
            'description' => 'required|min:8',
        ];
    }
}
