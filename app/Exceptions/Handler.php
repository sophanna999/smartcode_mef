<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Foundation\Validation\ValidationException;

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
        ValidationException::class,
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
        /* These codes update on 28/02/2017 */
        if($e instanceof \Illuminate\Session\TokenMismatchException) {
            //It kills the session and takes you where you wil login easily
            $mismatch = $request->mismatch;
            if ($mismatch == 'true'){
                //Backend Login
                return redirect('/auth');
            }else{
                //Frontend Login
                return redirect('/login');
            }
        }
        /* End of code update */

        if ($e instanceof ModelNotFoundException) {

            if ($request->ajax() || $request->wantsJson())
            {
                return response()->json(['message' => 'Data not found'],400);
            }
            $e = new NotFoundHttpException($e->getMessage(), $e);
        }

        return parent::render($request, $e);
    }
}
