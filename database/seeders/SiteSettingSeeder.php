<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use App\Support\SiteSettings;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        if (SiteSetting::query()->exists()) {
            return;
        }

        $defaults = SiteSettings::get();

        SiteSetting::query()->create([
            'about' => $defaults['about'] ?? [],
            'contact' => $defaults['contact'] ?? [],
            'footer' => $defaults['footer'] ?? [],
        ]);

        SiteSettings::clearCache();
    }
}

