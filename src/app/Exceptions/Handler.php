<?php

namespace App\Exceptions;

use App\Helpers\ApiResponse;
use BadMethodCallException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
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


        // Catch QueryException separately
        $this->renderable(function (QueryException $e, $request) {
            $api_res = new ApiResponse;
            return $api_res->error("unable to connect into database", 'ERR_INTERNAL_ERROR', 500);
        });

        

        $this->renderable(function (BadMethodCallException $e, $request) {
            $api_res = new ApiResponse;
            return $api_res->error("bad method call", 'ERR_INTERNAL_ERROR', 500);
        });
        

        $this->renderable(function (HttpException $e, $request) {
            $statusCode = $e->getStatusCode();
            // $message = $e->getMessage() ?: 'Server Error';
            $api_res = new ApiResponse;
            

            switch ($statusCode) {
                case 400:
                    return $api_res->error("invalid value of `type`", 'ERR_BAD_REQUEST', $statusCode);
                    break;
                case 401:
                    return $api_res->error("invalid access token", 'ERR_INVALID_ACCESS_TOKEN', $statusCode);
                    break;
                case 403:
                    return $api_res->error("user doesn't have enough authorization", 'ERR_FORBIDDEN_ACCESS', $statusCode);
                    break;    
                case 404:
                    return $api_res->error("resource is not found", 'ERR_NOT_FOUND', $statusCode);
                    break;
                case 500:
                    return $api_res->error("unable to connect into database", 'ERR_INTERNAL_ERROR', $statusCode);
                    break;
                default:
                    return $api_res->error("server_error", 'ERR_INTERNAL_ERROR', $statusCode);
                    break;
                
            }

            
        });
        
    }
}
