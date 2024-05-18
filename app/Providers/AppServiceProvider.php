<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\SmtpSetting;
use Config;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {


       info("alex:::::boot:: " . env('APP_NAME', 'Laravel'));

        // info("alex: boot from AppServiceProvider");
       if (\Schema::hasTable('smtp_settings')) {
        $smtpsetting = SmtpSetting::first();

        if ($smtpsetting) {
        $data = [
         'driver' => $smtpsetting->mailer,
         'host' => $smtpsetting->host,
         'port' => $smtpsetting->port,
         'username' => $smtpsetting->username,
         'password' => $smtpsetting->password,
         'encryption' => $smtpsetting->encryption,
         'from' => [
             'address' => $smtpsetting->from_address,
             'name' => Config::get('name', 'Alexa')
         ]

         ];
         Config::set('mail',$data);

        }
    } // end if



        //
    // Implicitly grant "Super Admin" role all permissions
    // This works in the app by using gate-related functions like auth()->user->can() and @can()
    Gate::before(function ($user, $ability) {
        return $user->hasRole('super') ? true : null;
    });
     Gate::before(function ($user, $ability) {
         return $user->hasRole('user') ? true : null;
     });

     Gate::before(function ($user, $ability) {
         return $user->hasRole('admin') ? true : null;
     });

    }
}
