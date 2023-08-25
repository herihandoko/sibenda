<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UserRegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    public function userRegisterForm()
    {
        return view('frontend.registerIndex');
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {


        $validation = [
            'name' =>     ['required', 'string', 'max:255'],
            'email' =>    ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' =>    ['unique:users'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
            'g-recaptcha-response' =>  ReCaptcha('recaptcha_status') == 1 ? ['required', 'captcha'] : [],
        ];

        return Validator::make($data, $validation);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([

            'name' => $data['name'],
            'email' => $data['email'],
            'avatar' => null,
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
        ]);

        $template = EmailTemplate::find(3);

        $body = str_replace('{name}', $user->name, $template->description);
        $body = str_replace('{website}', GetSetting('site_name'), $body);

        Mail::send('frontend.emailHtml', ['body' =>html_entity_decode($body)], function ($message) use ($user, $template) {
            $message->to($user->email);
            $message->subject($template->subject);
        });

        event(new Registered($user));

        alert()->success('Registration Successful!');

        return $user;
    }
}
