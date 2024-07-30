<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
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
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (HttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json(
                    $this->getJsonMessage($e),
                    $e->getStatusCode()
                );
            }
        });
    }

    // /**
    //  * Render an exception into an HTTP response.
    //  * Updated to return json for a request that wantsJson 
    //  * i.e: specifies 
    //  *      Accept: application/json
    //  * in its header
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \Exception  $e
    //  * @return \Illuminate\Http\Response
    //  */
    // public function render($request, Throwable $e)
    // {
    //     if ($request->ajax() || $request->wantsJson()) {
    //         return response()->json(
    //             $this->getJsonMessage($e),
    //             $e->getCode()
    //         );
    //     }
    //     return parent::render($request, $e);
    // }

    protected function getJsonMessage($e)
    {
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}
