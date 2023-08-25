<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserLoginController extends Controller
{


    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::USERPANEL;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('userLogout');
    }


    public function userLoginForm()
    {
        return view('frontend.loginIndex');
    }

    public function userCheckLogin(Request $request)
    {



        $this->validate($request, [
            'email' => ['required', function ($attribute, $value, $fail) {
                $email = User::where('email', $value)->first();
                if ($email == null) {
                    $fail($attribute . ' does not exist.');
                }
            },],
            'g-recaptcha-response' =>  ReCaptcha('recaptcha_status') == 1 ? 'required|captcha' : [],
            'password' => 'required|min:4'
        ]);



        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

            return redirect()->intended(RouteServiceProvider::USERPANEL);
        }

        return redirect()->back()->withInput($request->only('email', 'remember'))->withErrors([
            'error' => 'Wrong password.',
        ]);
    }

    public function userLogout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('user.login');
    }
}
