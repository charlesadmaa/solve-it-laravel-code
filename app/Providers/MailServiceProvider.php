<?php

namespace App\Providers;

use App\Models\GeneralSettings;
use Illuminate\Support\ServiceProvider;

class MailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $settings = GeneralSettings::emailConfiguration()->first();

        if($settings){
            $config = array(
                'driver'     => "smtp",
                'host'       => $settings->smtp_host,
                'port'       => $settings->smtp_port,
                'from'       => array('address' => $settings->from_email, 'name' => $settings->from_name),
                'encryption' => $settings->smtp_encryption,
                'username'   => $settings->smtp_username,
                'password'   => $settings->smtp_password
            );

            \Config::set('mail', $config);
        }

    }
}
