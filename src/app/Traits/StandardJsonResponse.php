<?php

namespace App\Traits;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;

trait StandardJsonResponse
{
    public function success(array|string|object|null $data, string $message, int $status_code = Response::HTTP_OK, array|null $paginate = null, int|null $code = null): JsonResponse
    {
        return $this->json(
            data: $data,
            message: $message,
            errors: null,
            status_code: $status_code,
            paginate : $paginate,
            code: $code
        );
    }

    public function error(string $message, array|object|null $errors, int $status_code = Response::HTTP_BAD_REQUEST, int|null $code = null): JsonResponse
    {
        return $this->json(
            data: null,
            message: $message,
            errors: $errors,
            status_code: $status_code,
            paginate : null,
            code: $code
        );
    }

    private function json(array|string|object|null $data, string $message, array|object|null $errors, int $status_code, array|null $paginate, int|null $code): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'errors' => $errors,
            'paginate' => $paginate,
            'code' => $code
        ], $status_code);
    }
}
