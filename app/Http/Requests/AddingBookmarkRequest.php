<?php

namespace App\Http\Requests;


class AddingBookmarkRequest extends BaseApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'bookmarkable_type' => 'required',
            'bookmarkable_id' => 'required|numeric|min:1',
        ];
    }
}
