<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Crypt;

use App\Models\user;
use App\Models\company;

class authController extends Controller
{
    //

    public function index()
    {
        return view('auth.index');
    }// end method

    public function login(Request $request)
    {
        $remember = $request->input('remember_token ');

        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if (Auth::attempt($validated, $remember)) 
        {
            user::update_last_login($validated['email']);

            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->with('error','accout or password is wrong')->onlyInput('email');

    }//end method

    public function create_account()
    {
        return view('auth.create_account');
    }// end method

    // store new employee data
    public function create_account_process(Request $request)
    {
        // validated new employee data 
        $validated = $request->validate([
            
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric|unique:users,phone',
            'ic' => 'required|integer|unique:users,ic',
            
        ]);

        $user = user::add_user($validated['name'],$validated['email'],$validated['phone'],$validated['ic']);

        $company = company::add_company($validated['email']);

        // Manually fire the Registered event
        event(new Registered($user));

        return back()->with('success','success create new account, your password will be your I.C '.$validated['name']);
        
    }//end method

    public function logout(Request $request)
    {
        Auth::logout();
 
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();

        return redirect(route('auth'));

    }// end method

    public function forgot_password()
    {
        return view('auth.forgot_password');
    }//end method

    public function forgot_password_email(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );
     
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['success' => __($status)])
                    : back()->withErrors(['email' => __($status)]);

    }//end method

    public function reset(string $token)
    {   
        return view('auth.reset_forgot_password', ['token' => $token]);

    }//end method

    public function reset_password(Request $request)
    {

        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
     
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );
     
        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('auth')->with('success', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }//end method


}//end class
