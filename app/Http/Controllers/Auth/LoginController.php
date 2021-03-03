<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    public function showAdminLogin()
    {
       $data['usergroup'] = 'admin';
       return view('admin.login.login', $data);
    }



    public function authenticate(Request $request)
    {
        $this->validate($request, [
            'email'           => 'required|max:255|email',
            'password'        => 'required',
        ]);
            
        
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
        
            $request->session()->flash('status', 'Login successful!');
            $request->session()->flash('preload', 'Login successful!');
  
            return redirect()->intended(route('home'));
            // dd($request);
            
        }else{
            
            if (Auth::guard('resident')->attempt($credentials)) {
                
                $details = Auth::guard('resident')->user();
            
                $request->session()->flash('status', 'Login successful!');
                $request->session()->flash('preload', 'Login successful!');
                
                return redirect()->intended(route('users.home'));

            } 
        
        }   
        return back()->withErrors([
            'message' => 'Email/Password does not match'
        ]);
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


}
