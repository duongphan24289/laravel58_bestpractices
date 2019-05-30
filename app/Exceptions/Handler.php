<?php

namespace App\Exceptions;

use Exception;
use Flugg\Responder\Http\MakesResponses;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    use MakesResponses;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception $exception
     * @return void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if($request->wantsJson())
        {
            return $this->handleApiException($request, $exception);
        }

        return parent::render($request, $exception);
    }

    private function handleApiException($request, Exception $exception)
    {
        $exception = $this->prepareException($exception);
        if($exception instanceof HttpResponseException)
        {
            $exception = $exception->getResponse();
        }

        if($exception instanceof AuthenticationException)
        {
            $exception = $this->unauthenticated($request, $exception);
        }

        if($exception instanceof ValidationException)
        {
            $exception = $this->convertValidationExceptionToResponse($exception, $request);
        }

        return $this->customApiResponse($exception);
    }

    private function customApiResponse($exception)
    {
        if(method_exists($exception, 'getStatusCode'))
        {
            $statusCode = $exception->getStatusCode();
        }
        else
        {
            $statusCode = 500;
        }

        $response = [];

        switch ($statusCode)
        {
            case 401:
                $response['message'] = "Unauthorized";
                break;

            case 403:
                $response['message'] = "Forbidden";
                break;

            case 404:
                $response['message'] = "Not Found";
                break;

            case 405:
                $response['message'] = "Method Not Allowed";
                break;

            case 422:
                $response['message'] = $exception->original['message'];
                $response['errors'] = $exception->original['errors'];
                break;

            default:
                $response['message'] = $statusCode === 500 ? "Whoops, looks like something went wrong" : $exception->getMessage();
                break;
        }

        if(config('app.debug'))
        {
            $response['trace'] = method_exists($exception, 'getTrace') ? $exception->getTrace() : null;
            $response['code'] = method_exists($exception, 'getCode') ? $exception->getCode() : null;
        }
        $response['status'] = $statusCode;

        return response()->json($response, $statusCode);
    }
}
