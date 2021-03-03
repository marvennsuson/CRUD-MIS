<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Redirect;

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

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function updatepassword(Request $request){
        $validator =  Validator::make($request->all(), [
            'token' => 'required|exists:password_resets,token',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::table('password_resets')->where('token', '=', $request->token)->delete();

        $user = User::where('email', $request->email)->firstOrFail();
    
        $user->password = Hash::make($request->password);
        $user->save();
        Auth::login($user);

        $request->session()->flash('status', 'Password changed successfully! You\'re logged in.');
        $request->session()->flash('preload', 'Password changed successfully! You\'re logged in.');

        // dd($request->session()->all());
        if($user->user_level == 9){
            return redirect(route('home'));
        } else {
            return redirect(route('users.home'));
        }
    }
}
