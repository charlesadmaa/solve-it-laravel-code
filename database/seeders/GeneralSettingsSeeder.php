<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GeneralSettings;


class GeneralSettingsSeeder extends Seeder
{

    public function run(): void
    {
        $settings = new GeneralSettings();
        $settings->from_email = "info@solve-it.ng";
        $settings->from_name = "Solve IT";
        $settings->sms_from_name = 'N-Alert';
        $settings->sms_api_key = "TLXKzbKIGoXUQn46NU6AkUHXQKNQ1JbYfBMLi4tX6V2BzHUlUR0dIhpS66ZME4";
        $settings->smtp_host = "sandbox.smtp.mailtrap.io";
        $settings->smtp_port = "2525";
        $settings->smtp_username = "7dfddc2e10d74d";
        $settings->smtp_password = "240ca5a02c706a";
        $settings->smtp_encryption = "tls";
        $settings->save();
    }
}
