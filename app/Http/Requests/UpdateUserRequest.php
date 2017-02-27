<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest
{
    /**
     * Request type: 1: Update information. 2: Change password.
     * @var
     */
    public $type;

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
        $pasValidation = [
            'currentPassword' => 'required|min:6',
            'newPassword' => 'required|min:6|different:currentPassword',
            'confirmPassword' => 'required|min:6|same:newPassword'
        ];

        $infoValidation = [
            'name' => 'unique:users,name,' . Auth::user()->name . ',name|between:3,50',
            'description' => 'min:6|max:500',
            'avatar' => 'mimes:jpeg,jpg,png'
        ];

        if ( $this->exists('updateProfile')) {
            $this->type = 1;
            return $infoValidation;
        }

        if ( $this->exists('changePassword')) {
            $this->type = 2;
            return $pasValidation;
        }
    }

    /**
     * Get the proper failed validation response for the request.
     *
     * @param  array  $errors
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors)
    {
        if ($this->expectsJson()) {
            return new JsonResponse($errors, 422);
        }

        return $this->redirector->to($this->getRedirectUrl())
            ->withInput($this->except($this->dontFlash))
            ->withErrors($errors, $this->errorBag)
            ->with('tabStatus', $this->type);
    }

    /**
     * Customize error messages.
     * @return array
     */
    public function messages()
    {
        return [];
    }
}
