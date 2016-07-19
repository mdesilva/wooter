<?php

namespace Wooter\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Wooter\Http\Controllers\PrimaryController;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        }

        if ($e instanceof NotFoundHttpException) {
            // if get param _f are defined and if request response are a not found exception will show 404 error
            if(!$request->get('_f')){
                return $this->appView($request);
            }
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            if($request->method()){
                return $this->appView($request);
            }
        }

        return parent::render($request, $e);
    }

    private function appView($request) {
        $data = [
            'es6_support' => ($request->cookie('es6') !== "false" || is_null($request->cookie('es6')))
        ];

        return response(view('app', $data));
    }
}
