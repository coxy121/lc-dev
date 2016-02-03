<?php
namespace App\Exceptions;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Exceptions\UnauthorizedException;
use App\Exceptions\NoActiveAccountException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
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
     * @param  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        switch($e){
            case ($e instanceof NotFoundHttpException):
                return $this->renderException($e);
                break;
            case ($e instanceof ModelNotFoundException):
                return $this->renderException($e);
                break;
            case ($e instanceof UnauthorizedException):
                return $this->renderException($e);
                break;
            case ($e instanceof NoActiveAccountException):
                return $this->renderException($e);
                break;
            default:
                return parent::render($request, $e);
        }
    }
    protected function renderException($e)
    {
        switch ($e){
            case ($e instanceof NotFoundHttpException):
                return response()->view('errors.404', [], 404);
                break;
            case ($e instanceof ModelNotFoundException):
                return response()->view('errors.404', [], 404);
                break;
            case ($e instanceof UnauthorizedException):
                return response()->view('errors.unauthorized');
                break;
            case ($e instanceof NoActiveAccountException):
                return response()->view('errors.no-active-account');
                break;
            default:
                return (new SymfonyDisplayer(config('app.debug')))
                    ->createResponse($e);
        }
    }
}