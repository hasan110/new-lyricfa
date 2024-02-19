<?php

namespace App\Exceptions\Throwable;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class GeneralException
 */
class ValidationException extends BaseException
{
    /**
     * The errors list.
     *
     * @var mixed
     */
    public mixed $errors;

    /**
     * Create a new exception instance.
     *
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct($message, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Set errors to send with the response.
     *
     * @param array|object $errors
     *
     * @return $this
     */
    public function withErrors(array|object $errors): static
    {
        $this->errors = $errors;
        return $this;
    }
}

