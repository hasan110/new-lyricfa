<?php

namespace App\Repository\V1\App;

use App\Interface\V1\App\SettingInterface;
use App\Models\Setting;

class SettingRepository implements SettingInterface
{
    /**
     * returns app settings.
     * @return array
     */
    public function getSettings(): array
    {
        $settings = Setting::query()->where('is_public' , '=' ,1)->get();
        $result = [];

        foreach ($settings as $setting) {
            $result[$setting->key] = $setting->value;
        }

        return $result;
    }
}
