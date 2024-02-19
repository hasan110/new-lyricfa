<?php

namespace App\Exceptions\Throwable;

use Exception;
use Throwable;

class BaseException extends Exception
{
    /**
     * @var bool
     */
    public bool $reportException = false;

    /**
     * BaseException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param bool $reportException
     */
    public function __construct(string $message = '', int $code = 0, bool $reportException = false, Throwable $previous = null)
    {
        $this->reportException = $reportException;
        parent::__construct($message, $code, $previous);
    }
}
