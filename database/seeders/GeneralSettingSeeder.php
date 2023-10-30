<?php

namespace Database\Seeders;

use App\Http\traits\ENVFilePutContent;
use App\Models\GeneralSetting;
use Illuminate\Database\Seeder;

class GeneralSettingSeeder extends Seeder
{
    use ENVFilePutContent;

    public function run(): void
    {
        GeneralSetting::truncate();

        $timeZone = "Asia/Dhaka";
        $dateFormat = "d-m-Y";

        $siteTitle = "PeoplePro";

        $data = [
            'site_title' => $siteTitle,
            'site_logo'  => "logo.png",
            'time_zone' => $timeZone,
            'currency' => "$",
            'currency_format' => "prefix",
            'default_payment_bank' => 1,
            'date_format' => $dateFormat,
            'date_format_js' => config('date_format_conversion.' .$dateFormat),
            'theme' => "default.css",
            'footer' => "LionCoders",
            'footer_link' => "https://www.lion-coders.com",
            'rtl_layout' => false,
            'enable_clockin_clockout' => true,
            'enable_early_clockin' => false,
        ];


        GeneralSetting::create($data);
    }
}
