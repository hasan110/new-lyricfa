<?php

namespace App\Exceptions\Throwable;

use Exception;
use Throwable;

class BaseException extends Exception
{
    /**
     * @var bool
     */
    public bool $reportException = true;

    /**
     * BaseException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param bool $reportException
     */
    public function __construct(string $message = '', int $code = 0, Throwable $previous = null, bool $reportException = true)
    {
        $this->reportException = $reportException;
        parent::__construct($message, $code, $previous);
    }
}
