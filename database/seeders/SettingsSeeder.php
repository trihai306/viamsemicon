<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['group' => 'general', 'key' => 'site_name', 'value' => 'Viam Semicon', 'type' => 'text'],
            ['group' => 'general', 'key' => 'company_name', 'value' => 'Công ty TNHH VIAM GLOBAL', 'type' => 'text'],
            ['group' => 'general', 'key' => 'address', 'value' => 'Số 251 Đường D���c Tú, Xã Dục Tú, Huyện Đông Anh, Thành phố Hà Nội, Vi��t Nam', 'type' => 'text'],
            ['group' => 'general', 'key' => 'phone', 'value' => '0986 020 896', 'type' => 'text'],
            ['group' => 'general', 'key' => 'hotline', 'value' => '0886 160 579', 'type' => 'text'],
            ['group' => 'general', 'key' => 'email', 'value' => 'sale@viamsemicon.com', 'type' => 'text'],
            ['group' => 'general', 'key' => 'contact_person', 'value' => 'Alex Nguyen', 'type' => 'text'],
            ['group' => 'social', 'key' => 'facebook', 'value' => '#', 'type' => 'text'],
            ['group' => 'social', 'key' => 'instagram', 'value' => '#', 'type' => 'text'],
            ['group' => 'social', 'key' => 'twitter', 'value' => '#', 'type' => 'text'],
            ['group' => 'social', 'key' => 'youtube', 'value' => '#', 'type' => 'text'],
            ['group' => 'social', 'key' => 'zalo', 'value' => '0886160579', 'type' => 'text'],
            ['group' => 'seo', 'key' => 'seo_title', 'value' => 'Viam Semicon - Thiết bị đo lường, Robot vận chuyển, RF Cable', 'type' => 'text'],
            ['group' => 'seo', 'key' => 'seo_description', 'value' => 'Viam Semicon chuyên cung cấp thiết bị đo lường, robot vận chuyển, RF Cable & Adapters. Hotline: 0986 020 896', 'type' => 'textarea'],
            ['group' => 'seo', 'key' => 'seo_keywords', 'value' => 'thiết bị đo lường, robot vận chuyển, RF cable, Viam Semicon', 'type' => 'text'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
