<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseApiRequest extends FormRequest
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
            //
        ];
    }

    /**Return response result if failed validation
     * @param array $errors
     * @return mixed
     */
    public function response(array $errors)
    {
        $failedValidations = [];

        foreach ($errors as $key => $value) {
            $tmp = new \stdClass();
            $tmp->error = $key;
            $tmp->message = $value[0];
            array_push($failedValidations, $tmp);
        }

        $failedResult = [
            'status' => -1,
            'data' => $failedValidations,
        ];

        return \Response::json($failedResult);
    }
}
