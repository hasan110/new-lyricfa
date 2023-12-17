<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class BaseService
{
    private string $base_url;
    private string $url;
    private string $method;
    private array $headers = [];
    private array $data = [];
    private array $supported_http_methods = [
        'get' , 'post'
    ];

    protected function setBaseUrl(string $url): void
    {
        $this->base_url = $url;
    }

    protected function setUrl(string $url): BaseService
    {
        $this->url = $url;
        return $this;
    }

    protected function setMethod(string $method): BaseService
    {
        if (!in_array(strtolower($method) , $this->supported_http_methods))
        {
            $method = 'post';
        }

        $this->method = $method;
        return $this;
    }

    protected function setHeaders(array $headers): BaseService
    {
        $this->headers = $headers;
        return $this;
    }

    protected function setData(array $data): BaseService
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @throws Exception
     */
    protected function call(string $method): Response|PromiseInterface
    {
        $this->setMethod($method);
        $url = $this->base_url . $this->url;
        return Http::withHeaders($this->headers)->send(strtoupper($this->method) , $url , $this->data);
    }

    /**
     * @throws Exception
     */
    public function callService(string $method , string $url , array $data = [] , array $headers = []) : Response|PromiseInterface
    {
        return $this->setUrl($url)->setData($data)->setHeaders($headers)->call($method);
    }
}
