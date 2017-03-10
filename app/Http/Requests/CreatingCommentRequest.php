<?php

namespace App\Http\Requests;


class CreatingCommentRequest extends BaseApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'commentable_id' => 'required|numeric|min:1',
            'commentable_type' => 'required',
            'content' => 'required',
        ];
    }
}
