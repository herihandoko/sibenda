<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
    public function showResetForm(Request $request)
    {
        $token = $request->route()->parameter('token');
        $email = DB::table('password_resets')->where(['token' => $token])->first();
        if ($email) {
            return view('frontend.passwordReset')->with(
                ['token' => $token, 'email' => $email->email]
            );
        }
        alert()->error('Oops!', 'Invalid password reset link.');
        return redirect('/');
    }
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed',
            'token' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors(['email' => 'Please complete the form']);
        }
        $password = $request->password;

        $tokenData = DB::table('password_resets')
            ->where('token', $request->token)->first();
        if (!$tokenData) return redirect()->back()->withErrors(['email' => 'Invalid Token!']);
        $user = User::where('email', $tokenData->email)->first();
        if (!$user) return redirect()->back()
            ->withErrors(['email' => 'Email not found']);
        $user->password = \Hash::make($password);
        $user->update();
        Auth::login($user);
        DB::table('password_resets')->where('email', $user->email)
            ->delete();
        alert()->success('Password reset successfully!.');
        return redirect('/');
    }
    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
}
