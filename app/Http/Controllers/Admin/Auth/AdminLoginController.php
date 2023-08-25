<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{


    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::ADMIN;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('adminLogout');
    }


    public function adminLoginForm()
    {
        return view('admin.loginIndex');
    }

    public function adminCheckLogin(Request $request)
    {

        $this->validate($request, [
            'username'   => 'required',
            'password' => 'required|min:4',
            'g-recaptcha-response' => 'recaptcha',
        ]);

        if (Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password], $request->get('remember'))) {

            $notification = trans('admin.Successfully logged in..');
            $notification = ['message' => $notification, 'alert-type' => 'success'];
            return redirect()->intended(RouteServiceProvider::ADMIN)->with($notification);
        }

        $notification = trans('admin.Wrong password..');
        $notification = ['message' => $notification, 'alert-type' => 'error'];
        return back()->withInput($request->only('username', 'remember'))->with($notification);
    }

    public function adminLogout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
