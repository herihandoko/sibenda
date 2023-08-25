<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\FacadesDB;
use Illuminate\Support\Facades\File;
use ZipArchive;

class UserDataController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:user-data-index|user-data-create|user-data-edit|user-data-delete', ['only' => ['index','show']]);
         $this->middleware('permission:user-data-create', ['only' => ['create','store']]);
         $this->middleware('permission:user-data-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:user-data-delete', ['only' => ['destroy']]);
    }

    public function backup()
    {

        if (checkDemo()) {
            $notification = trans('admin.This action is blocked in demo mode!');
            $notification = ['message' => $notification, 'alert-type' => 'error'];
            return redirect()->back()->with($notification);
        }


        $tables = DB::select('SHOW TABLES');

        $paths = getAllResourceFiles(database_path('seeders/'));
        foreach ($paths as $key => $path) {
            if (!str_contains($path, 'DatabaseSeeder.php')) {
                unlink($path);
            }
        }

        foreach ($tables as $key) {
            $databaseName = Config::get('database.connections.' . Config::get('database.default'));
            $database = 'Tables_in_' . $databaseName['database'];
            $table = $key->{$database};
            try {
                Artisan::call("iseed $table");
            } catch (\Throwable $th) {
                return $th;
            }
        }
        $zip_file = 'consilt_backup_' . date('y-m-d') . '.zip';
        $zip = new \ZipArchive();
        $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        $database = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(database_path('seeders/'))
        );
        foreach ($database as $name => $file) {
            if (!$file->isDir()) {
                $filePath     = $file->getRealPath();
                $relativePath = 'database/seeders/' .  basename($filePath);
                $zip->addFile($filePath, $relativePath);
            }
        }
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(public_path('assets/uploads/images/'))
        );
        foreach ($files as $name => $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();

                $relativePath = 'public/assets/uploads/images/' .  basename($filePath);
                $zip->addFile($filePath, $relativePath);
            }
        }

        $zip->close();
        return response()->download($zip_file)->deleteFileAfterSend(true);
    }
    public function restore(Request $request)
    {
        if (checkDemo()) {
            $notification = trans('admin.This action is blocked in demo mode!');
            $notification = ['message' => $notification, 'alert-type' => 'error'];
            return redirect()->back()->with($notification);
        }

        $zip = new ZipArchive;
        $res = $zip->open($request->file('backup'));
        if ($res === TRUE) {
            $zip->extractTo(base_path('/'));
            $zip->close();
            Artisan::call("db:seed");

            $notification = trans('admin.Restored Successfully');
            $notification = ['message' => $notification, 'alert-type' => 'success'];
            return redirect()->back()->with($notification);
        } else {
            $notification = trans('admin.Error restoring');
            $notification = ['message' => $notification, 'alert-type' => 'error'];
            return redirect()->back()->with($notification);
        }
    }
    public function maintenance_mode(Request $request)
    {

        if (checkDemo()) {
            $notification = trans('admin.This action is blocked in demo mode!');
            $notification = ['message' => $notification, 'alert-type' => 'error'];
            return redirect()->back()->with($notification);
        }


        if (checkMaintenance()) {
            Artisan::call('up');
        } else {
            Artisan::call('down');
        }

        $notification = trans('admin.Updated Successfully');
        $notification = ['message' => $notification, 'alert-type' => 'success'];
        return redirect()->back()->with($notification);
    }

    public function reset()
    {

        if (checkDemo()) {
            $notification = trans('admin.This action is blocked in demo mode!');
            $notification = ['message' => $notification, 'alert-type' => 'error'];
            return redirect()->back()->with($notification);
        }

        $paths = getAllResourceFiles(public_path('assets/uploads/images'));

        foreach ($paths as $key => $path) {

            if (str_contains($path, Auth::user()->avatar)) {
            } elseif (str_contains($path, GetSetting('site_logo'))) {
            } elseif (str_contains($path, GetSetting('site_favicon'))) {
            } elseif (str_contains($path, '.txt')) {
            } else {
                unlink($path);
            }
        }


        Artisan::call('migrate:fresh');


        $seeder = new \Database\Seeders\AdminsTableSeeder();
        $seeder->run();

        $seeder = new \Database\Seeders\GoogleMapsTableSeeder();
        $seeder->run();


        $seeder = new \Database\Seeders\PageComponentCategoriesTableSeeder();
        $seeder->run();


        $seeder = new \Database\Seeders\PageComponentsTableSeeder();
        $seeder->run();


        $seeder = new \Database\Seeders\PageFootersTableSeeder();
        $seeder->run();

        $seeder = new \Database\Seeders\PageHeadersTableSeeder();
        $seeder->run();


        $seeder = new \Database\Seeders\PaymentGatewaysTableSeeder();
        $seeder->run();

        DB::table('menus')->insert(
            array(
                'id' => 1,
                'title' => 'Home',
                'link' => '',
                'status' => 1,
                'order' => 0,
                'parent_id' => NULL,
                'created_at' => '2022-01-10 09:52:12',
                'updated_at' => '2022-03-01 11:15:13',
            )
        );

        DB::table('page_builders')->insert(
            array(
                'id' => 1,
                'title' => 'home',
                'slug' => 'home',
                'contents' => '3,4,5,6,7,8,9,10',
                'created_at' => '2022-01-10 09:27:39',
                'updated_at' => '2022-01-10 09:27:39',
            )
        );


        DB::table('settings')->insert(array(
            0 =>
            array(
                'id' => 1,
                'site_name' => 'Consilt',
                'site_description' => 'Lorem ipsum is simply free text dolor sit am adipi we help you ensure everyone is in the right jobs sicing elit, sed do consulting firms Et leggings across the nation tempor.',
                'site_tags' => 'consilt',
                'site_time_zone' => 'Asia/Dhaka',
                'site_currency' => 'USD',
                'site_currency_icon' => '$',
                'site_direction' => 'LTR',
                'site_primary_color' => '#000000',
                'site_secondary_color' => '#000000',
                'site_logo' => 'assets/uploads/images/media_1645359646.png',
                'site_favicon' => 'assets/uploads/images/media_1645359708.png',
                'site_header' => '2',
                'site_footer' => '2',
                'created_at' => NULL,
                'updated_at' => '2022-03-03 09:27:33',
            ),
        ));

        DB::table('cookies')->insert(array(
            0 =>
            array(
                'id' => 1,
                'cookie_status' => '1',
                'cookie_button' => 'Accept',
                'cookie_confirmation' => 'Your experience on this site will be improved by allowing cookies.',
                'created_at' => NULL,
                'updated_at' => '2022-02-15 14:02:37',
            ),
        ));

        DB::table('email_settings')->insert(array(
            0 =>
            array(
                'id' => 1,
                'mail_host' => 'smtp.mailtrap.io',
                'smtp_username' => 'd9145f3e45a4c3',
                'smtp_password' => '674f36bfa4904c',
                'mail_port' => '2525',
                'mail_sent_from' => 'Consilt',
                'mail_sent_from_email' => 'consilt@testmail.com',
                'mail_encryption' => 'tls',
                'created_at' => NULL,
                'updated_at' => '2022-02-14 05:20:44',
            ),
        ));

        DB::table('email_templates')->insert(array(
            0 =>
            array(
                'id' => 1,
                'name' => 'Reset Password',
                'subject' => 'Reset Password',
                'description' => '<h3>Click this link to reset your password -&nbsp;<span ><a href="http://{link}" target="_blank">{link}</a></span></h3>',
                'created_at' => NULL,
                'updated_at' => '2022-02-15 05:18:37',
            ),
            1 =>
            array(
                'id' => 2,
                'name' => 'Transaction',
                'subject' => 'Transaction',
                'description' => 'hello {name} Your Transacrtion is successful',
                'created_at' => NULL,
                'updated_at' => '2022-02-14 07:42:45',
            ),
            2 =>
            array(
                'id' => 3,
                'name' => 'Welcome Email',
                'subject' => 'welcome',
                'description' => '<b>Hello&nbsp;<span ">{name}! Welcome To&nbsp;</span><span ">{website}</span></b>',
                'created_at' => NULL,
                'updated_at' => '2022-02-15 06:07:56',
            ),
            array(
                'id' => 4,
                'name' => 'Subscriber Confirmation',
                'subject' => 'Subscriber Confirmation',
                'description' => '<h3>Click this link to confirm your email -&nbsp;<span ><a href="http://{link}" target="_blank">{link}</a></span></h3>',
                'created_at' => NULL,
                'updated_at' => '2022-02-14 07:42:45',
            ),

            array(
                'id' => 5,
                'name' => 'Contact Message',
                'subject' => 'Contact Message',
                'description' => '<h3>Click this link to confirm your email -&nbsp;<span><a href="http://{link}" target="_blank">{link}</a></span></h3>',
                'created_at' => NULL,
                'updated_at' => '2022-02-14 07:42:45',
            ),
        ));


        DB::table('email_template_variables')->insert(array(
            0 =>
            array(
                'id' => 1,
                'variable' => '{link}',
                'meaning' => 'Verification Link',
                'template_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 =>
            array(
                'id' => 2,
                'variable' => '{name}',
                'meaning' => 'Customer Name',
                'template_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 =>
            array(
                'id' => 3,
                'variable' => '{name}',
                'meaning' => 'Customer Name',
                'template_id' => 3,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 =>
            array(
                'id' => 4,
                'variable' => '{website}',
                'meaning' => 'Website Name',
                'template_id' => 3,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),

            array(
                'id' => 5,
                'variable' => '{name}',
                'meaning' => 'Name',
                'template_id' => 5,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),

            array(
                'id' => 6,
                'variable' => '{Phone}',
                'meaning' => 'Phone',
                'template_id' => 5,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),

            array(
                'id' => 7,
                'variable' => '{email}',
                'meaning' => 'Email',
                'template_id' => 5,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),

            array(
                'id' => 8,
                'variable' => '{subject}',
                'meaning' => 'Subject',
                'template_id' => 5,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),

            array(
                'id' => 9,
                'variable' => '{message}',
                'meaning' => 'Message',
                'template_id' => 5,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));

        DB::table('google_analytics')->insert(array(
            0 =>
            array(
                'id' => 1,
                'google_analytics_id' => 'google_analytics_id',
                'google_analytics_status' => 0,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));

        DB::table('google_recaptchas')->insert(array(
            0 =>
            array(
                'id' => 1,
                'recaptcha_site_key' => '6LdqGNseAAAAAHMsrzPzNOqYZwACD_VpBeF85SY4',
                'recaptcha_secret_key' => '6LdqGNseAAAAAIc47i2gAYdh2QCllvIt89aOT2Mn',
                'recaptcha_status' => 1,
                'created_at' => NULL,
                'updated_at' => '2022-03-14 04:44:35',
            ),
        ));


        $notification = trans('admin.Reset Successfully');
        $notification = ['message' => $notification, 'alert-type' => 'success'];
        return redirect()->back()->with($notification);
    }
}
