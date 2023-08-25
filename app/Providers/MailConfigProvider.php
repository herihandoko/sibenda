<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class MailConfigProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $config = array(
            'driver'     =>    'smtp',
            'host'       =>     MailConfig('mail_host'),
            'port'       =>     MailConfig('mail_port'),
            'username'   =>     MailConfig('smtp_username'),
            'password'   =>     MailConfig('smtp_password'),
            'encryption' =>     MailConfig('mail_encryption'),
            'from'       =>     array('address' => MailConfig('mail_sent_from_email'), 'name' => MailConfig('mail_sent_from')),
        );

        Config::set('mail', $config);
    }
}
