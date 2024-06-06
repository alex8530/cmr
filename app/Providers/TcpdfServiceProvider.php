<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use TCPDF;

class TcpdfServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('tcpdf', function () {
            return new TCPDF();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
