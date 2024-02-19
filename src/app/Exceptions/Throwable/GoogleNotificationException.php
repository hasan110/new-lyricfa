<?php

namespace App\Exceptions\Throwable;

class GoogleNotificationException extends BaseException
{
    /**
     * BaseException constructor.
     *
     * @param string $message
     * @param int $code
     */
    public function __construct(string $message = '', int $code = 0)
    {
        parent::__construct($message, $code, true);
    }
}
