<?php

namespace App\Http\Requests;


class RatingRequest extends BaseApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'garage_id' => 'numeric|min:1',
            'score' => 'numeric|min:1|max:10',
        ];
    }
}
