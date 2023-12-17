<?php

namespace App\Services\Notification;

use Carbon\Carbon;
use Exception;
use App\Services\BaseService;

class GoogleNotification extends BaseService implements NotificationInterface
{

    public function __construct()
    {
        $this->setBaseUrl(config('lyric.google_api.base_url'));
    }
    /**
     * send notification
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public function send(array $data): bool
    {
        if(!isset($data['token']))
        {
            return false;
        }

        try {
            $headers = [
                'Authorization:key=' . config('lyric.google_api.api_key'),
                'Content-Type: application/json'
            ];
            $data = [
                'notification' => [
                    'title' => $data['title'],
                    'body' => $data['body'],
                    'image' => isset($data['image']) ?? null
                ],
                'data' => [
                    'to' => 'VIP',
                    'date' => Carbon::now()->format('Y-m-d H:i:s'),
                    'other_data' => 'not important',
                    "sound" => "default"
                ],
                'time_to_live' => 3600,
                'to' => $data['token']
            ];

            $response = $this->callService('POST' , config('lyric.google_api.send_notification_url') , $data , $headers);
            if (!$response->successful())
            {
                $status = $response->status();
                $data = $response->json();
                $message = isset($data['message']) ?? __('messages.google_notification_error').' ('.$status.')';
                throw new Exception($message);
            }

            return true;

        }catch (Exception $e){
            throw new Exception($e->getMessage());
        }
    }
}
