<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class VerifyAccountController extends Controller
{
    /**
     * Activate account action.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activateAccount(Request $request)
    {
        $key = $request->input('key');
        $lenKey = strlen($key);

        if ($lenKey <= 60) {
            abort(503);
        }

        //Get email and password from key.
        $hashedPass = substr($key, strlen($key) - 60, strlen($key));
        $hashedEmail = substr($key, 0, strlen($key) - 60);
        $email = base64_decode($hashedEmail);
        $user = User::where('email', $email)->first();

        //If user are logging-in, log out auth.
        if (Auth::check()) {
            if (Auth::user()->email == $user->email) {
                Auth::logout();
                return redirect('login')->with('success', trans('auth.available_account_success'));
            }
        }

        //If database has user information.
        if (! is_null($user)) {
            if ($user->status) {
                return redirect('login')->with('success', trans('auth.available_account_success'));
            }

            //Change status to activated
            if (Hash::check($user->password, $hashedPass)) {
                $user->status = 1;
                $user->save();
                return redirect('login')->with('success', trans('auth.verify_account_success'));
            }
        }

        abort(503);
    }
}
