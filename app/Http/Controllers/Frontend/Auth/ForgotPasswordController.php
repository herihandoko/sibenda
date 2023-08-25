<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Request;

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

    use SendsPasswordResetEmails;

    public function forgot()
    {
        return view('frontend.forgotPassword');
    }

    public function resetLink(Request $request)
    {

        if (User::where(['email' => $request->email])->count()) {

            $token = Str::random(64);
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);

            $link = url('/password-reset') . '/' . $token;
            $template = EmailTemplate::find(1);
            $body = str_replace('{link}', $link, str_replace('http://', '', $template->description));

            Mail::send('frontend.emailHtml', ['body' =>html_entity_decode($body)], function ($message) use ($request, $template) {
                $message->to($request->email);
                $message->subject($template->subject);
            });

            alert()->success('Reset link sent!.','Please check your email.');
            return redirect()->route('user.login');
        }

        alert()->error('Oops!','Email Not Registered!');
        return redirect()->route('user.login');


    }
}
