<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;

interface ServiceInterface
{
    /**
     * call api
     * @param string $method
     * @param string $url
     * @param array $data
     * @param array $headers
     * @return Response|PromiseInterface
     * @throws Exception
     */
    public function call(string $method, string $url, array $data = [], array $headers = []): Response|PromiseInterface;
}
