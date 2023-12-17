<?php

namespace App\Services\Notification;

use Exception;

interface NotificationInterface
{
    /**
     * send notification
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public function send(array $data): bool;

    /**
     * prepare service for call rest api
     * @param string $method
     * @param string $url
     * @param array $data
     * @param array $headers
     * @return mixed
     * @throws Exception
     */
    public function callService(string $method , string $url , array $data , array $headers ): mixed;
}
