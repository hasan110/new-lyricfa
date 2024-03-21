<?php

namespace App\Services\Notification;

use App\Services\ServiceInterface;
use Carbon\Carbon;
use App\Exceptions\Throwable\BaseException;
use Exception;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class GoogleNotification implements ServiceInterface
{
    public string $base_url;

    public function __construct()
    {
        $this->base_url = config('lyricfa.google_notification.base_url');
    }

    /**
     * send notification
     * @param array $data
     * @return bool
     */
    public function send(array $data): bool
    {
        if(!isset($data['token']))
        {
            return false;
        }

        try {
            $headers = [
                'Authorization:key=' . config('lyricfa.google_notification.api_key'),
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

            $this->call('POST', config('lyricfa.google_notification.send_notification_url'), $data, $headers);

            return true;

        }catch (BaseException|Exception $e){
            // throw new GoogleNotificationException($e->getMessage());
            return false;
        }
    }

    /**
     * call api
     * @param string $method
     * @param string $url
     * @param array $data
     * @param array $headers
     * @return Response|PromiseInterface
     * @throws Exception
     */
    public function call(string $method, string $url, array $data = [], array $headers = []) : Response|PromiseInterface
    {
        $url = $this->base_url . $url;
        $request = Http::withHeaders($headers);
        $method = strtoupper($method);

        switch ($method) {
            case 'post':
                $response = $request->asForm()->post($url, $data);
            break;
            case 'get':
            default:
                $response = $request->get($url, $data);
            break;
        }

        if (!$response->successful())
        {
            // $status = $response->status();
            // $data = $response->json();
            // $message = isset($data['message']) ?? __('errors.google_notification_error').' ('.$status.')';
            throw new BaseException(__('errors.google_notification_error'));
        }

        return $response;

    }
}
