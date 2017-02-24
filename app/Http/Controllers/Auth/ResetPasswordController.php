<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */
    private $email;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Change methods name from ResetsPasswords trait.
     */
    use ResetsPasswords {
        reset as defaultReset;
        rules as defaultRules;
        validationErrorMessages as defaultValidationErrorMessages;
        credentials as defaultCredentials;
    }

    /**
     * Get email from given token.
     * @param $token
     * @return string
     */
    protected function getEmailFromToken($token)
    {
        $pwReset = DB::table('password_resets')->where('token', $token)->first();
        if (! is_null($pwReset)) {
            return $pwReset->email;
        }

        return "";
    }

    /**
     * Customized reset method.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset(Request $request)
    {
        $this->validate($request, $this->rules(), $this->validationErrorMessages());
        $this->email = $this->getEmailFromToken($request->input('token'));

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::PASSWORD_RESET
            ? $this->sendResetResponse($response)
            : $this->sendResetFailedResponse($request, $response);
    }

    /**
     * Validation rules for submitted data.
     * @return array
     */
    protected function rules()
    {
        return [
            'token' => 'required',
            'password' => 'required|confirmed|min:6',
        ];
    }

    /**
     * Messages for invalid.
     * @return array
     */
    protected function validationErrorMessages()
    {
        return [];
    }

    /**
     * Customized credentials method: set user email by $this->email.
     * @param Request $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $accountData = $request->only(
            'password', 'password_confirmation', 'token'
        );
        $accountData['email'] = $this->email;

        return $accountData;
    }
}
