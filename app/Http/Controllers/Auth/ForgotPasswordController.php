<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Notifications\ResetPassword;
use Redirect;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    public function sendResetLinkEmail(Request $request){
        $data = $request->all();
        $validator =  Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'exists:users'],
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::where('email', $data['email'])->firstOrFail();

        $token = $data['_token'].Str::random(8).time();
        DB::table('password_resets')->insert(
                ['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now() ]
        );

        $user->notify(new ResetPassword($token . '?email=' . $request->email ));

        $errors['email'] = 'Password reset link is sent to your email. Check your spam inbox if you don\'t see it';
        $request->session()->flash('status', 'A password reset link was sent to your email. Check your spam inbox if you did not see the email.');
        
        return redirect(route('forgot-password'));
    }

    use SendsPasswordResetEmails;
}
