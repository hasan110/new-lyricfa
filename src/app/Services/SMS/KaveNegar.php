<?php

namespace App\Services\SMS;

use App\Exceptions\Throwable\SendSmsException;
use App\Services\ServiceInterface;
use App\Exceptions\Throwable\BaseException;
use Exception;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class KaveNegar implements ServiceInterface
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
     * @throws Exception
     */
    public function call(string $method, string $url , array $data = [] , array $headers = []) : Response|PromiseInterface
    {
        $url = $this->base_url . $url;
        $method = strtoupper($method);

        $request = Http::withHeaders($headers);

        if ($method === 'POST') {
            $request = $request->asForm();
        }

        $response = $request->send($method, $url, $data);

        if (!$response->successful()) {
            throw new BaseException(__('errors.error_in_send_sms'));
        }

        return $response;
    }
}
