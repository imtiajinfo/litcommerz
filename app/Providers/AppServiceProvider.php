<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\EmailConfiguration;
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
        Paginator::useBootstrap();

        $mailsetting = EmailConfiguration::first();
        if(!empty($mailsetting)){
            $data = [
                'driver'            => $mailsetting->driver,
                'host'              => $mailsetting->host,
                'port'              => $mailsetting->port,
                'encryption'        => $mailsetting->encryption,
                'username'          => $mailsetting->username,
                'password'          => $mailsetting->password,
                'from'              => [
                    'address'=>$mailsetting->username,
                    'name'   => 'LaravelStarter'
                ]
            ];
            Config::set('mail',$data);
        }
    }
}
