<?php

namespace App\Repository\V1\App;

use App\Interface\V1\App\SettingInterface;
use App\Models\Setting;
use Exception;

class SettingRepository implements SettingInterface
{
    /**
     * returns app settings .
     * @throws Exception
     * @return array
     */
    public function getSettings(): array
    {
        $settings = Setting::all();
        $result = [];

        foreach ($settings as $setting) {
            $result[$setting->key] = $setting->value;
        }

        return $result;
    }
}
