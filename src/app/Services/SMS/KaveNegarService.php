<?php

namespace App\Services\SMS;

use App\Exceptions\Throwable\SendSmsException;
use App\Services\ServiceInterface;
use App\Exceptions\Throwable\BaseException;
use Exception;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class KaveNegarService implements ServiceInterface
{
    public string $base_url;

    public function __construct()
    {
        $this->base_url = config('lyricfa.kavenegar.base_url');
    }

    /**
     * send notification
     * @param string $receiver
     * @param int $activate_code
     * @return bool
     * @throws SendSmsException
     */
    public function sendOtpCode(string $receiver, int $activate_code): bool
    {
        try {
            if (config('app.env') === 'development')
                return true;

            $url = config('lyricfa.kavenegar.api_key') . config('lyricfa.kavenegar.lookup_url');
            $this->call('POST', $url, [
                'receptor' => $receiver,
                'token' => $activate_code,
                'template' => 'verify'
            ]);
            return true;
        } catch (BaseException|Exception $e) {
            throw new SendSmsException($e->getMessage());
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
        $method = strtoupper($method);

        $request = Http::withHeaders($headers);

        if ($method === 'POST') {
            $request = $request->asForm();
        }

        switch ($method) {
            case 'POST':
                $response = $request->post($url, $data);
            break;
            case 'GET':
            default:
                $response = $request->get($url, $data);
            break;
        }

        if (!$response->successful()) {
            throw new BaseException(__('errors.error_in_send_sms'));
        }

        return $response;
    }
}
