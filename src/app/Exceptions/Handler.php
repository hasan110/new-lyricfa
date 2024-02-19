<?php

namespace App\Exceptions;

use App\Exceptions\Throwable\BaseException;
use App\Exceptions\Throwable\ValidationException as CustumValidationException;
use Illuminate\Validation\ValidationException;
use App\Traits\StandardJsonResponse;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use Symfony\Component\HttpFoundation\Response as ResponseCode;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use StandardJsonResponse;

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * @param BaseException|Throwable $e
     *
     * @throws Throwable
     */
    public function report(BaseException|Throwable $e)
    {
        if (isset($e->reportException) and $e->reportException === true) {
            parent::report($e);
        }
    }

    /**
     * @param Request $request
     * @param Throwable $e
     * @return Response|JsonResponse
     * @throws Throwable
     */
    public function render($request, Throwable $e): Response|JsonResponse
    {
        if ($request->wantsJson() || $request->ajax()) {
            return $this->jsonResponse($e);
        }

        return $this->webPageResponse($e);
    }

    /**
     * @param Throwable $e
     * @return JsonResponse
     */
    public function jsonResponse(Throwable $e): JsonResponse
    {
        switch ($e) {
            case $e instanceof AuthenticationException:
                return $this->error(__('errors.http_unauthorized') , null , ResponseCode::HTTP_UNAUTHORIZED);
            case $e instanceof CustumValidationException:
                return $this->error(__('errors.validation_error') , $e->errors , ResponseCode::HTTP_UNPROCESSABLE_ENTITY);
            case $e instanceof ValidationException:
                return $this->error(__('errors.validation_error') , $e->errors() , ResponseCode::HTTP_UNPROCESSABLE_ENTITY);
            case $e instanceof NotFoundHttpException:
                return $this->error(__('errors.http_page_not_found') , null , ResponseCode::HTTP_NOT_FOUND);
            case $e instanceof MethodNotAllowedHttpException:
                return $this->error(__('errors.http_method_not_allowed') , null , ResponseCode::HTTP_METHOD_NOT_ALLOWED);
            case $e instanceof Exception:
                return $this->error($e->getMessage() ,
                    config('app.debug') ? [
                        'file' => $e->getFile().' : '.$e->getLine(),
                        'trace' => $e->getTrace()
                    ] : ['***'] ,
                    ResponseCode::HTTP_INTERNAL_SERVER_ERROR);
            default:
                return $this->error($e->getMessage() , [] , ResponseCode::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * returns web page response
     * @param Throwable $e
     * @return Response
     */
    public function webPageResponse(Throwable $e): Response
    {
        return response()->view('errors.custom' , [
            'message' => $e->getMessage() ?? __('errors.an_error_occurred'),
            'code' => $this->getValidCode($e->getCode())
        ] , $this->getValidCode($e->getCode()));
    }

    /**
     * checks exception code to be a valid http response status code
     * @param int $code
     * @return int
     */
    private function getValidCode(int $code): int
    {
        $statusCodesText = HttpFoundationResponse::$statusTexts;
        $statusCodes = array_keys($statusCodesText) ?? [];
        return in_array($code, $statusCodes) ? $code : ResponseCode::HTTP_INTERNAL_SERVER_ERROR;
    }
}
