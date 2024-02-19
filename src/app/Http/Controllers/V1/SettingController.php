<?php

namespace App\Http\Controllers\V1;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

use App\Interface\V1\App\SettingInterface;
use App\Repository\V1\App\SettingRepository;


class SettingController extends Controller
{
    private SettingRepository $settingRepository;

    public function __construct(SettingInterface $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    /**
     * returns app settings
     * @return JsonResponse
     */
    public function getSettings(): JsonResponse
    {
        try {
            $data = $this->settingRepository->getSettings();
        }catch (Exception $e){
            return $this->error($e->getMessage(), []);
        }

        return $this->success($data, __('messages.success_result'));
    }

}
